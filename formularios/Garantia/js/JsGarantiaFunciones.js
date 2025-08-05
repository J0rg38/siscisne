/*
* CAMPOS FORMULARIO
*/

var FormularioCampos = ["CmpFecha",
"CmpFechaVenta",
"CmpCausa",
"CmpTarifaAutorizada",
"CmpClienteNombre",

"CmpClienteTipoDocumento",
"CmpClienteNumeroDocumento",
"CmpClienteDireccion",
"CmpClienteCiudad",

"CmpVehiculoIngresoModelo",
"CmpObservacion",
"CmpObservacionImpresa",

"CmpGarantiaOperacionNumero",
"CmpGarantiaOperacionTiempo",
"CmpGarantiaOperacionValor",
"CmpGarantiaOperacionCosto",

"CmpGarantiaDetalleCodigo",
"CmpGarantiaDetalleDescripcion",
"CmpGarantiaDetalleCantidad",
"CmpGarantiaDetalleCostoTotal"

];

/******************************************************************************/
	
/*
*** EVENTOS
*/	

$().ready(function() {
/*
* EVENTOS - NAVEGACION
*/		
	$("input,select,textarea").keypress(function (event) {  
		//alert(event.keyCode);
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncGarantiaNavegar(this.id);
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
* EVENTOS - INICIALES
*/	
	//COMUNES VEHICULO

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			FncFichaIngresoModalidadesEstablecer($(this).attr('sigla'));
		}			 
	});

/*
Agregando Eventos
*/

});

/******************************************************************************/

/*
*** FUNCIONES
*/	

function FncGarantiaNavegar(oCampo){
	
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
		
		
		if("CmpGarantiaOperacionCosto"==oCampo){
			$("#CmpGarantiaOperacionCosto").blur();		
			FncGarantiaOperacionGuardar();	
			
		}
	
	
	
		if("CmpGarantiaDetalleCostoTotal"==oCampo){
			$("#CmpGarantiaDetalleCostoTotal").blur();		
			FncGarantiaDetalleGuardar();	
			
		}
	
		
		
	
}

/******************************************************************************/
function FncFichaIngresoModalidadesEstablecer(oModalidadIngresoSigla){

	if($("#CmpModalidadId_"+oModalidadIngresoSigla).is(':checked')){

		if(oModalidadIngresoSigla=="MA"){
			$('#CmpMantenimientoKilometraje').removeAttr('disabled');
		}

		$("#CapModalidad"+oModalidadIngresoSigla).show();		
		$("#TabModalidad"+oModalidadIngresoSigla).show();
		
	}else{
		
		if(oModalidadIngresoSigla=="MA"){
			$('#CmpMantenimientoKilometraje').attr('disabled', true);			
			$('#CmpMantenimientoKilometraje').val("");
		}
		
		$("#CapModalidad"+oModalidadIngresoSigla).hide();
		$("#TabModalidad"+oModalidadIngresoSigla).hide();
	}

}


/******************************************************************************/
function FncImprmir(oId){

	FncPopUp('formularios/Garantia/FrmGarantiaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.width,screen.height);

}


function FncVistaPreliminar(oId){

	FncPopUp('formularios/Garantia/FrmGarantiaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.width,screen.height);
	
}
