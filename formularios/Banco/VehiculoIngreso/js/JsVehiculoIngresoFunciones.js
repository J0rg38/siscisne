// JavaScript Document

/*
*** EVENTOS
*/

$().ready(function() {

/*
* EVENTOS - INICIALES
*/
	$("select#CmpVehiculoMarca").change(function(){
		FncVehiculoModelosCargar();
	});

	$("select#CmpVehiculoModelo").change(function(){
		FncVehiculoVersionesCargar();
	});
	
	
	
	
	
	
	
	$("select#CmpVehiculoModelo").dblclick(function(){
		FncVehiculoModelosCargar();
	});

	$("select#CmpVehiculoVersion").dblclick(function(){
		FncVehiculoVersionesCargar();
	});
	
	


//var txt = $("#ddlViewBy option:selected").text();

	$("#CmpVehiculoMarca").change(function(){
		$("#CmpVehiculoVersionCaracteristicaMarca").val($(this).text());
	});
	
	$("#CmpVehiculoModelo").change(function(){
		
		$("#CmpVehiculoVersionCaracteristicaModelo").val($(this).text());
		
		//$("#CmpVehiculoModelo option:selected").text();
		
	});
//	
//	
//	
//	
	$("#CmpAnoFabricacion").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaAnoFabricacion").val($(this).val());
	});
	
	$("#CmpVIN").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaVIN").val($(this).val());
	});
	
	$("#CmpColor").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaColor").val($(this).val());
	});
	
	$("#CmpNumeroMotor").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaNumeroMotor").val($(this).val());
	});
	

	$("#CmpDUA").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaDUA").val($(this).val());
	});
	
	
	$("select#CmpMonedaId").change(function(){
		FncVehiculoIngresoEstablecerMoneda();
	});
	
	
	/*$("#CmpVehiculoVersionCaracteristica10").keyup(function(){
		if()
	});
	CmpVehiculoVersionCaracteristica12
	
	CmpVehiculoVersionCaracteristica13*/
	
//	$("select#CmpVehiculoVersion").change(function(){
//		FncVehiculoColoresCargar();
//	});


	//$("#CmpPropietarioNombre").FncClienteAutocompletar({tipo: "Propietario",campo: "Nombre",columa: 0});
	//$("#CmpPropietarioNumeroDocumento").FncClienteAutocompletar({tipo: "Propietario",campo: "NumeroDocumento",columa: 2});


});













/*
*** FUNCIONES
*/


/*
* FUNCIONES - COMUNES
*/

function FncVehiculoMarcaFuncion(){
	FncVehiculoModelosCargar();
}

function FncVehiculoModeloFuncion(){
	//alert(":3");
	FncVehiculoVersionesCargar();
}

function FncVehiculoVersionFuncion(){
	//FncVehiculoColoresCargar();
//	alert(":3");
}










function FncVehiculoIngresoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpTipoCambioFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		//FncClienteDetalleListar();
		//alert("Debe Escoger una moneda");
	}else{
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");
			}

		}
		FncMonedaBuscar('Id');
	}

}






function FncCargarCaracteristicasPredeterminadas(){


	if(confirm("¿Realmente deseas cargar las caracteristicas predeterminadas?. Esto reemplazara las caracteristicas actuales.")){
		FncCargarVehiculoVersionCaracteristicas();
	}

}





