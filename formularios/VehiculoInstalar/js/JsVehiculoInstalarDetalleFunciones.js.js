// JavaScript Document

function FncVehiculoInstalarDetalleNuevo(){
	
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
	
	$('#CmpProductoVehiculoInstalarDetalleEstado').val("3");
	$('#CmpProductoVehiculoInstalarDetalleId').val("");
	
	$('#CmpProductoItem').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpVehiculoInstalarDetalleAccion').val("AccVehiculoInstalarDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");

					
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	
	
	
//	var Accion = $('#CmpVehiculoInstalarDetalleAccion').val();

//	if(Accion != "AccVehiculoInstalarDetalleReemplazar.php"){
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

function FncVehiculoInstalarDetalleGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpVehiculoInstalarDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var VehiculoInstalarDetalleEstado = $('#CmpVehiculoInstalarDetalleEstado').val();
			var ProductoVehiculoInstalarDetalleId = $('#CmpProductoVehiculoInstalarDetalleId').val();
			var ProductoCosto = $('#CmpProductoCostoIngreso').val();
			var ProductoCostoAnterior = $('#CmpProductoCostoAnterior').val();
			var ProductoCostoIngresoNeto = $('#CmpProductoCostoIngresoNeto').val();
			var ProductoCostoIngreso = $('#CmpProductoCostoIngreso').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var Item = $('#CmpProductoItem').val();

			var Accion = $('#CmpVehiculoInstalarDetalleAccion').val();
			

			if(ProductoId==""){
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
							url: 'formularios/VehiculoInstalar/acc/'+Acc,
							data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&ProductoCosto='+ProductoCosto+'&ProductoCostoAnterior='+ProductoCostoAnterior+'&ProductoCantidad='+ProductoCantidad+'&ProductoImporte='+ProductoImporte+'&ProductoCostoIngreso='+ProductoCostoIngreso+'&ProductoCostoIngresoNeto='+ProductoCostoIngresoNeto+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&VehiculoInstalarDetalleEstado='+VehiculoInstalarDetalleEstado+'&ProductoVehiculoInstalarDetalleId='+ProductoVehiculoInstalarDetalleId+'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncVehiculoInstalarDetalleListar();
							}
						});
						
							//	if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}
//								
								
					
					FncVehiculoInstalarDetalleNuevo();	
					
					
			}
	
}


function FncVehiculoInstalarDetalleListar(){

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
		url: 'formularios/VehiculoInstalar/FrmVehiculoInstalarDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+VehiculoInstalarDetalleEditar+
		'&Eliminar='+VehiculoInstalarDetalleEliminar+
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio+
		'&TotalRecargo='+TotalRecargo,
		
		success: function(html){

			$('#CapProductoAccion').html('Listo');	
			$("#CapVehiculoInstalarDetalles").html("");
			$("#CapVehiculoInstalarDetalles").append(html);

		}
	});
	
}



function FncVehiculoInstalarDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpVehiculoInstalarDetalleAccion').val("AccVehiculoInstalarDetalleEditar.php");

//SesionObjeto-VehiculoInstalarDetalle
//Parametro1 = VsdId
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
//Parametro20 = VsdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto
//Parametro25 = VsdEstado

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoInstalar/acc/AccVehiculoInstalarDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsVehiculoInstalarDetalle){
				$('#CmpProductoId').val(InsVehiculoInstalarDetalle.Parametro2);	
				$('#CmpProductoNombre').val(InsVehiculoInstalarDetalle.Parametro3);		
				$('#CmpProductoCostoIngresoNeto').val(InsVehiculoInstalarDetalle.Parametro4);	
				$('#CmpProductoAnterior').val(InsVehiculoInstalarDetalle.Parametro15);	
				$('#CmpProductoCantidad').val(InsVehiculoInstalarDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsVehiculoInstalarDetalle.Parametro6);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoCodigoOriginal').val(InsVehiculoInstalarDetalle.Parametro17);
				$('#CmpProductoCodigoAlternativo').val(InsVehiculoInstalarDetalle.Parametro18);
				$('#CmpProductoUnidadMedida').val(InsVehiculoInstalarDetalle.Parametro19);
				
				$('#CmpVehiculoInstalarDetalleEstado').val(InsVehiculoInstalarDetalle.Parametro25);

				$('#CmpProductoItem').val(InsVehiculoInstalarDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsVehiculoInstalarDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsVehiculoInstalarDetalle.Parametro19,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsVehiculoInstalarDetalle.Parametro10){
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
	//$('#CmpProductoCodigoOriginal').attr('readonly', true);
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
function FncVehiculoInstalarDetalleEscogerReemplazo(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpVehiculoInstalarDetalleAccion').val("AccVehiculoInstalarDetalleReemplazar.php");

//
//SesionObjeto-VehiculoInstalarDetalle
//Parametro1 = VsdId
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
		url: 'formularios/VehiculoInstalar/acc/AccVehiculoInstalarDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsVehiculoInstalarDetalle){

				$('#CmpProductoId').val(InsVehiculoInstalarDetalle.Parametro2);	
				$('#CmpProductoNombre').val(InsVehiculoInstalarDetalle.Parametro3);		
				$('#CmpProductoCostoIngresoNeto').val(InsVehiculoInstalarDetalle.Parametro4);	
				$('#CmpProductoAnterior').val(InsVehiculoInstalarDetalle.Parametro15);	
				$('#CmpProductoCantidad').val(InsVehiculoInstalarDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsVehiculoInstalarDetalle.Parametro6);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoCodigoOriginal').val(InsVehiculoInstalarDetalle.Parametro17);
				$('#CmpProductoCodigoAlternativo').val(InsVehiculoInstalarDetalle.Parametro18);
				$('#CmpProductoUnidadMedida').val(InsVehiculoInstalarDetalle.Parametro19);

				$('#CmpProductoItem').val(InsVehiculoInstalarDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsVehiculoInstalarDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsVehiculoInstalarDetalle.Parametro19,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsVehiculoInstalarDetalle.Parametro10){
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



function FncVehiculoInstalarDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoInstalar/acc/AccVehiculoInstalarDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncVehiculoInstalarDetalleListar();
			}
		});
		
		FncVehiculoInstalarDetalleNuevo();

	}
	
}



function FncVehiculoInstalarDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoInstalar/acc/AccVehiculoInstalarDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncVehiculoInstalarDetalleListar();
			}
		});	
			
		FncVehiculoInstalarDetalleNuevo();
	}
	
}




