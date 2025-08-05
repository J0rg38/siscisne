// JavaScript Document

function FncProduccionProductoDetalleSalidaNuevo(){
	
	$('#CmpProductoIdSalida').val("");
	$('#CmpProductoNombreSalida').val("");
	
	$('#CmpProductoCantidadSalida').val("");
	$('#CmpProductoCostoSalida').val("");
	$('#CmpProductoPrecioSalida').val("");
	$('#CmpProductoImporteSalida').val("");
	
	$('#CmpProduccionProductoDetalleSalidaEstado').val("1");	
	
	$('#CmpProductoItemSalida').val("");	
	
	$('#CmpProductoCodigoOriginalSalida').val("");
	$('#CmpProductoCodigoAlternativoSalida').val("");		
			
	$('#CapProductoAccionSalida').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginalSalida').select();
			
	$('#CmpProduccionProductoDetalleSalidaAccion').val("AccProduccionProductoDetalleSalidaRegistrar.php");

	$('#CmpProductoUnidadMedidaSalida').val("");
	$("select#CmpProductoUnidadMedidaConvertirSalida").html('');

	/*$('#CmpProductoIdSalida').removeAttr('readonly');*/
	$('#CmpProductoCodigoOriginalSalida').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativoSalida').removeAttr('readonly');
	
	$('#CmpProductoNombreSalida').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertirSalida').attr('disabled', false);
	
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditarSalida").hide();
	$("#BtnProductoRegistrarSalida").show();
}

function FncProduccionProductoDetalleSalidaGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpProduccionProductoDetalleSalidaAccion').val();		
	
			var ProductoId = $('#CmpProductoIdSalida').val();
			var ProductoNombre = $('#CmpProductoNombreSalida').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertirSalida').val();
			var ProductoCantidad = $('#CmpProductoCantidadSalida').val();
			var ProductoCosto = $('#CmpProductoCostoSalida').val();
			var ProductoPrecio = $('#CmpProductoPrecioSalida').val();
			var ProductoImporte = $('#CmpProductoImporteSalida').val();		
			
			var ProduccionProductoDetalleSalidaEstado = $('#CmpProduccionProductoDetalleSalidaEstado').val();		
			
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedidaSalida').val();
			
			var Item = $('#CmpProductoItemSalida').val();
	
			if(ProductoId == ""){
				alert("No existe el PRODUCTO");
				//FncProductoCargarFormulario("Registrar");
			}else if(ProductoNombre==""){
				$('#CmpProductoNombreSalida').select();	
				
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertirSalida').focus();
					
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#CmpProductoCantidadSalida').select();	
				
			}else{
				$('#CapProductoAccionSalida').html('Guardando...');
				
				$.ajax({
				  type: 'POST',
				  url: 'formularios/ProduccionProducto/acc/'+Acc,
				  data: 'Identificador='+Identificador+
				'&ProductoId='+ProductoId+
				'&ProductoCantidad='+ProductoCantidad+
				
				'&ProductoCosto='+ProductoCosto+
				'&ProductoPrecio='+ProductoPrecio+
				'&ProductoImporte='+ProductoImporte+
				
				'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
				'&ProductoUnidadMedida='+ProductoUnidadMedida+
				'&ProduccionProductoDetalleSalidaEstado='+ProduccionProductoDetalleSalidaEstado+
				'&Item='+Item,
				  success: function(){
					  $('#CapProductoAccionSalida').html('Listo');							
					  FncProduccionProductoDetalleSalidaListar();
				  }
				});
			
				FncProduccionProductoDetalleSalidaNuevo();	
						
		}
			

	
}


function FncProduccionProductoDetalleSalidaListar(){

	var Identificador = $('#Identificador').val();

	var PorcentajeImpuestoVenta  = $('#CmpPorcentajeImpuestoVenta').val();
	
	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var AlmacenId = $('#CmpAlmacen').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$('#CapProductoAccionSalida').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/ProduccionProducto/FrmProduccionProductoDetalleSalidaListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+ProduccionProductoDetalleSalidaEditar+
'&Eliminar='+ProduccionProductoDetalleSalidaEliminar+
'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
'&MonedaId='+MonedaId+
'&TipoCambio='+TipoCambio+
'&AlmacenId='+AlmacenId,
		success: function(html){
			$('#CapProductoAccionSalida').html('Listo');	
			$("#CapProduccionProductoDetalleSalidas").html("");
			$("#CapProduccionProductoDetalleSalidas").append(html);
		}
	});
	
}



function FncProduccionProductoDetalleSalidaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccionSalida').html('Editando...');
	$('#CmpProduccionProductoDetalleSalidaAccion').val("AccProduccionProductoDetalleSalidaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/ProduccionProducto/acc/AccProduccionProductoDetalleSalidaEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsProduccionProductoDetalleSalida){
			
/*
SesionObjeto-ProduccionProductoDetalleSalida
Parametro1 = PpdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = 
Parametro5 = PpdCantidad
Parametro6 = 
Parametro7 = PpdTiempoCreacion
Parametro8 = PpdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = PpdEstado
*/					
				$('#CmpProductoIdSalida').val(InsProduccionProductoDetalleSalida.Parametro2);	
				$('#CmpProductoCodigoOriginalSalida').val(InsProduccionProductoDetalleSalida.Parametro13);	
				$('#CmpProductoCodigoAlternativo').val(InsProduccionProductoDetalleSalida.Parametro14);		
							
				$('#CmpProductoNombreSalida').val(InsProduccionProductoDetalleSalida.Parametro3);						
				$('#CmpProductoUnidadMedidaConvertirSalida').val(InsProduccionProductoDetalleSalida.Parametro10);	
				$('#CmpProduccionProductoDetalleSalidaEstado').val(InsProduccionProductoDetalleSalida.Parametro16);		
				
				$('#CmpProductoCostoSalida').val("0");
				$('#CmpProductoPrecioSalida').val(InsProduccionProductoDetalleSalida.Parametro4);
				$('#CmpProductoCantidadSalida').val(InsProduccionProductoDetalleSalida.Parametro5);
				$('#CmpProductoImporteSalida').val(InsProduccionProductoDetalleSalida.Parametro18);
				
				$('#CmpProductoItemSalida').val(InsProduccionProductoDetalleSalida.Item);
				

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProduccionProductoDetalleSalida.Parametro11+"&Tipo=1&UnidadMedidaId="+InsProduccionProductoDetalleSalida.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsProduccionProductoDetalleSalida.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertirSalida").html(options);
					
				})
				
				$('#CmpProductoUnidadMedidaConvertirSalida').attr('disabled', true);

		}
	});
	
	
	$("#CmpProductoCantidadSalida").select();
	
	$('#CmpProductoIdSalida').attr('readonly', true);
	$('#CmpProductoCodigoOriginalSalida').attr('readonly', true);
	$('#CmpProductoCodigoAlternativoSalida').attr('readonly', true);
	
	$('#CmpProductoNombreSalida').attr('readonly', true);
	$('#CmpProductoUnidadMedidaConvertirSalida').attr('disabled', true);
	


/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditarSalida").show();
	$("#BtnProductoRegistrarSalida").hide();

}

function FncProduccionProductoDetalleSalidaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccionSalida').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/ProduccionProducto/acc/AccProduccionProductoDetalleSalidaEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapProductoAccionSalida').html("Eliminado");	
				FncProduccionProductoDetalleSalidaListar();
			}
		});

		FncProduccionProductoDetalleSalidaNuevo();
	}
	
}

function FncProduccionProductoDetalleSalidaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccionSalida').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/ProduccionProducto/acc/AccProduccionProductoDetalleSalidaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccionSalida').html('Eliminado');	
				FncProduccionProductoDetalleSalidaListar();
			}
		});	
			
		FncProduccionProductoDetalleSalidaNuevo();
	}
	
}


/*
$().ready(function() {

	
	$("#CmpProductoCodigoOriginalSalida").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoOriginal");
		 }
	});
	
});
*/