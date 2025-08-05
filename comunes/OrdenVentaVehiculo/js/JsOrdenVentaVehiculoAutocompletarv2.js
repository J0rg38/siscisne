// JavaScript Document


/*
Configuracion Autocompletar
*/
$().ready(function() {
	

	if ( $("#CmpOrdenVentaVehiculoId").val() != "" ) {
		
		$("#CmpOrdenVentaVehiculo").removeClass();
		$("#CmpOrdenVentaVehiculo").addClass("EstFormularioCajaSeleccionado");
		$('#CmpOrdenVentaVehiculo').attr('readonly', true);
		
	}
		
		
	$("#CmpOrdenVentaVehiculo").blur(function () {  
		
		var OrdenVentaVehiculoId = $("#CmpOrdenVentaVehiculoId").val();
		
		if (OrdenVentaVehiculoId == "") {
			
			//$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaError");		
			$(this).removeClass();
			$(this).addClass("EstFormularioCajaError");
			
		}else{
			//$("CmpOrdenVentaVehiculo").removeClass("EstFormularioCajaError").addClass("EstFormularioCajaSeleccionado");
			//$(this).removeClass("EstFormularioCajaError").addClass("EstFormularioCajaSeleccionado");
			$(this).removeClass();
			$(this).addClass("EstFormularioCajaSeleccionado");
			
		}
		
	}); 
	
	
	 
	
	
});

function FncEstablecerOrdenVentaVehiculoAutocompletar(){
	
	console.log("FncEstablecerOrdenVentaVehiculoAutocompletar");
	
	var Sucursal = $("#CmpSucursal").val();
	
	function OrdenVentaVehiculoFormato(row) {
		//return row[0] + " " + row[1];
		return row[0];
	}

	$("#CmpOrdenVentaVehiculo").unautocomplete();
	$("#CmpOrdenVentaVehiculo").autocomplete("comunes/OrdenVentaVehiculo/XmlOrdenVentaVehiculo.php?Sucursal="+Sucursal, {
		width: 150,
		selectFirst: false,
		formatItem: OrdenVentaVehiculoFormato
	});	
	
	$("#CmpOrdenVentaVehiculo").result(function(event, data, formatted) {
		
		if (data){

			$("#CmpOrdenVentaVehiculoId").val(data[0]);
			
			FncOrdenVentaVehiculoBuscar("Id");

			//$("#CmpOrdenVentaVehiculo").val(data[0]);
//			
//			$("#CmpOrdenVentaVehiculoFecha").val(data[1]);
//			$("#CmpOrdenVentaVehiculoKilometraje").val(data[2]);
//			$("#CmpOrdenVentaVehiculoConductor").val(data[3]);
//			$("#CmpOrdenVentaVehiculoCliente").val(data[4]);
//			$("#CmpOrdenVentaVehiculoVehiculoVIN").val(data[5]);
//			$("#CmpOrdenVentaVehiculoUtilidad").val(data[6]);
			
			//FncOrdenVentaVehiculoFuncion();
			
		}		
	});
	
	
}


$().ready(function() {
	
	
	 FncEstablecerOrdenVentaVehiculoAutocompletar();
	
	
});


