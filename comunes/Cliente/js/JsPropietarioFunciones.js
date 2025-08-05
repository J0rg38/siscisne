
$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	
	if($("#CmpPropietarioId").val()==""){
		$("#BtnPropietarioEditar").hide();
		$("#BtnPropietarioRegistrar").show();
	}else{
		$("#BtnPropietarioEditar").show();
		$("#BtnPropietarioRegistrar").hide();
	}
	
	$("#CmpPropietarioNumeroDocumento").keyup(function (event) {  
	
		if($.trim($("#CmpPropietarioNumeroDocumento").val())==""){
			FncPropietarioNuevo();
		}
		
		if (event.keyCode == '13' && this.value != "" && $("#CmpPropietarioNombre").val()=="") {
			FncPropietarioBuscar("NumeroDocumento")
		}

	});

	$("#CmpPropietarioNombre").keyup(function (event) {  		
		if($.trim($("#CmpPropietarioNombre").val())==""){
			 FncPropietarioNuevo();
		}
	}); 

});	

function FncPropietarioNuevo(){

	$('#CmpPropietarioId').val("");
	$('#CmpPropietarioNombre').val("");	
	$('#CmpPropietarioNumeroDocumento').val("");
	$('#CmpPropietarioTelefono').val("");
	$('#CmpPropietarioEmail').val("");
	$('#CmpPropietarioCelular').val("");
	$('#CmpPropietarioFax').val("");

	$('#CmpPropietarioTipoDocumento').val("");

	$('#CmpPropietarioDireccion').val("");
	$('#CmpPropietarioTipo').val("");
	$('#CmpPropietarioTipoUtilidad').val("");
	$('#CmpConductor').val("");

	$("#CmpPropietarioVehiculoIngresoId").val("");



	$('#CmpPropietarioNombre').removeAttr('readonly');
	$('#CmpPropietarioNumeroDocumento').removeAttr('readonly');
	$('#CmpPropietarioTipoDocumento').removeAttr('disabled');
	
//	$('#CmpPropietarioTelefono').removeAttr('readonly');
//	$('#CmpPropietarioCelular').removeAttr('readonly');
//	$('#CmpPropietarioEmail').removeAttr('readonly');
//	$('#CmpPropietarioDireccion').removeAttr('readonly');
	
	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnPropietarioEditar").hide();
	$("#BtnPropietarioRegistrar").show();

	FncPropietarioNuevoFuncion();

}

function FncPropietarioNuevoFuncion(){
	
}

function FncPropietarioBuscar(oCampo){

	var Dato = $('#CmpPropietario'+oCampo).val();

	if(Dato==""){
		$('#CmpPropietario'+oCampo).focus();
		$('#CmpPropietario'+oCampo).select();		
	}else{

		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Cliente/acc/AccClienteBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsPropietario){

				if(InsPropietario.CliId!=null){					
					FncPropietarioEscoger(InsPropietario.CliId,InsPropietario.CliNumeroDocumento,InsPropietario.CliNombreCompleto,InsPropietario.TdoId,InsPropietario.CliTelefono,InsPropietario.CliCelular,InsPropietario.CliDireccion,InsPropietario.LtiId,InsPropietario.LtiUtilidad,InsPropietario.CliEmail,InsPropietario.EinId);
				}

			}
		});	
	}

}

function FncPropietarioEscoger(oPropietarioId,oPropietarioNumeroDocumento,oPropietarioNombre,oTipoDocumentoId,oPropietarioTelefono,oPropietarioCelular,oPropietarioDireccion,oPropietarioTipoId,oPropietarioTipoUtilidad,oPropietarioEmail,oPropietarioVehiculoIngresoId){

	$('#CapPropietarioBuscar').html('');
	
	$('#CmpPropietarioId').val(oPropietarioId);
	$('#CmpPropietarioNombre').val(oPropietarioNombre);
	$('#CmpPropietarioNumeroDocumento').val(oPropietarioNumeroDocumento);
	$('#CmpPropietarioTipoDocumento').val(oTipoDocumentoId);
	$('#CmpPropietarioTelefono').val(oPropietarioTelefono);
	$('#CmpPropietarioCelular').val(oPropietarioCelular);
	$('#CmpPropietarioEmail').val(oPropietarioEmail);
	$('#CmpPropietarioDireccion').val(oPropietarioDireccion);
	$('#CmpPropietarioTipo').val(oPropietarioTipoId);

	$('#CmpConductor').val(oPropietarioNombre);

	$("#CmpPropietarioVehiculoIngresoId").val(oPropietarioVehiculoIngresoId);

	$('#CmpPropietarioNombre').attr('readonly', true);
	$('#CmpPropietarioNumeroDocumento').attr('readonly', true);
	$('#CmpPropietarioTipoDocumento').attr('disabled', true);
//	$('#CmpPropietarioTelefono').attr('readonly', true);
//	$('#CmpPropietarioCelular').attr('readonly', true);
//	$('#CmpPropietarioEmail').attr('readonly', true);
//	$('#CmpPropietarioDireccion').attr('readonly', true);

	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnPropietarioEditar").show();
	$("#BtnPropietarioRegistrar").hide();

	FncPropietarioFuncion();
}

function FncPropietarioFuncion(){
	
}


/*
* Funciones PopUp Formulario
*/

function FncPropietarioCargarFormulario(oForm,oPropietarioId){
	
	if(oPropietarioId == null){

		var ClienteId = $("#CmpPropietarioId").val();

	}else{

		var ClienteId = oPropietarioId;	

	}
	
	
	var ClienteNombre = $("#CmpPropietarioNombre").val();
	var ClienteNumeroDocumento = $("#CmpPropietarioNumeroDocumento").val();
	var ClienteDireccion = $("#CmpPropietarioDireccion").val();
	var TipoDocumentoId = $("#CmpPropietarioTipoDocumento").val();
	var ClienteTipoId = $("#CmpPropietarioTipo").val();
	
	var ClienteTelefono = $("#CmpPropietarioTelefono").val();
	var ClienteCelular = $("#CmpPropietarioCelular").val();
	var ClienteEmail = $("#CmpPropietarioEmail").val();

	

	tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&ClienteId='+ClienteId+'&Id='+ClienteId+'&ClienteNombre='+ClienteNombre+'&TipoDocumentoId='+TipoDocumentoId+'&ClienteNumeroDocumento='+ClienteNumeroDocumento+'&ClienteDireccion='+ClienteDireccion+'&ClienteTipoId='+ClienteTipoId+'&ClienteEmail='+ClienteEmail+'&ClienteTelefono='+ClienteTelefono+'&ClienteCelular='+ClienteCelular+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	

}


function FncTBCerrarFunncion(oModulo){
	
	if (typeof oModulo == 'string' || oModulo instanceof String){
		if(oModulo!="" && oModulo!=null && oModulo!="undefined"){
			try{
				eval("Fnc"+oModulo+"Buscar('Id');");		
			}catch(e){
				
			}
		}
	}

}


/*
* Funciones PopUp Listado
*/

function FncPropietarioFiltrar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	else if(e) keyCode=e.which;
	
	if (keyCode==13){	
		FncPropietarioFiltrar2();	
	}
	
}

function FncPropietarioFiltrar2(){
	
	//var Categoria = $('#CmpPropietarioCategoria').val();
	//var Campo = $('#CmpPropietarioCampo').val();
	//var Condicion = $('#CmpPropietarioCondicion').val();
	var Filtro = $('#CmpFiltro').val();

	$.ajax({
		type: 'POST',
		dataType : 'html',
		url: 'comunes/Cliente/FrmClienteListado.php',
		//data: 'Categoria='+Categoria+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
		data: 'Filtro='+Filtro,
		success: function(html){
			$("#CapPropietarios").html("");
			$("#CapPropietarios").append(html);
		}
	});		

}

function FncPropietarioListadorEscoger(oPropietarioId){
	
	$('#CmpPropietarioId').val(oPropietarioId);
	FncPropietarioBuscar("Id");
	tb_remove();
	
}