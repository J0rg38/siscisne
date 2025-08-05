// JavaScript Document
function FncReportePersonalFichaIngresoValidar(){
	
	var respuesta = true
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var Detalle = $("#CmpDetalle").val();
	
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}else if(Sucursal==""){
		alert("No ha escogido una sucursal.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReportePersonalFichaIngresoVer(){
	
	if(FncReportePersonalFichaIngresoValidar()){
		
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var Detalle = $("#CmpDetalle").val();
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
		
		$('#CapReportePersonalFichaIngreso').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReportePersonalFichaIngreso.php',
			data: "CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpDetalle="+Detalle+"&CmpSucursal="+Sucursal+"&CmpOrden="+Orden+"&CmpSentido="+Sentido,
			success: function(html){
				$('#CapReportePersonalFichaIngreso').html(html);	
			}
		});

	}

}

function FncReportePersonalFichaIngresoImprimir(){
	
	if(FncReportePersonalFichaIngresoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Detalle = $("#CmpDetalle").val();
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
	
		FncPopUp("formularios/Reporte/IfrReportePersonalFichaIngreso.php?CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpDetalle="+Detalle+"&CmpSucursal="+Sucursal+"&CmpOrden="+Orden+"&CmpSentido="+Sentido+"&P=1");
		
	}

}

function FncReportePersonalFichaIngresoGenerarExcel(){
	
	if(FncReportePersonalFichaIngresoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Detalle = $("#CmpDetalle").val();
		
		var Sucursal = $("#CmpSucursal").val();
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		//FncPopUp("formularios/Reporte/XLSReportePersonalFichaIngreso.php?CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=2");
		FncPopUp("formularios/Reporte/IfrReportePersonalFichaIngreso.php?CmpFechaInicio="+FechaInicio+"&CmpFechaFin="+FechaFin+"&CmpDetalle="+Detalle+"&CmpSucursal="+Sucursal+"&CmpOrden="+Orden+"&CmpSentido="+Sentido+"&P=2");
		
	}
	
}

function FncReportePersonalFichaIngresoNuevo(){

}




/* **************************** */



/*


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
}*/