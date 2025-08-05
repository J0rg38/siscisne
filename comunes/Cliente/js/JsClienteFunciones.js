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
			FncClienteNuevo();
		}
		
		 if (event.keyCode == '13' && this.value != "" && $("#CmpClienteNombre").val()=="") {
			FncClienteBuscar("NumeroDocumento")
		 }
	});

	
	$("#CmpClienteNombre").keyup(function (event) {  		
		if($.trim($("#CmpClienteNombre").val())==""){
			 FncClienteNuevo();
		}
	}); 

	FncClienteCargarEvento();
	
});	

function FncClienteNuevo(){

	$('#CmpClienteId').val("");
	$('#CmpClienteNombre').val("");	
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



	$('#CmpClienteNombre').removeAttr('readonly');
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
	
	FncClienteQuitarEvento();
	
	FncClienteNuevoFuncion();

}

function FncClienteNuevoFuncion(){
	
}

function FncClienteBuscar(oCampo){

	var Dato = $('#CmpCliente'+oCampo).val();

	if(Dato==""){
		$('#CmpCliente'+oCampo).focus();
		$('#CmpCliente'+oCampo).select();		
	}else{

		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Cliente/acc/AccClienteBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsCliente){

				if(InsCliente.CliId!=null){					
					FncClienteEscoger(InsCliente.CliId,InsCliente.CliNumeroDocumento,InsCliente.CliNombreCompleto,InsCliente.TdoId,InsCliente.CliTelefono,InsCliente.CliCelular,InsCliente.CliDireccion,InsCliente.LtiId,InsCliente.LtiUtilidad,InsCliente.CliEmail,InsCliente.EinId,InsCliente.MonId,InsCliente.LtiPorcentajeMargenUtilidad,InsCliente.CliDistrito,InsCliente.CliProvincia,InsCliente.CliDepartamento,InsCliente.LtiPorcentajeDescuento);
				}

			}
		});	
	}

}

function FncClienteEscoger(oClienteId,oClienteNumeroDocumento,oClienteNombre,oTipoDocumentoId,oClienteTelefono,oClienteCelular,oClienteDireccion,oClienteTipoId,oClienteTipoUtilidad,oClienteEmail,oClienteVehiculoIngresoId,oMonedaId,oMargenUtilidad,oClienteDistrito,oClienteProvincia,oClienteDepartamento,oClienteTipoPorcentajeDescuento){

	$('#CapClienteBuscar').html('');
	
	$('#CmpClienteId').val(oClienteId);
	$('#CmpClienteNombre').val(oClienteNombre);
	$('#CmpClienteNumeroDocumento').val(oClienteNumeroDocumento);
	$('#CmpClienteTipoDocumento').val(oTipoDocumentoId);
	$('#CmpClienteTelefono').val(oClienteTelefono);
	$('#CmpClienteCelular').val(oClienteCelular);
	$('#CmpClienteEmail').val(oClienteEmail);
	//$('#CmpClienteDireccion').val(oClienteDireccion);
	
	$('#CmpClienteDireccion').val(oClienteDireccion+" "+oClienteDistrito+" "+oClienteProvincia+" "+oClienteDepartamento);
	
	$('#CmpClienteTipo').val(oClienteTipoId);
	
	//PARA COTIZACIONES
	$('#CmpPorcentajeDescuento').val(oClienteTipoPorcentajeDescuento);
	
	//PARA COTIZACIONES/FICHA INGRESO
	$("#CmpClienteVehiculoIngresoId").val(oClienteVehiculoIngresoId);
	
	//PARA COTIZACIONES
	$("#CmpClienteMonedaId").val(oMonedaId);
	$("#CmpClienteMargenUtilidad").val(oMargenUtilidad);
	
	//PARA FICHA INGRESO
	$('#CmpConductor').val(oClienteNombre);
	

	$('#CmpClienteNombre').attr('readonly', true);
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

	FncClienteCargarEvento();

	FncClienteFuncion();
	
}

function FncClienteFuncion(){
	
}


/*
* Funciones Auxliares
*/


function FncClienteCargarEvento(){

	var ClienteId = $("#CmpClienteId").val();

	if(ClienteId !="" && ClienteId != null){
			
		$("#CmpClienteTipoDocumento").click(function (event) {  
			
			FncClienteCargarFormulario("Editar");
			
		}); 
		
		
		$("#CmpClienteTelefono").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncClienteCargarFormulario("Editar");
		
			 }
		}); 
		
		
		$("#CmpClienteCelular").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncClienteCargarFormulario("Editar");
		
			 }
		}); 
		
		$("#CmpClienteDireccion").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncClienteCargarFormulario("Editar");
		
			 }
		}); 
		
		$("#CmpClienteEmail").keyup(function (event) {  
			 if (event.keyCode >= 48 && event.keyCode <= 90) {
		
				FncClienteCargarFormulario("Editar");
		
			 }
		}); 
		
	}
	
}

function FncClienteQuitarEvento(){

	$("#CmpClienteTipoDocumento").unbind();
	
	$("#CmpClienteTelefono").unbind();
	
	$("#CmpClienteCelular").unbind();
	
	$("#CmpClienteDireccion").unbind();
	
	$("#CmpClienteEmail").unbind();
	
		
}
/*
* Funciones PopUp Formulario
*/

function FncClienteCargarFormulario(oForm){

	var ClienteId = $("#CmpClienteId").val();
	var ClienteNombre = $("#CmpClienteNombre").val();
	var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
	var ClienteDireccion = $("#CmpClienteDireccion").val();
	var TipoDocumentoId = $("#CmpClienteTipoDocumento").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();
	
	var ClienteTelefono = $("#CmpClienteTelefono").val();
	var ClienteCelular = $("#CmpClienteCelular").val();
	var ClienteEmail = $("#CmpClienteEmail").val();

	tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&ClienteId='+ClienteId+'&Id='+ClienteId+'&ClienteNombre='+ClienteNombre+'&TipoDocumentoId='+TipoDocumentoId+'&ClienteNumeroDocumento='+ClienteNumeroDocumento+'&ClienteDireccion='+ClienteDireccion+'&ClienteTipoId='+ClienteTipoId+'&ClienteEmail='+ClienteEmail+'&ClienteTelefono='+ClienteTelefono+'&ClienteCelular='+ClienteCelular+'&ClienteCelular='+ClienteCelular+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(screen.height-200)+'&width='+(screen.width-100)+'&modal=true',this.rel);
			
			
//	var ClienteId = $('#CmpClienteId').val();
//	tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+ClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncTBCerrarFunncion(oModulo){
	
	if (typeof oModulo == 'string' || oModulo instanceof String){
		if(oModulo!="" && oModulo!=null && oModulo!="undefined"){
			eval("Fnc"+oModulo+"Buscar('Id');");		
		}
	}

}


/*
* Funciones PopUp Listado
*/

function FncClienteFiltrar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	else if(e) keyCode=e.which;
	
	if (keyCode==13){	
		FncClienteFiltrar2();	
	}
	
}

function FncClienteFiltrar2(){
	

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

function FncClienteListadorEscoger(oClienteId){
	
	$('#CmpClienteId').val(oClienteId);
	FncClienteBuscar("Id");
	tb_remove();
	
}