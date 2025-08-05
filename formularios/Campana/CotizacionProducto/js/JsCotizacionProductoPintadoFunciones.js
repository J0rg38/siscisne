// JavaScript Document

function FncCotizacionProductoPintadoNuevo(){
	
	$('#CmpCotizacionProductoPintadoId').val("");
	$('#CmpCotizacionProductoPintadoDescripcion').val("");

	$('#CmpCotizacionProductoPintadoImporte').val("");
	$('#CmpCotizacionProductoPintadoEstado').val("");
	$('#CmpCotizacionProductoPintadoItem').val("");	

	$('#CapCotizacionProductoPintadoAccion').html('Listo para registrar elementos');	
			
	$('#CmpCotizacionProductoPintadoDescripcion').focus();
			
	$('#CmpCotizacionProductoPintadoAccion').val("AccCotizacionProductoPintadoRegistrar.php");

}

function FncCotizacionProductoPintadoGuardar(){

	var Identificador = $('#Identificador').val();
	
			var Acc = $('#CmpCotizacionProductoPintadoAccion').val();		
		
			var CotizacionProductoPintadoDescripcion = $('#CmpCotizacionProductoPintadoDescripcion').val();
			var CotizacionProductoPintadoImporte = $('#CmpCotizacionProductoPintadoImporte').val();
			var CotizacionProductoPintadoEstado = $('#CmpCotizacionProductoPintadoEstado').val();

			var Item = $('#CmpCotizacionProductoPintadoItem').val();
			
			if(CotizacionProductoPintadoDescripcion==""){
				$('#CmpCotizacionProductoPintadoDescripcion').select();	
			}else if(CotizacionProductoPintadoImporte=="" || CotizacionProductoPintadoImporte <=0){
				$('#CmpCotizacionProductoPintadoImporte').select();	
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/CotizacionProducto/acc/'+Acc,
							data: 'Identificador='+Identificador+'&CotizacionProductoPintadoDescripcion='+CotizacionProductoPintadoDescripcion+'&CotizacionProductoPintadoImporte='+CotizacionProductoPintadoImporte+'&CotizacionProductoPintadoEstado='+CotizacionProductoPintadoEstado+'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncCotizacionProductoPintadoListar();
							}
						});
						

							FncCotizacionProductoPintadoNuevo();	
					
					
			}
			
			
	
}


function FncCotizacionProductoPintadoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionProductoPintadoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionProducto/FrmCotizacionProductoPintadoListado.php',
		data:  'Identificador='+Identificador+'&Editar='+CotizacionProductoPintadoEditar+'&Eliminar='+CotizacionProductoPintadoEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&IncluyeImpuesto='+IncluyeImpuesto,
		success: function(html){
			$('#CapCotizacionProductoPintadoAccion').html('Listo');	
			$("#CapCotizacionProductoPintados").html("");
			$("#CapCotizacionProductoPintados").append(html);
		}
	});

}



function FncCotizacionProductoPintadoEscoger(oItem){
		
	$('#CapCotizacionProductoPintadoAccion').html('Editando...');
	$('#CmpCotizacionProductoPintadoAccion').val("AccCotizacionProductoPintadoEditar.php");

	var Identificador = $('#Identificador').val();

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoPintadoEscoger.php',
		data:  'Item='+oItem+'&Identificador='+Identificador,
		success: function(InsCotizacionProductoPintado){

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

				$('#CmpCotizacionProductoPintadoId').val(InsCotizacionProductoPintado.Parametro1);	
				$('#CmpCotizacionProductoPintadoDescripcion').val(InsCotizacionProductoPintado.Parametro2);
				$('#CmpCotizacionProductoPintadoImporte').val(InsCotizacionProductoPintado.Parametro5);
				$('#CmpCotizacionProductoPintadoEstado').val(InsCotizacionProductoPintado.Parametro6);
				
				$('#CmpCotizacionProductoPintadoItem').val(InsCotizacionProductoPintado.Item);
				
				$('#CmpCotizacionProductoPintadoImporte').select();
		}
	});
	



}

function FncCotizacionProductoPintadoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoPintadoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncCotizacionProductoPintadoListar();
			}
		});

		FncCotizacionProductoPintadoNuevo();

	}
	
}

function FncCotizacionProductoPintadoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoPintadoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncCotizacionProductoPintadoListar();
			}
		});	
			
		FncCotizacionProductoPintadoNuevo();
	}
	
}



