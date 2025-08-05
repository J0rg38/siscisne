// JavaScript Document

//var TipoCambioEstilo = "TcaMontoComercial";

function FncTipoCambioCargar(oMonedaId,oFecha,oTipo){
	
	if(oMonedaId!=""){
		
		$.ajax({
		type: 'GET',
		dataType: 'json',
		url: 'comunes/TipoCambio/JnTipoCambio.php',
		data: 'MonedaId='+oMonedaId+'&Fecha='+oFecha,
		success: function(InsTipoCambio){
			
			switch(oTipo){
				
				case "Comercial":
					$('#CmpTipoCambio').val(InsTipoCambio.TcaMontoComercial);
				break;
				
				case "Compra":
					$('#CmpTipoCambio').val(InsTipoCambio.TcaMontoCompra);
				break;
				
				case "Venta":
					$('#CmpTipoCambio').val(InsTipoCambio.TcaMontoVenta);
				break;
				
				default:
					$('#CmpTipoCambio').val(InsTipoCambio.TcaMontoVenta);
				break;
				
			}
			
			FncTipoCambioFuncion(InsTipoCambio);
			
			
		}
		});
		
	}
					
}

function FncTipoCambioFuncion(InsTipoCambio){
	
}