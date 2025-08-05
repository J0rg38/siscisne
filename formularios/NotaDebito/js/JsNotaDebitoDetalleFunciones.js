// JavaScript Document

function FncNotaDebitoDetalleNuevo(){
	
	$('#CmpNotaDebitoDetalleCodigo').val("");
	$('#CmpNotaDebitoDetalleDescripcion').val("");
	$('#CmpNotaDebitoDetalleUnidadMedida').val("");
	
	$('#CmpNotaDebitoDetallePrecio').val("");
	$('#CmpNotaDebitoDetalleCantidad').val("");
	$('#CmpNotaDebitoDetalleDescuento').val("");
	$('#CmpNotaDebitoDetalleImporte').val("");
	
	
	$("#CmpNotaDebitoDetalleGratuito").attr('checked', false);
	$("#CmpNotaDebitoDetalleExonerado").attr('checked', false);
	
	
	$('#CmpNotaDebitoDetalleItem').val("");

	$('#CmpNotaDebitoDetalleAccion').val("AccNotaDebitoDetalleRegistrar.php");
	
	$('#CmpNotaDebitoDetalleCantidad').select();

	$('#CapNotaDebitoDetalleAccion').html("Listo para registrar elementos");
	
}

function FncNotaDebitoDetalleGuardar(){
	
		var Identificador = $('#Identificador').val();
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var PorcentajeImpuestoSelectivo = $('#CmpPorcentajeImpuestoSelectivo').val();
	
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	
	var Descripcion = $('#CmpNotaDebitoDetalleDescripcion').val();
	var Codigo = $('#CmpNotaDebitoDetalleCodigo').val();
	var UnidadMedida = $('#CmpNotaDebitoDetalleUnidadMedida').val();
	
	var Precio = $('#CmpNotaDebitoDetallePrecio').val();
	var Cantidad = $('#CmpNotaDebitoDetalleCantidad').val();
	var Importe = $('#CmpNotaDebitoDetalleImporte').val();
	var Descuento = $('#CmpNotaDebitoDetalleDescuento').val();
	
	if($("#CmpNotaDebitoDetalleGratuito").is(':checked')){
		var Gratuito = 1;
	}else{
		var Gratuito = 2;
	}
	
	if($("#CmpNotaDebitoDetalleExonerado").is(':checked')){
		var Exonerado = 1;
	}else{
		var Exonerado = 2;
	}
	
	
	if($("#CmpNotaDebitoDetalleIncluyeSelectivo").is(':checked')){
		var IncluyeSelectivo = 1;
	}else{
		var IncluyeSelectivo = 2;
	}

	
	var Item = $('#CmpNotaDebitoDetalleItem').val();
	var Acc = $('#CmpNotaDebitoDetalleAccion').val();
	
		if(Descripcion==""){
			$('#CmpNotaDebitoDetalleDescripcion').select();	
		}else if(Precio==""){
			$('#CmpNotaDebitoDetalleImporte').select();	
		}else if(Cantidad=="" || Cantidad <=0){
			$('#CmpNotaDebitoDetalleImporte').select();	
		}else if(Importe==""){
			$('#CmpNotaDebitoDetalleImporte').select();	
		}else{
			$('#CapNotaDebitoDetalleAccion').html('Guardando...');

				$.ajax({
					type: 'POST',
					url: 'formularios/NotaDebito/acc/'+Acc,
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
						$('#CapNotaDebitoDetalleAccion').html('Listo');							
						FncNotaDebitoDetalleListar();
					}
				});
						

					//	if(confirm("Desea seguir agregando mas items?")==false){
//								if(confirm("Desea guardar el registro ahora?")){
//									$('#Guardar').val("1");
//									$('#'+Formulario).submit();
//								}
//							}
//							
			FncNotaDebitoDetalleNuevo();
		}

}
function FncNotaDebitoDetalleListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapNotaDebitoDetalleAccion').html('Cargando...');

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
		url: 'formularios/NotaDebito/FrmNotaDebitoDetalleListado.php',
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
			
			'&Editar='+NotaDebitoDetalleEditar+
			'&Eliminar='+NotaDebitoDetalleEliminar,
		success: function(html){
			$('#CapNotaDebitoDetalleAccion').html('Listo');	
			$("#CapNotaDebitoDetalles").html("");
			$("#CapNotaDebitoDetalles").append(html);
		}
	});
	

}


function FncNotaDebitoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapNotaDebitoDetalleAccion').html('Editando...');
	$('#CmpNotaDebitoDetalleAccion').val("AccNotaDebitoDetalleEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/NotaDebito/acc/AccNotaDebitoDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsNotaDebitoDetalle){
				
				$('#CmpNotaDebitoDetalleCodigo').val(InsNotaDebitoDetalle.Parametro18);	
				$('#CmpNotaDebitoDetalleUnidadMedida').val(InsNotaDebitoDetalle.Parametro13);				
				$('#CmpNotaDebitoDetalleDescripcion').val(InsNotaDebitoDetalle.Parametro2);
				
				$('#CmpNotaDebitoDetalleTipo').val(InsNotaDebitoDetalle.Parametro12);
				
				$('#CmpNotaDebitoDetalleCantidad').val(InsNotaDebitoDetalle.Parametro5);						
				$('#CmpNotaDebitoDetallePrecio').val(InsNotaDebitoDetalle.Parametro4);	
				$('#CmpNotaDebitoDetalleImporte').val(InsNotaDebitoDetalle.Parametro6);	
				
				$('#CmpNotaDebitoDetalleValorVenta').val(InsNotaDebitoDetalle.Parametro19);
				$('#CmpNotaDebitoDetalleDescuento').val(InsNotaDebitoDetalle.Parametro21);
				$('#CmpNotaDebitoDetalleImporte').select();
				
				if(InsNotaDebitoDetalle.Parametro22=="1"){
					$("#CmpNotaDebitoDetalleGratuito").attr('checked', true);
				}else{
					$("#CmpNotaDebitoDetalleGratuito").attr('checked', false);
				}
				
				if(InsNotaDebitoDetalle.Parametro23=="1"){
					$("#CmpNotaDebitoDetalleExonerado").attr('checked', true);
				}else{
					$("#CmpNotaDebitoDetalleExonerado").attr('checked', false);
				}
				
				if(InsNotaDebitoDetalle.Parametro24=="1"){
					$("#CmpNotaDebitoDetalleIncluyeSelectivo").attr('checked', true);
				}else{
					$("#CmpNotaDebitoDetalleIncluyeSelectivo").attr('checked', false);
				}
				
				$('#CmpNotaDebitoDetalleItem').val(InsNotaDebitoDetalle.Item);

		}
	});

	$('#CmpNotaDebitoDetalleCantidad').focus();

}



function FncNotaDebitoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapNotaDebitoDetalleAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/NotaDebito/acc/AccNotaDebitoDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapNotaDebitoDetalleAccion').html("Eliminado");	
				FncNotaDebitoDetalleListar();
			}
		});

		FncNotaDebitoDetalleNuevo();

	}
	
}

function FncNotaDebitoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapNotaDebitoDetalleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/NotaDebito/acc/AccNotaDebitoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapNotaDebitoDetalleAccion').html('Eliminado');	
				FncNotaDebitoDetalleListar();
			}
		});	
		
		FncNotaDebitoDetalleNuevo();
	}
	
}


function FncNotaDebitoDetalleDocumentoGuardar(){

	var Identificador = $('#Identificador').val();
	
	var DocumentoId = $('#CmpDocumentoId').val();
	var DocumentoTalonario = $('#CmpDocumentoTalonario').val();
	
	$('#CapNotaDebitoDetalleAccion').html('Guardando...');

	var Tipo = $('#CmpTipo').val();

		switch(Tipo){

		case "2":
	
				$.ajax({
					type: 'POST',
					url: 'formularios/NotaDebito/acc/AccNotaDebitoDetalleNotaDebitoRegistrar.php',
					data: 'Identificador='+Identificador+
'&FacId='+DocumentoId+
'&FtaId='+DocumentoTalonario,
					success: function(){
						$('#CapNotaDebitoDetalleAccion').html('Listo');							
						FncNotaDebitoDetalleListar();
					}
				});
						
		break;
		
		case "3":
			 
				$.ajax({
					type: 'POST',
					url: 'formularios/NotaDebito/acc/AccNotaDebitoDetalleNotaDebitoRegistrar.php',
					data: 'Identificador='+Identificador+
'&BolId='+DocumentoId+
'&BtaId='+DocumentoTalonario,
					success: function(){
						$('#CapNotaDebitoDetalleAccion').html('Listo');							
						FncNotaDebitoDetalleListar();
					}
				});
						
			
		break;	
		
		FncNotaDebitoDetalleNuevo();
				
		
	}

	

	
		
}
