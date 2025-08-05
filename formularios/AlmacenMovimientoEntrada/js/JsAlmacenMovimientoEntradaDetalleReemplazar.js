// JavaScript Document


$(function(){

	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
	
});

function FncProductoNuevo(){


	$('#CmpProductoId').val("");
	$('#CmpProductoCantidad').val("");
//	$('#CmpProductoNombre').val("");
//	$('#CmpProductoImporte').val("");
//	$('#CmpProductoCostoAnterior').val("");
//	$('#CmpProductoCosto').val("");
//	$('#CmpProductoCostoIngreso').val("");
//	$('#CmpProductoCostoIngresoNeto').val("");
//	$('#CmpProductoCostoAux').val("");
//	$('#CmpProductoPrecio').val("");
//	$('#CmpProductoFoto').val("");
//	$('#CapProductoEspecificacion').html("");
//
//	$('#CmpProductoTipo').val("");
//	$('#CmpProductoUnidadMedida').val("");
//	$('#CmpProductoUnidadMedidaIngreso').val("");
	
	
	
	$('#CmpProductoCodigoOriginal').val("");
//	$('#CmpProductoCodigoAlternativo').val("");
//	$("select#CmpProductoUnidadMedidaConvertir").html("");
	
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
		
}

//function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oAmdId,oProValorVenta){	

function FncProductoEscoger(InsProducto){	


//FncProductoEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProPrecio,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);

	$('#CmpProductoId').val(InsProducto.ProId);
//	$('#CmpProductoCantidad').val("");
	$('#CmpProductoNombre').val(InsProducto.ProNombre);
	//$('#CmpProductoImporte').val("");
//	$('#CmpProductoCostoAnterior').val(InsProducto.ProCostoIngreso);
//	$('#CmpProductoCosto').val(InsProducto.ProCosto);
//	$('#CmpProductoCostoIngreso').val(InsProducto.ProCostoIngreso);
//	$('#CmpProductoCostoIngresoNeto').val(InsProducto.ProCostoIngresoNeto);
//	$('#CmpProductoCostoAux').val(InsProducto.ProCosto);
//	$('#CmpProductoPrecio').val(InsProducto.ProPrecio);
//	$('#CmpProductoFoto').val(InsProducto.ProFoto);
//	$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+InsProducto.ProEspecificacion+'">Archivo de Especificaciones<a/>');
//
//	$('#CmpProductoTipo').val(InsProducto.RtiId);
//	$('#CmpProductoUnidadMedida').val(InsProducto.UmeId);
//	$('#CmpProductoUnidadMedidaIngreso').val(InsProducto.UmeIdIngreso);
//	
//	if(InsProducto.UmeIdIngreso==""){
//		alert("No se encontro UNIDAD DE MEDIDA (INGRESO), se recomienda revisar el PRODUCTO y establecer uno.");
//	}
//	
//	if(InsProducto.UmeId==""){
//		alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
//	}

	
	$('#CmpProductoCodigoOriginal').val(InsProducto.ProCodigoOriginal);
//	$('#CmpProductoCodigoAlternativo').val(InsProducto.ProCodigoAlternativo);
	
	//$('#CmpProductoAlmacenMovimientoDetalleId').val(InsProducto.AmdId);

///	$.getJSON("../../comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProducto.RtiId+"&Tipo=1&UnidadMedidaId="+InsProducto.UmeIdIngreso,{}, function(j){
//
//		var options = '';
//
//		options += '<option value="">Escoja una opcion</option>';
//		for (var i = 0; i < j.length; i++) {
//			if(InsProducto.UmeIdIngreso == j[i].UmeId){
//				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
//			}else{
//				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
//			}
//
//		}
//		$("select#CmpProductoUnidadMedidaConvertir").html(options);
//	})
//
//	$('#CmpProductoUnidadMedidaConvertir').unbind('change');
//	$("select#CmpProductoUnidadMedidaConvertir").change(function(){
//		$.getJSON("../../comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsProducto.UmeId+"&UnidadMedida2="+$(this).val(),{}, 
//		function(j){
//			$("#CmpProductoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
//			$('#CmpProductoCosto').val($('#CmpProductoCosto').val() * j[0].UmcEquivalente);
//			$('#CmpProductoImporte').val($('#CmpProductoCosto').val() * $('#CmpProductoCantidad').val());			
//		})
//	});
//	
	
	//$("#CmpProductoCantidad").select();
	
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);
	
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
	
}


function FncProductoBuscar(oCampo){
	
	var Dato = $('#CmpProducto'+oCampo).val()
	
	if(Dato!=""){
		
		$("#CmpProductoCodigoOriginal").val("Cargando...");
		$("#CmpProductoNombre").val("Cargando...");
			
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+
'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){
				
					FncProductoEscoger(InsProducto);
					
				}else{
					
					$("#CmpProductoCodigoOriginal").val("");
					$("#CmpProductoNombre").val("");
		
					$('#CmpProducto'+oCampo).focus();
					$('#CmpProducto'+oCampo).select();	
					
					alert("No se encontraron datos");					
				}
				
			}
		});
		

	}

}






$(function(){
	
	function FncFormato1(row) {			
	
		return "<td>"+row[8]+"</td>";
	
	}
	
	function FncFormato2(row) {			
	
		return "<td>"+row[9]+"</td><td>"+row[1]+"</td>";
	
	}

	$("#CmpProductoNombre").unautocomplete();
	$("#CmpProductoNombre").autocomplete(Ruta+'comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
		width: 600,
		max: 100,
		formatItem: FncFormato2,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoId").val(data[0]);	
			
			$("#CmpProductoCodigoOriginal").val("Buscando...");
			$("#CmpProductoNombre").val("Buscando...");
						
			FncProductoBuscar("Id");	
		}		
	});





	$("#CmpProductoCodigoOriginal").unautocomplete();
	$("#CmpProductoCodigoOriginal").autocomplete(Ruta+'comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&t=', {
		width: 150,
		max: 100,
		formatItem: FncFormato1,				
		minChars: 2,
		delay: 1000,
		cacheLength: 10,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoCodigoOriginal").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoId").val(data[0]);	
			
			$("#CmpProductoCodigoOriginal").val("Cargando...");
			$("#CmpProductoNombre").val("Cargando...");
						
			FncProductoBuscar("Id");	
		}		
	});
	
//	$("#CmpProductoCodigoAlternativo").unautocomplete();
//	$("#CmpProductoCodigoAlternativo").autocomplete(Ruta+'comunes/Producto/XmlProducto.php?Cbu=ProCodigoAlternativo&t=', {
//
//		width: 900,
//		max: 100,
//
//		formatItem: FncProductoFormato,				
//		minChars: 2,
//		delay: 1000,
//		cacheLength: 50,
//		scroll: true,
//		scrollHeight: 200
//	});	
//	
//	$("#CmpProductoCodigoAlternativo").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpProductoId").val(data[0]);				
//			FncProductoBuscar("Id");	
//		}		
//	});
	
		
	
	
});


    
	