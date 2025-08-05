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
			FncReporteVehiculoIngresoBonoVer('');
		//}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		//if(FncValidar()){
			FncReporteVehiculoIngresoBonoImprimir('');
		//}
	});
	
	
	$('#BtnExcel').on('click', function() {
		//if(FncValidar()){
			FncReporteVehiculoIngresoBonoGenerarExcel('');
		//}
	});
//
});





function FncReporteVehiculoIngresoBonoImprimir(oIndice){
	//var Accion = document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).action;
//	
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).submit();
//	
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).target = 'IfrReporteVehiculoIngresoBono'+oIndice;
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).action = Accion;
	
	if(FncValidar()){	
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
	
		FncPopUp("formularios/Reporte/IfrReporteVehiculoIngresoBono.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=1");
	
	}
	
}

function FncReporteVehiculoIngresoBonoGenerarExcel(oIndice){
	
	//var Accion = document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).action;
//	
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).submit();
//	
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).target = 'IfrReporteVehiculoIngresoBono'+oIndice;
//	document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).action = Accion;

	if(FncValidar()){	
	
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		FncPopUp("formularios/Reporte/XLSReporteVehiculoIngresoBono.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=2");
		
	}
}

function FncReporteVehiculoIngresoBonoVer(oIndice){
	
	
	if(FncValidar()){
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();

		$('#CapReporteVehiculoIngresoBono').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteVehiculoIngresoBono.php',
			data: "Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin,
			success: function(html){
				$('#CapReporteVehiculoIngresoBono').html(html);	
			}
		});

	}
	
	//document.getElementById('FrmReporteVehiculoIngresoBono'+oIndice).submit();
	
}


