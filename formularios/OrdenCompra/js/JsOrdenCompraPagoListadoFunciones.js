function FncOrdenCompraPagar(){

	if($("#CmpOrdenCompraPedidoCancelado").is(':checked')){		

	
		$('input[type=checkbox]').each(function () {

			if($(this).attr('name')=="CmpAgregarSeleccionado[]"){

				$("#CmpAlmacenMovimientoEntradaCancelado_"+$(this).val()).val("1");
				
				FncOrdenCompraPagoAccion($(this).val());
			}

		});

	}else{

		$('input[type=checkbox]').each(function () {

			if($(this).attr('name')=="CmpAgregarSeleccionado[]"){

				$("#CmpAlmacenMovimientoEntradaCancelado_"+$(this).val()).val("2");
				
				FncOrdenCompraPagoAccion($(this).val());
				
			}

		});

	}

}


function FncOrdenCompraPagoSeleccionar(){
	
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
	

	$('#CmpSeleccionados').val(seleccionados);

}

function FncOrdenCompraPagoCargarListado(){
	
	var CmpFechaInicio = $("#CmpFechaInicio").val();
	var CmpFechaFin = $("#CmpFechaFin").val();
	var CmpOrden = $("#CmpOrden").val();
	var CmpSentido = $("#CmpSentido").val();
	
	var CmpMoneda = $("#CmpMoneda").val();
	
	var CmpProveedorId = $("#CmpProveedorId").val();
	var CmpProveedorNombre = $("#CmpProveedorNombre").val();
	var CmpProveedorNumeroDocumento = $("#CmpProveedorNumeroDocumento").val();
	var CmpCancelado = $("#CmpCancelado").val();
	
	$("#CapOrdenCompraPago").html("Cargando...");
	
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenCompra/IfrOrdenCompraPagoListado.php',
			data: 'CmpFechaInicio='+CmpFechaInicio+'&CmpFechaFin='+CmpFechaFin+'&CmpOrden='+CmpOrden+'&CmpSentido='+CmpSentido+'&CmpProveedorId='+CmpProveedorId+'&CmpProveedorNombre='+CmpProveedorNombre+'&CmpProveedorNumeroDocumento='+CmpProveedorNumeroDocumento+'&CmpMoneda='+CmpMoneda+'&CmpCancelado='+CmpCancelado,
			success: function(html){
			
	
				$("#CapOrdenCompraPago").html(html);
	
				$("#CmpOrdenCompraPedidoCancelado").click(function(){
					FncOrdenCompraPagar();
				});

			
			}
		});
					
}

function FncOrdenCompraPagoAccion(oAlmacenMovimientoEntradaId){


	var AlmacenMovimientoEntradaCancelado = $("#CmpAlmacenMovimientoEntradaCancelado_"+oAlmacenMovimientoEntradaId).val();
	
	$("#CapOrdenCompraPagoAccion_"+oAlmacenMovimientoEntradaId).html("Guardando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenCompra/acc/AccOrdenCompraPagoEditar.php',
		data: 'AlmacenMovimientoEntradaId='+oAlmacenMovimientoEntradaId+'&AlmacenMovimientoEntradaCancelado='+AlmacenMovimientoEntradaCancelado,
		success: function(html){

			$("#CapOrdenCompraPagoAccion_"+oAlmacenMovimientoEntradaId).html("Listo");
			FncOrdenCompraPagoSumaTotal(oAlmacenMovimientoEntradaId);
		}
	});

}




function FncOrdenCompraPagoSumaTotal(oAlmacenMovimientoEntradaId){

	var SumaTotal = 0;
	var Total = 0;
	
	$('input[type=checkbox]').each(function () {

		if($(this).attr('etiqueta')=="movimiento_entrada"){

			if($('#CmpAlmacenMovimientoEntradaCancelado_'+$(this).val()).val() == "1"){				

				Total = $('#CmpAlmacenMovimientoEntradaTotal_'+$(this).val()).val();
			
				if(Total == ""){
					Total = 0;
				}

				SumaTotal = parseFloat(SumaTotal) + parseFloat(Total);
				SumaTotal = roundToTwo(SumaTotal);
			}
		}			 

	});

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="movimiento_entrada"){
			$("#CapOrdenCompraPagoAccion_"+$(this).val()).html("");
		}			 
	});
	
	$("#CapOrdenCompraPagoAccion_"+oAlmacenMovimientoEntradaId).html(SumaTotal);

}
