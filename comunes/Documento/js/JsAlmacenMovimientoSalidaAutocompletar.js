// JavaScript Document

/*
Valores por defecto
*/
var DocumentoAutocompletarVariables = "";

function FncAlmacenMovimientoSalidaAutocompletarCargar(){

	$("#CmpAlmacenMovimiento").unautocomplete();	
			
	function AlmacenMovimientoSalidaFormato(row) {
		return row[0] + "  " +  row[1];
	}

	$("#CmpAlmacenMovimiento").autocomplete("comunes/Documento/XmlAlmacenMovimientoSalida.php?1=1"+DocumentoAutocompletarVariables, {
		width: 550,
		selectFirst: false,
		formatItem: AlmacenMovimientoSalidaFormato
	});	

	$("#CmpAlmacenMovimiento").result(function(event, data, formatted) {
		if (data){
			$("#CmpAlmacenMovimiento").val(data[0]);
			$("#CmpAlmacenMovimientoId").val(data[0]);
			
			$('#CmpAlmacenMovimiento').attr('readonly', true);
		}
	});

}


/*;
Configuracion Autocompletar
*/

$().ready(function() {
	
	FncAlmacenMovimientoSalidaAutocompletarCargar();
	
});