// JavaScript Document


function FncBoletaPagoNuevo(){
	 

}

function FncBoletaPagoGuardar(){
	
	 
}


function FncBoletaPagoListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapBoletaPagoAccion').html('Cargando...');

	
	var Id = $('#CmpId').val();
	var Talonario = $('#CmpTalonario').val();	
	var VentaDirectaId = $('#CmpVentaDirectaId').val();	
	var PagoId = $('#CmpPagoId').val();	
	var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();	
	var FichaIngresoId = $('#CmpFichaIngresoId').val();	
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Boleta/CapBoletaPagoListado.php',
		data: 'Identificador='+Identificador+
		 
		 '&VentaDirectaId='+VentaDirectaId+
		 '&PagoId='+PagoId+
		 '&OrdenVentaVehiculoId='+OrdenVentaVehiculoId+
		 '&FichaIngresoId='+FichaIngresoId+
		 
		'&BolId='+Id+
		'&BtaId='+Talonario,
		
		success: function(html){
			$('#CapBoletaPagoAccion').html('Listo');	
			$("#CapBoletaPagos").html("");
			$("#CapBoletaPagos").append(html);
		}
	});


//alert(MonedaSimbolo);
	 
	
}


