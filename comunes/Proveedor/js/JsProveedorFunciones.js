// JavaScript Document

$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

	if($("#CmpProveedorId").val()==""){
		$("#BtnProveedorEditar").hide();
		$("#BtnProveedorRegistrar").show();
	}else{
		$("#BtnProveedorEditar").show();
		$("#BtnProveedorRegistrar").hide();
	}
	
	$("#CmpProveedorNumeroDocumento").keyup(function (event) {  
	
		if($.trim($("#CmpProveedorNumeroDocumento").val())==""){
			FncProveedorNuevo();
		}
		
		 if (event.keyCode == '13' && this.value != "" && $("#CmpProveedorNombre").val()=="") {
			FncProveedorBuscar("NumeroDocumento")
		 }
	}); 

	$("#CmpProveedorNombre").keyup(function (event) { 
		if($.trim($("#CmpProveedorNombre").val())==""){
			FncProveedorNuevo();
		}
	});

});	

function FncProveedorNuevo(){
	
	$('#CmpProveedorId').val("");
	$('#CmpProveedorNumeroDocumento').val("");
	$('#CmpProveedorNombre').val("");
	$('#CmpProveedorDireccion').val("");
	$('#CmpProveedorTipoDocumento').val("");

	$('#CmpProveedorNumeroDocumento').removeAttr('readonly');
	$('#CmpProveedorNombre').removeAttr('readonly');
	$('#CmpProveedorDireccion').removeAttr('readonly');
	//$('#CmpProveedorTipoDocumento').removeAttr('disabled');
	
	
/*
* POPUP REGISTRAR/EDITAR
*/		
	$("#BtnProveedorEditar").hide();
	$("#BtnProveedorRegistrar").show();
	
	FncProveedorNuevoFuncion();

}

function FncProveedorNuevoFuncion(){
	
}

function FncProveedorBuscar(oCampo){

	var Dato = $('#CmpProveedor'+oCampo).val();
	
	if(Dato==""){		
		$('#CmpProveedor'+oCampo).focus();
		$('#CmpProveedor'+oCampo).select();
	}else{
	
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Proveedor/acc/AccProveedorBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsProveedor){
			if(InsProveedor.PrvId!=null){
				FncProveedorEscoger(InsProveedor.PrvId,InsProveedor.PrvNumeroDocumento,InsProveedor.PrvNombreCompleto,InsProveedor.PrvDireccion,InsProveedor.TdoId);
			}
		}
		});	
		

	}
		
}

function FncProveedorEscoger(oProveedorId,oProveedorNumeroDocumento,oProveedorNombreCompleto,oProveedorDireccion,oTdoId){
	
	$('#CapProveedorBuscar').html('');
	
	$('#CmpProveedorId').val(oProveedorId);
	$('#CmpProveedorNumeroDocumento').val(oProveedorNumeroDocumento);
	$('#CmpProveedorNombre').val(oProveedorNombreCompleto);
	$('#CmpProveedorDireccion').val(oProveedorDireccion);
	$('#CmpProveedorTipoDocumento').val(oTdoId);
	
	
	$('#CmpProveedorNumeroDocumento').attr('readonly', true);
	$('#CmpProveedorNombre').attr('readonly', true);
	$('#CmpProveedorDireccion').attr('readonly', true);
	$('#CmpProveedorTipoDocumento').attr('disabled', true);


	$("#BtnProveedorEditar").show();
	$("#BtnProveedorRegistrar").hide();
	
	FncProveedorFuncion();
}


function FncProveedorFuncion(){
	
}

/*
* Funciones PopUp Formulario
*/

function FncProveedorCargarFormulario(oForm){

	var ProveedorId = $('#CmpProveedorId').val();
	var ProveedorNombre = $('#CmpProveedorNombre').val();
	var TipoDocumentoId = $("#CmpProveedorTipoDocumento").val();
	var ProveedorNumeroDocumento = $('#CmpProveedorNumeroDocumento').val();

	tb_show(this.title,'principal2.php?Mod=Proveedor&Form='+oForm+'&Dia=1&ProveedorId='+ProveedorId+'&Id='+ProveedorId+'&ProveedorNombre='+ProveedorNombre+'&TipoDocumentoId='+TipoDocumentoId+'&ProveedorNumeroDocumento='+ProveedorNumeroDocumento+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

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

//function FncProveedorCargarBuscador(){
//
//	tb_show(this.title,'principal2.php?Mod=OrdenCompra&Form='+oForm+'&Dia=1&Id='+oOrdenCompraId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//
//	formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&width=850
//
//}


function FncProveedorFiltrar(e){
	if(window.event)keyCode=window.event.keyCode;
	
	else if(e) keyCode=e.which;
	
	if (keyCode==13){	
	
		FncProveedorFiltrar2();
	
	}
}

function FncProveedorFiltrar2(){
	
	var Campo = $('#CmpProveedorCampo').val();
	var Condicion = $('#CmpProveedorCondicion').val();
	var Filtro = $('#CmpFiltro').val();
	
	if(Filtro.length > 2){
			
		$.ajax({
			type: 'POST',
			dataType : 'html',
			url: 'comunes/Proveedor/FrmProveedorListado.php',
			data: 'Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
			success: function(html){
				$("#CapProveedores").html("");
				$("#CapProveedores").append(html);
			}
		});
				
	}else{
		alert("Ingrese al menos tres caracteres.");
	}
}




function FncProveedorListadorEscoger(oProveedorId){
	
	$('#CmpProveedorId').val(oProveedorId);
	FncProveedorBuscar("Id");
	tb_remove();
}