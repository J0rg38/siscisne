/*
Configuracion Autocompletar
*/

/*
* Valores por defecto
*/

		
function FncProductoFormato(row) {			
	
	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td><td align='center'>"+row[9]+"</td><td align='center'>"+row[11]+"</td><td align='center'>"+row[14]+"</td><td align='center'>"+row[15]+"</td>";
	
}		
			
//
//function FncProductoFormato(row) {			
//	
//	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td><td align='center'>"+row[9]+"</td><td align='center'>"+row[11]+"</td><td align='center'>"+row[14]+"</td><td align='center'>"+row[15]+"</td>";
//	
//}

//function FncFormato(row) {			
//	
//	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td>";
//	
//}


function FncFormato2(row) {			
	return row[0];
}
function FncFormato3(row) {
	return row[8];
}
function FncFormato4(row) {
	return row[7];
}
	
function FncProductoAutocompletarCargar(){

	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var VehiculoModelo = $("#CmpVehiculoModeloId").val();
	var VehiculoVersion = $("#CmpVehiculoVersionId").val();
	var VehiculoAno = $("#CmpVehiculoAno").val();
	
	if(VehiculoMarca==null){
		VehiculoMarca = "";
	}

	if(VehiculoModelo==null){
		VehiculoModelo = "";
	}

	if(VehiculoVersion==null){
		VehiculoVersion = "";
	}

	if(VehiculoAno==null){
		VehiculoAno = "";
	}
	
	$("#CmpProductoNombre").unautocomplete();
	$("#CmpProductoNombre").autocomplete(Ruta+'comunes/Producto/XmlProducto.php?Cbu=ProNombre&Marca='+VehiculoMarca+'&Modelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&VehiculoAno='+VehiculoAno, {
		width: 900,
		max: 100,
		formatItem: FncProductoFormato,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoId").val(data[0]);				
			FncProductoBuscar("Id");	
		}		
	});

	$("#CmpProductoCodigoOriginal").unautocomplete();
	$("#CmpProductoCodigoOriginal").autocomplete(Ruta+'comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&t=', {
		width: 900,
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
	
	$("#CmpProductoCodigoAlternativo").unautocomplete();
	$("#CmpProductoCodigoAlternativo").autocomplete(Ruta+'comunes/Producto/XmlProducto.php?Cbu=ProCodigoAlternativo&t=', {

		width: 900,
		max: 100,

		formatItem: FncProductoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoCodigoAlternativo").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoId").val(data[0]);				
			FncProductoBuscar("Id");	
		}		
	});

	
}

$(function(){
	FncProductoAutocompletarCargar();
});