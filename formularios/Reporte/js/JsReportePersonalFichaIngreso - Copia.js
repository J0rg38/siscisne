// JavaScript Document

function FncReportePersonalFichaIngresoImprimir(oIndice){
	var Accion = document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).action;
	
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).target = '_blank';
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).submit();
	
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).target = 'IfrReportePersonalFichaIngreso'+oIndice;
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).action = Accion;
	
}

function FncReportePersonalFichaIngresoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).action;
	
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).target = '_blank';
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).submit();
	
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).target = 'IfrReportePersonalFichaIngreso'+oIndice;
	document.getElementById('FrmReportePersonalFichaIngreso'+oIndice).action = Accion;
	
}



function FncReportePersonalFichaIngresoNuevo(){


	
				
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
	
	//$('.myCheckbox').is(':checked');
	
	
//	if($('#CmpAgregarSeleccionado_'+oFila).is(':checked')){
//		//alert("si");
//		$('#Fila_'+oFila).css('background-color', '#CEE7FF');
//	}else{
//		//alert("no");
//		$('#Fila_'+oFila).css('background-color', '#FFFFFF');				
//	}

//	var Seleccionados = "";
//	
//	indice = 1;
//	$('input[type=checkbox]').each(function () {
//		
//		if($(this).attr('name')=="CmpAgregarSeleccionado[]"){
//
//			if($(this).is(':checked')){
//				Seleccionados = Seleccionados + "#" + $('#CmpAgregarSeleccionado_'+indice).val();
//			}
//
//			indice = indice + 1;
//		}
//	
//	});
	
	
	
	//$('#CmpSeleccionados').val(Seleccionados);
}