$(function(){

	$('#BtnReemplazar').click(function(){
	
	   FncAlmacenMovimientoEntradaDetalleReemplazar();
	   
	});
	
	$('#BtnCancelar').click(function(){
	
	   self.parent.tb_remove();
	   
	});
	
});


    	
	
function FncAlmacenMovimientoEntradaDetalleReemplazar(){

	var Identificador = $('#Identificador').val();

		
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var Item = $('#CmpProductoItem').val();

			var Accion = $('#CmpAlmacenMovimientoEntradaDetalleAccion').val();
		
			if(ProductoId==""){
				
				alert("No existe el producto, debe registrarlo desde el padron de productos.");
				
			}else if(ProductoNombre==""){
				
				alert("No se encontro nombre de producto.");
						
			}else{
				
				//$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'acc/AccAlmacenMovimientoEntradaDetalleReemplazar.php',
							data: 'Identificador='+Identificador+
							
							'&ProductoId='+ProductoId+
							'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
					
							'&Item='+Item,
							success: function(){
								
								self.parent.FncAlmacenMovimientoEntradaDetalleListar();
								self.parent.tb_remove();
								
								//$('#CapProductoAccion').html('Listo');							
								//FncAlmacenMovimientoEntradaDetalleListar();
							}
						});
						
							//	if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}
//								
								
					
				//	FncAlmacenMovimientoEntradaDetalleNuevo();	
					
					
			}
	
}