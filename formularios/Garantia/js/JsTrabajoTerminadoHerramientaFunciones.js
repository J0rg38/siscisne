// JavaScript Document

/******************************************************************************/

function FncGarantiaHerramientaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapHerramientaAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaHerramientaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+GarantiaHerramientaEditar+'&Eliminar='+GarantiaHerramientaEliminar,
		success: function(html){
			$('#CapHerramientaAccion').html('Listo');	

			$("#CapFichaAccionHerramientas").html("");
			$("#CapFichaAccionHerramientas").append(html);
		}
	});

}


function FncGarantiaHerramientaListar2(){

	var Identificador = $('#Identificador').val();

	$('#CapHerramientaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaHerramientaListado2.php',
		data: 'Identificador='+Identificador+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#CapHerramientaAccion').html('Listo');	
			$("#CapFichaAccionHerramientas2").html("");
			$("#CapFichaAccionHerramientas2").append(html);
		}
	});
	
}

