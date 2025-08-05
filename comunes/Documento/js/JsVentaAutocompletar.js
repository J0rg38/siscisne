// JavaScript Document

/*
Valores por defecto
*/
	
function FncVentaAutocompletarCargar(){

	$("#CmpVenta").unautocomplete();	
			
	function VentaFormato(row) {
		return row[2] + "-" +row[0]+ " | " +row[4]+ " | <i>" +row[3]+ "</i> ";
	}

	$("#CmpVenta").autocomplete("comunes/Documento/XmlVenta.php", {
		width: 550,
		selectFirst: false,
		formatItem: VentaFormato
	});	

	$("#CmpVenta").result(function(event, data, formatted) {
		if (data){
			$("#CmpVenta").val(data[2]+" - "+data[0]);
			$("#CmpVenId").val(data[0]);
			$("#CmpVtaId").val(data[1]);
			$("#CmpVtaNumero").val(data[2]);
		}
	});

}


/*;
Configuracion Autocompletar
*/

$().ready(function() {
	FncVentaAutocompletarCargar();
});