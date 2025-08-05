// JavaScript Document

function FncValidar(){

	var Sucursal = $("#CmpSucursal").val();
	var Nombre = $("#CmpNombre").val();

		if(Sucursal == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre",
					callback: function(result){
						$("#CmpNombre").focus();
					}
				});
				
			return false;
		
		}else if(Sucursal == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una sucursal",
					callback: function(result){
						$("#CmpSucursal").focus();
					}
				});
				
			return false;
		
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpSucursal").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpSucursal").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});




function FncDepartamentoFuncion(){
	
	console.log("FncDepartamentoFuncion2");
	
	FncProvinciasCargar();
	
}



function FncProvinciaFuncion(){
	
	console.log("FncProvinciaFuncion");
	
	FncDistritosCargar();
	
	
}
