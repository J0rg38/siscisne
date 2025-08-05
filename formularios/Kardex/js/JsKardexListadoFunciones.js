// JavaScript Document



var Moneda = "";
var AlmacenId = "";

var FechaInicio = "";
var FechaFin = "";

var TipoUnidadMedida = "";
var FechaTipo = "";
var ProductoCategoria = "";

function FncObtenerVariables(){

	Moneda = $("#CmpMoneda").val();
	AlmacenId = $("#CmpAlmacenId").val();
	
	FechaInicio = $("#CmpFechaInicio").val();
	FechaFin = $("#CmpFechaFin").val();
	
	ProductoCategoria = $("#CmpProductoCategoria").val();
	
	Variables = "CmpMoneda="+Moneda+"&CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpAlmacenId="+AlmacenId+"&CmpProductoCategoria="+ProductoCategoria+"&CmpTipoUnidadMedida="+TipoUnidadMedida+"&CmpFechaTipo="+FechaTipo;	
	
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
		
	}
	
	return respuesta;
	
}

$().ready(function() {

	$('#FrmKardexListado').on('submit', function() {
		return false
	});
	
	$('#BtnVer').click(function(e) {
		
		if(FncValidar()){
			FncKardexListadoVer('');
		}
		
	});
	
	$('#BtnImprimir').click(function(e) {
		
		if(FncValidar()){
			FncKardexListadoImprimir('');
		}
		
	});
	
	$('#BtnExcel').click(function(e) {
		if(FncValidar()){
			FncKardexListadoGenerarExcel('');
		}
	});

});





function FncKardexListadoImprimir(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmKardexListado'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=1",0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncKardexListadoGenerarExcel(oIndice){
	
	FncObtenerVariables();
	
	var Accion = document.getElementById('FrmKardexListado'+oIndice).action;
	
	FncPopUp(Accion+"?"+Variables+"&P=2",0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncKardexListadoVer(oIndice){
	
	document.getElementById('FrmKardexListado'+oIndice).submit();
	
}



/*
function FncKardexListadoListadoImprimir(oIndice){
	var Accion = document.getElementById('FrmKardexListadoListado'+oIndice).action;

	document.getElementById('FrmKardexListadoListado'+oIndice).target = '_blank';
	document.getElementById('FrmKardexListadoListado'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmKardexListadoListado'+oIndice).submit();

	document.getElementById('FrmKardexListadoListado'+oIndice).target = 'IfrKardexListadoListado'+oIndice;
	document.getElementById('FrmKardexListadoListado'+oIndice).action = Accion;
}

function FncKardexListadoListadoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmKardexListadoListado'+oIndice).action;

	document.getElementById('FrmKardexListadoListado'+oIndice).target = '_blank';
	document.getElementById('FrmKardexListadoListado'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmKardexListadoListado'+oIndice).submit();

	document.getElementById('FrmKardexListadoListado'+oIndice).target = 'IfrKardexListadoListado'+oIndice;
	document.getElementById('FrmKardexListadoListado'+oIndice).action = Accion;
}



function FncKardexListadoListadoNuevo(){

	
				
}

*/