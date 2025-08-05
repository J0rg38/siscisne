// JavaScript Document



function FncValidar(){

		var Destinatario = $("#CmpDestinatario").val();
	
		if(Destinatario == ""){		

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe de ingresar destinatarios",
					callback: function(result){
						$("#CmpDestinatario").focus();
					}
				});
							
			
			return false;

			
		}else{
			return true;
		}
		
	
}


$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');		
		$("#CmpOrigen").removeAttr('disabled');	
		$("#CmpClienterTipoDocumento").removeAttr('disabled');	
		$("#CmpIncluyeImpuesto").removeAttr('disabled');	
		$("#CmpPersonal").removeAttr('disabled');	

		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');		
		$("#CmpOrigen").removeAttr('disabled');	
		$("#CmpClienterTipoDocumento").removeAttr('disabled');	
		$("#CmpIncluyeImpuesto").removeAttr('disabled');	
		$("#CmpPersonal").removeAttr('disabled');	
		
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});

function FncGuardar(){
	
//	//HACK
//	$("#CmpClienteTipoDocumento").removeAttr('disabled');	
//	$("#CmpEstado").removeAttr('disabled');		
//	$("#CmpOrigen").removeAttr('disabled');	
//	$("#CmpIncluyeImpuesto").removeAttr('disabled');		
//	
//	//var ClienteId = $("#CmpClienteId").val();
////	
////	alert(ClienteId);
////	if(ClienteId==""){
////
////		alert("No ha registrado al cliente");
////		FncClienteCargarFormulario("Registrar")
////		return false
////
////	}

	
}

/************************************************************/
/************************************************************/

var FormularioCampos = ["CmpFecha",
"CmpClienteNombre",
"CmpClienteTipoDocumento",
"CmpClienteNumeroDocumento",
"CmpObservacion",
"CmpOrigen",
"CmpOrdenCompra",

"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",


"CmpPedidoCompraDetalleAno",
"CmpPedidoCompraDetalleModelo",
"CmpProductoPrecio",
"CmpProductoCantidad",
"CmpProductoImporte",
"CmpPedidoCompraDetalleObservacion"
];

//"CmpPedidoCompraDetalleCodigo",

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
		FncPedidoCompraEstablecerMoneda();
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
		
		if("CmpPedidoCompraDetalleObservacion"==oCampo){
			$('#CmpPedidoCompraDetalleObservacion').blur();
			FncPedidoCompraDetalleGuardar();
		}
		
}



/************************************************************/
//EXTRAS

function FncPedidoCompraEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncPedidoCompraDetalleListar();
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



function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}



/************************************************************/
//IMPRESION

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}




















/************************************************************/
/************************************************************/

function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oPcdId){	


	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
	var CostoIngreso = 0;

	if(EmpresaMonedaId == MonedaId){
	  $("#CmpProductoCosto").val(oProCostoIngreso);
	}else{
	  CostoIngreso = oProCostoIngreso / TipoCambio;
	  $("#CmpProductoCosto").val(oProCostoIngreso);
	}
	  
	$('#CmpProductoId').val(oProId);
	$('#CmpProductoCantidad').val(0);
	$('#CmpProductoNombre').val(oProNombre);
	$('#CmpProductoPrecio').val(0);
	$('#CmpProductoImporte').val(0);

	$('#CmpProductoFoto').val(oProFoto);
	$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+oProEspecificacion+'">Archivo de Especificaciones<a/>');

	$('#CmpProductoTipo').val(oRtiId);
	$('#CmpProductoUnidadMedida').val(oUmeId);
	$('#CmpProductoUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
	
	$('#CmpProductoCodigoOriginal').val(oProCodigoOriginal);
	$('#CmpProductoCodigoAlternativo').val(oProCodigoAlternativo);
	
	$('#CmpPedidoCompraDetalleCodigo').val(oProCodigoOriginal);

	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo=1&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){
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



	$.getJSON("comunes/Producto/JnProductoListaPrecio.php?ProductoCodigoOriginal="+oProCodigoOriginal,{}, function(j){
		
		var Precio = 0;
		
		if(j.PlpId != null){
			
			if(EmpresaMonedaId != MonedaId){

				if(MonedaId == j.MonId){
					Precio = j.PlpPrecioReal;
				}else{
					Precio = j.PlpPrecio/j.PlpTipoCambio;
				}

			}else{
				Precio = j.PlpPrecio;
			}
			
		}
		


			
			$('#CmpProductoPrecio').val(Precio);
			$('#CmpProductoCantidad').val(1);
			$('#CmpProductoImporte').val(Precio);		
			
			$('#CmpProductoCantidad').select();				


	});
	
	$('#CmpProductoNombre').attr('readonly', true);
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	
	

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
}




function FncProductoReemplazoCargar(oProductoCodigoOriginal){

	tb_show('','formularios/PedidoCompra/DiaProductoReemplazoBuscar.php?ProductoCodigoOriginal='+oProductoCodigoOriginal+
'&placeValuesBeforeTB_=savedValues','');	
  
}