// JavaScript Document

function FncGuardar(){

//HACK
	$('#CmpClienteTipo').removeAttr('disabled');
	$('#CmpEstado').removeAttr('disabled');
	$('#CmpMonedaId').removeAttr('disabled');
		
}



var FormularioCampos = ["CmpFecha",
"CmpTipoOperacion",
"CmpEstado",
"CmpObservacion",
"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpProductoCantidad",
"CmpProductoCosto",
"CmpProductoImporte",
"CmpFichaIngreso"];

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
	//	FncAlmacenMovimientoSalidaDetalleActualizarPrecio();
	//});
	
	$("#CmpDescuento").keyup(function(){
		FncAlmacenMovimientoSalidaDetalleListar();
	});
	
	
	$("select#CmpMonedaId").change(function(){
		FncAlmacenMovimientoSalidaEstablecerMoneda();
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
		
		if("CmpProductoImporte"==oCampo){
			$('#CmpProductoImporte').blur();
			FncAlmacenMovimientoSalidaDetalleGuardar();
		
		}
		
}

/*****************************************************************/

function FncTBCerrarFunncion(){
	
}




function FncAlmacenMovimientoSalidaEstablecerMoneda(){

	//var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		$('#CmpTipoCambio').attr('readonly', true);	
		
		FncAlmacenMovimientoSalidaDetalleListar();

		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
			$('#CmpTipoCambio').attr('readonly', true);	
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			}
			$('#CmpTipoCambio').removeAttr('readonly');	
			//$('#CmpTipoCambio').val(TcaMontoCompra)
		}
		FncMonedaBuscar('Id');
	}

}

function FncFichaIngresoCargarFormulario(oForm,oFichaIngresoId){

	tb_show(this.title,'principal2.php?Mod=FichaIngreso&Form='+oForm+'&Dia=1&Id='+oFichaIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncVentaDirectaCargarFormulario(oForm,oVentaDirectaId){

	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


/*****************************************************************/


function FncGenerarBoleta(){
	
	document.getElementById(Formulario).action = "principal.php?Mod=Boleta&Form=Registrar&Ori=AlmacenMovimientoSalida"//1
	document.getElementById(Formulario).submit();
	document.getElementById(Formulario).action = "#";

}

function FncGenerarFactura(){
	
	document.getElementById(Formulario).action = "principal.php?Mod=Factura&Form=Registrar&Ori=AlmacenMovimientoSalida"//1
	document.getElementById(Formulario).submit();
	document.getElementById(Formulario).action = "#";

}

function FncGenerarGuiaRemision(){
	
	document.getElementById(Formulario).action = "principal.php?Mod=GuiaRemision&Form=Registrar&Ori=AlmacenMovimientoSalida"//1
	document.getElementById(Formulario).submit();
	document.getElementById(Formulario).action = "#";

}

/*****************************************************************/

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
}








/*****************************************************************/

//FncProductoEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProPrecio,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);
function FncProductoEscoger(InsProducto){	

	var ClienteTipoId = $("#CmpClienteTipo").val();
	
	if(InsProducto.UmeIdIngreso==""){
		FncAlmacenMovimientoSalidaDetalleNuevo();
		alert("No se encontro UNIDAD DE MEDIDA (INGRESO).");
	}
	
	if(InsProducto.UmeId==""){
		FncAlmacenMovimientoSalidaDetalleNuevo();
		alert("No se encontro UNIDAD DE MEDIDA (BASE).");
	}
	
	if(ClienteTipoId==""){
		FncAlmacenMovimientoSalidaDetalleNuevo();
		alert("No se encontro el TIPO DE CLIENTE.");
	}else{
	
	
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
		
		//$('#CmpProductoFoto').val(InsProducto.ProFoto);
		//$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+oProEspecificacion+'">Archivo de Especificaciones<a/>');
	
		$('#CmpProductoTipo').val(InsProducto.RtiId);
		$('#CmpProductoUnidadMedida').val(InsProducto.UmeId);
		$('#CmpProductoUnidadMedidaIngreso').val(InsProducto.UmeIdIngreso);
	
		$('#CmpProductoCodigoOriginal').val(InsProducto.ProCodigoOriginal);
		$('#CmpProductoCodigoAlternativo').val(InsProducto.ProCodigoAlternativo);
	
		$('#CmpProductoAlmacenMovimientoDetalleId').val(InsProducto.AmdId);
	
		$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProducto.RtiId+"&Tipo=2&UnidadMedidaId="+InsProducto.UmeIdIngreso,{}, function(j){
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
		});
	
		$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+InsProducto.ProId+"&ProductoTipoId="+InsProducto.RtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+InsProducto.UmeIdIngreso,{}, function(j){
			$("#CmpProductoPrecio").val(j.LprPrecio);
		});
	
		$('#CmpProductoUnidadMedidaConvertir').unbind('change');
		$("select#CmpProductoUnidadMedidaConvertir").change(function(){
			$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsProducto.UmeId+"&UnidadMedida2="+$(this).val(),{}, 
			function(j){
	
				var ProductoCosto = 0;
				var ProductoCostoAux = $('#CmpProductoCostoAux').val();
				
				$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);
	
				ProductoCosto = ProductoCostoAux * j.UmcEquivalente;
				ProductoCosto = Math.round(InsProducto.ProCosto*100000)/100000;
	
				$('#CmpProductoCosto').val(ProductoCosto);
	
			})
			
			$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+InsProducto.ProId+"&ProductoTipoId="+InsProducto.RtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+$(this).val(),{}, function(j){
				$("#CmpProductoPrecio").val(j.LprPrecio);
			})
			
		});			
		
	
		
	}
//
//* POPUP REGISTRAR/EDITAR
//				
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();

//	$("#BtnListaPrecioEditar").show();

	$("#CmpProductoCantidad").focus();

}

/*
*
*/

function FncProductoBuscar(oCampo){
	
	var Dato = $('#CmpProducto'+oCampo).val()
	
	if(Dato!=""){
	
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){

					FncProductoEscoger(InsProducto);
					
				}else{
					$('#CmpProducto'+oCampo).focus();
					$('#CmpProducto'+oCampo).select();						
				}
				
			}
		});
		

	}

}






function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}
