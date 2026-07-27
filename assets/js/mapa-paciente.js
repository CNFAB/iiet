const COORD_DEFAULT = { lat: -25.2637, lng: -57.5759 };

let mapa, marcador, debounceTimer;
let mapaInicializado = false;

function initMapa() {
    if (mapaInicializado) return;

    mapa = L.map('mapa-paciente').setView([COORD_DEFAULT.lat, COORD_DEFAULT.lng], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(mapa);

    marcador = L.marker([COORD_DEFAULT.lat, COORD_DEFAULT.lng], { draggable: true }).addTo(mapa);

    marcador.on('dragend', (e) => {
        const { lat, lng } = e.target.getLatLng();
        guardarCoordenadas(lat, lng);
    });

    mapa.on('click', (e) => {
        marcador.setLatLng(e.latlng);
        guardarCoordenadas(e.latlng.lat, e.latlng.lng);
    });

    mapaInicializado = true;
}

function guardarCoordenadas(lat, lng) {
    document.getElementById('fn-lat').value = lat.toFixed(6);
    document.getElementById('fn-lng').value = lng.toFixed(6);
}

function moverMapa(lat, lng, zoom = 16) {
    if (!mapa) return;
    mapa.setView([lat, lng], zoom);
    marcador.setLatLng([lat, lng]);
    guardarCoordenadas(lat, lng);
}

function resetMapa() {
    if (!mapa) return;
    mapa.setView([COORD_DEFAULT.lat, COORD_DEFAULT.lng], 12);
    marcador.setLatLng([COORD_DEFAULT.lat, COORD_DEFAULT.lng]);
    document.getElementById('fn-lat').value = '';
    document.getElementById('fn-lng').value = '';
}

async function geocodificar() {
    const dpto = document.getElementById('fn-dpto');
    const localidad = document.getElementById('fn-localidad');
    const direccion = document.getElementById('fn-direc').value.trim();

    const dptoTexto = dpto?.selectedOptions[0]?.text || '';
    const localidadTexto = localidad?.selectedOptions[0]?.text || '';

    if (!localidadTexto) return;

    const partes = [direccion, localidadTexto, dptoTexto, 'Argentina'].filter(Boolean);
    const query = partes.join(', ');

    try {
        const resp = await fetch(
            `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(query)}`
        );
        const data = await resp.json();

        if (data && data.length > 0) {
            const { lat, lon } = data[0];
            moverMapa(parseFloat(lat), parseFloat(lon));
        }
    } catch (err) {
        console.error('Error al geocodificar:', err);
    }
}

function geocodificarConDelay() {
    const localidad = document.getElementById('fn-localidad')?.value;
    if (!localidad) return;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(geocodificar, 800);
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('form-paciente');
    const inputLat = document.getElementById('fn-lat');
    const inputLng = document.getElementById('fn-lng');

    initMapa();

    modal.addEventListener('shown.bs.modal', () => {
        mapa.invalidateSize();

        const modo = document.querySelector('#f-nuevo-pac')?.dataset.modo;

        if (modo === 'nuevo') {
            resetMapa();
        } else {
            const lat = parseFloat(inputLat.value);
            const lng = parseFloat(inputLng.value);

            if (!isNaN(lat) && !isNaN(lng)) {
                moverMapa(lat, lng);
            } else {
                resetMapa();
            }
        }
    });

    document.getElementById('fn-dpto')?.addEventListener('change', geocodificarConDelay);
    document.getElementById('fn-localidad')?.addEventListener('change', geocodificarConDelay);
    document.getElementById('fn-direc')?.addEventListener('input', geocodificarConDelay);
});

// Hacer funciones globales para usarlas desde otros scripts
window.initMapa = initMapa;
window.moverMapa = moverMapa;
window.resetMapa = resetMapa;