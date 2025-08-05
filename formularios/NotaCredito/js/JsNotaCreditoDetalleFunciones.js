// JavaScript Document

function FncNotaCreditoDetalleNuevo(){
	
	$('#CmpNotaCreditoDetalleCodigo').val("");
	$('#CmpNotaCreditoDetalleDescripcion').val("");
	$('#CmpNotaCreditoDetalleUnidadMedida').val("");
	
	$('#CmpNotaCreditoDetallePrecio').val("");
	$('#CmpNotaCreditoDetalleCantidad').val("");
	$('#CmpNotaCreditoDetalleDescuento').val("");
	$('#CmpNotaCreditoDetalleImporte').val("");
	
	$("#CmpNotaCreditoDetalleGratuito").attr('checked', false);
	$("#CmpNotaCreditoDetalleExonerado").attr('checked', false);
	$("#CmpNotaCreditoDetalleIncluyeSelectivo").attr('checked', false);
	
	$('#CmpNotaCreditoDetalleItem').val("");

	$('#CmpNotaCreditoDetalleAccion').val("AccNotaCreditoDetalleRegistrar.php");
	
	$('#CmpNotaCreditoDetalleCantidad').select();

	$('#CapNotaCreditoDetalleAccion').html("Listo para registrar elementos");
	
}

function FncNotaCreditoDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var PorcentajeImpuestoSelectivo = $('#CmpPorcentajeImpuestoSelectivo').val();
	
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	
	var Descripcion = $('#CmpNotaCreditoDetalleDescripcion').val();
	var Codigo = $('#CmpNotaCreditoDetalleCodigo').val();
	var UnidadMedida = $('#CmpNotaCreditoDetalleUnidadMedida').val();
	
	var Precio = $('#CmpNotaCreditoDetallePrecio').val();
	var Cantidad = $('#CmpNotaCreditoDetalleCantidad').val();
	var Importe = $('#CmpNotaCreditoDetalleImporte').val();
	var Descuento = $('#CmpNotaCreditoDetalleDescuento').val();
	
	if($("#CmpNotaCreditoDetalleGratuito").is(':checked')){
		var Gratuito = 1;
	}else{
		var Gratuito = 2;
	}
	
	if($("#CmpNotaCreditoDetalleExonerado").is(':checked')){
		var Exonerado = 1;
	}else{
		var Exonerado = 2;
	}
	
	if($("#CmpNotaCreditoDetalleIncluyeSelectivo").is(':checked')){
		var IncluyeSelectivo = 1;
	}else{
		var IncluyeSelectivo = 2;
	}

	
	var Item = $('#CmpNotaCreditoDetalleItem').val();
	var Acc = $('#CmpNotaCreditoDetalleAccion').val();
	
		if(Descripcion==""){
			$('#CmpNotaCreditoDetalleDescripcion').select();	
		}else if(Precio==""){
			$('#CmpNotaCreditoDetalleImporte').select();	
		}else if(Cantidad=="" || Cantidad <=0){
			$('#CmpNotaCreditoDetalleImporte').select();	
		}else if(Importe==""){
			$('#CmpNotaCreditoDetalleImporte').select();	
		}else{
			$('#CapNotaCreditoDetalleAccion').html('Guardando...');

				$.ajax({
					type: 'POST',
					url: 'formularios/NotaCredito/acc/'+Acc,
					data: 'Identificador='+Identificador+
							
							'&Codigo='+Codigo+
							'&Descripcion='+Descripcion+
							'&UnidadMedida='+UnidadMedida+
	
							'&Precio='+Precio+
							'&Cantidad='+Cantidad+
							'&Importe='+Importe+
							'&Descuento='+Descuento+

							'&Gratuito='+Gratuito+
							'&Exonerado='+Exonerado+
							'&IncluyeImpuesto='+IncluyeImpuesto+
							'&IncluyeSelectivo='+IncluyeSelectivo+

							'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
							'&PorcentajeImpuestoSelectivo='+PorcentajeImpuestoSelectivo+

							'&Item='+Item,
					success: function(){
						$('#CapNotaCreditoDetalleAccion').html('Listo');							
						FncNotaCreditoDetalleListar();
					}
				});
						

					//	if(confirm("Desea seguir agregando mas items?")==false){
//								if(confirm("Desea guardar el registro ahora?")){
//									$('#Guardar').val("1");
//									$('#'+Formulario).submit();
//								}
//							}
//							
			FncNotaCreditoDetalleNuevo();
		}

}

function FncNotaCreditoDetalleListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapNotaCreditoDetalleAccion').html('Cargando...');

	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var PorcentajeImpuestoSelectivo = $('#CmpPorcentajeImpuestoSelectivo').val();	
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();

	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	
	var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();
	var TotalDescuentoGlobal = $('#CmpTotalDescuento').val();
		
	var ImpuestoVenta = 0;

	if(PorcentajeImpuestoVenta!==""){
		ImpuestoVenta=PorcentajeImpuestoVenta/100;
	}
	
	if(TipoCambio==""){
		TipoCambio = 1;
	}
	
	$.ajax({
		type: 'POST',
		url: 'formularios/NotaCredito/FrmNotaCreditoDetalleListado.php',
		data: 'Identificador='+Identificador+
			'&ImpuestoVenta='+ImpuestoVenta+
			'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
			'&PorcentajeImpuestoSelectivo='+PorcentajeImpuestoSelectivo+
			'&PorcentajeDescuento='+PorcentajeDescuento+

			'&IncluyeImpuesto='+IncluyeImpuesto+

			'&MonedaId='+MonedaId+
			'&MonedaSimbolo='+MonedaSimbolo+
			'&TipoCambio='+TipoCambio+
			'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId+
			'&TotalDescuentoGlobal='+TotalDescuentoGlobal+
			
			'&Editar='+NotaCreditoDetalleEditar+
			'&Eliminar='+NotaCreditoDetalleEliminar,
		success: function(html){
			$('#CapNotaCreditoDetalleAccion').html('Listo');	
			$("#CapNotaCreditoDetalles").html("");
			$("#CapNotaCreditoDetalles").append(html);
		}
	});
	

}


function FncNotaCreditoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapNotaCreditoDetalleAccion').html('Editando...');
	$('#CmpNotaCreditoDetalleAccion').val("AccNotaCreditoDetalleEditar.php");

		
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/NotaCredito/acc/AccNotaCreditoDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsNotaCreditoDetalle){
				
				$('#CmpNotaCreditoDetalleCodigo').val(InsNotaCreditoDetalle.Parametro18);	
				$('#CmpNotaCreditoDetalleUnidadMedida').val(InsNotaCreditoDetalle.Parametro13);				
				$('#CmpNotaCreditoDetalleDescripcion').val(InsNotaCreditoDetalle.Parametro2);
				
				$('#CmpNotaCreditoDetalleTipo').val(InsNotaCreditoDetalle.Parametro12);
				
				$('#CmpNotaCreditoDetalleCantidad').val(InsNotaCreditoDetalle.Parametro5);						
				$('#CmpNotaCreditoDetallePrecio').val(InsNotaCreditoDetalle.Parametro4);	
				$('#CmpNotaCreditoDetalleImporte').val(InsNotaCreditoDetalle.Parametro6);	
				
				$('#CmpNotaCreditoDetalleValorVenta').val(InsNotaCreditoDetalle.Parametro19);
				$('#CmpNotaCreditoDetalleDescuento').val(InsNotaCreditoDetalle.Parametro21);
				$('#CmpNotaCreditoDetalleImporte').select();
				
				if(InsNotaCreditoDetalle.Parametro22=="1"){
					$("#CmpNotaCreditoDetalleGratuito").attr('checked', true);
				}else{
					$("#CmpNotaCreditoDetalleGratuito").attr('checked', false);
				}
				
				if(InsNotaCreditoDetalle.Parametro23=="1"){
					$("#CmpNotaCreditoDetalleExonerado").attr('checked', true);
				}else{
					$("#CmpNotaCreditoDetalleExonerado").attr('checked', false);
				}
				
				if(InsNotaCreditoDetalle.Parametro24=="1"){
					$("#CmpNotaCreditoDetalleIncluyeSelectivo").attr('checked', true);
				}else{
					$("#CmpNotaCreditoDetalleIncluyeSelectivo").attr('checked', false);
				}
				
				$('#CmpNotaCreditoDetalleItem').val(InsNotaCreditoDetalle.Item);

		}
	});

	$('#CmpNotaCreditoDetalleCantidad').focus();

}



function FncNotaCreditoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapNotaCreditoDetalleAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/NotaCredito/acc/AccNotaCreditoDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapNotaCreditoDetalleAccion').html("Eliminado");	
				FncNotaCreditoDetalleListar();
			}
		});

		FncNotaCreditoDetalleNuevo();

	}
	
}

function FncNotaCreditoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapNotaCreditoDetalleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/NotaCredito/acc/AccNotaCreditoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapNotaCreditoDetalleAccion').html('Eliminado');	
				FncNotaCreditoDetalleListar();
			}
		});	
		
		FncNotaCreditoDetalleNuevo();
	}
	
}


function FncNotaCreditoDetalleDocumentoGuardar(){

	var Identificador = $('#Identificador').val();
	
	var DocumentoId = $('#CmpDocumentoId').val();
	var DocumentoTalonario = $('#CmpDocumentoTalonario').val();
	
	$('#CapNotaCreditoDetalleAccion').html('Guardando...');

	var Tipo = $('#CmpTipo').val();

		switch(Tipo){

		case "2":
	
				$.ajax({
					type: 'POST',
					url: 'formularios/NotaCredito/acc/AccNotaCreditoDetalleNotaCreditoRegistrar.php',
					data: 'Identificador='+Identificador+
'&FacId='+DocumentoId+
'&FtaId='+DocumentoTalonario,
					success: function(){
						$('#CapNotaCreditoDetalleAccion').html('Listo');							
						FncNotaCreditoDetalleListar();
					}
				});
						
		break;
		
		case "3":
			 
				$.ajax({
					type: 'POST',
					url: 'formularios/NotaCredito/acc/AccNotaCreditoDetalleNotaCreditoRegistrar.php',
					data: 'Identificador='+Identificador+
'&BolId='+DocumentoId+
'&BtaId='+DocumentoTalonario,
					success: function(){
						$('#CapNotaCreditoDetalleAccion').html('Listo');							
						FncNotaCreditoDetalleListar();
					}
				});
						
			
		break;	
		
		FncNotaCreditoDetalleNuevo();
				
		
	}

	

	
		
}
