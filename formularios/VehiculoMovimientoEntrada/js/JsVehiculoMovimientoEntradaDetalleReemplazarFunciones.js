$(function(){

	$('#BtnReemplazar').click(function(){
	
	   FncVehiculoMovimientoEntradaDetalleReemplazar();
	   
	});
	
	$('#BtnCancelar').click(function(){
	
	   self.parent.tb_remove();
	   
	});
	
});


    	
	
function FncVehiculoMovimientoEntradaDetalleReemplazar(){

	var Identificador = $('#Identificador').val();

		
			var VehiculoId = $('#CmpVehiculoId').val();
			var VehiculoNombre = $('#CmpVehiculoNombre').val();
			var VehiculoUnidadMedida = $('#CmpVehiculoUnidadMedida').val();
			var VehiculoUnidadMedidaConvertir = $('#CmpVehiculoUnidadMedidaConvertir').val();
			var Item = $('#CmpVehiculoItem').val();

			var Accion = $('#CmpVehiculoMovimientoEntradaDetalleAccion').val();
		
			if(VehiculoId==""){
				
				alert("No existe el producto, debe registrarlo desde el padron de productos.");
				
			}else if(VehiculoNombre==""){
				
				alert("No se encontro nombre de producto.");
						
			}else{
				
				//$('#CapVehiculoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'acc/AccVehiculoMovimientoEntradaDetalleReemplazar.php',
							data: 'Identificador='+Identificador+
							
							'&VehiculoId='+VehiculoId+
							'&VehiculoUnidadMedidaConvertir='+VehiculoUnidadMedidaConvertir+
					
							'&Item='+Item,
							success: function(){
								
								self.parent.FncVehiculoMovimientoEntradaDetalleListar();
								self.parent.tb_remove();
								
								//$('#CapVehiculoAccion').html('Listo');							
								//FncVehiculoMovimientoEntradaDetalleListar();
							}
						});
						
							//	if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}
//								
								
					
				//	FncVehiculoMovimientoEntradaDetalleNuevo();	
					
					
			}
	
}