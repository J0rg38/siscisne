// JavaScript Document

$().ready(function() {	

	$("#CmpTransporteNumeroDocumento").keypress(function (event) {  
		 if (event.keyCode == '13' && this.value != "" && $("#CmpTransporteNombre").val()=="") {
			FncTransporteBuscar("NumeroDocumento")
		 }
	}); 
	
	$("#CmpTransporteNombre").keypress(function (event) {  
		 if (event.keyCode == '13' && this.value != "" && $("#CmpTransporteId").val()=="") {
			FncTransporteBuscar("Nombre")
		 }
	}); 
});	

function FncTransporteNuevo(){
	
	$('#CmpTransporteId').val("");
	$('#CmpTransporteNumeroDocumento').val("");	
	$('#CmpTransporteNombre').val("");
	$('#CmpTransporteDireccion').val("");
	
}




function FncTransporteBuscar(oCampo){
	
	var Dato = $('#CmpTransporte'+oCampo).val();

	if(Dato==""){
		$('#CmpTransporte'+oCampo).focus();
		$('#CmpTransporte'+oCampo).select();	
	}else{
		
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Transporte/acc/AccTransporteBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsTransporte){
		
			if(InsTransporte.TraId!=null){
				FncTransporteEscoger(InsTransporte.TraId,InsTransporte.TraNumeroDocumento,InsTransporte.TraNombre,InsTransporte.TraDireccion);
			}
				
		}
		});	
		
		
	}
	
		
}


function FncTransporteEscoger(oTransporteId,oTransporteNumeroDocumento,oTransporteNombre,oTransporteDireccion){
	
	$('#CapTransporteBuscar').html('');
	
		$('#CmpTransporteId').val(oTransporteId);
		$('#CmpTransporteNumeroDocumento').val(oTransporteNumeroDocumento);
		$('#CmpTransporteNombre').val(oTransporteNombre);
				
	var Transporte = '';
	
	if($('#CmpTransporteDireccion').length>0) {
		$('#CmpTransporteDireccion').val(oTransporteDireccion);
	}else{
		Transporte = Transporte + '<input size="10" type="hidden" name="CmpTransporteDireccion" id="CmpTransporteDireccion" value="' +oTransporteDireccion +'">';	
	}
	
	$('#CapTransporteBuscar').html(Transporte);
	tb_remove();
	
}


/*
* Funciones PopUp Listado
*/

function FncTransporteFiltrar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	
	else if(e) keyCode=e.which;
	
	if (keyCode==13){

FncTransporteFiltrar2();
	
	}
	
}

function FncTransporteFiltrar2(){
	
	var Categoria = $('#CmpTransporteCategoria').val();
	var Campo = $('#CmpTransporteCampo').val();
	var Condicion = $('#CmpTransporteCondicion').val();
	var Filtro = $('#CmpTransporteFiltro').val();

	$.ajax({
		type: 'POST',
		dataType : 'html',
		url: 'comunes/Transporte/FrmTransporteListado.php',
		data: 'Categoria='+Categoria+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
		success: function(html){
			$("#CapTransportes").html("");
			$("#CapTransportes").append(html);
		}
	});
		

	
}

