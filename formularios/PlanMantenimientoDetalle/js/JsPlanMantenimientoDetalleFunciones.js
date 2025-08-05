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

	$("#CmpProductoCodigoOriginal").keyup(function (event) {  
		 //if (event.keyCode == '13' && this.value != "" && $("#CmpProductoNombre").val()=="") {
//			FncProductoBuscar("NumeroDocumento")
//		 }

		if($.trim($("#CmpProductoCodigoOriginal").val())==""){
			 FncTareaProductoDetalleNuevo();
		}
		
	});

	//$("#CmpProductoNombre").keypress(function (event) {  
	$("#CmpProductoNombre").keyup(function (event) {  		
		//if (event.keyCode == '13' && this.value != "" && $("#CmpProductoId").val()=="") {
//			FncProductoBuscar("NombreCompleto")
//		}

		if($.trim($("#CmpProductoNombre").val())==""){
			 FncTareaProductoDetalleNuevo();
		}
	}); 

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