// JavaScript Document

function FncGuardar(){
	
	//HACK
	$("#CmpEstado").removeAttr('disabled');
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	
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
	
	$("#CmpManoObra").keyup(function(){
		FncCotizacionProductoDetalleListar();
	});
	
	/*$("#CmpClienteMargenUtilidad").keyup(function(){
		FncCotizacionProductoDetalleListar();
	});*/
	
	$("#CmpPorcentajeDescuento").keyup(function(){
		FncCotizacionProductoDetalleListar();
	});
	
	//$("#CmpCotizacionProductoDetallePorcentajeUtilidad").keyup(function(){
//		FncReCalcularMostrarPrecioFinal();
//	});
//	
//	$("#CmpCotizacionProductoDetallePorcentajeOtroCosto").keyup(function(){
//		FncReCalcularMostrarPrecioFinal();
//	});
//	
//	$("#CmpCotizacionProductoDetallePorcentajeAdicional").keyup(function(){
//		FncReCalcularMostrarPrecioFinal();
//	});
//	
//	$("#CmpCotizacionProductoDetallePorcentajeDescuento").keyup(function(){
//		FncReCalcularMostrarPrecioFinal();
//	});
	
	//$("#CmpTieneMantenimiento").click(function(){
//		
//		if($(this).is(':checked')){
//			$('#CmpPorcentajeManoObra').val(EmpresaMantenimientoPorcentajeManoObra);
//		}else{
//			$('#CmpPorcentajeManoObra').val(0);
//		}
//			
//	});



/*	$("#BtnMantenimientoVerificar").click(function(){
	
		dhtmlx.confirm("¿Desea aplicar el margen adicional por mantenimiento?", function(result){
			if(result==true){
				
				$('#CmpPorcentajeManoObra').val(EmpresaMantenimientoPorcentajeManoObra);
								
			}else{
				$('#CmpPorcentajeManoObra').val(0);
			}
		});

	});*/


	$("#CmpClienteTipo").change(function(){
		FncCotizacionProductoEstablecerClienteTipo();
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
				FncTipoCambioCargar(MonedaId,Fecha,"Comercial");				
			}
		}
		FncMonedaBuscar('Id');

	}

}


function FncCotizacionProductoEstablecerClienteTipo(){

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
function FncVehiculoIngresoFuncion(){
	
//	var ClienteId = $("#CmpVehiculoIngresoClienteId").val();
//	$("#CmpClienteId").val(ClienteId);
//	FncClienteBuscar('Id');

}

function FncClienteFuncion(InsCliente){
	
	var VehiculoIngresoId = $("#CmpClienteVehiculoIngresoId").val();
	
	$("#CmpVehiculoIngresoId").val(VehiculoIngresoId);

	FncVehiculoIngresoBuscar('Id');
	
	FncClienteNotaVerificar();
	
	
	$('#CmpPorcentajeOtroCosto').val(InsCliente.LtiPorcentajeOtroCosto);
	$('#CmpClienteMargenUtilidad').val(InsCliente.LtiPorcentajeMargenUtilidad);
	$('#CmpPorcentajeManoObra').val(InsCliente.LtiPorcentajeManoObra);
	$('#CmpPorcentajeDescuento').val(InsCliente.LtiPorcentajeDescuento);
	

}

function FncMonedaFuncion(){
	
	FncCotizacionProductoDetalleListar();
	
	FncCotizacionProductoPlanchadoListar();
	FncCotizacionProductoPintadoListar();
	FncCotizacionProductoCentradoListar();
	FncCotizacionProductoTareaListar();
	
	//FncCotizacionProductoTotalListar();
	

}

function FncVehiculoIngresoFormularioFuncion(){
	
	FncVehiculoIngresoBuscar("Id");

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


//			$('#CmpCotizacionProductoDetallePorcentajeUtilidad').val(MargenPorcentaje);
//			$('#CmpCotizacionProductoDetallePorcentajeOtroCosto').val(FletePorcentaje);
//			$('#CmpCotizacionProductoDetallePorcentajeAdicional').val(MantenimientoPorcentaje);
//			$('#CmpCotizacionProductoDetallePorcentajeDescuento').val(DescuentoPorcentaje);
//			$('#CmpCotizacionProductoDetallePorcentajePedido').val("0.00");
//			
//			$('#CmpCotizacionProductoDetallePorcentajeUtilidad').removeAttr('readonly');
//			$('#CmpCotizacionProductoDetallePorcentajeOtroCosto').removeAttr('readonly');
//			$('#CmpCotizacionProductoDetallePorcentajeAdicional').removeAttr('readonly');
//			$('#CmpCotizacionProductoDetallePorcentajeDescuento').removeAttr('readonly');
//			$('#CmpCotizacionProductoDetallePorcentajePedido').removeAttr('readonly');

		
			console.log("JnProductoTipoUnidadMedida");
			
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
			
			
			console.log("CmpCotizacionProductoDetalleTipoPedido");
			
			$('#CmpCotizacionProductoDetalleTipoPedido').unbind('change');
			$("select#CmpCotizacionProductoDetalleTipoPedido").change(function(){

				//FncReCalcularMostrarPrecioFinal();
				
				if($(this).val() == "URGENTE"){
					$('#CmpCotizacionProductoDetallePorcentajePedido').val("10.00");
				}else{
					$('#CmpCotizacionProductoDetallePorcentajePedido').val("0.00");
				}

			});
			  
			//console.log("CmpProductoUnidadMedidaConvertir");
//			  
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				
				var UnidadMedidaConvertir = $(this).val();
				
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsProducto.UmeId+"&UnidadMedida2="+UnidadMedidaConvertir,{}, 
				function(j){
					
						$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
						
						$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+InsProducto.ProId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+UnidadMedidaConvertir,{}, 
							function(j){
								
								console.log("LprCosto: "+j.LprCosto);				
								console.log("LprValorVenta: "+j.LprValorVenta);
								console.log("LprPrecio: "+j.LprPrecio);
								
								if(EmpresaMonedaId == MonedaId){
									Costo = (j.LprCosto);
									ValorVenta = (j.LprValorVenta);
									Precio = (j.LprPrecio);
								}else{
									Costo = j.LprCosto / TipoCambio;
									ValorVenta = j.LprValorVenta / TipoCambio;
									Precio = j.LprPrecio / TipoCambio;
								}
								
								if(Precio == 0 || Precio == null){	
									console.log("NO TIENE PRECIO SISTEMA");
									alert("No se encontro precio en LISTA DE SISTEMA. Proceso Cancelado");
									Precio = 0;
								}else{						
									console.log("TIENE PRECIO SISTEMA");	
								}
								
								Costo = Math.round(Costo*100)/100;		
								
								$("#CmpProductoCosto").val(Costo);	
								$("#CmpProductoValorVenta").val(ValorVenta);	
								
								$("#CmpProductoPrecio").val(Precio);
								$("#CmpProductoCantidad").val("1");
								$("#CmpProductoImporte").val(Precio);	
								
								if(Seguro==""){
						
									$("#CmpProductoPrecio").attr('readonly', true);
									$("#CmpProductoImporte").attr('readonly', true);
						
								}else{
						
									$('#CmpProductoPrecio').removeAttr('readonly');
									$('#CmpProductoImporte').removeAttr('readonly');
						
								}
								
								
								/*
								CALCULADORA PRECIOS
								*/
								$('#CmpCotizacionProductoDetallePorcentajeOtroCosto').val(j.LprPorcentajeOtroCosto);
								$('#CmpCotizacionProductoDetallePorcentajeUtilidad').val(j.LprPorcentajeUtilidad);
								$('#CmpCotizacionProductoDetallePorcentajeManoObra').val(j.LprPorcentajeManoObra);
								$('#CmpCotizacionProductoDetallePorcentajePedido').val("0.00");
								
								$('#CmpCotizacionProductoDetallePorcentajeAdicional').val(j.LprPorcentajeAdicional);
								$('#CmpCotizacionProductoDetallePorcentajeDescuento').val(j.LprPorcentajeDescuento);
								
								/*
								BLOQUEANDO CAJAS CALCULADORA PRECIOS
								*/
								$("#CmpCotizacionProductoDetallePorcentajeOtroCosto").attr('readonly', true);
								$("#CmpCotizacionProductoDetallePorcentajeUtilidad").attr('readonly', true);
								$("#CmpCotizacionProductoDetallePorcentajeManoObra").attr('readonly', true);
								$("#CmpCotizacionProductoDetallePorcentajePedido").attr('readonly', true);
								
								$('#CmpCotizacionProductoDetallePorcentajeAdicional').removeAttr('readonly');
								$('#CmpCotizacionProductoDetallePorcentajeDescuento').removeAttr('readonly');		
				
								
							});
			
			
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
					$('#CmpCotizacionProductoDetalleTipoPedido').val("ALMACEN");
				}else{
					$('#CmpCotizacionProductoDetalleTipoPedido').val("NORMAL");
				}			
				
			}else{
				
				if(InsProducto.ProStockReal>0){
					$('#CmpCotizacionProductoDetalleTipoPedido').val("ALMACEN");
				}else{
					$('#CmpCotizacionProductoDetalleTipoPedido').val("IMPORTACION");
				}	
				
			}
			
			console.log("JnListaPrecio");
			console.log("EmpresaMonedaId: "+EmpresaMonedaId);
			console.log("MonedaId:" + MonedaId);
			
			$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+InsProducto.ProId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+InsProducto.UmeIdSalida,{}, 
			function(j){
				
				console.log("LprCosto: "+j.LprCosto);				
				console.log("LprValorVenta: "+j.LprValorVenta);
				console.log("LprPrecio: "+j.LprPrecio);
				
				if(EmpresaMonedaId == MonedaId){
					Costo = (j.LprCosto);
					ValorVenta = (j.LprValorVenta);
					Precio = (j.LprPrecio);
				}else{
					Costo = j.LprCosto / TipoCambio;
					ValorVenta = j.LprValorVenta / TipoCambio;
					Precio = j.LprPrecio / TipoCambio;
				}
				
				if(Precio == 0 || Precio == null){	
					console.log("NO TIENE PRECIO SISTEMA");
					alert("No se encontro precio en LISTA DE SISTEMA. Proceso Cancelado");
					Precio = 0;
				}else{						
					console.log("TIENE PRECIO SISTEMA");	
				}

				Costo = Math.round(Costo*100)/100;		
				
				$("#CmpProductoCosto").val(Costo);	
				$("#CmpProductoValorVenta").val(ValorVenta);	
				
				$("#CmpProductoPrecio").val(Precio);
				$("#CmpProductoCantidad").val("1");
				$("#CmpProductoImporte").val(Precio);	
				
				if(Seguro==""){
		
					$("#CmpProductoPrecio").attr('readonly', true);
					$("#CmpProductoImporte").attr('readonly', true);

				}else{
		
					$('#CmpProductoPrecio').removeAttr('readonly');
					$('#CmpProductoImporte').removeAttr('readonly');
		
				}

				/*
				CALCULADORA PRECIOS
				*/
				$('#CmpCotizacionProductoDetallePorcentajeOtroCosto').val(j.LprPorcentajeOtroCosto);
				$('#CmpCotizacionProductoDetallePorcentajeUtilidad').val(j.LprPorcentajeUtilidad);
				$('#CmpCotizacionProductoDetallePorcentajeManoObra').val(j.LprPorcentajeManoObra);
				$('#CmpCotizacionProductoDetallePorcentajePedido').val("0.00");
				
				$('#CmpCotizacionProductoDetallePorcentajeAdicional').val(j.LprPorcentajeAdicional);
				$('#CmpCotizacionProductoDetallePorcentajeDescuento').val(j.LprPorcentajeDescuento);
				
				/*
				BLOQUEANDO CAJAS CALCULADORA PRECIOS
				*/
				$("#CmpCotizacionProductoDetallePorcentajeOtroCosto").attr('readonly', true);
				$("#CmpCotizacionProductoDetallePorcentajeUtilidad").attr('readonly', true);
				$("#CmpCotizacionProductoDetallePorcentajeManoObra").attr('readonly', true);
				$("#CmpCotizacionProductoDetallePorcentajePedido").attr('readonly', true);
				
				$('#CmpCotizacionProductoDetallePorcentajeAdicional').removeAttr('readonly');
				$('#CmpCotizacionProductoDetallePorcentajeDescuento').removeAttr('readonly');				
				
			});
			
			
		$("#BtnProductoEditar").show();
		$("#BtnProductoRegistrar").hide();
	  }
  }


function FncEstablecerUnidadMedidaConversionCosto(){
	
}


function FncCalcularMostrarPrecioFinal(oPorcentajeImpuestoVenta,oIncluyeImpuesto,oClienteMargenUtilidad,oTipoPedido,oFlete,oMantenimiento,oDescuento,oCosto,oRedondear,oEquivalente){
	
	var Precio = 0;
	var ValorVenta = 0;
	var Importe = 0;

	var NuevoCosto = oCosto*oEquivalente;
	
	console.log(NuevoCosto);
	
	
	if(oTipoPedido == "IMPORTACION"){
		//NuevoCosto = (NuevoCosto * 1) + ( NuevoCosto * (0.15));
	}

	if(oTipoPedido == "URGENTE"){
		NuevoCosto = (NuevoCosto * 1) + ( NuevoCosto * (0.10));
	}
	
	if(oFlete !=0 && oFlete != ""){	
//		NuevoCosto = (NuevoCosto * 1) + (NuevoCosto*((oFlete * 1)/100));
		NuevoCosto = (NuevoCosto * 1) * (((oFlete * 1)/100)+1);
		console.log("a");
		console.log(NuevoCosto);
	}
	
	
	if(oClienteMargenUtilidad !=0 && oClienteMargenUtilidad != ""){	
		console.log(oClienteMargenUtilidad);
//		NuevoCosto = ( NuevoCosto*1 ) + ( ( NuevoCosto*1 ) * ( ( oClienteMargenUtilidad * 1 )/100));
		NuevoCosto = (NuevoCosto * 1) * (((oClienteMargenUtilidad * 1)/100)+1);
		
		//ValorVenta = Precio;
		console.log("b");
		console.log(NuevoCosto);
	}
	
	
	if(oMantenimiento !=0 && oMantenimiento != ""){	
		//NuevoCosto = (NuevoCosto * 1) + (NuevoCosto*((oMantenimiento * 1)/100));
		NuevoCosto = (NuevoCosto * 1) * (((oMantenimiento * 1)/100)+1);
		console.log("C");
		console.log(NuevoCosto);
	}
	
	
//	if(oDescuento !=0 && oDescuento != ""){	
//		NuevoCosto = (NuevoCosto * 1) - (NuevoCosto*((oDescuento * 1)/100));
//	}
	
	
	if(oIncluyeImpuesto == 1){
		Precio = (NuevoCosto * 1) * (((oPorcentajeImpuestoVenta * 1)/100)+1);
//		Precio = (NuevoCosto * 1) + ( (NuevoCosto * 1) * ( (oPorcentajeImpuestoVenta * 1)/100)) ;
		console.log("d");
		console.log(Precio);
	}else{
		Precio = NuevoCosto;
		console.log("e");
		console.log(Precio);
	}

	Precio = Math.round(Precio*100)/100;
	
	if(oRedondear){
		console.log("f");
		Precio = Math.ceil(Precio);
	}else{
		console.log("g");
		Precio = Precio.toFixed(2);
	}
	
	return Precio;

}


//function FncClienteFunction(oInsCliente){
//	
//
//}

//
//function FncCalcularMostrarImporte(){
//
//	var Precio = $('#CmpProductoPrecio').val();
//	var Cantidad = $('#CmpProductoCantidad').val();
//	var Importe = 0;
//		
//	if(Precio == ""){
//		$('#CmpProductoPrecio').focus();
//			
//	}else if(Precio=="0.00"){
//		$('#CmpProductoPrecio').select();	
//		
//	}else if(Precio=="0"){
//		$('#CmpProductoPrecio').select();	
//		
//	}else if(Cantidad == ""){
//		$('#CmpProductoCantidad').focus();
//		
//	}else if(Cantidad == "0"){
//		$('#CmpProductoPrecio').select();
//		
//	}else if(Cantidad == "0.00"){		
//		$('#CmpProductoPrecio').select();
//	}else{
//		
//		Importe = (Precio * 1) * (Cantidad * 1);
//		Importe = Math.round(Importe*100)/100;
//		
//		$('#CmpProductoImporte').val(Importe);
//		//$('#CmpProductoCantidad').select();
//	}
//	
//	
//}


function FncReCalcularMostrarPrecioFinal(){
	
	var ClienteId = $("#CmpClienteId").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();
	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
	var IncluyeImpuesto = $("#CmpIncluyeImpuesto").val();
	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
	
	var TipoPedido = $('#CmpCotizacionProductoDetalleTipoPedido').val();
	var MargenPorcentaje = $("#CmpCotizacionProductoDetallePorcentajeUtilidad").val();	
	var FletePorcentaje = $("#CmpCotizacionProductoDetallePorcentajeOtroCosto").val();
	var MantenimientoPorcentaje = $("#CmpCotizacionProductoDetallePorcentajeAdicional").val();
	var DescuentoPorcentaje = $("#CmpCotizacionProductoDetallePorcentajeDescuento").val();
	
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

	var PrecioFinal = FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,MargenPorcentaje,TipoPedido,FletePorcentaje,MantenimientoPorcentaje,DescuentoPorcentaje,Costo,Redondear,ProductoUnidadMedidaEquivalente);

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
