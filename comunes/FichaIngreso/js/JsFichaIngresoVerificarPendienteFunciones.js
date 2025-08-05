// JavaScript Document


/*
* FUNCIONES ADICIONALES
*/


function FncFichaIngresoVerificarPendiente(oVehiculoIngresoId){

	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
	var VehiculoIngresoId = oVehiculoIngresoId;
	
	if(VehiculoIngresoId==""){
	
	}else{
				
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/FichaIngreso/acc/AccFichaIngresoVerificarPendiente.php',
		data: 'VehiculoIngresoId='+VehiculoIngresoId,
		success: function(InsFichaIngreso){
		
			if(InsFichaIngreso.FinId!=null){					
				
				// dhtmlx.message({ type:"info", text:"EL VIN ingresado tiene una O.T. pendiente registrado anteriormente: <a href='principal.php?Mod=FichaIngreso&Form=Ver&Id="+InsFichaIngreso.FinId+"' target='_blank'>"+InsFichaIngreso.FinId+"</a>", expire:-3 });
				
				dhtmlx.alert({
						title:"Aviso",
						type:"alert-error",
						text:"Existe una O.T.("+InsFichaIngreso.FinId+") pendiente con este VIN.",
						callback: function(result){
						//	FncVehiculoIngresoNuevo();
						}
					});
					
					
				
				//dhtmlx.message({ type:"info", text:"EL VIN ingresado tiene una O.T. pendiente registrado anteriormente: "+InsFichaIngreso.FinId });
				 
			}
				
			}
		});	
	}


}