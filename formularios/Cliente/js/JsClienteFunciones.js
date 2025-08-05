// JavaScript Document

function FncValidar(){

	var ClienteNombre = $("#CmpNombre").val();
	var ClienteApellidoPaterno = $("#CmpApellidoPaterno").val();
	var ClienteApellidoMaterno = $("#CmpApellidoMaterno").val();
	var ClienteNumeroDocumento = $("#CmpNumeroDocumento").val();
	var TipoDocumento = $("#CmpTipoDocumento").val();
	var Tipo = $("#CmpTipo").val();
	
	var ClienteDireccion = $("#CmpDireccion").val();
	var ClienteDistrito = $("#CmpDistrito").val();
	var ClienteProvincia = $("#CmpProvincia").val();
	var ClienteDepartamento = $("#CmpDepartamento").val();
	var ClientePais = $("#CmpPais").val();
	var ClienteEmail = $("#CmpEmail").val();
	var ClienteCelular = $("#CmpCelular").val();
	var ClienteTelefono = $("#CmpTelefono").val();
	
	var ClienteFechaNacimiento = $("#CmpFechaNacimiento").val();
	var ClienteContactoEmail1 = $("#CmpContactoEmail1").val();
	var ClienteContactoEmail2 = $("#CmpContactoEmail2").val();
	var ClienteContactoEmail3 = $("#CmpContactoEmail3").val();
	
	var ClienteContactoCelular1 = $("#CmpContactoCelular1").val();
	var ClienteContactoCelular2 = $("#CmpContactoCelular2").val();
	var ContactoCelular3 = $("#CmpContactoCelular3").val();

	var TipoReferido = $("#CmpTipoReferido").val();
	
	

	if(ClienteNombre == ""){		
		
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
	
	}else if(TipoDocumento == "TDO-10001" && ClienteApellidoPaterno == ""){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar el apellido paterno",
				callback: function(result){
					$("#CmpApellidoPaterno").focus();
				}
			});	
	
	}else if(TipoDocumento == "TDO-10001" && ClienteApellidoMaterno == ""){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar el apellido materno",
				callback: function(result){
					$("#CmpApellidoMaterno").focus();
				}
			});
	
		return false;
	
	}else if(TipoDocumento=="TDO-10003" && (ClienteNumeroDocumento.strlength < 11 || ClienteNumeroDocumento.strlength > 11) ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El numero de documento debe tener 11 digitos",
				callback: function(result){
					$("#CmpNumeroDocumento").focus();
				}
			});
	
		return false;
	}else if(TipoDocumento =="TDO-10001" && (ClienteNumeroDocumento.strlength < 8 || ClienteNumeroDocumento.strlength > 8) ){
	
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
			
	}else if(ClienteDireccion ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar una direccion",
				callback: function(result){
					$("#CmpDireccion").focus();
				}
			});
			
		return false;
		
	}else if(ClienteDistrito ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un distrito",
				callback: function(result){
					$("#CmpDistrito").focus();
				}
			});
		return false;
		
	}else if(ClienteProvincia ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un distrito",
				callback: function(result){
					$("#CmpProvincia").focus();
				}
			});
			
		return false;
		
	}else if(ClienteDepartamento ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un departamento",
				callback: function(result){
					$("#CmpDepartamento").focus();
				}
			});
		
		return false;
	
	
	}else if(ClienteCelular == "" && ClienteTelefono == ""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de celular o teléfono",
				callback: function(result){
					$("#CmpCelular").focus();
				}
			});
		
		return false;
		
	}else if(ClienteCelular != "" && FncValidarCelular(ClienteCelular) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de celular valido",
				callback: function(result){
					$("#CmpCelular").select();
				}
			});
		
		return false;
		
		}else if(ClienteTelefono != "" && FncValidarTelefono(ClienteTelefono) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de teléfono valido",
				callback: function(result){
					$("#CmpTelefono").select();
				}
			});
		
		return false;
		
		
		
/*	}else if(ClienteEmail == ""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un correo electronico",
				callback: function(result){
					$("#CmpEmail").focus();
				}
			});
		
		return false;
*/		
		}else if(ClienteEmail !="" && FncValidarEmail(ClienteEmail)==false){
		
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
	
	 
	}else if(ClienteContactoCelular1 != "" && FncValidarCelular(ClienteContactoCelular1) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El número de celular de contacto 1 no es valido",
				callback: function(result){
					$("#CmpContactoCelular1").select();
				}
			});
		
		return false;
			 
	}else if(ClienteContactoCelular2 != "" && FncValidarCelular(dClienteContactoCelular2) == false ){
		
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
			
	var ClienteUso = $("#CmpClienteUso").val();
	var ClienteBloquear = $("#CmpClienteBloquear").val();
	
	if(ClienteUso == "PRINCIPAL" || ClienteUso == "RESTRINGIDO"){
		
		$("input,select,textarea").keypress(function (event) {  
		
			alert("Este CLIENTE no puede ser editado");
			
		}); 
		
		
		$("input").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
	
		$("select").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
		
		$("textarea").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
			
	}
	
	
	if(ClienteBloquear == "1"){
		
		$("input,select,textarea").keypress(function (event) {  
		
			alert("Este cliente  ha sido bloqueado y no puede ser editado");
			
		}); 
		
		
		$("input").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
	
		$("select").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
		
		$("textarea").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
		
	
	}
	
/*
Agregando Eventos
*/

});


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
		FncClienteEstablecerMoneda();
	});
	
		
/*
Agregando Eventos
*/

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

function FncClienteEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpTipoCambioFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		//FncClienteDetalleListar();
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





//
//
///*
//* PUNTO PARTIDA
//*/
//
///*
//* DEPARTAMENTO
//*/
//function FncPuntoPartidaDepartamentosCargar(){
//	
//	var DepartamentoAux = $("#CmpPuntoPartidaDepartamentoAux").val();
//	var ProvinciaAux = $("#CmpPuntoPartidaProvinciaAux").val();
//	
//	if(PuntoPartidaDepartamentoHabilitado==1){
//		$('#CmpPuntoPartidaDepartamento').removeAttr('disabled');
//	}else{
//		$('#CmpPuntoPartidaDepartamento').attr('disabled', 'disabled');
//	}
//	
//	$("select#CmpPuntoPartidaDepartamento").html('<option value="">Escoja una opcion</option>');
//	
//	$.getJSON("comunes/Ubigeo/jn/JnDepartamentos.php",{Departamento:1}, function(j){
//		
//		var options = '';
//		options += '<option value="">Escoja una opcion</option>';			
//		
//		if(j.length!=0){
//			
//			for (var i = 0; i < j.length; i++) {
//			//	console.log(DepartamentoAux+" = "+j[i].UbiDepartamento);
//				if(DepartamentoAux == j[i].UbiDepartamento){
//					options += '<option selected="selected" value="' + j[i].UbiDepartamento + '">' + j[i].UbiDepartamento + '</option>';					
//				}else{
//					options += '<option value="' + j[i].UbiDepartamento + '">' + j[i].UbiDepartamento + '</option>';				
//				}
//			}
//			
//		}else{
//		
//			alert("No se encontraron departamentos");
//			
//		}
//		
//		$("select#CmpPuntoPartidaDepartamento").html(options);
//	
//		$("select#CmpPuntoPartidaDepartamento").unbind();	
//		$("select#CmpPuntoPartidaDepartamento").change(function(){
//	
//			FncPuntoPartidaProvinciasCargar();
//	
//		});
//		
//		if(ProvinciaAux!=""){
//			FncPuntoPartidaProvinciasCargar();
//		}
//		
//		
//	});		
//		
//	
//}
//
//
///*
//* PROVINCIAS
//*/
//
//function FncPuntoPartidaProvinciasCargar(){
//	
//	var Departamento = $("#CmpPuntoPartidaDepartamento").val();
//	var ProvinciaAux = $("#CmpPuntoPartidaProvinciaAux").val();
//	var DistritoAux = $("#CmpPuntoPartidaDistritoAux").val();
//	
//	if(PuntoPartidaProvinciaHabilitado==1){
//		$('#CmpPuntoPartidaProvincia').removeAttr('disabled');
//	}else{
//		$('#CmpPuntoPartidaProvincia').attr('disabled', 'disabled');
//	}
//	
//	if(Departamento != ""){
//
//		$("select#CmpPuntoPartidaProvincia").html('<option value="">Escoja una opcion</option>');
//
//		$.getJSON("comunes/Ubigeo/jn/JnProvincias.php",{Departamento: Departamento}, function(j){
//			
//			var options = '';
//			options += '<option value="">Escoja una opcion</option>';			
//			
//			if(j.length!=0){
//				
//				for (var i = 0; i < j.length; i++) {
//					
//					if(ProvinciaAux == j[i].UbiProvincia){
//						options += '<option selected="selected" value="' + j[i].UbiProvincia + '">' + j[i].UbiProvincia + '</option>';					
//					}else{
//						options += '<option value="' + j[i].UbiProvincia + '">' + j[i].UbiProvincia + '</option>';	
//					}
//				}
//				
//			}else{
//			
//				alert("No se encontraron provincias");
//				
//			}
//			
//			$("select#CmpPuntoPartidaProvincia").html(options);
//			
//			$("select#CmpPuntoPartidaProvincia").unbind();	
//			$("select#CmpPuntoPartidaProvincia").change(function(){
//
//				FncPuntoPartidaDistritosCargar();
//		
//			});
//			
//			if(DistritoAux!=""){
//				FncPuntoPartidaDistritosCargar();
//			}
//			
//		});		
//		
//	}else{
//
//		$("select#CmpPuntoPartidaProvincia").html("");
//
//	}
//}
//
//
///*
//* DISTRITO
//*/
//
//
//
//function FncPuntoPartidaDistritosCargar(){
//	
//	var Provincia = $("#CmpPuntoPartidaProvincia").val();
//	var DistritoAux = $("#CmpPuntoPartidaDistritoAux").val();
//	
//	if(PuntoPartidaDistritoHabilitado==1){
//		$('#CmpPuntoPartidaDistrito').removeAttr('disabled');
//	}else{
//		$('#CmpPuntoPartidaDistrito').attr('disabled', 'disabled');
//	}
//	
//	if(Provincia != ""){
//
//		$("select#CmpPuntoPartidaDistrito").html('<option value="">Escoja una opcion</option>');
//
//		$.getJSON("comunes/Ubigeo/jn/JnDistritos.php",{Provincia: Provincia}, function(j){
//			
//			var options = '';
//			options += '<option value="">Escoja una opcion</option>';			
//			
//			if(j.length!=0){
//				
//				for (var i = 0; i < j.length; i++) {
//					
//					if(DistritoAux == j[i].UbiDistrito){
//						options += '<option selected="selected" value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';					
//					}else{
//						options += '<option value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';	
//					}
//				}
//				
//			}else{
//			
//				alert("No se encontraron distritos");
//				
//			}
//			
//			$("select#CmpPuntoPartidaDistrito").html(options);
//			
//			$("select#CmpPuntoPartidaDistrito").unbind();		
//			$("select#CmpPuntoPartidaDistrito").change(function(){
//
//				$.ajax({
//					type: 'GET',
//					dataType: 'json',
//					url: Ruta+'comunes/Ubigeo/jn/JnDistrito.php',
//					data: 'Distrito='+$(this).val(),
//					success: function(InsDistrito){
//												
//						if(InsDistrito.UbiId!="" & InsDistrito.UbiId!=null){
//							//FncVehiculoEscoger(InsVehiculo.VehId,InsVehiculo.VmaNombre,InsVehiculo.VmoNombre,InsVehiculo.VveNombre,InsVehiculo.VtiNombre,InsVehiculo.VehColor);
//							$("#CmpPuntoPartidaCodigoUbigeo").val(InsDistrito.UbiCodigo);
//							
//						}else{
//							$("#CmpPuntoPartidaCodigoUbigeo").val("");
//							//$('#CmpVehiculo'+oCampo).focus();
//							//$('#CmpVehiculo'+oCampo).select();						
//						}
//						
//					}
//				});
//		
//			});
//			
//			
//		});		
//		
//	}else{
//
//		$("select#CmpPuntoPartidaDistrito").html("");
//
//	}
//}