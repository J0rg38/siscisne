// JavaScript Document


function FncGuardar(){
	
	//HACK
	$("#CmpProveedorTipoDocumento").removeAttr('disabled');	
	$("#CmpEstado").removeAttr('disabled');		
	$("#CmpOrigen").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');		
	//var ProveedorId = $("#CmpProveedorId").val();
//	
//	alert(ProveedorId);
//	if(ProveedorId==""){
//
//		alert("No ha registrado al cliente");
//		FncProveedorCargarFormulario("Registrar")
//		return false
//
//	}

	
}

/************************************************************/
/************************************************************/

var FormularioCampos = ["CmpFecha",
"CmpProveedorNombre",
"CmpProveedorTipoDocumento",
"CmpProveedorNumeroDocumento",
"CmpObservacion",
"CmpOrigen",
"CmpOrdenCompra",

"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",

"CmpOrdenCotizacionDetalleAno",
"CmpOrdenCotizacionDetalleModelo"

];

//"CmpOrdenCotizacionDetalleCodigo",

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
	$("select#CmpMonedaId").change(function(){
		FncOrdenCotizacionEstablecerMoneda();
	});

});
	
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
		
		if("CmpOrdenCotizacionDetalleModelo"==oCampo){
			$('#CmpOrdenCotizacionDetalleModelo').blur();
			FncOrdenCotizacionDetalleGuardar();
		}
		
}



/************************************************************/
//EXTRAS

function FncOrdenCotizacionEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncOrdenCotizacionDetalleListar();
		alert("Debe Escoger una moneda");
	}else{
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");
			}

		}
		FncMonedaBuscar('Id');
	}

}

function FncOrdenCompraNuevoFuncion(){

	$('#CmpOrdenCompraEnviar').attr('disabled', true);

}

function FncOrdenCompraFuncion(){

	$('#CmpOrdenCompraEnviar').removeAttr('disabled');

}
/************************************************************/
//IMPRESION

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/OrdenCotizacion/FrmOrdenCotizacionImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/OrdenCotizacion/FrmOrdenCotizacionImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}




















/************************************************************/
/************************************************************/

function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oPcdId){	

	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
	$('#CmpProductoId').val(oProId);
	//$('#CmpProductoCantidad').val(0);
	$('#CmpProductoNombre').val(oProNombre);
	//$('#CmpProductoPrecio').val(0);
	//$('#CmpProductoImporte').val(0);

	$('#CmpProductoFoto').val(oProFoto);
	$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+oProEspecificacion+'">Archivo de Especificaciones<a/>');

	$('#CmpProductoTipo').val(oRtiId);
	$('#CmpProductoUnidadMedida').val(oUmeId);
	$('#CmpProductoUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
	
	$('#CmpProductoCodigoOriginal').val(oProCodigoOriginal);
	$('#CmpProductoCodigoAlternativo').val(oProCodigoAlternativo);
	
	$('#CmpOrdenCotizacionDetalleCodigo').val(oProCodigoOriginal);

	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo="+UnidadMedidaTipo+'&UnidadMedidaId='+oUnidadMedidaIngreso,{}, function(j){
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

	$('#CmpProductoNombre').attr('readonly', true);
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	
	$('#CmpOrdenCotizacionDetalleAno').focus();

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
}



