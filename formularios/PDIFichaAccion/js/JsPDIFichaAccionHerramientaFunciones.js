// JavaScript Document

/******************************************************************************/

function FncFichaAccionHerramientaNuevo(){
	
	$('#CmpHerramientaId').val("");
	$('#CmpHerramientaNombre').val("");
	$('#CmpHerramientaItem').val("");	
			
	$('#CmpHerramientaUnidadMedida').val("");
	$('select#CmpHerramientaUnidadMedidaConvertir').html('');
	$('#CmpHerramientaUnidadMedidaEquivalente').val("");	
	
	$('#CmpHerramientaCantidad').val("")

	$('#CapHerramientaAccion').html('Listo para registrar elementos');				
	$('#CmpHerramientaNombre').focus();			
	$('#CmpFichaAccionHerramientaAccion').val("AccPDIFichaAccionHerramientaRegistrar.php");
	
	$('#CmpHerramientaNombre').removeAttr('readonly');

}

function FncFichaAccionHerramientaGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpFichaAccionHerramientaAccion').val();		
	
	var HerramientaId = $('#CmpHerramientaId').val();
	var HerramientaNombre = $('#CmpHerramientaNombre').val();
	var Item = $('#CmpHerramientaItem').val();
	
	var HerramientaUnidadMedidaConvertir = $('#CmpHerramientaUnidadMedidaConvertir').val();
	var HerramientaCantidad = $('#CmpHerramientaCantidad').val();
	var HerramientaUnidadMedida = $('#CmpHerramientaUnidadMedida').val();
	
	if(HerramientaNombre==""){
		$('#CmpHerramientaNombre').select();	
	}else if(HerramientaUnidadMedidaConvertir==""){
		$('#CmpHerramientaUnidadMedidaConvertir').focus();	
	}else if(HerramientaCantidad=="" || HerramientaCantidad <=0){
		$('#CmpHerramientaCantidad').select();	
	}else{
		$('#CapHerramientaAccion').html('Guardando...');

		$.ajax({
		  type: 'POST',
		  url: 'formularios/PDIFichaAccion/acc/'+Acc,
		  data: 'Identificador='+Identificador+'&HerramientaNombre='+HerramientaNombre+'&HerramientaId='+HerramientaId+'&HerramientaUnidadMedidaConvertir='+HerramientaUnidadMedidaConvertir+'&HerramientaCantidad='+HerramientaCantidad+'&HerramientaUnidadMedida='+HerramientaUnidadMedida+'&Item='+Item,
		  success: function(){
			  
		  $('#CapHerramientaAccion').html('Listo');							
			  FncFichaAccionHerramientaListar();
		  }
		});
			
		FncFichaAccionHerramientaNuevo();	
	
	}

}


function FncFichaAccionHerramientaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapHerramientaAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/PDIFichaAccion/FrmPDIFichaAccionHerramientaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+FichaAccionHerramientaEditar+'&Eliminar='+FichaAccionHerramientaEliminar,
		success: function(html){
			$('#CapHerramientaAccion').html('Listo');	

			$("#CapFichaAccionHerramientas").html("");
			$("#CapFichaAccionHerramientas").append(html);
		}
	});

}


function FncFichaAccionHerramientaListar2(){

	var Identificador = $('#Identificador').val();

	$('#CapHerramientaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PDIFichaAccion/FrmPDIFichaAccionHerramientaListado2.php',
		data: 'Identificador='+Identificador+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#CapHerramientaAccion').html('Listo');	
			$("#CapFichaAccionHerramientas2").html("");
			$("#CapFichaAccionHerramientas2").append(html);
		}
	});
	
}


function FncFichaAccionHerramientaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapHerramientaAccion').html('Editando...');
	$('#CmpFichaAccionHerramientaAccion').val("AccPDIFichaAccionHerramientaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionHerramientaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsFichaAccionHerramienta){
			
	
//SesionObjeto-FichaAccionHerramienta
//Parametro1 = FihId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = FihVerificar1
//Parametro5 = FihVeriticar2
//Parametro6 = UmeId
//Parametro7 = FihTiempoCreacion
//Parametro8 = FihTiempoModificacion
//Parametro9 = FihCantidad
//Parametro10 = FihCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
	
			$('#CmpHerramientaId').val(InsFichaAccionHerramienta.Parametro2);
			$('#CmpHerramientaNombre').val(InsFichaAccionHerramienta.Parametro3);
			$('#CmpHerramientaItem').val(InsFichaAccionHerramienta.Item);
			$('#CmpHerramientaUnidadMedidaEquivalente').val(1);
			$('#CmpHerramientaCantidad').val(InsFichaAccionHerramienta.Parametro9);
			
			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsFichaAccionHerramienta.Parametro11+"&Tipo=1&UnidadMedidaId="+InsFichaAccionHerramienta.Parametro13,{}, function(j){
				var options = '';
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(j[i].UmeId == InsFichaAccionHerramienta.Parametro6){
						options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}else{
						options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}
				}
				$('select#CmpHerramientaUnidadMedidaConvertir').html(options);
			})
			
			$('#CmpHerramientaUnidadMedidaConvertir').attr('disabled', true);
				
				
}
	});
	

	$('#CmpHerramientaCantidad').select();

	$('#CmpHerramientaNombre').attr('readonly', true);
	
}

function FncFichaAccionHerramientaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapHerramientaAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionHerramientaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapHerramientaAccion').html("Eliminado");	
				FncFichaAccionHerramientaListar();
			}
		});

		FncFichaAccionHerramientaNuevo();

	}
	
}



function FncFichaAccionHerramientaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapHerramientaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionHerramientaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapHerramientaAccion').html('Eliminado');	
				FncFichaAccionHerramientaListar();
			}
		});	
			
		FncFichaAccionHerramientaNuevo();
	}
	
}
