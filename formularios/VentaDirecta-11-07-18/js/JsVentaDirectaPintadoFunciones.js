// JavaScript Document

function FncVentaDirectaPintadoNuevo(){
	
	$('#CmpVentaDirectaPintadoId').val("");
	$('#CmpVentaDirectaPintadoDescripcion').val("");

	$('#CmpVentaDirectaPintadoImporte').val("");
	$('#CmpVentaDirectaPintadoItem').val("");	

			
	$('#CapVentaDirectaPintadoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVentaDirectaPintadoDescripcion').focus();
			
	$('#CmpVentaDirectaPintadoAccion').val("AccVentaDirectaPintadoRegistrar.php");

}

function FncVentaDirectaPintadoGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpVentaDirectaPintadoAccion').val();		
	
			var VentaDirectaPintadoId = $('#CmpVentaDirectaPintadoId').val();
			var VentaDirectaPintadoDescripcion = $('#CmpVentaDirectaPintadoDescripcion').val();
			var VentaDirectaPintadoImporte = $('#CmpVentaDirectaPintadoImporte').val();

			var Item = $('#CmpVentaDirectaPintadoItem').val();
			
			if(VentaDirectaPintadoDescripcion==""){
				$('#CmpVentaDirectaPintadoDescripcion').select();	
			}else if(VentaDirectaPintadoImporte=="" || VentaDirectaPintadoImporte <=0){
				$('#CmpVentaDirectaPintadoImporte').select();	
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/VentaDirecta/acc/'+Acc,
							data: 'Identificador='+Identificador+'&VentaDirectaPintadoId='+VentaDirectaPintadoId+'&VentaDirectaPintadoDescripcion='+VentaDirectaPintadoDescripcion+'&VentaDirectaPintadoImporte='+VentaDirectaPintadoImporte+'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncVentaDirectaPintadoListar();
							}
						});
						

							FncVentaDirectaPintadoNuevo();	
					
					
			}
			
			
	
}


function FncVentaDirectaPintadoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVentaDirectaPintadoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/FrmVentaDirectaPintadoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VentaDirectaPintadoEditar+'&Eliminar='+VentaDirectaPintadoEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVentaDirectaPintadoAccion').html('Listo');	
			$("#CapVentaDirectaPintados").html("");
			$("#CapVentaDirectaPintados").append(html);
		}
	});

}



function FncVentaDirectaPintadoEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVentaDirectaPintadoAccion').html('Editando...');
	$('#CmpVentaDirectaPintadoAccion').val("AccVentaDirectaPintadoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VentaDirecta/acc/AccVentaDirectaPintadoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsVentaDirectaPintado){

			
/*
SesionObjeto-VentaDirectaPintado
Parametro1 = CppId
Parametro2 = 
Parametro3 = CppDescripcion
Parametro4 = 
Parametro5 = CrdImporte
Parametro6 = CrdTiempoCreacion
Parametro7 = CrdTiempoModificacion
*/
				$('#CmpVentaDirectaPintadoId').val(InsVentaDirectaPintado.Parametro1);	
				$('#CmpVentaDirectaPintadoDescripcion').val(InsVentaDirectaPintado.Parametro3);
				$('#CmpVentaDirectaPintadoImporte').val(InsVentaDirectaPintado.Parametro5);
				$('#CmpVentaDirectaPintadoItem').val(InsVentaDirectaPintado.Item);
					$('#CmpVentaDirectaPintadoImporte').select();
		}
	});
	



}

function FncVentaDirectaPintadoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaPintadoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncVentaDirectaPintadoListar();
			}
		});

		FncVentaDirectaPintadoNuevo();

	}
	
}

function FncVentaDirectaPintadoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaPintadoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncVentaDirectaPintadoListar();
			}
		});	
			
		FncVentaDirectaPintadoNuevo();
	}
	
}
