// JavaScript Document

function FncPedidoCompraLlegadaDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");
	$('#CmpProductoCantidad').val("");
	
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoCodigoAlternativo').val("");

	
	$('#CmpProductoItem').val("");	
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpPedidoCompraLlegadaDetalleAccion').val("AccPedidoCompraLlegadaDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");

	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	
	FncProductoNuevo();
}

function FncPedidoCompraLlegadaDetalleGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpPedidoCompraLlegadaDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();

			var Item = $('#CmpProductoItem').val();

			if(ProductoId==""){
				alert("No existe el PRODUCTO");
				FncProductoCargarFormulario("Registrar");
			}else if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertir').focus();	
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#CmpProductoCantidad').select();	
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/PedidoCompraLlegada/acc/'+Acc,
							data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&ProductoCantidad='+ProductoCantidad+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncPedidoCompraLlegadaDetalleListar();
							}
						});
						
					FncPedidoCompraLlegadaDetalleNuevo();	
					
			}
	
}


function FncPedidoCompraLlegadaDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Cargando...');
	
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	
	var TotalRecargo = $('#CmpTotalRecargo').val();
	
	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/PedidoCompraLlegada/FrmPedidoCompraLlegadaDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+PedidoCompraLlegadaDetalleEditar+'&Eliminar='+PedidoCompraLlegadaDetalleEliminar+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio+'&TotalRecargo='+TotalRecargo,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapPedidoCompraLlegadaDetalles").html("");
			$("#CapPedidoCompraLlegadaDetalles").append(html);
			
			
		}
	});
	
}



function FncPedidoCompraLlegadaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpPedidoCompraLlegadaDetalleAccion').val("AccPedidoCompraLlegadaDetalleEditar.php");

//SesionObjeto-PedidoCompraLlegadaDetalle
//Parametro1 = 
//Parametro2 = PcdId
//Parametro3 = PldCantidad
//Parametro4 = PldEstado
//Parametro5 = PldTiempoCreacion
//Parametro6 = PldTiempoModificacion
//Parametro7 = ProId
//Parametro8 = UmeId
//Parametro9 = PcdCantidad
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = UmeIdOrigen
//Parametro14 = UmeNombre
//Parametro15 = VdiId

//Parametro16 = VdiOrdenCompraNumero
//Parametro17 = CliNumeroDocumento
//Parametro18 = CliNombre
//Parametro19 = CliApellidoPaterno
//Parametro20 = CliApellidoMaterno

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PedidoCompraLlegada/acc/AccPedidoCompraLlegadaDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsPedidoCompraLlegadaDetalle){
				$('#CmpProductoId').val(InsPedidoCompraLlegadaDetalle.Parametro7);	
				$('#CmpProductoNombre').val(InsPedidoCompraLlegadaDetalle.Parametro10);		
				$('#CmpProductoCantidad').val(InsPedidoCompraLlegadaDetalle.Parametro3);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoCodigoOriginal').val(InsPedidoCompraLlegadaDetalle.Parametro11);
				$('#CmpProductoCodigoAlternativo').val(InsPedidoCompraLlegadaDetalle.Parametro12);
				$('#CmpProductoUnidadMedida').val(InsPedidoCompraLlegadaDetalle.Parametro8);

				$('#CmpProductoItem').val(InsPedidoCompraLlegadaDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsPedidoCompraLlegadaDetalle.Parametro21+"&Tipo=1&UnidadMedidaId="+InsPedidoCompraLlegadaDetalle.Parametro8,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsPedidoCompraLlegadaDetalle.Parametro8){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
				})
				
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+$("#CmpProductoUnidadMedida").val()+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
					$("#CmpProductoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
					//$('#CmpProductoCosto').val($('#CmpProductoCosto').val() * j[0].UmcEquivalente);
					//$('#CmpProductoImporte').val($('#CmpProductoCosto').val() * $('#CmpProductoCantidad').val());
				})
			});
			
	
			$('#CmpProductoCantidad').select();
		}
	});
	
	$('#CmpProductoId').attr('readonly', true);
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);

}

function FncPedidoCompraLlegadaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PedidoCompraLlegada/acc/AccPedidoCompraLlegadaDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncPedidoCompraLlegadaDetalleListar();
			}
		});
		
		FncPedidoCompraLlegadaDetalleNuevo();

	}
	
}



function FncPedidoCompraLlegadaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PedidoCompraLlegada/acc/AccPedidoCompraLlegadaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncPedidoCompraLlegadaDetalleListar();
			}
		});	
			
		FncPedidoCompraLlegadaDetalleNuevo();
	}
	
}




