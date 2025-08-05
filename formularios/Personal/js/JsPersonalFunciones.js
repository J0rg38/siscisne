// JavaScript Document



function FncValidar(){

	var PersonalNombre = $("#CmpNombre").val();
	var PersonalApellidoPaterno = $("#CmpPersonalPaterno").val();
	var PersonalApellidoMaterno = $("#CmpPersonalMaterno").val();
	var PersonalNumeroDocumento = $("#CmpNumeroDocumento").val();
	var TipoDocumento = $("#CmpTipoDocumento").val();
	var TipoDocumento = $("#CmpTipoDocumento").val();
	
	var PersonalDireccion = $("#CmpDireccion").val();
	var PersonalDistrito = $("#CmpDistrito").val();
	var PersonalProvincia = $("#CmpProvincia").val();
	var PersonalDepartamento = $("#CmpDepartamento").val();
	var PersonalPais = $("#CmpPais").val();
	var PersonalEmail = $("#CmpEmail").val();
	var PersonalCelular = $("#CmpCelular").val();
	var PersonalTelefono = $("#CmpTelefono").val();
	
	var PersonalFechaNacimiento = $("#CmpFechaNacimiento").val();

	if(PersonalNombre == ""){		
		
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
	
	}else if(TipoDocumento == "TDO-10001" && PersonalApellidoPaterno == ""){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar el apellido paterno",
				callback: function(result){
					$("#CmpPersonalPaterno").focus();
				}
			});	
	
	}else if(TipoDocumento == "TDO-10001" && PersonalApellidoMaterno == ""){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar el apellido materno",
				callback: function(result){
					$("#CmpPersonalMaterno").focus();
				}
			});
	
		return false;
	
	}else if(TipoDocumento=="TDO-10003" && (PersonalNumeroDocumento.strlength < 11 || PersonalNumeroDocumento.strlength > 11) ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El numero de documento debe tener 11 digitos",
				callback: function(result){
					$("#CmpNumeroDocumento").focus();
				}
			});
	
		return false;
	}else if(TipoDocumento =="TDO-10001" && (PersonalNumeroDocumento.strlength < 8 || PersonalNumeroDocumento.strlength > 8) ){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El numero de documento debe tener 8 digitos",
				callback: function(result){
					$("#CmpNumeroDocumento").focus();
				}
			});
	
		return false;
	
	/*}else if(PersonalDireccion ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar una direccion",
				callback: function(result){
					$("#CmpDireccion").focus();
				}
			});
			
		return false;
		
	}else if(PersonalDistrito ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un distrito",
				callback: function(result){
					$("#CmpDistrito").focus();
				}
			});
		return false;
		
	}else if(PersonalProvincia ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un distrito",
				callback: function(result){
					$("#CmpProvincia").focus();
				}
			});
			
		return false;
		
	}else if(PersonalDepartamento ==""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un departamento",
				callback: function(result){
					$("#CmpDepartamento").focus();
				}
			});
		
		return false;
	
	
	}else if(PersonalCelular == "" && PersonalTelefono == ""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de celular o teléfono",
				callback: function(result){
					$("#CmpCelular").focus();
				}
			});
		
		return false;*/
		
	}else if(PersonalCelular != "" && FncValidarCelular(PersonalCelular) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de celular valido",
				callback: function(result){
					$("#CmpCelular").select();
				}
			});
		
		return false;
		
		}else if(PersonalTelefono != "" && FncValidarTelefono(PersonalTelefono) == false ){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un número de teléfono valido",
				callback: function(result){
					$("#CmpTelefono").select();
				}
			});
		
		return false;
		
		
		
	}else if(PersonalEmail == ""){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un correo electronico",
				callback: function(result){
					$("#CmpEmail").focus();
				}
			});
		
		return false;
		
	}else if(PersonalEmail !="" && FncValidarEmail(PersonalEmail)==false){
		
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El correo electronico no es valido",
				callback: function(result){
					$("#CmpEmail").select();
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





function FncCargarPersonalTipos(){
	
	
	$.getJSON("comunes/PersonalTipo/JnPersonalTipos.php",{}, function(j){
		$("select#CmpTipo").html("");
		
		var options = "";
		for (var i = 0; i < j.length; i++) {
			options += '<option value="' + j[i].PtiId + '">' + j[i].PtiNombre + '</option>';			
		}
		$("select#CmpTipo").html(options);
	})
	
}



function FncDepartamentoFuncion(){
	
	console.log("FncDepartamentoFuncion2");
	
	FncProvinciasCargar();
	
}



function FncProvinciaFuncion(){
	
	console.log("FncProvinciaFuncion");
	
	FncDistritosCargar();
	
	
}

