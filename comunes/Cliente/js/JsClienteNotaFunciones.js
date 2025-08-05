var ClienteNotaMostrarMensaje = true;

function FncClienteNotaVerificar(){
	
	var ClienteId = $('#CmpClienteId').val();

	if(ClienteId==""){
		
		if(ClienteNotaMostrarMensaje){
				dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger un cliente",
				callback: function(result){
			
				}
			});
		}
		
				
	}else{
		
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Cliente/acc/AccClienteNotaVerificar.php',
		data: 'ClienteId='+ClienteId+'&Limite=1',
		success: function(ArrClienteNotas){

				if(ArrClienteNotas!=null){					

					
					var d, i;

					for (i = 0; i < ArrClienteNotas.length; i++) {
					  d = ArrClienteNotas[i];
					  
					  //dhtmlx.message({ type:"alert", text:"Nota: "+d.CnoDescripcion, expire:-3 });
				
							dhtmlx.alert({
								title:"NOTA",
								type:"alert-error",
								text:" "+d.CnoDescripcion,
								callback: function(result){
			
								}
							});
							
				
					}

				}

			}
		});	
	}
	
}


