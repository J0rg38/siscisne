// JavaScript Document

function FncReporteVentaDirectaClientePendienteImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).target = 'IfrReporteVentaDirectaClientePendiente'+oIndice;
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaClientePendienteGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).target = 'IfrReporteVentaDirectaClientePendiente'+oIndice;
	document.getElementById('FrmReporteVentaDirectaClientePendiente'+oIndice).action = Accion;
	
}



function FncReporteVentaDirectaClientePendienteNuevo(){


	
				
}



function FncAgregarSeleccionado(){

	var indice = 0;
	//alert(":3");
	$('input[type=checkbox]').each(function () {
		if($(this).attr('name')=="cmp_seleccionar[]"){
			alert(":33");
			if($(this).is(':checked')){
				$('#Fila_'+indice).css('background-color', '#CEE7FF');
			}else{
				$('#Fila_'+indice).css('background-color', '#FFFFFF');				
			}
		}
		indice = indice + 1;
	});
	
	
}