// JavaScript Document

var OrdenCompraEstado = 1

/*
Configuracion Autocompletar
*/
$().ready(function() {
	


	function OrdenCompraFormato(row) {
		//return row[0] + " " + row[1];
		return row[0];
	}

	$("#CmpOrdenCompra").autocomplete("comunes/OrdenCompra/XmlOrdenCompra.php?OrdenCompraEstado"+OrdenCompraEstado, {
		width: 200,
		selectFirst: false,
		formatItem: OrdenCompraFormato
	});	
	
	$("#CmpOrdenCompra").result(function(event, data, formatted) {
		if (data){

			$("#CmpOrdenCompraId").val(data[0]);
			FncOrdenCompraBuscar("Id");	

		}		
	});
	
});


