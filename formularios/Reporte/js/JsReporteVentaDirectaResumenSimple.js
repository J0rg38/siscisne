// JavaScript Document



function FncReporteVentaDirectaResumenSimpleVer(){
	
doIframe();
	
}

function FncReporteVentaDirectaResumenSimpleImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).target = 'IfrReporteVentaDirectaResumenSimple'+oIndice;
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaResumenSimpleGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).target = 'IfrReporteVentaDirectaResumenSimple'+oIndice;
	document.getElementById('FrmReporteVentaDirectaResumenSimple'+oIndice).action = Accion;
	
}



function FncReporteVentaDirectaResumenSimpleNuevo(){


	
				
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