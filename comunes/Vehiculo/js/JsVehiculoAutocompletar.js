/*
Configuracion Autocompletar
*/

/*
* Valores por defecto
*/




//function FncVehiculoAutocompletarCargar(){
//	
//	$("#CmpVehiculoNombre").unautocomplete();	
//
//	function FncFormato(row) {			
//		return "<td>"+row[0]+"</td><td>"+row[1]+"</td><td align='left'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td><td align='center'>"+row[5]+"</td><td align='center'>"+row[6]+"</td>";
//	}
//
//	$("#CmpVehiculoNombre").autocomplete('comunes/Vehiculo/XmlVehiculo.php?', {
//		width: 900,
//		max: 100,
//		formatItem: FncFormato,
//		minChars: 2,
//		delay: 1000,
//		cacheLength: 50,
//		scroll: true,
//		scrollHeight: 200
//	});	
//	
//	$("#CmpVehiculoNombre").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpVehiculoId").val(data[0]);				
//			FncVehiculoBuscar("Id");	
//		}		
//	});
//	
//	
//	function FncFormato2(row) {			
//		return row[0];
//	}
//
//	$("#CmpVehiculoId").autocomplete('comunes/Vehiculo/XmlVehiculo.php?Cbu=VehId', {
//		width: 900,
//		max: 100,
//		formatItem: FncFormato2,
//		minChars: 2,
//		delay: 1000,
//		cacheLength: 50,
//		scroll: true,
//		scrollHeight: 200
//	});	
//	
//	$("#CmpVehiculoId").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpVehiculoId").val(data[0]);				
//			FncVehiculoBuscar("Id");	
//		}		
//	});
//	
//	
//	$("#CmpVehiculoNombre").autocomplete('comunes/Vehiculo/XmlVehiculo.php?Cbu=VehNombre', {
//		width: 900,
//		max: 100,
//		formatItem: FncFormato2,
//		minChars: 2,
//		delay: 1000,
//		cacheLength: 50,
//		scroll: true,
//		scrollHeight: 200
//	});	
//	
//	$("#CmpVehiculoNombre").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpVehiculoId").val(data[0]);				
//			FncVehiculoBuscar("Id");	
//		}		
//	});
//
//
//	
//}
//
//$(function(){
//	FncVehiculoAutocompletarCargar();
//});