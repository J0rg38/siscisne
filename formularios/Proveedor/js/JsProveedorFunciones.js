// JavaScript Document

function FncValidar(){

	var ProveedorNombre = $("#CmpNombre").val();
	var ProveedorApellidoPaterno = $("#CmpProveedorPaterno").val();
	var ProveedorApellidoMaterno = $("#CmpProveedorMaterno").val();
	var ProveedorNumeroDocumento = $("#CmpNumeroDocumento").val();
	var TipoDocumento = $("#CmpTipoDocumento").val();
	var Tipo = $("#CmpTipo").val();
	
	var ProveedorDireccion = $("#CmpDireccion").val();
	var ProveedorDistrito = $("#CmpDistrito").val();
	var ProveedorProvincia = $("#CmpProvincia").val();
	var ProveedorDepartamento = $("#CmpDepartamento").val();
	var ProveedorPais = $("#CmpPais").val();
	var ProveedorEmail = $("#CmpEmail").val();
	var ProveedorCelular = $("#CmpCelular").val();
	var ProveedorTelefono = $("#CmpTelefono").val();
	
	var ProveedorFechaNacimiento = $("#CmpFechaNacimiento").val();
	var ProveedorContactoEmail1 = $("#CmpContactoEmail1").val();
	var ProveedorContactoEmail2 = $("#CmpContactoEmail2").val();
	var ProveedorContactoEmail3 = $("#CmpContactoEmail3").val();
	
	var ProveedorContactoCelular1 = $("#CmpContactoCelular1").val();
	var ProveedorContactoCelular2 = $("#CmpContactoCelular2").val();
	var ProveedorContactoCelular3 = $("#CmpContactoCelular3").val();

	if(ProveedorNombre == ""){		
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un nombre",
				callback: function(result){
					$("#CmpNombre").focus();
				}
			});

		return false;
	}else if(TipoDocumento == ""){			
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger un tipo de documento",
				callback: function(result){
					$("#CmpTipoDocumento").focus();
				}
			});
	
	}else if(TipoDocumento == "TDO-10001" && ProveedorApellidoPaterno == ""){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar el apellido paterno",
				callback: function(result){
					$("#CmpProveedorPaterno").focus();
				}
			});	
	
	}else if(TipoDocumento == "TDO-10001" && ProveedorApellidoMaterno == ""){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar el apellido materno",
				callback: function(result){
					$("#CmpProveedorMaterno").focus();
				}
			});
	
		return false;
	
	}else if(TipoDocumento=="TDO-10003" && (ProveedorNumeroDocumento.strlength < 11 || ProveedorNumeroDocumento.strlength > 11) ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El numero de documento debe tener 11 digitos",
				callback: function(result){
					$("#CmpNumeroDocumento").focus();
				}
			});
	
		return false;
	}else if(TipoDocumento =="TDO-10001" && (ProveedorNumeroDocumento.strlength < 8 || ProveedorNumeroDocumento.strlength > 8) ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El numero de documento debe tener 8 digitos",
				callback: function(result){
					$("#CmpNumeroDocumento").focus();
				}
			});
	
		return false;
		
	}else if(Tipo ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger un tipo de cliente",
				callback: function(result){
					$("#CmpNumeroDocumento").focus();
				}
			});
			return false;
			
	}else if(ProveedorDireccion ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar una direccion",
				callback: function(result){
					$("#CmpDireccion").focus();
				}
			});
			
		return false;
	/*	
	}else if(ProveedorDistrito ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un distrito",
				callback: function(result){
					$("#CmpDistrito").focus();
				}
			});
		return false;
		
	}else if(ProveedorProvincia ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un distrito",
				callback: function(result){
					$("#CmpProvincia").focus();
				}
			});
			
		return false;
		
	}else if(ProveedorDepartamento ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un departamento",
				callback: function(result){
					$("#CmpDepartamento").focus();
				}
			});
		
		return false;
	
	
	}else if(ProveedorCelular == "" && ProveedorTelefono == ""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de celular o teléfono",
				callback: function(result){
					$("#CmpCelular").focus();
				}
			});
		
		return false;
		
	}else if(ProveedorCelular != "" && FncValidarCelular(ProveedorCelular) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de celular valido",
				callback: function(result){
					$("#CmpCelular").select();
				}
			});
		
		return false;
		
		}else if(ProveedorTelefono != "" && FncValidarTelefono(ProveedorTelefono) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de teléfono valido",
				callback: function(result){
					$("#CmpTelefono").select();
				}
			});
		
		return false;*/
		
		
		
	/*}else if(ProveedorEmail == ""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un correo electronico",
				callback: function(result){
					$("#CmpEmail").focus();
				}
			});
		
		return false;*/
		
	}else if(ProveedorEmail !="" && FncValidarEmail(ProveedorEmail)==false){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El correo electronico no es valido",
				callback: function(result){
					$("#CmpEmail").select();
				}
			});
		
		return false;
		
		
		}else if(ClienteFechaNacimiento !="" && FncValidarFecha(ClienteFechaNacimiento)==false){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado una fecha de nacimiento valida",
				callback: function(result){
					$("#CmpFechaNacimiento").select();
				}
			});
		
		return false;
		
		
	}else if(ClienteContactoEmail1 !="" && FncValidarEmail(ClienteContactoEmail1)==false){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El correo electronico de conctacto 1 no es valido",
				callback: function(result){
					$("#CmpContactoEmail1").select();
				}
			});
		
		return false;
	}else if(ClienteContactoEmail2 !="" && FncValidarEmail(ClienteContactoEmail2)==false){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El correo electronico de conctacto 2 no es valido",
				callback: function(result){
					$("#CmpContactoEmail2").select();
				}
			});
		
		return false;
		
	}else if(ClienteContactoEmail3 !="" && FncValidarEmail(ClienteContactoEmail3)==false){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El correo electronico de conctacto 3 no es valido",
				callback: function(result){
					$("#CmpContactoEmail3").select();
				}
			});
		
		return false;
	
	 
	}else if(ContactoCelular1 != "" && FncValidarCelular(ContactoCelular1) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El número de celular de contacto 1 no es valido",
				callback: function(result){
					$("#CmpContactoCelular1").select();
				}
			});
		
		return false;
			 
	}else if(ContactoCelular2 != "" && FncValidarCelular(ContactoCelular2) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El número de celular de contacto 2 no es valido",
				callback: function(result){
					$("#CmpContactoCelular2").select();
				}
			});
		
		return false;
		
		
	}else if(ContactoCelular3 != "" && FncValidarCelular(ContactoCelular3) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El número de celular de contacto 3 no es valido",
				callback: function(result){
					$("#CmpContactoCelular3").select();
				}
			});
		
		return false;
		
	}else{
		return true;
	}
		
	
}


$().ready(function() {

	$('#FrmRegistrar').on('submit', function() {
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});



/*
*** EVENTOS
*/	

$().ready(function() {
/*
* EVENTOS - NAVEGACION
*/		

	
/*
* EVENTOS - INICIALES
*/	
	//COMUNES VEHICULO

	$("#CmpTipoDocumento").change(function(){
		FncTipoDocumentoEstablecer();
	});

	
		
/*
Agregando Eventos
*/

	$("select#CmpMonedaId").change(function(){
		FncProveedorEstablecerMoneda();
	});
	
	
});


function FncTipoDocumentoEstablecer(){
	
	var TipoDocumento = $("#CmpTipoDocumento").val();
	
	if(TipoDocumento=="TDO-10003"){
		$("#CmpApellidoPaterno").val("");
		$('#CmpApellidoPaterno').attr('readonly', true);	
		$("#CmpApellidoMaterno").val("");
		$('#CmpApellidoMaterno').attr('readonly', true);	
	}else{
		$('#CmpApellidoPaterno').removeAttr('readonly');
		$('#CmpApellidoMaterno').removeAttr('readonly');
	}

}






function FncProveedorEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpTipoCambioFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		//FncProveedorDetalleListar();
		//alert("Debe Escoger una moneda");
	}else{
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");
			}

		}
		FncMonedaBuscar('Id');
	}

}







function FncDepartamentoFuncion(){
	
	console.log("FncDepartamentoFuncion2");
	
	FncProvinciasCargar();
	
}



function FncProvinciaFuncion(){
	
	console.log("FncProvinciaFuncion");
	
	FncDistritosCargar();
	
	
}
