// JavaScript Document

$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

//alert($("#CmpClienteId").val());
	if($("#CmpClienteId").val()==""){
		$("#BtnClienteEditar").hide();
		$("#BtnClienteRegistrar").show();
	}else{
		$("#BtnClienteEditar").show();
		$("#BtnClienteRegistrar").hide();
	}

	$("#CmpClienteNumeroDocumento").keyup(function (event) {  
	
		if($.trim($("#CmpClienteNumeroDocumento").val())==""){
			FncClienteSimpleNuevo();
		}
		
		 if (event.keyCode == '13' && this.value != "" && $("#CmpClienteNombre").val()=="") {
			FncClienteSimpleBuscar("NumeroDocumento")
		 }
	});

	
	$("#CmpClienteNombreCompleto").keyup(function (event) {  		
		if($.trim($("#CmpClienteNombreCompleto").val())==""){
			 FncClienteSimpleNuevo();
		}
	}); 

	FncClienteSimpleCargarEvento();
	
});	

function FncClienteSimpleNuevo(){

	$('#CmpClienteId').val("");
	
	$('#CmpClienteNombreCompleto').val("");	
	$('#CmpClienteNombre').val("");	
	$('#CmpClienteApellidoPaterno').val("");
	$('#CmpClienteApellidoMaterno').val("");
	
	$('#CmpClienteNumeroDocumento').val("");
	$('#CmpClienteTelefono').val("");
	$('#CmpClienteEmail').val("");
	$('#CmpClienteCelular').val("");
	$('#CmpClienteFax').val("");

	$('#CmpClienteTipoDocumento').val("");

	$('#CmpClienteDireccion').val("");
	$('#CmpClienteTipo').val("");
	$('#CmpClienteTipoUtilidad').val("");
	$('#CmpConductor').val("");
	
	//$('#CmpClienteMargenUtilidad').val("0");
	$("#CmpClienteVehiculoIngresoId").val("");
	
	

	$('#CmpClienteNombreCompleto').removeAttr('readonly');
	$('#CmpClienteNombre').removeAttr('readonly');
	$('#CmpClienteApellidoPaterno').removeAttr('readonly');
	$('#CmpClienteApellidoMaterno').removeAttr('readonly');
	
	$('#CmpClienteNumeroDocumento').removeAttr('readonly');
	
	//$('#CmpClienteTipoDocumento').removeAttr('disabled');
	
//	$('#CmpClienteTelefono').removeAttr('readonly');
//	$('#CmpClienteCelular').removeAttr('readonly');
//	$('#CmpClienteEmail').removeAttr('readonly');
//	$('#CmpClienteDireccion').removeAttr('readonly');
	
	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnClienteEditar").hide();
	$("#BtnClienteRegistrar").show();
	
	FncClienteSimpleQuitarEvento();
	
	FncClienteSimpleNuevoFuncion();

}

function FncClienteSimpleNuevoFuncion(){
	
}

function FncClienteSimpleBuscar(oCampo){

	var Dato = $('#CmpCliente'+oCampo).val();

	if(Dato==""){
		$('#CmpCliente'+oCampo).focus();
		$('#CmpCliente'+oCampo).select();		
	}else{

		$('.error').text("Cargando informacion...").fadeIn(400).delay(2000).fadeOut(400);
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Cliente/acc/AccClienteBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsCliente){

				if(InsCliente.CliId!=null){					
					
					$('.error').text("Listo").fadeIn(400).delay(1500).fadeOut(400);
					
						FncClienteSimpleEscoger(InsCliente);				//FncClienteSimpleEscoger(InsCliente.CliId,InsCliente.CliNumeroDocumento,InsCliente.CliNombreCompleto,InsCliente.TdoId,InsCliente.CliTelefono,InsCliente.CliCelular,InsCliente.CliDireccion,InsCliente.LtiId,InsCliente.LtiUtilidad,InsCliente.CliEmail,InsCliente.EinId,InsCliente.MonId,InsCliente.LtiMargenUtilidad,InsCliente.CliDistrito,InsCliente.CliProvincia,InsCliente.CliDepartamento,InsCliente.LtiPorcentajeDescuento);
				}

			}
		});	
	}

}


//function FncClienteSimpleEscoger(oClienteId,oClienteNumeroDocumento,oClienteNombre,oTipoDocumentoId,oClienteTelefono,oClienteCelular,oClienteDireccion,oClienteTipoId,oClienteTipoUtilidad,oClienteEmail,oClienteVehiculoIngresoId,oMonedaId,oMargenUtilidad,oClienteDistrito,oClienteProvincia,oClienteDepartamento,oClienteTipoPorcentajeDescuento){
function FncClienteSimpleEscoger(InsCliente){

	$('#CapClienteBuscar').html('');
	
	$('#CmpClienteId').val(InsCliente.CliId);
	
	$('#CmpClienteNombreCompleto').val(InsCliente.CliNombre+" "+InsCliente.CliApellidoPaterno+" "+InsCliente.CliApellidoMaterno);
	$('#CmpClienteNombre').val(InsCliente.CliNombre);
	$('#CmpClienteApellidoPaterno').val(InsCliente.CliApellidoPaterno);
	$('#CmpClienteApellidoMaterno').val(InsCliente.CliApellidoMaterno);
	
	$('#CmpClienteNumeroDocumento').val(InsCliente.CliNumeroDocumento);
	$('#CmpClienteTipoDocumento').val(InsCliente.TdoId);
	$('#CmpClienteTelefono').val(InsCliente.CliTelefono);
	$('#CmpClienteCelular').val(InsCliente.CliCelular);
	$('#CmpClienteEmail').val(InsCliente.CliEmail);
	$('#CmpClienteDireccion').val(InsCliente.CliDireccion);	
	$('#CmpClienteTipo').val(InsCliente.LtiId);
	
	//PARA CITAS
//	$("#CmpVehiculoIngresoId").val(InsCliente.EinId);
	
	$('#CmpClienteNombreCompleto').attr('readonly', true);
	$('#CmpClienteNombre').attr('readonly', true);
	$('#CmpClienteApellidoPaterno').attr('readonly', true);
	$('#CmpClienteApellidoMaterno').attr('readonly', true);
	
	$('#CmpClienteNumeroDocumento').attr('readonly', true);
	$('#CmpClienteTipoDocumento').attr('disabled', true);

	$('#CmpClienteTelefono').attr('readonly', true);
	$('#CmpClienteCelular').attr('readonly', true);
	$('#CmpClienteEmail').attr('readonly', true);
	$('#CmpClienteDireccion').attr('readonly', true);

		/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnClienteEditar").show();
	$("#BtnClienteRegistrar").hide();

	FncClienteSimpleCargarEvento();

	FncClienteSimpleFuncion(InsCliente);
	
}

function FncClienteSimpleFuncion(InsCliente){
	
}


/*
* Funciones Auxliares
*/


function FncClienteSimpleCargarEvento(){

	var ClienteId = $("#CmpClienteId").val();

	if(ClienteId !="" && ClienteId != null){
			
		$("#CmpClienteTipoDocumento").click(function (event) {  
			
			FncClienteSimpleCargarFormulario("Editar");
			
		}); 
		
		
		$("#CmpClienteTelefono").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncClienteSimpleCargarFormulario("Editar");
		
			 }
		}); 
		
		
		$("#CmpClienteCelular").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncClienteSimpleCargarFormulario("Editar");
		
			 }
		}); 
		
		$("#CmpClienteDireccion").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncClienteSimpleCargarFormulario("Editar");
		
			 }
		}); 
		
		$("#CmpClienteEmail").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncClienteSimpleCargarFormulario("Editar");
		
			 }
		}); 
		
	}
	
}

function FncClienteSimpleQuitarEvento(){

	$("#CmpClienteTipoDocumento").unbind();
	
	$("#CmpClienteTelefono").unbind();
	
	$("#CmpClienteCelular").unbind();
	
	$("#CmpClienteDireccion").unbind();
	
	$("#CmpClienteEmail").unbind();
	
		
}
/*
* Funciones PopUp Formulario
*/

function FncClienteSimpleCargarFormulario(oForm){

	var ClienteId = $("#CmpClienteId").val();
	var ClienteNombreCompleto = $("#CmpClienteNombreCompleto").val();
	var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
	var ClienteDireccion = $("#CmpClienteDireccion").val();
	var TipoDocumentoId = $("#CmpClienteTipoDocumento").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();
	
	var ClienteTelefono = $("#CmpClienteTelefono").val();
	var ClienteCelular = $("#CmpClienteCelular").val();
	var ClienteEmail = $("#CmpClienteEmail").val();

	tb_show(this.title,'principal2.php?Mod=ClienteSimple&Form='+oForm+'&Dia=1&ClienteId='+ClienteId+'&Id='+ClienteId+'&ClienteNombre='+ClienteNombreCompleto+'&TipoDocumentoId='+TipoDocumentoId+'&ClienteNumeroDocumento='+ClienteNumeroDocumento+'&ClienteDireccion='+ClienteDireccion+'&ClienteTipoId='+ClienteTipoId+'&ClienteEmail='+ClienteEmail+'&ClienteTelefono='+ClienteTelefono+'&ClienteCelular='+ClienteCelular+'&ClienteCelular='+ClienteCelular+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	
			
			
//	var ClienteId = $('#CmpClienteId').val();
//	tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+ClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

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

function FncClienteSimpleFiltrar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	else if(e) keyCode=e.which;
	
	if (keyCode==13){	
		FncClienteSimpleFiltrar2();	
	}
	
}

function FncClienteSimpleFiltrar2(){
	

	//var Categoria = $('#CmpClienteCategoria').val();
	//var Campo = $('#CmpClienteCampo').val();
	//var Condicion = $('#CmpClienteCondicion').val();
	var Filtro = $('#CmpFiltro').val();

	if(Filtro.length > 2){
	
		$("#CapClientes").html("Buscando...");
			
		$.ajax({
			type: 'POST',
			dataType : 'html',
			url: 'comunes/Cliente/FrmClienteListado.php',
			//data: 'Categoria='+Categoria+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
			data: 'Filtro='+Filtro,
			success: function(html){
				$("#CapClientes").html("");
				$("#CapClientes").append(html);
			}
		});	
	
	}else{
		alert("Ingrese al menos tres caracteres.");
	}
	
	
		

}

function FncClienteSimpleListadorEscoger(oClienteId){
	
	$('#CmpClienteId').val(oClienteId);
	FncClienteSimpleBuscar("Id");
	tb_remove();
	
}