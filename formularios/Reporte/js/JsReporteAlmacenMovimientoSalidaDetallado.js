// JavaScript Document
function FncReporteAlmacenMovimientoSalidaDetalladoValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
	var ProductoTipo = $("#CmpProductoTipo").val();
	var TipoSalida = $("#CmpTipoSalida").val();
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteAlmacenMovimientoSalidaDetalladoVer(){
	
	if(FncReporteAlmacenMovimientoSalidaDetalladoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Moneda = $("#CmpMoneda").val();
		var ProductoTipo = $("#CmpProductoTipo").val();
		var TipoSalida = $("#CmpTipoSalida").val();
		
		$('#CapReporteAlmacenMovimientoSalidaDetallado').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteAlmacenMovimientoSalidaDetallado.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Moneda="+Moneda+"&ProductoTipo="+ProductoTipo+"&TipoSalida="+TipoSalida,
			success: function(html){
				$('#CapReporteAlmacenMovimientoSalidaDetallado').html(html);	
			}
		});

	}

}


function FncReporteAlmacenMovimientoSalidaDetalladoImprimir(){
	
	if(FncReporteAlmacenMovimientoSalidaDetalladoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Moneda = $("#CmpMoneda").val();
		var ProductoTipo = $("#CmpProductoTipo").val();
		var TipoSalida = $("#CmpTipoSalida").val();

		FncPopUp("formularios/Reporte/IfrReporteAlmacenMovimientoSalidaDetallado.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Moneda="+Moneda+"&ProductoTipo="+ProductoTipo+"&TipoSalida="+TipoSalida+"&P=1");
	
	}

}

function FncReporteAlmacenMovimientoSalidaDetalladoGenerarExcel(){
	
	if(FncReporteAlmacenMovimientoSalidaDetalladoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Moneda = $("#CmpMoneda").val();
		var ProductoTipo = $("#CmpProductoTipo").val();
		var TipoSalida = $("#CmpTipoSalida").val();	
		
		FncPopUp("formularios/Reporte/XLSReporteAlmacenMovimientoSalidaDetallado.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Moneda="+Moneda+"&ProductoTipo="+ProductoTipo+"&TipoSalida="+TipoSalida+"&P=2");
		
	}
	
}

function FncReporteAlmacenMovimientoSalidaDetalladoNuevo(){

}

$().ready(function() {

	$('#BtnVer').on('click', function() {
	
		FncReporteAlmacenMovimientoSalidaDetalladoVer();	
	
	});
	
	$('#BtnImprimir').on('click', function() {
	
		FncReporteAlmacenMovimientoSalidaDetalladoImprimir();	
	
	});
	
		$('#BtnExcel').on('click', function() {
	
		FncReporteAlmacenMovimientoSalidaDetalladoGenerarExcel();	
	
	});

	
/*
* EVENTOS - NAVEGACION
*/		
	
});


// JavaScript Document


//
//function FncReporteAlmacenMovimientoSalidaDetalladoVer(){
//	
//	//doIframe();
//	
//}
//
//function FncReporteAlmacenMovimientoSalidaDetalladoImprimir(oIndice){
//	var Accion = document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).action;
//	
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).submit();
//	
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).target = 'IfrReporteAlmacenMovimientoSalidaDetallado'+oIndice;
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).action = Accion;
//	
//}
//
//function FncReporteAlmacenMovimientoSalidaDetalladoGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).action;
//	
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).submit();
//	
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).target = 'IfrReporteAlmacenMovimientoSalidaDetallado'+oIndice;
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaDetallado'+oIndice).action = Accion;
//	
//}
//
//function FncReporteAlmacenMovimientoSalidaDetalladoNuevo(){
//
//				
//}


