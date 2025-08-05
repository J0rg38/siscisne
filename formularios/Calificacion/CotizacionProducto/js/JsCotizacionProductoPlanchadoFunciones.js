// JavaScript Document

function FncCotizacionProductoPlanchadoNuevo(){
	
	$('#CmpCotizacionProductoPlanchadoId').val("");
	$('#CmpCotizacionProductoPlanchadoDescripcion').val("");

	$('#CmpCotizacionProductoPlanchadoImporte').val("");
	$('#CmpCotizacionProductoPlanchadoEstado').val("");
	$('#CmpCotizacionProductoPlanchadoItem').val("");	

			
	$('#CapCotizacionProductoPlanchadoAccion').html('Listo para registrar elementos');	
			
	$('#CmpCotizacionProductoPlanchadoDescripcion').focus();
			
	$('#CmpCotizacionProductoPlanchadoAccion').val("AccCotizacionProductoPlanchadoRegistrar.php");

}

function FncCotizacionProductoPlanchadoGuardar(){

			var Identificador = $('#Identificador').val();
	
			var Acc = $('#CmpCotizacionProductoPlanchadoAccion').val();		
	
			var CotizacionProductoPlanchadoDescripcion = $('#CmpCotizacionProductoPlanchadoDescripcion').val();
			var CotizacionProductoPlanchadoImporte = $('#CmpCotizacionProductoPlanchadoImporte').val();
			var CotizacionProductoPlanchadoEstado = $('#CmpCotizacionProductoPlanchadoEstado').val();

			var Item = $('#CmpCotizacionProductoPlanchadoItem').val();
			
			if(CotizacionProductoPlanchadoDescripcion==""){
				$('#CmpCotizacionProductoPlanchadoDescripcion').select();	
			}else if(CotizacionProductoPlanchadoImporte=="" || CotizacionProductoPlanchadoImporte <=0){
				$('#CmpCotizacionProductoPlanchadoImporte').select();	
			}else{
				$('#CapCotizacionProductoPlanchadoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/CotizacionProducto/acc/'+Acc,
							data: 'CotizacionProductoPlanchadoDescripcion='+CotizacionProductoPlanchadoDescripcion+'&CotizacionProductoPlanchadoImporte='+CotizacionProductoPlanchadoImporte+'&CotizacionProductoPlanchadoEstado='+CotizacionProductoPlanchadoEstado+'&Identificador='+Identificador+'&Item='+Item,
							success: function(){
							$('#CapCotizacionProductoPlanchadoAccion').html('Listo');							
								FncCotizacionProductoPlanchadoListar();
							}
						});
						

					FncCotizacionProductoPlanchadoNuevo();	
					
					
			}
			
			
	
}


function FncCotizacionProductoPlanchadoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionProductoPlanchadoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionProducto/FrmCotizacionProductoPlanchadoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+CotizacionProductoPlanchadoEditar+'&Eliminar='+CotizacionProductoPlanchadoEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&IncluyeImpuesto='+IncluyeImpuesto,
		success: function(html){
			$('#CapCotizacionProductoPlanchadoAccion').html('Listo');	
			$("#CapCotizacionProductoPlanchados").html("");
			$("#CapCotizacionProductoPlanchados").append(html);
		}
	});

}



function FncCotizacionProductoPlanchadoEscoger(oItem){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionProductoPlanchadoAccion').html('Editando...');
	$('#CmpCotizacionProductoPlanchadoAccion').val("AccCotizacionProductoPlanchadoEditar.php");

	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoPlanchadoEscoger.php',
		data: 'Item='+oItem+'&Identificador='+Identificador,
		success: function(InsCotizacionProductoPlanchado){

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

				$('#CmpCotizacionProductoPlanchadoId').val(InsCotizacionProductoPlanchado.Parametro1);	
				$('#CmpCotizacionProductoPlanchadoDescripcion').val(InsCotizacionProductoPlanchado.Parametro2);
				$('#CmpCotizacionProductoPlanchadoImporte').val(InsCotizacionProductoPlanchado.Parametro5);
				$('#CmpCotizacionProductoPlanchadoEstado').val(InsCotizacionProductoPlanchado.Parametro6);
				
				$('#CmpCotizacionProductoPlanchadoItem').val(InsCotizacionProductoPlanchado.Item);
				
				$('#CmpCotizacionProductoPlanchadoImporte').select();
				
		}
	});
	
		


}

function FncCotizacionProductoPlanchadoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapCotizacionProductoPlanchadoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoPlanchadoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapCotizacionProductoPlanchadoAccion').html("Eliminado");	
				FncCotizacionProductoPlanchadoListar();
			}
		});

		FncCotizacionProductoPlanchadoNuevo();

	}
	
}

function FncCotizacionProductoPlanchadoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapCotizacionProductoPlanchadoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoPlanchadoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapCotizacionProductoPlanchadoAccion').html('Eliminado');	
				FncCotizacionProductoPlanchadoListar();
			}
		});	
			
		FncCotizacionProductoPlanchadoNuevo();
	}
	
}



//
//function FncCotizacionProductoPlanchadoIncluir(){
//
//	var CotizacionProductoId = $('#CmpId').val();
//	
//	if($("#CmpPlanchado").is(':checked')){
//
//		$.ajax({
//			type: 'POST',
//			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoPlanchadoCargar.php',
//			data: 'CotizacionProductoId='+CotizacionProductoId,
//			success: function(){
//				$('#CapCotizacionProductoPlanchadoAccion').html('Eliminado');	
//				FncCotizacionProductoPlanchadoListar();
//			}
//		});	
//		
//	}else{
//		FncCotizacionProductoPlanchadoEliminarTodo();
//	}
//		
//}
//


