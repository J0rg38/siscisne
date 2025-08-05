// JavaScript Document

function FncPreEntregaProductoNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'ProductoId').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoItem').val("");	
			
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo para registrar elementos');	
			
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').focus();
			
	$('#CmpPreEntrega'+oModalidadIngreso+'ProductoAccion').val("AccPreEntregaProductoRegistrar.php");

}

function FncPreEntregaProductoGuardar(oModalidadIngreso){

var Identificador = $('#Identificador').val();

	var Acc = $('#CmpPreEntrega'+oModalidadIngreso+'ProductoAccion').val();		
	
			var ProductoId = $('#Cmp'+oModalidadIngreso+'ProductoId').val();
			var ProductoNombre = $('#Cmp'+oModalidadIngreso+'ProductoNombre').val();
			var ProductoCodigoOriginal = $('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val();
			var ProductoCodigoAlternativo = $('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val();
			var Item = $('#Cmp'+oModalidadIngreso+'ProductoItem').val();
	
			if(ProductoNombre==""){
				$('#Cmp'+oModalidadIngreso+'ProductoNombre').focus();	
			}else{
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Guardando...');
				
				
						$.ajax({
							type: 'POST',
							url: 'formularios/PreEntrega/acc/'+Acc,
							data: 'Identificador='+Identificador+'&ProductoCodigoOriginal='+ProductoCodigoOriginal+'&ProductoCodigoAlternativo='+ProductoCodigoAlternativo+'&ProductoNombre='+ProductoNombre+'&ProductoId='+ProductoId+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(rpta){
								
								if(rpta != "" ){
									alert(rpta);
								}
								
								
								$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');							
									FncPreEntregaProductoListar(oModalidadIngreso);
								}
						});
						
						
						
								/*if(confirm("Desea seguir agregando mas items?")==false){
									if(confirm("Desea guardar el registro ahora?")){
										$('#Guardar').val("1");
										$('#'+Formulario).submit();
									}
								}*/
								
							FncPreEntregaProductoNuevo(oModalidadIngreso);	
					
					
				}
			

	
}


function FncPreEntregaProductoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PreEntrega/FrmPreEntregaProductoListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaIngresoProductoEditar+'&Eliminar='+FichaIngresoProductoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			$("#CapPreEntrega"+oModalidadIngreso+"Productos").html("");
			$("#CapPreEntrega"+oModalidadIngreso+"Productos").append(html);
		}
	});
	
	


}



function FncPreEntregaProductoEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Editando...');
	$('#CmpPreEntrega'+oModalidadIngreso+'ProductoAccion').val("AccPreEntregaProductoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PreEntrega/acc/AccPreEntregaProductoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaIngresoProducto){
			
/*
SesionObjeto-FichaIngresoProducto
Parametro1 = FidId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = ProCodigoOriginal
Parametro5 = ProCodigoAlternativo
Parametro6 = 
Parametro7 = FipTiempoCreacion
Parametro8 = FipTiempoModificacion
*/
				$('#Cmp'+oModalidadIngreso+'ProductoId').val(InsFichaIngresoProducto.Parametro2);
				$('#Cmp'+oModalidadIngreso+'ProductoNombre').val(InsFichaIngresoProducto.Parametro3);
				
				$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val(InsFichaIngresoProducto.Parametro4);
				$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val(InsFichaIngresoProducto.Parametro5);
				
				$('#Cmp'+oModalidadIngreso+'ProductoItem').val(InsFichaIngresoProducto.Item);
		}
	});
	
	
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').select();
	
}

function FncPreEntregaProductoEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PreEntrega/acc/AccPreEntregaProductoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html("Eliminado");	
				FncPreEntregaProductoListar(oModalidadIngreso);
			}
		});

		FncPreEntregaProductoNuevo(oModalidadIngreso);

	}
	
}



function FncPreEntregaProductoEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
	
			$.ajax({
			type: 'POST',
			url: 'formularios/PreEntrega/acc/AccPreEntregaProductoEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminado');	
				FncPreEntregaProductoListar(oModalidadIngreso);
			}
		});	
			
		FncPreEntregaProductoNuevo(oModalidadIngreso);
	}
	
}
