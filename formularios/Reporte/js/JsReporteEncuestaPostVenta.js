// JavaScript Document




function FncValidar(){
	
	var respuesta = true
	
	var Sucursal = $("#CmpSucursal").val();
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var TipoFecha = $("#CmpTipoFecha").val();
	
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
		
		
	}else if(TipoFecha==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido un tipo de fecha.",
				callback: function(result){
					$("#CmpTipoFecha").focus();
				}
			});	
			
		respuesta = false	
		

	}
	
	return respuesta;
	
}


$().ready(function() {

	$('#BtnVer').on('click', function() {
		//if(FncValidar()){
			FncReporteEncuestaPostVentaVer('');
		//}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		//if(FncValidar()){
			FncReporteEncuestaPostVentaImprimir('');
		//}
	});
	
	
	$('#BtnExcel').on('click', function() {
		//if(FncValidar()){
			FncReporteEncuestaPostVentaGenerarExcel('');
		//}
	});
//
});





function FncReporteEncuestaPostVentaImprimir(oIndice){
	//var Accion = document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).action;
//	
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).submit();
//	
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).target = 'IfrReporteEncuestaPostVenta'+oIndice;
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).action = Accion;
	
	if(FncValidar()){	
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var TipoFecha = $("#CmpTipoFecha").val();
	
		FncPopUp("formularios/Reporte/IfrReporteEncuestaPostVenta.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&TipoFecha="+TipoFecha+"&P=1");
	
	}
	
}

function FncReporteEncuestaPostVentaGenerarExcel(oIndice){
	
	//var Accion = document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).action;
//	
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).submit();
//	
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).target = 'IfrReporteEncuestaPostVenta'+oIndice;
//	document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).action = Accion;

	if(FncValidar()){	
	
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var TipoFecha = $("#CmpTipoFecha").val();
		
		FncPopUp("formularios/Reporte/XLSReporteEncuestaPostVenta.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&TipoFecha="+TipoFecha+"&P=2");
		
	}
}

function FncReporteEncuestaPostVentaVer(oIndice){
	
	
	if(FncValidar()){
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var TipoFecha = $("#CmpTipoFecha").val();

		$('#CapReporteEncuestaPostVenta').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteEncuestaPostVenta.php',
			data: "Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&TipoFecha="+TipoFecha,
			success: function(html){
				$('#CapReporteEncuestaPostVenta').html(html);	
			}
		});

	}
	
	//document.getElementById('FrmReporteEncuestaPostVenta'+oIndice).submit();
	
}


