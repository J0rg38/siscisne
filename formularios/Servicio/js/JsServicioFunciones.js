
function FncValidar(){

	var Nombre = $("#CmpNombre").val();
	var Importe = $("#CmpImporte").val();
	var MonedaId = $("#CmpMonedaId").val();

		if(Nombre == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre",
					callback: function(result){
						$("#CmpNombre").focus();
					}
				});
				
			return false;
		}else if(Importe == "" || Importe == "0.00"){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un importe",
					callback: function(result){
						$("#CmpImporte").focus();
					}
				});
				
			return false;
			
		}else if(MonedaId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#CmpMonedaId").focus();
					}
				});
				
			return false;
			
		}else{
			return true;
		}

}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});











var FormularioCampos = ["CmpFecha",
"CmpNombre",
"CmpDescripcion",
"CmpMonedaId",
"CmpImporte",

"CmpProductoCodigoOriginal",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpServicioDetalleCantidad"
];


$().ready(function() {

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden" && this.type !=="image") {
			FncVentaDirectaNavegar(this.id);
		 }
	}); 

	$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" && this.type !=="image") {
			$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 

	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" && this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 



});


function FncVentaDirectaNavegar(oCampo){

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

	if("CmpServicioDetalleCantidad"==oCampo){
		$('#CmpServicioDetalleCantidad').blur();
		FncServicioDetalleGuardar();		
	}

	//alert(oCampo);
}


function FncProductoEscoger(InsProducto){	

	$('#CmpProductoId').val(InsProducto.ProId);
	$('#CmpProductoNombre').val(InsProducto.ProNombre);
	$('#CmpProductoTipo').val(InsProducto.RtiId);
	$('#CmpProductoCodigoOriginal').val(InsProducto.ProCodigoOriginal);
	$('#CmpProductoCodigoAlternativo').val(InsProducto.ProCodigoAlternativo);
	
	$('#CmpProductoUnidadMedidaConvertir').val(InsProducto.UmeIdIngreso);

	$('#CmpServicioDetalleCantidad').val("");
	
	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProducto.RtiId+"&Tipo=2&UnidadMedidaId="+InsProducto.UmeId,{}, function(j){
		var options = '';
		options += '<option value="">Escoja una opcion</option>';
			for (var i = 0; i < j.length; i++) {
			if(InsProducto.UmeIdSalida == j[i].UmeId){
				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
			}
		}
		$("select#CmpProductoUnidadMedidaConvertir").html(options);
	});

	$('#CmpServicioDetalleCantidad').focus();
	
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	  
}