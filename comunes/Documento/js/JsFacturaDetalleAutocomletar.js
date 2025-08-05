// JavaScript Document

/*
Valores por defecto
*/
var DocumentoAutocompletarVariables = "";

function FncFacturaDetalleAutocompletarCargar(){

	$("#CmpFacturaDetalleDescripcion").unautocomplete();	
			
	function FacturaDetalleFormato(row) {
		return row[1];
	}

	$("#CmpFacturaDetalleDescripcion").autocomplete("comunes/Documento/XmlFacturaDetalle.php?1=1"+DocumentoAutocompletarVariables, {
		width: 550,
		selectFirst: false,
		formatItem: FacturaDetalleFormato
	});	

	$("#CmpFacturaDetalleDescripcion").result(function(event, data, formatted) {
		if (data){
			$("#CmpFacturaDetalleDescripcion").val(data[1]);
			$("#CmpFacturaDetalleCodigo").val(data[0]);
			$("#CmpFacturaDetalleCodigo").val(data[0]);
			$('#CmpFacturaDetalleUnidadMedida').attr('readonly', true);
		}
	});

}


/*;
Configuracion Autocompletar
*/

$().ready(function() {
	
	FncFacturaDetalleAutocompletarCargar();
	
});