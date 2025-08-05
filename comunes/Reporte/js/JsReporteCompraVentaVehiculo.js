// JavaScript Document

function FncReporteCompraVentaVehiculoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).action;
	
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).submit();
	
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).target = 'IfrReporteCompraVentaVehiculo'+oIndice;
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).action = Accion;
	
}

function FncReporteCompraVentaVehiculoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).action;
	
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).submit();
	
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).target = 'IfrReporteCompraVentaVehiculo'+oIndice;
	document.getElementById('FrmReporteCompraVentaVehiculo'+oIndice).action = Accion;
	
}



function FncReporteCompraVentaVehiculoNuevo(){


	
				
}