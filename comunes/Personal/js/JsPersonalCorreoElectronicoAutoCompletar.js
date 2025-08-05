


	
 $().ready(function() {


	function PersonalFormato(row) {
		return row[0] + " [" +row[1]+"]";
	}
	
	
	$("#CmpDestinatario").autocomplete("comunes/Personal/XmlPersonalCorreoElectronico.php", {
		multiple: true,
		mustMatch: true,
		autoFill: true,
		formatItem: PersonalFormato
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});
