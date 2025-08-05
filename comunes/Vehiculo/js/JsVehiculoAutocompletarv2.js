/*
Configuracion Autocompletar
*/

/*
* Valores por defecto
*/

		
function FncVehiculoFormato1(row) {			
	
	return "<td>"+row[1]+"</td><td>"+row[6]+"</td><td align='left'>"+row[2]+"</td><td align='center'>"+row[3]+"</td>";
	
}		
		
function FncVehiculoFormato2(row) {			
	
	return "<td>"+row[6]+"</td><td>"+row[1]+"</td><td align='left'>"+row[2]+"</td><td align='center'>"+row[3]+"</td>";
	
}

function FncVehiculoAutocompletarCargar(){

	$("#CmpVehiculoNombre").unautocomplete();
	$("#CmpVehiculoNombre").autocomplete(Ruta+'comunes/Vehiculo/XmlVehiculo.php?Cbu=VehNombre', {
		width: 900,
		max: 100,
		formatItem: FncVehiculoFormato1,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpVehiculoNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpVehiculoId").val(data[0]);				
			FncVehiculoBuscar("Id");	
		}		
	});

	$("#CmpVehiculoCodigoIdentificador").unautocomplete();
	$("#CmpVehiculoCodigoIdentificador").autocomplete(Ruta+'comunes/Vehiculo/XmlVehiculo.php?Cbu=VehCodigoIdentificador&t=', {
		width: 900,
		max: 100,
		formatItem: FncVehiculoFormato2,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpVehiculoCodigoIdentificador").result(function(event, data, formatted) {
		if (data){
			$("#CmpVehiculoId").val(data[0]);				
			FncVehiculoBuscar("Id");	
		}		
	});
	
	
}

$(function(){
	
	FncVehiculoAutocompletarCargar();
	
});