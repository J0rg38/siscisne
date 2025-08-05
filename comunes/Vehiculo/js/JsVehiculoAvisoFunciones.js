// JavaScript Document


$().ready(function() {	

});	
	
function FncVehiculoAvisoNuevo(){
	
//	$('#CmpOrdenVentaVehiculoId').val("");
//	$('#CmpVehiculoAvisoFechaVenta').val("");
//	$('#CapVehiculoAvisoHoja').html("");
	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
}

function FncVehiculoAvisoNuevoFuncion(){
	
}

function FncVehiculoAvisoVerificar(){

	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
	var Fecha = $('#CmpFecha').val();
	
	if(VehiculoIngresoId==""){
		
	}else{
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Vehiculo/acc/AccVehiculoAvisoVerificar.php',
		data: 'VehiculoIngresoId='+VehiculoIngresoId,
		success: function(InsAviso){
				if(InsAviso.AviId!=null){					
					
					FncVehiculoAvisoEscoger(InsAviso.AvvId,InsAviso.AviFecha,InsAviso.AviObservacion);

				}
			}
		});	
	}


}


function FncVehiculoAvisoEscoger(oAvisoId,oAvisoFecha,oAvisoObservacion){

	dhtmlx.alert({
		title:"¡Aviso Importante!",
		type:"alert-error",
		text:"Mensaje: "+oAvisoObservacion
	});
				
	//$('#CmpOrdenVentaVehiculoId').val(oOrdenVentaVehiculoId);
	//$('#CmpVehiculoAvisoFechaVenta').val(oVehiculoAvisoFechaVenta);
	//$('#CmpVehiculoAvisoCantidadMantenimientos').val(oVehiculoAvisoCantidadMantenimientos);
	//$('#CapVehiculoAvisoHoja').html("<a href='javascript:FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPM.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);'>Ver Hoja de Plan de Mantenimiento</a>");

	FncVehiculoAvisoFuncion();

}

function FncVehiculoAvisoFuncion(){
	
}

/*
* Funciones PopUp Formulario
*/

/*
* Funciones PopUp Listado
*/
