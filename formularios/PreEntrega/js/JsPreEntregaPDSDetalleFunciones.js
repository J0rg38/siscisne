// JavaScript Document




function FncPreEntregaPDSDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapPreEntregaPDSDetalleAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PreEntrega/FrmPreEntregaPDSDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+PreEntregaDetalleEditar+'&Eliminar='+PreEntregaDetalleEliminar,
		success: function(html){
			$('#CapPreEntregaPDSDetalleAccion').html('Listo');	
			$("#CapPreEntregaPDSDetalles").html("");
			$("#CapPreEntregaPDSDetalles").append(html);
		}
	});


}


