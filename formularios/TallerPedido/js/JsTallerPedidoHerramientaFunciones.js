// JavaScript Document

//
//function FncHerramientaFormato(row) {			
//	return "<td>"+row[1]+"</td>";
//}
//
//function FncHerramientaEscoger(oProId,oProNombre,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso){	
//
//	$('#CmpHerramientaId').val(oProId);
//	$('#CmpHerramientaCantidad').val("");
//	$('#CmpHerramientaNombre').val(oProNombre);
//	$('#CmpHerramientaTipo').val(oRtiId);
//	$('#CmpHerramientaUnidadMedida').val(oUmeId);
//	$('#CmpHerramientaUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
//	$('#CmpHerramientaCodigoOriginal').val(oProCodigoOriginal);
//	$('#CmpHerramientaCodigoAlternativo').val(oProCodigoAlternativo);
//	
//	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo=2",{}, function(j){
//		var options = '';
//
//		options += '<option value="">Escoja una opcion</option>';
//		for (var i = 0; i < j.length; i++) {
//			if(oUnidadMedidaIngreso == j[i].UmeId){
//				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
//			}else{
//				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
//			}
//		}
//		$('select#CmpHerramientaUnidadMedidaConvertir').html(options);
//	})
//
//	$('select#CmpHerramientaUnidadMedidaConvertir').change(function(){
//		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
//		function(j){
//			//$('#CmpHerramientaUnidadMedidaEquivalente').val(j[0].UmcEquivalente);
//			$('#CmpHerramientaUnidadMedidaEquivalente').val(j.UmcEquivalente);
//		})
//	});
//	
//	FncHerramientaFuncion();
//
//	try{
//		tb_remove();
//	}catch(e){
//		
//	}
//}
//
//function FncHerramientaFuncion(){
//	
//}
//
//function FncHerramientaBuscar(oCampo){
//	
//	var Dato = $('#CmpHerramienta'+oCampo).val()
//	
//	if(Dato!=""){
//		
//		$.ajax({
//			type: 'POST',
//			dataType: 'json',
//			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
//			data: 'Campo='+oCampo+'&Dato='+Dato,
//			success: function(InsProducto){
//										
//				if(InsProducto.ProId!="" & InsProducto.ProId!=null){
//					FncHerramientaEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso);
//				}else{
//					$('#CmpHerramienta'+oCampo).focus();
//					$('#CmpHerramienta'+oCampo).select();						
//				}
//				
//			}
//		});
//
//	}
//
//}
//
//$().ready(function() {
//	
//	var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
//	var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
//	var VersionId = $("#CmpVehiculoIngresoVersionId").val();
//	var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();
//	
//	var Sigla = $(this).attr('sigla');
////			$("#CmpHerramientaNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
//	$("#CmpHerramientaNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&ProductoTipoId=RTI-10005', {
//		width: 900,
//		max: 100,
//		formatItem: FncHerramientaFormato,
//		minChars: 2,
//		delay: 1000,
//		cacheLength: 50,
//		scroll: true,
//		scrollHeight: 200
//	});	
//
//	$("#CmpHerramientaNombre").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpHerramientaId").val(data[0]);				
//			FncHerramientaBuscar("Id");	
//		}		
//	});	
//
//});



/******************************************************************************/

function FncTallerPedidoHerramientaNuevo(){
	
	$('#CmpHerramientaId').val("");
	$('#CmpHerramientaNombre').val("");
	$('#CmpHerramientaItem').val("");	
			
	$('#CmpHerramientaUnidadMedida').val("");
	$('select#CmpHerramientaUnidadMedidaConvertir').html('');
	$('#CmpHerramientaUnidadMedidaEquivalente').val("");	
	
	$('#CmpHerramientaCantidad').val("")

	$('#CapHerramientaAccion').html('Listo para registrar elementos');				
	$('#CmpHerramientaNombre').focus();			
	$('#CmpTallerPedidoHerramientaAccion').val("AccTallerPedidoHerramientaRegistrar.php");
	
	$('#CmpHerramientaNombre').removeAttr('readonly');

}

function FncTallerPedidoHerramientaGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpTallerPedidoHerramientaAccion').val();		
	
	var HerramientaId = $('#CmpHerramientaId').val();
	var HerramientaNombre = $('#CmpHerramientaNombre').val();
	var Item = $('#CmpHerramientaItem').val();
	
	var HerramientaUnidadMedidaConvertir = $('#CmpHerramientaUnidadMedidaConvertir').val();
	var HerramientaCantidad = $('#CmpHerramientaCantidad').val();
	var HerramientaUnidadMedida = $('#CmpHerramientaUnidadMedida').val();
	
	if(HerramientaNombre==""){
		$('#CmpHerramientaNombre').select();	
	}else if(HerramientaUnidadMedidaConvertir==""){
		$('#CmpHerramientaUnidadMedidaConvertir').focus();	
	}else if(HerramientaCantidad=="" || HerramientaCantidad <=0){
		$('#CmpHerramientaCantidad').select();	
	}else{
		$('#CapHerramientaAccion').html('Guardando...');

		$.ajax({
		  type: 'POST',
		  url: 'formularios/TallerPedido/acc/'+Acc,
		  data: 'Identificador='+Identificador+'&HerramientaNombre='+HerramientaNombre+'&HerramientaId='+HerramientaId+'&HerramientaUnidadMedidaConvertir='+HerramientaUnidadMedidaConvertir+'&HerramientaCantidad='+HerramientaCantidad+'&HerramientaUnidadMedida='+HerramientaUnidadMedida+'&Item='+Item,
		  success: function(){
			  
		  $('#CapHerramientaAccion').html('Listo');							
			  FncTallerPedidoHerramientaListar();
		  }
		});
			
		FncTallerPedidoHerramientaNuevo();	
	
	}

}


function FncTallerPedidoHerramientaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapHerramientaAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoHerramientaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+TallerPedidoHerramientaEditar+'&Eliminar='+TallerPedidoHerramientaEliminar,
		success: function(html){
			$('#CapHerramientaAccion').html('Listo');	

			$("#CapTallerPedidoHerramientas").html("");
			$("#CapTallerPedidoHerramientas").append(html);
		}
	});

}


function FncTallerPedidoHerramientaListar2(){

	var Identificador = $('#Identificador').val();

	$('#CapHerramientaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoHerramientaListado2.php',
		data: 'Identificador='+Identificador+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#CapHerramientaAccion').html('Listo');	
			$("#CapTallerPedidoHerramientas2").html("");
			$("#CapTallerPedidoHerramientas2").append(html);
		}
	});
	
}


function FncTallerPedidoHerramientaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapHerramientaAccion').html('Editando...');
	$('#CmpTallerPedidoHerramientaAccion').val("AccTallerPedidoHerramientaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TallerPedido/acc/AccTallerPedidoHerramientaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsTallerPedidoHerramienta){
	
//SesionObjeto-TallerPedidoHerramienta
//Parametro1 = FihId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = 
//Parametro5 = 
//Parametro6 = UmeId
//Parametro7 = FihTiempoCreacion
//Parametro8 = FihTiempoModificacion
//Parametro9 = FihCantidad
//Parametro10 = FihCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
	
			$('#CmpHerramientaId').val(InsTallerPedidoHerramienta.Parametro2);
			$('#CmpHerramientaNombre').val(InsTallerPedidoHerramienta.Parametro3);
			$('#CmpHerramientaItem').val(InsTallerPedidoHerramienta.Item);
			$('#CmpHerramientaUnidadMedidaEquivalente').val(1);
			$('#CmpHerramientaCantidad').val(InsTallerPedidoHerramienta.Parametro9);
			
			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsTallerPedidoHerramienta.Parametro11+"&Tipo=1&UnidadMedidaId="+InsTallerPedidoHerramienta.Parametro13,{}, function(j){
				var options = '';
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(j[i].UmeId == InsTallerPedidoHerramienta.Parametro6){
						options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}else{
						options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}
				}
				$('select#CmpHerramientaUnidadMedidaConvertir').html(options);
			})
			
			$('#CmpHerramientaUnidadMedidaConvertir').attr('disabled', true);
				
				
}
	});
	

	$('#CmpHerramientaCantidad').select();

	$('#CmpHerramientaNombre').attr('readonly', true);
	
}

function FncTallerPedidoHerramientaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapHerramientaAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoHerramientaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapHerramientaAccion').html("Eliminado");	
				FncTallerPedidoHerramientaListar();
			}
		});

		FncTallerPedidoHerramientaNuevo();

	}
	
}



function FncTallerPedidoHerramientaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapHerramientaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoHerramientaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapHerramientaAccion').html('Eliminado');	
				FncTallerPedidoHerramientaListar();
			}
		});	
			
		FncTallerPedidoHerramientaNuevo();
	}
	
}
