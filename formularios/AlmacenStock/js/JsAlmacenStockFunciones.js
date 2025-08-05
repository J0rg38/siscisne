// JavaScript Document

$().ready(function() {

	$('#EstAlmacenStockMovimientoEntradas2014').hide(1500);
	$('#EstAlmacenStockMovimientoEntradas2014').hide("slow");

	$('#EstAlmacenStockMovimientoSalidas2014').hide(1500);
	$('#EstAlmacenStockMovimientoSalidas2014').hide("slow");
	
	$('#EstAlmacenStockMovimientoEntradas2015').hide(1500);
	$('#EstAlmacenStockMovimientoEntradas2015').hide("slow");

	$('#EstAlmacenStockMovimientoSalidas2015').hide(1500);
	$('#EstAlmacenStockMovimientoSalidas2015').hide("slow");

	
	$("select#CmpAlmacenId").change(function(){
		
		$('#CmpStock').val("0.00");
		
		FncAlmacenStockCargarEntradas();
		FncAlmacenStockCargarSalidas();
		//FncAlmacenStockCargarStock();
		
		
		
	});
	
	
	/*
	
	$("select#CmpAno").change(function(){
		
		if((this).val==""){
			alert("No ha escogido un año");
		}else{
			FncAlmacenStockCargarEntradas();
			FncAlmacenStockCargarSalidas();
			FncAlmacenStockCargarStock();
		}
		
		$('#CmpStock').val("0.00");
		
	});
	
	*/
	
	
	
	FncAlmacenStockCargarEntradas();
	
	FncAlmacenStockCargarSalidas();
	
	FncAlmacenStockCargarStock();
	
});


function FncAlmacenStockCargarEntradas(){
		
	var Sucursal = $("#CmpSucursal").val();
	var ProductoId = $("#CmpProductoId").val();
	var AlmacenId = $("#CmpAlmacenId").val();
	var Ano = $("#CmpAno").val();
	
	$("#CapAlmacenStockEntradaAccion").html("Cargando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/AlmacenStock/CapAlmacenStockEntradas.php',
		data: 'ProductoId='+ProductoId+'&AlmacenId='+AlmacenId+'&Ano='+Ano+'&Sucursal='+Sucursal,
		success: function(html){
			$('#CapAlmacenStockEntradaAccion').html('Listo');	
			
			$("#CapAlmacenStockEntradas").html("");
			$("#CapAlmacenStockEntradas").append(html);
			
			
			
		}
	});
	
	FncAlmacenStockCargarStock();
	
}	


function FncAlmacenStockCargarSalidas(){
		
	var Sucursal = $("#CmpSucursal").val();
	var ProductoId = $("#CmpProductoId").val();
	var AlmacenId = $("#CmpAlmacenId").val();
	var Ano = $("#CmpAno").val();
	
	$("#CapAlmacenStockSalidaAccion").html("Cargando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/AlmacenStock/CapAlmacenStockSalidas.php',
		data: 'ProductoId='+ProductoId+'&AlmacenId='+AlmacenId+'&Ano='+Ano+'&Sucursal='+Sucursal,
		success: function(html){
			$('#CapAlmacenStockSalidaAccion').html('Listo');	
			
			$("#CapAlmacenStockSalidas").html("");
			$("#CapAlmacenStockSalidas").append(html);
			
		}
	});
	
	FncAlmacenStockCargarStock();

}	

function FncAlmacenStockCargarStock(){
		
	var ProductoId = $("#CmpProductoId").val();
	var SucursalId = $("#CmpSucursal").val();
	var AlmacenId = $("#CmpAlmacenId").val();
	var Ano = $("#CmpAno").val();

	$.ajax({
	type: 'POST',
	dataType : 'json',
	url: Ruta+'formularios/AlmacenStock/jn/JnAlmacenStock.php',
	data: 'ProductoId='+ProductoId+'&SucursalId='+SucursalId+'&AlmacenId='+AlmacenId+'&Ano='+Ano,
		success: function(InsAlmacenStock){
			 $("#CmpStock").val(InsAlmacenStock.AstStockReal);  
	  }
	});	

}	

	
	
	

function FncMostrarEntradas(oAno){
	
	$('#EstAlmacenStockMovimientoEntradas'+oAno).show(3000);
	$('#EstAlmacenStockMovimientoEntradas'+oAno).show("slow");
}

function FncOcultarEntradas(oAno){
	
	$('#EstAlmacenStockMovimientoEntradas'+oAno).hide(3000);
	$('#EstAlmacenStockMovimientoEntradas'+oAno).hide("slow");
}


function FncMostrarSalidas(oAno){

	$('#EstAlmacenStockMovimientoSalidas'+oAno).show(3000);
	$('#EstAlmacenStockMovimientoSalidas'+oAno).show("slow");
	 	
}

function FncOcultarSalidas(oAno){

	$('#EstAlmacenStockMovimientoSalidas'+oAno).hide(3000);
	$('#EstAlmacenStockMovimientoSalidas'+oAno).hide("slow");
	 	
}