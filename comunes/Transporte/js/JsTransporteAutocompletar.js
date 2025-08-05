// JavaScript Document

/*
Configuracion Autocompletar
*/
$().ready(function() {
				   
	function TransporteFormato(row) {
		return row[0];
	}
		
	$("#CmpTransporteNombre").autocomplete("comunes/Transporte/XmlTransporte.php", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: TransporteFormato
	});		

	$("#CmpTransporteNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpTransporteId").val(data[1]);				
			FncTransporteBuscar("Id");
		}		
	});

});