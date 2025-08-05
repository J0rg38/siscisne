// JavaScript Document

function FncGastoDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");
	$('#CmpProductoCosto').val("");
	$('#CmpProductoCostoAnterior').val("");
	$('#CmpProductoCostoIngreso').val("");
	$('#CmpProductoCostoIngresoNeto').val("");
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoImporte').val("");
	
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoCodigoAlternativo').val("");
	
	$('#CmpProductoAlmacenMovimientoDetalleEstado').val("3");
	$('#CmpProductoAlmacenMovimientoDetalleId').val("");
	
	$('#CmpProductoItem').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpGastoDetalleAccion').val("AccGastoDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");

					
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	
	
	
//	var Accion = $('#CmpGastoDetalleAccion').val();

//	if(Accion != "AccGastoDetalleReemplazar.php"){
//		
//		$('#CmpProductoCantidad').removeAttr('readonly');
//		$('#CmpProductoImporte').removeAttr('readonly');
//		$('#CmpProductoCostoIngresoNeto').removeAttr('readonly');
//		
//		$('#CmpProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//		$('#CmpProductoCodigoAlternativo').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//		
//		$('#CmpProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//		$('#CmpProductoImporte').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//		$('#CmpProductoCostoIngresoNeto').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//	
//	
//	}else{
//	
//					
//		
//	}
	
	
	
	
	FncProductoNuevo();
}

function FncGastoDetalleGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpGastoDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var AlmacenMovimientoDetalleEstado = $('#CmpAlmacenMovimientoDetalleEstado').val();
			var ProductoAlmacenMovimientoDetalleId = $('#CmpProductoAlmacenMovimientoDetalleId').val();
			var ProductoCosto = $('#CmpProductoCostoIngreso').val();
			var ProductoCostoAnterior = $('#CmpProductoCostoAnterior').val();
			var ProductoCostoIngresoNeto = $('#CmpProductoCostoIngresoNeto').val();
			var ProductoCostoIngreso = $('#CmpProductoCostoIngreso').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var Item = $('#CmpProductoItem').val();


			var Accion = $('#CmpGastoDetalleAccion').val();
			var OrdenCompra = $('#CmpOrdenCompra').val();

			/*if(Accion == "AccGastoDetalleRegistrar.php" && OrdenCompra != "" ){
				alert("No se puede agregar items cuando se tiene una ORDEN DE COMPRA");
			}else */if(ProductoId==""){
				alert("No existe el PRODUCTO");
				FncProductoCargarFormulario("Registrar");
			}else if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertir').focus();	
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#CmpProductoCantidad').select();	
			}else if(ProductoCosto==""){
				$('#CmpProductoCosto').select();	
			}else if(ProductoImporte==""){
				$('#CmpProductoImporte').select();						
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/Gasto/acc/'+Acc,
							data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&ProductoCosto='+ProductoCosto+'&ProductoCostoAnterior='+ProductoCostoAnterior+'&ProductoCantidad='+ProductoCantidad+'&ProductoImporte='+ProductoImporte+'&ProductoCostoIngreso='+ProductoCostoIngreso+'&ProductoCostoIngresoNeto='+ProductoCostoIngresoNeto+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&AlmacenMovimientoDetalleEstado='+AlmacenMovimientoDetalleEstado+'&ProductoAlmacenMovimientoDetalleId='+ProductoAlmacenMovimientoDetalleId+'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncGastoDetalleListar();
							}
						});
						
							//	if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}
//								
								
					
					FncGastoDetalleNuevo();	
					
					
			}
	
}


function FncGastoDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Cargando...');
	
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	
	var TotalRecargo = $('#CmpTotalRecargo').val();
	
	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/Gasto/FrmGastoDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+GastoDetalleEditar+'&Eliminar='+GastoDetalleEliminar+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio+'&TotalRecargo='+TotalRecargo,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapGastoDetalles").html("");
			$("#CapGastoDetalles").append(html);
			
			FncGastoCostoVinculadoListar();
		}
	});
	
}



function FncGastoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpGastoDetalleAccion').val("AccGastoDetalleEditar.php");

//SesionObjeto-GastoDetalle
//Parametro1 = GadId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = GadIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = GadEstado

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Gasto/acc/AccGastoDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsGastoDetalle){
				$('#CmpProductoId').val(InsGastoDetalle.Parametro2);	
				$('#CmpProductoNombre').val(InsGastoDetalle.Parametro3);		
				$('#CmpProductoCostoIngresoNeto').val(InsGastoDetalle.Parametro4);	
				$('#CmpProductoAnterior').val(InsGastoDetalle.Parametro15);	
				$('#CmpProductoCantidad').val(InsGastoDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsGastoDetalle.Parametro6);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoCodigoOriginal').val(InsGastoDetalle.Parametro17);
				$('#CmpProductoCodigoAlternativo').val(InsGastoDetalle.Parametro18);
				$('#CmpProductoUnidadMedida').val(InsGastoDetalle.Parametro19);
				
				$('#CmpAlmacenMovimientoDetalleEstado').val(InsGastoDetalle.Parametro25);

				$('#CmpProductoItem').val(InsGastoDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsGastoDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsGastoDetalle.Parametro19,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsGastoDetalle.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
				})
				
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+$("#CmpProductoUnidadMedida").val()+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
					$("#CmpProductoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
					$('#CmpProductoCosto').val($('#CmpProductoCosto').val() * j[0].UmcEquivalente);
					$('#CmpProductoImporte').val($('#CmpProductoCosto').val() * $('#CmpProductoCantidad').val());
				})
			});
			
	
			$('#CmpProductoCantidad').select();
		}
	});
	
	
	$('#CmpProductoId').attr('readonly', true);
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);


	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	

	

		//$('#CmpProductoCantidad').removeAttr('readonly');
//		$('#CmpProductoImporte').removeAttr('readonly');
//		$('#CmpProductoCostoIngresoNeto').removeAttr('readonly');
//		
//		$('#CmpProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//		$('#CmpProductoCodigoAlternativo').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//		
//		$('#CmpProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//		$('#CmpProductoImporte').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//		$('#CmpProductoCostoIngresoNeto').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja"); 
		
		
		
}




/*
function FncGastoDetalleEscogerReemplazo(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpGastoDetalleAccion').val("AccGastoDetalleReemplazar.php");

//
//SesionObjeto-GastoDetalle
//Parametro1 = GadId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen


	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Gasto/acc/AccGastoDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsGastoDetalle){

				$('#CmpProductoId').val(InsGastoDetalle.Parametro2);	
				$('#CmpProductoNombre').val(InsGastoDetalle.Parametro3);		
				$('#CmpProductoCostoIngresoNeto').val(InsGastoDetalle.Parametro4);	
				$('#CmpProductoAnterior').val(InsGastoDetalle.Parametro15);	
				$('#CmpProductoCantidad').val(InsGastoDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsGastoDetalle.Parametro6);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoCodigoOriginal').val(InsGastoDetalle.Parametro17);
				$('#CmpProductoCodigoAlternativo').val(InsGastoDetalle.Parametro18);
				$('#CmpProductoUnidadMedida').val(InsGastoDetalle.Parametro19);

				$('#CmpProductoItem').val(InsGastoDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsGastoDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsGastoDetalle.Parametro19,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsGastoDetalle.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
				})
				
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+$("#CmpProductoUnidadMedida").val()+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
					$("#CmpProductoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
					$('#CmpProductoCosto').val($('#CmpProductoCosto').val() * j[0].UmcEquivalente);
					$('#CmpProductoImporte').val($('#CmpProductoCosto').val() * $('#CmpProductoCantidad').val());
				})
			});

			$('#CmpProductoCodigoOriginal').select();
		}
	});
	
	$('#CmpProductoId').attr('readonly', true);
	
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);
	
	$('#CmpProductoCantidad').attr('readonly', true);
	$('#CmpProductoImporte').attr('readonly', true);
	$('#CmpProductoCostoIngresoNeto').attr('readonly', true);
	
	
	$('#CmpProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
	$('#CmpProductoCodigoAlternativo').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
	
	$('#CmpProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
	$('#CmpProductoImporte').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
	$('#CmpProductoCostoIngresoNeto').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
	
}*/



function FncGastoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Gasto/acc/AccGastoDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncGastoDetalleListar();
			}
		});
		
		FncGastoDetalleNuevo();

	}
	
}



function FncGastoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Gasto/acc/AccGastoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncGastoDetalleListar();
			}
		});	
			
		FncGastoDetalleNuevo();
	}
	
}




