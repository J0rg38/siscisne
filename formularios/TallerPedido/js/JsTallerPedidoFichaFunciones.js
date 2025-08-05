// JavaScript Document

//

function FncTallerPedidoFichaNuevo(oModalidadIngreso){
	
	
}

function FncTallerPedidoFichaGuardar(oModalidadIngreso){

}

function FncTallerPedidoFichaEstadoGuardar(oModalidadIngreso,oItem){

}

function FncTallerPedidoFichaListar(oModalidadIngreso){

//alert("test//;

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TallerPedidoFichaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoFichaListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TallerPedidoFichaEditar+'&Eliminar='+TallerPedidoFichaEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'FichaAccion').html('Listo');	
			$("#CapTallerPedido"+oModalidadIngreso+"Fichas").html("");
			$("#CapTallerPedido"+oModalidadIngreso+"Fichas").append(html);
			
		}
	});
	
	


}




function FncTallerPedidoFichaEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Editando...');
	
	//$('#CmpTallerPedido'+oModalidadIngreso+'ProductoAccion').val("AccTallerPedidoFichaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TallerPedido/acc/AccTallerPedidoFichaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsTallerPedidoFicha){

			FncCargarVentanaNuevo('principal2.php?Mod=AlmacenMovimientoSalida&Form=Editar&Dia=1&Id='+InsTallerPedidoFicha.Parametro1);
			
		//	tb_show('','principal2.php?Mod=AlmacenMovimientoSalida&Form=Editar&Dia=1&Id='+InsTallerPedidoFicha.AmoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true','');	
		
		}
	});
	

	
}

function FncTallerPedidoFichaEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'TallerPedidoFichaAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoFichaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TallerPedidoFichaAccion').html("Eliminado");	
				FncTallerPedidoFichaListar(oModalidadIngreso);
			}
		});

		FncTallerPedidoFichaNuevo(oModalidadIngreso);

	}
	
}



function FncTallerPedidoFichaEliminarTodo(oModalidadIngreso){

//	var Identificador = $('#Identificador').val();
//	
//	if(confirm("¿Realmente desea eliminar todos los elementos?")){
//		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
//	
//		$.ajax({
//			type: 'POST',
//			url: 'formularios/TallerPedido/acc/AccTallerPedidoFichaEliminarTodo.php',
//			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
//			success: function(){
//				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminado');	
//				FncTallerPedidoFichaListar(oModalidadIngreso);
//			}
//		});	
//			
//		FncTallerPedidoFichaNuevo(oModalidadIngreso);
//	}
	
}












	