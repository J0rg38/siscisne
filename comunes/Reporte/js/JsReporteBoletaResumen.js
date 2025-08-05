// JavaScript Document




function FncValidar(){
	
	var respuesta = true
	
	var Moneda = $("#CmpMoneda").val();
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
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
				text:"No ha escogido una moneda.",
				callback: function(result){
					$("#CmpFechaInicio").focus();
				}
			});	
			
		respuesta = false;		
		
	}else if(FechaFin==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una moneda.",
				callback: function(result){
					$("#CmpFechaFin").focus();
				}
			});	
			
		respuesta = false;

	}
	
	return respuesta;
	
}




$().ready(function() {



	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});
	
	
	$('#BtnVer').on('click', function() {
		if(FncValidar()){
			FncReporteBoletaResumenVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteBoletaResumenImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteBoletaResumenGenerarExcel('');
		}
	});
//
});





function FncReporteBoletaResumenImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteBoletaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteBoletaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteBoletaResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteBoletaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteBoletaResumen'+oIndice).target = 'IfrReporteBoletaResumen'+oIndice;
	document.getElementById('FrmReporteBoletaResumen'+oIndice).action = Accion;
	
}

function FncReporteBoletaResumenGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteBoletaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteBoletaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteBoletaResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteBoletaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteBoletaResumen'+oIndice).target = 'IfrReporteBoletaResumen'+oIndice;
	document.getElementById('FrmReporteBoletaResumen'+oIndice).action = Accion;
	
}

function FncReporteBoletaResumenVer(oIndice){
	
	document.getElementById('FrmReporteBoletaResumen'+oIndice).submit();
	
}


