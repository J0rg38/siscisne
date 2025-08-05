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

	/*$("#cpa-FrmReporteNotaCreditoResumen").submit(function(e){
    e.preventDefault();
  });*/
  
  
//	$('#FrmReporteNotaCreditoResumen').on('submit', function() {
//			
//		//$("#CmpEstado").removeAttr('disabled');	
//		return FncValidar();
//
//	});
	
	$('#BtnVer').click(function(e) {
		
		if(FncValidar()){
			FncReporteNotaCreditoResumenVer('');
		}else{
			e.preventDefault();	
		}
	});
	
	$('#BtnImprimir').click(function(e) {
		
		if(FncValidar()){
			FncReporteNotaCreditoResumenImprimir('');
		}else{
			e.preventDefault();
		}
	});
	
	$('#BtnExcel').click(function(e) {
	
		if(FncValidar()){
			FncReporteNotaCreditoResumenGenerarExcel('');
		}else{
				e.preventDefault();
		}
	});

	

});


function FncReporteNotaCreditoResumenImprimir(oIndice){
	
	var Accion = document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).action;
	
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).target = 'IfrReporteNotaCreditoResumen'+oIndice;
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).action = Accion;
	
}

function FncReporteNotaCreditoResumenGenerarExcel(oIndice){
	
	var Accion = document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).action;
	
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).target = 'IfrReporteNotaCreditoResumen'+oIndice;
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).action = Accion;
	
}

function FncReporteNotaCreditoResumenVer(oIndice){
	
	document.getElementById('FrmReporteNotaCreditoResumen'+oIndice).submit();
	
}


