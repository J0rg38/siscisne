// JavaScript Document

function FncGuardar(){

//HACK
//	$('#CmpClienteTipo').removeAttr('disabled');
	$('#CmpEstado').removeAttr('disabled');
	//$('#CmpMonedaId').removeAttr('disabled');
	$('#CmpTipoOperacion').removeAttr('disabled');
}



var FormularioCampos = ["CmpFecha",
"CmpTipoOperacion",
"CmpEstado",
"CmpObservacion",
"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpProductoCantidad"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncAlmacenMovimientoNavegar(this.id);
		 }
	}); 
	
	/*$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 
	
	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	});*/ 
	
	
/*
Agregando Eventos
*/

	//$("select#CmpClienteTipo").change(function(){
	//	FncTrasladoAlmacenSalidaDetalleActualizarPrecio();
	//});
	
	$("#CmpDescuento").keyup(function(){
		FncTrasladoAlmacenSalidaDetalleListar();
	});
	
});
	
/*****************************************************************/


function FncAlmacenMovimientoNavegar(oCampo){
	
		for(var i=0; i< FormularioCampos.length; i++) {
			if(FormularioCampos.length !== i + 1){
				
				if(FormularioCampos[i]==oCampo){
					
					if($('#'+FormularioCampos[i+1]).attr('type')=="text"){
						$('#'+FormularioCampos[i]).blur();
						$('#'+FormularioCampos[i+1]).focus();
						$('#'+FormularioCampos[i+1]).select();	
					}else{
						$('#'+FormularioCampos[i]).blur();	
						$('#'+FormularioCampos[i+1]).focus();	
					}
									
				}				
				
			}
				
		}
		
		if("CmpProductoCantidad"==oCampo){
			$('#CmpProductoCantidad').blur();
			FncTrasladoAlmacenSalidaDetalleGuardar();
		
		}
		
}

/*****************************************************************/

function FncTBCerrarFunncion(){
	
}


function FncFichaIngresoCargarFormulario(oForm,oFichaIngresoId){

	tb_show(this.title,'principal2.php?Mod=FichaIngreso&Form='+oForm+'&Dia=1&Id='+oFichaIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncVentaDirectaCargarFormulario(oForm,oVentaDirectaId){

	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


/*****************************************************************/


function FncGenerarBoleta(){
	
	document.getElementById(Formulario).action = "principal.php?Mod=Boleta&Form=Registrar&Ori=TrasladoAlmacenSalida"//1
	document.getElementById(Formulario).submit();
	document.getElementById(Formulario).action = "#";

}

function FncGenerarFactura(){
	
	document.getElementById(Formulario).action = "principal.php?Mod=Factura&Form=Registrar&Ori=TrasladoAlmacenSalida"//1
	document.getElementById(Formulario).submit();
	document.getElementById(Formulario).action = "#";

}

function FncGenerarGuiaRemision(){
	
	document.getElementById(Formulario).action = "principal.php?Mod=GuiaRemision&Form=Registrar&Ori=TrasladoAlmacenSalida"//1
	document.getElementById(Formulario).submit();
	document.getElementById(Formulario).action = "#";

}

/*****************************************************************/

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/TrasladoAlmacenSalida/FrmTrasladoAlmacenSalidaImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/TrasladoAlmacenSalida/FrmTrasladoAlmacenSalidaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
}



function FncProductoFormato(row) {			
	
//	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[4]+"</td>";
	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td>";
	
}




/*****************************************************************/
/*
function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oAmdId){	

	//var ClienteId = $("#CmpClienteId").val();
	var ClienteTipoId = $("#CmpClienteTipo").val();
	
	//if(ClienteId==""){
	//	alert("Escoja primero un CLIENTE");
	//	FncTrasladoAlmacenSalidaDetalleNuevo();
	//	$('#CmpClienteNombre').focus();
		
	//}else{

		if(oUnidadMedidaIngreso==""){
			alert("No se encontro UNIDAD DE MEDIDA (INGRESO), se recomienda revisar el PRODUCTO y establecer uno.");
		}
		
		if(oUmeId==""){
			alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
		}
//		if(oProPrecio!=0 || oProPrecio != ""){

		if(ClienteTipoId==""){
			FncTrasladoAlmacenSalidaDetalleNuevo();
			alert("No se encontro el TIPO DE CLIENTE.");
		}else{

		
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

			$('#CmpProductoCodigoOriginal').val(oProCodigoOriginal);
			$('#CmpProductoCodigoAlternativo').val(oProCodigoAlternativo);

			$('#CmpProductoAlmacenMovimientoDetalleId').val(oAmdId);

			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo=2&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){
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
			});
		
			$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){
				//$("#CmpProductoPrecio"+oSigla).val(j.LprValorVenta);
				$("#CmpProductoPrecio").val(j.LprPrecio);
			});
		
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
		
					var ProductoCosto = 0;
					var ProductoCostoAux = $('#CmpProductoCostoAux').val();
					//$("#CmpProductoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
					$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
		
					ProductoCosto = ProductoCostoAux * j.UmcEquivalente;
					ProductoCosto = Math.round(ProductoCosto*100000)/100000;
		
					$('#CmpProductoCosto').val(ProductoCosto);
		
				})
				
				$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+$(this).val(),{}, function(j){
					$("#CmpProductoPrecio").val(j.LprPrecio);
				})
				
			});			
			

			
		}
//		}else{
//			alert("No se encontro PRECIO para el PRODUCTO");			
//		}


//
//* POPUP REGISTRAR/EDITAR
//				
			$("#BtnProductoEditar").show();
			$("#BtnProductoRegistrar").hide();
		
			$("#BtnListaPrecioEditar").show();
			
		
	//}

	$("#CmpProductoCantidad").focus();

	
}*/
/*
function FncProductoBuscar(oCampo){
	
	var Dato = $('#CmpProducto'+oCampo).val()
	var ClienteTipo = $("#CmpClienteTipo").val();
	
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

							FncProductoEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProPrecio,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);

							var ProductoNombre = $('#CmpProductoNombre').val();

							if(ProductoNombre!="undefined" & ProductoNombre!=""){
								$('#CmpProductoCantidad').val(1);
								$('#CmpProductoImporte').val(InsProducto.ProPrecio*1);
								//eval(ProductoFuncion+"Guardar();");
							}

						}else{
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
			data: 'Campo='+oCampo+'&Dato='+Dato+'&ClienteTipo='+ClienteTipo,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){

					FncProductoEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProPrecio,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);
					
				}else{
					$('#CmpProducto'+oCampo).focus();
					$('#CmpProducto'+oCampo).select();						
				}
				
			}
		});
		

	}

}

}

*/




function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}
