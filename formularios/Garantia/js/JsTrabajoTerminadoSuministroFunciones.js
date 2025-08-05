// JavaScript Document




function FncGarantiaSuministroListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaSuministroListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+GarantiaSuministroEditar+'&Eliminar='+GarantiaSuministroEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');	
//			alert("#CapFichaAccion"+oModalidadIngreso+"Suministros");
			
			$("#CapFichaAccion"+oModalidadIngreso+"Suministros").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Suministros").append(html);
		}
	});
	
	


}


function FncGarantiaSuministroListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaSuministroListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+GarantiaSuministroEditar+'&Eliminar='+GarantiaSuministroEliminar,		
		success: function(html){
			$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Suministros2").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Suministros2").append(html);
		}
	});
	
}


