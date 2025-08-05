






function FncProductoClienteBuscar(){
	
	console.log("FncProductoClienteBuscar");
			
	var Dato = $('#CmpProductoCodigoOriginal').val()
	
	if(Dato!=""){
	
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscarCliente.php',
			data: 'ProductoCodigoOriginal='+Dato,
			success: function(Respuesta){
										
				if(Respuesta!=null){
					
					if(Respuesta['TienePedido']=="Si"){
						
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"El codigo ingresado tiene pedido de cliente pendiente",
							callback: function(result){
								
							}
						});
						
					}
					
				}else{
					console.log("No se encontraron repuestos pendientes");				
				}
				
			}
		});
		

	}
	

}


