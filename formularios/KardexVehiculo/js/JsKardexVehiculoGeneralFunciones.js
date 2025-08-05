// JavaScript Document


var VehiculoCodigoIdentificador = "";
var VehiculoUnidadMedidaKardex = "";
var Moneda = "";
var SucursalId = "";
var VehiculoId = "";

var FechaInicio = "";
var FechaFin = "";

function FncObtenerVariables(){

	VehiculoCodigoIdentificador = $("#CmpVehiculoCodigoIdentificador").val();
	VehiculoUnidadMedidaKardex = $("#CmpVehiculoUnidadMedidaKardexVehiculo").val();
	Moneda = $("#CmpMoneda").val();
	SucursalId = $("#CmpSucursalId").val();
	VehiculoId = $("#CmpVehiculoId").val();
	
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	
	VehiculoNombre = $("#CmpVehiculoNombre").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpVehiculoId="+VehiculoId+"&CmpSucursalId="+SucursalId+"&CmpVehiculoUnidadMedidaKardexVehiculo="+VehiculoUnidadMedidaKardex+"&CmpVehiculoCodigoIdentificador="+VehiculoCodigoIdentificador+"&CmpVehiculoNombre="+VehiculoNombre;	
	
}

function FncValidar(){

	var respuesta = true

	FncObtenerVariables();

	/*if(Moneda==""){
	
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No ha escogido una moneda.",
			callback: function(result){
				$("#CmpMoneda").focus();
			}
		});
			
		respuesta = false;
			
	}else */if(FechaInicio==""){
	
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
		
	
	/*
	}else if(VehiculoCodigoIdentificador==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado un codigo de vehiculo.",
				callback: function(result){
					$("#CmpVehiculoCodigoIdentificador").focus();
				}
			});	
			
		respuesta = false;*/

	}else if(VehiculoUnidadMedidaKardex==""){
	
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

	$('#FrmKardexVehiculo').on('submit', function() {
		return false
	});
	
	$('#BtnVer').click(function(e) {
		
		if(FncValidar()){
			FncKardexVehiculoVer('');
		}
		
	});
	
	$('#BtnImprimir').click(function(e) {
		
		if(FncValidar()){
			FncKardexVehiculoImprimir('');
		}
		
	});
	
	$('#BtnExcel').click(function(e) {
		if(FncValidar()){
			FncKardexVehiculoGenerarExcel('');
		}
	});

});



function FncKardexVehiculoImprimir(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmKardexVehiculo'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncKardexVehiculoGenerarExcel(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmKardexVehiculo'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncKardexVehiculoVer(oIndice){
	
	document.getElementById('FrmKardexVehiculo'+oIndice).submit();
	
}



/*
function FncKardexVehiculoImprimir(oIndice){
	var Accion = document.getElementById('FrmKardexVehiculo'+oIndice).action;

	document.getElementById('FrmKardexVehiculo'+oIndice).target = '_blank';
	document.getElementById('FrmKardexVehiculo'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmKardexVehiculo'+oIndice).submit();

	document.getElementById('FrmKardexVehiculo'+oIndice).target = 'IfrKardex'+oIndice;
	document.getElementById('FrmKardexVehiculo'+oIndice).action = Accion;
}

function FncKardexVehiculoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmKardexVehiculo'+oIndice).action;

	document.getElementById('FrmKardexVehiculo'+oIndice).target = '_blank';
	document.getElementById('FrmKardexVehiculo'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmKardexVehiculo'+oIndice).submit();

	document.getElementById('FrmKardexVehiculo'+oIndice).target = 'IfrKardex'+oIndice;
	document.getElementById('FrmKardexVehiculo'+oIndice).action = Accion;
}*/



function FncKardexVehiculoNuevo(){

	console.log("FncKardexVehiculoNuevo");
	
	$('#CmpVehiculoId').val("");		
	$('#CmpVehiculoCodigoIdentificador').val("");		
	
	$('#CmpVehiculoNombre').val("");	
	$('#CmpVehiculoMarca').val("");	
	$('#CmpVehiculoModelo').val("");	
	$('#CmpVehiculoVersion').val("");
	
	$('#CmpVehiculoUnidadMedidaKardexVehiculo').val("");	
	
	//$('#CmpVehiculoUnidadMedidaKardexVehiculo').html("");	
	
	$('#CmpVehiculoCodigoIdentificador').focus();
				
}


function FncVehiculoFuncion(InsVehiculo){

	console.log("FncVehiculoFuncion");
	console.log(InsVehiculo.UmeId);
	
	$('#CmpVehiculoUnidadMedidaKardexVehiculo').val(InsVehiculo.UmeId);
	
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

