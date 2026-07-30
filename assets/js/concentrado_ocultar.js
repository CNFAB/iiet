/**
 * Módulo para manejar la cantidad (ESCASO/FRECUENTE/ABUNDANTE) del Concentrado
 * Se activa cuando se marca un parásito como POSITIVO
 */

// Lista de parásitos del concentrado
const PARASITOS_CONCENTRADO = [
    'ascaris', 'giardia', 'coli', 'uncinarias', 
    'strongyloides', 'hymenolepis', 'trichuris', 
    'enterobius', 'taenia', 'isosporabelli'
];

/**
 * Configurar los eventos de los selects de cantidad
 */
function configurarConcentradoCantidad() {
    PARASITOS_CONCENTRADO.forEach(function(parasito) {
        var checkbox = document.getElementById('cc-' + parasito);
        var select = document.getElementById('cc-' + parasito + '-cantidad');
        
        if (checkbox && select) {
            // Evento: cuando se marca/desmarca el checkbox
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // POSITIVO → habilitar select
                    select.disabled = false;
                    select.classList.remove('is-invalid');
                    // Enfocar para facilitar selección
                    setTimeout(function() {
                        select.focus();
                    }, 100);
                } else {
                    // NEGATIVO → deshabilitar y limpiar select
                    select.disabled = true;
                    select.value = '';
                    select.classList.remove('is-invalid');
                }
            });
            
            // Evento: limpiar si se desmarca por click
            checkbox.addEventListener('click', function() {
                if (!this.checked) {
                    select.disabled = true;
                    select.value = '';
                }
            });
        }
    });
}

/**
 * Inicializar el concentrado cuando esté disponible en el DOM
 */
function initConcentradoCantidad() {
    var concentradoFieldset = document.querySelector('#result-cc fieldset');
    
    if (concentradoFieldset) {
        configurarConcentradoCantidad();
        console.log(' Concentrado cantidad inicializado');
    } else {
        // Si el acordeón aún no está cargado, esperar
        var observer = new MutationObserver(function(mutations) {
            var fieldset = document.querySelector('#result-cc fieldset');
            if (fieldset) {
                configurarConcentradoCantidad();
                observer.disconnect();
                console.log(' Concentrado cantidad inicializado (carga dinámica)');
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initConcentradoCantidad();
});

