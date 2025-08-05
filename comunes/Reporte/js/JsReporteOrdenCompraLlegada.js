// JavaScript Document

function FncReporteOrdenCompraLlegadaImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).target = 'IfrReporteOrdenCompraLlegada'+oIndice;
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).action = Accion;
	
}

function FncReporteOrdenCompraLlegadaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).target = 'IfrReporteOrdenCompraLlegada'+oIndice;
	document.getElementById('FrmReporteOrdenCompraLlegada'+oIndice).action = Accion;
	
}



function FncReporteOrdenCompraLlegadaNuevo(){


	
				
}



function FncReporteOrdenCompraLlegadaSeleccionarTodos(){
	
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


function FncReporteOrdenCompraLlegadaSeleccionar(){
	
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