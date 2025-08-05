/*
* CAMPOS FORMULARIO
*/

var FormularioCampos = ["CmpModalidad",
"CmpFecha",
"CmpHora",
"CmpPlanMantenimiento",
"CmpPrioridad",
"CmpEstadoAux",
"CmpVehiculoIngresoVIN",
"CmpVehiculoIngresoPlaca",
"CmpVehiculoIngresoMarca",
"CmpVehiculoIngresoModelo",
"CmpVehiculoIngresoVersion",
"CmpVehiculoIngresoAnoFabricacion",
"CmpVehiculoIngresoColor",
"CmpVehiculoKilometraje",
"CmpClienteTipoDocumento",
"CmpClienteNumeroDocumento",
"CmpClienteNombre",
"CmpConductor",

"CmpExteriorDelantero1",
"CmpExteriorDelantero2",
"CmpExteriorDelantero3",
"CmpExteriorDelantero4",
"CmpExteriorDelantero5",
"CmpExteriorDelantero6",
"CmpExteriorDelantero7",
"CmpExteriorPosterior1",
"CmpExteriorPosterior2",
"CmpExteriorPosterior3",
"CmpExteriorPosterior4",
"CmpExteriorPosterior5",
"CmpExteriorPosterior6",
"CmpExteriorDerecho1",
"CmpExteriorDerecho2",
"CmpExteriorDerecho3",
"CmpExteriorDerecho4",
"CmpExteriorDerecho5",
"CmpExteriorDerecho6",
"CmpExteriorDerecho7",
"CmpExteriorDerecho8",
"CmpExteriorIzquierdo1",
"CmpExteriorIzquierdo2",
"CmpExteriorIzquierdo3",
"CmpExteriorIzquierdo4",
"CmpExteriorIzquierdo5",
"CmpExteriorIzquierdo6",
"CmpExteriorIzquierdo7",
"CmpInterior1",
"CmpInterior2",
"CmpInterior3",
"CmpInterior4",
"CmpInterior5",
"CmpInterior6",
"CmpInterior7",
"CmpInterior8",
"CmpInterior9",
"CmpInterior10",
"CmpInterior11",
"CmpInterior12",
"CmpInterior13",
"CmpInterior14",
"CmpInterior15",
"CmpInterior16",
"CmpInterior17",
"CmpInterior18",
"CmpInterior19",
"CmpInterior20",
"CmpInterior21",
"CmpInterior22",
"CmpInterior23",
"CmpInterior24",
"CmpInterior25",
"CmpInterior26",
"CmpInterior27",
"CmpObservacion",
"CmpTareaDescripcion",
"CmpTareaResultado"];

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
	
		var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;

					case "3":

	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;


				
				}
				
			}
			
			

}


function FncVistaPreliminar(oId){
	
	
		var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;

					case "3":

	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;			
				}
				
			}
	
}

