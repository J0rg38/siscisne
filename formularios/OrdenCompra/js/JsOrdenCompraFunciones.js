// JavaScript Document


function FncValidar(){

	var Tipo = $("#CmpTipo").val();
	var ProveedorId = $("#CmpProveedorId").val();
	var ProveedorNombre = $("#CmpProveedorNombre").val();
	var Fecha = $("#CmpFecha").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
		if(Tipo == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de pedido",
					callback: function(result){
						$("#CmpTipo").focus();
					}
				});
				
			return false;
			
		}else if(Fecha == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una fecha",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});
				
			return false;
			
}else if(ProveedorNombre == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un proveedor",
					callback: function(result){
						$("#CmpProveedorNombre").focus();
					}
				});
				
			return false;
			
}else if(ProveedorNombre != "" && ProveedorId==""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un proveedor",
					callback: function(result){
						$("#CmpProveedorNombre").focus();
					}
				});
				
			return false;
			
		}else if(VehiculoMarca == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una marca",
					callback: function(result){
						$("#CmpVehiculoMarca").focus();
					}
				});

			return false;


}else if(MonedaId == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una moneda ",
					callback: function(result){
						$("#CmpMonedaId").focus();
					}
				});

			return false;

}else if(MonedaId =! EmpresaMonedaId && (TipoCambio=="" || TipoCambio=="0.00")){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un tipo de cambio ",
					callback: function(result){
						$("#CmpTipoCambio").focus();
					}
				});

			return false;
						
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});



function FncGuardar(){
	
	//HACK
	
	
	$("#CmpIncluyeImpuesto").removeAttr('disabled');	
	
	$("#CmpEstado").removeAttr('disabled');	
	$("#CmpTipo").removeAttr('disabled');		
	
	$("#CmpMonedaId").removeAttr('disabled');	
	
}


var FormularioCampos = ["CmpTipo",
"CmpAno",
"CmpMes",
"CmpCodigoDealer",
"CmpFecha",
"CmpHora",
"CmpEstado",
"CmpMonedaId",
"CmpTipoCambio",
"CmpObservacion",
"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoCodigoOtro",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpProductoCantidad",
"CmpProductoPrecio",
"CmpProductoImporte"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncOrdenCompraNavegar(this.id);
		 }
	}); 
	
	/*$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 
	
	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	});*/ 
	
/*
Agregando Eventos
*/
	$("select#CmpMonedaId").change(function(){
		FncOrdenCompraEstablecerMoneda();
	});
	
	
	$("select#CmpTipo").change(function(){
		switch($(this).val()){
			case "ZVOR":
			
		/*
var mensaje = "	Vehículo Detenido (ZVOR) 
Es un pedido que se genera para requerimientos de repuestos de urgencia y 
únicamente para vehículos detenidos en taller de concesionarios. Los pedidos 
recibidos hasta las 15:00 horas serán despachados dentro de un plazo máximo 
24 para Lima y 48 horas para provincias. Estos tiempos estarán sujetos a la 
disponibilidad de inventario GMP y a cupo disponible por parte del 
concesionario (línea de crédito GMF o línea de crédito directo con GMP). De no 
contar con disponibilidad inmediata de inventario GMP se generará Back Order 
para el concesionario el cuál será solicitado a la fuente de abastecimiento 
respectiva vía expedite.

En este pedido debe indicarse el N° VIN del vehículo, placa del vehículo, modelo 
del vehículo y Orden de Trabajo (O/T) en el formato único de pedidos y en cada 
número de parte solicitado. Estos pedidos estarán sujetos a la permanente 
revisión por parte de General Motors Perú. Si General Motors Perú detecta un 
mal uso de este tipo de pedido, es decir que el concesionario coloque un pedido 
para un vehículo que no está detenido en el taller, no se realizará el pago de 
incentivos por política comercial de Posventa en el mes correspondiente.

Los Repuestos solicitados en esta categoría no tendrán recargo.
";
			 dhtmlx.message({ type:"info", text:mensaje, expire:-3 });*/
			
			break;
			
			case "STK":
			
			/*
			Stock (STK):

Es un pedido que se genera para reposición de inventario de repuestos en 

forma planificada diaria o semanal. Los pedidos recibidos hasta las 15:00 horas 

serán despachados dentro de un plazo máximo 48 horas para Lima y en un 

rango de 72 a 96 horas para provincias. 

Estos tiempos estarán sujetos a la disponibilidad de inventario GMP y a cupo 

disponible por parte del concesionario (línea de crédito GMF o línea de crédito 

directo con GMP). De no contar con disponibilidad inmediata en inventario 

GMP se generará Back Order para el concesionario el cuál será solicitado a la 

fuente de abastecimiento respectiva vía marítima.

Los Repuestos solicitados en esta categoría no tendrán recargo.
			*/
			break;
			
		}
	});
	
	
	
});
	
function FncOrdenCompraNavegar(oCampo){
	
		for(var i=0; i< FormularioCampos.length; i++) {
			if(FormularioCampos.length !== i + 1){
				
				if(FormularioCampos[i]==oCampo){
					
					if($('#'+FormularioCampos[i+1]).attr('type')=="text"){
						$('#'+FormularioCampos[i]).blur();
						$('#'+FormularioCampos[i+1]).focus();
						$('#'+FormularioCampos[i+1]).select();	
					}else{
						$('#'+FormularioCampos[i]).blur();	
						$('#'+FormularioCampos[i+1]).focus();	
					}
									
				}				
				
			}
				
		}
		
		
	if("CmpProductoImporte"==oCampo){
		$('#CmpProductoImporte').blur();
		FncOrdenCompraDetalleGuardar();
	}
		
}


function FncPedidoCompraBuscar(){
	FncOrdenCompraPedidoListar();
}


function FncVentaDirectaBuscar(){
	
}


function FncOrdenCompraEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();
	
	//alert(MonedaId);

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		//FncOrdenCompraDetalleListar();
		FncOrdenCompraPedidoListar();
		alert("Debe Escoger una moneda");
	}else{
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			}
		}
		FncMonedaBuscar('Id');
	}
}





//CmpAlmacenMovimientoEntradaCancelado



function FncImprmir(oId){
	FncPopUp('formularios/OrdenCompraGM/FrmOrdenCompraGMImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId){
	FncPopUp('formularios/OrdenCompraGM/FrmOrdenCompraGMImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}



function FncGenerarExcel(oId){
	
	FncPopUp('formularios/OrdenCompra/FrmOrdenCompraGenerarExcel.php?Id='+oId+'&P=2',0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncCotizacionProductoVistaPreliminar(oId){
	FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVentaDirectaVistaPreliminar(oId){
	FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}



function FncVentaConcretadaVistaPreliminar(oId){
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncPedidoCompraVistaPreliminar(oId){
	FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}



function FncPedidoCompraCargarFormulario(oForm,oPedidoCompraId){

//	tb_show(this.title,'principal2.php?Mod=PedidoCompra&Form='+oForm+'&Dia=1&Id='+oPedidoCompraId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width='+(screen.width-100)+'&modal=true',this.rel);	//tb_show(this.title,'principal2.php?Mod=PedidoCompra&Form='+oForm+'&Dia=1&Id='+oPedidoCompraId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=800&modal=true',this.rel);	
	FncCargarVentanaNuevo('principal2.php?Mod=PedidoCompra&Form='+oForm+'&Dia=1&Id='+oPedidoCompraId,"true","true","");	
	
}

function FncVentaDirectaCargarFormulario(oForm,oVentaDirectaId){

//	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width='+(screen.width-100)+'&modal=true',this.rel);		
	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=800&modal=true',this.rel);		

}