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

	$('#BtnVer').on('click', function() {
		if(FncValidar()){
			FncReporteBoletaCobrarVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteBoletaCobrarImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteBoletaCobrarGenerarExcel('');
		}
	});

});





function FncReporteBoletaCobrarImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteBoletaCobrar'+oIndice).action;
	
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).target = '_blank';
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).submit();
	
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).target = 'IfrReporteBoletaCobrar'+oIndice;
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).action = Accion;
	
}

function FncReporteBoletaCobrarGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteBoletaCobrar'+oIndice).action;
	
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).target = '_blank';
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).submit();
	
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).target = 'IfrReporteBoletaCobrar'+oIndice;
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).action = Accion;
	
}

function FncReporteBoletaCobrarVer(oIndice){
	
	document.getElementById('FrmReporteBoletaCobrar'+oIndice).submit();
	
}


