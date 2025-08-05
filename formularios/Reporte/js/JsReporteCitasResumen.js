// JavaScript Document




function FncValidar(){
	
	var respuesta = true
	
	var Sucursal = $("#CmpSucursal").val();
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
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
		//if(FncValidar()){
			FncReporteCitasResumenVer('');
		//}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		//if(FncValidar()){
			FncReporteCitasResumenImprimir('');
		//}
	});
	
	
	$('#BtnExcel').on('click', function() {
		//if(FncValidar()){
			FncReporteCitasResumenGenerarExcel('');
		//}
	});
//
});





function FncReporteCitasResumenImprimir(oIndice){
	//var Accion = document.getElementById('FrmReporteCitasResumen'+oIndice).action;
//	
//	document.getElementById('FrmReporteCitasResumen'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteCitasResumen'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteCitasResumen'+oIndice).submit();
//	
//	document.getElementById('FrmReporteCitasResumen'+oIndice).target = 'IfrReporteCitasResumen'+oIndice;
//	document.getElementById('FrmReporteCitasResumen'+oIndice).action = Accion;
	
	if(FncValidar()){	
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
	
		FncPopUp("formularios/Reporte/IfrReporteCitasResumen.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=1");
	
	}
	
}

function FncReporteCitasResumenGenerarExcel(oIndice){
	
	//var Accion = document.getElementById('FrmReporteCitasResumen'+oIndice).action;
//	
//	document.getElementById('FrmReporteCitasResumen'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteCitasResumen'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteCitasResumen'+oIndice).submit();
//	
//	document.getElementById('FrmReporteCitasResumen'+oIndice).target = 'IfrReporteCitasResumen'+oIndice;
//	document.getElementById('FrmReporteCitasResumen'+oIndice).action = Accion;

	if(FncValidar()){	
	
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		FncPopUp("formularios/Reporte/XLSReporteCitasResumen.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=2");
		
	}
}

function FncReporteCitasResumenVer(oIndice){
	
	
	if(FncValidar()){
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();

		$('#CapReporteCitasResumen').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteCitasResumen.php',
			data: "Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin,
			success: function(html){
				$('#CapReporteCitasResumen').html(html);	
			}
		});

	}
	
	//document.getElementById('FrmReporteCitasResumen'+oIndice).submit();
	
}


