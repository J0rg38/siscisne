// JavaScript Document

function FncGarantiaProductoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaProductoListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+GarantiaProductoEditar+'&Eliminar='+GarantiaProductoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Productos").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Productos").append(html);
		}
	});

}


function FncGarantiaProductoListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaProductoListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+GarantiaProductoEditar+'&Eliminar='+GarantiaProductoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Productos2").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Productos2").append(html);
		}
	});
	
}
