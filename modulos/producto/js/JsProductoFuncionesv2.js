var ProductoLector = 1;
var UnidadMedidaTipo = 1;

$(function(){

	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
	
});

function FncProductoNuevo(){


	$('#CmpProductoId').val("");
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoNombre').val("");
	$('#CmpProductoImporte').val("");
	$('#CmpProductoCostoAnterior').val("");
	$('#CmpProductoCosto').val("");
	$('#CmpProductoCostoIngreso').val("");
	$('#CmpProductoCostoIngresoNeto').val("");
	$('#CmpProductoCostoAux').val("");
	$('#CmpProductoPrecio').val("");
	$('#CmpProductoFoto').val("");
	$('#CapProductoEspecificacion').html("");

	$('#CmpProductoTipo').val("");
	$('#CmpProductoUnidadMedida').val("");
	$('#CmpProductoUnidadMedidaIngreso').val("");
	
	
	
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoCodigoAlternativo').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html("");
	
	
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
		
}

function FncProductoEscoger(InsProducto){	

	$('#CmpProductoId').val(InsProducto.ProId);
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoNombre').val(InsProducto.ProNombre);
	$('#CmpProductoImporte').val("");
	$('#CmpProductoCostoAnterior').val(InsProducto.ProCostoIngreso);
	$('#CmpProductoCosto').val(InsProducto.ProCosto);
	$('#CmpProductoCostoIngreso').val(InsProducto.ProCostoIngreso);
	$('#CmpProductoCostoIngresoNeto').val(InsProducto.ProCostoIngresoNeto);
	$('#CmpProductoCostoAux').val(InsProducto.ProCosto);
	$('#CmpProductoPrecio').val(InsProducto.ProPrecio);
	$('#CmpProductoFoto').val(InsProducto.ProFoto);
	$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+InsProducto.ProEspecificacion+'">Archivo de Especificaciones<a/>');

	$('#CmpProductoTipo').val(InsProducto.RtiId);
	$('#CmpProductoUnidadMedida').val(InsProducto.UmeId);
	$('#CmpProductoUnidadMedidaIngreso').val(InsProducto.UnidadMedidaIngreso);
	
	if(InsProducto.UmeIdIngreso==""){
		alert("No se encontro UNIDAD DE MEDIDA (INGRESO), se recomienda revisar el PRODUCTO y establecer uno.");
	}
	
	if(InsProducto.UmeId==""){
		alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
	}

	
	$('#CmpProductoCodigoOriginal').val(InsProducto.ProCodigoOriginal);
	$('#CmpProductoCodigoAlternativo').val(InsProducto.ProCodigoAlternativo);
	
	$('#CmpProductoAlmacenMovimientoDetalleId').val(InsProducto.AmdId);

	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProducto.RtiId+"&Tipo="+UnidadMedidaTipo+"&UnidadMedidaId="+InsProducto.UmeIdIngreso,{}, function(j){

		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if(InsProducto.UmeIdIngreso == j[i].UmeId){
				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
			}

		}
		$("select#CmpProductoUnidadMedidaConvertir").html(options);
	})

	$('#CmpProductoUnidadMedidaConvertir').unbind('change');
	$("select#CmpProductoUnidadMedidaConvertir").change(function(){
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsProducto.UmeId+"&UnidadMedida2="+$(this).val(),{}, 
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


function FncProductoFuncion(){
	
}






function FncProductoBuscar(oCampo){
	
	var Dato = $('#CmpProducto'+oCampo).val()
	
if(Dato!=""){
	
	var ProductoLector = $('#CmpProductoLector:checked').val();
	
	if(ProductoLector=="1"){
		
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
				data: 'Campo='+oCampo+'&Dato='+Dato,
				success: function(InsProducto){

						if(InsProducto.ProId!="" & InsProducto.ProId!=null){

							FncProductoEscoger(InsProducto);

							var ProductoNombre = $('#CmpProductoNombre').val();

							if(ProductoNombre!="undefined" & ProductoNombre!=""){
								$('#CmpProductoCantidad').val(1);
								$('#CmpProductoImporte').val(InsProducto.ProPrecio*1);
								//eval(ProductoFuncion+"Guardar();");
							}

						}else{
							
							dhtmlx.alert({
								title:"Aviso",
								type:"alert-error",
								text:"No se encontraron datos",
								callback: function(result){
								
								}
							});
							
							$('#CmpProducto'+oCampo).focus();
							$('#CmpProducto'+oCampo).select();											
						}
					
				}
			});
			

	}else{
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){

					FncProductoEscoger(InsProducto);
				}else{
					
					dhtmlx.alert({
						title:"Aviso",
						type:"alert-error",
						text:"No se encontraron datos",
						callback: function(result){
						
						}
					});
				
				
					$('#CmpProducto'+oCampo).focus();
					$('#CmpProducto'+oCampo).select();						
				}
				
			}
		});
		

	}

}

}






/*
* Funciones PopUp Formulario
*/

function FncProductoCargarFormulario(oForm){

	var ProductoId = $('#CmpProductoId').val();
	var ProductoNombre = $('#CmpProductoNombre').val();
	var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
	var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginal').val();	
	var ProductoCodigoAlternativo = $('#CmpProductoCodigoAlternativo').val();	
	

tb_show(this.title,'principal2.php?Mod=Producto&Form='+oForm+'&Dia=1&ProductoId='+ProductoId+'&Id='+ProductoId+'&ProductoCodigoOriginal='+ProductoCodigoOriginal+'&ProductoNombre='+ProductoNombre+'&ProductoCodigoAlternativo='+ProductoCodigoAlternativo+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	

			
//	var ProductoId = $('#CmpProductoId').val();
//	tb_show(this.title,'principal2.php?Mod=Producto&Form='+oForm+'&Dia=1&Id='+ProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncTBCerrarFunncion(oModulo){



	if (typeof oModulo == 'string' || oModulo instanceof String){
		if(oModulo!="" && oModulo!=null && oModulo!="undefined"){
			
			//eval("Fnc"+oModulo+"Buscar('Id');");		
			try{
				eval("Fnc"+oModulo+"Buscar('Id');");		
			}catch(e){
				
			}
		}
	}

}

/*
* Funciones PopUp Listado
*/

function FncProductoListar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	
	else if(e) keyCode=e.which;
	
	if (keyCode==13){		
		FncProductoListar2();		
	}	
	
}

function FncProductoListar2(){	

	var ProductoTipo = $('#CmpProductoTipos').val();
	var Campo = $('#CmpProductoCampo').val();
	var Condicion = $('#CmpProductoCondicion').val();
	var Filtro = $('#CmpProductoFiltro').val();		

	$.ajax({
		type: 'POST',
		dataType : 'html',
		url: Ruta+ 'comunes/Producto/FrmProductoListado.php',
		data: 'ProductoTipo='+ProductoTipo+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
		success: function(html){
			$('#CapProductos').html("");
			$('#CapProductos').append(html);
		}
	});

}



/*
* Funciones Detalle
*/

function FncProductoCalcularMonto(oTipo){

	var Tipo;
	var Cantidad = $('#CmpProductoCantidad').val();
	var Importe = $('#CmpProductoImporte').val();	

//alert(Cantidad);

	if(Cantidad!=""){
		if(Importe!=""){
			Tipo = Importe/Cantidad;
			//var Tipo=parseFloat(Tipo);
			//Tipo=Math.round(Tipo*100000)/100000 ;
//			document.getElementById('CmpProducto'+oTipo).value = Tipo;
			$('#CmpProducto'+oTipo).val(Tipo);
		}else{
			//document.getElementById('CmpProductoImporte').value = 0.00;
		}
	}else{
		//document.getElementById('CmpProductoCantidad').value = 0.00;
	}
}

function FncProductoCalcularImporte(oTipo){
	
//	alert(oTipo);

	var Tipo = $('#CmpProducto'+oTipo).val();
//	alert('#CmpProducto'+oTipo);
	var Cantidad = $('#CmpProductoCantidad').val();
	var Importe;
		
//	alert(Tipo);
	if(Cantidad!=""){
		if(Tipo!=""){
			Importe = Tipo * Cantidad;
			//var Importe=parseFloat(Importe);
			//Importe=Math.round(Importe*100000)/100000 ;
			//document.getElementById('CmpProductoImporte').value = Importe;
			$('#CmpProductoImporte').val(Importe);
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpProductoCantidad').value = 0.00;
	}
}

function FncProductoListadorEscoger(oProductoId){

	$('#CmpProductoId').val(oProductoId);
	FncProductoBuscar("Id");
	tb_remove();

}




function FncProductoNotificarSinStock(oProductoId){
	
	if(confirm("¿Realmente desea NOTIFICAR la revision de este PRODUCTO.")){
	
		$.ajax({
			type: 'POST',
			url: 'comunes/Producto/acc/AccProductoNotificarSinStock.php',
			data: 'ProductoId='+oProductoId,
			success: function(oRespuesta){
		
				if(oRespuesta=="1"){
					
					alert("Se ha notificado correctamente el producto");
					
				}
		
			}
		});
			
	}


}


function FncProductoParcharStock(oProductoId,oCantidad){

	$.ajax({
		type: 'POST',
		url: 'comunes/Producto/acc/AccProductoParcharStock.php',
		data: 'ProductoId='+oProductoId+'&Cantidad='+oCantidad,
		success: function(oRespuesta){
	
			if(oRespuesta=="1"){
				alert("Se ha parchado correctamente el stock del producto");
			}
	
		}
	});

}







