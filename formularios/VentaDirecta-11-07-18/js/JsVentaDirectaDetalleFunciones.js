// JavaScript Document

function FncVentaDirectaDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");

	$('#CmpProductoCosto').val("");
	$('#CmpProductoCostoAux').val("");
	$('#CmpProductoPrecioBruto').val("");
	
	$('#CmpProductoPrecio').val("");
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoImporte').val("");
	
	$('#CmpVentaDirectaDetalleEstado').val("1");	
	
	$('#CmpProductoItem').val("");	
	
	$('#CmpVentaDirectaDetalleTipoPedido').val("NORMAL");	
	
	$('#CmpVentaDirectaDetalleMargenPorcentaje').val("");	
	$('#CmpVentaDirectaDetalleFletePorcentaje').val("");
	$('#CmpVentaDirectaDetalleMantenimientoPorcentaje').val("");
	$('#CmpVentaDirectaDetalleDescuentoPorcentaje').val("");
	
	$('#CmpVentaDirectaDetalleValorVenta').val("");
	
	
	
	
	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoCodigoAlternativo').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	

	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpVentaDirectaDetalleAccion').val("AccVentaDirectaDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");
	
	//$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);


	$('#CmpVentaDirectaDetalleMargenPorcentaje').attr('readonly', true);
	$('#CmpVentaDirectaDetalleFletePorcentaje').attr('readonly', true);
	$('#CmpVentaDirectaDetalleMantenimientoPorcentaje').attr('readonly', true);
	$('#CmpVentaDirectaDetalleDescuentoPorcentaje').attr('readonly', true);
	
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
	
	$("#BtnListaPrecioEditar").hide();
}

function FncVentaDirectaDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpVentaDirectaDetalleAccion').val();		
			
			var AlmacenId = $('#CmpProductoId').val();
			
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCosto = $('#CmpProductoCosto').val();
			var ProductoValorVenta = $('#CmpProductoValorVenta').val();
			
			var ProductoPrecioBruto = $('#CmpProductoPrecioBruto').val();
			var ProductoPrecio = $('#CmpProductoPrecio').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			
			var Item = $('#CmpProductoItem').val();
			
			var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginal').val();	
			var ProductoCodigoAlternativo = $('#CmpProductoCodigoAlternativo').val();
			var VentaDirectaDetalleEstado = $('#CmpVentaDirectaDetalleEstado').val();	
			
			var VentaDirectaDetalleTipoPedido = $('#CmpVentaDirectaDetalleTipoPedido').val();		
			
			var VentaDirectaDetalleMargenPorcentaje = $('#CmpVentaDirectaDetalleMargenPorcentaje').val();
			var VentaDirectaDetalleFletePorcentaje = $('#CmpVentaDirectaDetalleFletePorcentaje').val();
			var VentaDirectaDetalleMantenimientoPorcentaje = $('#CmpVentaDirectaDetalleMantenimientoPorcentaje').val();			
			var VentaDirectaDetalleDescuentoPorcentaje = $('#CmpVentaDirectaDetalleDescuentoPorcentaje').val();			
			var VentaDirectaDetalleValorVenta = $('#CmpVentaDirectaDetalleValorVenta').val();			
			
			if(ProductoId == ""){
				
				alert("No existe el PRODUCTO");

				FncProductoCargarFormulario("Registrar");
			
			}else if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertir').focus();	
				
			}else if(VentaDirectaDetalleTipoPedido==""){
				$('#CmpVentaDirectaDetalleTipoPedido').focus();	
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#CmpProductoCantidad').select();	
			}else if(ProductoPrecio=="" || ProductoPrecio=="0"){
				$('#CmpProductoPrecio').select();	
			}else if(ProductoImporte==""){
				$('#CmpProductoImporte').select();						
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
				$.ajax({
					type: 'POST',
					url: 'formularios/VentaDirecta/acc/'+Acc,
					data: 'Identificador='+Identificador+
					'&ProductoId='+ProductoId+
					'&ProductoCosto='+ProductoCosto+
					'&ProductoValorVenta='+ProductoValorVenta+
					'&ProductoPrecioBruto='+ProductoPrecioBruto+
					'&ProductoPrecio='+ProductoPrecio+
					'&ProductoCantidad='+ProductoCantidad+
					'&ProductoImporte='+ProductoImporte+
					'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
					'&ProductoUnidadMedida='+ProductoUnidadMedida+
					
					'&VentaDirectaDetalleEstado='+VentaDirectaDetalleEstado+
					'&VentaDirectaDetalleTipoPedido='+VentaDirectaDetalleTipoPedido+
					
					'&VentaDirectaDetalleMargenPorcentaje='+VentaDirectaDetalleMargenPorcentaje+
					'&VentaDirectaDetalleFletePorcentaje='+VentaDirectaDetalleFletePorcentaje+
					'&VentaDirectaDetalleMantenimientoPorcentaje='+VentaDirectaDetalleMantenimientoPorcentaje+
					'&VentaDirectaDetalleDescuentoPorcentaje='+VentaDirectaDetalleDescuentoPorcentaje+
					'&VentaDirectaDetalleValorVenta='+VentaDirectaDetalleValorVenta+					
					
					'&Item='+Item,
					success: function(){
						
					$('#CapProductoAccion').html('Listo');							
						FncVentaDirectaDetalleListar();
					}
				});
						
				FncVentaDirectaDetalleNuevo();	
					
		}
	
}

function FncVentaDirectaDetalleConfirmar(oItem){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Guardando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/acc/AccVentaDirectaDetalleConfirmar.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(){

			$('#CapProductoAccion').html('Listo');							
			//FncVentaDirectaDetalleListar();
		}

	});

}

function FncVentaDirectaDetalleListar(){

	var Identificador = $('#Identificador').val();

	var PorcentajeImpuestoVenta  = $('#CmpPorcentajeImpuestoVenta').val();
	
	$('#CapProductoAccion').html('Cargando...');
	
	var Descuento = $('#CmpDescuento').val();

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();
	var ManoObra = $('#CmpManoObra').val();
	
	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}
	
	$('#CapVentaDirectaDetalles').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/FrmVentaDirectaDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+VentaDirectaDetalleEditar+
		'&Eliminar='+VentaDirectaDetalleEliminar+
		'&VerEstado='+VentaDirectaDetalleVerEstado+
		'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
		'&ManoObra='+ManoObra+
		'&Descuento='+Descuento+
		'&MonedaId='+MonedaId+
		'&TipoCambio='+TipoCambio+
		'&IncluyeImpuesto='+IncluyeImpuesto+
		'&PorcentajeDescuento='+PorcentajeDescuento ,
		success: function(html){
			
			$('#CapProductoAccion').html('Listo');	
			$("#CapVentaDirectaDetalles").html("");
			$("#CapVentaDirectaDetalles").append(html);
				
		}
	});
	
}



function FncVentaDirectaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	var Redondear = $("#CmpRedondear").attr('checked', true);		
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpVentaDirectaDetalleAccion').val("AccVentaDirectaDetalleEditar.php");
	
	var ClienteMargenUtilidad = $("#CmpClienteMargenUtilidad").val();
	var Flete = $("#CmpPorcentajeOtroCosto").val();
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VentaDirecta/acc/AccVentaDirectaDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsVentaDirectaDetalle){

/*
//						SesionObjeto-VentaDirectaDetalle
//						Parametro1 = VddId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = VddPrecioVenta
//						Parametro5 = VddCantidad
//						Parametro6 = VddImporte
//						Parametro7 = VddTiempoCreacion
//						Parametro8 = VddTiempoModificacion
//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = VddCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo
//						Parametro15 = UmeIdOrigen
//						Parametro16 = VerificarStock
//						Parametro17 = VddCosto
//						Parametro18 = ProStock
//						Parametro19 = ProStockReal
//						Parametro20 = VddCantidadPedir
//						Parametro21 = VddCantidadPedirFecha
//						Parametro22 = CrdId
//						Parametro23 = VddNuevo
//						Parametro24 = VddCantidadPorLlegar
//						Parametro25 = AmdCantidad
//						Parametro26 = VddEstado
//						Parametro27 = VdiId

//						Parametro28 = VddRemplazo
//						Parametro29 = ProIdPedido
//						Parametro30 = ProCodigoOriginalPedido

//						Parametro31 = PcdBOFecha
//						Parametro32 = PcdBOEstado
//						Parametro33 = VddFechaPorLlegar
//						Parametro34 = AmdEstado
//						Parametro35 = VddTipoPedido

//						Parametro36 = VddPrecioBruto
*/

			$('#CmpProductoId').val(InsVentaDirectaDetalle.Parametro2);	
			$('#CmpProductoCodigoOriginal').val(InsVentaDirectaDetalle.Parametro13);
			$('#CmpProductoCodigoAlternativo').val(InsVentaDirectaDetalle.Parametro14);
			$('#CmpProductoUnidadMedidaEquivalente').val(1);
			$('#CmpProductoNombre').val(InsVentaDirectaDetalle.Parametro3);		
			$('#CmpProductoCosto').val(InsVentaDirectaDetalle.Parametro17);
			$('#CmpProductoCostoAux').val(InsVentaDirectaDetalle.Parametro17);
			
			$('#CmpProductoPrecioBruto').val(InsVentaDirectaDetalle.Parametro36);	
			
			$('#CmpProductoPrecio').val(InsVentaDirectaDetalle.Parametro4);	
			$('#CmpProductoCantidad').val(InsVentaDirectaDetalle.Parametro5);
			$('#CmpProductoImporte').val(InsVentaDirectaDetalle.Parametro6);
			
			$('#CmpVentaDirectaDetalleEstado').val(InsVentaDirectaDetalle.Parametro26);
			$('#CmpVentaDirectaDetalleTipoPedido').val(InsVentaDirectaDetalle.Parametro35);
			
			$('#CmpProductoItem').val(InsVentaDirectaDetalle.Item);

			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsVentaDirectaDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsVentaDirectaDetalle.Parametro15,{}, function(j){
				var options = '';
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(j[i].UmeId == InsVentaDirectaDetalle.Parametro10){
						options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}else{
						options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}
				}
				$("select#CmpProductoUnidadMedidaConvertir").html(options);
			})
			

			$('#CmpVentaDirectaDetalleTipoPedido').unbind('change');
			$("select#CmpVentaDirectaDetalleTipoPedido").change(function(){
				
				FncReCalcularMostrarPrecioFinal();
				
								
			});
			
			

			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
					
					$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
					FncReCalcularMostrarPrecioFinal();
	
				})
  
			  });
			
			  
			$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);
			$('#CmpProductoCantidad').select();
		}
	});

	$('#CmpProductoId').attr('readonly', true);
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);
	
	$('#CmpVentaDirectaDetalleMargenPorcentaje').attr('readonly', false);
	$('#CmpVentaDirectaDetalleMantenimientoPorcentaje').attr('readonly', false);
	$('#CmpVentaDirectaDetalleFletePorcentaje').attr('readonly', false);
	$('#CmpVentaDirectaDetalleDescuentoPorcentaje').attr('readonly', false);
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
	$("#BtnListaPrecioEditar").show();

}

function FncVentaDirectaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncVentaDirectaDetalleListar();
			}
		});

		FncVentaDirectaDetalleNuevo("");	

	}
	
}


function FncVentaDirectaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncVentaDirectaDetalleListar();
			}
		});	
			
		FncVentaDirectaDetalleNuevo("");	
	}
	
}











//
//
//function FncProductoCalcularMonto(oTipo){
//
//	var Tipo;
//	var Cantidad = $('#CmpProductoCantidad').val();
//	var Importe = $('#CmpProductoImporte').val();	
//
////alert(Cantidad);
//
//	if(Cantidad!=""){
//		if(Importe!=""){
//			Tipo = Importe/Cantidad;
//			//var Tipo=parseFloat(Tipo);
//			//Tipo=Math.round(Tipo*100000)/100000 ;
////			document.getElementById('CmpProducto'+oTipo).value = Tipo;
//			$('#CmpProducto'+oTipo).val(Tipo);
//		}else{
//			//document.getElementById('CmpProductoImporte').value = 0.00;
//		}
//	}else{
//		//document.getElementById('CmpProductoCantidad').value = 0.00;
//	}
//}
//
//function FncProductoCalcularImporte(oTipo){
//	
//	var Tipo = $('#CmpProducto'+oTipo).val();
//
//	var Cantidad = $('#CmpProductoCantidad').val();
//	var Importe;
//
//	if(Cantidad!=""){
//		if(Tipo!=""){
//			Importe = Tipo * Cantidad;
//			//var Importe=parseFloat(Importe);
//			//Importe=Math.round(Importe*100000)/100000 ;
//			//document.getElementById('CmpProductoImporte').value = Importe;
//			$('#CmpProductoImporte').val(Importe);
//		}else{
//			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
//		}
//	}else{
//		//document.getElementById('CmpProductoCantidad').value = 0.00;
//	}
//}
