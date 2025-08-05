// JavaScript Document

function FncReporteMovimientoEntradaDetalleImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).action;
	
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).target = '_blank';
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).submit();
	
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).target = 'IfrReporteMovimientoEntradaDetalle'+oIndice;
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).action = Accion;
	
}

function FncReporteMovimientoEntradaDetalleGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).action;
	
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).target = '_blank';
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).submit();
	
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).target = 'IfrReporteMovimientoEntradaDetalle'+oIndice;
	document.getElementById('FrmReporteMovimientoEntradaDetalle'+oIndice).action = Accion;
	
}



function FncReporteMovimientoEntradaDetalleNuevo(){


	
				
}



function FncAgregarSeleccionado(){

	var indice = 0;
	//alert(":3");
	$('input[type=checkbox]').each(function () {
		if($(this).attr('name')=="cmp_seleccionar[]"){
			//alert(":33");
			if($(this).is(':checked')){
				$('#Fila_'+indice).css('background-color', '#CEE7FF');
			}else{
				$('#Fila_'+indice).css('background-color', '#FFFFFF');				
			}
		}
		indice = indice + 1;
	});
	
	
}