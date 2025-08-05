// JavaScript Document

/*
Valores por defecto
*/
	
function FncNotaEntregaAutocompletarCargar(){

	$("#CmpNotaEntrega").unautocomplete();	
			
	function NotaEntregaFormato(row) {
		return row[2] + "-" +row[0]+ " | " +row[4]+ " | <i>" +row[3]+ "</i> ";
	}

	$("#CmpNotaEntrega").autocomplete("comunes/Documento/XmlNotaEntrega.php", {
		width: 550,
		selectFirst: false,
		formatItem: NotaEntregaFormato
	});	

	$("#CmpNotaEntrega").result(function(event, data, formatted) {
		if (data){
			$("#CmpNotaEntrega").val(data[2]+" - "+data[0]);
			$("#CmpNenId").val(data[0]);
			$("#CmpNetId").val(data[1]);
			$("#CmpNetNumero").val(data[2]);
		}
	});

}


/*;
Configuracion Autocompletar
*/

$().ready(function() {
	FncNotaEntregaAutocompletarCargar();
});