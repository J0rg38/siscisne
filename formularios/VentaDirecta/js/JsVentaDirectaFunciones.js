// JavaScript Document


function FncValidar(){

	var Fecha = $("#CmpFecha").val();
	var ClienteId = $("#CmpClienteId").val();
	var ClienteNombreCompleto = $("#CmpClienteNombreCompleto").val();
	var MonedaId = $("#CmpMonedaId").val();
	var Personal = $("#CmpPersonal").val();
	
	var TipoCambio = $("#CmpTipoCambio").val();
		
		if(Fecha == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});
				
			return false;
			
		}else if(FncValidarFecha(Fecha) == false){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"La fecha ingresada no es correcta",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});
				
			return false;
		
		}else if(ClienteNombreCompleto == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un cliente",
					callback: function(result){
						$("#CmpClienteNombreCompleto").focus();
					}
				});
				
			return false;
			
		}else if(ClienteId == "" && ClienteNombreCompleto!=""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No has ingresado correctamente al cliente",
					callback: function(result){
						$("#CmpClienteNombreCompleto").focus();
					}
				});
				
			return false;
			
			
		}else if(ClienteNombreCompleto == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un cliente",
					callback: function(result){
						$("#CmpClienteNombreCompleto").focus();
					}
				});
				
			return false;
			
		}else if(MonedaId == ""){			
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una moneda",
				callback: function(result){
					$("#CmpMonedaId").focus();
				}
			});
				
			return false;
			
		}else if(MonedaId != EmpresaMonedaId && TipoCambio =="" ){			
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un tipo de cambio",
				callback: function(result){
					$("#CmpTipoCambio").focus();
				}
			});
				
			return false;
			
		}else if(Personal == ""){			
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una cotizador",
				callback: function(result){
					$("#CmpPersonal").focus();
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
		
			$("#CmpTipoOperacion").removeAttr('disabled');
	$("#CmpEstado").removeAttr('disabled');		
	$("#CmpClienteTipo").removeAttr('disabled');		
	$("#CmpMonedaId").removeAttr('disabled');		
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
			$("#CmpTipoOperacion").removeAttr('disabled');
	$("#CmpEstado").removeAttr('disabled');		
	$("#CmpClienteTipo").removeAttr('disabled');		
	$("#CmpMonedaId").removeAttr('disabled');		
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');	
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});

var FormularioCampos = ["CmpFecha",
"CmpClienteNombre",
"CmpClienteTipoDocumento",
"CmpClienteNumeroDocumento",
"CmpClienteDireccion",
"CmpVehiculoIngresoVIN",
"CmpMonedaId",
"CmpObservacion",

"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpProductoCantidad",
"CmpProductoImporte"

];


$().ready(function() {

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden" && this.type !=="image") {
			FncVentaDirectaNavegar(this.id);
		 }
	}); 

	$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" && this.type !=="image") {
			$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 

	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" && this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 

/*
Agregando Eventos
*/
	
	$("select#CmpMonedaId").change(function(){
		FncVentaDirectaEstablecerMoneda();
	});
	
//	$("#CmpManoObra").keyup(function(){
//		FncVentaDirectaDetalleListar();
//	});
//	
////	$("#CmpClienteMargenUtilidad").keyup(function(){
////		FncVentaDirectaDetalleListar();
////	});
//	
//	$("#CmpPorcentajeDescuento").keyup(function(){
//		FncVentaDirectaDetalleListar();
//	});
//	
//	
//	$("#BtnMantenimientoVerificar").click(function(){
//	
//		dhtmlx.confirm("¿Desea aplicar el margen adicional por mantenimiento?", function(result){
//			if(result==true){
//				
//				$('#CmpPorcentajeManoObra').val(EmpresaMantenimientoPorcentajeManoObra);
//								
//			}else{
//				$('#CmpPorcentajeManoObra').val(0);
//			}
//		});
//
//	});

	$("#CmpClienteTipo").change(function(){
		FncVentaDirectaEstablecerClienteTipo();
	});


	$('input[type=radio][name=CmpListaPrecio]').change(function() {
		
		if (this.value == 'LOCAL') {
			
			var ClienteTipo = $("#CmpClienteTipo").val();
			
			if(ClienteTipo==""){
				
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de cliente",
					callback: function(result){
						$("#CmpClienteTipo").focus();
					}
				});
				
				//return false;
				
			}else{
				
				$("#CmpClienteMargenUtilidad").val("0.00");
				
			}
			
		}else{

			$("#CmpClienteMargenUtilidad").val(EmpresaMargenesMeson );
			
		}
		
		
	});
	

});
	
function FncVentaDirectaNavegar(oCampo){

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
		FncVentaDirectaDetalleGuardar();		
	}

	//alert(oCampo);
}


/*
* FUNCIONES - AUXILIARES
*/

function FncVentaDirectaEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncVentaDirectaDetalleListar();
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


function FncVentaDirectaEstablecerClienteTipo(){

	var ClienteTipoId = $('#CmpClienteTipo').val();

	if(ClienteTipoId==""){		
	
		alert("Debe escoger un tipo de cliente");
		
	}else{
		
		$.ajax({
			type: 'POST',
			dataType : 'json',
			url: 'comunes/Cliente/jn/JnClienteTipo.php',
			data: 'ClienteTipoId='+ClienteTipoId,
			success: function(InsClienteTipo){
				
				if(InsClienteTipo!=null){
					
					$("#CmpClienteMargenUtilidad").val(InsClienteTipo.LtiPorcentajeMargenUtilidad);
					$("#CmpPorcentajeOtroCosto").val(InsClienteTipo.LtiPorcentajeOtroCosto);
					$("#CmpPorcentajeManoObra").val(InsClienteTipo.LtiPorcentajeManoObra);
					$("#CmpPorcentajeDescuento").val(InsClienteTipo.LtiPorcentajeDescuento);
					
				}
				
			}
		});	

	}

}


/*
* FUNCIONES COMUNES
*/

function FncVehiculoIngresoSimpleFuncion(){

}

function FncClienteFuncion(InsCliente){
	
	var VehiculoIngresoId = $("#CmpClienteVehiculoIngresoId").val();
	
	$("#CmpVehiculoIngresoId").val(VehiculoIngresoId);

	FncVehiculoIngresoSimpleBuscar('Id');
	
	FncClienteNotaVerificar();
	
	
	
	//FncVentaDirectaEstablecerMoneda();
	
	$('#CmpPorcentajeOtroCosto').val("0.00");
	$('#CmpClienteMargenUtilidad').val(EmpresaMargenesMeson);
	$('#CmpPorcentajeManoObra').val("0.00");
	$('#CmpPorcentajeDescuento').val("0.00");
	
	$('#CmpClienteTipo').val("");
}

function FncListaPrecioBuscar(oCampo){
	
	FncProductoBuscar('Id');

}

function FncMonedaFuncion(){

	FncVentaDirectaDetalleListar();
	
	FncVentaDirectaPlanchadoListar();
	FncVentaDirectaPintadoListar();
	FncVentaDirectaCentradoListar();
	FncVentaDirectaTareaListar();
	
}

function FncVehiculoIngresoSimpleFormularioFuncion(){	

	FncVehiculoIngresoSimpleBuscar("Id");
	
}

/*
* FUNCIONES IMPRESION
*/


function FncImprmir(oId){
	
//	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Ficha de Salida) \n 2 = Formato 2 (Orden de Venta)", "1");
//			
//	if(Tipo !== null){
//		
//		switch(Tipo.toUpperCase()){
//			case "1":
//
//				FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
//
//			break;
//			
//			case "2":

				FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

//			break;
//		
//		}
//		
//	}

}


function FncVistaPreliminar(oId){
	
//	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Ficha de Salida) \n 2 = Formato 2 (Orden de Venta)", "1");
//	
//		if(Tipo !== null){
//			switch(Tipo.toUpperCase()){
//				case "1":
//
//					FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir.php?Id='+oId+'',0,0,1,0,0,1,0,screen.height,screen.width);
//
//				break;
//				
//				case "2":
					FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
//				break;
//			
//			}
//			
//		}

}

$().ready(function() {

	$("#CmpProductoImporte").keyup(function (event) {
		//FncProductoCalcularMonto("Precio");
		FncCalcularMostrarPrecio();
	});
	
	$("#CmpProductoCantidad").keyup(function (event) {  
		//FncProductoCalcularImporte("Precio");
		FncCalcularMostrarImporte()
	});
	
		
	$("#CmpVentaDirectaDetallePorcentajeAdicional").keyup(function (event) {  
		//FncCalcularMostrarImporteFinal();
		FncReCalcularMostrarPrecioFinal();
	});
	
	$("#CmpVentaDirectaDetallePorcentajeDescuento").keyup(function (event) {  
		//FncCalcularMostrarImporteFinal();
		FncReCalcularMostrarPrecioFinal();
	});
	
	$("#CmpProductoId").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("Id");
		 }
	});
	
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







function FncProductoBuscar(oCampo){
	
	var Dato = $('#CmpProducto'+oCampo).val()
	var ClienteTipoId = $("#CmpClienteTipo").val();
	
	if(Dato!=""){
	
		//var ProductoLector = $('#CmpProductoLector:checked').val();
		
		/*if(ProductoLector=="1"){
			
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
					data: 'Campo='+oCampo+'&Dato='+Dato,
					success: function(InsProducto){
	
							if(InsProducto.ProId!="" & InsProducto.ProId!=null){
	
								FncProductoEscoger(InsProducto);
	
								var ProductoNombre = $('#CmpProductoNombre').val();
	
								if(ProductoNombre!="undefined" & ProductoNombre!=""){
									$('#CmpProductoCantidad').val(1);
									$('#CmpProductoImporte').val(InsProducto.ProPrecio*1);
									//eval(ProductoFuncion+"Guardar();");
								}
	
							}else{
								$('#CmpProducto'+oCampo).focus();
								$('#CmpProducto'+oCampo).select();											
							}
						
					}
				});
				
	
		}else{*/
			
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
				data: 'Campo='+oCampo+'&Dato='+Dato+'&ClienteTipo='+ClienteTipoId,
				success: function(InsProducto){
											
					if(InsProducto.ProId!="" & InsProducto.ProId!=null){
	
						FncProductoEscoger(InsProducto);
						
					}else{
						
							dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"No se encontro codigo registrado",
							callback: function(result){
								$('#CmpProducto'+oCampo).focus();
								$('#CmpProducto'+oCampo).select();	
							}
						});
											
					}
					
				}
			});
			
		//}

	}

}

/*****************************************************************************/
//FncProductoEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProPrecio,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);

function FncProductoEscoger(InsProducto){	

	console.log("FncProductoEscoger");
	
	var ListaEscogida = "1";
	
	var ClienteId = $("#CmpClienteId").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();
	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
	var IncluyeImpuesto = $("#CmpIncluyeImpuesto").val();
	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();

	var MargenPorcentaje = $("#CmpClienteMargenUtilidad").val();	
	var FletePorcentaje = $("#CmpPorcentajeOtroCosto").val();
	var MantenimientoPorcentaje = $("#CmpPorcentajeManoObra").val();
	var DescuentoPorcentaje = $("#CmpPorcentajeDescuento").val();

	var Fecha = $("#CmpFecha").val();	
	var Seguro = $("#CmpSeguro").val();
	
	var ListaPrecio = $("input[name='CmpListaPrecio']:checked").val();
	
	var Redondear = true;
	var Incrementar = false;
	var MargenPorcentajeAux = 0;
	var PorcentajeImpuestoVentaAux = 0;
	var PorcentajePedido = 0;
	
	var TipoPedido = "NORMAL";
	
	console.log("MargenPorcentaje: "+MargenPorcentaje);
	console.log("PorcentajeImpuestoVenta: "+PorcentajeImpuestoVenta);
	
	if(MargenPorcentaje==""){
		MargenPorcentajeAux = 0;				
	}else{
		//MargenPorcentajeAux = parseFloat(MargenPorcentaje).toFixed(2);		
		MargenPorcentajeAux = parseFloat(MargenPorcentaje);		
	}
	
	if(PorcentajeImpuestoVenta==""){
		PorcentajeImpuestoVentaAux = 0;		
	}else{
		//PorcentajeImpuestoVentaAux = parseFloat(PorcentajeImpuestoVenta).toFixed(2);		
		PorcentajeImpuestoVentaAux = parseFloat(PorcentajeImpuestoVenta);		
	}
				
	if($("#CmpRedondear").is(':checked')){
		 Redondear = true;		
	}else{
		 Redondear = false;					
	}
	
	if($("#CmpIncrementar").is(':checked')){
		 Incrementar = true;		
	}else{
		 Incrementar = false;					
	}
	
	
	$('#CmpVentaDirectaDetallePorcentajeUtilidad').val(MargenPorcentaje);
	$('#CmpVentaDirectaDetallePorcentajeOtroCosto').val(FletePorcentaje);
	$('#CmpVentaDirectaDetallePorcentajeManoObra').val(MantenimientoPorcentaje);
	$('#CmpVentaDirectaDetallePorcentajeAdicional').val("0.00");
	$('#CmpVentaDirectaDetallePorcentajeDescuento').val(DescuentoPorcentaje);
	$('#CmpVentaDirectaDetallePorcentajePedido').val("0.00");
	
	if(ClienteId==""){
		
		//alert("Escoja primero un CLIENTE");
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un cliente",
			callback: function(result){
				FncVentaDirectaDetalleNuevo();
				$('#CmpClienteNombre').focus();
			}
		});
			
		//FncClienteCargarFormulario("Registrar");
/*	}else if(MargenPorcentaje == "" || MargenPorcentaje == "0.00"){
			
		alert("Defina un margen de utilidad");
		
		$('#CmpClienteMargenUtilidad').focus();
			*/
	}else{
		
			$('#CmpProductoId').val(InsProducto.ProId);
			$('#CmpProductoCantidad').val("");
			$('#CmpProductoNombre').val(InsProducto.ProNombre);
			$('#CmpProductoPrecio').val("");
			$('#CmpProductoImporte').val("");
			
			$('#CmpProductoCosto').val("");
			$('#CmpProductoCostoAux').val("");
			$("#CmpProductoValorVenta").val("");	

			$('#CmpProductoFoto').val(InsProducto.ProFoto);
			$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+InsProducto.ProEspecificacion+'">Archivo de Especificaciones<a/>');

			$('#CmpProductoTipo').val(InsProducto.RtiId);
			$('#CmpProductoUnidadMedida').val(InsProducto.UmeId);
			$('#CmpProductoUnidadMedidaIngreso').val(InsProducto.UnidadMedidaIngreso);

			$('#CmpProductoCodigoOriginal').val(InsProducto.ProCodigoOriginal);
			$('#CmpProductoCodigoAlternativo').val(InsProducto.ProCodigoAlternativo);
			
			FncProductoClienteBuscar();
			
			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProducto.RtiId+"&Tipo=2&UnidadMedidaId="+InsProducto.UmeId,{}, function(j){
				var options = '';
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(InsProducto.UmeIdSalida == j[i].UmeId){
						options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
					}else{
						options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
					}
				}
				$("select#CmpProductoUnidadMedidaConvertir").html(options);
			});
			
		
			$('#CmpVentaDirectaDetalleTipoPedido').unbind('change');
			$("select#CmpVentaDirectaDetalleTipoPedido").change(function(){

				if($(this).val() == "URGENTE"){
					$('#CmpVentaDirectaDetallePorcentajePedido').val("10.00");
					PorcentajePedido = 10;
				}else{
					$('#CmpVentaDirectaDetallePorcentajePedido').val("0.00");
					PorcentajePedido = 0;
				}				
				
					/*
					RECALCULAR IMPORTE FINAL
					*/

				FncReCalcularMostrarPrecioFinal();
			});
			
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				
				var UnidadMedidaConvertir = $(this).val();
				
				var ProductoId = InsProducto.ProId;
				var UnidadMedidaIdSalida = InsProducto.UmeIdSalida;
						
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsProducto.UmeId+"&UnidadMedida2="+UnidadMedidaConvertir,{}, 
				function(j){
					
					$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
										/*
					RECALCULAR IMPORTE FINAL
					*/
					FncReCalcularMostrarPrecioFinal();
						
				});
			
			});
			  
			console.log("UmeIdSalida: "+InsProducto.UmeIdSalida);  
			console.log("UmeId: "+InsProducto.UmeId);

			if(InsProducto.UmeIdSalida=="" || InsProducto.UmeIdSalida == null){
				alert("No se encontro UNIDAD DE MEDIDA (SALIDA), se recomienda revisar el PRODUCTO y establecer uno.");
			}
			
			if(InsProducto.UmeId=="" || InsProducto.UmeId == null ){
				alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
			}
			
			console.log("ProTieneDisponibilidadGM: "+InsProducto.ProTieneDisponibilidadGM);
			
			if(InsProducto.ProTieneDisponibilidadGM == "SI"){

				if(InsProducto.ProStockReal>0){
					$('#CmpVentaDirectaDetalleTipoPedido').val("ALMACEN");
					TipoPedido = "ALMACEN";
				}else{
					$('#CmpVentaDirectaDetalleTipoPedido').val("NORMAL");
					TipoPedido = "NORMAL";
				}			
				
			}else{
				
				if(InsProducto.ProStockReal>0){
					$('#CmpVentaDirectaDetalleTipoPedido').val("ALMACEN");
					TipoPedido = "ALMACEN";
				}else{
					$('#CmpVentaDirectaDetalleTipoPedido').val("IMPORTACION");
					TipoPedido = "IMPORTACION";
				}	
				
			}
			
			console.log("JnListaPrecio");
			console.log("EmpresaMonedaId: "+EmpresaMonedaId);
			console.log("MonedaId:" + MonedaId);
			console.log("ListaPrecio:" + ListaPrecio);
			
			var Costo = 0;
			var Precio = 0;
			var ValorVenta = 0;
			
			if(ListaPrecio=="LOCAL"){
				
				if(EmpresaMonedaId == MonedaId){
					  Costo = (InsProducto.LprCosto);
					  Precio = (InsProducto.LprPrecio);
					  ValorVenta = (InsProducto.LprValorVenta);
				}else{
					  Costo = InsProducto.LprCosto / TipoCambio;
					  Precio = InsProducto.LprPrecio / TipoCambio;
					  ValorVenta = InsProducto.LprValorVenta / TipoCambio;
				}
	
				if(Costo == 0){	
					console.log("NO TIENE PRECIO SISTEMA");
					alert("No se encontro precio en LISTA DE SISTEMA. Proceso Cancelado");
					Precio = 0;
					ValorVenta = 0;
				}else{						
					console.log("TIENE PRECIO SISTEMA");	
				}
				
				
				/*
				* ESTABLECER COSTO
				*/
				$('#CmpProductoCosto').val(Costo);
				/*
				CANTIDAD
				*/
				$('#CmpProductoCantidad').val("1");
				/*
				CALCULAR IMPORTE FINAL
				*/
				FncCalcularMostrarImporteFinal();
				
				$('#CmpProductoCantidad').select();
				
			}else{
				
				if(InsProducto.ProListaPrecioCostoReal>0 && InsProducto.ProListaPrecioCostoReal!= "" && InsProducto.ProListaPrecioCostoReal!= "0.00" && InsProducto.ProListaPrecioCostoReal!= null){
					
					console.log("TIENE PRECIO LISTA");
					console.log(InsProducto.MonIdListaPrecio+" - "+EmpresaMonedaId+" - "+MonedaId);
					
					if(MonedaId == InsProducto.MonIdListaPrecio){
						console.log("MonedaId == InsProducto.MonIdListaPrecio");
						Costo = InsProducto.ProListaPrecioCostoReal;
						
					}else if(MonedaId == EmpresaMonedaId){
						console.log("MonedaId == EmpresaMonedaId");
						Costo = InsProducto.ProListaPrecioCosto;
						
					}else{
						console.log("VACIO");
						Costo = 0;	
					}
					
					if(MargenPorcentajeAux>0){
						ValorVenta = (Costo*((MargenPorcentajeAux/100)+1))
					}
					
					if(PorcentajeImpuestoVentaAux>0){
						Precio =  (ValorVenta*((PorcentajeImpuestoVentaAux/100)+1))
					}
					
					//PrecioFinal = FncCalcularPrecioFinal(PorcentajeImpuestoVentaAux,IncluyeImpuesto,Costo,MargenPorcentajeAux,0,0,VentaDirectaDetallePorcentajePedido,0,0);
					
					/*
					* ESTABLECER COSTO
					*/
					$('#CmpProductoCosto').val(Costo);
					/*
					CANTIDAD
					*/
					$('#CmpProductoCantidad').val("1");
					/*
					CALCULAR IMPORTE FINAL
					*/
					FncCalcularMostrarImporteFinal();
					
					$('#CmpProductoCantidad').select();
					
					console.log("MargenPorcentajeAux: "+MargenPorcentajeAux);
					console.log("PorcentajeImpuestoVentaAux: "+PorcentajeImpuestoVentaAux);

					console.log("Costo: "+Costo);
					console.log("ValorVenta: "+ValorVenta);
					console.log("Precio: "+Precio);

				}else{
					console.log("NO TIENE PRECIO LISTA");
					Costo = 0;		
				}
				
			}
			
		
		$("#BtnProductoEditar").show();
		$("#BtnProductoRegistrar").hide();
	  }
  }

function FncCalcularMostrarImporteFinal(){
	
	console.log("FncCalcularMostrarImporteFinal");
		
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var ProductoCosto = $('#CmpProductoCosto').val();
	var PrecioFinal = 0;
	var ValorVentaFinal = 0;
	var DescuentoFinal = 0;
	var Importe = 0;
	
	var VentaDirectaDetallePorcentajeUtilidad = $('#CmpVentaDirectaDetallePorcentajeUtilidad').val();
	var VentaDirectaDetallePorcentajeOtroCosto = $('#CmpVentaDirectaDetallePorcentajeOtroCosto').val();
	var VentaDirectaDetallePorcentajeManoObra = $('#CmpVentaDirectaDetallePorcentajeManoObra').val();
	var VentaDirectaDetallePorcentajePedido = $('#CmpVentaDirectaDetallePorcentajePedido').val();
			
	var VentaDirectaDetallePorcentajeAdicional = $('#CmpVentaDirectaDetallePorcentajeAdicional').val();			
	var VentaDirectaDetallePorcentajeDescuento = $('#CmpVentaDirectaDetallePorcentajeDescuento').val();
	
	var Cantidad = $('#CmpProductoCantidad').val();

	//FncCalcularValorVentaFinal(oCosto,oPorcentajeUtilidad,oPorcentajeOtroCosto,oPorcentajeManoObra,oPorcentajePedido,oPorcentajeAdicional,oPorcentajeDescuento){
	ValorVentaFinal = FncCalcularValorVentaFinal(ProductoCosto,VentaDirectaDetallePorcentajeUtilidad,VentaDirectaDetallePorcentajeOtroCosto,VentaDirectaDetallePorcentajeManoObra,VentaDirectaDetallePorcentajePedido,VentaDirectaDetallePorcentajeAdicional,VentaDirectaDetallePorcentajeDescuento);

	$("#CmpVentaDirectaDetalleValorVenta").val(ValorVentaFinal);

	DescuentoFinal = FncCalcularDescuentoFinal(ValorVentaFinal,VentaDirectaDetallePorcentajeDescuento);	
	
	$("#CmpVentaDirectaDetalleDescuento").val(DescuentoFinal);
	
	ValorVentaFinal = ValorVentaFinal - DescuentoFinal;
	
	//FncCalcularPrecioFinal(oValorVenta,oIncluyeImpuesto,oPorcentajeImpuestoVenta,oRedondear)
	PrecioFinal = FncCalcularPrecioFinal(ValorVentaFinal,IncluyeImpuesto,PorcentajeImpuestoVenta,true);
	
	$("#CmpProductoPrecio").val(PrecioFinal);
	
	Importe = FncCalcularImporte(Cantidad,PrecioFinal);
	
	$("#CmpProductoImporte").val(Importe);
	
//	/*
//	* CALCULANDO BRUTO
//	*/
//	
//	ValorVentaFinal = FncCalcularValorVentaFinal(ProductoCosto,VentaDirectaDetallePorcentajeUtilidad,VentaDirectaDetallePorcentajeOtroCosto,VentaDirectaDetallePorcentajeManoObra,VentaDirectaDetallePorcentajePedido,0,0);
//
//	$("#CmpVentaDirectaDetalleValorVenta").val(ValorVentaFinal);
//
//	DescuentoFinal = FncCalcularDescuentoFinal(ValorVentaFinal,VentaDirectaDetallePorcentajeDescuento);	
//	
//	$("#CmpVentaDirectaDetalleDescuento").val(DescuentoFinal);
//	
//	ValorVentaFinal = ValorVentaFinal - DescuentoFinal;
//	
//	//FncCalcularPrecioFinal(oValorVenta,oIncluyeImpuesto,oPorcentajeImpuestoVenta,oRedondear)
//	PrecioFinal = FncCalcularPrecioFinal(ValorVentaFinal,IncluyeImpuesto,PorcentajeImpuestoVenta,true);
//	
//	$("#CmpProductoPrecio").val(PrecioFinal);
//	
//	Importe = FncCalcularImporte(Cantidad,PrecioFinal);
//	
//	$("#CmpProductoImporte").val(Importe);
//	
	
	
}


function FncReCalcularMostrarPrecioFinal(){
	
	console.log("FncReCalcularMostrarPrecioFinal");
	
		var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var ProductoCosto = $('#CmpProductoCosto').val();
	var PrecioFinal = 0;
	var ValorVentaFinal = 0;
	var DescuentoFinal = 0;
	var Importe = 0;
	
	var VentaDirectaDetallePorcentajeUtilidad = $('#CmpVentaDirectaDetallePorcentajeUtilidad').val();
	var VentaDirectaDetallePorcentajeOtroCosto = $('#CmpVentaDirectaDetallePorcentajeOtroCosto').val();
	var VentaDirectaDetallePorcentajeManoObra = $('#CmpVentaDirectaDetallePorcentajeManoObra').val();
	var VentaDirectaDetallePorcentajePedido = $('#CmpVentaDirectaDetallePorcentajePedido').val();
			
	var VentaDirectaDetallePorcentajeAdicional = $('#CmpVentaDirectaDetallePorcentajeAdicional').val();			
	var VentaDirectaDetallePorcentajeDescuento = $('#CmpVentaDirectaDetallePorcentajeDescuento').val();
	
	var Cantidad = $('#CmpProductoCantidad').val();

	//FncCalcularValorVentaFinal(oCosto,oPorcentajeUtilidad,oPorcentajeOtroCosto,oPorcentajeManoObra,oPorcentajePedido,oPorcentajeAdicional,oPorcentajeDescuento){
	ValorVentaFinal = FncCalcularValorVentaFinal(ProductoCosto,VentaDirectaDetallePorcentajeUtilidad,VentaDirectaDetallePorcentajeOtroCosto,VentaDirectaDetallePorcentajeManoObra,VentaDirectaDetallePorcentajePedido,VentaDirectaDetallePorcentajeAdicional,VentaDirectaDetallePorcentajeDescuento);

	$("#CmpVentaDirectaDetalleValorVenta").val(ValorVentaFinal);

	DescuentoFinal = FncCalcularDescuentoFinal(ValorVentaFinal,VentaDirectaDetallePorcentajeDescuento);	
	
	$("#CmpVentaDirectaDetalleDescuento").val(DescuentoFinal);
	
	ValorVentaFinal = ValorVentaFinal - DescuentoFinal;
	
	//FncCalcularPrecioFinal(oValorVenta,oIncluyeImpuesto,oPorcentajeImpuestoVenta,oRedondear)
	PrecioFinal = FncCalcularPrecioFinal(ValorVentaFinal,IncluyeImpuesto,PorcentajeImpuestoVenta,true);
	
	$("#CmpProductoPrecio").val(PrecioFinal);
	
	Importe = FncCalcularImporte(Cantidad,PrecioFinal);
	
	$("#CmpProductoImporte").val(Importe);
	
}
//
//function FncCalcularMostrarPrecioFinal(){
//	
//	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
//	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
//	var ProductoCosto = $('#CmpProductoCosto').val();
//	var PrecioFinal = 0;
//	var Importe = 0;
//	
//	var VentaDirectaDetallePorcentajeUtilidad = $('#CmpVentaDirectaDetallePorcentajeUtilidad').val();
//	var VentaDirectaDetallePorcentajeOtroCosto = $('#CmpVentaDirectaDetallePorcentajeOtroCosto').val();
//	var VentaDirectaDetallePorcentajeManoObra = $('#CmpVentaDirectaDetallePorcentajeManoObra').val();
//	var VentaDirectaDetallePorcentajePedido = $('#CmpVentaDirectaDetallePorcentajePedido').val();
//			
//	var VentaDirectaDetallePorcentajeAdicional = $('#CmpVentaDirectaDetallePorcentajeAdicional').val();			
//	var VentaDirectaDetallePorcentajeDescuento = $('#CmpVentaDirectaDetallePorcentajeDescuento').val();
//	
//	var Cantidad = $('#CmpProductoCantidad').val();
//
//	PrecioFinal = FncCalcularPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ProductoCosto,VentaDirectaDetallePorcentajeUtilidad,VentaDirectaDetallePorcentajeOtroCosto,VentaDirectaDetallePorcentajeManoObra,VentaDirectaDetallePorcentajePedido,VentaDirectaDetallePorcentajeAdicional,VentaDirectaDetallePorcentajeDescuento);
//	
//	$("#CmpProductoPrecio").val(PrecioFinal);
//	
//	Importe = FncCalcularImporte(Cantidad,PrecioFinal);
//	
//	$("#CmpProductoImporte").val(Importe);
//	
//}


function FncCalcularPrecioFinal(oValorVenta,oIncluyeImpuesto,oPorcentajeImpuestoVenta,oRedondear){
	
	console.log("FncCalcularPrecioFinal");
	
	var Precio = 0;
	var ValorVenta = 0;
	var Importe = 0;
	
	var ValorVenta = oValorVenta;
	var Descuento = 0;

	if(oIncluyeImpuesto == 1){
		Precio = (ValorVenta * 1) * (((oPorcentajeImpuestoVenta * 1)/100)+1);
	}else{
		Precio = ValorVenta;
	}

	Precio = Math.round(Precio*100)/100;

	if(oRedondear){
		Precio = Math.ceil(Precio);
	}else{
		Precio = Precio.toFixed(2);
	}
	
//	Importe = (Precio * 1) * (oCantidad * 1);	
	return Precio;

}


function FncCalcularValorVentaFinal(oCosto,oPorcentajeUtilidad,oPorcentajeOtroCosto,oPorcentajeManoObra,oPorcentajePedido,oPorcentajeAdicional,oPorcentajeDescuento){
	
	console.log("FncCalcularValorVentaFinal");
	console.log("oCosto: "+oCosto);
	console.log("oPorcentajeUtilidad: "+oPorcentajeUtilidad);
	console.log("oPorcentajeOtroCosto: "+oPorcentajeOtroCosto);
	console.log("oPorcentajeManoObra: "+oPorcentajeManoObra);
	console.log("oPorcentajePedido: "+oPorcentajePedido);
	console.log("oPorcentajeAdicional: "+oPorcentajeAdicional);
	console.log("oPorcentajeDescuento: "+oPorcentajeDescuento);
	
	var Precio = 0;
	var ValorVenta = 0;
	var Importe = 0;
	
	var ValorVenta = oCosto;
	var Descuento = 0;

	if(oPorcentajeUtilidad !=0 && oPorcentajeUtilidad != ""){	
		ValorVenta = (ValorVenta * 1) * (((oPorcentajeUtilidad * 1)/100)+1);
	}
	
	if(oPorcentajeOtroCosto !=0 && oPorcentajeOtroCosto != ""){	
		ValorVenta = (ValorVenta * 1) * (((oPorcentajeOtroCosto * 1)/100)+1);
	}
	
	if(oPorcentajeManoObra !=0 && oPorcentajeManoObra != ""){	
		ValorVenta = (ValorVenta * 1) * (((oPorcentajeManoObra * 1)/100)+1);
	}
	
	if(oPorcentajePedido !=0 && oPorcentajePedido != ""){	
		ValorVenta = (ValorVenta * 1) * (((oPorcentajePedido * 1)/100)+1);
	}	
	
	if(oPorcentajeAdicional !=0 && oPorcentajeAdicional != ""){	
		ValorVenta = (ValorVenta * 1) * (((oPorcentajeAdicional * 1)/100)+1);
	}	
	
	//if(oPorcentajeDescuento !=0 && oPorcentajeDescuento != ""){	
	//	Descuento = (ValorVenta * 1) * (((oPorcentajeDescuento * 1)/100));
	//}	

	//ValorVenta = ValorVenta - Descuento;
	
	ValorVenta = Math.round(ValorVenta*100)/100;
	
	return ValorVenta;

}


function FncCalcularDescuentoFinal(oValorVenta,oPorcentajeDescuento){
	
	console.log("FncCalcularDescuentoFinal");
	console.log("oPorcentajeDescuento: "+oPorcentajeDescuento);
	console.log("oValorVenta: "+oValorVenta);
	
	var Precio = 0;
	var ValorVenta = 0;
	var Importe = 0;
	
	var ValorVenta = oValorVenta;
	var Descuento = 0;

	if(oPorcentajeDescuento !=0 && oPorcentajeDescuento != ""){	
		Descuento = (ValorVenta * 1) * (((oPorcentajeDescuento * 1)/100));
	}	

	Descuento = Math.round(Descuento*100)/100;
	
	return Descuento;
	
}




/*
* CALCULOS DETALLE GENERAL
*/

function FncCalcularImporte(oCantidad,oPrecio){
	
	console.log("FncCalcularImporte");
	
	var Precio = 0;
	var Cantidad = 0;
	var Importe = 0;
	
	Precio = oPrecio;
	Cantidad = oCantidad;
	
	Importe = (Precio * 1) * (Cantidad * 1);
	
	return Importe;

}


function FncCalcularPrecio(oCantidad,oImporte){//NO DEBE USARSE
	
	console.log("FncCalcularPrecio");
	
	var Precio = 0;
	var Cantidad = 0;
	var Importe = 0;
	
	Importe = oImporte;
	Cantidad = oCantidad;
	
	Precio = (Importe * 1) / (Cantidad * 1);
	
	return Precio;

}

/*
* DETALLE
*/
function FncCalcularMostrarImporte(){

	console.log("FncCalcularMostrarImporte");
	
	var Precio = $('#CmpProductoPrecio').val();
	var Cantidad = $('#CmpProductoCantidad').val();
	var Importe = 0;
		
	if(Precio == ""){
		$('#CmpProductoPrecio').focus();
			
	}else if(Precio=="0.00"){
		$('#CmpProductoPrecio').select();	
		
	}else if(Precio=="0"){
		$('#CmpProductoPrecio').select();	
		
	}else if(Cantidad == ""){
		$('#CmpProductoCantidad').focus();
		
	}else if(Cantidad == "0"){
		$('#CmpProductoPrecio').select();
		
	}else if(Cantidad == "0.00"){		
		$('#CmpProductoPrecio').select();
	}else{
		
		Importe = (Precio * 1) * (Cantidad * 1);
		Importe = Math.round(Importe*100)/100;
		
		$('#CmpProductoImporte').val(Importe);
		//$('#CmpProductoCantidad').select();
	}
	
	
}

function FncCalcularMostrarPrecio(){//NO DEBE USARSE
		
	var Precio = 0;
	var Cantidad = $('#CmpProductoCantidad').val();
	var Importe = $('#CmpProductoCantidad').val();

	Precio = FncCalcularPrecio(Cantidad,Precio);
	
	$("#CmpProductoPrecio").val(Precio);
	
}





/*
* FORMULARIOS
*/


function FncProductoReemplazoCargar(oProductoCodigoOriginal){

	tb_show('','formularios/VentaDirecta/DiaProductoReemplazoBuscar.php?ProductoCodigoOriginal='+oProductoCodigoOriginal+
'&placeValuesBeforeTB_=savedValues','');	
  
}


function FncProductoConsultarCargar(oProductoId){

	tb_show('','formularios/Producto/DiaProductoConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}

function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}


/*
* VISTA PRELIMINAR
*/

function FncVentaConcretadaVistaPreliminar(oId){
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncTallerPedidoVistaPreliminar(oId){
	FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncAlmacenMovimientoEntradaVistaPreliminar(oId){
	FncPopUp('formularios/AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncOrdenCompraVistaPreliminar(oId){
	FncPopUp('formularios/OrdenCompra/FrmOrdenCompraImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}



function FncFacturaVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncFacturaGenerarPDF(oId,oTalonario){
	FncPopUp('formularios/Factura/FrmFacturaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncBoletaVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncBoletaGenerarPDF(oId,oTalonario){
	FncPopUp('formularios/Boleta/FrmBoletaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncFichaIngresoVistaPreliminar(oId){
				
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}




