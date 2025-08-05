


/*
* CAMPOS FORMULARIO
*/

var FormularioCampos = ["CmpFecha",
"CmpClienteNombre",
"CmpFichaIngresoLlamadaFecha",
"CmpFichaIngresoLlamadaObservacion"];

/******************************************************************************/
	
/*
*** EVENTOS
*/	

$().ready(function() {
/*
* EVENTOS - NAVEGACION
*/		
//	$("input,select,textarea").keypress(function (event) {  
//		 if (event.keyCode == '13' && this.type !== "hidden") {
//			FncAlmacenMovimientoNavegar(this.id);
//		 }
//	}); 
//	
//	$("input,select,textarea").focus(function () {  
//		if (this.type !== "hidden" & this.type !=="image") {
//		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
//		}
//	}); 
//	
//	$("input,select,textarea").blur(function () {  
//		if (this.type !== "hidden" & this.type !=="image") {
//			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
//		}
//	}); 
	
/*
* EVENTOS - INICIALES
*/	
	//COMUNES VEHICULO





/*
Agregando Eventos
*/

});

/******************************************************************************/

/*
*** FUNCIONES
*/	

function FncFichaIngresoNavegar(oCampo){
	
		for(var i=0; i< FormularioCampos.length; i++) {
			if(FormularioCampos.length !== i + 1){
				
				if(FormularioCampos[i]==oCampo){
					
					if($('#'+FormularioCampos[i+1]).attr('type')=="text"){
						$('#'+FormularioCampos[i]).blur();
						$('#'+FormularioCampos[i+1]).focus();
						$('#'+FormularioCampos[i+1]).select();	
					}else{
						$('#'+FormularioCampos[i]).blur();	
						$('#'+FormularioCampos[i+1]).focus();	
					}
									
				}				
				
			}
				
		}
	
	
	if("CmpFichaIngresoLlamadaObservacion"==oCampo){
		$('#CmpFichaIngresoLlamadaObservacion').blur();
		FncFichaIngresoLlamadaGuardar();		
	}

}


/*
* FUNCIONES -AUXILIARES
*/





/*
* FUNCIONES COMUNES
*/


function FncFichaIngresoBuscar(){
	
}