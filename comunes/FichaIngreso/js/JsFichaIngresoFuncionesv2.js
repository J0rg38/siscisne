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
					
				FncFichaIngresoEscoger(InsFichaIngreso);
				
			}
				
			}
		});	
	}


}

//FncFichaIngresoEscoger(InsFichaIngreso.,InsFichaIngreso.,InsFichaIngreso.,InsFichaIngreso.,InsFichaIngreso.,InsFichaIngreso.);
				
//function FncFichaIngresoEscoger(oFichaIngresoId,oFichaIngresoFecha,oFichaIngresoClienteNombre,oFichaIngresoVehiculoVIN,oFichaIngresoConductor,oFichaIngresoVehiculoKilometraje){
function FncFichaIngresoEscoger(InsFichaIngreso){	
	
	//$("CmpFichaIngreso").removeClass("EstFormularioCajaError").addClass("EstFormularioCajaSeleccionado");
	
	$("#CmpFichaIngreso").removeClass();
	$("#CmpFichaIngreso").addClass("EstFormularioCajaSeleccionado");
	
	$('#CapFichaIngresoBuscar').html('');
	
	$('#CmpFichaIngresoId').val(InsFichaIngreso.FinId);
	$('#CmpFichaIngresoFecha').val(InsFichaIngreso.FinFecha);
	$('#CmpFichaIngresoCliente').val(InsFichaIngreso.CliNombre);
	$('#CmpFichaIngresoVehiculoVIN').val(InsFichaIngreso.EinVIN);
	$('#CmpFichaIngresoConductor').val(InsFichaIngreso.FinConductor);
	$('#CmpFichaIngresoVehiculoKilometraje').val(InsFichaIngreso.FinVehiculoKilometraje);

	
	$('#CmpFichaIngreso').attr('readonly', true);
	$('#CmpFichaIngresoFecha').attr('readonly', true);
	$('#CmpFichaIngresoCliente').attr('readonly', true);
	$('#CmpFichaIngresoVehiculoVIN').attr('readonly', true);
	
	FncFichaIngresoFuncion(InsFichaIngreso);
	//tb_remove();

}


function FncFichaIngresoFuncion(InsFichaIngreso){
	
}



/*
* FUNCIONES ADICIONALES
*/




/*
* Funciones PopUp Listado
*/

function FncFichaIngresoFiltrar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	else if(e) keyCode=e.which;
	
	if (keyCode==13){	
		FncFichaIngresoFiltrar2();	
	}
	
}

function FncFichaIngresoFiltrar2(){
	
	var Filtro = $('#CmpBuscarFiltro').val();
	var Sucursal = $('#CmpBuscarSucursal').val();
	
	if(Filtro.length > 2){
	
		$("#CapFichaIngresos").html("Buscando...");
			
		$.ajax({
			type: 'POST',
			dataType : 'html',
			url: 'comunes/FichaIngreso/FrmFichaIngresoListado.php',
			data: 'Filtro='+Filtro+'&Sucursal='+Sucursal,
			success: function(html){
				$("#CapFichaIngresos").html("");
				$("#CapFichaIngresos").append(html);
			}
		});	
	
	}else{
		alert("Ingrese al menos tres caracteres.");
	}
	
	
		

}

function FncFichaIngresoListadoEscoger(oFichaIngresoId){
	
	$('#CmpFichaIngresoId').val(oFichaIngresoId);
	$('#CmpFichaIngreso').val(oFichaIngresoId);
	FncFichaIngresoBuscar("Id");
	tb_remove();
	
}

/*
* FUNCIONES ADICIONALES
*/
