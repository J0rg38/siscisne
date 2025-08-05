// JavaScript Document

function FncValidar(){

	var AlmacenId = $("#CmpAlmacenId").val();
	var StockMinimo = $("#CmpStockMinimo").val();
	var StockMaximo = $("#CmpStockMaximo").val();	

		if(AlmacenId == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un almacen",
					callback: function(result){
						$("#CmpAlmacenId").focus();
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
		
		$("#CmpAlmacenId").removeAttr('disabled');
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpSucursal").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');	
			$("#CmpAlmacenId").removeAttr('disabled');
			
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
