// JavaScript Document

function FncAlmacenMovimientoEntradaDetalleNuevo(){
	
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
			
	$('#CmpAlmacenMovimientoEntradaDetalleAccion').val("AccAlmacenMovimientoEntradaDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");

					
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	
	
	
//	var Accion = $('#CmpAlmacenMovimientoEntradaDetalleAccion').val();

//	if(Accion != "AccAlmacenMovimientoEntradaDetalleReemplazar.php"){
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

function FncAlmacenMovimientoEntradaDetalleGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpAlmacenMovimientoEntradaDetalleAccion').val();		
	
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


			var Accion = $('#CmpAlmacenMovimientoEntradaDetalleAccion').val();
			var OrdenCompra = $('#CmpOrdenCompra').val();

			/*if(Accion == "AccAlmacenMovimientoEntradaDetalleRegistrar.php" && OrdenCompra != "" ){
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
							url: 'formularios/AlmacenMovimientoEntrada/acc/'+Acc,
							data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&ProductoCosto='+ProductoCosto+'&ProductoCostoAnterior='+ProductoCostoAnterior+'&ProductoCantidad='+ProductoCantidad+'&ProductoImporte='+ProductoImporte+'&ProductoCostoIngreso='+ProductoCostoIngreso+'&ProductoCostoIngresoNeto='+ProductoCostoIngresoNeto+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&AlmacenMovimientoDetalleEstado='+AlmacenMovimientoDetalleEstado+'&ProductoAlmacenMovimientoDetalleId='+ProductoAlmacenMovimientoDetalleId+'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncAlmacenMovimientoEntradaDetalleListar();
							}
						});
						
							//	if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}
//								
								
					
					FncAlmacenMovimientoEntradaDetalleNuevo();	
					
					
			}
	
}


function FncAlmacenMovimientoEntradaDetalleListar(){

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
		url: 'formularios/AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+AlmacenMovimientoEntradaDetalleEditar+'&Eliminar='+AlmacenMovimientoEntradaDetalleEliminar+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio+'&TotalRecargo='+TotalRecargo,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapAlmacenMovimientoEntradaDetalles").html("");
			$("#CapAlmacenMovimientoEntradaDetalles").append(html);
			
			FncAlmacenMovimientoEntradaCostoVinculadoListar();
		}
	});
	
}



function FncAlmacenMovimientoEntradaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpAlmacenMovimientoEntradaDetalleAccion').val("AccAlmacenMovimientoEntradaDetalleEditar.php");

//SesionObjeto-AlmacenMovimientoEntradaDetalle
//Parametro1 = AmdId
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
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = AmdEstado

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsAlmacenMovimientoEntradaDetalle){
				$('#CmpProductoId').val(InsAlmacenMovimientoEntradaDetalle.Parametro2);	
				$('#CmpProductoNombre').val(InsAlmacenMovimientoEntradaDetalle.Parametro3);		
				$('#CmpProductoCostoIngresoNeto').val(InsAlmacenMovimientoEntradaDetalle.Parametro4);	
				$('#CmpProductoAnterior').val(InsAlmacenMovimientoEntradaDetalle.Parametro15);	
				$('#CmpProductoCantidad').val(InsAlmacenMovimientoEntradaDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsAlmacenMovimientoEntradaDetalle.Parametro6);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoCodigoOriginal').val(InsAlmacenMovimientoEntradaDetalle.Parametro17);
				$('#CmpProductoCodigoAlternativo').val(InsAlmacenMovimientoEntradaDetalle.Parametro18);
				$('#CmpProductoUnidadMedida').val(InsAlmacenMovimientoEntradaDetalle.Parametro19);
				
				$('#CmpAlmacenMovimientoDetalleEstado').val(InsAlmacenMovimientoEntradaDetalle.Parametro25);

				$('#CmpProductoItem').val(InsAlmacenMovimientoEntradaDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsAlmacenMovimientoEntradaDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsAlmacenMovimientoEntradaDetalle.Parametro19,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsAlmacenMovimientoEntradaDetalle.Parametro10){
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
function FncAlmacenMovimientoEntradaDetalleEscogerReemplazo(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpAlmacenMovimientoEntradaDetalleAccion').val("AccAlmacenMovimientoEntradaDetalleReemplazar.php");

//
//SesionObjeto-AlmacenMovimientoEntradaDetalle
//Parametro1 = AmdId
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
		url: 'formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsAlmacenMovimientoEntradaDetalle){

				$('#CmpProductoId').val(InsAlmacenMovimientoEntradaDetalle.Parametro2);	
				$('#CmpProductoNombre').val(InsAlmacenMovimientoEntradaDetalle.Parametro3);		
				$('#CmpProductoCostoIngresoNeto').val(InsAlmacenMovimientoEntradaDetalle.Parametro4);	
				$('#CmpProductoAnterior').val(InsAlmacenMovimientoEntradaDetalle.Parametro15);	
				$('#CmpProductoCantidad').val(InsAlmacenMovimientoEntradaDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsAlmacenMovimientoEntradaDetalle.Parametro6);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoCodigoOriginal').val(InsAlmacenMovimientoEntradaDetalle.Parametro17);
				$('#CmpProductoCodigoAlternativo').val(InsAlmacenMovimientoEntradaDetalle.Parametro18);
				$('#CmpProductoUnidadMedida').val(InsAlmacenMovimientoEntradaDetalle.Parametro19);

				$('#CmpProductoItem').val(InsAlmacenMovimientoEntradaDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsAlmacenMovimientoEntradaDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsAlmacenMovimientoEntradaDetalle.Parametro19,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsAlmacenMovimientoEntradaDetalle.Parametro10){
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



function FncAlmacenMovimientoEntradaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncAlmacenMovimientoEntradaDetalleListar();
			}
		});
		
		FncAlmacenMovimientoEntradaDetalleNuevo();

	}
	
}



function FncAlmacenMovimientoEntradaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncAlmacenMovimientoEntradaDetalleListar();
			}
		});	
			
		FncAlmacenMovimientoEntradaDetalleNuevo();
	}
	
}




