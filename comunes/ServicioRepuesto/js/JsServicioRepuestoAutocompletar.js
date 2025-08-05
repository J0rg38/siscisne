/*
Configuracion Autocompletar
*/

/*
* Valores por defecto
*/

		
function FncServicioRepuestoFormato(row) {			
	
	return row[0];
}		
		
function FncServicioRepuestoAutocompletarCargar(){

	//var TipoGasto = $("#CmpTipoGasto").val();

	$("#CmpServicioRepuestoNombre").unautocomplete();
		$("#CmpServicioRepuestoNombre").autocomplete(Ruta+'comunes/ServicioRepuesto/XmlServicioRepuesto.php?Cbu=SreNombre', {
//	$("#CmpServicioRepuestoNombre").autocomplete(Ruta+'comunes/ServicioRepuesto/XmlServicioRepuesto.php?Cbu=SreNombre&TipoGasto='+TipoGasto, {
		width: 900,
		max: 100,
		formatItem: FncServicioRepuestoFormato,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpServicioRepuestoNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpServicioRepuestoId").val(data[1]);				
			FncServicioRepuestoBuscar("Id");	
		}		
	});

}

$(function(){
	FncServicioRepuestoAutocompletarCargar();
});