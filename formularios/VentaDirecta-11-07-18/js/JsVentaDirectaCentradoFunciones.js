// JavaScript Document

function FncVentaDirectaCentradoNuevo(){
	
	$('#CmpVentaDirectaCentradoId').val("");
	$('#CmpVentaDirectaCentradoDescripcion').val("");

	$('#CmpVentaDirectaCentradoImporte').val("");
	$('#CmpVentaDirectaCentradoItem').val("");	

			
	$('#CapVentaDirectaCentradoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVentaDirectaCentradoDescripcion').focus();
			
	$('#CmpVentaDirectaCentradoAccion').val("AccVentaDirectaCentradoRegistrar.php");

}

function FncVentaDirectaCentradoGuardar(){

			var Identificador = $('#Identificador').val();

			var Acc = $('#CmpVentaDirectaCentradoAccion').val();		
	
			var VentaDirectaCentradoId = $('#CmpVentaDirectaCentradoId').val();
			var VentaDirectaCentradoDescripcion = $('#CmpVentaDirectaCentradoDescripcion').val();
			var VentaDirectaCentradoImporte = $('#CmpVentaDirectaCentradoImporte').val();

			var Item = $('#CmpVentaDirectaCentradoItem').val();
			
			if(VentaDirectaCentradoDescripcion==""){
				$('#CmpVentaDirectaCentradoDescripcion').select();	
			}else if(VentaDirectaCentradoImporte=="" || VentaDirectaCentradoImporte <=0){
				$('#CmpVentaDirectaCentradoImporte').select();	
			}else{
				$('#CapVentaDirectaCentradoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/VentaDirecta/acc/'+Acc,
							data: 'Identificador='+Identificador+'&VentaDirectaCentradoId='+VentaDirectaCentradoId+'&VentaDirectaCentradoDescripcion='+VentaDirectaCentradoDescripcion+'&VentaDirectaCentradoImporte='+VentaDirectaCentradoImporte+'&Item='+Item,
							success: function(){
								
							$('#CapVentaDirectaCentradoAccion').html('Listo');							
								FncVentaDirectaCentradoListar();
							}
						});
						

							FncVentaDirectaCentradoNuevo();	
					
					
			}
			
			
	
}


function FncVentaDirectaCentradoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVentaDirectaCentradoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/FrmVentaDirectaCentradoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VentaDirectaCentradoEditar+'&Eliminar='+VentaDirectaCentradoEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVentaDirectaCentradoAccion').html('Listo');	
			$("#CapVentaDirectaCentrados").html("");
			$("#CapVentaDirectaCentrados").append(html);
		}
	});

}



function FncVentaDirectaCentradoEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVentaDirectaCentradoAccion').html('Editando...');
	$('#CmpVentaDirectaCentradoAccion').val("AccVentaDirectaCentradoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VentaDirecta/acc/AccVentaDirectaCentradoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsVentaDirectaCentrado){

			
/*
SesionObjeto-VentaDirectaCentrado
Parametro1 = CppId
Parametro2 = 
Parametro3 = CppDescripcion
Parametro4 = 
Parametro5 = CrdImporte
Parametro6 = CrdTiempoCreacion
Parametro7 = CrdTiempoModificacion
*/
				$('#CmpVentaDirectaCentradoId').val(InsVentaDirectaCentrado.Parametro1);	
				$('#CmpVentaDirectaCentradoDescripcion').val(InsVentaDirectaCentrado.Parametro3);
				$('#CmpVentaDirectaCentradoImporte').val(InsVentaDirectaCentrado.Parametro5);
				$('#CmpVentaDirectaCentradoItem').val(InsVentaDirectaCentrado.Item);
				$('#CmpVentaDirectaCentradoImporte').select();
				
		}
	});
	
		


}

function FncVentaDirectaCentradoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVentaDirectaCentradoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaCentradoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVentaDirectaCentradoAccion').html("Eliminado");	
				FncVentaDirectaCentradoListar();
			}
		});

		FncVentaDirectaCentradoNuevo();

	}
	
}

function FncVentaDirectaCentradoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVentaDirectaCentradoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaCentradoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVentaDirectaCentradoAccion').html('Eliminado');	
				FncVentaDirectaCentradoListar();
			}
		});	
			
		FncVentaDirectaCentradoNuevo();
	}
	
}





