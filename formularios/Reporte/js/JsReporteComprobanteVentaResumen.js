// JavaScript Document

var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";
var Filtro = "";

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
	
	
	
	
	
	
	if(FechaInicio==""){
	
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
			FncReporteComprobanteVentaResumenVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteComprobanteVentaResumenImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteComprobanteVentaResumenGenerarExcel('');
		}
	});
	
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	 
	Ancho = Ancho - (Ancho*(0.08));
	 
	$('.EstReporteCapaListado').width(Ancho);
	
	
	
	
//
});





function FncReporteComprobanteVentaResumenImprimir(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion =  "formularios/Reporte/IfrReporteComprobanteVentaResumen.php";
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReporteComprobanteVentaResumenGenerarExcel(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion =  "formularios/Reporte/XLSReporteComprobanteVentaResumen.php";
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
	
}

function FncReporteComprobanteVentaResumenVer(oIndice){
	
	
	//if(FncValidar()){
		//
//		var Moneda = $("#CmpMoneda").val();
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		
//		var Orden = $("#CmpOrden").val();
//		var Sentido = $("#CmpSentido").val();
//		var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
//		var ClienteNombre = $("#CmpClienteNombre").val();
//		var ClienteId = $("#CmpClienteId").val();
		
		FncObtenerVariables();
		
		$('#CapReporteComprobanteVentaResumen').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteComprobanteVentaResumen.php',
			//data: "Moneda="+Moneda+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Orden="+Orden+"&Sentido="+Sentido+"&ClienteNumeroDocumento="+ClienteNumeroDocumento+"&ClienteNombre="+ClienteNombre+"&ClienteId="+ClienteId,
			data: Variables,
			
			success: function(html){
				$('#CapReporteComprobanteVentaResumen').html(html);	
			}
		});

	//}
	
	//document.getElementById('FrmReporteComprobanteVentaResumen'+oIndice).submit();
	
}


