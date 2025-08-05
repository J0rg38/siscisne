// JavaScript Document

function FncValidar(){

	var Fecha = $("#CmpFecha").val();
	var Almacen = $("#CmpAlmacen").val();

		if(Fecha == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de salida",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});
				
			return false;
		
		}else if(Almacen == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un almacen",
					callback: function(result){
						$("#CmpAlmacen").focus();
					}
				});
				
			return false;
			
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
				$("#CmpEstado").removeAttr('disabled');		
		$("#CmpMonedaId").removeAttr('disabled');
		$("#CmpClienteTipo").removeAttr('disabled');		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');		
		$("#CmpIncluyeImpuesto").removeAttr('disabled');	

		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		$("#CmpMonedaId").removeAttr('disabled');
		$("#CmpClienteTipo").removeAttr('disabled');		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');		
		$("#CmpIncluyeImpuesto").removeAttr('disabled');	
		
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});

//
//function FncGuardar(){
//	
//	//HACK
//	$("#CmpEstado").removeAttr('disabled');		
//	$("#CmpMonedaId").removeAttr('disabled');
//	$("#CmpClienteTipo").removeAttr('disabled');		
//	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
//	$("#CmpIncluyeImpuesto").removeAttr('disabled');		
//		
//}

var FormularioCampos = ["CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpProductoCantidad",
"CmpProductoImporte",
];

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

	$("#CmpDescuento").keyup(function(){
		FncVentaConcretadaDetalleListar();
	});
	
	$("#CmpAlmacen").change(function(){
		FncVentaConcretadaDetalleListar();
	});
	
	
	
	if($("#CmpAlmacen").val()==""){
	
		$("#CmpAlmacen").prop("selectedIndex", 1);
	
	}
						

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
		
		
		if("CmpProductoImporte"==oCampo){
			$('#CmpProductoImporte').blur();
			FncVentaConcretadaDetalleGuardar();
		
		}
		
}

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oVcdId){	

	$('#CmpProductoId').val(oProId);
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoNombre').val(oProNombre);
	$('#CmpProductoImporte').val("");
	$('#CmpProductoCostoAnterior').val(oProCostoIngreso);
	$('#CmpProductoCosto').val(oProCosto);
	
	$('#CmpProductoCosto').val(oProCostoIngreso);
	$('#CmpProductoCostoIngreso').val(oProCostoIngreso);
	$('#CmpProductoCostoIngresoNeto').val(oProCostoIngresoNeto);
	$('#CmpProductoCostoAux').val(oProCosto);
	//$('#CmpProductoPrecio').val(oProPrecio);
	$('#CmpProductoFoto').val(oProFoto);
	$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+oProEspecificacion+'">Archivo de Especificaciones<a/>');

	$('#CmpProductoTipo').val(oRtiId);
	$('#CmpProductoUnidadMedida').val(oUmeId);
	$('#CmpProductoUnidadMedidaIngreso').val(oUnidadMedidaIngreso);

	$('#CmpProductoCodigoOriginal').val(oProCodigoOriginal);
	$('#CmpProductoCodigoAlternativo').val(oProCodigoAlternativo);
	
	$('#CmpProductoAlmacenMovimientoDetalleId').val(oVcdId);

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
	})

	$('#CmpProductoUnidadMedidaConvertir').unbind('change');
	$("select#CmpProductoUnidadMedidaConvertir").change(function(){
		
//		alert(":3a");
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
	
		function(j){
			//alert(j);
			var ProductoCosto = 0;
			var ProductoCostoAux = $('#CmpProductoCostoAux').val();
			//$("#CmpProductoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
			$("#CmpProductoUnidadMedidaEquivalente").val(j.UmcEquivalente);

			ProductoCosto = ProductoCostoAux * j.UmcEquivalente;
			ProductoCosto = Math.round(ProductoCosto*100000)/100000;

			$('#CmpProductoCosto').val(ProductoCosto);
			$('#CmpProductoImporte').val($('#CmpProductoCosto').val() * $('#CmpProductoCantidad').val());			
		})
	});
	
	var ClientePorcentajeUtilidad = $("#CmpClienteTipoUtilidad").val();
	var ProductoCosto = parseFloat($('#CmpProductoCosto').val());
	var ClienteUtilidad = 0;
	var ProductoPrecio = 0;
	
	ClienteUtilidad = (ClientePorcentajeUtilidad/100);
	//ProductoPrecio = (ClienteUtilidad*oProCosto) + oProCosto;
	ProductoPrecio = (ClienteUtilidad*ProductoCosto) + ProductoCosto;
	ProductoPrecio = Math.round(ProductoPrecio*100000)/100000 ;
	
	
	$('#CmpProductoPrecio').val(ProductoPrecio);
}









function FncProductoReemplazoCargar(oProductoCodigoOriginal){

	tb_show('','formularios/VentaConcretada/DiaProductoReemplazoBuscar.php?ProductoCodigoOriginal='+oProductoCodigoOriginal+
'&placeValuesBeforeTB_=savedValues','');	
  
}


function FncProductoConsultarCargar(oProductoId){

	tb_show('','formularios/Producto/DiaProductoConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}

function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}
