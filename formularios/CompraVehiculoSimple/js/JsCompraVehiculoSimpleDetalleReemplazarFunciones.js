$(function(){

	$('#BtnReemplazar').click(function(){
	
	   FncCompraVehiculoSimpleDetalleReemplazar();
	   
	});
	
	$('#BtnCancelar').click(function(){
	
	   self.parent.tb_remove();
	   
	});
	
});


    	
	
function FncCompraVehiculoSimpleDetalleReemplazar(){

	var Identificador = $('#Identificador').val();

		
			var VehiculoId = $('#CmpVehiculoId').val();
			var VehiculoNombre = $('#CmpVehiculoNombre').val();
			var VehiculoUnidadMedida = $('#CmpVehiculoUnidadMedida').val();
			var VehiculoUnidadMedidaConvertir = $('#CmpVehiculoUnidadMedidaConvertir').val();
			var Item = $('#CmpVehiculoItem').val();

			var Accion = $('#CmpCompraVehiculoDetalleAccion').val();
		
			if(VehiculoId==""){
				
				alert("No existe el producto, debe registrarlo desde el padron de productos.");
				
			}else if(VehiculoNombre==""){
				
				alert("No se encontro nombre de producto.");
						
			}else{
				
				//$('#CapVehiculoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'acc/AccCompraVehiculoSimpleDetalleReemplazar.php',
							data: 'Identificador='+Identificador+
							
							'&VehiculoId='+VehiculoId+
							'&VehiculoUnidadMedidaConvertir='+VehiculoUnidadMedidaConvertir+
					
							'&Item='+Item,
							success: function(){
								
								self.parent.FncCompraVehiculoSimpleDetalleListar();
								self.parent.tb_remove();
								
								//$('#CapVehiculoAccion').html('Listo');							
								//FncCompraVehiculoSimpleDetalleListar();
							}
						});
						
							//	if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}
//								
								
					
				//	FncCompraVehiculoSimpleDetalleNuevo();	
					
					
			}
	
}