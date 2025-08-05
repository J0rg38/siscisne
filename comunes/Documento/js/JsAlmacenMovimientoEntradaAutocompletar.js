// JavaScript Document

/*
Valores por defecto
*/
var DocumentoAutocompletarVariables = "";

function FncAlmacenMovimientoEntradaAutocompletarCargar(){

	$("#CmpAlmacenMovimientoEntrada").unautocomplete();	
			
	function AlmacenMovimientoEntradaFormato(row) {
		return row[0] + "  " +  row[1];
	}

	$("#CmpAlmacenMovimientoEntrada").autocomplete("comunes/Documento/XmlAlmacenMovimientoEntrada.php?1=1"+DocumentoAutocompletarVariables, {
		width: 550,
		selectFirst: false,
		formatItem: AlmacenMovimientoEntradaFormato
	});	

	$("#CmpAlmacenMovimientoEntrada").result(function(event, data, formatted) {
		if (data){
			$("#CmpAlmacenMovimientoEntrada").val(data[0]);
			$("#CmpAmoId").val(data[0]);


		}
	});

}


/*;
Configuracion Autocompletar
*/

$().ready(function() {
	FncAlmacenMovimientoEntradaAutocompletarCargar();
});