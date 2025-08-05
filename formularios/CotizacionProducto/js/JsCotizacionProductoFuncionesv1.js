// JavaScript Document

function FncGuardar(){
	
	//HACK
	$("#CmpEstado").removeAttr('disabled');
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	
	//FncClienteCargarFormulario("Registrar");

	//var ClienteId = $("#CmpClienteId").val();
//	
//	if(ClienteId==""){
//		
//		alert("Se ha detectado que el cliente ha sido registrado");
//		
//		var ClienteNombre = $("#CmpClienteNombre").val();
//		var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
//		var ClienteDireccion = $("#CmpClienteDireccion").val();
//		var ClienteCelular = $("#CmpClienteCelular").val();
//		var ClienteEmail = $("#CmpClienteEmail").val();
//		var TipoDocumentoId = $("#CmpClienteTipoDocumento").val();
//		var ClienteTipoId = $("#CmpClienteTipo").val();
//		  
//		tb_show(this.title,'principal2.php?Mod=Cliente&Form=Registrar&Dia=1&ClienteNombre='+ClienteNombre+'&TipoDocumentoId='+TipoDocumentoId+'&ClienteNumeroDocumento='+ClienteNumeroDocumento+'&ClienteDireccion='+ClienteDireccion+'&ClienteCelular='+ClienteCelular+'&ClienteEmail='+ClienteEmail+'&ClienteTipoId='+ClienteTipoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	
//		
//	}
	
		
	
}


var FormularioCampos = [


"CmpClienteNombre",
"CmpClienteNumeroDocumento",

"CmpRepresentante",
"CmpClienteTipo",
"CmpSeguro",
"CmpAsegurado",

"CmpVehiculoIngresoVIN",
"CmpVehiculoIngresoMarca",
"CmpVehiculoIngresoModelo",
"CmpVehiculoIngresoPlaca",
"CmpVehiculoIngresoAnoModelo",

"CmpFecha",
"CmpPersonal",
"CmpMonedaId",
"CmpIncluyeImpuesto",


"CmpVigencia",
"CmpTiempoEntrega",

"CmpManoObra",
"CmpPorcentajeDescuento",

"CmpObservacion",

"CmpProductoCodigoOriginal",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
//"CmpCotizacionProductoDetalleTipoPedido",
"CmpProductoCantidad",
"CmpProductoImporte",
"CmpCotizacionProductoPlanchadoDescripcion",
"CmpCotizacionProductoPlanchadoImporte",
"CmpCotizacionProductoPintadoDescripcion",
"CmpCotizacionProductoPintadoImporte",
"CmpCotizacionProductoCentradoDescripcion",
"CmpCotizacionProductoCentradoImporte",
"CmpCotizacionProductoTareaDescripcion",
"CmpCotizacionProductoTareaImporte"];

$().ready(function() {

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncCotizacionProductoNavegar(this.id);
		 }
	}); 

	$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 

	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 

/*
Agregando Eventos
*/

	$("select#CmpMonedaId").change(function(){
		FncCotizacionProductoEstablecerMoneda();
	});



	//$("select#CmpClienteTipo").change(function(){
//		FncCotizacionProductoDetalleActualizarPrecio();
//	});
//	
//	$("#CmpManoObra").keyup(function(){
//		FncCotizacionProductoDetalleListar();
//	});
//	
//	$("#CmpClienteMargenUtilidad").keyup(function(){
//		FncCotizacionProductoDetalleListar();
//	});
//	
//	$("#CmpPorcentajeDescuento").keyup(function(){
//		FncCotizacionProductoDetalleListar();
//	});
	
	$("#CmpCotizacionProductoDetalleMargenPorcentaje").keyup(function(){
		FncReCalcularMostrarPrecioFinal();
	});
	
	$("#CmpCotizacionProductoDetalleFletePorcentaje").keyup(function(){
		FncReCalcularMostrarPrecioFinal();
	});
	
	$("#CmpCotizacionProductoDetalleMantenimientoPorcentaje").keyup(function(){
		FncReCalcularMostrarPrecioFinal();
	});
	
	$("#CmpCotizacionProductoDetalleDescuentoPorcentaje").keyup(function(){
		FncReCalcularMostrarPrecioFinal();
	});
	
	
	

});
	
function FncCotizacionProductoNavegar(oCampo){
	
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
		FncCotizacionProductoDetalleGuardar();
	}
	
	
	
	if("CmpCotizacionProductoPlanchadoImporte"==oCampo){
		$('#CmpCotizacionProductoPlanchadoImporte').blur();
		FncCotizacionProductoPlanchadoGuardar();
	}
	
	if("CmpCotizacionProductoPintadoImporte"==oCampo){
		$('#CmpCotizacionProductoPintadoImporte').blur();
		FncCotizacionProductoPintadoGuardar();
	}


	if("CmpCotizacionProductoCentradoImporte"==oCampo){
		$('#CmpCotizacionProductoCentradoImporte').blur();
		FncCotizacionProductoCentradoGuardar();
	}

	if("CmpCotizacionProductoTareaImporte"==oCampo){
		$('#CmpCotizacionProductoTareaImporte').blur();
		FncCotizacionProductoTareaGuardar();
	}

}

/*
* FUNCIONES -AUXILIARES
*/
function FncCotizacionProductoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncCotizacionProductoDetalleListar();
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


/*
* FUNCIONES COMUNES
*/
function FncVehiculoIngresoSimpleFuncion(){
	
//	var ClienteId = $("#CmpVehiculoIngresoClienteId").val();
//	$("#CmpClienteId").val(ClienteId);
//	FncClienteBuscar('Id');

}

function FncClienteFuncion(){
	
	var VehiculoIngresoId = $("#CmpClienteVehiculoIngresoId").val();
	
	$("#CmpVehiculoIngresoId").val(VehiculoIngresoId);

	FncVehiculoIngresoSimpleBuscar('Id');

}

function FncMonedaFuncion(){
	
	FncCotizacionProductoDetalleListar();
	
	FncCotizacionProductoPlanchadoListar();
	FncCotizacionProductoPintadoListar();
	FncCotizacionProductoCentradoListar();
	FncCotizacionProductoTareaListar();
	
	FncCotizacionProductoTotalListar();
	

}


function FncVehiculoIngresoSimpleFormularioFuncion(){
	
	FncVehiculoIngresoSimpleBuscar("Id");

}



/*
* FUNCIONES IMPRESION
*/

function FncImprmir(oId){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Cotizacion c/ Codigo) \n 2 = Formato 2 (Cotizacion s/ Codigo) \n 3 = Formato 3 (Cotizacion c/ Tipo Pedido)", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&P=1&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&P=1+ImprimirCodigo=1&ImprimirPedido=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}
			

}


function FncVistaPreliminar(oId){
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Cotizacion c/ Codigo) \n 2 = Formato 2 (Cotizacion s/ Codigo) \n 3 = Formato 3 (Cotizacion c/ Tipo Pedido)", "1");	
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&ImprimirCodigo=1&ImprimirPedido=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}
		

}

/*****************************************************************************/

$().ready(function() {

	$("#CmpProductoImporte").keyup(function (event) {  
		FncProductoCalcularMonto("Precio")
	});
	
	$("#CmpProductoCantidad").keyup(function (event) {  
		FncProductoCalcularImporte("Precio")
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

	var ListaEscogida = "1";
	
	var ClienteId = $("#CmpClienteId").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();
	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
	var IncluyeImpuesto = $("#CmpIncluyeImpuesto").val();
	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
	
	var MargenPorcentaje = $("#CmpClienteMargenUtilidad").val();	
	var FletePorcentaje = $("#CmpFletePorcentaje").val();
	var MantenimientoPorcentaje = $("#CmpMantenimientoPorcentaje").val();
	var DescuentoPorcentaje = $("#CmpPorcentajeDescuento").val();
	
	var Fecha = $("#CmpFecha").val();
	
	if($("#CmpRedondear").is(':checked')){
		var Redondear = true;		
	}else{
		var Redondear = false;					
	}

	if(ClienteId==""){
		
		alert("Escoja primero un CLIENTE");
		FncCotizacionProductoDetalleNuevo();
		$('#CmpClienteNombre').focus();
			
		//FncClienteCargarFormulario("Registrar");
	}else if(MargenPorcentaje == "" || MargenPorcentaje == "0.00"){
			
		alert("Defina un margen de utilidad");
		
		$('#CmpClienteMargenUtilidad').focus();
			
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

			$('#CmpCotizacionProductoDetalleMargenPorcentaje').val(MargenPorcentaje);
			$('#CmpCotizacionProductoDetalleFletePorcentaje').val(FletePorcentaje);
			$('#CmpCotizacionProductoDetalleMantenimientoPorcentaje').val(MantenimientoPorcentaje);
			$('#CmpCotizacionProductoDetalleDescuentoPorcentaje').val(DescuentoPorcentaje);

			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProducto.RtiId+"&Tipo="+UnidadMedidaTipo+"&UnidadMedidaId="+InsProducto.UmeId,{}, function(j){
				var options = '';
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(InsProducto.UmeIdIngreso == j[i].UmeId){
						options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
					}else{
						options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
					}
				}
				$("select#CmpProductoUnidadMedidaConvertir").html(options);
			});

			$('#CmpCotizacionProductoDetalleTipoPedido').unbind('change');
			$("select#CmpCotizacionProductoDetalleTipoPedido").change(function(){

				FncReCalcularMostrarPrecioFinal();
				

			});
			  
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
			
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsProducto.UmeId+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
					
					$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
					FncReCalcularMostrarPrecioFinal();

				})
			
			});
			  
			if(InsProducto.UmeIdIngreso=="" || InsProducto.UmeIdIngreso == null){
				alert("No se encontro UNIDAD DE MEDIDA (INGRESO), se recomienda revisar el PRODUCTO y establecer uno.");
			}
			
			if(InsProducto.UmeId=="" || InsProducto.UmeId == null ){
				alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
			}
			
			if(InsProducto.ProTieneDisponibilidadGM == "1"){

				if(InsProducto.ProStockReal>0){
					$('#CmpCotizacionProductoDetalleTipoPedido').val("ALMACEN");
				}else{
					$('#CmpCotizacionProductoDetalleTipoPedido').val("NORMAL");
				}			
				
			}else{
				$('#CmpCotizacionProductoDetalleTipoPedido').val("IMPORTACION");
			}
						
			var Precio = 0;
			var Costo = 0;
			var ValorVenta = 0;					
			var TipoPedido = $('#CmpCotizacionProductoDetalleTipoPedido').val();
			
			if(InsProducto.ProListaPromocionCostoReal>0 && InsProducto.ProListaPromocionCostoReal!= "" && InsProducto.ProListaPromocionCostoReal!= "0.00" && InsProducto.ProListaPromocionCostoReal!= null){
				
				console.log("TIENE PROMOCION");
				if(confirm("¿El producto tiene precio de promocion desea aplicarlo?")){
					
					console.log("SE ACEPTO PROMOCION");
					
					if(MonedaId == InsProducto.MonIdListaPromocion){				
						Costo = InsProducto.ProListaPromocionCostoReal;
						
					}else if(MonedaId == EmpresaMonedaId){						
						Costo = InsProducto.ProListaPromocionCosto;// /TIPOCAMBIO (REVISAR MAS ADELANTE)
						
					}else{
						Costo = 0;	
					}

				}else{
					
					console.log("SE NEGO PROMOCION");
					
					if(InsProducto.ProListaPrecioCostoReal>0 && InsProducto.ProListaPrecioCostoReal!= "" && InsProducto.ProListaPrecioCostoReal!= "0.00" && InsProducto.ProListaPrecioCostoReal!= null){
						
						console.log("TIENE PRECIO LISTA");
					
						if(MonedaId == InsProducto.MonIdListaPrecio){
					
							Costo = InsProducto.ProListaPrecioCostoReal;
							
						}else if(MonedaId == EmpresaMonedaId){
							
							Costo = InsProducto.ProListaPrecioCosto;
							
						}else{
							Costo = 0;	
						}
						
					}else{
						console.log("NO TIENE PRECIO LISTA");
						//Costo = 0;		
					}
					
				}
				
			}else{
				
				console.log("NO TIENE PROMOCION");
				
				if(InsProducto.ProListaPrecioCostoReal>0 && InsProducto.ProListaPrecioCostoReal!= "" && InsProducto.ProListaPrecioCostoReal!= "0.00" && InsProducto.ProListaPrecioCostoReal!= null){
					
					console.log("TIENE PRECIO LISTA");
					console.log(InsProducto.MonIdListaPrecio+" - "+EmpresaMonedaId+" - "+MonedaId);
					
					if(MonedaId == InsProducto.MonIdListaPrecio){
						//console.log("A");
						Costo = InsProducto.ProListaPrecioCostoReal;
						
					}else if(MonedaId == EmpresaMonedaId){
						//console.log("B");
						Costo = InsProducto.ProListaPrecioCosto;
						
					}else{
						//console.log("C");
						Costo = 0;	
					}
					
					console.log(Costo);

				}else{
					console.log("NO TIENE PRECIO LISTA");
					Costo = 0;		
				}

			}
			
			//alert(Costo);
			if(Costo == 0){

				if(confirm("No se encontro precio en LISTA DE PROVEEDOR ¿Desea consultar precio en LISTA DE SISTEMA ?")){
				
////					$('#CmpCotizacionProductoDetalleMargenPorcentaje').val("0");
//					$('#CmpCotizacionProductoDetalleFletePorcentaje').val("0");
//					$('#CmpCotizacionProductoDetalleMantenimientoPorcentaje').val("0");
//					$('#CmpCotizacionProductoDetalleDescuentoPorcentaje').val("0");
						
						
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
						Costo = 0;
						Precio = 0;
					}else{						
						console.log("TIENE PRECIO SISTEMA");	
						
						
					}

					$("#CmpProductoPrecio").val(Precio);

				}else{
					$("#CmpProductoPrecio").val("0");	
				}
				
			}else{
				
				var ValorFinal = FncCalcularMostrarValorFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,MargenPorcentaje,TipoPedido,FletePorcentaje,MantenimientoPorcentaje,DescuentoPorcentaje,Costo,Redondear,"1");
				
				var PrecioFinal = FncCalcularMostrarPrecioFinal(ValorFinal,DescuentoPorcentaje,PorcentajeImpuestoVenta,Redondear);
				
				$("#CmpCotizacionProductoDetalleValorVenta").val(ValorFinal);
				$("#CmpProductoPrecio").val(PrecioFinal);					
				
			}
					
		Costo = Math.round(Costo*100)/100;			
					
		$("#CmpProductoCosto").val(Costo);	
				
		FncCalcularMostrarImporte();
		 
		 
		 if(InsProducto.ProCalcularPrecio=="1"){
			 
			 $("#CmpProductoPrecio").removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
			 $("#CmpProductoImporte").removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
			 $('#CmpProductoPrecio').removeAttr('readonly');
			 $('#CmpProductoImporte').removeAttr('readonly');
		 }else{
			 
			 $("#CmpProductoPrecio").removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
			 $("#CmpProductoImporte").removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
			 $('#CmpProductoPrecio').attr('readonly', true);
			 $('#CmpProductoImporte').attr('readonly', true);
			
		 }
		 
		$('#CmpCotizacionProductoDetalleMargenPorcentaje').removeAttr('readonly');
		$('#CmpCotizacionProductoDetalleFletePorcentaje').removeAttr('readonly');
		$('#CmpCotizacionProductoDetalleMantenimientoPorcentaje').removeAttr('readonly');
		$('#CmpCotizacionProductoDetalleDescuentoPorcentaje').removeAttr('readonly');
		 
		 //$('#CmpProductoCantidad').select();
		
		 
		$("#BtnProductoEditar").show();
		$("#BtnProductoRegistrar").hide();
	  }
  }


function FncEstablecerUnidadMedidaConversionCosto(){
	
	
}


function FncCalcularMostrarValorFinal(oPorcentajeImpuestoVenta,oIncluyeImpuesto,oClienteMargenUtilidad,oTipoPedido,oFlete,oMantenimiento,oDescuento,oCosto,oRedondear,oEquivalente){
	
	var Precio = 0;
	var ValorVenta = 0;
	var Importe = 0;

	var NuevoCosto = oCosto*oEquivalente;
	
	if(oTipoPedido == "IMPORTACION"){
		//NuevoCosto = (NuevoCosto * 1) + ( NuevoCosto * (0.15));
	}

	if(oTipoPedido == "URGENTE"){
		NuevoCosto = (NuevoCosto * 1) + ( NuevoCosto * (0.10));
	}
	
	if(oFlete !=0 && oFlete != ""){	
		NuevoCosto = (NuevoCosto * 1) + (NuevoCosto*((oFlete * 1)/100));
		//console.Log("a");
	}
	
	if(oClienteMargenUtilidad !=0 && oClienteMargenUtilidad != ""){	
		NuevoCosto = ( NuevoCosto*1 ) + ( ( NuevoCosto*1 ) * ( ( oClienteMargenUtilidad * 1 )/100));
		//ValorVenta = Precio;
		//console.Log("b");
	}
	
	if(oMantenimiento !=0 && oMantenimiento != ""){	
		NuevoCosto = (NuevoCosto * 1) + (NuevoCosto*((oMantenimiento * 1)/100));
	}
	
//	if(oDescuento !=0 && oDescuento != ""){	
//		NuevoCosto = (NuevoCosto * 1) - (NuevoCosto*((oDescuento * 1)/100));
//	}
	
	
	//if(oIncluyeImpuesto == 1){
//		Precio = (NuevoCosto * 1) + ( (NuevoCosto * 1) * ( (oPorcentajeImpuestoVenta * 1)/100)) ;
//	}else{
//		Precio = NuevoCosto;
//	}

	ValorVenta = NuevoCosto;	
	ValorVenta = Math.round(ValorVenta*100)/100;
	
	//if(oRedondear){
//		ValorVenta = Math.ceil(ValorVenta);
//	}else{
//		ValorVenta = ValorVenta.toFixed(2);
//	}
	
	return ValorVenta;

}

function FncCalcularMostrarPrecioFinal(oValorVenta,oDescuentoPorcenaje,oPorcentajeImpuestoVenta,oRedondear){
	
	var PrecioFinal = 0;
	var ValorVenta = 0;

	PrecioFinal = (oValorVenta * 1) + ( (oValorVenta * 1) * ( (oPorcentajeImpuestoVenta * 1)/100)) ;

	if(oDescuentoPorcenaje !=0 && oDescuentoPorcenaje != ""){	
		PrecioFinal = (PrecioFinal * 1) - (PrecioFinal*((oDescuentoPorcenaje * 1)/100));
	}

	PrecioFinal = Math.round(PrecioFinal*100)/100;
	
	if(oRedondear){
		PrecioFinal = Math.ceil(PrecioFinal);
	}else{
		PrecioFinal = PrecioFinal.toFixed(2);
	}
	
	return PrecioFinal;

}



function FncCalcularMostrarImporte(){

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


function FncReCalcularMostrarPrecioFinal(){
	
	var ClienteId = $("#CmpClienteId").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();
	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
	var IncluyeImpuesto = $("#CmpIncluyeImpuesto").val();
	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
	
	var TipoPedido = $('#CmpCotizacionProductoDetalleTipoPedido').val();
	var MargenPorcentaje = $("#CmpCotizacionProductoDetalleMargenPorcentaje").val();	
	var FletePorcentaje = $("#CmpCotizacionProductoDetalleFletePorcentaje").val();
	var MantenimientoPorcentaje = $("#CmpCotizacionProductoDetalleMantenimientoPorcentaje").val();
	var DescuentoPorcentaje = $("#CmpCotizacionProductoDetalleDescuentoPorcentaje").val();
	
	var ProductoUnidadMedidaEquivalente = $("#CmpProductoUnidadMedidaEquivalente").val();
	
	var Costo = $('#CmpProductoCosto').val();
	
	if(ProductoUnidadMedidaEquivalente==""){
		ProductoUnidadMedidaEquivalente = "1";
	}
	
	if($("#CmpRedondear").is(':checked')){
		var Redondear = true;		
	}else{
		var Redondear = false;					
	}

	var ValorFinal = FncCalcularMostrarValorFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,MargenPorcentaje,TipoPedido,FletePorcentaje,MantenimientoPorcentaje,DescuentoPorcentaje,Costo,Redondear,ProductoUnidadMedidaEquivalente);

	var PrecioFinal = FncCalcularMostrarPrecioFinal(ValorFinal,DescuentoPorcentaje,PorcentajeImpuestoVenta,Redondear);
				
	$("#CmpCotizacionProductoDetalleValorVenta").val(ValorFinal);
	$("#CmpProductoPrecio").val(PrecioFinal);		
				
	FncCalcularMostrarImporte();
	
}


//
//function FncProductoBuscar(oCampo){
//	
//	var Dato = $('#CmpProducto'+oCampo).val()
//	var ClienteTipo = $("#CmpClienteTipo").val();
//	
//	if(Dato!=""){
//	
//	var ProductoLector = $('#CmpProductoLector:checked').val();
//	
//	if(ProductoLector=="1"){
//	
//			$.ajax({
//				type: 'POST',
//				dataType: 'json',
//				url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
//				data: 'Campo='+oCampo+'&Dato='+Dato,
//				success: function(InsProducto){
//
//						if(InsProducto.ProId!="" & InsProducto.ProId!=null){
//
//							FncProductoEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);
//
//							var ProductoNombre = $('#CmpProductoNombre').val();
//
//							if(ProductoNombre!="undefined" & ProductoNombre!=""){
//								$('#CmpProductoCantidad').val(1);
//								$('#CmpProductoImporte').val(InsProducto.ProPrecio*1);
//								//eval(ProductoFuncion+"Guardar();");
//							}
//
//						}else{
//							$('#CmpProducto'+oCampo).focus();
//							$('#CmpProducto'+oCampo).select();											
//						}
//					
//				}
//			});
//			
//
//	}else{
//		
//		$.ajax({
//			type: 'POST',
//			dataType: 'json',
//			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
//			data: 'Campo='+oCampo+'&Dato='+Dato+'&ClienteTipo='+ClienteTipo,
//			success: function(InsProducto){
//
//				if(InsProducto.ProId!="" & InsProducto.ProId!=null){
//
//					FncProductoEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);
//
//				}else{
//					$('#CmpProducto'+oCampo).focus();
//					$('#CmpProducto'+oCampo).select();						
//				}
//				
//			}
//		});
//		
//
//	}
//
//}
//
//}
//




function FncProductoReemplazoCargar(oProductoCodigoOriginal){

	tb_show('','formularios/CotizacionProducto/DiaProductoReemplazoBuscar.php?ProductoCodigoOriginal='+oProductoCodigoOriginal+
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
