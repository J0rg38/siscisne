// JavaScript Document



function FncReporteVentaDirectaResumenVer(){
	
	$("#CmpSucursal").removeAttr('disabled');		
	
doIframe();
	
}
function FncReporteVentaDirectaResumenImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).target = 'IfrReporteVentaDirectaResumen'+oIndice;
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaResumenGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).target = 'IfrReporteVentaDirectaResumen'+oIndice;
	document.getElementById('FrmReporteVentaDirectaResumen'+oIndice).action = Accion;
	
}



function FncReporteVentaDirectaResumenNuevo(){


	
				
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