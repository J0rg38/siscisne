// JavaScript Document

function FncCotizacionProductoCentradoNuevo(){
	
	$('#CmpCotizacionProductoCentradoId').val("");
	$('#CmpCotizacionProductoCentradoDescripcion').val("");

	$('#CmpCotizacionProductoCentradoImporte').val("");
	$('#CmpCotizacionProductoCentradoEstado').val("");
	$('#CmpCotizacionProductoCentradoItem').val("");	

			
	$('#CapCotizacionProductoCentradoAccion').html('Listo para registrar elementos');	
			
	$('#CmpCotizacionProductoCentradoDescripcion').focus();
			
	$('#CmpCotizacionProductoCentradoAccion').val("AccCotizacionProductoCentradoRegistrar.php");

}

function FncCotizacionProductoCentradoGuardar(){

	
	var Identificador = $('#Identificador').val();
	
	
			var Acc = $('#CmpCotizacionProductoCentradoAccion').val();		
			
		
			var CotizacionProductoCentradoDescripcion = $('#CmpCotizacionProductoCentradoDescripcion').val();
			var CotizacionProductoCentradoImporte = $('#CmpCotizacionProductoCentradoImporte').val();
			var CotizacionProductoCentradoEstado = $('#CmpCotizacionProductoCentradoEstado').val();

			var Item = $('#CmpCotizacionProductoCentradoItem').val();
			
			if(CotizacionProductoCentradoDescripcion==""){
				$('#CmpCotizacionProductoCentradoDescripcion').select();	
			}else if(CotizacionProductoCentradoImporte=="" || CotizacionProductoCentradoImporte <=0){
				$('#CmpCotizacionProductoCentradoImporte').select();	
			}else{
				$('#CapCotizacionProductoCentradoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/CotizacionProducto/acc/'+Acc,
							data: 'CotizacionProductoCentradoDescripcion='+CotizacionProductoCentradoDescripcion+'&CotizacionProductoCentradoImporte='+CotizacionProductoCentradoImporte+'&CotizacionProductoCentradoEstado='+CotizacionProductoCentradoEstado+'&Identificador='+Identificador+'&Item='+Item,
							success: function(){
								
							$('#CapCotizacionProductoCentradoAccion').html('Listo');							
								FncCotizacionProductoCentradoListar();
							}
						});
						
						FncCotizacionProductoCentradoNuevo();	
					
					
			}
			
			
	
}


function FncCotizacionProductoCentradoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionProductoCentradoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionProducto/FrmCotizacionProductoCentradoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+CotizacionProductoCentradoEditar+'&Eliminar='+CotizacionProductoCentradoEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&IncluyeImpuesto='+IncluyeImpuesto,
		success: function(html){
			$('#CapCotizacionProductoCentradoAccion').html('Listo');	
			$("#CapCotizacionProductoCentrados").html("");
			$("#CapCotizacionProductoCentrados").append(html);
		}
	});

}



function FncCotizacionProductoCentradoEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapCotizacionProductoCentradoAccion').html('Editando...');
	$('#CmpCotizacionProductoCentradoAccion').val("AccCotizacionProductoCentradoEditar.php");


	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoCentradoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsCotizacionProductoCentrado){
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

				$('#CmpCotizacionProductoCentradoId').val(InsCotizacionProductoCentrado.Parametro1);	
				$('#CmpCotizacionProductoCentradoDescripcion').val(InsCotizacionProductoCentrado.Parametro2);
				$('#CmpCotizacionProductoCentradoImporte').val(InsCotizacionProductoCentrado.Parametro5);
				$('#CmpCotizacionProductoCentradoEstado').val(InsCotizacionProductoCentrado.Parametro6);
				
				$('#CmpCotizacionProductoCentradoItem').val(InsCotizacionProductoCentrado.Item);
				
				$('#CmpCotizacionProductoCentradoImporte').select();
				
		}
	});
	
		


}

function FncCotizacionProductoCentradoEliminar(oItem){
	
	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapCotizacionProductoCentradoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoCentradoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapCotizacionProductoCentradoAccion').html("Eliminado");	
				FncCotizacionProductoCentradoListar();
			}
		});

		FncCotizacionProductoCentradoNuevo();

	}
	
}

function FncCotizacionProductoCentradoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapCotizacionProductoCentradoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionProducto/acc/AccCotizacionProductoCentradoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapCotizacionProductoCentradoAccion').html('Eliminado');	
				FncCotizacionProductoCentradoListar();
			}
		});	
			
		FncCotizacionProductoCentradoNuevo();
	}
	
}



