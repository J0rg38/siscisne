// JavaScript Document
//var Ventas = "1";
//var Libres = "1";

$().ready(function() {

	$('#BtnVer').on('click', function() {
	
		FncReporteProductoStockVer();
	
	});
	
	
	$('#BtnImprimir').on('click', function() {
	
		FncReporteProductoStockValidar();
	
	});
	
	
	$('#BtnExcel').on('click', function() {
	
		FncReporteProductoStockGenerarExcel();
	
	});

	
/*
* EVENTOS - NAVEGACION
*/		
	
});

function FncReporteProductoStockValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Sucursal = $("#CmpSucursal").val();
	var ProductoCategoria = $("#CmpProductoCategoria").val();
	var ProductoTipo = $("#CmpProductoTipo").val();
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();

	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}
	
	
	return respuesta;
	
}

function FncReporteProductoStockVer(){
	
	if(FncReporteProductoStockValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		var ProductoCategoria = $("#CmpProductoCategoria").val();
		var ProductoTipo = $("#CmpProductoTipo").val();
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
			
		$('#CapReporteProductoStock').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteProductoStock.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&ProductoCategoria="+ProductoCategoria+"&ProductoTipo="+ProductoTipo,
			success: function(html){
				$('#CapReporteProductoStock').html(html);	
			}
		});

	}

}


function FncReporteProductoStockImprimir(){
	
	if(FncReporteProductoStockValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Sucursal = $("#CmpSucursal").val();
	var ProductoCategoria = $("#CmpProductoCategoria").val();
	var ProductoTipo = $("#CmpProductoTipo").val();
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
		
		FncPopUp("formularios/Reporte/IfrReporteProductoStock.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&ProductoCategoria="+ProductoCategoria+"&ProductoTipo="+ProductoTipo+"&Orden="+Orden+"&Sentido="+Sentido+"&P=1");
	
	}

}

function FncReporteProductoStockGenerarExcel(){
	
	if(FncReporteProductoStockValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Sucursal = $("#CmpSucursal").val();
	var ProductoCategoria = $("#CmpProductoCategoria").val();
	var ProductoTipo = $("#CmpProductoTipo").val();
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
		
		FncPopUp("formularios/Reporte/XLSReporteProductoStock.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&ProductoCategoria="+ProductoCategoria+"&ProductoTipo="+ProductoTipo+"&Orden="+Orden+"&Sentido="+Sentido+"&P=2");
		
	}
	
}

function FncReporteProductoStockNuevo(){

}



/*

function FncReporteProductoStockImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteProductoStock'+oIndice).action;
	
	document.getElementById('FrmReporteProductoStock'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoStock'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteProductoStock'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoStock'+oIndice).target = 'IfrReporteProductoStock'+oIndice;
	document.getElementById('FrmReporteProductoStock'+oIndice).action = Accion;
	
}

function FncReporteProductoStockGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteProductoStock'+oIndice).action;
	
	document.getElementById('FrmReporteProductoStock'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoStock'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteProductoStock'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoStock'+oIndice).target = 'IfrReporteProductoStock'+oIndice;
	document.getElementById('FrmReporteProductoStock'+oIndice).action = Accion;
	
}



function FncReporteProductoStockNuevo(){


	
				
}*/
