
// JavaScript Document



function FncGuardar(){
//$('#CmpProformaMes').html('');	
}
/*
*** EVENTOS
*/

$().ready(function() {

/*
* EVENTOS - INICIALES
*/

	$("select#CmpVehiculoMarca").change(function(){
		FncVehiculoModelosCargar();
		$('#CmpVehiculoVersion').html('');	
	});

	$("select#CmpVehiculoModelo").change(function(){
		FncVehiculoVersionesCargar();
	});
	
	

	
		

});

/*
*** FUNCIONES
*/





var FormularioCampos = [
"CmpId",
"CmpFecha",
"CmpCodigo",
"CmpAnoProforma",
"CmpMesProforma",
"CmpMonedaId",
"CmpTipoCambio",
"CmpObservacion",
"CmpEstado",


"CmpVehiculoMarca",
"CmpVehiculoModelo",
"CmpVehiculoVersion",

"CmpVehiculoIngresoColor",

"CmpVehiculoIngresoVIN",
"CmpVehiculoIngresoNumeroMotor",
"CmpVehiculoIngresoAnoFabricacion",
"CmpVehiculoIngresoAnoModelo",





"CmpVehiculoProformaDetalleCosto"

];

$().ready(function() {
	

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncVehiculoProformaNavegar(this.id);
		 }
	});
	
/*
Agregando Eventos
*/


});
	
function FncVehiculoProformaNavegar(oCampo){
	
		for(var i=0; i< FormularioCampos.length; i++) {
			if(FormularioCampos.length !== i + 1){
				
				if(FormularioCampos[i]==oCampo){
					
					if(document.getElementById(FormularioCampos[i+1]).type=="text"){
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

		if("CmpVehiculoProformaDetalleCosto"==oCampo){
		
			FncVehiculoProformaDetalleGuardar();
			
		}
	
}





/*
* FUNCIONES - COMUNES
*/

function FncVehiculoIngresoFuncion(){
	
	
	$('#CmpVehiculoIngresoVIN').attr('readonly', true);
	
//	$('#CmpVehiculoMarca').attr('disabled', true);
//	$('#CmpVehiculoModelo').attr('disabled', true);
//	$('#CmpVehiculoVersion').attr('disabled', true);
//	
//	$('#CmpVehiculoIngresoColor').attr('readonly', true);
//	$('#CmpVehiculoIngresoAnoModelo').attr('readonly', true);
//	$('#CmpVehiculoIngresoAnoFabricacion').attr('readonly', true);
	
	VehiculoModeloHabilitado = 1;	
	VehiculoVersionHabilitado = 1;	
						
	$('#CmpVehiculoProformaDetalleCosto').val(0);
	$('#CmpVehiculoProformaDetalleCosto').select();
	
	FncVehiculoModelosCargar();

	$('#CmpVehiculoVersion').html('');	


	
	
//	$("#CmpVehiculoIngresoColor").keyup(function (event) {  
//		 if (event.keyCode >= 48 && event.keyCode <= 90) {
//	
//			FncVehiculoIngresoCargarFormulario("Editar");
//	
//		 }
//	}); 
//	
//	
//	$("#CmpVehiculoIngresoAnoModelo").keyup(function (event) {  
//		 if (event.keyCode >= 48 && event.keyCode <= 90) {
//	
//			FncVehiculoIngresoCargarFormulario("Editar");
//	
//		 }
//	}); 
//	
//	
//	$("#CmpVehiculoIngresoAnoFabricacion").keyup(function (event) {  
//		 if (event.keyCode >= 48 && event.keyCode <= 90) {
//	
//			FncVehiculoIngresoCargarFormulario("Editar");
//	
//		 }
//	}); 

}



function FncVehiculoIngresoGuardarSimpleFuncion(){
	
	//FncVehiculoIngresoBuscar('VIN');
	
	//FncVehiculoIngresoBuscar('VIN');
	
	
	FncVehiculoProformaDetalleGuardar();
	
}


function FncVehiculoModeloFuncion(){

	FncVehiculoVersionesCargar();
	
}

function FncVehiculoIngresoFormularioFuncion(){
	
	FncVehiculoIngresoBuscar("Id");

}

/*
* FUNCIONES - IMPRESION
*/
