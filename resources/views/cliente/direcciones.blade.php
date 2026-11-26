@extends('layouts.cliente')

@section('titulo', 'PideYa - Mis direcciones')

@section('contenido')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<div class="mx-auto grid max-w-5xl gap-6 lg:grid-cols-2">

    <form id="form-direccion" class="space-y-4 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Nueva dirección</h1>

        <div id="errores" class="hidden rounded-lg bg-red-50 p-3 text-sm text-red-700"></div>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Nombre (Casa, Trabajo...)</label>
            <input type="text" name="nombre" maxlength="60" required
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
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Calle y número de casa</label>
            <input type="text" name="detalle_calle" maxlength="255" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Referencia</label>
            <input type="text" name="referencia" maxlength="250" required
                   placeholder="Portón negro, frente a la pulpería"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>

        <div>
            <div class="mb-1 flex items-center justify-between">
                <label class="text-sm font-medium dark:text-gray-300">Toca el mapa para marcar tu ubicación</label>
                <button type="button" id="btn-ubicacion" class="text-sm font-semibold text-[#459361]">Usar mi ubicación</button>
            </div>
            <div id="mapa" class="relative z-0 h-72 w-full rounded-lg border border-gray-300"></div>
            <p id="coordenadas" class="mt-1 text-xs text-gray-500">Aún no has marcado un punto.</p>
            <input type="hidden" name="latitud_envio" id="latitud">
            <input type="hidden" name="longitud_envio" id="longitud">
        </div>

        <label class="flex items-center gap-2 text-sm dark:text-gray-300">
            <input type="checkbox" name="es_predeterminada" id="predeterminada"> Usar como dirección predeterminada
        </label>

        <button type="submit" class="w-full rounded-lg bg-[#459361] py-2 font-semibold text-white">Guardar dirección</button>
    </form>

    <div class="h-fit space-y-4 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Mis direcciones</h2>
        <div id="lista" class="space-y-3"></div>
        <p id="vacio" class="hidden text-sm text-gray-500">Todavía no tienes direcciones guardadas.</p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const zonasPorCiudad = @json($ciudades->mapWithKeys(fn ($c) => [$c->id_ciudad => $c->zonas->map(fn ($z) => ['id' => $z->id_zona, 'nombre' => $z->nombre])->values()]));
const csrf = document.querySelector('meta[name="csrf-token"]').content;
const rutas = {
    lista: @json(route('direcciones.lista')),
    guardar: @json(route('direcciones.store')),
    base: @json(url('/direcciones')),
};

const selectCiudad = document.getElementById('ciudad');
const selectZona = document.getElementById('zona');
const formulario = document.getElementById('form-direccion');
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

document.getElementById('btn-ubicacion').addEventListener('click', function () {
    if (!navigator.geolocation) {
        return;
    }
    navigator.geolocation.getCurrentPosition(function (posicion) {
        const lat = posicion.coords.latitude;
        const lng = posicion.coords.longitude;
        colocarMarcador(lat, lng);
        mapa.setView([lat, lng], 16);
    });
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

function crearTarjeta(direccion) {
    const tarjeta = document.createElement('div');
    tarjeta.className = 'rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800';

    const encabezado = document.createElement('div');
    encabezado.className = 'flex items-center justify-between';

    const titulo = document.createElement('p');
    titulo.className = 'font-semibold text-gray-800 dark:text-white';
    titulo.textContent = direccion.nombre;
    encabezado.appendChild(titulo);

    if (direccion.es_predeterminada) {
        const etiqueta = document.createElement('span');
        etiqueta.className = 'rounded-full bg-[#76BB20] px-2 py-0.5 text-xs font-bold text-white';
        etiqueta.textContent = 'Predeterminada';
        encabezado.appendChild(etiqueta);
    }
    tarjeta.appendChild(encabezado);

    const zona = direccion.zona ? direccion.zona.nombre + ', ' + direccion.zona.ciudad.nombre : '';
    [zona, direccion.detalle_calle, 'Ref: ' + direccion.referencia].forEach(function (texto) {
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
        colocarMarcador(direccion.latitud_envio, direccion.longitud_envio);
        mapa.setView([direccion.latitud_envio, direccion.longitud_envio], 16);
        document.getElementById('mapa').scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
    acciones.appendChild(verMapa);

    if (!direccion.es_predeterminada) {
        const hacerPredeterminada = document.createElement('button');
        hacerPredeterminada.type = 'button';
        hacerPredeterminada.className = 'text-gray-600 dark:text-gray-300';
        hacerPredeterminada.textContent = 'Hacer predeterminada';
        hacerPredeterminada.addEventListener('click', async function () {
            await peticion(rutas.base + '/' + direccion.id_direccion + '/predeterminar', 'PATCH');
            cargarLista();
        });
        acciones.appendChild(hacerPredeterminada);
    }

    const eliminar = document.createElement('button');
    eliminar.type = 'button';
    eliminar.className = 'text-red-600';
    eliminar.textContent = 'Eliminar';
    eliminar.addEventListener('click', async function () {
        if (!confirm('¿Eliminar esta dirección?')) {
            return;
        }
        const resultado = await peticion(rutas.base + '/' + direccion.id_direccion, 'DELETE');
        if (!resultado.ok) {
            mostrarErrores([resultado.datos.message || 'No se pudo eliminar la dirección.']);
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
    const direcciones = resultado.datos;
    textoVacio.classList.toggle('hidden', direcciones.length > 0);
    direcciones.forEach(function (direccion) {
        contenedorLista.appendChild(crearTarjeta(direccion));
    });
}

formulario.addEventListener('submit', async function (evento) {
    evento.preventDefault();
    cajaErrores.classList.add('hidden');

    const datos = Object.fromEntries(new FormData(formulario));
    datos.es_predeterminada = document.getElementById('predeterminada').checked;

    const resultado = await peticion(rutas.guardar, 'POST', datos);

    if (resultado.estado === 422) {
        mostrarErrores(Object.values(resultado.datos.errors).flat());
        return;
    }
    if (!resultado.ok) {
        mostrarErrores(['No se pudo guardar la dirección.']);
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