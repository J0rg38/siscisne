// JavaScript Document

function FncDesembolsoComprobanteNuevo(){
	
//	$('#CmpDesembolsoComprobanteId').val("");
//	$('#CmpDesembolsoComprobanteDescripcion').val("");
//
//	$('#CmpDesembolsoComprobanteImporte').val("");
//	$('#CmpDesembolsoComprobanteItem').val("");	
//
//			
//	$('#CapDesembolsoComprobanteAccion').html('Listo para registrar elementos');	
//			
//	$('#CmpDesembolsoComprobanteDescripcion').focus();
//			
//	$('#CmpDesembolsoComprobanteAccion').val("AccDesembolsoComprobanteRegistrar.php");

}

function FncDesembolsoComprobanteGuardar(){

		//var Identificador = $('#Identificador').val();
//
//		var Acc = $('#CmpDesembolsoComprobanteAccion').val();		
//	
//			var DesembolsoComprobanteId = $('#CmpDesembolsoComprobanteId').val();
//			var DesembolsoComprobanteDescripcion = $('#CmpDesembolsoComprobanteDescripcion').val();
//			var DesembolsoComprobanteImporte = $('#CmpDesembolsoComprobanteImporte').val();
//
//			var Item = $('#CmpDesembolsoComprobanteItem').val();
//			
//			if(DesembolsoComprobanteDescripcion==""){
//				$('#CmpDesembolsoComprobanteDescripcion').select();	
//			}else if(DesembolsoComprobanteImporte=="" || DesembolsoComprobanteImporte <=0){
//				$('#CmpDesembolsoComprobanteImporte').select();	
//			}else{
//				$('#CapProductoAccion').html('Guardando...');
//				
//						$.ajax({
//							type: 'POST',
//							url: 'formularios/VentaDirecta/acc/'+Acc,
//							data: 'Identificador='+Identificador+'&DesembolsoComprobanteId='+DesembolsoComprobanteId+'&DesembolsoComprobanteDescripcion='+DesembolsoComprobanteDescripcion+'&DesembolsoComprobanteImporte='+DesembolsoComprobanteImporte+'&Item='+Item,
//							success: function(){
//								
//							$('#CapProductoAccion').html('Listo');							
//								FncDesembolsoComprobanteListar();
//							}
//						});
//						
//
//							FncDesembolsoComprobanteNuevo();	
//					
//					
//			}
			
			
	
}


function FncDesembolsoComprobanteListar(oRuta){

	var Identificador = $('#Identificador').val();

	$('#CapDesembolsoComprobanteAccion'+oRuta).html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var ProveedorId = $('#CmpProveedorId'+oRuta).val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Desembolso/FrmDesembolsoComprobanteListado.php',
		data: 'Identificador='+Identificador+'&Editar='+DesembolsoComprobanteEditar+'&Eliminar='+DesembolsoComprobanteEliminar+'&MonedaId='+MonedaId+'&ProveedorId='+ProveedorId,
		success: function(html){
			$('#CapDesembolsoComprobanteAccion'+oRuta).html('Listo');	
			$("#CapDesembolsoComprobantes"+oRuta).html("");
			$("#CapDesembolsoComprobantes"+oRuta).append(html);
		}
	});

}



function FncDesembolsoComprobanteEscoger(oItem){
	//	
//	var Identificador = $('#Identificador').val();
//	
//	$('#CapDesembolsoComprobanteAccion').html('Editando...');
//	$('#CmpDesembolsoComprobanteAccion').val("AccDesembolsoComprobanteEditar.php");
//	
//	$.ajax({
//		type: 'POST',
//		dataType: 'json',
//		url: 'formularios/VentaDirecta/acc/AccDesembolsoComprobanteEscoger.php',
//		data: 'Identificador='+Identificador+'&Item='+oItem,
//		success: function(InsDesembolsoComprobante){
//
//			
///*
//SesionObjeto-DesembolsoComprobante
//Parametro1 = CppId
//Parametro2 = 
//Parametro3 = CppDescripcion
//Parametro4 = 
//Parametro5 = CrdImporte
//Parametro6 = CrdTiempoCreacion
//Parametro7 = CrdTiempoModificacion
//*/
//				$('#CmpDesembolsoComprobanteId').val(InsDesembolsoComprobante.Parametro1);	
//				$('#CmpDesembolsoComprobanteDescripcion').val(InsDesembolsoComprobante.Parametro3);
//				$('#CmpDesembolsoComprobanteImporte').val(InsDesembolsoComprobante.Parametro5);
//				$('#CmpDesembolsoComprobanteItem').val(InsDesembolsoComprobante.Item);
//					$('#CmpDesembolsoComprobanteImporte').select();
//		}
//	});
//	



}

function FncDesembolsoComprobanteEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Desembolso/acc/AccDesembolsoComprobanteEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncDesembolsoComprobanteListar();
			}
		});

		FncDesembolsoComprobanteNuevo();

	}
	
}

function FncDesembolsoComprobanteEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Desembolso/acc/AccDesembolsoComprobanteEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncDesembolsoComprobanteListar();
			}
		});	
			
		FncDesembolsoComprobanteNuevo();
	}
	
}
