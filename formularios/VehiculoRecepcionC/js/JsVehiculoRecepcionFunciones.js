// JavaScript Document
/*var headertext = [],
headers = document.querySelectorAll("#miyazaki th"),
tablerows = document.querySelectorAll("#miyazaki th"),
tablebody = document.querySelector("#miyazaki tbody");

for(var i = 0; i < headers.length; i++) {
  var current = headers[i];
  headertext.push(current.textContent.replace(/\r?\n|\r/,""));
} 
for (var i = 0, row; row = tablebody.rows[i]; i++) {
  for (var j = 0, col; col = row.cells[j]; j++) {
    col.setAttribute("data-th", headertext[j]);
  } 
}*/
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
"CmpVehiculoRecepcionDetalleTipoPedido",
"CmpProductoCantidad",
"CmpProductoImporte",
"CmpVehiculoRecepcionPlanchadoDescripcion",
"CmpVehiculoRecepcionPlanchadoImporte",
"CmpVehiculoRecepcionPintadoDescripcion",
"CmpVehiculoRecepcionPintadoImporte",
"CmpVehiculoRecepcionCentradoDescripcion",
"CmpVehiculoRecepcionCentradoImporte",
"CmpVehiculoRecepcionTareaDescripcion",
"CmpVehiculoRecepcionTareaImporte"];

$().ready(function() {

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncVehiculoRecepcionNavegar(this.id);
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
		FncVehiculoRecepcionEstablecerMoneda();
	});
	
//	$("#CmpPlanchado").change(function(){
//		//FncVehiculoRecepcionPlanchadoIncluir();
//	});
//
//	$("#CmpPintado").change(function(){
//		//FncVehiculoRecepcionPintadoIncluir();
//	});
//	
//	$("#CmpCentrado").change(function(){
//		//FncVehiculoRecepcionCentradoIncluir();
//	});


	$("select#CmpClienteTipo").change(function(){
		FncVehiculoRecepcionDetalleActualizarPrecio();
	});
	
	$("#CmpManoObra").keyup(function(){
		FncVehiculoRecepcionDetalleListar();
	});
	
	$("#CmpClienteMargenUtilidad").keyup(function(){
		FncVehiculoRecepcionDetalleListar();
	});
	
	$("#CmpPorcentajeDescuento").keyup(function(){
		FncVehiculoRecepcionDetalleListar();
	});

});
	
function FncVehiculoRecepcionNavegar(oCampo){
	
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
		FncVehiculoRecepcionDetalleGuardar();
	}
	
	
	
	if("CmpVehiculoRecepcionPlanchadoImporte"==oCampo){
		$('#CmpVehiculoRecepcionPlanchadoImporte').blur();
		FncVehiculoRecepcionPlanchadoGuardar();
	}
	
	if("CmpVehiculoRecepcionPintadoImporte"==oCampo){
		$('#CmpVehiculoRecepcionPintadoImporte').blur();
		FncVehiculoRecepcionPintadoGuardar();
	}


	if("CmpVehiculoRecepcionCentradoImporte"==oCampo){
		$('#CmpVehiculoRecepcionCentradoImporte').blur();
		FncVehiculoRecepcionCentradoGuardar();
	}

	if("CmpVehiculoRecepcionTareaImporte"==oCampo){
		$('#CmpVehiculoRecepcionTareaImporte').blur();
		FncVehiculoRecepcionTareaGuardar();
	}

}

/*
* FUNCIONES -AUXILIARES
*/
function FncVehiculoRecepcionEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncVehiculoRecepcionDetalleListar();
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
function FncVehiculoIngresoFuncion(){
	
//	var ClienteId = $("#CmpVehiculoIngresoClienteId").val();
//	$("#CmpClienteId").val(ClienteId);
//	FncClienteBuscar('Id');

}

function FncClienteFuncion(){
	
	var VehiculoIngresoId = $("#CmpClienteVehiculoIngresoId").val();
	
	$("#CmpVehiculoIngresoId").val(VehiculoIngresoId);

	FncVehiculoIngresoBuscar('Id');

}

function FncMonedaFuncion(){
	
	FncVehiculoRecepcionDetalleListar();
	
	FncVehiculoRecepcionPlanchadoListar();
	FncVehiculoRecepcionPintadoListar();
	FncVehiculoRecepcionCentradoListar();
	FncVehiculoRecepcionTareaListar();
	

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
					
FncPopUp('formularios/VehiculoRecepcionC/FrmVehiculoRecepcionImprimir.php?Id='+oId+'&P=1&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/VehiculoRecepcionC/FrmVehiculoRecepcionImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/VehiculoRecepcionC/FrmVehiculoRecepcionImprimir.php?Id='+oId+'&P=1+ImprimirCodigo=1&ImprimirPedido=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}
			

}


function FncVistaPreliminar(oId){
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Cotizacion c/ Codigo) \n 2 = Formato 2 (Cotizacion s/ Codigo) \n 3 = Formato 3 (Cotizacion c/ Tipo Pedido)", "1");	
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/VehiculoRecepcionC/FrmVehiculoRecepcionImprimir.php?Id='+oId+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

FncPopUp('formularios/VehiculoRecepcionC/FrmVehiculoRecepcionImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/VehiculoRecepcionC/FrmVehiculoRecepcionImprimir.php?Id='+oId+'&ImprimirCodigo=1&ImprimirPedido=1',0,0,1,0,0,1,0,screen.height,screen.width);

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

/*****************************************************************************/
//FncProductoEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProPrecio,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);

function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oVddId){	

	var ClienteId = $("#CmpClienteId").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();
	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
	var IncluyeImpuesto = $("#CmpIncluyeImpuesto").val();
	var PorcentajeImpuestoVenta = $("#CmpPorcentajeImpuestoVenta").val();
	
	var ClienteMargenUtilidad = $("#CmpClienteMargenUtilidad").val();
	var Flete = $("#CmpFlete").val();
	
	var Fecha = $("#CmpFecha").val();
	
	if(ClienteId==""){
		
		alert("Escoja primero un CLIENTE");

		FncVehiculoRecepcionDetalleNuevo();

		$('#CmpClienteNombre').focus();
			
		//FncClienteCargarFormulario("Registrar");
	}else if(ClienteMargenUtilidad == "" || ClienteMargenUtilidad == "0.00"){
			
		alert("Defina un margen de utilidad");
		
		$('#CmpClienteMargenUtilidad').focus();
			
	}else{

			if(oUnidadMedidaIngreso=="" || oUnidadMedidaIngreso == null){
			  alert("No se encontro UNIDAD DE MEDIDA (INGRESO), se recomienda revisar el PRODUCTO y establecer uno.");
			}
			
			if(oUmeId=="" || oUmeId == null ){
			  alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
			}

			$.getJSON("comunes/Producto/JnProductoDisponibilidad.php?ProductoCodigoOriginal="+oProCodigoOriginal,{}, function(j){

				if(j.PdiDisponible == "1"){
					$('#CmpVehiculoRecepcionDetalleTipoPedido').val("NORMAL");
				}else{
					$('#CmpVehiculoRecepcionDetalleTipoPedido').val("IMPORTACION");
				}
				
				$.getJSON("comunes/Producto/JnProductoListaPrecio.php?ProductoCodigoOriginal="+oProCodigoOriginal+"&MonedaId="+MonedaId+"&Fecha="+Fecha,{}, function(j){
	
					var Precio = 0;
					var Costo = 0;
					var ValorVenta = 0;
					
					var TipoPedido = $('#CmpVehiculoRecepcionDetalleTipoPedido').val();
					
					if(EmpresaMonedaId == MonedaId){
						Costo = j.PlpPrecio;
					}else{
						Costo = j.PlpPrecioReal;
					}
				
					if(Costo == 0){
						
						$('#CmpVehiculoRecepcionDetalleTipoPedido').val("ALMACEN");
						
						if(confirm("No se encontro precio en LISTA DE PROVEEDOR ¿Desea consultar precio en LISTA DE SISTEMA ?")){
				
							$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+oUmeId,{}, function(j){

								if(EmpresaMonedaId == MonedaId){
									  Costo = (j.LprCosto);
									  Precio = (j.LprPrecio);
									  ValorVenta = (j.LprValorVenta);
								}else{
									  Costo = j.LprCosto / TipoCambio;
									  Precio = j.LprPrecio / TipoCambio;
									  ValorVenta = j.LprValorVenta / TipoCambio;
								}

								if(Costo == 0){

									if(confirm("No se encontro precio en LISTA DE SISTEMA. Proceso Cancelado")){
										//FncVehiculoRecepcionDetalleNuevo();
									}

								}else{
									
//									$("#CmpProductoPrecio").val(Precio);
//									$("#CmpProductoCosto").val(Costo);	
//									$("#CmpProductoValorVenta").val(ValorVenta);	
//									
//									$("#CmpProductoCostoAux").val(Costo);

									FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,TipoPedido,Flete,Costo);
									FncCalcularMostrarImporte();
									
								}

							});
							
						}else{
							//FncVehiculoRecepcionDetalleNuevo();
							//$('#CmpVehiculoRecepcionDetalleTipoPedido').val("ALMACEN");
						}
						
					}else{
						
						FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,TipoPedido,Flete,Costo);
						FncCalcularMostrarImporte();
						
						//$('#CmpProductoUnidadMedidaConvertir').unbind('change');
//							$("select#CmpProductoUnidadMedidaConvertir").change(function(){
//				
//							$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
//								function(j){
//										
//									var Costo = 0;
//									var CostoAux = $('#CmpProductoCostoAux').val();
//									var TipoPedido = $('#CmpVehiculoRecepcionDetalleTipoPedido').val();
//									//var Cantidad = $('#CmpProductoCantidad').val();
//									var Precio = 0;
//									//var Importe = 0;
//										
//									Costo = CostoAux * j.UmcEquivalente;
//									Costo = Math.round(Costo*100000)/100000;
//										
//									$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
//										
//									FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,TipoPedido,Flete,Costo);
//									FncCalcularMostrarImporte();
//									/*var Precio = $('#CmpProductoPrecio').val();
//										
//										Importe = (Precio * 1) * (Cantidad * 1);
//										
//										$('#CmpProductoImporte').val(Importe);*/
//										
//								})				  
//							});
						
					}
	
					
				});

			});
			
			$('#CmpProductoId').val(oProId);
			$('#CmpProductoCantidad').val(0);
			$('#CmpProductoNombre').val(oProNombre);
			$('#CmpProductoPrecio').val(0);
			$('#CmpProductoImporte').val(0);
			
			$('#CmpProductoCosto').val(0);
			$('#CmpProductoCostoAux').val(0);
			$("#CmpProductoValorVenta").val(0);	
			
			$('#CmpProductoFoto').val(oProFoto);
			$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+oProEspecificacion+'">Archivo de Especificaciones<a/>');

			$('#CmpProductoTipo').val(oRtiId);
			$('#CmpProductoUnidadMedida').val(oUmeId);
			$('#CmpProductoUnidadMedidaIngreso').val(oUnidadMedidaIngreso);

			$('#CmpProductoCodigoOriginal').val(oProCodigoOriginal);
			$('#CmpProductoCodigoAlternativo').val(oProCodigoAlternativo);

			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo="+UnidadMedidaTipo+"&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){
				var options = '';
		
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(oUnidadMedidaIngreso == j[i].UmeId){
						options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
					}else{
						options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
					}
				}
				$("select#CmpProductoUnidadMedidaConvertir").html(options);
			});

			$('#CmpVehiculoRecepcionDetalleTipoPedido').unbind('change');
			$("select#CmpVehiculoRecepcionDetalleTipoPedido").change(function(){
				
				var Costo = $('#CmpProductoCostoAux').val();
				
				FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,$(this).val(),Flete,Costo);
				FncCalcularMostrarImporte();
				
			});
			  

			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
					
					var Costo = 0;
					var CostoAux = $('#CmpProductoCostoAux').val();
					var TipoPedido = $('#CmpVehiculoRecepcionDetalleTipoPedido').val();
					//var Cantidad = $('#CmpProductoCantidad').val();
					var Precio = 0;
					var UnidadMedidaId = j.UmeId2;
					//var Importe = 0;
					
					if(TipoPedido == "ALMACEN"){
						
						$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+UnidadMedidaId,{}, function(j){
						
							if(EmpresaMonedaId == MonedaId){
								  Costo = (j.LprCosto);
								  Precio = (j.LprPrecio);
								  ValorVenta = (j.LprValorVenta);
							}else{
								  Costo = j.LprCosto / TipoCambio;
								  Precio = j.LprPrecio / TipoCambio;
								  ValorVenta = j.LprValorVenta / TipoCambio;
							}
	
							if(Costo == 0){
	
								if(confirm("No se encontro precio en LISTA DE SISTEMA. Proceso Cancelado")){
									//FncVehiculoRecepcionDetalleNuevo();
								}
	
							}else{
								
								//Precio
								
							//	
//								$("#CmpProductoPrecio").val(Precio);
//								$("#CmpProductoCosto").val(Costo);	
//								$("#CmpProductoValorVenta").val(ValorVenta);	
//								
//								$("#CmpProductoCostoAux").val(Costo);
								
								//alert(":3");
								FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,TipoPedido,Flete,Costo);
								FncCalcularMostrarImporte();
								
							}
								
						});

					}else{

						Costo = CostoAux * j.UmcEquivalente;
						Costo = Math.round(Costo*100000)/100000;
						
						$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
						
						FncCalcularMostrarPrecioFinal(PorcentajeImpuestoVenta,IncluyeImpuesto,ClienteMargenUtilidad,TipoPedido,Flete,Costo);
						FncCalcularMostrarImporte();
						var Precio = $('#CmpProductoPrecio').val();
						//					
						//	Importe = (Precio * 1) * (Cantidad * 1);
						//					
						//	$('#CmpProductoImporte').val(Importe);
										
					}
	
				})
  
			  });
		 
		 $('#CmpProductoCantidad').select();
		 
		$("#BtnProductoEditar").show();
		$("#BtnProductoRegistrar").hide();
	  }
  }

function FncEstablecerUnidadMedidaConversionCosto(){
	
}
//function FncCalcularMostrarPrecioFinal(oPorcentajeImpuestoVenta,oIncluyeImpuesto,oClienteMargenUtilidad,oTipoPedido,oFlete,oCosto,oActualizarCostoAux){
function FncCalcularMostrarPrecioFinal(oPorcentajeImpuestoVenta,oIncluyeImpuesto,oClienteMargenUtilidad,oTipoPedido,oFlete,oCosto){
	
	var Precio = 0;
	var ValorVenta = 0;
	var Importe = 0;

	var CostoReal = 0;
	
	if(oIncluyeImpuesto == 1){
		CostoReal = (oCosto * 1) + ( (oCosto * 1) * ( (oPorcentajeImpuestoVenta * 1)/100)) ;
	}else{
		CostoReal = oCosto;
	}
	
	if(oTipoPedido == "IMPORTACION"){
		CostoReal = (CostoReal * 1) + ( CostoReal * (0.15));
	}

	if(oTipoPedido == "URGENTE"){
		CostoReal = (CostoReal * 1) + ( CostoReal * (0.10));
	}
	
	if(oFlete !=0 && oFlete != ""){	
		CostoReal = (CostoReal * 1) + (CostoReal*((oFlete * 1)/100));
	}

	if(oClienteMargenUtilidad !=0 && oClienteMargenUtilidad != ""){	
		Precio = ( CostoReal*1 ) + ( ( CostoReal*1 ) * ( ( oClienteMargenUtilidad * 1 )/100));
		ValorVenta = Precio;
	}
	
// 
//	
//	
//	if(oClienteMargenUtilidad !=0 && oClienteMargenUtilidad != ""){	
//		Precio = ( oCosto*1 ) + ( ( oCosto*1 ) * ( ( oClienteMargenUtilidad * 1 )/100));
//		ValorVenta = Precio;
//	}
//
//	if(oFlete !=0 && oFlete != ""){	
//		Precio = Precio + (oCosto*((oFlete * 1)/100));
//	}
//
//
//	if(oTipoPedido == "IMPORTACION"){
//		Precio = (Precio * 1) + ( Precio * (0.15));
//	}
//
//	if(oTipoPedido == "URGENTE"){
//		Precio = (Precio * 1) + ( Precio * (0.1));
//	}
//
//	if(oIncluyeImpuesto == 1){
//		Precio = (Precio * 1) + ( Precio * ( (oPorcentajeImpuestoVenta * 1)/100));
//	}
	
	Precio = Math.round(Precio*100000)/100000;
	Costo = Math.round(oCosto*100000)/100000;
	
	$("#CmpProductoPrecio").val(Precio);
	$("#CmpProductoCosto").val(Costo);	
	$("#CmpProductoValorVenta").val(ValorVenta);	

	$("#CmpProductoCostoAux").val(Costo);	

}

function FncCalcularMostrarImporte(){

	var Precio = $('#CmpProductoPrecio').val();
	var Cantidad = $('#CmpProductoCantidad').val();
	var Importe = 0;
					
	Importe = (Precio * 1) * (Cantidad * 1);
					
	$('#CmpProductoImporte').val(Importe);
	
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
