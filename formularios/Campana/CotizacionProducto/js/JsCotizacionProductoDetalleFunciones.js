// JavaScript Document

function FncCotizacionProductoDetalleNuevo(){
	
	$('#CmpCotizacionProductoDetalleId').val("");
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");

	$('#CmpProductoCosto').val("");
	$('#CmpProductoCostoAux').val("");

	//$('#CmpProductoValorVenta').val("");
	$('#CmpProductoPrecioBruto').val("");		
	$('#CmpProductoPrecio').val("");	
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoImporte').val("");
	
	$('#CmpProductoEstado').val("");
	
	$('#CmpProductoItem').val("");	
	
	$('#CmpCotizacionProductoDetalleTipoPedido').val("NORMAL");	
	
	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoCodigoAlternativo').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpCotizacionProductoDetalleAccion').val("AccCotizacionProductoDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");
	
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
	
	$("#BtnListaPrecioEditar").hide();	
	
}

function FncCotizacionProductoDetalleGuardar(){

	var Identificador = $('#Identificador').val();
	
		var Acc = $('#CmpCotizacionProductoDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();					
			var ProductoDescripcion = $('#CmpProductoNombre').val();						
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCosto = $('#CmpProductoCosto').val();
			var ProductoValorVenta = $('#CmpProductoValorVenta').val();
			
			var ProductoPrecioBruto = $('#CmpProductoPrecioBruto').val();
			var ProductoPrecio = $('#CmpProductoPrecio').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			
			var ProductoEstado = $('#CmpProductoEstado').val();
			
			var Item = $('#CmpProductoItem').val();
			
			var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginal').val();	
			var ProductoCodigoAlternativo = $('#CmpProductoCodigoAlternativo').val();
			
			var CotizacionProductoDetalleTipoPedido = $('#CmpCotizacionProductoDetalleTipoPedido').val();		
			
			if(ProductoId == ""){	
				alert("No existe el PRODUCTO");
				FncProductoCargarFormulario("Registrar");
			}else if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				alert("Escoja una unidad de medida");
				$('#CmpProductoUnidadMedidaConvertir').focus();	
			}else if(CotizacionProductoDetalleTipoPedido==""){
				$('#CmpCotizacionProductoDetalleTipoPedido').select();	
				
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				alert("No ha ingresado una cantidad");
				$('#CmpProductoCantidad').select();	
			}else if(ProductoPrecio=="" || ProductoPrecio=="0"){
				$('#CmpProductoPrecio').select();	
			}else if(ProductoImporte==""){
				alert("No ha ingresado el importe");
				$('#CmpProductoImporte').select();						
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/CotizacionProducto/acc/'+Acc,
							
							data: 'ProductoId='+ProductoId+
							'&ProductoCodigo='+ProductoCodigoOriginal+
							'&ProductoDescripcion='+ProductoDescripcion+
							'&ProductoCosto='+ProductoCosto+
							'&ProductoValorVenta='+ProductoValorVenta+
							'&ProductoPrecioBruto='+ProductoPrecioBruto+
							'&ProductoPrecio='+ProductoPrecio+
							'&ProductoCantidad='+ProductoCantidad+
							'&ProductoImporte='+ProductoImporte+
							'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
							'&ProductoUnidadMedida='+ProductoUnidadMedida+
							'&ProductoEstado='+ProductoEstado+
							'&CotizacionProductoDetalleTipoPedido='+CotizacionProductoDetalleTipoPedido+
							'&Identificador='+Identificador+'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncCotizacionProductoDetalleListar();
							}
						});
						
						FncCotizacionProductoDetalleNuevo();	
					
					
			}
			
			
	
}


function FncCotizacionProductoDetalleListar(){

	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var ManoObra = $('#CmpManoObra').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	
	//alert(TipoCambio);
	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionProducto/FrmCotizacionProductoDetalleListado.php',
		data: 'Editar='+CotizacionProductoDetalleEditar+'&Eliminar='+CotizacionProductoDetalleEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&ManoObra='+ManoObra+'&IncluyeImpuesto='+IncluyeImpuesto+'&PorcentajeDescuento='+PorcentajeDescuento+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&Identificador='+Identificador,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapCotizacionProductoDetalles").html("");
			$("#CapCotizacionProductoDetalles").append(html);
		}
	});

}



function FncCotizacionProductoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	var Redondear = $("#CmpRedondear").attr('checked', true);	
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpCotizacionProductoDetalleAccion').val("AccCotizacionProductoDetalleEditar.php");
	
	var ClienteMargenUtilidad = $("#CmpClienteMargenUtilidad").val();
	var Flete = $("#CmpFlete").val();

	var IncluyeImpuesto = $("#CmpIncluyeImpuesto").val();
	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
		
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoDetalleEscoger.php',
		data: 'Item='+oItem+'&Identificador='+Identificador,
		success: function(InsCotizacionProductoDetalle){

//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion
//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo
//						Parametro15 = AmdPrecioVenta
//						Parametro16 = 
//						Parametro17 = 
//						Parametro18 = CrdValorVenta
//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

				$('#CmpProductoId').val(InsCotizacionProductoDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsCotizacionProductoDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsCotizacionProductoDetalle.Parametro14);

				$('#CmpProductoUnidadMedidaEquivalente').val(1);

				$('#CmpProductoNombre').val(InsCotizacionProductoDetalle.Parametro3);

				$('#CmpProductoCosto').val(InsCotizacionProductoDetalle.Parametro20);	
				$('#CmpProductoCostoAux').val(InsCotizacionProductoDetalle.Parametro20);	
				$('#CmpProductoValorVenta').val(InsCotizacionProductoDetalle.Parametro18);	

				$('#CmpProductoPrecioBruto').val(InsCotizacionProductoDetalle.Parametro24);	
				$('#CmpProductoPrecio').val(InsCotizacionProductoDetalle.Parametro4);	
				$('#CmpProductoCantidad').val(InsCotizacionProductoDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsCotizacionProductoDetalle.Parametro6);
				
				$('#CmpProductoEstado').val(InsCotizacionProductoDetalle.Parametro21);
				
				$('#CmpCotizacionProductoDetalleTipoPedido').val(InsCotizacionProductoDetalle.Parametro22);

				$('#CmpCotizacionProductoDetalleId').val(InsCotizacionProductoDetalle.Parametro1);

				$('#CmpProductoItem').val(InsCotizacionProductoDetalle.Item);
								
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsCotizacionProductoDetalle.Parametro11+"&Tipo=2&UnidadMedidaId="+InsCotizacionProductoDetalle.Parametro19,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsCotizacionProductoDetalle.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
				})
				
				
			$('#CmpCotizacionProductoDetalleTipoPedido').unbind('change');
			$("select#CmpCotizacionProductoDetalleTipoPedido").change(function(){
				
				var Costo = $('#CmpProductoCostoAux').val();
				
				FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,$(this).val(),Flete,Costo,Redondear);
				FncCalcularMostrarImporte();
			
			});
			  
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){

				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsCotizacionProductoDetalle.Parametro10+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
					
					//var Costo = 0;
//					var CostoAux = $('#CmpProductoCostoAux').val();
//					var TipoPedido = $('#CmpCotizacionProductoDetalleTipoPedido').val();
//					var Precio = 0;
//					
//					Costo = CostoAux * j.UmcEquivalente;
//					Costo = Math.round(Costo*100000)/100000;
//					
//					$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
//					
//					FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,TipoPedido,Flete,Costo);
//					FncCalcularMostrarImporte();

					if(TipoPedido == "ALMACEN"){
						
						$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+UnidadMedidaId,{}, function(j){
						
							if(EmpresaMonedaId == MonedaId){
								  Costo = (j.LprCosto);
								  Precio = (j.LprPrecio);
								  ValorVenta = (j.LprValorVenta);
							}else{
								  Costo = j.LprCosto / TipoCambio;
								  Precio = j.LprPrecio / TipoCambio;
								  ValorVenta = j.LprValorVenta / TipoCambio;
							}
	
							if(Costo == 0){
	
								if(confirm("No se encontro precio en LISTA DE SISTEMA. Proceso Cancelado")){
									//FncCotizacionProductoDetalleNuevo();
									
								}
	
							}else{
								
								$("#CmpProductoPrecio").val(Precio);
								$("#CmpProductoCosto").val(Costo);	
								$("#CmpProductoValorVenta").val(ValorVenta);	
								
								$("#CmpProductoCostoAux").val(Costo);
	
								//FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,TipoPedido,Flete,Costo);
								FncCalcularMostrarImporte();
								
							}
								
						});

					}else{

						Costo = CostoAux * j.UmcEquivalente;
						Costo = Math.round(Costo*100000)/100000;
						
						$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
						
						FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,TipoPedido,Flete,Costo,Redondear);
						FncCalcularMostrarImporte();
						var Precio = $('#CmpProductoPrecio').val();
						//					
						//	Importe = (Precio * 1) * (Cantidad * 1);
						//					
						//	$('#CmpProductoImporte').val(Importe);
										
					}
					
					
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

	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
	$("#BtnListaPrecioEditar").show();

}

function FncCotizacionProductoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncCotizacionProductoDetalleListar();
			}
		});

		FncCotizacionProductoDetalleNuevo();

	}
	
}

function FncCotizacionProductoDetalleEliminarTodo(){
	
	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncCotizacionProductoDetalleListar();
			}
		});	
			
		FncCotizacionProductoDetalleNuevo();
	}
	
}
//
//function FncCotizacionProductoDetalleActualizarPrecio(){
//
//	var ClienteTipoId = $('#CmpClienteTipo').val();
//
//		$('#CapProductoAccion').html('Actualizando Precios...');	
//
//		$.ajax({
//			type: 'POST',
//			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoDetalleActualizarPrecio.php',
//			data: 'Identificador='+Identificador+'&ClienteTipoId='+ClienteTipoId,
//			success: function(){
//				$('#CapProductoAccion').html('Listo');	
//				FncCotizacionProductoDetalleListar();
//			}
//		});	
//
//	FncCotizacionProductoDetalleNuevo();
//	
//}
//
//
//
//
//function FncCotizacionProductoDetalleActualizarMoneda(){
//
//	var ClienteTipoId = $('#CmpClienteTipo').val();
//	var MonedaId = $('#CmpMonedaId').val();
//	var TipoCambio = $('#CmpTipoCambio').val();
//	
//	if(TipoCambio=="" || TipoCambio=="0.000"){
//		TipoCambio = 1;
//	}
//	
//		$('#CapProductoAccion').html('Actualizando Precios...');	
//
//		$.ajax({
//			type: 'POST',
//			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoDetalleActualizarMoneda.php',
//			data: 'Identificador='+Identificador+'&ClienteTipoId='+ClienteTipoId+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
//			success: function(){
//				$('#CapProductoAccion').html('Listo');	
//				FncCotizacionProductoDetalleListar();
//			}
//		});	
//
//	FncCotizacionProductoDetalleNuevo();
//	
//}