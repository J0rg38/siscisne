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

	/*$("#cpa-FrmReporteNotaDebitoResumen").submit(function(e){
    e.preventDefault();
  });*/
  
  
//	$('#FrmReporteNotaDebitoResumen').on('submit', function() {
//			
//		//$("#CmpEstado").removeAttr('disabled');	
//		return FncValidar();
//
//	});
	
	$('#BtnVer').click(function(e) {
		
		if(FncValidar()){
			FncReporteNotaDebitoResumenVer('');
		}else{
			e.preventDefault();	
		}
	});
	
	$('#BtnImprimir').click(function(e) {
		
		if(FncValidar()){
			FncReporteNotaDebitoResumenImprimir('');
		}else{
			e.preventDefault();
		}
	});
	
	$('#BtnExcel').click(function(e) {
	
		if(FncValidar()){
			FncReporteNotaDebitoResumenGenerarExcel('');
		}else{
				e.preventDefault();
		}
	});

	

});


function FncReporteNotaDebitoResumenImprimir(oIndice){
	
	var Accion = document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).action;
	
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).target = 'IfrReporteNotaDebitoResumen'+oIndice;
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).action = Accion;
	
}

function FncReporteNotaDebitoResumenGenerarExcel(oIndice){
	
	var Accion = document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).action;
	
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).target = 'IfrReporteNotaDebitoResumen'+oIndice;
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).action = Accion;
	
}

function FncReporteNotaDebitoResumenVer(oIndice){
	
	document.getElementById('FrmReporteNotaDebitoResumen'+oIndice).submit();
	
}


