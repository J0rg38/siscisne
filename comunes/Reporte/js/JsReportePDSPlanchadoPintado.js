// JavaScript Document



function FncReportePDSPlanchadoPintadoVer(){
	
doIframe();
	
}
function FncReportePDSPlanchadoPintadoImprimir(oIndice){
	var Accion = document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).action;
	
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).target = '_blank';
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).submit();
	
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).target = 'IfrReportePDSPlanchadoPintado'+oIndice;
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).action = Accion;
	
}

function FncReportePDSPlanchadoPintadoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).action;
	
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).target = '_blank';
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).submit();
	
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).target = 'IfrReportePDSPlanchadoPintado'+oIndice;
	document.getElementById('FrmReportePDSPlanchadoPintado'+oIndice).action = Accion;
	
}



function FncReportePDSPlanchadoPintadoNuevo(){


	
				
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