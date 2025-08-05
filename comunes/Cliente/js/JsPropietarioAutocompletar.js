// JavaScript Document

/*
Configuracion Autocompletar
*/

$().ready(function() {

	function PropietarioFormato(row) {
		return row[0];
	}
		
	$("#CmpPropietarioNombre").autocomplete("comunes/Cliente/XmlPropietario.php?Campo=CliNombreCompleto", {
		width: 500,
		max:20,
		selectFirst: true,
		formatItem: PropietarioFormato
	});	
	
	$("#CmpPropietarioNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpPropietarioId").val(data[1]);
			FncPropietarioBuscar("Id");
		}		
	});
	


	
	function PropietarioFormato2(row) {
		return row[2];
	}
		
	$("#CmpPropietarioNumeroDocumento").autocomplete("comunes/Cliente/XmlPropietario.php?Campo=CliNumeroDocumento", {
		width: 100,
		max:20,
		selectFirst: true,
		formatItem: PropietarioFormato2
	});	
	
	$("#CmpPropietarioNumeroDocumento").result(function(event, data, formatted) {
		if (data){
			$("#CmpPropietarioId").val(data[1]);
			FncPropietarioBuscar("Id");
		}		
	});
		
});

