// JavaScript Document

function FncTrasladoAlmacenDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");
	$('#CmpProductoCantidad').val("");
	$('#CmpTrasladoAlmacenDetalleEstado').val("1");	
	$('#CmpProductoItem').val("");	
	$('#CmpProductoCodigoOriginal').val("");		
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpTrasladoAlmacenDetalleAccion').val("AccTrasladoAlmacenDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');


	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	
	$('#CmpProductoNombre').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
}

function FncTrasladoAlmacenDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpTrasladoAlmacenDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();		
			
			var TrasladoAlmacenDetalleEstado = $('#CmpTrasladoAlmacenDetalleEstado').val();		
			
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			
			var Item = $('#CmpProductoItem').val();
	
			if(ProductoId == ""){
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
				  url: 'formularios/TrasladoAlmacen/acc/'+Acc,
				  data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&ProductoCantidad='+ProductoCantidad+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&TrasladoAlmacenDetalleEstado='+TrasladoAlmacenDetalleEstado+'&Item='+Item,
				  success: function(){
					  $('#CapProductoAccion').html('Listo');							
					  FncTrasladoAlmacenDetalleListar();
				  }
				});
						


				FncTrasladoAlmacenDetalleNuevo();	
							
					
					
		}
			

	
}


function FncTrasladoAlmacenDetalleListar(){

	var Identificador = $('#Identificador').val();

	var PorcentajeImpuestoVenta  = $('#CmpPorcentajeImpuestoVenta').val();
	var OrdenCompraId  = $('#CmpOrdenCompraId').val();
	var AlmacenId  = $('#CmpAlmacen').val();

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$('#CapProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrasladoAlmacen/FrmTrasladoAlmacenDetalleListado.php',
		data: 'Identificador='+Identificador
		+'&Editar='+TrasladoAlmacenDetalleEditar
		+'&Eliminar='+TrasladoAlmacenDetalleEliminar
		+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&OrdenCompraId='+OrdenCompraId+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&AlmacenId='+AlmacenId,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapTrasladoAlmacenDetalles").html("");
			$("#CapTrasladoAlmacenDetalles").append(html);
		}
	});
	
}



function FncTrasladoAlmacenDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	var VentaDirectaId = $('#CmpVentaDirectaId').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpTrasladoAlmacenDetalleAccion').val("AccTrasladoAlmacenDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TrasladoAlmacen/acc/AccTrasladoAlmacenDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsTrasladoAlmacenDetalle){
			
/*
SesionObjeto-TrasladoAlmacenDetalle
Parametro1 = TadId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = 
Parametro5 = TadCantidad
Parametro6 = 
Parametro7 = TadTiempoCreacion
Parametro8 = TadTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = TadEstado
*/					
				$('#CmpProductoId').val(InsTrasladoAlmacenDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsTrasladoAlmacenDetalle.Parametro13);		
				
				$('#CmpProductoCodigoAlternativo').val(InsTrasladoAlmacenDetalle.Parametro14);					
				$('#CmpProductoNombre').val(InsTrasladoAlmacenDetalle.Parametro3);						
				$('#CmpProductoUnidadMedidaConvertir').val(InsTrasladoAlmacenDetalle.Parametro10);	
				$('#CmpTrasladoAlmacenDetalleEstado').val(InsTrasladoAlmacenDetalle.Parametro16);		
				$('#CmpProductoCantidad').val(InsTrasladoAlmacenDetalle.Parametro5);
				$('#CmpProductoItem').val(InsTrasladoAlmacenDetalle.Item);
				

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsTrasladoAlmacenDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsTrasladoAlmacenDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsTrasladoAlmacenDetalle.Parametro10){
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
	$('#CmpProductoNombre').attr('readonly', true);
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);
	


/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();

}

function FncTrasladoAlmacenDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoAlmacen/acc/AccTrasladoAlmacenDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncTrasladoAlmacenDetalleListar();
			}
		});

		FncTrasladoAlmacenDetalleNuevo();
	}
	
}

function FncTrasladoAlmacenDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoAlmacen/acc/AccTrasladoAlmacenDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncTrasladoAlmacenDetalleListar();
			}
		});	
			
		FncTrasladoAlmacenDetalleNuevo();
	}
	
}



$().ready(function() {

	
	$("#CmpProductoCodigoOriginal").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoOriginal");
		 }
	});
	
});
