// JavaScript Document

function FncOrdenVentaVehiculoFotoNuevo(){
}

function FncOrdenVentaVehiculoFotoGuardar(){
	
}


function FncOrdenVentaVehiculoFotoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapOrdenVentaVehiculoFotosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenVentaVehiculoC/FrmOrdenVentaVehiculoFotoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+OrdenVentaVehiculoFotoEditar+'&Eliminar='+OrdenVentaVehiculoFotoEliminar,
		success: function(html){
			$('#CapOrdenVentaVehiculoFotosAccion').html('Listo');	
			$("#CapOrdenVentaVehiculoFotos").html("");
			$("#CapOrdenVentaVehiculoFotos").append(html);
			
			tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
			
		}
	});
	
	

}



function FncOrdenVentaVehiculoFotoEscoger(oItem){
}

function FncOrdenVentaVehiculoFotoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapOrdenVentaVehiculoFotosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculoC/acc/AccOrdenVentaVehiculoFotoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapOrdenVentaVehiculoFotosAccion').html("Eliminado");	
				FncOrdenVentaVehiculoFotoListar();
			}
		});

		FncOrdenVentaVehiculoFotoNuevo();

	}
	
}

function FncOrdenVentaVehiculoFotoEliminarTodo(){

	
}



function tb_remove(oModulo){
	
	//self.parent.tb_remove2(oModulo);
	  window.opener.tb_remove2(oModulo);
	window.close();
}