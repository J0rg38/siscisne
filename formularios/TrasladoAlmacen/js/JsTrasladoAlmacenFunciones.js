// JavaScript Document


function FncGuardar(){
	
	//HACK
	$("#CmpEstado").removeAttr('disabled');	
	$("#CmpAlmacenDestino").removeAttr('disabled');		
	$("#CmpAlmacen").removeAttr('disabled');			
	
}

/************************************************************/
/************************************************************/

var FormularioCampos = ["CmpFecha",
"CmpObservacion",
"CmpAlmacen",
"CmpAlmacenDestino",

"CmpProductoCodigoOriginal",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpProductoCantidad"

];

//"CmpTrasladoAlmacenDetalleCodigo",

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
		$("#CmpAlmacen").change(function(){
		FncTrasladoAlmacenDetalleListar();
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
		
		if("CmpProductoCantidad"==oCampo){
			$('#CmpProductoCantidad').blur();
			FncTrasladoAlmacenDetalleGuardar();
		}
		
}



/************************************************************/
//EXTRAS

/************************************************************/
//IMPRESION

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/TrasladoAlmacen/FrmTrasladoAlmacenImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/TrasladoAlmacen/FrmTrasladoAlmacenImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}




















/************************************************************/
/************************************************************/

function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oTadId){	
		  
	$('#CmpProductoId').val(oProId);
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoNombre').val(oProNombre);
	
	$('#CmpProductoFoto').val(oProFoto);
	
	$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+oProEspecificacion+'">Archivo de Especificaciones<a/>');

	$('#CmpProductoUnidadMedida').val(oUmeId);
	
	$('#CmpProductoCodigoOriginal').val(oProCodigoOriginal);	


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

	$('#CmpProductoCantidad').focus();
////
//* POPUP REGISTRAR/EDITAR

	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
}




function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}
