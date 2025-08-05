// JavaScript Document

function FncVentaDirectaPlanchadoNuevo(){
	
	$('#CmpVentaDirectaPlanchadoId').val("");
	$('#CmpVentaDirectaPlanchadoDescripcion').val("");

	$('#CmpVentaDirectaPlanchadoImporte').val("");
	$('#CmpVentaDirectaPlanchadoItem').val("");	

			
	$('#CapVentaDirectaPlanchadoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVentaDirectaPlanchadoDescripcion').focus();
			
	$('#CmpVentaDirectaPlanchadoAccion').val("AccVentaDirectaPlanchadoRegistrar.php");

}

function FncVentaDirectaPlanchadoGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpVentaDirectaPlanchadoAccion').val();		
	
			var VentaDirectaPlanchadoId = $('#CmpVentaDirectaPlanchadoId').val();
			var VentaDirectaPlanchadoDescripcion = $('#CmpVentaDirectaPlanchadoDescripcion').val();
			var VentaDirectaPlanchadoImporte = $('#CmpVentaDirectaPlanchadoImporte').val();

			var Item = $('#CmpVentaDirectaPlanchadoItem').val();
			
			if(VentaDirectaPlanchadoDescripcion==""){
				$('#CmpVentaDirectaPlanchadoDescripcion').select();	
			}else if(VentaDirectaPlanchadoImporte=="" || VentaDirectaPlanchadoImporte <=0){
				$('#CmpVentaDirectaPlanchadoImporte').select();	
			}else{
				$('#CapVentaDirectaPlanchadoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/VentaDirecta/acc/'+Acc,
							data: 'Identificador='+Identificador+'&VentaDirectaPlanchadoId='+VentaDirectaPlanchadoId+'&VentaDirectaPlanchadoDescripcion='+VentaDirectaPlanchadoDescripcion+'&VentaDirectaPlanchadoImporte='+VentaDirectaPlanchadoImporte+'&Item='+Item,
							success: function(){
								
							$('#CapVentaDirectaPlanchadoAccion').html('Listo');							
								FncVentaDirectaPlanchadoListar();
							}
						});
						

							FncVentaDirectaPlanchadoNuevo();	
					
					
			}
			
			
	
}


function FncVentaDirectaPlanchadoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVentaDirectaPlanchadoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/FrmVentaDirectaPlanchadoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VentaDirectaPlanchadoEditar+'&Eliminar='+VentaDirectaPlanchadoEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVentaDirectaPlanchadoAccion').html('Listo');	
			$("#CapVentaDirectaPlanchados").html("");
			$("#CapVentaDirectaPlanchados").append(html);
		}
	});

}



function FncVentaDirectaPlanchadoEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVentaDirectaPlanchadoAccion').html('Editando...');
	$('#CmpVentaDirectaPlanchadoAccion').val("AccVentaDirectaPlanchadoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VentaDirecta/acc/AccVentaDirectaPlanchadoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsVentaDirectaPlanchado){

			
/*
SesionObjeto-VentaDirectaPlanchado
Parametro1 = CppId
Parametro2 = 
Parametro3 = CppDescripcion
Parametro4 = 
Parametro5 = CrdImporte
Parametro6 = CrdTiempoCreacion
Parametro7 = CrdTiempoModificacion
*/
				$('#CmpVentaDirectaPlanchadoId').val(InsVentaDirectaPlanchado.Parametro1);	
				$('#CmpVentaDirectaPlanchadoDescripcion').val(InsVentaDirectaPlanchado.Parametro3);
				$('#CmpVentaDirectaPlanchadoImporte').val(InsVentaDirectaPlanchado.Parametro5);
				$('#CmpVentaDirectaPlanchadoItem').val(InsVentaDirectaPlanchado.Item);
				$('#CmpVentaDirectaPlanchadoImporte').select();
				
		}
	});
	
		


}

function FncVentaDirectaPlanchadoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVentaDirectaPlanchadoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaPlanchadoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVentaDirectaPlanchadoAccion').html("Eliminado");	
				FncVentaDirectaPlanchadoListar();
			}
		});

		FncVentaDirectaPlanchadoNuevo();

	}
	
}

function FncVentaDirectaPlanchadoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVentaDirectaPlanchadoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaPlanchadoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVentaDirectaPlanchadoAccion').html('Eliminado');	
				FncVentaDirectaPlanchadoListar();
			}
		});	
			
		FncVentaDirectaPlanchadoNuevo();
	}
	
}



