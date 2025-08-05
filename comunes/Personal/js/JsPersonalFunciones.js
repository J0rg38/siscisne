// JavaScript Document

$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

//alert($("#CmpPersonalId").val());
	if($("#CmpPersonalId").val()==""){
		$("#BtnPersonalEditar").hide();
		$("#BtnPersonalRegistrar").show();
	}else{
		$("#BtnPersonalEditar").show();
		$("#BtnPersonalRegistrar").hide();
	}

	$("#CmpPersonalNumeroDocumento").keyup(function (event) {  
	
		if($.trim($("#CmpPersonalNumeroDocumento").val())==""){
			FncPersonalNuevo();
		}
		
		 if (event.keyCode == '13' && this.value != "" && $("#CmpPersonalNombre").val()=="") {
			FncPersonalBuscar("NumeroDocumento")
		 }
	});

	
	$("#CmpPersonalNombre").keyup(function (event) {  		
		if($.trim($("#CmpPersonalNombre").val())==""){
			 FncPersonalNuevo();
		}
	}); 

	FncPersonalCargarEvento();
	
});	

function FncPersonalNuevo(){

	$('#CmpPersonalId').val("");
	$('#CmpPersonalNombre').val("");	
	$('#CmpPersonalNumeroDocumento').val("");
	$('#CmpPersonalTelefono').val("");
	$('#CmpPersonalEmail').val("");
	$('#CmpPersonalCelular').val("");
	$('#CmpPersonalFax').val("");

	$('#CmpPersonalTipoDocumento').val("");

	$('#CmpPersonalDireccion').val("");
	$('#CmpPersonalTipo').val("");
	$('#CmpPersonalTipoUtilidad').val("");
	$('#CmpConductor').val("");

	$("#CmpPersonalVehiculoIngresoId").val("");



	$('#CmpPersonalNombre').removeAttr('readonly');
	$('#CmpPersonalNumeroDocumento').removeAttr('readonly');
	$('#CmpPersonalTipoDocumento').removeAttr('disabled');
	
//	$('#CmpPersonalTelefono').removeAttr('readonly');
//	$('#CmpPersonalCelular').removeAttr('readonly');
//	$('#CmpPersonalEmail').removeAttr('readonly');
//	$('#CmpPersonalDireccion').removeAttr('readonly');
	
	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnPersonalEditar").hide();
	$("#BtnPersonalRegistrar").show();


	
	FncPersonalQuitarEvento();

	
	FncPersonalNuevoFuncion();

}

function FncPersonalNuevoFuncion(){
	
}

function FncPersonalBuscar(oCampo){

	var Dato = $('#CmpPersonal'+oCampo).val();

	if(Dato==""){
		$('#CmpPersonal'+oCampo).focus();
		$('#CmpPersonal'+oCampo).select();		
	}else{

		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Personal/acc/AccPersonalBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsPersonal){

				if(InsPersonal.PerId!=null){					
					FncPersonalEscoger(InsPersonal.PerId,InsPersonal.PerNumeroDocumento,InsPersonal.PerNombreCompleto,InsPersonal.TdoId,InsPersonal.PerTelefono,InsPersonal.PerCelular,InsPersonal.PerDireccion,InsPersonal.LtiId,InsPersonal.LtiUtilidad,InsPersonal.PerEmail,InsPersonal.EinId,InsPersonal.MonId,InsPersonal.PerNombreCompleto);
				}

			}
		});	
	}

}


//FncPersonalEscoger(InsPersonal.PerId,InsPersonal.PerNumeroDocumento,InsPersonal.PerNombreCompleto,InsPersonal.TdoId,InsPersonal.PerTelefono,InsPersonal.PerCelular,InsPersonal.PerDireccion,InsPersonal.LtiId,InsPersonal.LtiUtilidad,InsPersonal.PerEmail,InsPersonal.EinId,InsPersonal.MonId);

function FncPersonalEscoger(oPersonalId,oPersonalNumeroDocumento,oPersonalNombre,oTipoDocumentoId,oPersonalTelefono,oPersonalCelular,oPersonalDireccion,oPersonalTipoId,oPersonalTipoUtilidad,oPersonalEmail,oPersonalVehiculoIngresoId,oMonedaId,oPersonalNombreCompleto){

	$('#CapPersonalBuscar').html('');
	
	$('#CmpPersonalId').val(oPersonalId);
	$('#CmpPersonalNombre').val(oPersonalNombreCompleto);
	$('#CmpPersonalNumeroDocumento').val(oPersonalNumeroDocumento);
	$('#CmpPersonalTipoDocumento').val(oTipoDocumentoId);
	$('#CmpPersonalTelefono').val(oPersonalTelefono);
	$('#CmpPersonalCelular').val(oPersonalCelular);
	$('#CmpPersonalEmail').val(oPersonalEmail);
	$('#CmpPersonalDireccion').val(oPersonalDireccion);
	$('#CmpPersonalTipo').val(oPersonalTipoId);

	$('#CmpConductor').val(oPersonalNombre);

	$("#CmpPersonalVehiculoIngresoId").val(oPersonalVehiculoIngresoId);
	
	$("#CmpPersonalMonedaId").val(oMonedaId);
	
	$('#CmpPersonalNombre').attr('readonly', true);
	$('#CmpPersonalNumeroDocumento').attr('readonly', true);
	$('#CmpPersonalTipoDocumento').attr('disabled', true);

	$('#CmpPersonalTelefono').attr('readonly', true);
	$('#CmpPersonalCelular').attr('readonly', true);
	$('#CmpPersonalEmail').attr('readonly', true);
	$('#CmpPersonalDireccion').attr('readonly', true);

	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnPersonalEditar").show();
	$("#BtnPersonalRegistrar").hide();



	FncPersonalCargarEvento();

	FncPersonalFuncion();
	
}

function FncPersonalFuncion(){
	
}


/*
* Funciones Auxliares
*/


function FncPersonalCargarEvento(){

	var PersonalId = $("#CmpPersonalId").val();

	if(PersonalId !="" && PersonalId != null){
			
		$("#CmpPersonalTipoDocumento").click(function (event) {  
			
			FncPersonalCargarFormulario("Editar");
			
		}); 
		
		
		$("#CmpPersonalTelefono").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncPersonalCargarFormulario("Editar");
		
			 }
		}); 
		
		
		$("#CmpPersonalCelular").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncPersonalCargarFormulario("Editar");
		
			 }
		}); 
		
		$("#CmpPersonalDireccion").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncPersonalCargarFormulario("Editar");
		
			 }
		}); 
		
		$("#CmpPersonalEmail").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncPersonalCargarFormulario("Editar");
		
			 }
		}); 
		
	}
	
}

function FncPersonalQuitarEvento(){

	$("#CmpPersonalTipoDocumento").unbind();
	
	$("#CmpPersonalTelefono").unbind();
	
	$("#CmpPersonalCelular").unbind();
	
	$("#CmpPersonalDireccion").unbind();
	
	$("#CmpPersonalEmail").unbind();
	
		
}
/*
* Funciones PopUp Formulario
*/

function FncPersonalCargarFormulario(oForm){

	var PersonalId = $("#CmpPersonalId").val();
	var PersonalNombre = $("#CmpPersonalNombre").val();
	var PersonalNumeroDocumento = $("#CmpPersonalNumeroDocumento").val();
	var PersonalDireccion = $("#CmpPersonalDireccion").val();
	var TipoDocumentoId = $("#CmpPersonalTipoDocumento").val();
	var PersonalTipoId = $("#CmpPersonalTipo").val();
	
	var PersonalTelefono = $("#CmpPersonalTelefono").val();
	var PersonalCelular = $("#CmpPersonalCelular").val();
	var PersonalEmail = $("#CmpPersonalEmail").val();

	tb_show(this.title,'principal2.php?Mod=Personal&Form='+oForm+'&Dia=1&PersonalId='+PersonalId+'&Id='+PersonalId+'&PersonalNombre='+PersonalNombre+'&TipoDocumentoId='+TipoDocumentoId+'&PersonalNumeroDocumento='+PersonalNumeroDocumento+'&PersonalDireccion='+PersonalDireccion+'&PersonalTipoId='+PersonalTipoId+'&PersonalEmail='+PersonalEmail+'&PersonalTelefono='+PersonalTelefono+'&PersonalCelular='+PersonalCelular+'&PersonalCelular='+PersonalCelular+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	
			
			
//	var PersonalId = $('#CmpPersonalId').val();
//	tb_show(this.title,'principal2.php?Mod=Personal&Form='+oForm+'&Dia=1&Id='+PersonalId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

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

function FncPersonalFiltrar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	else if(e) keyCode=e.which;
	
	if (keyCode==13){	
		FncPersonalFiltrar2();	
	}
	
}

function FncPersonalFiltrar2(){
	
	//var Categoria = $('#CmpPersonalCategoria').val();
	//var Campo = $('#CmpPersonalCampo').val();
	//var Condicion = $('#CmpPersonalCondicion').val();
	var Filtro = $('#CmpFiltro').val();

	$.ajax({
		type: 'POST',
		dataType : 'html',
		url: 'comunes/Personal/FrmPersonalListado.php',
		//data: 'Categoria='+Categoria+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
		data: 'Filtro='+Filtro,
		success: function(html){
			$("#CapPersonales").html("");
			$("#CapPersonales").append(html);
		}
	});		

}

function FncPersonalListadorEscoger(oPersonalId){
	
	$('#CmpPersonalId').val(oPersonalId);
	FncPersonalBuscar("Id");
	tb_remove();
	
}