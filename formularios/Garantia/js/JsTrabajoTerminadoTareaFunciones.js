// JavaScript Document



function FncGarantiaTareaListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaTareaListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+GarantiaTareaEditar+'&Eliminar='+GarantiaTareaEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	
			//alert(html);
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas").append(html);
		}
	});
	
}

function FncGarantiaTareaListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaTareaListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	

			$("#CapFichaAccion"+oModalidadIngreso+"Tareas2").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas2").append(html);
		}
	});
	
}