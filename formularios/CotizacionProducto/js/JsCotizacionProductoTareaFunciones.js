// JavaScript Document

function FncCotizacionProductoTareaNuevo(){
	
	$('#CmpCotizacionProductoTareaId').val("");
	$('#CmpCotizacionProductoTareaDescripcion').val("");

	$('#CmpCotizacionProductoTareaImporte').val("");
	$('#CmpCotizacionProductoTareaEstado').val("");
	$('#CmpCotizacionProductoTareaItem').val("");	

			
	$('#CapCotizacionProductoTareaAccion').html('Listo para registrar elementos');	
			
	$('#CmpCotizacionProductoTareaDescripcion').focus();
			
	$('#CmpCotizacionProductoTareaAccion').val("AccCotizacionProductoTareaRegistrar.php");

}

function FncCotizacionProductoTareaGuardar(){

	var Identificador = $('#Identificador').val();
	
			var Acc = $('#CmpCotizacionProductoTareaAccion').val();		
	
			var CotizacionProductoTareaDescripcion = $('#CmpCotizacionProductoTareaDescripcion').val();
			var CotizacionProductoTareaImporte = $('#CmpCotizacionProductoTareaImporte').val();
			var CotizacionProductoTareaEstado = $('#CmpCotizacionProductoTareaEstado').val();

			var Item = $('#CmpCotizacionProductoTareaItem').val();
			
			if(CotizacionProductoTareaDescripcion==""){
				$('#CmpCotizacionProductoTareaDescripcion').select();	
			//}else if(CotizacionProductoTareaImporte=="" || CotizacionProductoTareaImporte <=0){
			//	$('#CmpCotizacionProductoTareaImporte').select();	
			}else{
				$('#CapCotizacionProductoTareaAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/CotizacionProducto/acc/'+Acc,
							data: 'Identificador='+Identificador+'&CotizacionProductoTareaDescripcion='+CotizacionProductoTareaDescripcion+'&CotizacionProductoTareaImporte='+CotizacionProductoTareaImporte+'&CotizacionProductoTareaEstado='+CotizacionProductoTareaEstado+'&Item='+Item,
							success: function(){
								
							$('#CapCotizacionProductoTareaAccion').html('Listo');							
								FncCotizacionProductoTareaListar();
							}
						});
						

							FncCotizacionProductoTareaNuevo();	
					
					
			}
			
			
	
}


function FncCotizacionProductoTareaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionProductoTareaAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionProducto/FrmCotizacionProductoTareaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+CotizacionProductoTareaEditar+'&Eliminar='+CotizacionProductoTareaEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&IncluyeImpuesto='+IncluyeImpuesto,
		success: function(html){
			$('#CapCotizacionProductoTareaAccion').html('Listo');	
			$("#CapCotizacionProductoTareas").html("");
			$("#CapCotizacionProductoTareas").append(html);
			FncCotizacionProductoDetalleListar();
		}
	});
	
	FncCotizacionProductoTotalListar();

}



function FncCotizacionProductoTareaEscoger(oItem){

	$('#CapCotizacionProductoTareaAccion').html('Editando...');
	$('#CmpCotizacionProductoTareaAccion').val("AccCotizacionProductoTareaEditar.php");

	var Identificador = $('#Identificador').val();
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoTareaEscoger.php',
		data:  'Item='+oItem+'&Identificador='+Identificador,
		success: function(InsCotizacionProductoTarea){

//						SesionObjeto-CotizacionProductoPlanchado
//						Parametro1 = CppId
//						Parametro2 = CppDescripcion
//						Parametro3 = CppPrecio
//						Parametro4 = CppCantidad
//						Parametro5 = CppImporte
//						Parametro6 = CppEstado
//						Parametro7 = CppTipo
//						Parametro8 = CppTiempoCreacion
//						Parametro9 = CppTiempoModificacion

				$('#CmpCotizacionProductoTareaId').val(InsCotizacionProductoTarea.Parametro1);	
				$('#CmpCotizacionProductoTareaDescripcion').val(InsCotizacionProductoTarea.Parametro2);
				$('#CmpCotizacionProductoTareaImporte').val(InsCotizacionProductoTarea.Parametro5);
				$('#CmpCotizacionProductoTareaEstado').val(InsCotizacionProductoTarea.Parametro6);
				
				$('#CmpCotizacionProductoTareaItem').val(InsCotizacionProductoTarea.Item);
				
				$('#CmpCotizacionProductoTareaImporte').select();
				
		}
	});
	
		


}

function FncCotizacionProductoTareaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapCotizacionProductoTareaAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoTareaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapCotizacionProductoTareaAccion').html("Eliminado");	
				FncCotizacionProductoTareaListar();
			}
		});

		FncCotizacionProductoTareaNuevo();

	}
	
}

function FncCotizacionProductoTareaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapCotizacionProductoTareaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoTareaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapCotizacionProductoTareaAccion').html('Eliminado');	
				FncCotizacionProductoTareaListar();
			}
		});	
			
		FncCotizacionProductoTareaNuevo();
	}
	
}

