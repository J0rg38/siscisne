// JavaScript Document

function FncTrasladoAlmacenEntradaDetalleNuevo(){
	
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
	
	$('#CmpTrasladoAlmacenEntradaDetalleEstado').val("3");
	$('#CmpTrasladoAlmacenEntradaDetalleId').val("");
	$('#CmpTrasladoAlmacenEntradaDetalleUbicacion').val("");
	
	$('#CmpProductoItem').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpTrasladoAlmacenEntradaDetalleAccion').val("AccTrasladoAlmacenEntradaDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");

					
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	

	//FncProductoNuevo();
}

function FncTrasladoAlmacenEntradaDetalleGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpTrasladoAlmacenEntradaDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var TrasladoAlmacenEntradaDetalleEstado = $('#CmpTrasladoAlmacenEntradaDetalleEstado').val();
			var TrasladoAlmacenEntradaDetalleId = $('#CmpTrasladoAlmacenEntradaDetalleId').val();
			var TrasladoAlmacenEntradaDetalleUbicacion = $('#CmpTrasladoAlmacenEntradaDetalleUbicacion').val();
			
			var ProductoCantidad = $('#CmpProductoCantidad').val();
		
			var Item = $('#CmpProductoItem').val();

			var Accion = $('#CmpTrasladoAlmacenEntradaDetalleAccion').val();
			

			if(ProductoId==""){
				alert("No existe el PRODUCTO");
				FncProductoCargarFormulario("Registrar");
			}else if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertir').focus();	
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#CmpProductoCantidad').select();	
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/TrasladoAlmacenEntrada/acc/'+Acc,
							data: 'Identificador='+Identificador+
							'&ProductoId='+ProductoId+
							'&ProductoCantidad='+ProductoCantidad+
							'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
							'&ProductoUnidadMedida='+ProductoUnidadMedida+
							'&TrasladoAlmacenEntradaDetalleEstado='+TrasladoAlmacenEntradaDetalleEstado+
							'&TrasladoAlmacenEntradaDetalleId='+TrasladoAlmacenEntradaDetalleId+
							'&TrasladoAlmacenEntradaDetalleUbicacion='+TrasladoAlmacenEntradaDetalleUbicacion+
							'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncTrasladoAlmacenEntradaDetalleListar();
							}
						});
						
							//	if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}
//								
								
					
					FncTrasladoAlmacenEntradaDetalleNuevo();	
					
					
			}
	
}


function FncTrasladoAlmacenEntradaDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/TrasladoAlmacenEntrada/FrmTrasladoAlmacenEntradaDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+TrasladoAlmacenEntradaDetalleEditar+
		'&Eliminar='+TrasladoAlmacenEntradaDetalleEliminar,
	
		success: function(html){

			$('#CapProductoAccion').html('Listo');	
			$("#CapTrasladoAlmacenEntradaDetalles").html("");
			$("#CapTrasladoAlmacenEntradaDetalles").append(html);

		}
	});
	
}



function FncTrasladoAlmacenEntradaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpTrasladoAlmacenEntradaDetalleAccion').val("AccTrasladoAlmacenEntradaDetalleEditar.php");

//SesionObjeto-TrasladoAlmacenEntradaDetalle
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
//Parametro26 = AmdUbicacion

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TrasladoAlmacenEntrada/acc/AccTrasladoAlmacenEntradaDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsTrasladoAlmacenEntradaDetalle){
				$('#CmpProductoId').val(InsTrasladoAlmacenEntradaDetalle.Parametro2);	
				$('#CmpProductoNombre').val(InsTrasladoAlmacenEntradaDetalle.Parametro3);	
				$('#CmpProductoCantidad').val(InsTrasladoAlmacenEntradaDetalle.Parametro5);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoCodigoOriginal').val(InsTrasladoAlmacenEntradaDetalle.Parametro17);
				$('#CmpProductoCodigoAlternativo').val(InsTrasladoAlmacenEntradaDetalle.Parametro18);
				$('#CmpProductoUnidadMedida').val(InsTrasladoAlmacenEntradaDetalle.Parametro19);
				
				$('#CmpTrasladoAlmacenEntradaDetalleEstado').val(InsTrasladoAlmacenEntradaDetalle.Parametro25);
				$('#CmpTrasladoAlmacenEntradaDetalleUbicacion').val(InsTrasladoAlmacenEntradaDetalle.Parametro26);

				$('#CmpProductoItem').val(InsTrasladoAlmacenEntradaDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsTrasladoAlmacenEntradaDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsTrasladoAlmacenEntradaDetalle.Parametro19,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsTrasladoAlmacenEntradaDetalle.Parametro10){
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
				})
			});
			
	
			$('#CmpProductoCantidad').select();
		}
	});
	
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
		
}


function FncTrasladoAlmacenEntradaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoAlmacenEntrada/acc/AccTrasladoAlmacenEntradaDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncTrasladoAlmacenEntradaDetalleListar();
			}
		});
		
		FncTrasladoAlmacenEntradaDetalleNuevo();

	}
	
}



function FncTrasladoAlmacenEntradaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoAlmacenEntrada/acc/AccTrasladoAlmacenEntradaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncTrasladoAlmacenEntradaDetalleListar();
			}
		});	
			
		FncTrasladoAlmacenEntradaDetalleNuevo();
	}
	
}




