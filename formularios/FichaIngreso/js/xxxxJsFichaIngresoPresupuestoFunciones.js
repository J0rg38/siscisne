// JavaScript Document




function FncFichaIngresoPresupuestoListar(){

	var Identificador = $('#Identificador').val();

	var VehiculoModelo = $("#CmpVehiculoIngresoModeloId").val();
	var VehiculoVersion = $("#CmpVehiculoIngresoVersionId").val();	

	var VehiculoKilometraje = $("#CmpVehiculoKilometraje").val();
	var MantenimientoKilometraje = $("#CmpMantenimientoKilometraje").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();	
	
	$('#CapPresupuestoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/FrmFichaIngresoPresupuestoListado.php',
		//data: 'Identificador='+Identificador+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&VehiculoKilometraje='+VehiculoKilometraje+'&PresupuestoKilometraje='+PresupuestoKilometraje+'&Editar='+FichaIngresoPresupuestoEditar+'&Eliminar='+FichaIngresoPresupuestoEliminar,
data: 'Identificador='+Identificador+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&VehiculoKilometraje='+VehiculoKilometraje+'&MantenimientoKilometraje='+MantenimientoKilometraje+'&ClienteTipoId='+ClienteTipoId,
		success: function(html){
			$('#CapPresupuestoAccion').html('Listo');	
			$("#CapFichaIngresoPresupuestos").html("");
			$("#CapFichaIngresoPresupuestos").append(html);
		}
	});
	
	


}


