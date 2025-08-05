// JavaScript Document
function FncReporteAlmacenMovimientoSalidaResumenValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteAlmacenMovimientoSalidaResumenVer(){
	
	if(FncReporteAlmacenMovimientoSalidaResumenValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Moneda = $("#CmpMoneda").val();
		
		$('#CapReporteAlmacenMovimientoSalidaResumen').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteAlmacenMovimientoSalidaResumen.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Moneda="+Moneda,
			success: function(html){
				$('#CapReporteAlmacenMovimientoSalidaResumen').html(html);	
			}
		});

	}

}


function FncReporteAlmacenMovimientoSalidaResumenImprimir(){
	
	if(FncReporteAlmacenMovimientoSalidaResumenValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Moneda = $("#CmpMoneda").val();
		

		FncPopUp("formularios/Reporte/IfrReporteAlmacenMovimientoSalidaResumen.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Moneda="+Moneda+"&P=1");
	
	}

}

function FncReporteAlmacenMovimientoSalidaResumenGenerarExcel(){
	
	if(FncReporteAlmacenMovimientoSalidaResumenValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Moneda = $("#CmpMoneda").val();
		
		
		FncPopUp("formularios/Reporte/XLSReporteAlmacenMovimientoSalidaResumen.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Moneda="+Moneda+"&P=2");
		
	}
	
}

function FncReporteAlmacenMovimientoSalidaResumenNuevo(){

}

$().ready(function() {

	$('#BtnVer').on('click', function() {
	
		FncReporteAlmacenMovimientoSalidaResumenVer();	
	
	});
	
	$('#BtnImprimir').on('click', function() {
	
		FncReporteAlmacenMovimientoSalidaResumenImprimir();	
	
	});
	
		$('#BtnExcel').on('click', function() {
	
		FncReporteAlmacenMovimientoSalidaResumenGenerarExcel();	
	
	});

	
/*
* EVENTOS - NAVEGACION
*/		
	
});


// JavaScript Document


//
//function FncReporteAlmacenMovimientoSalidaResumenVer(){
//	
//	//doIframe();
//	
//}
//
//function FncReporteAlmacenMovimientoSalidaResumenImprimir(oIndice){
//	var Accion = document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action;
//	
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).submit();
//	
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).target = 'IfrReporteAlmacenMovimientoSalidaResumen'+oIndice;
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action = Accion;
//	
//}
//
//function FncReporteAlmacenMovimientoSalidaResumenGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action;
//	
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).submit();
//	
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).target = 'IfrReporteAlmacenMovimientoSalidaResumen'+oIndice;
//	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action = Accion;
//	
//}
//
//function FncReporteAlmacenMovimientoSalidaResumenNuevo(){
//
//				
//}


