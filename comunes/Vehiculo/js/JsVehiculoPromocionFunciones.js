// JavaScript Document


$().ready(function() {	

});	
	
function FncVehiculoPromocionNuevo(){
	
	//$('#CmpOrdenVentaVehiculoId').val("");
//	$('#CmpVehiculoPromocionFechaVenta').val("");
//	$('#CapVehiculoPromocionHoja').html("");
//	
	
	$('#CmpObsequioId').val("");
	$('#CmpObsequioNombre').val("");
	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	
	FncVehiculoPromocionNuevoFuncion();
}

function FncVehiculoPromocionNuevoFuncion(){
	
}

function FncVehiculoPromocionVerificar(){

	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
	var Fecha = $('#CmpFecha').val();
	
	if(VehiculoIngresoVIN==""){
		
	}else{
		
		$('.error').text("Buscando promocion...").fadeIn(400).delay(2000).fadeOut(400);
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Vehiculo/acc/AccVehiculoPromocionVerificar.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&Fecha='+Fecha+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(InsVehiculoPromocion){
				if(InsVehiculoPromocion.OvvId!=null){					
					//$('#CmpFichaIngresoModalidadObsequio_MA').checked(true);					
					//FncVehiculoPromocionEscoger(InsVehiculoPromocion.OvvId,InsVehiculoPromocion.VroFechaVenta,InsVehiculoPromocion.VroCantidadMantenimientos);
					FncVehiculoPromocionEscoger(InsVehiculoPromocion);

				}else{
				
					$('.error').text("No se encontraron promociones...").fadeIn(400).delay(2000).fadeOut(400);
					
				}
			}
		});	
	}


}


//function FncVehiculoPromocionEscoger(oOrdenVentaVehiculoId,oVehiculoPromocionFechaVenta,oVehiculoPromocionCantidadMantenimientos){
function FncVehiculoPromocionEscoger(InsVehiculoPromocion){

	//$('#CmpOrdenVentaVehiculoId').val(InsVehiculoPromocion.OvvId);

	//$('#CmpVehiculoPromocionFechaVenta').val(InsVehiculoPromocion.VroFechaVenta);
	//$('#CmpVehiculoPromocionCantidadMantenimientos').val(InsVehiculoPromocion.VroCantidadMantenimientos);
	
	
	$('#CmpObsequioId').val(InsVehiculoPromocion.ObsId);
	$('#CmpObsequioNombre').val(InsVehiculoPromocion.ObsNombre);
	//$('#CapVehiculoPromocionHoja').html("<a href='javascript:FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPM.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);'>Ver Hoja de Plan de Mantenimiento</a>");
	
	if(InsVehiculoPromocion.ObsId=="OBS-10011"){
		
		$('#CapVehiculoPromocionResumen').html("<a href=\"javascript:FncVehiculoPromocionCargarListado('"+InsVehiculoPromocion.EinId+"','20k');\">Ver Resumen 20k</a>");
		
	}else if(InsVehiculoPromocion.ObsId=="OBS-10012"){
				
		$('#CapVehiculoPromocionResumen').html("<a href=\"javascript:FncVehiculoPromocionCargarListado('"+InsVehiculoPromocion.EinId+"','30k');\">Ver Resumen 30k</a>");
		
	}
	
	FncVehiculoPromocionFuncion(InsVehiculoPromocion);

}

function FncVehiculoPromocionFuncion(InsVehiculoPromocion){	

}

/*
* Funciones PopUp Formulario
*/

function FncVehiculoPromocionCargarListado(oVehiculoIngresoId,oKm){

	tb_show('Listado','comunes/Vehiculo/FrmVehiculoPromocion'+oKm+'Listado.php?VehiculoIngresoId='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=false',this.rel);	

}

/*
* Funciones PopUp Listado
*/
