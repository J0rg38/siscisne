// JavaScript Document




function FncReporteVentaDirectaDespachoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).target = 'IfrReporteVentaDirectaDespacho'+oIndice;
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaDespachoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).target = 'IfrReporteVentaDirectaDespacho'+oIndice;
	document.getElementById('FrmReporteVentaDirectaDespacho'+oIndice).action = Accion;
	
}



function FncReporteVentaDirectaDespachoNuevo(){


	
				
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