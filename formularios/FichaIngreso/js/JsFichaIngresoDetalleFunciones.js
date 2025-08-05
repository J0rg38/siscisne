// JavaScript Document

//function FncFichaIngresoDetalleNuevo(){
//	
//	$('#CmpDetalleId').val("");
//	$('#CmpDetalleDescripcion').val("");
//	$('#CmpDetalleImporte').val("");
//	$('#CmpDetalleItem').val("");	
//			
//	$('#CapDetalleAccion').html('Listo para registrar elementos');	
//			
//	$('#CmpDetalleId').select();
//			
//	$('#CmpFichaIngresoDetalleAccion').val("AccFichaIngresoDetalleRegistrar.php");
//
//	$('#CmpDetalleId').removeAttr('readonly');
//
//}
//
//function FncFichaIngresoDetalleGuardar(){
//
//var Identificador = $('#Identificador').val();
//
//	var Acc = $('#CmpFichaIngresoDetalleAccion').val();		
//	
//			var Id = $('#CmpDetalleId').val();
//			var Descripcion = $('#CmpDetalleDescripcion').val();
//			var Importe = $('#CmpDetalleImporte').val();
//			var Item = $('#CmpDetalleItem').val();
//	
//			if(Id==""){
//				$('#CmpDetalleId').select();	
//			}else if(Importe==""){
//				$('#CmpDetalleImporte').select();						
//			}else{
//				$('#CapDetalleAccion').html('Guardando...');
//				
//				
//						$.ajax({
//							type: 'POST',
//							url: 'formularios/FichaIngreso/acc/'+Acc,
//							data: 'Identificador='+Identificador+'&Id='+Id+'&Descripcion='+Descripcion+'&Importe='+Importe+'&Item='+Item,
//							success: function(){
//								
//							$('#CapDetalleAccion').html('Listo');							
//								FncFichaIngresoDetalleListar();
//							}
//						});
//						
//						
//						
//								if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}
//								
//							FncFichaIngresoDetalleNuevo();	
//					
//					
//				}
//			
//
//	
//}


function FncFichaIngresoDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapDetalleAccion').html('Cargando...');

	var VehiculoVersionId = $("#CmpVehiculoIngresoVersionId").val();	
	var VehiculoKilometraje = $("#CmpVehiculoKilometraje").val();
	var MantenimientoKilometraje = $("#CmpMantenimientoKilometraje").val();
	
	
	if(VehiculoVersionId!=""){
		if(VehiculoKilometraje!=""){
	
				//$("#CapFichaIngresoDetalles").html("");
				
				$.ajax({
				type: 'POST',
				url: 'formularios/FichaIngreso/FrmFichaIngresoDetalleListado.php',
				data: 'Identificador='+Identificador+'&VehiculoVersionId='+VehiculoVersionId+'&VehiculoKilometraje='+VehiculoKilometraje+'&MantenimientoKilometraje='+MantenimientoKilometraje+'&Editar='+FichaIngresoDetalleEditar+'&Eliminar='+FichaIngresoDetalleEliminar+'&MecanicoAccion='+FichaIngresoDetalleMecanicoAccion,
				success: function(html){
					$('#CapDetalleAccion').html('Listo');	
					$("#CapFichaIngresoDetalles").html("");
					$("#CapFichaIngresoDetalles").append(html);
				}
			});
		}else{
		//	alert("Ingrese el Kilometraje");
		}
	}else{
		//alert("No se encontro el Modelo del Vehiculo");	
	}
	
	//
//	$.ajax({
//		type: 'POST',
//		url: 'formularios/FichaIngreso/CapFichaIngresoPlanMantenimientoTarea.php',
//		data: 'Identificador='+Identificador+'&Editar='+FichaIngresoPlanMantenimientoTareaEditar+'&Eliminar='+FichaIngresoPlanMantenimientoTareaEliminar+'&VehiculoVersionId='+VehiculoVersionId+'&VehiculoKilometraje='+VehiculoKilometraje,
//		success: function(html){
//			$("#CapFichaIngresoPlanMantenimientoTareas").html("");
//			$("#CapFichaIngresoPlanMantenimientoTareas").html(html);
//		}
//	});

}
//
//
//
//function FncFichaIngresoDetalleEscoger(oItem){
//		
//	var Identificador = $('#Identificador').val();
//	
//	$('#CapDetalleAccion').html('Editando...');
//	$('#CmpFichaIngresoDetalleAccion').val("AccFichaIngresoDetalleEditar.php");
//	
//	$.ajax({
//		type: 'POST',
//		dataType: 'json',
//		url: 'formularios/FichaIngreso/acc/AccFichaIngresoDetalleEscoger.php',
//		data: 'Identificador='+Identificador+'&Item='+oItem,
//		success: function(InsFichaIngresoDetalle){
//				$('#CmpDetalleId').val(InsFichaIngresoDetalle.Parametro2);	
//				$('#CmpDetalleDescripcion').val(InsFichaIngresoDetalle.Parametro3);		
//				$('#CmpDetalleImporte').val(InsFichaIngresoDetalle.Parametro6);
//				$('#CmpDetalleItem').val(InsFichaIngresoDetalle.Item);
//		}
//	});
//	
//	
//	$('#CmpDetalleCantidad').select();
//	
//	$('#CmpDetalleId').attr('readonly', true);
//
//
//}
//
//function FncFichaIngresoDetalleEliminar(oItem){
//
//	var Identificador = $('#Identificador').val();
//
//	if(confirm("¿Realmente desea eliminar el elemento?")){
//		
//		$('#CapDetalleAccion').html('Eliminando...');	
//		
//		$.ajax({
//			type: 'POST',
//			url: 'formularios/FichaIngreso/acc/AccFichaIngresoDetalleEliminar.php',
//			data: 'Identificador='+Identificador+'&Item='+oItem,
//			success: function(){
//				$('#CapDetalleAccion').html("Eliminado");	
//				FncFichaIngresoDetalleListar();
//			}
//		});
//
//		
//		FncFichaIngresoDetalleNuevo();
//		
//
//	}
//
//
//	
//}
//
//
//
//function FncFichaIngresoDetalleEliminarTodo(){
//
//	var Identificador = $('#Identificador').val();
//	
//	if(confirm("¿Realmente desea eliminar todos los elementos?")){
//		$('#CapDetalleAccion').html('Eliminando...');	
//	
//		$.ajax({
//			type: 'POST',
//			url: 'formularios/FichaIngreso/acc/AccFichaIngresoDetalleEliminarTodo.php',
//			data: 'Identificador='+Identificador,
//			success: function(){
//				$('#CapDetalleAccion').html('Eliminado');	
//				FncFichaIngresoDetalleListar();
//			}
//		});	
//			
//		FncFichaIngresoDetalleNuevo();
//	}
//	
//}
