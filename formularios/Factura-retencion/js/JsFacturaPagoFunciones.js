// JavaScript Document


function FncFacturaPagoNuevo(){
	 

}

function FncFacturaPagoGuardar(){
	
	 
}


function FncFacturaPagoListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapFacturaPagoAccion').html('Cargando...');

	
	var Id = $('#CmpId').val();
	var Talonario = $('#CmpTalonario').val();	
	var VentaDirectaId = $('#CmpVentaDirectaId').val();	
	var PagoId = $('#CmpPagoId').val();	
	var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();	
	var FichaIngresoId = $('#CmpFichaIngresoId').val();	
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Factura/CapFacturaPagoListado.php',
		data: 'Identificador='+Identificador+
		 
		 '&VentaDirectaId='+VentaDirectaId+
		 '&PagoId='+PagoId+
		 '&OrdenVentaVehiculoId='+OrdenVentaVehiculoId+
		 '&FichaIngresoId='+FichaIngresoId+
		 
		'&BolId='+Id+
		'&BtaId='+Talonario,
		
		success: function(html){
			$('#CapFacturaPagoAccion').html('Listo');	
			$("#CapFacturaPagos").html("");
			$("#CapFacturaPagos").append(html);
		}
	});


//alert(MonedaSimbolo);
	 
	
}


