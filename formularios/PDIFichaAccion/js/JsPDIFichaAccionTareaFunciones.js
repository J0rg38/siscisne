// JavaScript Document

function FncFichaAccionTareaNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'TareaId').val("");
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').val("");
	
	$('#Cmp'+oModalidadIngreso+'TareaEspecificacion').val("");
	$('#Cmp'+oModalidadIngreso+'TareaCosto').val("");
	
	$('#Cmp'+oModalidadIngreso+'TareaAccion').val("");
	$('#Cmp'+oModalidadIngreso+'TareaItem').val("");	
			
	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo para registrar elementos');	
			
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();
			
	$('#CmpFichaAccion'+oModalidadIngreso+'TareaAccion').val("AccPDIFichaAccionTareaRegistrar.php");

}

function FncFichaAccionTareaGuardar(oModalidadIngreso){

var Identificador = $('#Identificador').val();

	var Acc = $('#CmpFichaAccion'+oModalidadIngreso+'TareaAccion').val();		
	
			var TareaDescripcion = $('#Cmp'+oModalidadIngreso+'TareaDescripcion').val();
			var TareaEspecificacion = $('#Cmp'+oModalidadIngreso+'TareaEspecificacion').val();
			var TareaCosto = $('#Cmp'+oModalidadIngreso+'TareaCosto').val();
			
			var TareaDescripcion = $('#Cmp'+oModalidadIngreso+'TareaDescripcion').val();
			var TareaAccion = $('#Cmp'+oModalidadIngreso+'TareaAccion').val();
			var Item = $('#Cmp'+oModalidadIngreso+'TareaItem').val();
	
			if(TareaDescripcion==""){
				$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();	
			}else if(TareaAccion==""){
				$('#Cmp'+oModalidadIngreso+'TareaAccion').select();						
			}else{
				$('#Cap'+oModalidadIngreso+'TareaAccion').html('Guardando...');
				
				
						$.ajax({
							type: 'POST',
							url: 'formularios/PDIFichaAccion/acc/'+Acc,
							data: 'Identificador='+Identificador+'&TareaDescripcion='+TareaDescripcion+'&TareaEspecificacion='+TareaEspecificacion+'&TareaCosto='+TareaCosto+'&TareaAccion='+TareaAccion+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(){
								
							$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');							
								FncFichaAccionTareaListar(oModalidadIngreso);
							}
						});
						
						
						
								/*if(confirm("Desea seguir agregando mas items?")==false){
									if(confirm("Desea guardar el registro ahora?")){
										$('#Guardar').val("1");
										$('#'+Formulario).submit();
									}
								}*/
								
							FncFichaAccionTareaNuevo(oModalidadIngreso);	
					
					
				}
			

	
}


function FncFichaAccionTareaListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}
	
	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PDIFichaAccion/FrmPDIFichaAccionTareaListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&Editar='+FichaAccionTareaEditar+'&Eliminar='+FichaAccionTareaEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	
			//alert(html);
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas").append(html);
		}
	});
	
}

function FncFichaAccionTareaListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PDIFichaAccion/FrmPDIFichaAccionTareaListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	

			$("#CapFichaAccion"+oModalidadIngreso+"Tareas2").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas2").append(html);
		}
	});
	
}

function FncFichaAccionTareaEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Editando...');
	$('#CmpFichaAccion'+oModalidadIngreso+'TareaAccion').val("AccPDIFichaAccionTareaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionTareaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaAccionTarea){
			
//		SesionObjeto-FichaAccionTarea
//		Parametro1 = FatId
//		Parametro2 =
//		Parametro3 = FatDescripcion
//		Parametro4 = FatVerificar1
//		Parametro5 = FatVerificar2
//		Parametro6 = FatAccion
//		Parametro7 = FatTiempoCreacion
//		Parametro8 = FatTiempoModificacion
//		Parametro9 = FatEstado
//		Parametro10 = FitId

//		Parametro11 = FatEspecificacion
//		Parametro12 = FatCosto

				$('#Cmp'+oModalidadIngreso+'TareaDescripcion').val(InsFichaAccionTarea.Parametro3);		
				$('#Cmp'+oModalidadIngreso+'TareaAccion').val(InsFichaAccionTarea.Parametro6);
				
				$('#Cmp'+oModalidadIngreso+'TareaEspecificacion').val(InsFichaAccionTarea.Parametro11);
				$('#Cmp'+oModalidadIngreso+'TareaCosto').val(InsFichaAccionTarea.Parametro12);
				
				$('#Cmp'+oModalidadIngreso+'TareaItem').val(InsFichaAccionTarea.Item);
		}
	});
	
	
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();
	
}

function FncFichaAccionTareaEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionTareaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TareaAccion').html("Eliminado");	
				FncFichaAccionTareaListar(oModalidadIngreso);
			}
		});

		
		FncFichaAccionTareaNuevo(oModalidadIngreso);
		

	}


	
}



function FncFichaAccionTareaEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionTareaEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminado');	
				FncFichaAccionTareaListar(oModalidadIngreso);
			}
		});	
			
		FncFichaAccionTareaNuevo(oModalidadIngreso);
	}
	
}
