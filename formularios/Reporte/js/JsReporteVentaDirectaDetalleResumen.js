// JavaScript Document



function FncReporteVentaDirectaDetalleResumenVer(){
	
doIframe();
	
}
function FncReporteVentaDirectaDetalleResumenImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).target = 'IfrReporteVentaDirectaDetalleResumen'+oIndice;
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaDetalleResumenGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).target = 'IfrReporteVentaDirectaDetalleResumen'+oIndice;
	document.getElementById('FrmReporteVentaDirectaDetalleResumen'+oIndice).action = Accion;
	
}



function FncReporteVentaDirectaDetalleResumenNuevo(){


	
				
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