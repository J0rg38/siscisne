// JavaScript Document


var VehiculoIngresoVIN = "";
var VehiculoUnidadMedidaKardexVehiculo = "";
var Moneda = "";
var SucursalId = "";
var VehiculoIngresoId = "";
var VehiculoCodigoIdentificador = "";
var VehiculoId = "";

var VehiculoNombre = "";

var FechaInicio = "";
var FechaFin = "";

function FncObtenerVariables(){

	VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	VehiculoUnidadMedidaKardexVehiculo = $("#CmpVehiculoUnidadMedidaKardexVehiculo").val();
	Moneda = $("#CmpMoneda").val();
	SucursalId = $("#CmpSucursalId").val();
	VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();
	VehiculoCodigoIdentificador = $("#CmpVehiculoCodigoIdentificador").val();
	VehiculoId = $("#CmpVehiculoId").val();
	
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	
	VehiculoNombre = $("#CmpVehiculoNombre").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpVehiculoIngresoId="+VehiculoIngresoId+"&CmpSucursalId="+SucursalId+"&CmpVehiculoUnidadMedidaKardexVehiculo="+VehiculoUnidadMedidaKardexVehiculo+"&CmpVehiculoIngresoVIN="+VehiculoIngresoVIN+"&CmpVehiculoNombre="+VehiculoNombre+"&CmpVehiculoId="+VehiculoId+"&CmpVehiculoCodigoIdentificador="+VehiculoCodigoIdentificador;	
	
}

function FncValidar(){

	var respuesta = true

	FncObtenerVariables();

	if(Moneda==""){
	
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No ha escogido una moneda.",
			callback: function(result){
				$("#CmpMoneda").focus();
			}
		});
			
		respuesta = false;
			
	}else if(FechaInicio==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una fecha inicio.",
				callback: function(result){
					$("#CmpFechaInicio").focus();
				}
			});	
			
		respuesta = false;		
		
	}else if(FechaFin==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una fecha fin.",
				callback: function(result){
					$("#CmpFechaFin").focus();
				}
			});	
			
		respuesta = false;
	
	
	}else if(VehiculoIngresoVIN==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado un VIN.",
				callback: function(result){
					$("#CmpVehiculoIngresoVIN").focus();
				}
			});	
			
		respuesta = false;

	}else if(VehiculoUnidadMedidaKardexVehiculo==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una unidad de medida.",
				callback: function(result){
					$("#CmpVehiculoUnidadMedidaKardexVehiculo").focus();
				}
			});	
			
		respuesta = false;
	}
	
	return respuesta;
	
}

$().ready(function() {

	$('#FrmKardex').on('submit', function() {
		return false
	});
	
	$('#BtnVer').click(function(e) {
		
		if(FncValidar()){
			FncKardexVer('');
		}
		
	});
	
	$('#BtnImprimir').click(function(e) {
		
		if(FncValidar()){
			FncKardexImprimir('');
		}
		
	});
	
	$('#BtnExcel').click(function(e) {
		if(FncValidar()){
			FncKardexGenerarExcel('');
		}
	});

});



function FncKardexImprimir(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmKardex'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncKardexGenerarExcel(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmKardex'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncKardexVer(oIndice){
	
	document.getElementById('FrmKardex'+oIndice).submit();
	
}



/*
function FncKardexImprimir(oIndice){
	var Accion = document.getElementById('FrmKardex'+oIndice).action;

	document.getElementById('FrmKardex'+oIndice).target = '_blank';
	document.getElementById('FrmKardex'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmKardex'+oIndice).submit();

	document.getElementById('FrmKardex'+oIndice).target = 'IfrKardex'+oIndice;
	document.getElementById('FrmKardex'+oIndice).action = Accion;
}

function FncKardexGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmKardex'+oIndice).action;

	document.getElementById('FrmKardex'+oIndice).target = '_blank';
	document.getElementById('FrmKardex'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmKardex'+oIndice).submit();

	document.getElementById('FrmKardex'+oIndice).target = 'IfrKardex'+oIndice;
	document.getElementById('FrmKardex'+oIndice).action = Accion;
}*/



function FncKardexNuevo(){

	$('#CmpVehiculoIngresoId').val("");		
	$('#CmpVehiculoIngresoVIN').val("");		
	
	$('#CmpVehiculoId').val("");		
	$('#CmpVehiculoCodigoIdentificador').val("");	
	
	$('#CmpVehiculoNombre').val("");	
	$('#CmpVehiculoMarca').val("");	
	$('#CmpVehiculoModelo').val("");	
	$('#CmpVehiculoVersion').val("");	
	
	$('#CmpVehiculoUnidadMedidaKardexVehiculo').val("");	
	
	$('#CmpVehiculoIngresoVIN').focus();
				
}


//function FncProductoFuncion(){
//	
//	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();
//
//		$.getJSON("comunes/UnidadMedida/JnProductoKardexUnidadMedida.php?VehiculoIngresoId="+VehiculoIngresoId,{}, function(j){
//		var options = '';
//
//		options += '<option value="">Escoja una opcion</option>';
//		for (var i = 0; i < j.length; i++) {
//			if("3" == j[i].UmeUso){
//				options += '<option value="' + j[i].UmeUso + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
//			}else{
//				options += '<option value="' + j[i].UmeUso + '" >' + j[i].UmeNombre+ '</option>';				
//			}
//
//		}
//		$("select#CmpVehiculoUnidadMedidaKardexVehiculo").html(options);
//	})
//}
//
//


function FncVehiculoIngresoFuncion(InsVehiculoIngreso){

	console.log("FncVehiculoIngresoFuncion");
//	console.log(InsVehiculoIngreso.UmeId);
	
	$('#CmpVehiculoUnidadMedidaKardexVehiculo').val(InsVehiculoIngreso.UmeId);
	
	$('#CmpVehiculoIngresoId').val(InsVehiculoIngreso.EinId);
	$('#CmpVehiculoId').val(InsVehiculoIngreso.VehId);
	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoIngreso.VehCodigoIdentificador);
	$('#CmpVehiculoNombre').val(InsVehiculoIngreso.VehNombre);
	
	$('#CmpVehiculoMarca').val(InsVehiculoIngreso.VmaNombre);
	$('#CmpVehiculoModelo').val(InsVehiculoIngreso.VmoNombre);
	$('#CmpVehiculoVersion').val(InsVehiculoIngreso.VveNombre);
	
	
	
/*	var VehiculoId = $("#CmpVehiculoId").val();

		$.getJSON("comunes/UnidadMedida/JnVehiculoKardexUnidadMedida.php?VehiculoId="+VehiculoId,{}, function(j){
		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if("3" == j[i].UmeUso){
				options += '<option value="' + j[i].UmeUso + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeUso + '" >' + j[i].UmeNombre+ '</option>';				
			}

		}
		$("select#CmpVehiculoUnidadMedidaKardexVehiculo").html(options);
	})*/
}

