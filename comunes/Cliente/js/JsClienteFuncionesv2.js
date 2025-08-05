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

	
	$("#CmpClienteNombreCompleto").keyup(function (event) {  		
		if($.trim($("#CmpClienteNombreCompleto").val())==""){
			 FncClienteNuevo();
		}
	}); 

	FncClienteCargarEvento();
	
});	

function FncClienteNuevo(){

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
	
	$("#CmpClienteVehiculoIngresoId").val("");
	
	
	$('#CmpClienteNombre').removeAttr('readonly');
	$('#CmpClienteApellidoPaterno').removeAttr('readonly');
	$('#CmpClienteApellidoMaterno').removeAttr('readonly');

	$('#CmpClienteNombreCompleto').removeAttr('readonly');
	
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

		$('.error').text("Cargando informacion...").fadeIn(400).delay(2000).fadeOut(400);
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Cliente/acc/AccClienteBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsCliente){

				if(InsCliente.CliId!=null){					
					
					$('.error').text("Listo").fadeIn(400).delay(1500).fadeOut(400);
					
					FncClienteEscoger(InsCliente);
					//FncClienteEscoger(InsCliente.CliId,InsCliente.CliNumeroDocumento,InsCliente.CliNombreCompleto,InsCliente.TdoId,InsCliente.CliTelefono,InsCliente.CliCelular,InsCliente.CliDireccion,InsCliente.LtiId,InsCliente.LtiUtilidad,InsCliente.CliEmail,InsCliente.EinId,InsCliente.MonId,InsCliente.LtiMargenUtilidad,InsCliente.CliDistrito,InsCliente.CliProvincia,InsCliente.CliDepartamento,InsCliente.LtiPorcentajeDescuento);
				}else{
					
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"No se encontraron datos",
							callback: function(result){
								
							}
						});
			
			
				}

			}
		});	
	}

}

function FncClienteEscoger(InsCliente){

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
	//$('#CmpClienteDireccion').val(oClienteDireccion);
	
	$('#CmpClienteDireccion').val(InsCliente.CliDireccion+" "+InsCliente.CliDistrito+" "+InsCliente.CliProvincia+" "+InsCliente.CliDepartamento);
	
	$('#CmpClienteTipo').val(InsCliente.LtiId);
	
	//PARA COTIZACIONES
	$('#CmpPorcentajeDescuento').val(InsCliente.LtiPorcentajeDescuento);
	
	//PARA COTIZACIONES/FICHA INGRESO
	$("#CmpClienteVehiculoIngresoId").val(InsCliente.EinId);
	
	//PARA COTIZACIONES
	$("#CmpClienteMonedaId").val(InsCliente.MonId);
	
	//PARA FICHA INGRESO
	$('#CmpConductor').val(InsCliente.CliNombre+" "+InsCliente.CliApellidoPaterno+" "+InsCliente.CliApellidoMaterno);
	

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

	FncClienteFuncion(InsCliente);
	
}

function FncClienteFuncion(InsCliente){
	
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

	var Ancho = $( window ).width();
	var Alto = $( window ).height();

	Ancho = Ancho - (Ancho*(0.3));
	Alto = Alto - (Alto*(0.2));
	
	tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&ClienteId='+ClienteId+'&Id='+ClienteId+'&ClienteNombre='+ClienteNombre+'&TipoDocumentoId='+TipoDocumentoId+'&ClienteNumeroDocumento='+ClienteNumeroDocumento+'&ClienteDireccion='+ClienteDireccion+'&ClienteTipoId='+ClienteTipoId+'&ClienteEmail='+ClienteEmail+'&ClienteTelefono='+ClienteTelefono+'&ClienteCelular='+ClienteCelular+'&ClienteCelular='+ClienteCelular+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(Alto)+'&width='+(Ancho)+'&modal=true',this.rel);	
	//tb_show(this.title,'principal2.php?Mod=VehiculoIngreso&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(screen.height-200)+'&width='+(screen.width-100)+'&modal=true',this.rel);		
		
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