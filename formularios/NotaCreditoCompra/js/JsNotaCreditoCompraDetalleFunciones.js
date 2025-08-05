// JavaScript Document

function FncNotaCreditoCompraDetalleNuevo(){

	
	$('#CmpProductoId').val("");
	
	$('#CmpNotaCreditoCompraDetalleEstado').val("3");
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoNombre').val("");
	$('#CmpProductoUnidadMedida').val("");
	$('#CmpProductoUnidadMedidaConvertir').val("");

	$('#CmpNotaCreditoCompraDetallePrecio').val("");
	$('#CmpNotaCreditoCompraDetalleCantidad').val("");
	$('#CmpNotaCreditoCompraDetalleImporte').val("");
	
	$('#CmpNotaCreditoCompraDetalleItem').val("");
	$('#CmpNotaCreditoCompraDetalleAccion').val("AccNotaCreditoCompraDetalleRegistrar.php");
	$('#CmpNotaCreditoCompraDetallePrecio').select();
	$('#CapNotaCreditoCompraDetalleAccion').html("Listo para registrar elementos");
	
}

function FncNotaCreditoCompraDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var NotaCreditoCompraDetalleEstado = $('#CmpNotaCreditoCompraDetalleEstado').val();
	var ProductoId = $('#CmpProductoId').val();
	var ProductoNombre = $('#CmpProductoNombre').val();
	var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
	var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
	
	var NotaCreditoCompraDetallePrecio = $('#CmpNotaCreditoCompraDetallePrecio').val();
	var NotaCreditoCompraDetalleCantidad = $('#CmpNotaCreditoCompraDetalleCantidad').val();
	var NotaCreditoCompraDetalleImporte = $('#CmpNotaCreditoCompraDetalleImporte').val();
	

	var Item = $('#CmpNotaCreditoCompraDetalleItem').val();
	var Acc = $('#CmpNotaCreditoCompraDetalleAccion').val();
	
	if(ProductoNombre==""){
		dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/malo.png' width='25' height='25' border='0' > No ha ingresado un producto</p>", expire:3000 });
		
		$('#CmpProductoNombre').select();	
		
	}else if(NotaCreditoCompraDetallePrecio==""){
		dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/malo.png' width='25' height='25' border='0' > No ha ingresado un precio</p>", expire:3000 });
		
		$('#CmpNotaCreditoCompraDetallePrecio').select();	
		
	}else if(NotaCreditoCompraDetalleCantidad=="" || NotaCreditoCompraDetalleCantidad <=0){
		dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/malo.png' width='25' height='25' border='0' > No ha ingresado una cantidad</p>", expire:3000 });
		
		$('#CmpNotaCreditoCompraDetalleCantidad').select();	
		
	}else if(NotaCreditoCompraDetalleImporte==""){

		dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/malo.png' width='25' height='25' border='0' > No ha ingresado un importe</p>", expire:3000 });

		$('#CmpNotaCreditoCompraDetalleImporte').select();	

	}else if(NotaCreditoCompraDetalleEstado==""){

		dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/malo.png' width='25' height='25' border='0' >No ha escogido un estado</p>", expire:3000 });

		$('#CmpNotaCreditoCompraDetalleEstado').focus();	

	}else{

		$('#CapNotaCreditoCompraDetalleAccion').html('Guardando...');
				
		$.ajax({
			type: 'POST',
			url: 'formularios/NotaCreditoCompra/acc/'+Acc,
			data: 'Identificador='+Identificador+
			'&ProductoId='+(ProductoId)+
			'&ProductoNombre='+escape(ProductoNombre)+
			'&ProductoUnidadMedidaConvertir='+(ProductoUnidadMedidaConvertir)+
			'&ProductoUnidadMedida='+(ProductoUnidadMedida)+
			'&NotaCreditoCompraDetallePrecio='+NotaCreditoCompraDetallePrecio+
			'&NotaCreditoCompraDetalleCantidad='+NotaCreditoCompraDetalleCantidad+
			'&NotaCreditoCompraDetalleImporte='+NotaCreditoCompraDetalleImporte+
			'&NotaCreditoCompraDetalleEstado='+NotaCreditoCompraDetalleEstado+
			'&Item='+Item,
			success: function(){
				$('#CapNotaCreditoCompraDetalleAccion').html('Listo');							
				FncNotaCreditoCompraDetalleListar();
			}
		});

			FncNotaCreditoCompraDetalleNuevo();
	}		
}


function FncNotaCreditoCompraDetalleListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapNotaCreditoCompraDetalleAccion').html('Cargando...');

	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	var ImpuestoVenta = 0;

	if(PorcentajeImpuestoVenta!==""){
		ImpuestoVenta=PorcentajeImpuestoVenta/100;
	}

	if(TipoCambio==""){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/NotaCreditoCompra/FrmNotaCreditoCompraDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&ImpuestoVenta='+ImpuestoVenta+
		'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
		'&Editar='+NotaCreditoCompraDetalleEditar+
		'&Eliminar='+NotaCreditoCompraDetalleEliminar+
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio+
		'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId+
		'&IncluyeImpuesto='+IncluyeImpuesto,
		success: function(html){
			$('#CapNotaCreditoCompraDetalleAccion').html('Listo');	
			$("#CapNotaCreditoCompraDetalles").html("");
			$("#CapNotaCreditoCompraDetalles").append(html);
		}
	});
	
	//alert(MonedaSimbolo)
	$('#CapMonedaArticuloImporte').html(MonedaSimbolo);
	$('#CapMonedaArticuloPrecio').html(MonedaSimbolo);
	$('#CapMonedaRegimenMonto').html(MonedaSimbolo);
	$('#CapMonedaLetraMonto').html(MonedaSimbolo);	
	

}


function FncNotaCreditoCompraDetalleEscoger(oItem){


//SesionObjeto-NotaCreditoCompraDetalleListado
//Parametro1 = NodId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = NodPrecio
//Parametro5 = NodCantidad
//Parametro6 = NodImporte
//Parametro7 = NodTiempoCreacion
//Parametro8 = NodTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 = ProNombre
//Parametro12 = ProCodigoOriginal
//Parametro13 = UmeNombre
//Parametro14 = RtiId
//Parametro15 = UmeIdOrigen
//Parametro16 = NodEstado

	var Identificador = $('#Identificador').val();

	$('#CapNotaCreditoCompraDetalleAccion').html('Editando...');
	$('#CmpNotaCreditoCompraDetalleAccion').val("AccNotaCreditoCompraDetalleEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/NotaCreditoCompra/acc/AccNotaCreditoCompraDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsNotaCreditoCompraDetalle){
		
				$('#CmpProductoId').val(InsNotaCreditoCompraDetalle.Parametro2);
				$('#CmpProductoCodigoOriginal').val(InsNotaCreditoCompraDetalle.Parametro12);
				$('#CmpProductoNombre').val(InsNotaCreditoCompraDetalle.Parametro11);
				
				$('#CmpNotaCreditoCompraDetalleEstado').val(InsNotaCreditoCompraDetalle.Parametro12);
				$('#CmpArticuloDescripcion').val(InsNotaCreditoCompraDetalle.Parametro2);
				$('#CmpProductoUnidadMedidaConvertir').val(InsNotaCreditoCompraDetalle.Parametro3);
				
				$('#CmpNotaCreditoCompraDetalleEstado').val(InsNotaCreditoCompraDetalle.Parametro16);
				$('#CmpNotaCreditoCompraDetallePrecio').val(InsNotaCreditoCompraDetalle.Parametro4);
				$('#CmpNotaCreditoCompraDetalleCantidad').val(InsNotaCreditoCompraDetalle.Parametro5);
				$('#CmpNotaCreditoCompraDetalleImporte').val(InsNotaCreditoCompraDetalle.Parametro6);
				$('#CmpNotaCreditoCompraDetalleItem').val(InsNotaCreditoCompraDetalle.Item);
				
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsNotaCreditoCompraDetalle.Parametro14+"&Tipo=1&UnidadMedidaId="+InsNotaCreditoCompraDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsNotaCreditoCompraDetalle.Parametro3){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
				})
				
				
				
				$('#CmpNotaCreditoCompraDetalleImporte').select();
		}
	});


	

}



function FncNotaCreditoCompraDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapNotaCreditoCompraDetalleAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/NotaCreditoCompra/acc/AccNotaCreditoCompraDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapNotaCreditoCompraDetalleAccion').html("Eliminado");	
				FncNotaCreditoCompraDetalleListar();
			}
		});

		FncNotaCreditoCompraDetalleNuevo();
		

	}


	
}

function FncNotaCreditoCompraDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapNotaCreditoCompraDetalleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/NotaCreditoCompra/acc/AccNotaCreditoCompraDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapNotaCreditoCompraDetalleAccion').html('Eliminado');	
				FncNotaCreditoCompraDetalleListar();
			}
		});	
		
		FncNotaCreditoCompraDetalleNuevo();
	}
	
}



