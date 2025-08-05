// JavaScript Document

function FncCotizacionProductoDetalleNuevo(){
	
	$('#CmpCotizacionProductoDetalleId').val("");
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");

	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoCodigoAlternativo').val("");	
	
	$('#CmpProductoCosto').val("");
	$('#CmpProductoCostoAux').val("");
	
	$('#CmpProductoValorVenta').val("");
	$('#CmpProductoPrecioBruto').val("");		
	$('#CmpProductoImporteBruto').val("");		

	$('#CmpProductoPrecio').val("");	
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoImporte').val("");
	$('#CmpProductoEstado').val("");
	
	$('#CmpProductoItem').val("");	
	
	$('#CmpCotizacionProductoDetalleTipoPedido').val("NORMAL");	
	
	$('#CmpCotizacionProductoDetallePorcentajeOtroCosto').val("0.00");
	$('#CmpCotizacionProductoDetallePorcentajeUtilidad').val("0.00");
	$('#CmpCotizacionProductoDetallePorcentajeManoObra').val("0.00");
	$('#CmpCotizacionProductoDetallePorcentajePedido').val("0.00");
	
	$('#CmpCotizacionProductoDetallePorcentajeAdicional').val("0.00");
	$('#CmpCotizacionProductoDetallePorcentajeDescuento').val("0.00");
	
	$('#CmpCotizacionProductoDetalleValorVenta').val("0.00");
	$('#CmpCotizacionProductoDetalleAdicional').val("0.00");
	$('#CmpCotizacionProductoDetalleDescuento').val("0.00");
	
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').focus();
			
	$('#CmpCotizacionProductoDetalleAccion').val("AccCotizacionProductoDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");
	
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
	$('#CmpCotizacionProductoDetallePorcentajeOtroCosto').attr('readonly', true);
	$('#CmpCotizacionProductoDetallePorcentajeUtilidad').attr('readonly', true);
	$('#CmpCotizacionProductoDetallePorcentajeManoObra').attr('readonly', true);
	$('#CmpCotizacionProductoDetallePorcentajePedido').attr('readonly', true);
	
	$('#CmpCotizacionProductoDetallePorcentajeAdicional').attr('readonly', true);
	$('#CmpCotizacionProductoDetallePorcentajeDescuento').attr('readonly', true);
	
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
			var ProductoImporteBruto = $('#CmpProductoImporteBruto').val();
			
			var ProductoPrecio = $('#CmpProductoPrecio').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			
			var ProductoEstado = $('#CmpProductoEstado').val();
			
			var Item = $('#CmpProductoItem').val();
			
			var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginal').val();	
			var ProductoCodigoAlternativo = $('#CmpProductoCodigoAlternativo').val();
			
			var CotizacionProductoDetalleTipoPedido = $('#CmpCotizacionProductoDetalleTipoPedido').val();	

			var CotizacionProductoDetallePorcentajeUtilidad = $('#CmpCotizacionProductoDetallePorcentajeUtilidad').val();
			var CotizacionProductoDetallePorcentajeOtroCosto = $('#CmpCotizacionProductoDetallePorcentajeOtroCosto').val();
			var CotizacionProductoDetallePorcentajeManoObra = $('#CmpCotizacionProductoDetallePorcentajeManoObra').val();
			var CotizacionProductoDetallePorcentajePedido = $('#CmpCotizacionProductoDetallePorcentajePedido').val();
			
			var CotizacionProductoDetallePorcentajeAdicional = $('#CmpCotizacionProductoDetallePorcentajeAdicional').val();			
			var CotizacionProductoDetallePorcentajeDescuento = $('#CmpCotizacionProductoDetallePorcentajeDescuento').val();
			
			var CotizacionProductoDetalleValorVenta = $('#CmpCotizacionProductoDetalleValorVenta').val();			
			var CotizacionProductoDetalleDescuento = $('#CmpCotizacionProductoDetalleDescuento').val();			
			var CotizacionProductoDetalleDescuentoUnitario = $('#CmpCotizacionProductoDetalleDescuentoUnitario').val();			
			var CotizacionProductoDetalleAdicional = $('#CmpCotizacionProductoDetalleAdicional').val();			
			var CotizacionProductoDetalleAdicionalUnitario = $('#CmpCotizacionProductoDetalleAdicionalUnitario').val();			
			
			if(ProductoId == ""){	
				//alert("No existe el PRODUCTO");
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"El producto ingresado no existe en sistema",
					callback: function(result){
						FncProductoCargarFormulario("Registrar");
					}
				});
				
				
			}else if(ProductoNombre==""){
				
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre de producto",
					callback: function(result){
						$('#CmpProductoNombre').focus();	
					}
				});
				
			}else if(ProductoUnidadMedidaConvertir==""){
				
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una unidad de medida",
					callback: function(result){
					 $('#CmpProductoUnidadMedidaConvertir').focus();	
					}
				});
				
			}else if(CotizacionProductoDetalleTipoPedido==""){
				
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de pedido",
					callback: function(result){
					 $('#CmpCotizacionProductoDetalleTipoPedido').focus();	
					}
				});
				
			//}else if(ProductoCantidad=="" || ProductoCantidad <=0){
			}else if(ProductoCantidad=="" ){
				
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una cantidad",
					callback: function(result){
					 $('#CmpProductoCantidad').focus();	
					}
				});
				
			}else if(ProductoPrecio=="" ){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un precio",
					callback: function(result){
					 $('#CmpProductoPrecio').focus();	
					}
				});
				
			}else if(ProductoImporte==""){
				
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un importe",
					callback: function(result){
					 $('#CmpProductoImporte').focus();	
					}
				});
							
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
							'&ProductoImporteBruto='+ProductoImporteBruto+
							
							'&ProductoPrecio='+ProductoPrecio+							
							'&ProductoCantidad='+ProductoCantidad+
							'&ProductoImporte='+ProductoImporte+
							
							'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
							'&ProductoUnidadMedida='+ProductoUnidadMedida+
							'&ProductoEstado='+ProductoEstado+
							
							'&CotizacionProductoDetalleTipoPedido='+CotizacionProductoDetalleTipoPedido+
							
							'&CotizacionProductoDetallePorcentajeUtilidad='+CotizacionProductoDetallePorcentajeUtilidad+
							'&CotizacionProductoDetallePorcentajeOtroCosto='+CotizacionProductoDetallePorcentajeOtroCosto+
							'&CotizacionProductoDetallePorcentajeManoObra='+CotizacionProductoDetallePorcentajeManoObra+
							'&CotizacionProductoDetallePorcentajePedido='+CotizacionProductoDetallePorcentajePedido+
							
							'&CotizacionProductoDetallePorcentajeAdicional='+CotizacionProductoDetallePorcentajeAdicional+
							'&CotizacionProductoDetallePorcentajeDescuento='+CotizacionProductoDetallePorcentajeDescuento+
							
							'&CotizacionProductoDetalleDescuento='+CotizacionProductoDetalleDescuento+
							'&CotizacionProductoDetalleDescuentoUnitario='+CotizacionProductoDetalleDescuentoUnitario+
							'&CotizacionProductoDetalleAdicional='+CotizacionProductoDetalleAdicional+
							'&CotizacionProductoDetalleAdicionalUnitario='+CotizacionProductoDetalleAdicionalUnitario+
											
							'&CotizacionProductoDetalleValorVenta='+CotizacionProductoDetalleValorVenta+
							
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
	var DescuentoPorcentaje = $('#CmpPorcentajeDescuento').val();
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	
	//alert(TipoCambio);
	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionProducto/FrmCotizacionProductoDetalleListado.php',
		data: 'Editar='+CotizacionProductoDetalleEditar+'&Eliminar='+CotizacionProductoDetalleEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&ManoObra='+ManoObra+'&IncluyeImpuesto='+IncluyeImpuesto+'&DescuentoPorcentaje='+DescuentoPorcentaje+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&Identificador='+Identificador,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapCotizacionProductoDetalles").html("");
			$("#CapCotizacionProductoDetalles").append(html);
			
				var i = 0;
				
				$('input[type=checkbox]').each(function () {
					
					if($(this).attr('etiqueta')=="detalle"){

							var Sigla = $(this).val();
						
							$("#CmpCotizacionProductoDetalleEstado_"+Sigla).change(function(){
								
								$.ajax({
									type: 'POST',
									url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoDetalleEditarEstado.php',
									data: 'CotizacionProductoDetalleEstado='+$(this).val()+
									'&Identificador='+Identificador+
									'&Item='+Sigla,
									success: function(){
										
								
									}
								});
								
							});
							
							$("#CmpCotizacionProductoDetalleObservacion_"+Sigla).keyup(function(){
											
								 clearTimeout($.data(this, 'timer'));
								  var wait = setTimeout("FncCotizacionProductoDetalleEditarObservacion('"+Sigla+"');", 1500);
								  $(this).data('timer', wait);
			
							});
			
			
			
					}			 
				});
	
					
					
			
		
			
			
			
		}
	});

}



function FncCotizacionProductoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	var Redondear = $("#CmpRedondear").attr('checked', true);	
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpCotizacionProductoDetalleAccion').val("AccCotizacionProductoDetalleEditar.php");
	
	var ClienteMargenUtilidad = $("#CmpClienteMargenUtilidad").val();
	var Flete = $("#CmpPorcentajeOtroCosto").val();

	var IncluyeImpuesto = $("#CmpIncluyeImpuesto").val();
	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
	var Seguro = $("#CmpSeguro").val();
	
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
//						Parametro16 = CrdDescripcion
//						Parametro17 = CrdCodigo
//						Parametro18 = CrdValorVenta

//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

//						Parametro25 = CrdPorcentajeUtilidad
//						Parametro26 = CrdPorcentajeOtroCosto
//						Parametro27 = CrdPorcentajeManoObra
//						Parametro28 = CrdPorcentajePedido

//						Parametro29 = CrdPorcentajeAdicional
//						Parametro30 = CrdPorcentajeDescuento
//						Parametro31 = CrdAdicional
//						Parametro32 = CrdDescuentoUnitario
//						Parametro33 = CrdImporteBruto
//						Parametro34 = CrdAdicionalUnitario

				$('#CmpProductoId').val(InsCotizacionProductoDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsCotizacionProductoDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsCotizacionProductoDetalle.Parametro14);

				$('#CmpProductoUnidadMedidaEquivalente').val(1);

				$('#CmpProductoNombre').val(InsCotizacionProductoDetalle.Parametro3);

				$('#CmpProductoCosto').val(InsCotizacionProductoDetalle.Parametro20);	
				$('#CmpProductoCostoAux').val(InsCotizacionProductoDetalle.Parametro20);	
				$('#CmpProductoValorVenta').val(InsCotizacionProductoDetalle.Parametro18);	

				$('#CmpProductoPrecioBruto').val(InsCotizacionProductoDetalle.Parametro24);	
				$('#CmpProductoImporteBruto').val(InsCotizacionProductoDetalle.Parametro33);	
				
				$('#CmpProductoPrecio').val(InsCotizacionProductoDetalle.Parametro4);	
				$('#CmpProductoCantidad').val(InsCotizacionProductoDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsCotizacionProductoDetalle.Parametro6);
				
				$('#CmpProductoEstado').val(InsCotizacionProductoDetalle.Parametro21);
				
				$('#CmpCotizacionProductoDetalleTipoPedido').val(InsCotizacionProductoDetalle.Parametro22);
				
				$('#CmpCotizacionProductoDetallePorcentajeUtilidad').val(InsCotizacionProductoDetalle.Parametro25);
				$('#CmpCotizacionProductoDetallePorcentajeOtroCosto').val(InsCotizacionProductoDetalle.Parametro26);
				$('#CmpCotizacionProductoDetallePorcentajeManoObra').val(InsCotizacionProductoDetalle.Parametro27);
				$('#CmpCotizacionProductoDetallePorcentajePedido').val(InsCotizacionProductoDetalle.Parametro28);
				
				$('#CmpCotizacionProductoDetallePorcentajeAdicional').val(InsCotizacionProductoDetalle.Parametro29);
				$('#CmpCotizacionProductoDetallePorcentajeDescuento').val(InsCotizacionProductoDetalle.Parametro30);
				
				$('#CmpCotizacionProductoDetalleValorVenta').val(InsCotizacionProductoDetalle.Parametro18);
				
				$('#CmpCotizacionProductoDetalleDescuento').val(InsCotizacionProductoDetalle.Parametro32);
				
				//$('#CmpCotizacionProductoDetalleDescuento').val(InsCotizacionProductoDetalle.Parametro23);
				//$('#CmpCotizacionProductoDetalleDescuentoUnitario').val(InsCotizacionProductoDetalle.Parametro32);
				//$('#CmpCotizacionProductoDetalleAdicional').val(InsCotizacionProductoDetalle.Parametro31);
				//$('#CmpCotizacionProductoDetalleAdicionalUnitario').val(InsCotizacionProductoDetalle.Parametro34);
			
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
				
				if($(this).val() == "URGENTE"){
					$('#CmpCotizacionProductoDetallePorcentajePedido').val("10.00");
				}else{
					$('#CmpCotizacionProductoDetallePorcentajePedido').val("0.00");
				}
				
				FncCalcularMostrarImporteFinal();
			
			});
			  
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){

				var UnidadMedidaConvertir = $(this).val();
				
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsProducto.UmeId+"&UnidadMedida2="+UnidadMedidaConvertir,{}, 
				function(j){
					
					$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
						
					$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+InsProducto.ProId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+UnidadMedidaConvertir,{}, 
							function(j){
								
								console.log("LprCosto: "+j.LprCosto);				
								console.log("LprValorVenta: "+j.LprValorVenta);
								console.log("LprPrecio: "+j.LprPrecio);
								
								if(EmpresaMonedaId == MonedaId){
									Costo = (j.LprCosto);
									ValorVenta = (j.LprValorVenta);
									Precio = (j.LprPrecio);
								}else{
									Costo = j.LprCosto / TipoCambio;
									ValorVenta = j.LprValorVenta / TipoCambio;
									Precio = j.LprPrecio / TipoCambio;
								}
								
								if(Precio == 0 || Precio == null){	
									console.log("NO TIENE PRECIO SISTEMA");
									alert("No se encontro precio en LISTA DE SISTEMA. Proceso Cancelado");
									Precio = 0;
								}else{						
									console.log("TIENE PRECIO SISTEMA");	
								}
								
								Costo = Math.round(Costo*100)/100;		
								
								$("#CmpProductoCosto").val(Costo);	
								$("#CmpProductoValorVenta").val(ValorVenta);	
								
								$("#CmpProductoPrecio").val(Precio);
								$("#CmpProductoCantidad").val("1");
								$("#CmpProductoImporte").val(Precio);	
								
//								if(Seguro==""){
//						
//									$("#CmpProductoPrecio").attr('readonly', true);
//									$("#CmpProductoImporte").attr('readonly', true);
//						
//								}else{
//						
//									$('#CmpProductoPrecio').removeAttr('readonly');
//									$('#CmpProductoImporte').removeAttr('readonly');
//						
//								}
								
								
								/*
								CALCULADORA PRECIOS
								*/
								$('#CmpCotizacionProductoDetallePorcentajeOtroCosto').val(j.LprPorcentajeOtroCosto);
								$('#CmpCotizacionProductoDetallePorcentajeUtilidad').val(j.LprPorcentajeUtilidad);
								$('#CmpCotizacionProductoDetallePorcentajeManoObra').val(j.LprPorcentajeManoObra);
								$('#CmpCotizacionProductoDetallePorcentajePedido').val("0.00");
								
								$('#CmpCotizacionProductoDetallePorcentajeAdicional').val(j.LprPorcentajeAdicional);
								$('#CmpCotizacionProductoDetallePorcentajeDescuento').val(j.LprPorcentajeDescuento);
								
								/*
								BLOQUEANDO CAJAS CALCULADORA PRECIOS
								*/
								$("#CmpCotizacionProductoDetallePorcentajeOtroCosto").attr('readonly', true);
								$("#CmpCotizacionProductoDetallePorcentajeUtilidad").attr('readonly', true);
								$("#CmpCotizacionProductoDetallePorcentajeManoObra").attr('readonly', true);
								$("#CmpCotizacionProductoDetallePorcentajePedido").attr('readonly', true);
								
								$('#CmpCotizacionProductoDetallePorcentajeAdicional').removeAttr('readonly');
								$('#CmpCotizacionProductoDetallePorcentajeDescuento').removeAttr('readonly');		
							
					});

				});

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
	BLOQUEANDO CAJAS CALCULADORA PRECIOS
	*/
	$("#CmpCotizacionProductoDetallePorcentajeOtroCosto").attr('readonly', true);
	$("#CmpCotizacionProductoDetallePorcentajeUtilidad").attr('readonly', true);
	$("#CmpCotizacionProductoDetallePorcentajeManoObra").attr('readonly', true);
	$("#CmpCotizacionProductoDetallePorcentajePedido").attr('readonly', true);
	
	$('#CmpCotizacionProductoDetallePorcentajeAdicional').removeAttr('readonly');
	$('#CmpCotizacionProductoDetallePorcentajeDescuento').removeAttr('readonly');	
	
	//if(Seguro==""){
//	
//		$("#CmpProductoPrecio").attr('readonly', true);
//		$("#CmpProductoImporte").attr('readonly', true);
//	
//	}else{
//	
//		$('#CmpProductoPrecio').removeAttr('readonly');
//		$('#CmpProductoImporte').removeAttr('readonly');
//	
//	}

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




function FncCotizacionProductoDetalleEditarObservacion(oItem){
	
	console.log("FncCotizacionProductoDetalleEditarObservacion");

		var Identificador = $('#Identificador').val();
	var Dato = $("#CmpCotizacionProductoDetalleObservacion_"+oItem).val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoDetalleEditarObservacion.php',
		data: 'CotizacionProductoDetalleObservacion='+Dato+'&Item='+oItem+'&Identificador='+Identificador,
		success: function(html){
		
			//$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html(html);
			console.log("ResultadoEditar: "+html);
	
		}
	});


}