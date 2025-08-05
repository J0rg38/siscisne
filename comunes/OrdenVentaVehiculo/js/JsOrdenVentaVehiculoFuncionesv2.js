// JavaScript Document


function FncOrdenVentaVehiculoNuevo(){
	
	$('#CmpOrdenVentaVehiculo').val("");
	$('#CmpOrdenVentaVehiculoId').val("");
	$('#CmpOrdenVentaVehiculoFecha').val("");	
	$('#CmpOrdenVentaVehiculoCliente').val("");	
	$('#CmpOrdenVentaVehiculoVehiculoVIN').val("");	
	$('#CmpOrdenVentaVehiculoConductor').val("");	
	$('#CmpOrdenVentaVehiculoVehiculoKilometraje').val("");	
	

	$('#CmpOrdenVentaVehiculo').removeAttr('readonly');
	$('#CmpOrdenVentaVehiculoFecha').removeAttr('readonly');
	$('#CmpOrdenVentaVehiculoCliente').removeAttr('readonly');
	$('#CmpOrdenVentaVehiculoVehiculoVIN').removeAttr('readonly');
	
	
	$("#CmpOrdenVentaVehiculo").removeClass();
	$("#CmpOrdenVentaVehiculo").addClass("EstFormularioCaja");

}

function FncOrdenVentaVehiculoBuscar(oCampo){
	
	console.log("FncOrdenVentaVehiculoBuscar");
	
	var Dato = $('#CmpOrdenVentaVehiculo'+oCampo).val();
	
	if(Dato==""){
		$('#CmpOrdenVentaVehiculo'+oCampo).focus();
		$('#CmpOrdenVentaVehiculo'+oCampo).select();		
	}else{
				
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsOrdenVentaVehiculo){
		
			if(InsOrdenVentaVehiculo.OvvId!=null){					
					
				FncOrdenVentaVehiculoEscoger(InsOrdenVentaVehiculo);
				
			}
				
			}
		});	
	}


}

//FncOrdenVentaVehiculoEscoger(InsOrdenVentaVehiculo.,InsOrdenVentaVehiculo.,InsOrdenVentaVehiculo.,InsOrdenVentaVehiculo.,InsOrdenVentaVehiculo.,InsOrdenVentaVehiculo.);
				
//function FncOrdenVentaVehiculoEscoger(oOrdenVentaVehiculoId,oOrdenVentaVehiculoFecha,oOrdenVentaVehiculoClienteNombre,oOrdenVentaVehiculoVehiculoVIN,oOrdenVentaVehiculoConductor,oOrdenVentaVehiculoVehiculoKilometraje){
function FncOrdenVentaVehiculoEscoger(InsOrdenVentaVehiculo){	
	
	console.log("FncOrdenVentaVehiculoEscoger");
	//$("CmpOrdenVentaVehiculo").removeClass("EstFormularioCajaError").addClass("EstFormularioCajaSeleccionado");
	
	$("#CmpOrdenVentaVehiculo").removeClass();
	$("#CmpOrdenVentaVehiculo").addClass("EstFormularioCajaSeleccionado");
	
	$('#CapOrdenVentaVehiculoBuscar').html('');
	
	$('#CmpOrdenVentaVehiculoId').val(InsOrdenVentaVehiculo.OvvId);
	$('#CmpOrdenVentaVehiculoFecha').val(InsOrdenVentaVehiculo.OvvFecha);
	$('#CmpOrdenVentaVehiculoCliente').val(InsOrdenVentaVehiculo.CliNombre);
	$('#CmpOrdenVentaVehiculoVehiculoVIN').val(InsOrdenVentaVehiculo.EinVIN);
	
	$('#CmpOrdenVentaVehiculo').attr('readonly', true);
	$('#CmpOrdenVentaVehiculoFecha').attr('readonly', true);
	$('#CmpOrdenVentaVehiculoCliente').attr('readonly', true);
	$('#CmpOrdenVentaVehiculoVehiculoVIN').attr('readonly', true);
	
	FncOrdenVentaVehiculoFuncion(InsOrdenVentaVehiculo);
	//tb_remove();

}


function FncOrdenVentaVehiculoFuncion(InsOrdenVentaVehiculo){
	
}





/*
* Funciones PopUp Listado
*/

function FncOrdenVentaVehiculoFiltrar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	else if(e) keyCode=e.which;
	
	if (keyCode==13){	
		FncOrdenVentaVehiculoFiltrar2();	
	}
	
}

function FncOrdenVentaVehiculoFiltrar2(){
	
	var Filtro = $('#CmpBuscarFiltro').val();
	var Sucursal = $('#CmpBuscarSucursal').val();
	
	if(Filtro.length > 2){
	
		$("#CapOrdenVentaVehiculos").html("Buscando...");
			
		$.ajax({
			type: 'POST',
			dataType : 'html',
			url: 'comunes/OrdenVentaVehiculo/FrmOrdenVentaVehiculoListado.php',
			data: 'Filtro='+Filtro+'&Sucursal='+Sucursal,
			success: function(html){
				$("#CapOrdenVentaVehiculos").html("");
				$("#CapOrdenVentaVehiculos").append(html);
			}
		});	
	
	}else{
		alert("Ingrese al menos tres caracteres.");
	}
	
	
		

}

function FncOrdenVentaVehiculoListadoEscoger(oOrdenVentaVehiculoId){
	
	$('#CmpOrdenVentaVehiculoId').val(oOrdenVentaVehiculoId);
	$('#CmpOrdenVentaVehiculo').val(oOrdenVentaVehiculoId);
	FncOrdenVentaVehiculoBuscar("Id");
	tb_remove();
	
}

/*
* FUNCIONES ADICIONALES
*/



//function FncOrdenVentaVehiculoBuscarLista(){
//	
//	tb_show("",'comunes/OrdenVentaVehiculo/FrmOrdenVentaVehiculoBuscar.php?Id=&placeValuesBeforeTB_=savedValues&TB_iframe=false&height=400&width=600&modal=false',this.rel);		
//
//	
//}