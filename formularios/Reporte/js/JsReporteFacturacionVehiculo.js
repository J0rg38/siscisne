// JavaScript Document

// JavaScript Document

var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";
var Filtro = "";

var VehiculoMarca = "";
var CostoDetalle = "";
var Observado = "";

var Orden = "";
var Sentido = "";

var Variables = "";

function FncObtenerVariables(){

	Moneda = $("#CmpMoneda").val();
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	Sucursal = $("#CmpSucursal").val();
	Filtro = $("#CmpFiltro").val();
	
	
	VehiculoMarca = $("#CmpVehiculoMarca").val();
	CostoDetalle = $("#CmpCostoDetalle").val();
	Observado = $("#CmpObservado").val();


	Orden = $("#CmpOrden").val();
	Sentido = $("#CmpSentido").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpSucursal="+Sucursal+"&CmpFiltro="+Filtro+"&CmpVehiculoMarca="+VehiculoMarca+"&CmpCostoDetalle="+CostoDetalle+"&CmpObservado="+Observado+"&CmpOrden="+Orden+"&CmpSentido="+Sentido;	
	
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
			FncReporteFacturacionVehiculoVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteFacturacionVehiculoImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteFacturacionVehiculoGenerarExcel('');
		}
	});
	
	
	//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	 
	Ancho = Ancho - (Ancho*(0.08));
	 
	$('.EstReporteCapaListado').width(Ancho);
	
	
	
	
//
});





function FncReporteFacturacionVehiculoImprimir(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmReporteFacturacionVehiculo'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncReporteFacturacionVehiculoGenerarExcel(oIndice){
	
	
	FncObtenerVariables();
	
	var Accion =  "formularios/Reporte/XLSReporteFacturacionVehiculo.php";
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
	
}

function FncReporteFacturacionVehiculoVer(oIndice){
	
		
		FncObtenerVariables();
		
		$('#CapReporteFacturacionVehiculo').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteFacturacionVehiculo.php',
			//data: "Moneda="+Moneda+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Orden="+Orden+"&Sentido="+Sentido+"&ClienteNumeroDocumento="+ClienteNumeroDocumento+"&ClienteNombre="+ClienteNombre+"&ClienteId="+ClienteId,
			data: Variables,
			
			success: function(html){
				$('#CapReporteFacturacionVehiculo').html(html);	
			}
		});

	//}
	
	//document.getElementById('FrmReporteFacturacionVehiculo'+oIndice).submit();
	
}









//
//function FncReporteFacturacionVehiculoValidar(){
//	
//	var respuesta = true
//	var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	var Sucursal = $("#CmpSucursal").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	var CostoDetalle = $("#CmpCostoDetalle").val();
//	var Observado = $("#CmpObservado").val();
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
//function FncReporteFacturacionVehiculoVer(){
//	
//	if(FncReporteFacturacionVehiculoValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Sucursal = $("#CmpSucursal").val();
//		var VehiculoMarca = $("#CmpVehiculoMarca").val();
//		var CostoDetalle = $("#CmpCostoDetalle").val();
//		var Observado = $("#CmpObservado").val();
//		
//		$('#CapReporteFacturacionVehiculo').html("Cargando...");	
//		
//		$.ajax({
//			type: 'GET',
//			url: 'formularios/Reporte/IfrReporteFacturacionVehiculo.php',
//			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&CostoDetalle="+CostoDetalle+"&Observado="+Observado,
//			success: function(html){
//				$('#CapReporteFacturacionVehiculo').html(html);	
//			}
//		});
//
//	}
//
//}
//
//
//function FncReporteFacturacionVehiculoImprimir(){
//	
//	if(FncReporteFacturacionVehiculoValidar()){
//
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Sucursal = $("#CmpSucursal").val();
//		var VehiculoMarca = $("#CmpVehiculoMarca").val();
//		var CostoDetalle = $("#CmpCostoDetalle").val();
//		var Observado = $("#CmpObservado").val();
//		
//		FncPopUp("formularios/Reporte/IfrReporteFacturacionVehiculo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&CostoDetalle="+CostoDetalle+"&Observado="+Observado+"&P=1");
//	
//	}
//
//}
//
//function FncReporteFacturacionVehiculoGenerarExcel(){
//	
//	if(FncReporteFacturacionVehiculoValidar()){
//		
//			var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//		var Sucursal = $("#CmpSucursal").val();
//		var VehiculoMarca = $("#CmpVehiculoMarca").val();
//		var CostoDetalle = $("#CmpCostoDetalle").val();
//		var Observado = $("#CmpObservado").val();
//		
//		FncPopUp("formularios/Reporte/XLSReporteFacturacionVehiculo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&CostoDetalle="+CostoDetalle+"&Observado="+Observado+"&P=2");
//		
//	}
//	
//}
//
//function FncReporteFacturacionVehiculoNuevo(){
//
//}
