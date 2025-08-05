// JavaScript Document

function FncReporteOrdenCompraBackOrderImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).target = 'IfrReporteOrdenCompraBackOrder'+oIndice;
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).action = Accion;
	
}

function FncReporteOrdenCompraBackOrderGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).target = 'IfrReporteOrdenCompraBackOrder'+oIndice;
	document.getElementById('FrmReporteOrdenCompraBackOrder'+oIndice).action = Accion;
	
}



function FncReporteOrdenCompraBackOrderNuevo(){


	
				
}



function FncReporteOrdenCompraBackOrderSeleccionarTodos(){
	
	self.parent.$('#CmpSeleccionados').val("");
	
	var seleccionados = '';
	var indice = 0;
	
	if($("#CmpAgregarSeleccionados").is(':checked')){
		$('input[type=checkbox]').each(function () {
			if($(this).attr('name')=="CmpAgregarSeleccionado[]"){
				$(this).attr('checked', true);		
				$('#Fila_'+indice).css('background-color', '#CEE7FF');		
				seleccionados = seleccionados + '#'+ $(this).val();
			}			 
			indice = indice + 1;
		});
	}else{
		$('input[type=checkbox]').each(function () {
			if($(this).attr('name')=="CmpAgregarSeleccionado[]"){
				$(this).attr('checked', false);
				$('#Fila_'+indice).css('background-color', '#FFFFFF');
			}
			indice = indice + 1;
		});
	}

	self.parent.$('#CmpSeleccionados').val(seleccionados);
}


function FncReporteOrdenCompraBackOrderSeleccionar(){
	
	var seleccionados = "";
	var indice = 1;
	
	$('input[type=checkbox]').each(function () {
		
		if($(this).attr('name')=="CmpAgregarSeleccionado[]"){

			if($(this).is(':checked')){
				$('#Fila_'+indice).css('background-color', '#CEE7FF');
				seleccionados = seleccionados + "#" + $(this).val();
			}else{
				$('#Fila_'+indice).css('background-color', '#FFFFFF');		
			}
			indice = indice + 1;
		}
	
	});
	
	self.parent.$('#CmpSeleccionados').val(seleccionados);
	
}