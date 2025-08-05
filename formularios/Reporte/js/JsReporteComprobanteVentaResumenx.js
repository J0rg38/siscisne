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

	/*$("#cpa-FrmReporteFacturaResumen").submit(function(e){
    e.preventDefault();
  });*/
  
  
//	$('#FrmReporteFacturaResumen').on('submit', function() {
//			
//		//$("#CmpEstado").removeAttr('disabled');	
//		return FncValidar();
//
//	});
	
	$('#BtnVer').click(function(e) {
		
		if(FncValidar()){
			FncReporteFacturaResumenVer('');
		}else{
			e.preventDefault();	
		}
	});
	
	$('#BtnImprimir').click(function(e) {
		
		if(FncValidar()){
			FncReporteFacturaResumenImprimir('');
		}else{
			e.preventDefault();
		}
	});
	
	$('#BtnExcel').click(function(e) {
	
		if(FncValidar()){
			FncReporteFacturaResumenGenerarExcel('');
		}else{
				e.preventDefault();
		}
	});

	

});


function FncReporteFacturaResumenImprimir(oIndice){
	
	var Accion = document.getElementById('FrmReporteFacturaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFacturaResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFacturaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).target = 'IfrReporteFacturaResumen'+oIndice;
	document.getElementById('FrmReporteFacturaResumen'+oIndice).action = Accion;
	
}

function FncReporteFacturaResumenGenerarExcel(oIndice){
	
	var Accion = document.getElementById('FrmReporteFacturaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFacturaResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFacturaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).target = 'IfrReporteFacturaResumen'+oIndice;
	document.getElementById('FrmReporteFacturaResumen'+oIndice).action = Accion;
	
}

function FncReporteFacturaResumenVer(oIndice){
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).submit();
	
}


