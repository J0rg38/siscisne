// JavaScript Document

function FncPagoOrdenVentaVehiculoFotoNuevo(){
}

function FncPagoOrdenVentaVehiculoFotoGuardar(){
	
}


function FncPagoOrdenVentaVehiculoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapPagoOrdenVentaVehiculoFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PagoOrdenVentaVehiculoC/FrmPagoOrdenVentaVehiculoFotoAbonoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+PagoOrdenVentaVehiculoFotoEditar+'&Eliminar='+PagoOrdenVentaVehiculoFotoEliminar,
		success: function(html){
			$('#CapPagoOrdenVentaVehiculoFotosAccion').html('Listo');	
			$("#CapPagoOrdenVentaVehiculoFotos").html("");
			$("#CapPagoOrdenVentaVehiculoFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncPagoOrdenVentaVehiculoFotoEscoger(oItem){
}

function FncPagoOrdenVentaVehiculoFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapPagoOrdenVentaVehiculoFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PagoOrdenVentaVehiculoC/acc/AccPagoOrdenVentaVehiculoFotoAbonoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapPagoOrdenVentaVehiculoFotosAccion').html("Eliminado");	
				FncPagoOrdenVentaVehiculoFotoListar();
			}
		});

		FncPagoOrdenVentaVehiculoFotoNuevo();

	}
	
}

function FncPagoOrdenVentaVehiculoFotoEliminarTodo(){

	
}



function tb_remove(oModulo){
	
	//self.parent.tb_remove2(oModulo);
	  window.opener.tb_remove2(oModulo);
	window.close();
}