// JavaScript Document



var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";

var Orden = "";
var Sentido = "";

var Variables = "";

function FncObtenerVariables(){

	Moneda = $("#CmpMoneda").val();
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	Sucursal = $("#CmpSucursal").val();
	Filtro = $("#CmpFiltro").val();
	
	Orden = $("#CmpOrden").val();
	Sentido = $("#CmpSentido").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpSucursal="+Sucursal+"&CmpFiltro="+Filtro+"&CmpOrden="+Orden+"&CmpSentido="+Sentido;	
	
}


function FncValidar(){
	
	var respuesta = true
	
	FncObtenerVariables();
	
	/*if(Moneda==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una moneda.",
				callback: function(result){
					$("#CmpMoneda").focus();
				}
			});
			
		respuesta = false;
			
	}else */if(FechaInicio==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una fecha de inicio.",
				callback: function(result){
					$("#CmpFechaInicio").focus();
				}
			});	respuesta = false;		
		
	}else if(FechaFin==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una fecha fin.",
				callback: function(result){
					$("#CmpFechaFin").focus();
				}
			});	respuesta = false;

	}
	
	return respuesta;
	
}




$().ready(function() {

	$('#BtnVer').on('click', function() {
		if(FncValidar()){
			FncReportePedidoCompraDetalleVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReportePedidoCompraDetalleImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReportePedidoCompraDetalleGenerarExcel('');
		}
	});

});





function FncReportePedidoCompraDetalleImprimir(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReportePedidoCompraDetalle'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReportePedidoCompraDetalleGenerarExcel(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReportePedidoCompraDetalle'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReportePedidoCompraDetalleVer(oIndice){
	
	document.getElementById('FrmReportePedidoCompraDetalle'+oIndice).submit();
	
}


