// JavaScript Document


/*
Configuracion Autocompletar
*/
$().ready(function() {
	
	var Sucursal = $("#CmpSucursal").val();
	
	if ( $("#CmpFichaIngresoId").val() != "" ) {
		
		$("#CmpFichaIngreso").removeClass();
		$("#CmpFichaIngreso").addClass("EstFormularioCajaSeleccionado");
		$('#CmpFichaIngreso').attr('readonly', true);
		
	}
		
		
	$("#CmpFichaIngreso").blur(function () {  
		
		var FichaIngresoId = $("#CmpFichaIngresoId").val();
		
		if (FichaIngresoId == "") {
			
			//$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaError");		
			$(this).removeClass();
			$(this).addClass("EstFormularioCajaError");
			
		}else{
			//$("CmpFichaIngreso").removeClass("EstFormularioCajaError").addClass("EstFormularioCajaSeleccionado");
			//$(this).removeClass("EstFormularioCajaError").addClass("EstFormularioCajaSeleccionado");
			$(this).removeClass();
			$(this).addClass("EstFormularioCajaSeleccionado");
			
		}
		
	}); 
	
	

	
});


function FncEstablecerFichaIngresoAutocompletar(){
	
	console.log("FncEstablecerFichaIngresoAutocompletar");
	
	var Sucursal = $("#CmpSucursal").val();
	
		function FichaIngresoFormato(row) {
		//return row[0] + " " + row[1];
		return row[0];
	}

	$("#CmpFichaIngreso").autocomplete("comunes/FichaIngreso/XmlFichaIngreso.php?Sucursal="+Sucursal, {
		width: 150,
		selectFirst: false,
		formatItem: FichaIngresoFormato
	});	
	
	$("#CmpFichaIngreso").result(function(event, data, formatted) {
		
		if (data){

			$("#CmpFichaIngresoId").val(data[0]);
			
			FncFichaIngresoBuscar("Id");

			//$("#CmpFichaIngreso").val(data[0]);
//			
//			$("#CmpFichaIngresoFecha").val(data[1]);
//			$("#CmpFichaIngresoKilometraje").val(data[2]);
//			$("#CmpFichaIngresoConductor").val(data[3]);
//			$("#CmpFichaIngresoCliente").val(data[4]);
//			$("#CmpFichaIngresoVehiculoVIN").val(data[5]);
//			$("#CmpFichaIngresoUtilidad").val(data[6]);
			
			//FncFichaIngresoFuncion();
			
		}		
	});
	
	
}


$().ready(function() {
	
	
	 FncEstablecerFichaIngresoAutocompletar();
	
	
});

