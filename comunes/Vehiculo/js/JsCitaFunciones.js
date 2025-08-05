// JavaScript Document


$().ready(function() {	

});	
	
function FncCitaNuevo(){
	
	$('#CmpCitaId').val("");
	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	
	FncCitaNuevoFuncion();
}

function FncCitaNuevoFuncion(){
	
}

function FncCitaVerificar(){

	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
	var Fecha = $('#CmpFecha').val();
	
	if(VehiculoIngresoVIN==""){
		
	}else{
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Vehiculo/acc/AccCitaVerificar.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&Fecha='+Fecha+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(InsCita){
//				if(InsCita.CitId!=null){					

				if(InsCita.CitId!="" & InsCita.CitId!=null){	
					FncCitaEscoger(InsCita);
					
				}
			}
		});	
	}


}


//function FncCitaEscoger(oOrdenVentaVehiculoId,oCitaFechaVenta,oCitaCantidadMantenimientos){
function FncCitaEscoger(InsCita){
	
	
	//if(InsCita!="" && InsCita!=null){

		dhtmlx.confirm("Este vehiculo tiene cita programada "+InsCita.CitHoraProgramada+". ¿Desea enlazarlo con esta O.T.?", function(result){
			if(result==true){		
				$('#CmpCitaId').val(InsCita.CitId);
			}else{
				$('#CmpCitaId').val();
			}
		});
	
		
	//}
	
				
	//dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/alerta.png' width='25' height='25' border='0' > Este vehiculo tiene cita programada "+InsCita.CitHora+" </p>" });
	FncCitaFuncion(InsCita);

}

function FncCitaFuncion(InsCita){	

}

/*
* Funciones PopUp Formulario
*/



/*
* Funciones PopUp Listado
*/
