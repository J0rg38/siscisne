// JavaScript Document

/*
Configuracion Autocompletar
*/

$().ready(function() {

	function PersonalFormato(row) {
		return row[0] + " " + row[3]+ " " + row[4];
	}
		
	$("#CmpPersonalNombre").autocomplete("comunes/Personal/XmlPersonal.php?Campo=PerNombreCompleto", {
		width: 500,
		max:20,
		selectFirst: true,
		formatItem: PersonalFormato
	});	
	
	$("#CmpPersonalNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpPersonalId").val(data[1]);
			FncPersonalBuscar("Id");
		}		
	});
	
	
	function PersonalFormato2(row) {
		return row[2];
	}
		
	$("#CmpPersonalNumeroDocumento").autocomplete("comunes/Personal/XmlPersonal.php?Campo=PerNumeroDocumento", {
		width: 100,
		max:20,
		selectFirst: true,
		formatItem: PersonalFormato2
	});	
	
	$("#CmpPersonalNumeroDocumento").result(function(event, data, formatted) {
		if (data){
			$("#CmpPersonalId").val(data[1]);
			FncPersonalBuscar("Id");
		}		
	});
		
});



