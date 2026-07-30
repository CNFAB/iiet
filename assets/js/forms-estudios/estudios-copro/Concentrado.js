import { EstudioBase } from '../EstudioBase.js';

export function Concentrado(html) {
    EstudioBase.call(this, html);

    this.campos = this.cuerpo.querySelectorAll('input[type=checkbox]');
    
    // ⭐ Lista de nombres de parásitos para manejar cantidades
    this.nombresParasitos = [
        'ascaris', 'giardia', 'entamoebacoli', 'uncinarias',
        'strongyloides', 'hymenolepis', 'trichuris',
        'enterobius', 'taenia', 'isosporabelli'
    ];
}

EstudioBase.heredar(Concentrado);

Concentrado.prototype.deshabilitar = function() {
    EstudioBase.prototype.deshabilitar.call(this);

    // Desmarcar checkboxes
    for(var i = 0; i < this.campos.length; ++i) {
        this.campos[i].checked = false;
    }
    
    // ⭐ Limpiar selects de cantidad
    this.nombresParasitos.forEach(function(nombre) {
        var select = document.getElementById('cc-' + nombre + '-cantidad');
        if (select) {
            select.disabled = true;
            select.value = '';
        }
        var container = document.getElementById('cc-' + nombre + '-cantidad-container');
        if (container) {
            container.style.display = 'none';
        }
    });
};

Concentrado.prototype.cargarDatos = function(concentrado) {
	  console.log('📊 DATOS RECIBIDOS EN CONCENTRADO:', concentrado);
    console.log('📊 CONCENTRADO_CANTIDAD:', concentrado.concentrado_cantidad);
    // ⭐ Cargar checkboxes (POSITIVO/NEGATIVO)
    this.campos[0].checked = concentrado.ascaris == 'POSITIVO' ? true : false;
    this.campos[1].checked = concentrado.giardia == 'POSITIVO' ? true : false;
    this.campos[2].checked = concentrado.entamoebacoli == 'POSITIVO' ? true : false;
    this.campos[3].checked = concentrado.uncinarias == 'POSITIVO' ? true : false;
    this.campos[4].checked = concentrado.strongyloides == 'POSITIVO' ? true : false;
    this.campos[5].checked = concentrado.hymenolepis == 'POSITIVO' ? true : false;
    this.campos[6].checked = concentrado.trichuris == 'POSITIVO' ? true : false;
    this.campos[7].checked = concentrado.enterobius == 'POSITIVO' ? true : false;
    this.campos[8].checked = concentrado.taenia == 'POSITIVO' ? true : false;
    this.campos[9].checked = concentrado.isosporabelli == 'POSITIVO' ? true : false;
    
    // ⭐⭐⭐ NUEVO: Cargar cantidades (ESCASO/FRECUENTE/ABUNDANTE)
    // Buscar los datos de cantidad en concentrado_cantidad
    var cantidadData = concentrado.concentrado_cantidad || {};
    
    this.nombresParasitos.forEach(function(nombre, index) {
        var select = document.getElementById('cc-' + nombre + '-cantidad');
        var container = document.getElementById('cc-' + nombre + '-cantidad-container');
        var checkbox = document.getElementById('cc-' + nombre);
        
        if (select) {
            // Buscar la cantidad en los datos
            // El nombre del campo puede ser nombre + '_cantidad'
            var cantidad = concentrado[nombre + '_cantidad'] || null;
            
            // Si no está en el objeto principal, buscar en cantidadData
            if (!cantidad && cantidadData) {
                cantidad = cantidadData[nombre] || null;
            }
            
            if (cantidad) {
                // Hay cantidad → habilitar select y mostrar
                select.disabled = false;
                select.value = cantidad;
                
                if (container) {
                    container.style.display = 'block';
                    container.style.opacity = '1';
                }
                
                // Asegurar que el checkbox esté marcado
                if (checkbox) {
                    checkbox.checked = true;
                }
            } else {
                // No hay cantidad → deshabilitar select
                select.disabled = true;
                select.value = '';
                
                if (container) {
                    container.style.display = 'none';
                }
            }
        }
    });
};

// ⭐ NUEVO: Método para obtener datos incluyendo cantidades
Concentrado.prototype.obtenerDatos = function() {
    var datos = {};
    
    // Obtener POSITIVO/NEGATIVO
    this.nombresParasitos.forEach(function(nombre, index) {
        var checkbox = document.getElementById('cc-' + nombre);
        var select = document.getElementById('cc-' + nombre + '-cantidad');
        
        datos[nombre] = checkbox && checkbox.checked ? 'POSITIVO' : 'NEGATIVO';
        
        // Obtener cantidad si existe
        if (select && !select.disabled && select.value) {
            datos[nombre + '_cantidad'] = select.value;
        } else {
            datos[nombre + '_cantidad'] = null;
        }
    });
    
    return datos;
};