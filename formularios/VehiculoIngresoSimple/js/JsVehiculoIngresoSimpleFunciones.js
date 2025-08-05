// JavaScript Document



function FncValidar(){

	var VIN = $("#CmpVIN").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var VehiculoModelo = $("#CmpVehiculoModelo").val();
	var VehiculoVersion = $("#CmpVehiculoVersion").val();
	
	var VehiculoCodigoIdentificador = $("#CmpVehiculoCodigoIdentificador").val();
	var VehiculoId = $("#CmpVehiculoId").val();
		
		if(VIN == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una VIN",
					callback: function(result){
						$("#CmpVIN").focus();
					}
				});
				
			return false;
		
		}else if(VehiculoMarca == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una marca",
					callback: function(result){
						$("#CmpVehiculoMarca").focus();
					}
				});
				
			return false;
			
		}else if(VehiculoModelo == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un modelo",
					callback: function(result){
						$("#CmpVehiculoModelo").focus();
					}
				});
				
			return false;
	

		}else if(VehiculoVersion == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una version ",
					callback: function(result){
						$("#CmpVehiculoVersion").focus();
					}
				});

			return false;
			
	/*	}else if(VehiculoCodigoIdentificador == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No ha ingresado codigo identificador unico. Verifique que se encuentre registrado en el padron de vehiculos ",
					callback: function(result){
						$("#CmpVehiculoCodigoIdentificador").focus();
					}
				});

			return false;
*/
		}else{
			return true;
		}

}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
		$("#CmpOrigen").removeAttr('disabled');	
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
				$("#CmpOrigen").removeAttr('disabled');	
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});



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
	
	//$("select#CmpVehiculoModelo").dblclick(function(){
//		FncVehiculoModelosCargar();
//	});

	$("select#CmpVehiculoVersion").change(function(){
		//FncVehiculoVersionesCargar();
		console.log("CmpVehiculoVersion Cambiar");
		FncCargarVehiculoCodigoIdentificador();
		
	});
	
	

	$("#CmpVehiculoMarca").change(function(){
		
		FncVehiculoNuevo();
		$("#CmpVehiculoVersionCaracteristicaMarca").val($(this).text());
	});
	
	$("#CmpVehiculoModelo").change(function(){
		FncVehiculoNuevo();
		$("#CmpVehiculoVersionCaracteristicaModelo").val($(this).text());
		
	});

	$("#CmpAnoFabricacion").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaAnoFabricacion").val($(this).val());
	});
	
	$("#CmpVIN").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaVIN").val($(this).val());
	});
	
	$("#CmpColor").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaColor").val($(this).val());
	});
	
	$("#CmpColorInterior").keyup(function(){
		$("#CmpVehiculoVersionCaracteristicaColorInterior").val($(this).val());
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

function FncCargarVehiculoCodigoIdentificador(){
	
	FncVehiculoBuscar("Version");
		
	if($("#CmpVehiculoId").val()==""){
		$("#CmpVehiculoCodigoIdentificador").val("");
	}
		
	if($("#CmpVehiculoVersion").val()==""){
		FncVehiculoNuevo();
	}
		
}

function FncVehiculoNuevo(){

	$("#CmpVehiculoId").val("");
	$("#CmpVehiculoCodigoIdentificador").val("");
		
}
		
/*
* FUNCIONES - COMUNES
*/

function FncVehiculoMarcaFuncion(){
	
	console.log("FncVehiculoMarcaFuncion");
	
	FncVehiculoModelosCargar();
	FncVehiculoNuevo();
}

function FncVehiculoModeloFuncion(){
	
	console.log("FncVehiculoModeloFuncion");
	
	FncVehiculoVersionesCargar();
	FncVehiculoNuevo();
}

function FncVehiculoVersionFuncion(){

	console.log("FncVehiculoVersionFuncion");
	FncCargarVehiculoCodigoIdentificador();
}



function FncVehiculoEscoger(InsVehiculo){

	console.log("FncVehiculoEscoger");
	$('#CmpVehiculoId').val(InsVehiculo.VehId);
	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculo.VehCodigoIdentificador);
	
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





