// JavaScript Document



function FncProductoConsultaValidar(){
	
	var respuesta = true
	var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
	var Sucursal = $("#CmpSucursal").val();
	
	if(ProductoCodigoOriginal==""){
		alert("No ha ingresado el codigo original.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncProductoConsultaVer(){
	
	if(FncProductoConsultaValidar()){
		
		var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
		var Sucursal = $("#CmpSucursal").val();
		$('#CapProductoConsulta').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Producto/IfrProductoConsulta.php',
			data: 'ProductoCodigoOriginal='+ProductoCodigoOriginal+'&Sucursal='+Sucursal,
			success: function(html){
				$('#CapProductoConsulta').html(html);	
			}
		});

	}

}


function FncProductoConsultaImprimir(oIndice){
	
	if(FncProductoConsultaValidar()){
		
		var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
		var Sucursal = $("#CmpSucursal").val();
		FncPopUp("formularios/Producto/IfrProductoConsulta.php?ProductoCodigoOriginal="+ProductoCodigoOriginal+'&Sucursal='+Sucursal+"&P=1");
		
	}

}

function FncProductoConsultaGenerarExcel(oIndice){
	
	if(FncProductoConsultaValidar()){
		
		var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
	var Sucursal = $("#CmpSucursal").val();
		FncPopUp("formularios/Producto/IfrProductoConsulta.php?ProductoCodigoOriginal="+ProductoCodigoOriginal+'&Sucursal='+Sucursal+"&P=2");
		
	}
	
}



function FncProductoConsultaNuevo(){


	
				
}


$(function(){
	
		function FncProductoFormato(row) {			
		return "<td>"+row[8]+"</td>";
	}
	
	
	$("#CmpProductoCodigoOriginal").unautocomplete();
	$("#CmpProductoCodigoOriginal").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&t=', {
		width: 100,
		max: 100,
		formatItem: FncProductoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoCodigoOriginal").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoId").val(data[0]);				
			FncProductoBuscar("Id");	
		}		
	});
	
});







/*
FORMULARIOS
*/

function FncProductoCargarFormulario(oForm,oProductoId){

	tb_show(this.title,'principal2.php?Mod=Producto&Form='+oForm+'&Dia=1&Id='+oProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(screen.height-200)+'&width='+(screen.width-100)+'&modal=true',this.rel);		

}


//function FncCotizacionProductoCargarFormulario(oForm,oProductoId){
//
//	tb_show(this.title,'principal2.php?Mod=CotizacionProducto&Form='+oForm+'&Dia=1&Id='+oProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(screen.height-200)+'&width='+(screen.width-100)+'&modal=true',this.rel);		
//
//}