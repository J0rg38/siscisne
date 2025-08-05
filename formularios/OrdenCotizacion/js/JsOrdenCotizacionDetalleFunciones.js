// JavaScript Document

function FncOrdenCotizacionDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");
	
	$('#CmpOrdenCotizacionDetalleEstado').val("1");
	
	//$('#CmpOrdenCotizacionDetalleCodigo').val("");
	
	
	if($("#CmpOrdenCotizacionDetalleEstatico").is(':checked')){
		
	}else{
		$('#CmpOrdenCotizacionDetalleModelo').val("");
		$('#CmpOrdenCotizacionDetalleAno').val("");
	}

	
	$('#CmpOrdenCotizacionDetallePrecio').val("");	
	$('#CmpProductoItem').val("");	

	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoCodigoAlternativo').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpOrdenCotizacionDetalleAccion').val("AccOrdenCotizacionDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");
	

	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
}

function FncOrdenCotizacionDetalleGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpOrdenCotizacionDetalleAccion').val();		
	
	var ProductoId = $('#CmpProductoId').val();
	var ProductoNombre = $('#CmpProductoNombre').val();
	var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
	//var OrdenCotizacionDetalleEstado = $('#CmpOrdenCotizacionDetalleEstado').val();
	var OrdenCotizacionDetalleAno = $('#CmpOrdenCotizacionDetalleAno').val();
	var OrdenCotizacionDetalleModelo = $('#CmpOrdenCotizacionDetalleModelo').val();
	var OrdenCotizacionDetallePrecio = $('#CmpOrdenCotizacionDetallePrecio').val();			
	
	var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
	
	var Item = $('#CmpProductoItem').val();
	
	if(ProductoId == ""){
		alert("No existe el PRODUCTO");
		FncProductoCargarFormulario("Registrar");
	
	}else if(ProductoNombre==""){
		$('#CmpProductoNombre').select();	
	}else if(ProductoUnidadMedidaConvertir==""){
		$('#CmpProductoUnidadMedidaConvertir').focus();	
	}else{
		$('#CapProductoAccion').html('Guardando...');
		
		$.ajax({
		  type: 'POST',
		  url: 'formularios/OrdenCotizacion/acc/'+Acc,
		  //data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&ProductoCosto='+ProductoCosto+'&ProductoPrecio='+ProductoPrecio+'&ProductoCantidad='+ProductoCantidad+'&ProductoImporte='+ProductoImporte+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&OrdenCotizacionDetalleAno='+OrdenCotizacionDetalleAno+'&OrdenCotizacionDetalleModelo='+OrdenCotizacionDetalleModelo+'&OrdenCotizacionDetalleCodigo='+OrdenCotizacionDetalleCodigo+'&OrdenCotizacionDetalleEstado='+OrdenCotizacionDetalleEstado+'&Item='+Item,
		  data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&OrdenCotizacionDetalleAno='+OrdenCotizacionDetalleAno+'&OrdenCotizacionDetalleModelo='+OrdenCotizacionDetalleModelo+'&OrdenCotizacionDetallePrecio='+OrdenCotizacionDetallePrecio+'&Item='+Item,
		  success: function(){
			  $('#CapProductoAccion').html('Listo');							
			  FncOrdenCotizacionDetalleListar();
		  }
		});
				
						//if(confirm("Desea seguir agregando mas items?")==false){
	//									if(confirm("Desea guardar el registro ahora?")){
	//										$('#Guardar').val("1");
	//										$('#'+Formulario).submit();
	//									}
	//								}
	
				FncOrdenCotizacionDetalleNuevo();	
					
			
			
		}
			

	
}


function FncOrdenCotizacionDetalleListar(){

	var Identificador = $('#Identificador').val();

	var PorcentajeImpuestoVenta  = $('#CmpPorcentajeImpuestoVenta').val();
	var OrdenCompraId  = $('#CmpOrdenCompraId').val();
	

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$('#CapProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenCotizacion/FrmOrdenCotizacionDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+OrdenCotizacionDetalleEditar+'&Eliminar='+OrdenCotizacionDetalleEliminar+'&VerEstado='+OrdenCotizacionDetalleVerEstado+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&OrdenCompraId='+OrdenCompraId+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapOrdenCotizacionDetalles").html("");
			$("#CapOrdenCotizacionDetalles").append(html);
		}
	});
	
}



function FncOrdenCotizacionDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	var VentaDirectaId = $('#CmpVentaDirectaId').val();
	
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpOrdenCotizacionDetalleAccion').val("AccOrdenCotizacionDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/OrdenCotizacion/acc/AccOrdenCotizacionDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsOrdenCotizacionDetalle){
			
		
/*
SesionObjeto-OrdenCotizacionDetalle
Parametro1 = PcdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PcdPrecio
Parametro5 = 
Parametro6 = 
Parametro7 = PcdTiempoCreacion
Parametro8 = PcdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = PcdCodigo
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = 
Parametro18 = VddId
Parametro19 = PcdAno
Parametro20 = PcdModelo

Parametro21 - PcdDisponibilidad
Parametro22 - PcdReemplazo
Parametro23 = AmdCantidad

Parametro24 = PcdBOFecha
Parametro25 = PcdBOEstado

Parametro26 = PcdEstado
*/
						
				$('#CmpProductoId').val(InsOrdenCotizacionDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsOrdenCotizacionDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsOrdenCotizacionDetalle.Parametro14);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoNombre').val(InsOrdenCotizacionDetalle.Parametro3);		
				
				//$('#CmpOrdenCotizacionDetalleEstado').val(InsOrdenCotizacionDetalle.Parametro26);		
				
				//$('#CmpProductoCosto').val(InsOrdenCotizacionDetalle.Parametro17);
				$('#CmpOrdenCotizacionDetallePrecio').val(InsOrdenCotizacionDetalle.Parametro4);	
				//$('#CmpProductoCantidad').val(InsOrdenCotizacionDetalle.Parametro5);
				//$('#CmpProductoImporte').val(InsOrdenCotizacionDetalle.Parametro6);
				
				
				//$('#CmpOrdenCotizacionDetalleCodigo').val(InsOrdenCotizacionDetalle.Parametro12);
				$('#CmpOrdenCotizacionDetalleAno').val(InsOrdenCotizacionDetalle.Parametro19);
				$('#CmpOrdenCotizacionDetalleModelo').val(InsOrdenCotizacionDetalle.Parametro20);
				
				$('#CmpProductoItem').val(InsOrdenCotizacionDetalle.Item);
				

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsOrdenCotizacionDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsOrdenCotizacionDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsOrdenCotizacionDetalle.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
					$('#CmpProductoPrecio').select();
				})
				
				$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);

		}
	});
	
	
	
	
	$('#CmpProductoId').attr('readonly', true);
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);
	
	$('#CmpOrdenCotizacionDetalleAno').focus();
	
	//if(VentaDirectaId!=""){
//		$('#CmpProductoCantidad').attr('readonly', true);
//	}
	

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();

}

function FncOrdenCotizacionDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenCotizacion/acc/AccOrdenCotizacionDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncOrdenCotizacionDetalleListar();
			}
		});

		FncOrdenCotizacionDetalleNuevo();
	}
	
}

function FncOrdenCotizacionDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenCotizacion/acc/AccOrdenCotizacionDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncOrdenCotizacionDetalleListar();
			}
		});	
			
		FncOrdenCotizacionDetalleNuevo();
	}
	
}



$().ready(function() {

	//$("#CmpProductoImporte").keyup(function (event) {  
//		FncProductoCalcularMonto("Precio")
//	});
//	
//	$("#CmpProductoCantidad").keyup(function (event) {  
//		FncProductoCalcularImporte("Precio")
//	});
//
//	$("#CmpProductoPrecio").keyup(function (event) {  
//		FncProductoCalcularImporte("Precio")
//	});
	
//	$("#CmpProductoId").keypress(function (event) {  
//		 if (event.keyCode == '13' && this.type !== "hidden") {
//			FncProductoBuscar("Id");
//		 }
//	});
	
	$("#CmpProductoCodigoOriginal").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoOriginal");
		 }
	});
	
	$("#CmpProductoCodigoAlternativo").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoAlternativo");
		 }
	});
	
});
