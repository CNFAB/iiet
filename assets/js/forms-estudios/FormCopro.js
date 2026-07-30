import { Concentrado } from './estudios-copro/Concentrado.js';
import { McMaster } from './estudios-copro/McMaster.js';
import { Cualitativo } from './estudios-copro/Cualitativo.js';

export function FormCopro() {
    this.elem = document.getElementById('form_estudios');

    this.cc = new Concentrado(document.getElementById('metodo-cc'));
    this.mm = new McMaster(document.getElementById('metodo-mm'));
    this.kk = new McMaster(document.getElementById('metodo-kk'));
    this.hm = new Cualitativo(document.getElementById('metodo-hm'));
    this.bm = new Cualitativo(document.getElementById('metodo-bm'));
    this.pa = new Cualitativo(document.getElementById('metodo-pa'));

    this.preSubmit = null;
    this.exitoGuardar = null;
    this.errorGuardar = null;

    var self = this;

    this.elem.addEventListener('submit', function(e) {
        e.preventDefault();

        this.classList.add('was-validated');

        if(this.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            if(self.preSubmit) self.preSubmit();

            // ⭐ Enviar todos los datos incluyendo selects deshabilitados
            var datos = $(this).serialize();
            
            // ⭐ Agregar los selects de cantidad que están deshabilitados
            var selects = this.querySelectorAll('select[name^="concentrado_cantidad"]');
            selects.forEach(function(select) {
                if (select.disabled && select.value) {
                    // Si está deshabilitado pero tiene valor, agregarlo manualmente
                    datos += '&' + select.name + '=' + encodeURIComponent(select.value);
                }
            });

            $.ajax(this.action, {
                method: 'POST',
                data: datos,
                success: self.exitoGuardar,
                error: self.errorGuardar
            });
        }
    });
}

FormCopro.prototype.cargarDatosEstudios = function(estudios) {
    var copro = estudios.copro;

    if(!copro) return false;

    this.elem.fecha.value        = copro.fecha;
    this.elem.peso_materia.value = copro.peso_materia;
    this.elem.consistencia.value = copro.consistencia;
    this.elem.nro_muestra.value  = copro.nro_muestra;
    this.elem.seriado.value      = copro.seriado;

    if(copro.concentrado) {
        this.cc.cargarDatos(copro.concentrado);
        this.cc.desplegar();
    }

    // ⭐ Cargar cantidades
    if(copro.concentrado_cantidad) {
        this.cargarCantidades(copro.concentrado_cantidad);
    }

    if(copro.mc_master) {
        this.mm.cargarDatos(copro.mc_master);
        this.mm.desplegar();
    }

    if(copro.kato_katz) {
        this.kk.cargarDatos(copro.kato_katz);
        this.kk.desplegar();
    }

    if(copro.harada_mori) {
        this.hm.cargarDatos(copro.harada_mori);
        this.hm.desplegar();
    }

    if(copro.baerman) {
        this.bm.cargarDatos(copro.baerman);
        this.bm.desplegar();
    }

    if(copro.placa_agar) {
        this.pa.cargarDatos(copro.placa_agar);
        this.pa.desplegar();
    }

    return true;
};

FormCopro.prototype.cargarCantidades = function(cantidadData) {
    var parasitos = ['ascaris','giardia','entamoebacoli','uncinarias','strongyloides','hymenolepis','trichuris','enterobius','taenia','isosporabelli'];
    
    parasitos.forEach(function(nombre) {
        var id = (nombre === 'entamoebacoli') ? 'coli' : nombre;
        var select = document.getElementById('cc-' + id + '-cantidad');
        var container = document.getElementById('cc-' + id + '-cantidad-container');
        var checkbox = document.getElementById('cc-' + id);
        
        if (select && cantidadData[nombre]) {
            select.disabled = false;
            select.value = cantidadData[nombre];
            if (container) container.style.display = 'block';
            if (checkbox) checkbox.checked = true;
        }
    });
};

FormCopro.prototype.reset = function() {
    this.elem.reset();
    Forms.resetForm(this.elem);
    this.cc.plegar();
    this.mm.plegar();
    this.kk.plegar();
    this.hm.plegar();
    this.bm.plegar();
    this.pa.plegar();
};

FormCopro.prototype.accionPreSubmit = function(fc) {
    this.preSubmit = fc;
};

FormCopro.prototype.exito = function(fc) {
    this.exitoGuardar = fc;
};

FormCopro.prototype.error = function(fc) {
    this.errorGuardar = fc;
};