// JavaScript Document

function FncOrdenVentaVehiculoMantenimientoNuevo(){
	
//	$("#CmpMantenimientoKilometraje").val(InsOrdenVentaVehiculoMantenimiento.OvmKilometraje);
	$("#CmpFichaIngresoModalidadObsequio_MA").attr('checked', false);

	$('#CmpOrdenVentaVehiculoMantenimientoId').val("");
	$('#CmpOrdenVentaVehiculoMantenimientoKilometraje').val("");
	

}
/*
* FUNCIONES ADICIONALES
*/

//function FncOrdenVentaVehiculoMantenimientoVerificar(oVehiculoIngresoId){
	function FncOrdenVentaVehiculoMantenimientoVerificar(){

	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
	///var VehiculoIngresoId = oVehiculoIngresoId;
	
	if(VehiculoIngresoId==""){
	
	}else{
		
		$('.error').text("Buscando mantenimientos gratuitos...").fadeIn(400).delay(2000).fadeOut(400);
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/FichaIngreso/acc/AccOrdenVentaVehiculoMantenimientoVerificar.php',
		data: 'VehiculoIngresoId='+VehiculoIngresoId,
		success: function(InsOrdenVentaVehiculoMantenimiento){
		
			if(InsOrdenVentaVehiculoMantenimiento!=null){
				if(InsOrdenVentaVehiculoMantenimiento.OvmId!=null){					
					
					
					var notas = "";
					
					if(InsOrdenVentaVehiculoMantenimiento.OvvObservacion!=null){	
						if(InsOrdenVentaVehiculoMantenimiento.OvvObservacion!=""){	
						
							notas += "<b>NOTA: </b>";
							notas += InsOrdenVentaVehiculoMantenimiento.OvvObservacion;
							
						}
					}
					
					dhtmlx.message({ 
						type:"info", 
						text:"EL VIN ingresado tiene mantenimiento gratuito: "+InsOrdenVentaVehiculoMantenimiento.OvmKilometraje+" km. " + notas , 
						expire:-3 
					});

//					dhtmlx.alert({
//						title:"Aviso",
//						type:"alert-error",
//						text:"EL VIN ingresado tiene mantenimiento gratuito: "+InsOrdenVentaVehiculoMantenimiento.OvmKilometraje+" km" ,
//						callback: function(result){
//						//	FncVehiculoIngresoNuevo();
//						}
//					});
					
					
					//dhtmlx.alert({
//						
//						title:"Aviso",
//					 	//type:"alert-error",
//						text:"EL VIN ingresado tiene mantenimiento gratuito: "+InsOrdenVentaVehiculoMantenimiento.OvmKilometraje+" km"
//						
//					});
					FncOrdenVentaVehiculoMantenimientoFuncion(InsOrdenVentaVehiculoMantenimiento);
					
				}else{
					$('.error').text("No se encontraron mantenimientos gratuitos...").fadeIn(400).delay(2000).fadeOut(400);
				}
				
			}else{
				$('.error').text("No se encontraron mantenimientos gratuitos...").fadeIn(400).delay(2000).fadeOut(400);
			}
				
				
			}
		});	
	}


}

function FncOrdenVentaVehiculoMantenimientoFuncion(oOrdenVentaVehiculoMantenimiento){
	
}