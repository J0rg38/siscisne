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
			FncReporteEncuestaVentaVer('');
		//}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		//if(FncValidar()){
			FncReporteEncuestaVentaImprimir('');
		//}
	});
	
	
	$('#BtnExcel').on('click', function() {
		//if(FncValidar()){
			FncReporteEncuestaVentaGenerarExcel('');
		//}
	});
//
});





function FncReporteEncuestaVentaImprimir(oIndice){
	//var Accion = document.getElementById('FrmReporteEncuestaVenta'+oIndice).action;
//	
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).submit();
//	
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).target = 'IfrReporteEncuestaVenta'+oIndice;
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).action = Accion;
	
	if(FncValidar()){	
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var TipoFecha = $("#CmpTipoFecha").val();
	
		FncPopUp("formularios/Reporte/IfrReporteEncuestaVenta.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&TipoFecha="+TipoFecha+"&P=1");
	
	}
	
}

function FncReporteEncuestaVentaGenerarExcel(oIndice){
	
	//var Accion = document.getElementById('FrmReporteEncuestaVenta'+oIndice).action;
//	
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).submit();
//	
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).target = 'IfrReporteEncuestaVenta'+oIndice;
//	document.getElementById('FrmReporteEncuestaVenta'+oIndice).action = Accion;

	if(FncValidar()){	
	
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var TipoFecha = $("#CmpTipoFecha").val();
		FncPopUp("formularios/Reporte/XLSReporteEncuestaVenta.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&TipoFecha="+TipoFecha+"&P=2");
		
	}
}

function FncReporteEncuestaVentaVer(oIndice){
	
	
	if(FncValidar()){
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
var TipoFecha = $("#CmpTipoFecha").val();
var Personal = $("#CmpPersonal").val();
		$('#CapReporteEncuestaVenta').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteEncuestaVenta.php',
			data: "Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&TipoFecha="+TipoFecha+"&Personal="+Personal,
			success: function(html){
				$('#CapReporteEncuestaVenta').html(html);	
			}
		});

	}
	
	//document.getElementById('FrmReporteEncuestaVenta'+oIndice).submit();
	
}


