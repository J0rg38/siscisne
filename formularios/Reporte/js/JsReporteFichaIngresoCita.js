// JavaScript Document
var Taller = "1";


var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";

var Filtro = "";

var Modalidad = "";
var VehiculoMarca = "";
var Personal = "";

var Orden = "";
var Sentido = "";

var Variables = "";
 

	
	
function FncObtenerVariables(){

	Moneda = $("#CmpMoneda").val();
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	Sucursal = $("#CmpSucursal").val();
	
	Filtro = $("#CmpFiltro").val();
	
	Modalidad = $("#CmpModalidad").val();
	VehiculoMarca = $("#CmpVehiculoMarca").val();
	Personal = $("#CmpPersonal").val();
		 
	 
	Orden = $("#CmpOrden").val();
	Sentido = $("#CmpSentido").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpSucursal="+Sucursal+"&CmpFiltro="+Filtro+"&CmpModalidad="+Modalidad+"&CmpVehiculoMarca="+VehiculoMarca+"&CmpPersonal="+Personal+"&CmpOrden="+Orden+"&CmpSentido="+Sentido;	
	
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
			FncReporteFichaIngresoCitaVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteFichaIngresoCitaImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteFichaIngresoCitaGenerarExcel('');
		}
	});
	
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	 
	Ancho = Ancho - (Ancho*(0.08));
	 
	$('.EstReporteCapaListado').width(Ancho);
	
	
	
	
//
});





function FncReporteFichaIngresoCitaImprimir(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReporteFichaIngresoCita'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReporteFichaIngresoCitaGenerarExcel(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion =  "formularios/Reporte/XLSReporteFichaIngresoCita.php";
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
	
}

function FncReporteFichaIngresoCitaVer(oIndice){
	
	
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
		
		$('#CapReporteFichaIngresoCita').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteFichaIngresoCita.php',
			//data: "Moneda="+Moneda+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Orden="+Orden+"&Sentido="+Sentido+"&ClienteNumeroDocumento="+ClienteNumeroDocumento+"&ClienteNombre="+ClienteNombre+"&ClienteId="+ClienteId,
			data: Variables,
			
			success: function(html){
				$('#CapReporteFichaIngresoCita').html(html);	
			}
		});

	//}
	
	//document.getElementById('FrmReporteFichaIngresoCita'+oIndice).submit();
	
}





//
//
//
//
//function FncReporteFichaIngresoCitaValidar(){
//	
//	var respuesta = true
//	
//	var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	var Sucursal = $("#CmpSucursal").val();
//	
//	var Modalidad = $("#CmpModalidad").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var Personal = $("#CmpPersonal").val();
//	var Orden = $("#CmpOrden").val();
//	var Sentido = $("#CmpSentido").val();
//	
//	if(FechaInicio==""){
//		alert("No ha escogido una fecha de inicio.");
//		respuesta = false;
//	}else if(FechaFin==""){
//		alert("No ha escogido una fecha fin.");
//		respuesta = false;
//	
//	}
//	
//	return respuesta;
//	
//}
//
//function FncReporteFichaIngresoCitaVer(){
//	
//	if(FncReporteFichaIngresoCitaValidar()){
//		
//	var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	var Sucursal = $("#CmpSucursal").val();
//			
//	var Modalidad = $("#CmpModalidad").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var Personal = $("#CmpPersonal").val();
//	var Orden = $("#CmpOrden").val();
//	var Sentido = $("#CmpSentido").val();
//	
//		$('#CapReporteFichaIngresoCita').html("Cargando...");	
//		
//		$.ajax({
//			type: 'GET',
//			url: 'formularios/Reporte/IfrReporteFichaIngresoCita.php',
//			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Modalidad="+Modalidad+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Orden="+Orden+"&Sentido="+Sentido,
//			success: function(html){
//				$('#CapReporteFichaIngresoCita').html(html);	
//			}
//		});
//
//	}
//
//}
//
//function FncReporteFichaIngresoCitaImprimir(){
//	
//	if(FncReporteFichaIngresoCitaValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Sucursal = $("#CmpSucursal").val();
//		
//			
//	var Modalidad = $("#CmpModalidad").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var Personal = $("#CmpPersonal").val();
//	var Orden = $("#CmpOrden").val();
//	var Sentido = $("#CmpSentido").val();
//	
//		FncPopUp("formularios/Reporte/IfrReporteFichaIngresoCita.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Modalidad="+Modalidad+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Orden="+Orden+"&Sentido="+Sentido+"&P=1");
//		
//	}
//
//}
//
//function FncReporteFichaIngresoCitaGenerarExcel(){
//	
//	if(FncReporteFichaIngresoCitaValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Moneda = "";
//		var Sucursal = $("#CmpSucursal").val();
//		
//			
//	var Modalidad = $("#CmpModalidad").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var Personal = $("#CmpPersonal").val();
//	var Orden = $("#CmpOrden").val();
//	var Sentido = $("#CmpSentido").val();
//	
//		FncPopUp("formularios/Reporte/XLSReporteFichaIngresoCita.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Modalidad="+Modalidad+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Orden="+Orden+"&Sentido="+Sentido+"&P=2");
//		
//	}
//	
//}
//
//function FncReporteFichaIngresoCitaNuevo(){
//
//}
//
//
///*
//* Funciones complementarias
//*/
//$().ready(function() {
//
//	$('#BtnVer').on('click', function() {
//	
//		FncReporteFichaIngresoCitaVer();
//	
//	});
//	
//	$('#BtnImprimir').on('click', function() {
//	
//		FncReporteFichaIngresoCitaImprimir();
//	
//	});
//	
//	$('#BtnExcel').on('click', function() {
//	
//		FncReporteFichaIngresoCitaGenerarExcel();
//
//	});
//	
//	
//	$('#CmpSucursal').on('change', function() {
//	
//		FncPersonalesCargar();	
//	
//	});
//
//});

