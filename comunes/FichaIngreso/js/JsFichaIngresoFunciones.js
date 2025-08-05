// JavaScript Document


function FncFichaIngresoNuevo(){
	
	$('#CmpFichaIngreso').val("");
	$('#CmpFichaIngresoId').val("");
	$('#CmpFichaIngresoFecha').val("");	
	$('#CmpFichaIngresoCliente').val("");	
	$('#CmpFichaIngresoVehiculoVIN').val("");	
	$('#CmpFichaIngresoConductor').val("");	
	$('#CmpFichaIngresoVehiculoKilometraje').val("");	
	

	$('#CmpFichaIngreso').removeAttr('readonly');
	$('#CmpFichaIngresoFecha').removeAttr('readonly');
	$('#CmpFichaIngresoCliente').removeAttr('readonly');
	$('#CmpFichaIngresoVehiculoVIN').removeAttr('readonly');
	
	
	$("#CmpFichaIngreso").removeClass();
	$("#CmpFichaIngreso").addClass("EstFormularioCaja");

}

function FncFichaIngresoBuscar(oCampo){

	var Dato = $('#CmpFichaIngreso'+oCampo).val();
	
	if(Dato==""){
		$('#CmpFichaIngreso'+oCampo).focus();
		$('#CmpFichaIngreso'+oCampo).select();		
	}else{
				
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/FichaIngreso/acc/AccFichaIngresoBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsFichaIngreso){
		
			if(InsFichaIngreso.FinId!=null){					
					
				FncFichaIngresoEscoger(InsFichaIngreso.FinId,InsFichaIngreso.FinFecha,InsFichaIngreso.CliNombre,InsFichaIngreso.EinVIN,InsFichaIngreso.FinConductor,InsFichaIngreso.FinVehiculoKilometraje);
				
			}
				
			}
		});	
	}


}

function FncFichaIngresoEscoger(oFichaIngresoId,oFichaIngresoFecha,oFichaIngresoClienteNombre,oFichaIngresoVehiculoVIN,oFichaIngresoConductor,oFichaIngresoVehiculoKilometraje){
	
	//$("CmpFichaIngreso").removeClass("EstFormularioCajaError").addClass("EstFormularioCajaSeleccionado");
	
	$("#CmpFichaIngreso").removeClass();
	$("#CmpFichaIngreso").addClass("EstFormularioCajaSeleccionado");
	
	
	
	$('#CapFichaIngresoBuscar').html('');
	
	$('#CmpFichaIngresoId').val(oFichaIngresoId);
	$('#CmpFichaIngresoFecha').val(oFichaIngresoFecha);
	$('#CmpFichaIngresoCliente').val(oFichaIngresoClienteNombre);
	$('#CmpFichaIngresoVehiculoVIN').val(oFichaIngresoVehiculoVIN);
	$('#CmpFichaIngresoConductor').val(oFichaIngresoConductor);
	$('#CmpFichaIngresoVehiculoKilometraje').val(oFichaIngresoVehiculoKilometraje);

	
	$('#CmpFichaIngreso').attr('readonly', true);
	$('#CmpFichaIngresoFecha').attr('readonly', true);
	$('#CmpFichaIngresoCliente').attr('readonly', true);
	$('#CmpFichaIngresoVehiculoVIN').attr('readonly', true);
	
	FncFichaIngresoFuncion();
	//tb_remove();

}


function FncFichaIngresoFuncion(){
	
}



/*
* FUNCIONES ADICIONALES
*/

