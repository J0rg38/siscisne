// JavaScript Document

function FncPagoProveedorArchivoNuevo(){
}

function FncPagoProveedorArchivoGuardar(){
	
}


function FncPagoProveedorArchivoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapPagoProveedorArchivosAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PagoProveedor/FrmPagoProveedorArchivoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+PagoProveedorArchivoEditar+'&Eliminar='+PagoProveedorArchivoEliminar,
		success: function(html){
			$('#CapPagoProveedorArchivosAccion').html('Listo');	
			$("#CapPagoProveedorArchivos").html("");
			$("#CapPagoProveedorArchivos").append(html);
		}
	});
	
	

}



function FncPagoProveedorArchivoEscoger(oItem){
}

function FncPagoProveedorArchivoEliminar(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapPagoProveedorArchivosAccion').html('Eliminando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PagoProveedor/acc/AccPagoProveedorArchivoEliminar.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapPagoProveedorArchivosAccion').html("Eliminado");	
				FncPagoProveedorArchivoListar();
			}
		});

		FncPagoProveedorArchivoNuevo();

	}
	
}



function FncPagoProveedorArchivoEliminarTodo(){

	
	
}
