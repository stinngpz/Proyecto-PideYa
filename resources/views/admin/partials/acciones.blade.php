<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;

document.querySelectorAll('[data-accion]').forEach(function (boton) {
    boton.addEventListener('click', async function () {
        if (boton.dataset.confirmar && !confirm(boton.dataset.confirmar)) {
            return;
        }

        const fila = boton.closest('tr');
        const respuesta = await fetch(boton.dataset.url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: boton.dataset.cuerpo || '{}',
        });
        const datos = await respuesta.json().catch(function () { return {}; });

        if (!respuesta.ok) {
            const errores = datos.errors ? Object.values(datos.errors).flat().join(' ') : '';
            alert(datos.message || errores || 'No se pudo completar la acción.');
            return;
        }

        Object.entries(datos.campos).forEach(function ([campo, texto]) {
            fila.querySelectorAll('[data-campo="' + campo + '"]').forEach(function (nodo) {
                nodo.textContent = texto;
            });
        });
        const aviso = document.getElementById('aviso');

        if (aviso && datos.mensaje) {
        aviso.textContent = datos.mensaje;
        aviso.classList.remove('hidden');
        }

        setTimeout(function () {
        location.reload();
        }, 1500);
    });
});
</script>