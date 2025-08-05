// JavaScript Document

function FncProduccionProductoDetalleEntradaNuevo(){
	
	$('#CmpProductoIdEntrada').val("");
	
	$('#CmpProductoNombreEntrada').val("");
	$('#CmpProductoCantidadEntrada').val("");	

	$('#CmpProductoCostoEntrada').val("");
	$('#CmpProductoPrecioEntrada').val("");
	$('#CmpProductoImporteEntrada').val("");
	
	
	$('#CmpProduccionProductoDetalleEstadoEntrada').val("1");	
	$('#CmpProductoItemEntrada').val("");	
	$('#CmpProductoCodigoOriginalEntrada').val("");		
	$('#CmpProductoCodigoAlternativoEntrada').val("");
	
	$('#CapProductoAccionEntrada').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginalEntrada').select();
			
	$('#CmpProduccionProductoDetalleEntradaAccionEntrada').val("AccProduccionProductoDetalleEntradaRegistrar.php");

	$('#CmpProductoUnidadMedidaEntrada').val("");
	$("select#CmpProductoUnidadMedidaConvertirEntrada").html('');

	$('#CmpProductoIdEntrada').removeAttr('readonly');
	$('#CmpProductoCodigoOriginalEntrada').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativoEntrada').removeAttr('readonly');
	
	$('#CmpProductoNombreEntrada').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertirEntrada').attr('disabled', false);
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditarEntrada").hide();
	$("#BtnProductoRegistrarEntrada").show();
}

function FncProduccionProductoDetalleEntradaGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpProduccionProductoDetalleEntradaAccion').val();		
	
	var ProductoId = $('#CmpProductoIdEntrada').val();
	var ProductoNombre = $('#CmpProductoNombreEntrada').val();
	var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertirEntrada').val();
	var ProductoUnidadMedida = $('#CmpProductoUnidadMedidaEntrada').val();

	var ProductoCantidad = $('#CmpProductoCantidadEntrada').val();
	var ProductoCosto = $('#CmpProductoCostoEntrada').val();
	var ProductoPrecio = $('#CmpProductoPrecioEntrada').val();
	var ProductoImporte = $('#CmpProductoImporteEntrada').val();
	
	var ProduccionProductoDetalleEntradaEstado = $('#CmpProduccionProductoDetalleEntradaEstado').val();		
	
	var Item = $('#CmpProductoItemEntrada').val();
	
	if(ProductoId == ""){
		alert("No existe el PRODUCTO");
	//				FncProductoCargarFormulario("Registrar");
	}else if(ProductoNombre==""){
		$('#CmpProductoNombreEntrada').select();	
		
	}else if(ProductoUnidadMedidaConvertir==""){
		$('#CmpProductoUnidadMedidaConvertirEntrada').focus();	
		
	}else if(ProductoCantidad=="" || ProductoCantidad <=0){
		$('#CmpProductoCantidadEntrada').select();	
		
	}else{
		$('#CapProductoAccionEntrada').html('Guardando...');
		
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
		'&ProduccionProductoDetalleEntradaEstado='+ProduccionProductoDetalleEntradaEstado+
		'&Item='+Item,
		  success: function(){
			  $('#CapProductoAccionEntrada').html('Listo');							
			  FncProduccionProductoDetalleEntradaListar();
		  }
		});
			
		FncProduccionProductoDetalleEntradaNuevo();	
				
	}
		
}


function FncProduccionProductoDetalleEntradaListar(){

	var Identificador = $('#Identificador').val();

	var PorcentajeImpuestoVenta  = $('#CmpPorcentajeImpuestoVenta').val();
	var AlmacenId  = $('#CmpAlmacen').val();

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}
	
	$('#CapProductoAccionEntrada').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/ProduccionProducto/FrmProduccionProductoDetalleEntradaListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+ProduccionProductoDetalleEntradaEditar+
'&Eliminar='+ProduccionProductoDetalleEntradaEliminar+
'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
'&MonedaId='+MonedaId+
'&AlmacenId='+AlmacenId+
'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapProductoAccionEntrada').html('Listo');	
			$("#CapProduccionProductoDetalleEntradas").html("");
			$("#CapProduccionProductoDetalleEntradas").append(html);
		}
	});
	
}



function FncProduccionProductoDetalleEntradaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccionEntrada').html('Editando...');
	$('#CmpProduccionProductoDetalleEntradaAccion').val("AccProduccionProductoDetalleEntradaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/ProduccionProducto/acc/AccProduccionProductoDetalleEntradaEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsProduccionProductoDetalleEntrada){
			
/*
SesionObjeto-ProduccionProductoDetalleEntrada
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
				$('#CmpProductoIdEntrada').val(InsProduccionProductoDetalleEntrada.Parametro2);	
				$('#CmpProductoCodigoOriginalEntrada').val(InsProduccionProductoDetalleEntrada.Parametro13);				
				$('#CmpProductoCodigoAlternativoEntrada').val(InsProduccionProductoDetalleEntrada.Parametro14);	
								
				$('#CmpProductoNombreEntrada').val(InsProduccionProductoDetalleEntrada.Parametro3);						
				$('#CmpProductoUnidadMedidaConvertirEntrada').val(InsProduccionProductoDetalleEntrada.Parametro10);	
				$('#CmpProduccionProductoDetalleEntradaEstado').val(InsProduccionProductoDetalleEntrada.Parametro16);		
				
				$('#CmpProductoCostoEntrada').val(InsProduccionProductoDetalleEntrada.Parametro4);
				$('#CmpProductoCostoPrecio').val("");
				$('#CmpProductoCantidadEntrada').val(InsProduccionProductoDetalleEntrada.Parametro5);
				$('#CmpProductoImporteEntrada').val(InsProduccionProductoDetalleEntrada.Parametro18);
				
				
				$('#CmpProductoItemEntrada').val(InsProduccionProductoDetalleEntrada.Item);
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProduccionProductoDetalleEntrada.Parametro11+"&Tipo=1&UnidadMedidaId="+InsProduccionProductoDetalleEntrada.Parametro15,{}, function(j){

					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsProduccionProductoDetalleEntrada.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertirEntrada").html(options);

				})

				$('#CmpProductoUnidadMedidaConvertirEntrada').attr('disabled', true);

		}
	});
	
	$("#CmpProductoCantidadEntrada").select();
	
	$('#CmpProductoIdEntrada').attr('readonly', true);
	$('#CmpProductoCodigoOriginalEntrada').attr('readonly', true);
	$('#CmpProductoCodigoAlternativoEntrada').attr('readonly', true);
	
	$('#CmpProductoNombreEntrada').attr('readonly', true);
	$('#CmpProductoUnidadMedidaConvertirEntrada').attr('disabled', true);
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditarEntrada").show();
	$("#BtnProductoRegistrarEntrada").hide();

}

function FncProduccionProductoDetalleEntradaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccionEntrada').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/ProduccionProducto/acc/AccProduccionProductoDetalleEntradaEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapProductoAccionEntrada').html("Eliminado");	
				FncProduccionProductoDetalleEntradaListar();
			}
		});

		FncProduccionProductoDetalleEntradaNuevo();
	}
	
}

function FncProduccionProductoDetalleEntradaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccionEntrada').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/ProduccionProducto/acc/AccProduccionProductoDetalleEntradaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccionEntrada').html('Eliminado');	
				FncProduccionProductoDetalleEntradaListar();
			}
		});	
			
		FncProduccionProductoDetalleEntradaNuevo();
	}
	
}

/*

$().ready(function() {

	
	$("#CmpProductoCodigoOriginalEntrada").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoOriginal");
		 }
	});
	
});*/
