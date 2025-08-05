// JavaScript Document

function FncVentaDirectaTareaNuevo(){
	
	$('#CmpVentaDirectaTareaId').val("");
	$('#CmpVentaDirectaTareaDescripcion').val("");

	$('#CmpVentaDirectaTareaImporte').val("");
	$('#CmpVentaDirectaTareaItem').val("");	

			
	$('#CapVentaDirectaTareaAccion').html('Listo para registrar elementos');	
			
	$('#CmpVentaDirectaTareaDescripcion').focus();
			
	$('#CmpVentaDirectaTareaAccion').val("AccVentaDirectaTareaRegistrar.php");

}

function FncVentaDirectaTareaGuardar(){

			var Identificador = $('#Identificador').val();

			var Acc = $('#CmpVentaDirectaTareaAccion').val();		
	
			var VentaDirectaTareaId = $('#CmpVentaDirectaTareaId').val();
			var VentaDirectaTareaDescripcion = $('#CmpVentaDirectaTareaDescripcion').val();
			var VentaDirectaTareaImporte = $('#CmpVentaDirectaTareaImporte').val();

			var Item = $('#CmpVentaDirectaTareaItem').val();
			
			if(VentaDirectaTareaDescripcion==""){
				$('#CmpVentaDirectaTareaDescripcion').select();	
			}else if(VentaDirectaTareaImporte=="" || VentaDirectaTareaImporte <=0){
				$('#CmpVentaDirectaTareaImporte').select();	
			}else{
				$('#CapVentaDirectaTareaAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/VentaDirecta/acc/'+Acc,
							data: 'Identificador='+Identificador+'&VentaDirectaTareaId='+VentaDirectaTareaId+'&VentaDirectaTareaDescripcion='+VentaDirectaTareaDescripcion+'&VentaDirectaTareaImporte='+VentaDirectaTareaImporte+'&Item='+Item,
							success: function(){
								
							$('#CapVentaDirectaTareaAccion').html('Listo');							
								FncVentaDirectaTareaListar();
							}
						});
						

							FncVentaDirectaTareaNuevo();	
					
					
			}
			
			
	
}


function FncVentaDirectaTareaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVentaDirectaTareaAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/FrmVentaDirectaTareaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VentaDirectaTareaEditar+'&Eliminar='+VentaDirectaTareaEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVentaDirectaTareaAccion').html('Listo');	
			$("#CapVentaDirectaTareas").html("");
			$("#CapVentaDirectaTareas").append(html);
		}
	});

}



function FncVentaDirectaTareaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVentaDirectaTareaAccion').html('Editando...');
	$('#CmpVentaDirectaTareaAccion').val("AccVentaDirectaTareaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VentaDirecta/acc/AccVentaDirectaTareaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsVentaDirectaTarea){

			
/*
SesionObjeto-VentaDirectaTarea
Parametro1 = CppId
Parametro2 = 
Parametro3 = CppDescripcion
Parametro4 = 
Parametro5 = CrdImporte
Parametro6 = CrdTiempoCreacion
Parametro7 = CrdTiempoModificacion
*/
				$('#CmpVentaDirectaTareaId').val(InsVentaDirectaTarea.Parametro1);	
				$('#CmpVentaDirectaTareaDescripcion').val(InsVentaDirectaTarea.Parametro3);
				$('#CmpVentaDirectaTareaImporte').val(InsVentaDirectaTarea.Parametro5);
				$('#CmpVentaDirectaTareaItem').val(InsVentaDirectaTarea.Item);
				$('#CmpVentaDirectaTareaImporte').select();
				
		}
	});
	
		


}

function FncVentaDirectaTareaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVentaDirectaTareaAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaTareaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVentaDirectaTareaAccion').html("Eliminado");	
				FncVentaDirectaTareaListar();
			}
		});

		FncVentaDirectaTareaNuevo();

	}
	
}

function FncVentaDirectaTareaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVentaDirectaTareaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaTareaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVentaDirectaTareaAccion').html('Eliminado');	
				FncVentaDirectaTareaListar();
			}
		});	
			
		FncVentaDirectaTareaNuevo();
	}
	
}

