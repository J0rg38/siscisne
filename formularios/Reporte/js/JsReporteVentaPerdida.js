// JavaScript Document


var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";
var Filtro = "";

var VehiculoMarca = "";
var Vista = "";
var Personal = "";

var Orden = "";
var Sentido = "";

var Variables = "";

	//	var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	var Sucursal = $("#CmpSucursal").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var Vista = $("#CmpVista").val();
//	var Personal = $("#CmpPersonal").val();

function FncObtenerVariables(){

	Moneda = $("#CmpMoneda").val();
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	Sucursal = $("#CmpSucursal").val();
	Filtro = $("#CmpFiltro").val();

	VehiculoMarca = $("#CmpVehiculoMarca").val();
	Vista = $("#CmpVista").val();
	Personal = $("#CmpPersonal").val();
	
	Orden = $("#CmpOrden").val();
	Sentido = $("#CmpSentido").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpSucursal="+Sucursal+"&CmpFiltro="+Filtro+"&CmpVehiculoMarca="+VehiculoMarca+"&CmpVista="+Vista+"&CmpPersonal="+Personal+"&CmpOrden="+Orden+"&CmpSentido="+Sentido;	
	
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
			FncReporteVentaPerdidaVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteVentaPerdidaImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteVentaPerdidaGenerarExcel('');
		}
	});
	
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	 
	Ancho = Ancho - (Ancho*(0.08));
	 
	$('.EstReporteCapaListado').width(Ancho);
	
	
	
	
//
});





function FncReporteVentaPerdidaImprimir(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReporteVentaPerdida'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReporteVentaPerdidaGenerarExcel(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion =  "formularios/Reporte/XLSReporteVentaPerdida.php";
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
	
}

function FncReporteVentaPerdidaVer(oIndice){
	 
		
		FncObtenerVariables();
		
		$('#CapReporteVentaPerdida').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteVentaPerdida.php',
			//data: "Moneda="+Moneda+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Orden="+Orden+"&Sentido="+Sentido+"&ClienteNumeroDocumento="+ClienteNumeroDocumento+"&ClienteNombre="+ClienteNombre+"&ClienteId="+ClienteId,
			data: Variables,
			
			success: function(html){
				$('#CapReporteVentaPerdida').html(html);	
			}
		});

	 
	
}




//function FncReporteVentaPerdidaValidar(){
//	
//	var respuesta = true
//	var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	var Sucursal = $("#CmpSucursal").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var Vista = $("#CmpVista").val();
//	var Personal = $("#CmpPersonal").val();
//	
//	if(FechaInicio==""){
//		alert("No ha escogido una fecha de inicio.");
//		respuesta = false;
//	}else if(FechaFin==""){
//		alert("No ha escogido una fecha fin.");
//		respuesta = false;
//	}
//	
//	return respuesta;
//	
//}
//
//function FncReporteVentaPerdidaVer(){
//	
//	if(FncReporteVentaPerdidaValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Sucursal = $("#CmpSucursal").val();
//		var VehiculoMarca = $("#CmpVehiculoMarca").val();
//		var Personal = $("#CmpPersonal").val();
//		
//		$('#CapReporteVentaPerdida').html("Cargando...");	
//		
//		$.ajax({
//			type: 'GET',
//			url: 'formularios/Reporte/IfrReporteVentaPerdida.php',
//			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal,
//			success: function(html){
//				$('#CapReporteVentaPerdida').html(html);	
//			}
//		});
//
//	}
//
//}
//
//
//function FncReporteVentaPerdidaImprimir(){
//	
//	if(FncReporteVentaPerdidaValidar()){
//
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Sucursal = $("#CmpSucursal").val();
//		var VehiculoMarca = $("#CmpVehiculoMarca").val();
//		
//var Personal = $("#CmpPersonal").val();
//
//		FncPopUp("formularios/Reporte/IfrReporteVentaPerdida.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&P=1");
//	
//	}
//
//}
//
//function FncReporteVentaPerdidaGenerarExcel(){
//	
//	if(FncReporteVentaPerdidaValidar()){
//		
//			var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Sucursal = $("#CmpSucursal").val();
//		var VehiculoMarca = $("#CmpVehiculoMarca").val();
//		
//		var Personal = $("#CmpPersonal").val();
//		
//		FncPopUp("formularios/Reporte/XLSReporteVentaPerdida.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&P=2");
//		
//	}
//	
//}
//
//function FncReporteVentaPerdidaNuevo(){
//
//}
