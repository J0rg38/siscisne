// JavaScript Document

/*
Configuracion Autocompletar
*/

$().ready(function() {

	function ClienteFormato(row) {
		return row[0];
	}
		
	$("#CmpClienteNombreCompleto").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombreCompleto", {
		width: 500,
		max:20,
		selectFirst: true,
		formatItem: ClienteFormato
	});	
	
	$("#CmpClienteNombreCompleto").result(function(event, data, formatted) {
		if (data){
			$("#CmpClienteId").val(data[1]);
			FncClienteSimpleBuscar("Id");
		}		
	});
	


	
	function ClienteFormato2(row) {
		return row[2];
	}
		
	$("#CmpClienteNumeroDocumento").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento", {
		width: 100,
		max:20,
		selectFirst: true,
		formatItem: ClienteFormato2
	});	
	
	$("#CmpClienteNumeroDocumento").result(function(event, data, formatted) {
		if (data){
			$("#CmpClienteId").val(data[1]);
			FncClienteSimpleBuscar("Id");
		}		
	});
		
});



