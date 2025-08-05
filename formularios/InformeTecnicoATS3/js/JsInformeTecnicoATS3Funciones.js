// JavaScript Document
/*
* CAMPOS FORMULARIO
*/
var FormularioCampos = ["CmpFecha",
"CmpFechaVenta",
"CmpPropietario",

"CmpCausa",

"CmpCorreccion",
"CmpConclusion",
"CmpSolucionSatisfactoria",
"CmpPersonal",
"CmpPersonalCargo",

"CmpInformeTecnicoATS3OperacionNumero",
"CmpInformeTecnicoATS3OperacionTiempo",
//"CmpInformeTecnicoATS3OperacionCostoHora",
"CmpInformeTecnicoATS3OperacionValorTotal",

"CmpProductoCodigoOriginal",
"CmpProductoNombre",
"CmpInformeTecnicoATS3ProductoCantidad",
"CmpInformeTecnicoATS3OperacionNumero",
"CmpInformeTecnicoATS3ProductoValorTotal"
];

/******************************************************************************/



/******************************************************************************/
	
/*
*** EVENTOS
*/	

$().ready(function() {
/*
* EVENTOS - NAVEGACION
*/		
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
	
		if("CmpInformeTecnicoATS3ProductoValorTotal"==oCampo){
			$('#CmpInformeTecnicoATS3ProductoValorTotal').blur();
			FncInformeTecnicoATS3ProductoGuardar();
		}
		
		if("CmpInformeTecnicoATS3OperacionValorTotal"==oCampo){
			$('#CmpInformeTecnicoATS3OperacionValorTotal').blur();
			FncInformeTecnicoATS3OperacionGuardar();
		}

		
}


/******************************************************************************/



/******************************************************************************/

function FncImprmir(oId){
	
	FncPopUp('formularios/InformeTecnicoATS3/FrmInformeTecnicoATS3Imprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncVistaPreliminar(oId){
	
	FncPopUp('formularios/InformeTecnicoATS3/FrmInformeTecnicoATS3Imprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
}



