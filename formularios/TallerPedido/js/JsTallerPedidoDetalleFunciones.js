// JavaScript Document

function FncTallerPedidoDetalleNuevo(oModalidadIngreso){
	
	var Almacen = $("CmpAlmacen_"+oModalidadIngreso).val();
	
	$('#Cmp'+oModalidadIngreso+'ProductoId').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoItem').val("");	
			
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val("");	
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val("");	
	
	$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedida').val("");
	$('select#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').html('');
	$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaEquivalente').val("");	
	
	$('#Cmp'+oModalidadIngreso+'ProductoCantidad').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoPrecio').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoImporte').val("");
	
	$('#Cmp'+oModalidadIngreso+'TallerPedidoDetalleEstado').val("3");
	$('#Cmp'+oModalidadIngreso+'TallerPedidoDetalleReingreso').val("2");	
	
	$('#CmpTallerPedidoDetalleFecha_'+oModalidadIngreso).val(FechaHoy);	
	$('#CmpAlmacenId_'+oModalidadIngreso).val(EmpresaAlmacenId);	
	
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo para registrar elementos');				
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').focus();			
	
	$('#CmpTallerPedido'+oModalidadIngreso+'ProductoAccion').val("AccTallerPedidoDetalleRegistrar.php");
	
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').removeAttr('readonly');
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').removeAttr('readonly');
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').removeAttr('readonly');
//	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);

	FncTallerPedidoCalcularMantenimientTotal();
}

function FncTallerPedidoDetalleGuardar(oModalidadIngreso){

//alert(":3");
			var Identificador = $('#Identificador').val();
	
			var Acc = $('#CmpTallerPedido'+oModalidadIngreso+'ProductoAccion').val();		
	
			var ProductoId = $('#Cmp'+oModalidadIngreso+'ProductoId').val();
			var ProductoNombre = $('#Cmp'+oModalidadIngreso+'ProductoNombre').val();
			var ProductoCodigoOriginal = $('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val();
			var ProductoCodigoAlternativo = $('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val();
			var Item = $('#Cmp'+oModalidadIngreso+'ProductoItem').val();
	
			var ProductoUnidadMedidaConvertir = $('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').val();
			var ProductoCantidad = $('#Cmp'+oModalidadIngreso+'ProductoCantidad').val();
			var ProductoPrecio = $('#Cmp'+oModalidadIngreso+'ProductoPrecio').val();
			var ProductoImporte = $('#Cmp'+oModalidadIngreso+'ProductoImporte').val();
			
			var ProductoUnidadMedida = $('#Cmp'+oModalidadIngreso+'ProductoUnidadMedida').val();
			
			var TallerPedidoDetalleEstado = $('#Cmp'+oModalidadIngreso+'TallerPedidoDetalleEstado').val();
			var TallerPedidoDetalleReingreso = $('#Cmp'+oModalidadIngreso+'TallerPedidoDetalleReingreso').val();
			
			var AlmacenId = $('#CmpAlmacenId_'+oModalidadIngreso).val();
			var TallerPedidoDetalleFecha = $('#CmpTallerPedidoDetalleFecha_'+oModalidadIngreso).val();
			
			console.log('#CmpAlmacenId_'+oModalidadIngreso);
			console.log('#CmpTallerPedidoDetalleFecha_'+oModalidadIngreso);
			
			if(ProductoNombre==""){			
				$('#Cmp'+oModalidadIngreso+'ProductoNombre').select();				
			}else if(ProductoUnidadMedidaConvertir==""){			
				$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').focus();				
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){			
				$('#Cmp'+oModalidadIngreso+'ProductoCantidad').select();				
			}else if(TallerPedidoDetalleEstado==""){			
				$('#CmpTallerPedido'+oModalidadIngreso+'DetalleEstado').focus();
			}else{
			
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Guardando...');
				
				$.ajax({
					type: 'POST',
					url: 'formularios/TallerPedido/acc/'+Acc,
					data: 'Identificador='+Identificador+
					'&ProductoNombre='+ProductoNombre+
					'&ProductoCodigoOriginal='+ProductoCodigoOriginal+
					'&ProductoCodigoAlternativo='+ProductoCodigoAlternativo+
					'&ProductoId='+ProductoId+
					'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
					'&ProductoCantidad='+ProductoCantidad+
					'&ProductoPrecio='+ProductoPrecio+
					'&ProductoImporte='+ProductoImporte+
					'&ProductoUnidadMedida='+ProductoUnidadMedida+
					'&TallerPedidoDetalleEstado='+TallerPedidoDetalleEstado+
					'&TallerPedidoDetalleReingreso='+TallerPedidoDetalleReingreso+
					'&AlmacenId='+AlmacenId+
					'&TallerPedidoDetalleFecha='+TallerPedidoDetalleFecha+
					'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
					success: function(){
						
					$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');							
						FncTallerPedidoDetalleListar(oModalidadIngreso);
					}
				});
						
						
						
								/*if(confirm("Desea seguir agregando mas items?")==false){
									if(confirm("Desea guardar el registro ahora?")){
										$('#Guardar').val("1");
										$('#'+Formulario).submit();
									}
								}*/
								
							FncTallerPedidoDetalleNuevo(oModalidadIngreso);	
					
					
				}
			

	
}


function FncTallerPedidoDetalleEstadoGuardar(oModalidadIngreso,oItem){
	
	console.log('FncTallerPedidoDetalleEstadoGuardar');
	

	var Identificador = $('#Identificador').val();
	//var Item = $('#Cmp'+oModalidadIngreso+'ProductoItem').val();
	
	console.log('#CmpTallerPedidoDetalleEstado_'+oModalidadIngreso+oItem);
	
	var TallerPedidoDetalleEstado = $('#CmpTallerPedidoDetalleEstado_'+oModalidadIngreso+oItem).val();

//CmpTallerPedidoDetalleEstado_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Guardando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/acc/AccTallerPedidoDetalleEstadoGuardar.php',
		data: 'Identificador='+Identificador+'&TallerPedidoDetalleEstado='+TallerPedidoDetalleEstado+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(){
			
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');							
			
			FncTallerPedidoDetalleListar(oModalidadIngreso);
			
		}
	});
						
	
}

function FncTallerPedidoDetalleListar(oModalidadIngreso){
	
	console.log("Cargando taller pedido detalle");
	console.log("Modalidad: "+oModalidadIngreso);
	
	var Identificador = $('#Identificador').val();

	//$('#CapProductoAccion').html('Cargando...');
	
	var MonedaId = $('#CmpMonedaId_'+oModalidadIngreso).val();
	var TipoCambio = $('#CmpTipoCambio_'+oModalidadIngreso).val();
	var AlmacenId = $('#CmpAlmacen_'+oModalidadIngreso).val();
	var Descuento = $('#CmpDescuento_'+oModalidadIngreso).val();
	var Total = $('#CmpMantenimientoTotal').val();
	var SucursalId = $('#CmpSucursalId').val();


	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}
	
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoDetalleListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&AlmacenId='+AlmacenId+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&Descuento='+Descuento+'&Total='+Total+'&SucursalId='+SucursalId+'&Editar='+TallerPedidoDetalleEditar+'&Eliminar='+TallerPedidoDetalleEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			$("#CapTallerPedido"+oModalidadIngreso+"Productos").html("");
			$("#CapTallerPedido"+oModalidadIngreso+"Productos").append(html);
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('etiqueta')=="producto"){

					var Item = $(this).attr('item');
					////////////////////////////////////////////////////////
					var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
					var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
					var VersionId = $("#CmpVehiculoIngresoVersionId").val();
					var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();
					
					var Sigla = $(this).val();
					var ModalidadSigla = $(this).attr('modalidad_sigla');
					
							
					/*					
					$("input,select,textarea").keypress(function (event) {  	
						 if (event.keyCode == '13' && this.type !== "hidden") {
							FncTallerPedidoNavegar(this.id);
						 }
					}); 
					*/	
					////////////////////////////////////////////////////////////
					
						if($("#CmpAlmacen_"+Sigla+"").val()==""){
							//console.log("#CmpAlmacenId_"+Sigla);
							$("#CmpAlmacen_"+Sigla+"").prop("selectedIndex", 1);
							
						}else{
							//console.log("#CmpAlmacenId_"+Sigla+": "+$("#CmpAlmacenId_"+Sigla).val());
						}
						
						if($("#CmpTallerPedidoDetalleEstado_"+Sigla+"").val()==""){
							
							//console.log("#Cmp"+Sigla+"TallerPedidoDetalleEstado"));
							$("#CmpTallerPedidoDetalleEstado_"+Sigla+"").prop("selectedIndex", 2);
							
						}else{
							//console.log("#CmpAlmacenId_"+Sigla+": "+$("#CmpAlmacenId_"+Sigla).val());
						}
						    
							
							
					
							
						$("#CmpTallerPedidoDetalleEstado_"+Sigla+"").change(function(){
							
							
							console.log("#CmpTallerPedidoDetalleEstado_"+Sigla+": change");
														
							if($(this).val()=="1"){
								$(this).removeClass("EstFormularioCombo").addClass("EstFormularioComboAnulado");	
							}else{
								$(this).removeClass("EstFormularioComboAnulado").addClass("EstFormularioCombo");
							}
							
							FncTallerPedidoDetalleEstadoGuardar(ModalidadSigla,Item);
							
						});
						
						
					//console.log("TEST#CmpTallerPedidoDetalleEstado_"+$(this).val());
					/*
					$("#CmpTallerPedidoDetalleEstado_"+$(this).val()).unbind("change");
					$("#CmpTallerPedidoDetalleEstado_"+$(this).val()).change(function(){
			
							FncTallerPedidoDetalleEstadoGuardar(oModalidadIngreso,Item);
			
					});		*/
					
					

				}			 
			});
			
			FncTallerPedidoTotalListar(oModalidadIngreso);

		}
	});
	
	


}




function FncTallerPedidoDetalleEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	var ClienteTipoId = $("#CmpClienteTipo").val();
	
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Editando...');
	$('#CmpTallerPedido'+oModalidadIngreso+'ProductoAccion').val("AccTallerPedidoDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TallerPedido/acc/AccTallerPedidoDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsTallerPedidoDetalle){

//	SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
				//	Parametro1 = AmdId
				//	Parametro2 = ProId
				//	Parametro3 = ProNombre
				//	Parametro4 = AmdPrecioVenta
				//	Parametro5 = AmdCantidad
				//	Parametro6 = AmdImporte
				//	Parametro7 = AmdTiempoCreacion
				//	Parametro8 = AmdTiempoModificacion
				//	Parametro9 = UmeNombre
				//	Parametro10 = UmeId
				//	Parametro11 = RtiId
				//	Parametro12 = AmdCantidadReal
				//	Parametro13 = ProCodigoOriginal,
				//	Parametro14 = ProCodigoAlternativo
				//	Parametro15 = UmeIdOrigen
				//	Parametro16 = VerificarStock
				//	Parametro17 = AmdCosto
				//	Parametro18 = Origen
				//	Parametro19 = Verificar
				//	Parametro20 = FaaId
				
				//	Parametro21 = PmtId
				//	Parametro22 = FaaAccion
				//	Parametro23 = FaaNivel
				//	Parametro24 = FaaVerificar1
				//	Parametro25 = 
				//	Parametro26 = FapId	
				//	Parametro27 = AmdCantidadRealAnterior
				//	Parametro28 = AmdEstado
				//	Parametro29 = AmdReingreso
				//	Parametro30 = VddId
				
				//	Parametro31 = AlmId
				//	Parametro32 = AmdFecha

				$('#Cmp'+oModalidadIngreso+'ProductoId').val(InsTallerPedidoDetalle.Parametro2);
				$('#Cmp'+oModalidadIngreso+'ProductoNombre').val(InsTallerPedidoDetalle.Parametro3);
				$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val(InsTallerPedidoDetalle.Parametro13);
				$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val(InsTallerPedidoDetalle.Parametro14);
				$('#Cmp'+oModalidadIngreso+'ProductoItem').val(InsTallerPedidoDetalle.Item);
				$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaEquivalente').val(1);
				$('#Cmp'+oModalidadIngreso+'ProductoCantidad').val(InsTallerPedidoDetalle.Parametro5);

				$('#Cmp'+oModalidadIngreso+'ProductoPrecio').val(InsTallerPedidoDetalle.Parametro4);
				$('#Cmp'+oModalidadIngreso+'ProductoImporte').val(InsTallerPedidoDetalle.Parametro6);
				
				//CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>DetalleEstado
				$('#Cmp'+oModalidadIngreso+'TallerPedidoDetalleEstado').val(InsTallerPedidoDetalle.Parametro28);
				
				$('#Cmp'+oModalidadIngreso+'TallerPedidoDetalleReingreso').val(InsTallerPedidoDetalle.Parametro29);
				
				$('#CmpAlmacenId_'+oModalidadIngreso).val(InsTallerPedidoDetalle.Parametro31);
				$('#CmpTallerPedidoDetalleFecha_'+oModalidadIngreso).val(InsTallerPedidoDetalle.Parametro32);
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsTallerPedidoDetalle.Parametro11+"&Tipo=2&UnidadMedidaId="+InsTallerPedidoDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsTallerPedidoDetalle.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$('select#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').html(options);
				});
				
				
		$('select#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').change(function(){
		
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsTallerPedidoDetalle.Parametro10+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){
			
			$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaEquivalente').val(j.UmcEquivalente);
			
		});
		
		//var UnidadMedidaSalida = $(this).val();
		$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+InsTallerPedidoDetalle.Parametro2+"&ProductoTipoId="+InsTallerPedidoDetalle.Parametro11+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+$(this).val(),{}, function(j){

			$('#Cmp'+oModalidadIngreso+'ProductoPrecio').val(j.LprPrecio);
			$('#Cmp'+oModalidadIngreso+'ProductoCantidad').val(0);
			$('#Cmp'+oModalidadIngreso+'ProductoImporte').val(j.LprPrecio);
			
		});
		
		$('#Cmp'+oModalidadIngreso+'ProductoCantidad').focus("");

	});
	
		//$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').attr('disabled', true);
		
}
	});
	


	//$('#CmpProductoCantidad').select();
	$('#Cmp'+oModalidadIngreso+'ProductoCantidad').select();
	
	//$('#CmpProductoId').attr('readonly', true);
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').attr('readonly', true);
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').attr('readonly', true);
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').attr('readonly', true);
	
		
	
	
}

function FncTallerPedidoDetalleEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html("Eliminado");	
				FncTallerPedidoDetalleListar(oModalidadIngreso);
			}
		});

		FncTallerPedidoDetalleNuevo(oModalidadIngreso);

	}
	
}



function FncTallerPedidoDetalleEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TallerPedido/acc/AccTallerPedidoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminado');	
				FncTallerPedidoDetalleListar(oModalidadIngreso);
			}
		});	
			
		FncTallerPedidoDetalleNuevo(oModalidadIngreso);
	}
	
}


function FncTallerPedidoCargarCotizacionProducto(oModalidadIngreso){

	var AlmacenId = $('#CmpAlmacenId_'+oModalidadIngreso).val();
	var TallerPedidoDetalleFecha = $('#CmpTallerPedidoDetalleFecha_'+oModalidadIngreso).val();
			
	var Identificador = $('#Identificador').val();

	var MonedaId = $('#CmpMonedaId_'+oModalidadIngreso).val();
	var TipoCambio = $('#CmpTipoCambio_'+oModalidadIngreso).val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}
	
	var MonedaId = $('#CmpMonedaId').val();
	var CotizacionProductoId = $('#CmpCotizacionProductoId').val();
	var FichaIngresoId = $('#CmpFichaIngresoId').val();
	
	//if(CotizacionProductoId==""){
	//	alert("No se encontro ninguna Cotizacion");
	//}else{
		
		if(confirm("¿Realmente desea Cargar los productos de la Orden de Venta?")){
				
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
			
			$.ajax({
				type: 'POST',
				url: 'formularios/TallerPedido/acc/AccTallerPedidoCargarCotizacionProducto.php',
				data: 'Identificador='+Identificador+
				'&ModalidadIngreso='+oModalidadIngreso+
				'&MonedaId='+MonedaId+
				'&TipoCambio='+TipoCambio+
				'&CotizacionProductoId='+CotizacionProductoId+
				'&FichaIngresoId='+FichaIngresoId+
				'&AlmacenId='+AlmacenId+
				'&TallerPedidoDetalleFecha='+TallerPedidoDetalleFecha+
				'&Editar='+TallerPedidoDetalleEditar+
				'&Eliminar='+TallerPedidoDetalleEliminar,
				success: function(html){
					
					$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');
					
					$('#CmpMonedaId_'+oModalidadIngreso).val('Listo');
					
					FncTallerPedidoDetalleListar(oModalidadIngreso);
									
				}
			});
			
		}
		
		
				
	//}
	


}



$().ready(function() {

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){

			var Sigla = $(this).attr('sigla');

			$("#Cmp"+Sigla+"ProductoImporte").keyup(function (event) {  
				FncProductoCalcularMonto(Sigla);
			});

			$("#Cmp"+Sigla+"ProductoPrecio").keyup(function (event) {  
				FncProductoCalcularImporte(Sigla);
			});

			$("#Cmp"+Sigla+"ProductoCantidad").keyup(function (event) {  
				FncProductoCalcularImporte(Sigla);
			});

		}			 
	});

});




	