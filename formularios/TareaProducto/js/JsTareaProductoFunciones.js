
function FncGuardar(){

	//HACK
	$("#CmpPlanMantenimientoDetalleAccion").removeAttr('disabled');	
			
}



$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

	if($("#CmpProductoId").val()==""){
		$("#BtnProductoEditar").hide();
		$("#BtnProductoRegistrar").show();
	}else{
		$("#BtnProductoEditar").show();
		$("#BtnProductoRegistrar").hide();
	}

//	$("#CmpProductoCodigoOriginal").keyup(function (event) {  
//		 //if (event.keyCode == '13' && this.value != "" && $("#CmpProductoNombre").val()=="") {
////			FncProductoBuscar("NumeroDocumento")
////		 }
//
//		if($.trim($("#CmpProductoCodigoOriginal").val())==""){
//			 FncTareaProductoDetalleNuevo();
//		}
//		
//	});

//	//$("#CmpProductoNombre").keypress(function (event) {  
//	$("#CmpProductoNombre").keyup(function (event) {  		
//		//if (event.keyCode == '13' && this.value != "" && $("#CmpProductoId").val()=="") {
////			FncProductoBuscar("NombreCompleto")
////		}
//
//		if($.trim($("#CmpProductoNombre").val())==""){
//			 FncTareaProductoDetalleNuevo();
//		}
//	}); 

});	



function FncTareaProductoDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");
	$('#CmpTareaProductoDetalleCantidad').val("");
	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoUnidadMedidaConvertir').html("");
	
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
	
	$("#BtnListaPrecioEditar").hide();
}




/*function FncTareaProductoCargarFormulario(oForm,oTareaProductoId){

	tb_show(this.title,'principal2.php?Mod=TareaProducto&Form='+oForm+'&Dia=1&Id='+oTareaProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}*/





function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oAmdId,oProValorVenta){	

	$('#CmpProductoId').val(oProId);
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoNombre').val(oProNombre);
	$('#CmpProductoImporte').val("");
	$('#CmpProductoCostoAnterior').val(oProCostoIngreso);
	$('#CmpProductoCosto').val(oProCosto);
	$('#CmpProductoCostoIngreso').val(oProCostoIngreso);
	$('#CmpProductoCostoIngresoNeto').val(oProCostoIngresoNeto);
	$('#CmpProductoCostoAux').val(oProCosto);
	$('#CmpProductoPrecio').val(oProPrecio);
	$('#CmpProductoFoto').val(oProFoto);
	$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+oProEspecificacion+'">Archivo de Especificaciones<a/>');

	$('#CmpProductoTipo').val(oRtiId);
	$('#CmpProductoUnidadMedida').val(oUmeId);
	$('#CmpProductoUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
	
	if(oUnidadMedidaIngreso==""){
		alert("No se encontro UNIDAD DE MEDIDA (INGRESO), se recomienda revisar el PRODUCTO y establecer uno.");
	}
	
	if(oUmeId==""){
		alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
	}

	
	$('#CmpProductoCodigoOriginal').val(oProCodigoOriginal);
	$('#CmpProductoCodigoAlternativo').val(oProCodigoAlternativo);
	
	$('#CmpProductoAlmacenMovimientoDetalleId').val(oAmdId);

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
	})

	$('#CmpProductoUnidadMedidaConvertir').unbind('change');
	$("select#CmpProductoUnidadMedidaConvertir").change(function(){
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){
			$("#CmpProductoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
			$('#CmpProductoCosto').val($('#CmpProductoCosto').val() * j[0].UmcEquivalente);
			$('#CmpProductoImporte').val($('#CmpProductoCosto').val() * $('#CmpProductoCantidad').val());			
		})
	});
	
	
	$("#CmpProductoCantidad").select();
	
	
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
	FncProductoFuncion();

//	try{
//		tb_remove();
//	}catch(e){
//		
//	}
}

