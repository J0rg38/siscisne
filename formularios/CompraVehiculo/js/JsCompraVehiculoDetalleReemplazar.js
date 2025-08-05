// JavaScript Document


$(function(){

	$("#BtnVehiculoEditar").hide();
	$("#BtnVehiculoRegistrar").show();
	
});

function FncVehiculoNuevo(){


	$('#CmpVehiculoId').val("");
	$('#CmpVehiculoCantidad').val("");
//	$('#CmpVehiculoNombre').val("");
//	$('#CmpVehiculoImporte').val("");
//	$('#CmpVehiculoCostoAnterior').val("");
//	$('#CmpVehiculoCosto').val("");
//	$('#CmpVehiculoCostoIngreso').val("");
//	$('#CmpVehiculoCostoIngresoNeto').val("");
//	$('#CmpVehiculoCostoAux').val("");
//	$('#CmpVehiculoPrecio').val("");
//	$('#CmpVehiculoFoto').val("");
//	$('#CapVehiculoEspecificacion').html("");
//
//	$('#CmpVehiculoTipo').val("");
//	$('#CmpVehiculoUnidadMedida').val("");
//	$('#CmpVehiculoUnidadMedidaIngreso').val("");
	
	
	
	$('#CmpVehiculoCodigoOriginal').val("");
//	$('#CmpVehiculoCodigoAlternativo').val("");
//	$("select#CmpVehiculoUnidadMedidaConvertir").html("");
	
	$('#CmpVehiculoCodigoOriginal').removeAttr('readonly');
	$('#CmpVehiculoNombre').removeAttr('readonly');
	
	$("#BtnVehiculoEditar").hide();
	$("#BtnVehiculoRegistrar").show();
		
}

//function FncVehiculoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oCvdId,oProValorVenta){	

function FncVehiculoEscoger(InsVehiculo){	


//FncVehiculoEscoger(InsVehiculo.ProId,InsVehiculo.ProNombre,InsVehiculo.ProPrecio,InsVehiculo.ProCosto,InsVehiculo.ProFoto,InsVehiculo.ProEspecificacion,InsVehiculo.RtiId,InsVehiculo.UmeId,InsVehiculo.ProCodigoOriginal,InsVehiculo.ProCodigoAlternativo,InsVehiculo.UmeIdIngreso,InsVehiculo.ProCostoIngreso,InsVehiculo.ProCostoIngresoNeto,InsVehiculo.CvdId);

	$('#CmpVehiculoId').val(InsVehiculo.ProId);
//	$('#CmpVehiculoCantidad').val("");
	$('#CmpVehiculoNombre').val(InsVehiculo.ProNombre);
	//$('#CmpVehiculoImporte').val("");
//	$('#CmpVehiculoCostoAnterior').val(InsVehiculo.ProCostoIngreso);
//	$('#CmpVehiculoCosto').val(InsVehiculo.ProCosto);
//	$('#CmpVehiculoCostoIngreso').val(InsVehiculo.ProCostoIngreso);
//	$('#CmpVehiculoCostoIngresoNeto').val(InsVehiculo.ProCostoIngresoNeto);
//	$('#CmpVehiculoCostoAux').val(InsVehiculo.ProCosto);
//	$('#CmpVehiculoPrecio').val(InsVehiculo.ProPrecio);
//	$('#CmpVehiculoFoto').val(InsVehiculo.ProFoto);
//	$('#CapVehiculoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+InsVehiculo.ProEspecificacion+'">Archivo de Especificaciones<a/>');
//
//	$('#CmpVehiculoTipo').val(InsVehiculo.RtiId);
//	$('#CmpVehiculoUnidadMedida').val(InsVehiculo.UmeId);
//	$('#CmpVehiculoUnidadMedidaIngreso').val(InsVehiculo.UmeIdIngreso);
//	
//	if(InsVehiculo.UmeIdIngreso==""){
//		alert("No se encontro UNIDAD DE MEDIDA (INGRESO), se recomienda revisar el PRODUCTO y establecer uno.");
//	}
//	
//	if(InsVehiculo.UmeId==""){
//		alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
//	}

	
	$('#CmpVehiculoCodigoOriginal').val(InsVehiculo.ProCodigoOriginal);
//	$('#CmpVehiculoCodigoAlternativo').val(InsVehiculo.ProCodigoAlternativo);
	
	//$('#CmpCompraVehiculoDetalleId').val(InsVehiculo.CvdId);

///	$.getJSON("../../comunes/UnidadMedida/JnVehiculoTipoUnidadMedida.php?RtiId="+InsVehiculo.RtiId+"&Tipo=1&UnidadMedidaId="+InsVehiculo.UmeIdIngreso,{}, function(j){
//
//		var options = '';
//
//		options += '<option value="">Escoja una opcion</option>';
//		for (var i = 0; i < j.length; i++) {
//			if(InsVehiculo.UmeIdIngreso == j[i].UmeId){
//				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
//			}else{
//				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
//			}
//
//		}
//		$("select#CmpVehiculoUnidadMedidaConvertir").html(options);
//	})
//
//	$('#CmpVehiculoUnidadMedidaConvertir').unbind('change');
//	$("select#CmpVehiculoUnidadMedidaConvertir").change(function(){
//		$.getJSON("../../comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsVehiculo.UmeId+"&UnidadMedida2="+$(this).val(),{}, 
//		function(j){
//			$("#CmpVehiculoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
//			$('#CmpVehiculoCosto').val($('#CmpVehiculoCosto').val() * j[0].UmcEquivalente);
//			$('#CmpVehiculoImporte').val($('#CmpVehiculoCosto').val() * $('#CmpVehiculoCantidad').val());			
//		})
//	});
//	
	
	//$("#CmpVehiculoCantidad").select();
	
	$('#CmpVehiculoCodigoOriginal').attr('readonly', true);
	$('#CmpVehiculoNombre').attr('readonly', true);
	
	$("#BtnVehiculoEditar").show();
	$("#BtnVehiculoRegistrar").hide();
	
	
}


function FncVehiculoBuscar(oCampo){
	
	var Dato = $('#CmpVehiculo'+oCampo).val()
	
	if(Dato!=""){
		
		$("#CmpVehiculoCodigoOriginal").val("Cargando...");
		$("#CmpVehiculoNombre").val("Cargando...");
			
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Vehiculo/acc/AccVehiculoBuscar.php',
			data: 'Campo='+oCampo+
'&Dato='+Dato,
			success: function(InsVehiculo){
										
				if(InsVehiculo.ProId!="" & InsVehiculo.ProId!=null){
				
					FncVehiculoEscoger(InsVehiculo);
					
				}else{
					
					$("#CmpVehiculoCodigoOriginal").val("");
					$("#CmpVehiculoNombre").val("");
		
					$('#CmpVehiculo'+oCampo).focus();
					$('#CmpVehiculo'+oCampo).select();	
					
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

	$("#CmpVehiculoNombre").unautocomplete();
	$("#CmpVehiculoNombre").autocomplete(Ruta+'comunes/Vehiculo/XmlVehiculo.php?Cbu=ProNombre', {
		width: 600,
		max: 100,
		formatItem: FncFormato2,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpVehiculoNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpVehiculoId").val(data[0]);	
			
			$("#CmpVehiculoCodigoOriginal").val("Buscando...");
			$("#CmpVehiculoNombre").val("Buscando...");
						
			FncVehiculoBuscar("Id");	
		}		
	});





	$("#CmpVehiculoCodigoOriginal").unautocomplete();
	$("#CmpVehiculoCodigoOriginal").autocomplete(Ruta+'comunes/Vehiculo/XmlVehiculo.php?Cbu=ProCodigoOriginal&t=', {
		width: 150,
		max: 100,
		formatItem: FncFormato1,				
		minChars: 2,
		delay: 1000,
		cacheLength: 10,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpVehiculoCodigoOriginal").result(function(event, data, formatted) {
		if (data){
			$("#CmpVehiculoId").val(data[0]);	
			
			$("#CmpVehiculoCodigoOriginal").val("Cargando...");
			$("#CmpVehiculoNombre").val("Cargando...");
						
			FncVehiculoBuscar("Id");	
		}		
	});
	
//	$("#CmpVehiculoCodigoAlternativo").unautocomplete();
//	$("#CmpVehiculoCodigoAlternativo").autocomplete(Ruta+'comunes/Vehiculo/XmlVehiculo.php?Cbu=ProCodigoAlternativo&t=', {
//
//		width: 900,
//		max: 100,
//
//		formatItem: FncVehiculoFormato,				
//		minChars: 2,
//		delay: 1000,
//		cacheLength: 50,
//		scroll: true,
//		scrollHeight: 200
//	});	
//	
//	$("#CmpVehiculoCodigoAlternativo").result(function(event, data, formatted) {
//		if (data){
//			$("#CmpVehiculoId").val(data[0]);				
//			FncVehiculoBuscar("Id");	
//		}		
//	});
	
		
	
	
});


    
	