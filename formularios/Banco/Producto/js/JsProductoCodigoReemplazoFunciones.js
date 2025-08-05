// JavaScript Document

// JavaScript Document

function FncProductoCodigoReemplazoNuevo(){

	var MonedaId = $('#CmpMonedaId').val();

	$('#CmpProductoCodigoReemplazoId').val("");

	$('#CmpProductoCodigoReemplazoNumero').val("");
	$('#CmpProductoCodigoReemplazoItem').val("");	

	$('#CapProductoCodigoReemplazoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoReemplazoNumero').select();
			
	$('#CmpProductoCodigoReemplazoAccion').val("AccProductoCodigoReemplazoRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncProductoCodigoReemplazoGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpProductoCodigoReemplazoAccion').val();		

	var ProductoCodigoReemplazoId = $('#CmpProductoCodigoReemplazoId').val();
	var ProductoCodigoReemplazoNumero = $('#CmpProductoCodigoReemplazoNumero').val();			
				
	var Item = $('#CmpProductoCodigoReemplazoItem').val();
	
	if(ProductoCodigoReemplazoNumero==""){
		$('#CmpProductoCodigoReemplazoNumero').select();
	}else{
		$('#CapProductoCodigoReemplazoAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/Producto/acc/'+Acc,
			data: 'Identificador='+Identificador+'&ProductoCodigoReemplazoId='+ProductoCodigoReemplazoId+'&ProductoCodigoReemplazoNumero='+ProductoCodigoReemplazoNumero+'&Item='+Item,
			success: function(){
				
			$('#CapProductoCodigoReemplazoAccion').html('Listo');							
				FncProductoCodigoReemplazoListar();
			}
		});
		
		FncProductoCodigoReemplazoNuevo();
	}
	
}


function FncProductoCodigoReemplazoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoCodigoReemplazoAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/Producto/FrmProductoCodigoReemplazoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+ProductoCodigoReemplazoEditar+'&Eliminar='+ProductoCodigoReemplazoEliminar,
		success: function(html){
			$('#CapProductoCodigoReemplazoAccion').html('Listo');	
			$("#CapProductoCodigoReemplazos").html("");
			$("#CapProductoCodigoReemplazos").append(html);
		}
	});

}



function FncProductoCodigoReemplazoEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoCodigoReemplazoAccion').html('Editando...');
	$('#CmpProductoCodigoReemplazoAccion').val("AccProductoCodigoReemplazoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Producto/acc/AccProductoCodigoReemplazoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsProductoCodigoReemplazo){

		//SesionObjeto-InsProductoCodigoReemplazo
		//Parametro1 = PcrId
		//Parametro2 = PcrNumero
		//Parametro3 = PcrEstado
		//Parametro4 = PcrTiempoCreacion
		//Parametro5 = PcrTiempoModificacion
			
			$('#CmpProductoCodigoReemplazoNumero').val(InsProductoCodigoReemplazo.Parametro2);
			$('#CmpProductoCodigoReemplazoItem').val(InsProductoCodigoReemplazo.Item);
			$('#CmpProductoCodigoReemplazoNumero').select();
				
		}
	});
	
	

	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncProductoCodigoReemplazoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoCodigoReemplazoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Producto/acc/AccProductoCodigoReemplazoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoCodigoReemplazoAccion').html("Eliminado");	
				FncProductoCodigoReemplazoListar();
			}
		});

		FncProductoCodigoReemplazoNuevo();

	}
	
}

function FncProductoCodigoReemplazoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoCodigoReemplazoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Producto/acc/AccProductoCodigoReemplazoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoCodigoReemplazoAccion').html('Eliminado');	
				FncProductoCodigoReemplazoListar();
			}
		});	
			
		FncProductoCodigoReemplazoNuevo();
	}
	
}
