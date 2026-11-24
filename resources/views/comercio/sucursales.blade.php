@extends('layouts.panel')

@section('titulo', 'PideYa - Sucursales')

@section('contenido')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<div class="grid gap-6 lg:grid-cols-2">

    <form id="form-sucursal" class="space-y-4 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Nueva sucursal</h1>

        <div id="errores" class="hidden rounded-lg bg-red-50 p-3 text-sm text-red-700"></div>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Nombre de la sucursal</label>
            <input type="text" name="nombre" maxlength="120" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Ciudad</label>
                <select id="ciudad" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    @foreach ($ciudades as $ciudad)
                        <option value="{{ $ciudad->id_ciudad }}">{{ $ciudad->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Zona</label>
                <select id="zona" name="id_zona" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2"></select>
            </div>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Dirección</label>
            <input type="text" name="direccion" maxlength="255" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Teléfono (8 dígitos)</label>
            <input type="text" name="telefono" maxlength="8" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Toca el mapa para marcar la ubicación</label>
            <div id="mapa" class="relative z-0 h-72 w-full rounded-lg border border-gray-300"></div>
            <p id="coordenadas" class="mt-1 text-xs text-gray-500">Aún no has marcado un punto.</p>
            <input type="hidden" name="latitud" id="latitud">
            <input type="hidden" name="longitud" id="longitud">
        </div>

        <button type="submit" class="w-full rounded-lg bg-[#459361] py-2 font-semibold text-white">Guardar sucursal</button>
    </form>

    <div class="space-y-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Mis sucursales</h2>
        <div id="lista" class="space-y-3"></div>
        <p id="vacio" class="hidden text-sm text-gray-500">Todavía no tienes sucursales registradas.</p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const zonasPorCiudad = @json($ciudades->mapWithKeys(fn ($c) => [$c->id_ciudad => $c->zonas->map(fn ($z) => ['id' => $z->id_zona, 'nombre' => $z->nombre])->values()]));
const csrf = document.querySelector('meta[name="csrf-token"]').content;
const rutas = {
    lista: @json(route('sucursales.lista')),
    guardar: @json(route('sucursales.store')),
    base: @json(url('/comercio/sucursales')),
};

const selectCiudad = document.getElementById('ciudad');
const selectZona = document.getElementById('zona');
const formulario = document.getElementById('form-sucursal');
const cajaErrores = document.getElementById('errores');
const contenedorLista = document.getElementById('lista');
const textoVacio = document.getElementById('vacio');
const campoLat = document.getElementById('latitud');
const campoLng = document.getElementById('longitud');
const textoCoordenadas = document.getElementById('coordenadas');

function cargarZonas() {
    selectZona.replaceChildren();
    (zonasPorCiudad[selectCiudad.value] || []).forEach(function (zona) {
        const opcion = document.createElement('option');
        opcion.value = zona.id;
        opcion.textContent = zona.nombre;
        selectZona.appendChild(opcion);
    });
}

selectCiudad.addEventListener('change', cargarZonas);
cargarZonas();

const mapa = L.map('mapa').setView([14.0723, -87.1921], 12);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap'
}).addTo(mapa);

let marcador = null;

function colocarMarcador(lat, lng) {
    if (marcador) {
        marcador.setLatLng([lat, lng]);
    } else {
        marcador = L.marker([lat, lng]).addTo(mapa);
    }
    campoLat.value = lat.toFixed(7);
    campoLng.value = lng.toFixed(7);
    textoCoordenadas.textContent = 'Latitud ' + lat.toFixed(5) + ', Longitud ' + lng.toFixed(5);
}

mapa.on('click', function (evento) {
    colocarMarcador(evento.latlng.lat, evento.latlng.lng);
});

function mostrarErrores(mensajes) {
    cajaErrores.replaceChildren();
    mensajes.forEach(function (mensaje) {
        const linea = document.createElement('p');
        linea.textContent = mensaje;
        cajaErrores.appendChild(linea);
    });
    cajaErrores.classList.remove('hidden');
}

async function peticion(url, metodo, cuerpo) {
    const respuesta = await fetch(url, {
        method: metodo,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        body: cuerpo ? JSON.stringify(cuerpo) : undefined,
    });
    const datos = await respuesta.json().catch(function () { return {}; });
    return { ok: respuesta.ok, estado: respuesta.status, datos: datos };
}

function crearTarjeta(sucursal) {
    const tarjeta = document.createElement('div');
    tarjeta.className = 'rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800';

    const encabezado = document.createElement('div');
    encabezado.className = 'flex items-center justify-between';

    const titulo = document.createElement('p');
    titulo.className = 'font-semibold text-gray-800 dark:text-white';
    titulo.textContent = sucursal.nombre;
    encabezado.appendChild(titulo);

    const etiqueta = document.createElement('span');
    etiqueta.className = sucursal.esta_activa
        ? 'rounded-full bg-[#76BB20] px-2 py-0.5 text-xs font-bold text-white'
        : 'rounded-full bg-gray-400 px-2 py-0.5 text-xs font-bold text-white';
    etiqueta.textContent = sucursal.esta_activa ? 'Activa' : 'Inactiva';
    encabezado.appendChild(etiqueta);
    tarjeta.appendChild(encabezado);

    const zona = sucursal.zona ? sucursal.zona.nombre + ', ' + sucursal.zona.ciudad.nombre : '';
    [zona, sucursal.direccion, 'Tel: ' + sucursal.telefono].forEach(function (texto) {
        const linea = document.createElement('p');
        linea.className = 'text-sm text-gray-600 dark:text-gray-300';
        linea.textContent = texto;
        tarjeta.appendChild(linea);
    });

    const acciones = document.createElement('div');
    acciones.className = 'mt-3 flex gap-4 text-sm font-semibold';

    const verMapa = document.createElement('button');
    verMapa.type = 'button';
    verMapa.className = 'text-[#459361]';
    verMapa.textContent = 'Ver en mapa';
    verMapa.addEventListener('click', function () {
        colocarMarcador(sucursal.latitud, sucursal.longitud);
        mapa.setView([sucursal.latitud, sucursal.longitud], 16);
        document.getElementById('mapa').scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
    acciones.appendChild(verMapa);

    const alternar = document.createElement('button');
    alternar.type = 'button';
    alternar.className = 'text-gray-600 dark:text-gray-300';
    alternar.textContent = sucursal.esta_activa ? 'Desactivar' : 'Activar';
    alternar.addEventListener('click', async function () {
        await peticion(rutas.base + '/' + sucursal.id_sucursal + '/estado', 'PATCH');
        cargarLista();
    });
    acciones.appendChild(alternar);

    const eliminar = document.createElement('button');
    eliminar.type = 'button';
    eliminar.className = 'text-red-600';
    eliminar.textContent = 'Eliminar';
    eliminar.addEventListener('click', async function () {
        if (!confirm('¿Eliminar esta sucursal?')) {
            return;
        }
        const resultado = await peticion(rutas.base + '/' + sucursal.id_sucursal, 'DELETE');
        if (!resultado.ok) {
            mostrarErrores([resultado.datos.message || 'No se pudo eliminar la sucursal.']);
            return;
        }
        cargarLista();
    });
    acciones.appendChild(eliminar);

    tarjeta.appendChild(acciones);
    return tarjeta;
}

async function cargarLista() {
    const resultado = await peticion(rutas.lista, 'GET');
    contenedorLista.replaceChildren();
    const sucursales = resultado.datos;
    textoVacio.classList.toggle('hidden', sucursales.length > 0);
    sucursales.forEach(function (sucursal) {
        contenedorLista.appendChild(crearTarjeta(sucursal));
    });
}

formulario.addEventListener('submit', async function (evento) {
    evento.preventDefault();
    cajaErrores.classList.add('hidden');

    const datos = Object.fromEntries(new FormData(formulario));
    const resultado = await peticion(rutas.guardar, 'POST', datos);

    if (resultado.estado === 422) {
        mostrarErrores(Object.values(resultado.datos.errors).flat());
        return;
    }
    if (!resultado.ok) {
        mostrarErrores(['No se pudo guardar la sucursal.']);
        return;
    }

    formulario.reset();
    cargarZonas();
    if (marcador) {
        mapa.removeLayer(marcador);
        marcador = null;
    }
    textoCoordenadas.textContent = 'Aún no has marcado un punto.';
    cargarLista();
});

cargarLista();
</script>
@endpush