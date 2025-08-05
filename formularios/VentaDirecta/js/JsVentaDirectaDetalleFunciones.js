// JavaScript Document

function FncVentaDirectaDetalleNuevo(){
	
	$('#CmpVentaDirectaDetalleId').val("");
	
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
	$('#CmpVentaDirectaDetalleEstado').val("1");	
	
	$('#CmpProductoItem').val("");	
	
	$('#CmpVentaDirectaDetalleTipoPedido').val("NORMAL");	
	
	$('#CmpVentaDirectaDetallePorcentajeUtilidad').val("0.00");	
	$('#CmpVentaDirectaDetallePorcentajeOtroCosto').val("0.00");
	$('#CmpVentaDirectaDetallePorcentajeManoObra').val("0.00");
	$('#CmpVentaDirectaDetallePorcentajeDescuento').val("0.00");
	
	$('#CmpVentaDirectaDetallePorcentajeAdicional').val("0.00");
	$('#CmpVentaDirectaDetallePorcentajeDescuento').val("0.00");
	
	$('#CmpVentaDirectaDetalleValorVenta').val("");
	$('#CmpVentaDirectaDetalleAdicional').val("0.00");
	$('#CmpVentaDirectaDetalleDescuento').val("0.00");	
	
	$('#CapProductoAccion').html('Listo para registrar elementos');	

	$('#CmpProductoCodigoOriginal').focus();
			
	$('#CmpVentaDirectaDetalleAccion').val("AccVentaDirectaDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");
	
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);

	$('#CmpVentaDirectaDetallePorcentajeUtilidad').attr('readonly', true);
	$('#CmpVentaDirectaDetallePorcentajeOtroCosto').attr('readonly', true);
	$('#CmpVentaDirectaDetallePorcentajeManoObra').attr('readonly', true);
	$('#CmpVentaDirectaDetallePorcentajePedido').attr('readonly', true);
	
	$('#CmpVentaDirectaDetallePorcentajeDescuento').attr('readonly', true);
	$('#CmpVentaDirectaDetallePorcentajeAdicional').attr('readonly', true);

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
			var ProductoImporteBruto = $('#CmpProductoImporteBruto').val();
			
			var ProductoPrecio = $('#CmpProductoPrecio').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			
			var VentaDirectaDetalleEstado = $('#CmpVentaDirectaDetalleEstado').val();	
			
			var Item = $('#CmpProductoItem').val();
			
			var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginal').val();	
			var ProductoCodigoAlternativo = $('#CmpProductoCodigoAlternativo').val();
			
			var VentaDirectaDetalleTipoPedido = $('#CmpVentaDirectaDetalleTipoPedido').val();		
			
			var VentaDirectaDetallePorcentajeUtilidad = $('#CmpVentaDirectaDetallePorcentajeUtilidad').val();
			var VentaDirectaDetallePorcentajeOtroCosto = $('#CmpVentaDirectaDetallePorcentajeOtroCosto').val();
			var VentaDirectaDetallePorcentajeManoObra = $('#CmpVentaDirectaDetallePorcentajeManoObra').val();			
			var VentaDirectaDetallePorcentajePedido = $('#CmpVentaDirectaDetallePorcentajePedido').val();			
			
			var VentaDirectaDetallePorcentajeAdicional = $('#CmpVentaDirectaDetallePorcentajeAdicional').val();			
			var VentaDirectaDetallePorcentajeDescuento = $('#CmpVentaDirectaDetallePorcentajeDescuento').val();			
			
			var VentaDirectaDetalleValorVenta = $('#CmpVentaDirectaDetalleValorVenta').val();			
			var VentaDirectaDetalleDescuento = $('#CmpVentaDirectaDetalleDescuento').val();			
			var VentaDirectaDetalleDescuentoUnitario = $('#CmpVentaDirectaDetalleDescuentoUnitario').val();			
			var VentaDirectaDetalleAdicional = $('#CmpVentaDirectaDetalleAdicional').val();			
			var VentaDirectaDetalleAdicionalUnitario = $('#CmpVentaDirectaDetalleAdicionalUnitario').val();			
			
			
			if(ProductoId == ""){
				
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
				
			}else if(VentaDirectaDetalleTipoPedido==""){
				
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de pedido",
					callback: function(result){
					 $('#CmpVentaDirectaDetalleTipoPedido').focus();	
					}
				});
				
			}else if(ProductoCantidad==""){
				
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
					url: 'formularios/VentaDirecta/acc/'+Acc,
					data: 'Identificador='+Identificador+
					'&ProductoId='+ProductoId+
					'&ProductoCosto='+ProductoCosto+
					'&ProductoValorVenta='+ProductoValorVenta+
					
					'&ProductoPrecioBruto='+ProductoPrecioBruto+
					'&ProductoImporteBruto='+ProductoImporteBruto+
							
					'&ProductoPrecio='+ProductoPrecio+
					'&ProductoCantidad='+ProductoCantidad+
					'&ProductoImporte='+ProductoImporte+
					
					'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
					'&ProductoUnidadMedida='+ProductoUnidadMedida+					
					'&VentaDirectaDetalleEstado='+VentaDirectaDetalleEstado+
					
					'&VentaDirectaDetalleTipoPedido='+VentaDirectaDetalleTipoPedido+
					
					'&VentaDirectaDetallePorcentajeUtilidad='+VentaDirectaDetallePorcentajeUtilidad+
					'&VentaDirectaDetallePorcentajeOtroCosto='+VentaDirectaDetallePorcentajeOtroCosto+
					'&VentaDirectaDetallePorcentajeManoObra='+VentaDirectaDetallePorcentajeManoObra+
					'&VentaDirectaDetallePorcentajePedido='+VentaDirectaDetallePorcentajePedido+
					
					'&VentaDirectaDetallePorcentajeAdicional='+VentaDirectaDetallePorcentajeAdicional+
					'&VentaDirectaDetallePorcentajeDescuento='+VentaDirectaDetallePorcentajeDescuento+
					
					'&VentaDirectaDetalleDescuento='+VentaDirectaDetalleDescuento+
					'&VentaDirectaDetalleDescuentoUnitario='+VentaDirectaDetalleDescuentoUnitario+
					'&VentaDirectaDetalleAdicional='+VentaDirectaDetalleAdicional+
					'&VentaDirectaDetalleAdicionalUnitario='+VentaDirectaDetalleAdicionalUnitario+
							
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
//						Parametro22 = VddId
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

//						Parametro37 = VddValorVenta
//						Parametro38 = VddDescuento
//						Parametro39 = VddPorcentajeUtilidad
//						Parametro40 = VddPorcentajeOtroCosto
//						Parametro41 = VddPorcentajeManoObra
//						Parametro42 = VddPorcentajePedido

//						Parametro43 = VddPorcentajeAdicional
//						Parametro44 = VddPorcentajeDescuento
//						Parametro45 = VddAdicional
//						Parametro46 = VddDescuentoUnitario
//						Parametro47 = VddImporteBruto
//						Parametro48 = VddAdicionalUnitario
*/

			$('#CmpProductoId').val(InsVentaDirectaDetalle.Parametro2);	
			$('#CmpProductoCodigoOriginal').val(InsVentaDirectaDetalle.Parametro13);
			$('#CmpProductoCodigoAlternativo').val(InsVentaDirectaDetalle.Parametro14);
			
			$('#CmpProductoUnidadMedidaEquivalente').val(1);
			
			$('#CmpProductoNombre').val(InsVentaDirectaDetalle.Parametro3);		
			
			$('#CmpProductoCosto').val(InsVentaDirectaDetalle.Parametro17);
			$('#CmpProductoCostoAux').val(InsVentaDirectaDetalle.Parametro17);
			$('#CmpProductoValorVenta').val(InsVentaDirectaDetalle.Parametro37);	
			
			$('#CmpProductoPrecioBruto').val(InsVentaDirectaDetalle.Parametro36);	
			$('#CmpProductoImporteBruto').val(InsVentaDirectaDetalle.Parametro47);	
			
			$('#CmpProductoPrecio').val(InsVentaDirectaDetalle.Parametro4);	
			$('#CmpProductoCantidad').val(InsVentaDirectaDetalle.Parametro5);
			$('#CmpProductoImporte').val(InsVentaDirectaDetalle.Parametro6);
			
			$('#CmpVentaDirectaDetalleEstado').val(InsVentaDirectaDetalle.Parametro26);
			
			$('#CmpVentaDirectaDetalleTipoPedido').val(InsVentaDirectaDetalle.Parametro35);
			
			$('#CmpVentaDirectaDetallePorcentajeUtilidad').val(InsVentaDirectaDetalle.Parametro39);
			$('#CmpVentaDirectaDetallePorcentajeOtroCosto').val(InsVentaDirectaDetalle.Parametro40);
			$('#CmpVentaDirectaDetallePorcentajeManoObra').val(InsVentaDirectaDetalle.Parametro41);
			$('#CmpVentaDirectaDetallePorcentajePedido').val(InsVentaDirectaDetalle.Parametro42);
				
			$('#CmpVentaDirectaDetallePorcentajeAdicional').val(InsVentaDirectaDetalle.Parametro43);
			$('#CmpVentaDirectaDetallePorcentajeDescuento').val(InsVentaDirectaDetalle.Parametro44);
				
			$('#CmpVentaDirectaDetalleValorVenta').val(InsVentaDirectaDetalle.Parametro37);
				
			$('#CmpVentaDirectaDetalleDescuento').val(InsVentaDirectaDetalle.Parametro46);
			$('#CmpVentaDirectaDetalleAdicional').val(InsVentaDirectaDetalle.Parametro48);
			
		//	$('#CmpVentaDirectaDetalleDescuento').val(InsVentaDirectaDetalle.Parametro38);
//			$('#CmpVentaDirectaDetalleDescuentoUnitario').val(InsVentaDirectaDetalle.Parametro46);
//			$('#CmpVentaDirectaDetalleAdicional').val(InsVentaDirectaDetalle.Parametro45);
//			$('#CmpVentaDirectaDetalleAdicionalUnitario').val(InsVentaDirectaDetalle.Parametro48);
//			
			$('#CmpVentaDirectaDetalleId').val(InsVentaDirectaDetalle.Parametro1);
				
			$('#CmpProductoItem').val(InsVentaDirectaDetalle.Item);

			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsVentaDirectaDetalle.Parametro11+"&Tipo=2&UnidadMedidaId="+InsVentaDirectaDetalle.Parametro15,{}, function(j){
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
				
				if($(this).val() == "URGENTE"){
					$('#CmpVentaDirectaDetallePorcentajePedido').val("10.00");
				}else{
					$('#CmpVentaDirectaDetallePorcentajePedido').val("0.00");
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
								$('#CmpVentaDirectaDetallePorcentajeOtroCosto').val(j.LprPorcentajeOtroCosto);
								$('#CmpVentaDirectaDetallePorcentajeUtilidad').val(j.LprPorcentajeUtilidad);
								$('#CmpVentaDirectaDetallePorcentajeManoObra').val(j.LprPorcentajeManoObra);
								$('#CmpVentaDirectaDetallePorcentajePedido').val("0.00");
								
								$('#CmpVentaDirectaDetallePorcentajeAdicional').val(j.LprPorcentajeAdicional);
								$('#CmpVentaDirectaDetallePorcentajeDescuento').val(j.LprPorcentajeDescuento);
								
								/*
								BLOQUEANDO CAJAS CALCULADORA PRECIOS
								*/
								$("#CmpVentaDirectaDetallePorcentajeOtroCosto").attr('readonly', true);
								$("#CmpVentaDirectaDetallePorcentajeUtilidad").attr('readonly', true);
								$("#CmpVentaDirectaDetallePorcentajeManoObra").attr('readonly', true);
								$("#CmpVentaDirectaDetallePorcentajePedido").attr('readonly', true);
								
								$('#CmpVentaDirectaDetallePorcentajeAdicional').removeAttr('readonly');
								$('#CmpVentaDirectaDetallePorcentajeDescuento').removeAttr('readonly');		
							
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
	
	$('#CmpVentaDirectaDetallePorcentajeUtilidad').attr('readonly', false);
	$('#CmpVentaDirectaDetallePorcentajeManoObra').attr('readonly', false);
	$('#CmpVentaDirectaDetallePorcentajeOtroCosto').attr('readonly', false);
	$('#CmpVentaDirectaDetallePorcentajeDescuento').attr('readonly', false);
	
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
