// JavaScript Document

/*
Configuracion Autocompletar
*/

var ClienteEstado = "1";

$().ready(function() {

	function ClienteFormato(row) {
		return row[0];
	}
		
	$("#CmpClienteNombre").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNombre,CliApellidoPaterno,CliApellidoMaterno,CliNombreCompleto&Estado="+ClienteEstado, {
		width: 500,
		max:20,
		selectFirst: true,
		formatItem: ClienteFormato
	});	
	
	$("#CmpClienteNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpClienteId").val(data[1]);
			FncClienteBuscar("Id");
		}		
	});
	


	
	function ClienteFormato2(row) {
		return row[2];
	}
		
	$("#CmpClienteNumeroDocumento").autocomplete("comunes/Cliente/XmlCliente.php?Campo=CliNumeroDocumento&Estado="+ClienteEstado, {
		width: 100,
		max:20,
		selectFirst: true,
		formatItem: ClienteFormato2
	});	
	
	$("#CmpClienteNumeroDocumento").result(function(event, data, formatted) {
		if (data){
			$("#CmpClienteId").val(data[1]);
			FncClienteBuscar("Id");
		}		
	});
		
});



