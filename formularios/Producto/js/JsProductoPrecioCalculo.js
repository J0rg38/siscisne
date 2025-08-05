// JavaScript Document

function FncProductoPrecioCalculoImprimir(oIndice){
	var Accion = document.getElementById('FrmProductoPrecioCalculo'+oIndice).action;
	
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).target = '_blank';
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).submit();
	
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).target = 'IfrProductoPrecioCalculo'+oIndice;
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).action = Accion;
	
}

function FncProductoPrecioCalculoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmProductoPrecioCalculo'+oIndice).action;
	
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).target = '_blank';
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).submit();
	
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).target = 'IfrProductoPrecioCalculo'+oIndice;
	document.getElementById('FrmProductoPrecioCalculo'+oIndice).action = Accion;
	
}



function FncProductoPrecioCalculoNuevo(){


	
				
}


$(function(){
	
/*		function FncProductoFormato(row) {			
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
	});*/
	
});




