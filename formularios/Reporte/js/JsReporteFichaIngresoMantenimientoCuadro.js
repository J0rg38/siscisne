// JavaScript Document

// JavaScript Document
function FncReporteFichaIngresoMantenimientoCuadroValidar(){
	
	var respuesta = true
	
	var Sucursal = $("#CmpSucursal").val();
	
	var VehiculoMarca = $("#CmpVehiculoMarca").val();	
	var VehiculoModelo = $("#CmpVehiculoModelo").val();
	
	var Ano = $("#CmpAno").val();
	
	
	
	if(VehiculoMarca==""){
		alert("No ha escogido una marca.");
		respuesta = false;
	}else if(Ano==""){
		alert("No ha escogido un año.");
		respuesta = false;
	
	}
	
	return respuesta;
	
}


$().ready(function() {

	$('#BtnVer').on('click', function() {
		if(FncReporteFichaIngresoMantenimientoCuadroValidar()){
			FncReporteFichaIngresoMantenimientoCuadroVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncReporteFichaIngresoMantenimientoCuadroValidar()){
			FncReporteFichaIngresoMantenimientoCuadroImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncReporteFichaIngresoMantenimientoCuadroValidar()){
			FncReporteFichaIngresoMantenimientoCuadroGenerarExcel('');
		}
	});


	
	$("select#CmpVehiculoMarca").change(function(){
		FncVehiculoModelosCargar();
	});


});



function FncReporteFichaIngresoMantenimientoCuadroVer(){
	
	if(FncReporteFichaIngresoMantenimientoCuadroValidar()){
		
	var Sucursal = $("#CmpSucursal").val();
	
	var VehiculoMarca = $("#CmpVehiculoMarca").val();	
	var VehiculoModelo = $("#CmpVehiculoModelo").val();
	
	var Ano = $("#CmpAno").val();
	
	
		
		$('#CapReporteFichaIngresoMantenimientoCuadro').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteFichaIngresoMantenimientoCuadro.php',
			data: "Sucursal="+Sucursal+"&VehiculoModelo="+VehiculoModelo+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Ano="+Ano,
			success: function(html){
				$('#CapReporteFichaIngresoMantenimientoCuadro').html(html);	
			}
		});

	}

}

function FncReporteFichaIngresoMantenimientoCuadroImprimir(){
	
	if(FncReporteFichaIngresoMantenimientoCuadroValidar()){
		
		var Sucursal = $("#CmpSucursal").val();
	
		var VehiculoMarca = $("#CmpVehiculoMarca").val();	
		var VehiculoModelo = $("#CmpVehiculoModelo").val();
		
		var Ano = $("#CmpAno").val();
		
		
	
		FncPopUp("formularios/Reporte/IfrReporteFichaIngresoMantenimientoCuadro.php?Sucursal="+Sucursal+"&VehiculoModelo="+VehiculoModelo+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Ano="+Ano+"&P=1");
		
	}

}

function FncReporteFichaIngresoMantenimientoCuadroGenerarExcel(){
	
	if(FncReporteFichaIngresoMantenimientoCuadroValidar()){
		
		var Sucursal = $("#CmpSucursal").val();
		
		var VehiculoMarca = $("#CmpVehiculoMarca").val();	
		var VehiculoModelo = $("#CmpVehiculoModelo").val();
		
		var Ano = $("#CmpAno").val();
		
	
	
	
		FncPopUp("formularios/Reporte/XLSReporteFichaIngresoMantenimientoCuadro.php?Sucursal="+Sucursal+"&VehiculoModelo="+VehiculoModelo+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Ano="+Ano+"&P=2");
		
	}
	
}

function FncReporteFichaIngresoMantenimientoCuadroNuevo(){

}


//function FncReporteFichaIngresoMantenimientoCuadroImprimir(oIndice){
//	var Accion = document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action;
//	
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).submit();
//	
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).target = 'IfrReporteFichaIngresoMantenimientoCuadro'+oIndice;
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action = Accion;
//	
//}
//
//function FncReporteFichaIngresoMantenimientoCuadroGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action;
//	
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).submit();
//	
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).target = 'IfrReporteFichaIngresoMantenimientoCuadro'+oIndice;
//	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action = Accion;
//	
//}
//
//
//
//function FncReporteFichaIngresoMantenimientoCuadroNuevo(){
//
//
//	
//				
//}
//
//
//
///*
//*** EVENTOS
//*/
//
//$().ready(function() {
//
///*
//* EVENTOS - INICIALES
//*/
//	$("select#CmpVehiculoMarca").change(function(){
//		FncVehiculoModelosCargar();
//	});
//
//
//});
