function FncGuardar(){
	
	//HACK
	$("#CmpProveedorTipoDocumento").removeAttr('disabled');	
	$("#CmpMonedaId").removeAttr('disabled');	
	
}


/*
* CAMPOS FORMULARIO
*/


var FormularioCampos = ["CmpFecha",
"CmpCodigoReclamo",
"CmpProveedorNombre",
"CmpProveedorNumeroDocumento",
"CmpCliente",

"CmpSucursal",
"CmpPais",
"CmpObservacion",
"CmpObservacionImpresa",

"CmpPersonal",

"CmpReclamoDetalleCantidad",
"CmpReclamoDetalleObservacion"
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
			FncReclamoNavegar(this.id);
		 }
	}); 
	
	$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 
	
	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 
	
/*
* EVENTOS - INICIALES
*/	
	//COMUNES VEHICULO

	

/*
Agregando Eventos
*/

});

/******************************************************************************/

/*
*** FUNCIONES
*/	

function FncReclamoNavegar(oCampo){
	
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
		
		if("CmpReclamoDetalleObservacion"==oCampo){
			$("#CmpReclamoDetalleObservacion").blur();		
			FncReclamoDetalleGuardar();	
			
		}
	
	
}

/******************************************************************************/
function FncImprmir(oId){

	FncPopUp('formularios/Reclamo/FrmReclamoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.width,screen.height);

}


function FncVistaPreliminar(oId){

	FncPopUp('formularios/Reclamo/FrmReclamoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.width,screen.height);
	
}
