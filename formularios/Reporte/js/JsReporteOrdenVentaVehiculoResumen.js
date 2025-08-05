// JavaScript Document



function FncReporteOrdenVentaVehiculoResumenVer(){
	
doIframe();
	
}
function FncReporteOrdenVentaVehiculoResumenImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).target = 'IfrReporteOrdenVentaVehiculoResumen'+oIndice;
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).action = Accion;
	
}

function FncReporteOrdenVentaVehiculoResumenGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).target = 'IfrReporteOrdenVentaVehiculoResumen'+oIndice;
	document.getElementById('FrmReporteOrdenVentaVehiculoResumen'+oIndice).action = Accion;
	
}



function FncReporteOrdenVentaVehiculoResumenNuevo(){


	
				
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