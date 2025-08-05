// JavaScript Document

/*
Valores por defecto
*/
var DocumentoAutocompletarVariables = "";

function FncVehiculoMovimientoSalidaAutocompletarCargar(){

	$("#CmpVehiculoMovimiento").unautocomplete();	
			
	function VehiculoMovimientoSalidaFormato(row) {
		return row[0] + "  " +  row[1];
	}

	$("#CmpVehiculoMovimiento").autocomplete("comunes/Documento/XmlVehiculoMovimientoSalida.php?1=1"+DocumentoAutocompletarVariables, {
		width: 550,
		selectFirst: false,
		formatItem: VehiculoMovimientoSalidaFormato
	});	

	$("#CmpVehiculoMovimiento").result(function(event, data, formatted) {
		if (data){
			$("#CmpVehiculoMovimiento").val(data[0]);
			$("#CmpVehiculoMovimientoId").val(data[0]);
			
			$('#CmpVehiculoMovimiento').attr('readonly', true);
		}
	});

}


/*;
Configuracion Autocompletar
*/

$().ready(function() {
	
	FncVehiculoMovimientoSalidaAutocompletarCargar();
	
});