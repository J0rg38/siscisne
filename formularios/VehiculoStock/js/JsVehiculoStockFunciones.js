// JavaScript Document

$().ready(function() {

//	$('#EstVehiculoStockMovimientoEntradas2014').hide(1500);
//	$('#EstVehiculoStockMovimientoEntradas2014').hide("slow");
//
//	$('#EstVehiculoStockMovimientoSalidas2014').hide(1500);
//	$('#EstVehiculoStockMovimientoSalidas2014').hide("slow");
//	
//	$('#EstVehiculoStockMovimientoEntradas2015').hide(1500);
//	$('#EstVehiculoStockMovimientoEntradas2015').hide("slow");
//
//	$('#EstVehiculoStockMovimientoSalidas2015').hide(1500);
//	$('#EstVehiculoStockMovimientoSalidas2015').hide("slow");
//
//	
	$("select#CmpSucursal").change(function(){

		FncVehiculoStockCargarEntradas();
		FncVehiculoStockCargarSalidas();
		FncVehiculoStockCargarStock();
		
		$('#CmpStock').val("0.00");
		
	});
	
	$("select#CmpAno").change(function(){
		
		if((this).val==""){
			alert("No ha escogido un año");
		}else{
			FncVehiculoStockCargarEntradas();
			FncVehiculoStockCargarSalidas();
			FncVehiculoStockCargarStock();
		}
		
		$('#CmpStock').val("0.00");
		
	});
	
	
	
	
	
	FncVehiculoStockCargarEntradas();
	
	FncVehiculoStockCargarSalidas();
	
	FncVehiculoStockCargarStock();
	
});


function FncVehiculoStockCargarEntradas(){
		
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoId = $("#CmpVehiculoId").val();
	var Ano = $("#CmpAno").val();
	
	$("#CapVehiculoStockEntradaAccion").html("Cargando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoStock/CapVehiculoStockEntradas.php',
		data: 'VehiculoId='+VehiculoId+'&Ano='+Ano+'&Sucursal='+Sucursal,
		success: function(html){
			$('#CapVehiculoStockEntradaAccion').html('Listo');	
			
			$("#CapVehiculoStockEntradas").html("");
			$("#CapVehiculoStockEntradas").append(html);
			
		}
	});
	
}	


function FncVehiculoStockCargarSalidas(){
		
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoId = $("#CmpVehiculoId").val();
	var Ano = $("#CmpAno").val();
	
	$("#CapVehiculoStockSalidaAccion").html("Cargando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoStock/CapVehiculoStockSalidas.php',
		data: 'VehiculoId='+VehiculoId+'&Ano='+Ano+'&Sucursal='+Sucursal,
		success: function(html){
			$('#CapVehiculoStockSalidaAccion').html('Listo');	
			
			$("#CapVehiculoStockSalidas").html("");
			$("#CapVehiculoStockSalidas").append(html);
			
		}
	});

}	

function FncVehiculoStockCargarStock(){
		
	var VehiculoId = $("#CmpVehiculoId").val();
	var Sucursal = $("#CmpSucursal").val();
	var Ano = $("#CmpAno").val();

	$.ajax({
	type: 'POST',
	dataType : 'json',
	url: 'formularios/VehiculoStock/jn/JnVehiculoStock.php',
	data: 'VehiculoId='+VehiculoId+'&Sucursal='+Sucursal+'&Ano='+Ano,
		success: function(InsVehiculoStock){
			 $("#CmpStock").val(InsVehiculoStock.VstStockReal);  
	  }
	});	

}	

	
	
	//
//
//function FncMostrarEntradas(oAno){
//	
//	$('#EstVehiculoStockMovimientoEntradas'+oAno).show(3000);
//	$('#EstVehiculoStockMovimientoEntradas'+oAno).show("slow");
//}
//
//function FncOcultarEntradas(oAno){
//	
//	$('#EstVehiculoStockMovimientoEntradas'+oAno).hide(3000);
//	$('#EstVehiculoStockMovimientoEntradas'+oAno).hide("slow");
//}
//
//
//function FncMostrarSalidas(oAno){
//
//	$('#EstVehiculoStockMovimientoSalidas'+oAno).show(3000);
//	$('#EstVehiculoStockMovimientoSalidas'+oAno).show("slow");
//	 	
//}
//
//function FncOcultarSalidas(oAno){
//
//	$('#EstVehiculoStockMovimientoSalidas'+oAno).hide(3000);
//	$('#EstVehiculoStockMovimientoSalidas'+oAno).hide("slow");
//	 	
//}