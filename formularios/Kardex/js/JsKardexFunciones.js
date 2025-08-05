// JavaScript Document


var ProductoCodigoOriginal = "";
var ProductoUnidadMedidaKardex = "";
var Moneda = "";
var AlmacenId = "";
var ProductoId = "";

var FechaInicio = "";
var FechaFin = "";

function FncObtenerVariables(){

	ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
	ProductoUnidadMedidaKardex = $("#CmpProductoUnidadMedidaKardex").val();
	Moneda = $("#CmpMoneda").val();
	AlmacenId = $("#CmpAlmacenId").val();
	ProductoId = $("#CmpProductoId").val();
	
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	
	ProductoNombre = $("#CmpProductoNombre").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpProductoId="+ProductoId+"&CmpAlmacenId="+AlmacenId+"&CmpProductoUnidadMedidaKardex="+ProductoUnidadMedidaKardex+"&CmpProductoCodigoOriginal="+ProductoCodigoOriginal+"&CmpProductoNombre="+ProductoNombre;	
	
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
		
	}else if(ProductoNombre==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado un nombre de producto.",
				callback: function(result){
					$("#CmpProductoNombre").focus();
				}
			});	
			
		respuesta = false;
	
	}else if(ProductoCodigoOriginal==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado un codigo original de producto.",
				callback: function(result){
					$("#CmpProductoCodigoOriginal").focus();
				}
			});	
			
		respuesta = false;

	}else if(ProductoUnidadMedidaKardex==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una unidad de medida.",
				callback: function(result){
					$("#CmpProductoUnidadMedidaKardex").focus();
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

	$('#CmpProductoId').val("");		
	$('#CmpProductoCodigoAlternativo').val("");		
	$('#CmpProductoCodigoOriginal').val("");		
	$('#CmpProductoNombre').val("");	
	
	$('#CmpProductoUnidadMedidaKardex').html("");	
	
	
	$('#CmpProductoCodigoAlternativo').select();
				
}


function FncProductoFuncion(){
	
	var ProductoId = $("#CmpProductoId").val();

		$.getJSON("comunes/UnidadMedida/JnProductoKardexUnidadMedida.php?ProductoId="+ProductoId,{}, function(j){
		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if("3" == j[i].UmeUso){
				options += '<option value="' + j[i].UmeUso + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeUso + '" >' + j[i].UmeNombre+ '</option>';				
			}

		}
		$("select#CmpProductoUnidadMedidaKardex").html(options);
	})
}
