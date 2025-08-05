// JavaScript Document


function FncValidar(){

	var Moneda = $("#CmpMoneda").val();
	var ProveedorId = $("#CmpProveedorId").val();
	var ProveedorNombre = $("#CmpProveedorNombre").val();
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
		
		if(Moneda == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#CmpMoneda").focus();
					}
				});
				
			return false;
			
		}else if(ProveedorId == "" && ProveedorNombre !=""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Ingresa nuevamente el proveedor",
					callback: function(result){
						$("#CmpMoneda").focus();
					}
				});
				
			return false;
			
		}else if(ProveedorNombre == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un proveedor",
					callback: function(result){
						$("#CmpMoneda").focus();
					}
				});
				
			return false;
			
}else if(FechaInicio == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de inicio",
					callback: function(result){
						$("#CmpMoneda").focus();
					}
				});
				
			return false;
			
}else if(FechaFin == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de termino",
					callback: function(result){
						$("#CmpMoneda").focus();
					}
				});
				
			return false;
			
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmReporteClienteLineaCredito').on('submit', function() {
	
		return FncValidar();

	});

/*
* EVENTOS - NAVEGACION
*/		

	
});




function FncReporteClienteLineaCreditoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action;
	
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).target = '_blank';
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).submit();
	
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).target = 'IfrReporteClienteLineaCredito'+oIndice;
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action = Accion;
	
}

function FncReporteClienteLineaCreditoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action;
	
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).target = '_blank';
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).submit();
	
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).target = 'IfrReporteClienteLineaCredito'+oIndice;
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action = Accion;
	
}



function FncReporteClienteLineaCreditoNuevo(){


	
				
}
