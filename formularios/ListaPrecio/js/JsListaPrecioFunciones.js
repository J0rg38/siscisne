// JavaScript Document
var ProductoTipoUnidadMedidaIngresoHabilitado = 1;
var ProductoTipoUnidadMedidaBaseHabilitado = 1;

$().ready(function() {
	
/*
CARGAS INICIALES
*/	
//	FncEstablecerProductoTipoUnidadMedidaIngreso();
//	FncEstablecerProductoTipoUnidadMedidaBase();
//	FncEstablecerProductoTipoUnidadMedidaSalida();
	
/*
AGREGANDO EVENTOS
*/

//	$("select#CmpTipo").change(function(){
//		FncEstablecerProductoTipoUnidadMedidaIngreso();
//		FncEstablecerProductoTipoUnidadMedidaBase();
//		FncEstablecerProductoTipoUnidadMedidaSalida();
//	})

	$("#CmpCosto").keyup(function(){
		FncListaPrecioCalcularCostoIngrseo();
	});
	
	$('input').each(function () {

		if($(this).attr('etiqueta')=="porcentaje_utilidad"){
		}			 
		
		if($(this).attr('etiqueta')=="valor_venta"){
		}			 

		if($(this).attr('etiqueta')=="precio"){
			$("#CmpListaPrecioPrecio_"+$(this).attr('cliente_tipo')+"_"+$(this).attr('unidad_medida')).keyup(function(){
				FncListaPrecioCalcular3($(this).attr('cliente_tipo'),$(this).attr('unidad_medida'));
			});
		}			 

	});
	
});

//FUNCIONES

function FncListaPrecioCalcularCostoIngrseo(){
	
	var ProductoCosto = $("#CmpCosto").val().replace(",","");
	var UnidadMedidaEquivalente = $("#CmpUnidadMedidaEquivalente").val();
	var ProductoCostoIngreso = 0;

	ProductoCosto = parseFloat(ProductoCosto);
	UnidadMedidaEquivalente = parseFloat(UnidadMedidaEquivalente);

	ProductoCostoIngreso = ProductoCosto * UnidadMedidaEquivalente;

	$("#CmpCostoIngreso").val(ProductoCostoIngreso);

	$('input').each(function () {
		
		if($(this).attr('etiqueta')=="costo"){
			FncListaPrecioCalcularCostoSalida($(this).attr('cliente_tipo'),$(this).attr('unidad_medida'));
			FncListaPrecioCalcular($(this).attr('cliente_tipo'),$(this).attr('unidad_medida'));
		}

	});	
		
}

function FncListaPrecioCalcularCostoSalida(oClienteTipoId,oUnidadMedidaId){
	
	var ProductoCosto = $("#CmpCosto").val().replace(",","");
	var UnidadMedidaEquivalente = $("#CmpListaPrecioEquivalente_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ProductoCostoSalida = 0;

	ProductoCosto = parseFloat(ProductoCosto);
	UnidadMedidaEquivalente = parseFloat(UnidadMedidaEquivalente);

	ProductoCostoSalida = ProductoCosto * UnidadMedidaEquivalente;

	$("#CmpListaPrecioCosto_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ProductoCostoSalida);

}


//
//function FncListaPrecioCalcular(oClienteTipoId,oUnidadMedidaId){
//	
//	var ProductoCosto = $("#CmpCosto").val().replace(",","");
//	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
//	
//	var ListaPrecioValorVenta = $("#CmpListaPrecioValorVenta_"+oClienteTipoId+"_"+oUnidadMedidaId).val().replace(",", "");
//	var ListaPrecioPorcentajeUtilidad = 0;
//	var ListaPrecioImpuesto = 0;
//	var ListaPrecioPrecio = 0;
//	
//	ProductoCosto = parseFloat(ProductoCosto);
//	ListaPrecioValorVenta = parseFloat(ListaPrecioValorVenta);
//	PorcentajeImpuestoVenta = parseFloat(PorcentajeImpuestoVenta);
//	
//	ListaPrecioUtilidad = ListaPrecioValorVenta - ProductoCosto;
//	ListaPrecioPorcentajeUtilidad = ListaPrecioUtilidad/ProductoCosto;
//	ListaPrecioImpuesto = (PorcentajeImpuestoVenta/100) * ListaPrecioValorVenta;
//	ListaPrecioPrecio = ListaPrecioValorVenta + ListaPrecioImpuesto;
//	
//	$("#CmpListaPrecioUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioUtilidad);
//	$("#CmpListaPrecioPorcentajeUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioPorcentajeUtilidad);
//	
//	$("#CmpListaPrecioImpuesto_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioImpuesto);
//	$("#CmpListaPrecioPrecio_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioPrecio);
//
//}
//



//
//
//function FncListaPrecioCalcular2(oClienteTipoId,oUnidadMedidaId){
//	
//	var ProductoCosto = $("#CmpListaPrecioCosto_"+oClienteTipoId+"_"+oUnidadMedidaId).val().replace(",", "");
//	//var ProductoCosto = ProductoCosto.replace(",", "");
//
//	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
//	
//	var ListaPrecioValorVenta = 0;
//	var ListaPrecioPorcentajeUtilidad = $("#CmpListaPrecioPorcentajeUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val().replace(",", "");
//	var ListaPrecioUtilidad = 0;
//	
//	var ListaPrecioImpuesto = 0;
//	var ListaPrecioPrecio = 0;
//
//	ProductoCosto = parseFloat(ProductoCosto);
//	PorcentajeImpuestoVenta = parseFloat(PorcentajeImpuestoVenta);
//	ListaPrecioPorcentajeUtilidad = parseFloat(ListaPrecioPorcentajeUtilidad);
//	
//	ListaPrecioUtilidad =  (ProductoCosto * (ListaPrecioPorcentajeUtilidad/100));
//	ListaPrecioValorVenta = ProductoCosto + ListaPrecioUtilidad;
//	
//	ListaPrecioImpuesto = (PorcentajeImpuestoVenta/100) * ListaPrecioValorVenta;
//	ListaPrecioPrecio = ListaPrecioValorVenta + ListaPrecioImpuesto;
//	
//	$("#CmpListaPrecioUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioUtilidad);
//	$("#CmpListaPrecioValorVenta_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioValorVenta);
//	
//	$("#CmpListaPrecioImpuesto_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioImpuesto);
//	$("#CmpListaPrecioPrecio_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioPrecio);
//
//}


//
//function FncListaPrecioCalcular6(oClienteTipoId,oUnidadMedidaId){
//
//	var ListaPrecioPorcentajeUtilidad  = $("#CmpListaPrecioPorcentajeUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val().replace(",", "");
//
//	ListaPrecioUbicacion1  = $("#CmpListaPrecioPrecio_"+oClienteTipoId+"_"+oUnidadMedidaId).attr('ubicacion');				
//
//	$('input').each(function () {
//
//		if($(this).attr('etiqueta')=="porcentaje_utilidad"){
//
//			if($(this).attr('unidad_medida') != oUnidadMedidaId){
//
//				$("#CmpListaPrecioPorcentajeUtilidad_"+oClienteTipoId+"_"+$(this).attr('unidad_medida')).val(ListaPrecioPorcentajeUtilidad);
//				
//				FncListaPrecioCalcular2(oClienteTipoId,$(this).attr('unidad_medida'));
//				FncListaPrecioCalcular7(oClienteTipoId,oUnidadMedidaId)
//				
//
//			}
//
//		}
//
//	});	
//
//}
//
//function FncListaPrecioCalcular7(oClienteTipoId,oUnidadMedidaId){
//
//	var ListaPrecioPorcentajeUtilidad  = $("#CmpListaPrecioPorcentajeUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val().replace(",", "");
//	var ListaPrecioUbicacion1 = 0;
//
//	ListaPrecioUbicacion1  = $("#CmpListaPrecioPrecio_"+oClienteTipoId+"_"+oUnidadMedidaId).attr('ubicacion');
//
//	$('input').each(function () {
//		
//		
//
//		if($(this).attr('etiqueta')=="precio"){
//	
//			  if(ListaPrecioUbicacion1<$(this).attr('ubicacion')){
//  
//				  
//				  if( $( "#CmpListaPrecioUso_"+$(this).attr('cliente_tipo')+"_"+$(this).attr('unidad_medida')).val() != "CYC" && $("#CmpListaPrecioUso_"+$(this).attr('cliente_tipo')+"_"+$(this).attr('unidad_medida')).val() != "EXC" ){
//		  
//					$("#CmpListaPrecioPorcentajeUtilidad_"+$(this).attr('cliente_tipo')+"_"+$(this).attr('unidad_medida')).val(ListaPrecioPorcentajeUtilidad);
//							  
//				  }
//	  
//	  
//				  FncListaPrecioCalcular2($(this).attr('cliente_tipo'),$(this).attr('unidad_medida'));
//			  }
//				
//		}
//	
//
//		
//		
//		
//				
//		
//		
//
//	});	
//
//}
//






















function FncListaPrecioCalcular3(oClienteTipoId,oUnidadMedidaId){

console.log("--------------------------------------------");

	var ProductoCosto = $("#CmpListaPrecioCosto_"+oClienteTipoId+"_"+oUnidadMedidaId).val().replace(",", "");
	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();	
	
	var ListaPrecioPorcentajeOtroCosto  = $("#CmpListaPrecioPorcentajeOtroCosto_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ListaPrecioPorcentajeManoObra  = $("#CmpListaPrecioPorcentajeManoObra_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	
	var ListaPrecioPorcentajeAdicional  = $("#CmpListaPrecioPorcentajeAdicional_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ListaPrecioPorcentajeAdicional2  = $("#CmpListaPrecioPorcentajeAdicional2_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	
	var ListaPrecioPorcentajeDescuento  = $("#CmpListaPrecioPorcentajeDescuento_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ListaPrecioPorcentajeDescuento2  = $("#CmpListaPrecioPorcentajeDescuento2_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ListaPrecioPorcentajeUtilidad = $("#CmpListaPrecioPorcentajeUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val();

	var ListaPrecioOtroCosto = 0;
	var ListaPrecioManoObra = 0;
	
	var ListaPrecioUtilidad = 0;
	var ListaPrecioAdicional = 0;

	var ListaPrecioValorVenta = 0;
	var ListaPrecioImpuesto = 0;
	var ListaPrecioDescuento= 0;
	var ListaPrecioPrecioNuevo  = $("#CmpListaPrecioPrecio_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ListaPrecioValorVentaImpuesto = 0;
	var ListaPrecioPrecio = 0;
	
	
	if(ListaPrecioPorcentajeOtroCosto==""){
		ListaPrecioPorcentajeOtroCosto = 0;
	}
	
	if(ListaPrecioPorcentajeManoObra==""){
		ListaPrecioPorcentajeManoObra = 0;
	}
	
	
	if(ListaPrecioPorcentajeAdicional==""){
		ListaPrecioPorcentajeAdicional = 0;
	}
	
	if(ListaPrecioPorcentajeAdicional2==""){
		ListaPrecioPorcentajeAdicional2 = 0;
	}
	
	if(ListaPrecioPorcentajeDescuento==""){
		ListaPrecioPorcentajeDescuento = 0;
	}
	
	if(ListaPrecioPorcentajeDescuento2==""){
		ListaPrecioPorcentajeDescuento2 = 0;
	}
	
	if(ListaPrecioPorcentajeUtilidad==""){
		ListaPrecioPorcentajeUtilidad = 0;
	}
	
	if(ListaPrecioPrecioNuevo==""){
		ListaPrecioPrecioNuevo = 0;
	}
	
	
	ProductoCosto = parseFloat(ProductoCosto);
	PorcentajeImpuestoVenta = parseFloat(PorcentajeImpuestoVenta);
	
	
	ListaPrecioPorcentajeOtroCosto = parseFloat(ListaPrecioPorcentajeOtroCosto);
	ListaPrecioPorcentajeManoObra = parseFloat(ListaPrecioPorcentajeManoObra);
	
	ListaPrecioPorcentajeAdicional = parseFloat(ListaPrecioPorcentajeAdicional);
	ListaPrecioPorcentajeDescuento = parseFloat(ListaPrecioPorcentajeDescuento);
	ListaPrecioPorcentajeUtilidad = parseFloat(ListaPrecioPorcentajeUtilidad);
	ListaPrecioPrecioNuevo = parseFloat(ListaPrecioPrecioNuevo);
	
//	console.log("ListaPrecioPorcentajeOtroCosto");
//	console.log(ListaPrecioPorcentajeOtroCosto);
//	console.log("ListaPrecioPorcentajeAdicional");
//	console.log(ListaPrecioPorcentajeAdicional);
//	console.log("ListaPrecioPorcentajeDescuento");
//	console.log(ListaPrecioPorcentajeDescuento);
//	console.log("ListaPrecioPorcentajeUtilidad");
//	console.log(ListaPrecioPorcentajeUtilidad);
	
	
	ListaPrecioOtroCosto = (ProductoCosto*((ListaPrecioPorcentajeOtroCosto/100)));	
	ListaPrecioUtilidad = ( (ProductoCosto + ListaPrecioOtroCosto) * (ListaPrecioPorcentajeUtilidad/100));
	ListaPrecioManoObra = ( (ProductoCosto + ListaPrecioOtroCosto + ListaPrecioUtilidad) * (ListaPrecioPorcentajeManoObra/100));


	ListaPrecioValorVenta = ProductoCosto + ListaPrecioOtroCosto + ListaPrecioUtilidad + ListaPrecioManoObra;	
	ListaPrecioImpuesto = (ListaPrecioValorVenta * 0.18);		
	ListaPrecioValorVentaImpuesto = (ListaPrecioValorVenta + ListaPrecioImpuesto);
	
	ListaPrecioAdicional = ( ListaPrecioValorVentaImpuesto * (ListaPrecioPorcentajeAdicional2/100));
	ListaPrecioDescuento = ( (ListaPrecioValorVentaImpuesto + ListaPrecioAdicional) * (ListaPrecioPorcentajeDescuento2/100));
	ListaPrecioPrecio = ( ListaPrecioValorVentaImpuesto + ListaPrecioAdicional - ListaPrecioDescuento );	

	//console.log(ListaPrecioValorVentaImpuesto+" - "+ListaPrecioPrecioNuevo);
	
	
	
	if(ListaPrecioValorVentaImpuesto > ListaPrecioPrecioNuevo){

		var AuxDiferencia = parseFloat(ListaPrecioValorVentaImpuesto) - parseFloat(ListaPrecioPrecioNuevo);
		var AuxListaPrecioPorcentajeDescuento = (( AuxDiferencia*100 )/parseFloat(ListaPrecioValorVentaImpuesto))
		var AuxListaPrecioPorcentajeAdicional = 0;

	}else{

		var AuxDiferencia = parseFloat(ListaPrecioPrecioNuevo) - parseFloat(ListaPrecioValorVentaImpuesto);
		var AuxListaPrecioPorcentajeAdicional = (( AuxDiferencia*100 )/parseFloat(ListaPrecioValorVentaImpuesto))
		var AuxListaPrecioPorcentajeDescuento = 0;

	}
	
	if(ListaPrecioValorVentaImpuesto=="" || ListaPrecioValorVentaImpuesto == "0.00"){
		AuxListaPrecioPorcentajeAdicional = 0;
	}
	

	ListaPrecioOtroCosto = (ProductoCosto*((ListaPrecioPorcentajeOtroCosto/100)));
	ListaPrecioUtilidad = ( ( ProductoCosto + ListaPrecioOtroCosto ) * (ListaPrecioPorcentajeUtilidad/100));
	ListaPrecioManoObra = ( ( ProductoCosto + ListaPrecioOtroCosto + ListaPrecioUtilidad) * (ListaPrecioPorcentajeManoObra/100));
	
	
	ListaPrecioValorVenta = ProductoCosto + ListaPrecioOtroCosto + ListaPrecioUtilidad + ListaPrecioManoObra;	
	ListaPrecioImpuesto = (ListaPrecioValorVenta * 0.18);		
	ListaPrecioValorVentaImpuesto = (ListaPrecioValorVenta + ListaPrecioImpuesto);

	ListaPrecioAdicional = ( ListaPrecioValorVentaImpuesto * (AuxListaPrecioPorcentajeAdicional/100));
	ListaPrecioDescuento = ( (ListaPrecioValorVentaImpuesto + ListaPrecioAdicional) * (AuxListaPrecioPorcentajeDescuento/100));
	ListaPrecioPrecio = (ListaPrecioValorVentaImpuesto + ListaPrecioAdicional - ListaPrecioDescuento);	
	

	$("#CmpListaPrecioPorcentajeDescuento_"+oClienteTipoId+"_"+oUnidadMedidaId).val(AuxListaPrecioPorcentajeDescuento);
	$("#CmpListaPrecioPorcentajeAdicional_"+oClienteTipoId+"_"+oUnidadMedidaId).val(AuxListaPrecioPorcentajeAdicional);
	
	$("#CmpListaPrecioUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioUtilidad);	
	$("#CmpListaPrecioOtroCosto_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioOtroCosto);	
	$("#CmpListaPrecioManoObra_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioManoObra);	
	
	$("#CmpListaPrecioValorVenta_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioValorVenta);
	$("#CmpListaPrecioImpuesto_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioImpuesto);
	
	$("#CmpListaPrecioAdicional_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioAdicional);
	$("#CmpListaPrecioDescuento_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioDescuento);
	
	
}



function FncListaPrecioCalcular(oClienteTipoId,oUnidadMedidaId){

	var ProductoCosto = $("#CmpListaPrecioCosto_"+oClienteTipoId+"_"+oUnidadMedidaId).val().replace(",", "");

	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
	var ListaPrecioPorcentajeOtroCosto  = $("#CmpListaPrecioPorcentajeOtroCosto_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ListaPrecioPorcentajeManoObra  = $("#CmpListaPrecioPorcentajeManoObra_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	
	var ListaPrecioPorcentajeUtilidad  = $("#CmpListaPrecioPorcentajeUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ListaPrecioPorcentajeAdicional  = $("#CmpListaPrecioPorcentajeAdicional_"+oClienteTipoId+"_"+oUnidadMedidaId).val();
	var ListaPrecioPorcentajeDescuento = $("#CmpListaPrecioPorcentajeDescuento_"+oClienteTipoId+"_"+oUnidadMedidaId).val();

	var ListaPrecioOtroCosto = 0;
	var ListaPrecioManoObra = 0;
	
	var ListaPrecioUtilidad = 0;
	var ListaPrecioValorVenta = 0;
	var ListaPrecioImpuesto = 0;

	var ListaPrecioAdicional = 0;
	var ListaPrecioDescuento = 0;
	var ListaPrecioPrecio  = 0;
	
	
	if(ListaPrecioPorcentajeOtroCosto==""){
		ListaPrecioPorcentajeOtroCosto = 0;
	}
	
	if(ListaPrecioPorcentajeManoObra==""){
		ListaPrecioPorcentajeManoObra = 0;
	}
	
	if(ListaPrecioPorcentajeUtilidad==""){
		ListaPrecioPorcentajeUtilidad = 0;
	}
	
	if(ListaPrecioPorcentajeAdicional==""){
		ListaPrecioPorcentajeAdicional = 0;
	}
	
	if(ListaPrecioPorcentajeDescuento==""){
		ListaPrecioPorcentajeDescuento = 0;
	}

	
	
	
	ProductoCosto = parseFloat(ProductoCosto);
	PorcentajeImpuestoVenta = parseFloat(PorcentajeImpuestoVenta);
	
	ListaPrecioPorcentajeOtroCosto = parseFloat(ListaPrecioPorcentajeOtroCosto);
	ListaPrecioPorcentajeManoObra = parseFloat(ListaPrecioPorcentajeManoObra);
	
	ListaPrecioPorcentajeAdicional = parseFloat(ListaPrecioPorcentajeAdicional);
	ListaPrecioPorcentajeUtilidad = parseFloat(ListaPrecioPorcentajeUtilidad);
	ListaPrecioPorcentajeDescuento = parseFloat(ListaPrecioPorcentajeDescuento);

	
	ListaPrecioOtroCosto = (ProductoCosto * ((ListaPrecioPorcentajeOtroCosto/100)));	
	ListaPrecioUtilidad = ( (ProductoCosto + ListaPrecioOtroCosto ) * (ListaPrecioPorcentajeUtilidad/100));
	ListaPrecioManoObra = ( (ProductoCosto + ListaPrecioOtroCosto + ListaPrecioUtilidad) * (ListaPrecioPorcentajeManoObra/100));
	
	ListaPrecioValorVenta = ProductoCosto + ListaPrecioOtroCosto + ListaPrecioUtilidad + ListaPrecioManoObra;	
	ListaPrecioImpuesto = (ListaPrecioValorVenta * 0.18);		
	ListaPrecioValorVentaImpuesto = (ListaPrecioValorVenta + ListaPrecioImpuesto);
	
	ListaPrecioAdicional = ( ListaPrecioValorVentaImpuesto * (ListaPrecioPorcentajeAdicional/100));
	ListaPrecioDescuento = ( (ListaPrecioValorVentaImpuesto + ListaPrecioAdicional) * (ListaPrecioPorcentajeDescuento/100));
	ListaPrecioPrecio = (ListaPrecioValorVentaImpuesto + ListaPrecioAdicional - ListaPrecioDescuento);	
	
	$("#CmpListaPrecioOtroCosto_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioOtroCosto);
	$("#CmpListaPrecioUtilidad_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioUtilidad);
	$("#CmpListaPrecioManoObra_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioManoObra);
	
	$("#CmpListaPrecioValorVenta_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioValorVenta);
	$("#CmpListaPrecioImpuesto_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioImpuesto);
	
	$("#CmpListaPrecioAdicional_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioAdicional);
	$("#CmpListaPrecioDescuento_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioDescuento);
	$("#CmpListaPrecioPrecio_"+oClienteTipoId+"_"+oUnidadMedidaId).val(ListaPrecioPrecio);
}


