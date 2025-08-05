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

	$('#BtnVer').on('click', function() {
		if(FncValidar()){
			FncReporteFacturaCobrarVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteFacturaCobrarImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteFacturaCobrarGenerarExcel('');
		}
	});

});





function FncReporteFacturaCobrarImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFacturaCobrar'+oIndice).action;
	
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).submit();
	
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).target = 'IfrReporteFacturaCobrar'+oIndice;
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).action = Accion;
	
}

function FncReporteFacturaCobrarGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFacturaCobrar'+oIndice).action;
	
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).submit();
	
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).target = 'IfrReporteFacturaCobrar'+oIndice;
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).action = Accion;
	
}

function FncReporteFacturaCobrarVer(oIndice){
	
	document.getElementById('FrmReporteFacturaCobrar'+oIndice).submit();
	
}


