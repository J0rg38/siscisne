// JavaScript Document
//var Ventas = "1";
//var Libres = "1";

$().ready(function() {

	$('#CmpSucursal').on('change', function() {
	
		//FncPersonalesCargar();	
	
	});
	
	
	$('#BtnVer').on('click', function() {
	
		FncReporteProductoVenta12MesesVer();
	
	});
	
	
	$('#BtnImprimir').on('click', function() {
	
		FncReporteProductoVenta12MesesImprimir();
	
	});
	
	
	$('#BtnExcel').on('click', function() {
	
		FncReporteProductoVenta12MesesGenerarExcel();
	
	});

	
/*
* EVENTOS - NAVEGACION
*/		
	
});

function FncReporteProductoVenta12MesesValidar(){
	
	var respuesta = true
	var Ano = $("#CmpAno").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();

	if(Ano==""){
		alert("No ha escogido un año.");
	}
	
	return respuesta;
	
}

function FncReporteProductoVenta12MesesVer(){
	
	if(FncReporteProductoVenta12MesesValidar()){
		
		var Ano = $("#CmpAno").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		$('#CapReporteProductoVenta12Meses').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteProductoVenta12Meses.php',
			data: "Ano="+Ano+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca,
			success: function(html){
				$('#CapReporteProductoVenta12Meses').html(html);	
			}
		});

	}

}


function FncReporteProductoVenta12MesesImprimir(){
	
	if(FncReporteProductoVenta12MesesValidar()){

		var Ano = $("#CmpAno").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/IfrReporteProductoVenta12Meses.php?Ano="+Ano+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&P=1");
	
	}

}

function FncReporteProductoVenta12MesesGenerarExcel(){
	
	if(FncReporteProductoVenta12MesesValidar()){
		
		var Ano = $("#CmpAno").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/XLSReporteProductoVenta12Meses.php?Ano="+Ano+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&P=2");
		
	}
	
}

function FncReporteProductoVenta12MesesNuevo(){

}
