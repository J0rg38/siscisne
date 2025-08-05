// JavaScript Document
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

function FncFormato(row) {			
	return "<td>"+row[1]+"</td>";
}

function FncProductoEscoger(oModalidadIngresoSigla,oProId,oProNombre,oProCodigoOriginal,oProCodigoAlternativo){	

	$('#Cmp'+oModalidadIngresoSigla+'ProductoId').val(oProId);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoNombre').val(oProNombre);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoCodigoOriginal').val(oProCodigoOriginal);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoCodigoAlternativo').val(oProCodigoAlternativo);
	
	FncProductoFuncion();

	try{
		tb_remove();
	}catch(e){
		
	}

}

function FncProductoFuncion(){
	
}

function FncProductoBuscar(oCampo,oModalidadIngresoSigla){
	
	//alert('#Cmp'+oModalidadIngresoSigla+'Producto'+oCampo);
	var Dato = $('#Cmp'+oModalidadIngresoSigla+'Producto'+oCampo).val()
	
	if(Dato!=""){
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){
					FncProductoEscoger(oModalidadIngresoSigla,InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo);
				}else{
					$('#Cmp'+oModalidadIngresoSigla+'Producto'+oCampo).focus();
					$('#Cmp'+oModalidadIngresoSigla+'Producto'+oCampo).select();						
				}
				
			}
		});

	}

}


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

//	$("select#CmpVehiculoMarca").change(function(){
//		FncVehiculoModelosCargar();
//	});

//	$("select#CmpVehiculoModelo").change(function(){
//		FncVehiculoVersionesCargar();
//	});
	
//	$("#CmpVehiculoKilometraje").keyup(function(){
//		FncInformeTecnicoDetalleListar();
//	});

	//$("#CmpMantenimientoKilometraje").change(function(){
//		FncInformeTecnicoDetalleListar();
//	});

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			FncInformeTecnicoModalidadesEstablecer($(this).attr('sigla'));
			//FncInformeTecnicoModalidadesEstablecer($(this).val());
		}			 
	});

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			$("#CmpModalidadId_"+$(this).attr('sigla')).change(function(){
				FncInformeTecnicoModalidadesEstablecer($(this).attr('sigla'));
				//FncInformeTecnicoModalidadesEstablecer($(this).val());
			});
		}			 
	});
	
	
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
//			var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
//			alert(MarcaId);
//			var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
//			var VersionId = $("#CmpVehiculoIngresoVersionId").val();
//			var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();
			
			var Sigla = $(this).attr('sigla');
			
			//$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
			//$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+$("#CmpVehiculoIngresoMarcaId").val()+'&ModeloId='+$("#CmpVehiculoIngresoModeloId").val()+'&VersionId='+$("#CmpVehiculoIngresoVersionId").val()+'&AnoFabricacion='+$("#CmpVehiculoIngresoAnoFabricacion").val(), {
			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").unautocomplete();
			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
				width: 900,
				max: 100,
				formatItem: FncFormato,
				minChars: 2,
				delay: 1000,
				cacheLength: 50,
				scroll: true,
				scrollHeight: 200
			});	

			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").result(function(event, data, formatted) {
				if (data){
					$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
					FncProductoBuscar("Id",Sigla);	
				}		
			});

			//alert(Sigla);
//			$("#CmpModalidadId_"+$(this).attr('sigla')).change(function(){
//				FncInformeTecnicoModalidadesEstablecer($(this).attr('sigla'));
//				//FncInformeTecnicoModalidadesEstablecer($(this).val());
//			});
			
			
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
	
		//if("CmpTareaResultado"==oCampo){
//			$('#CmpTareaResultado').blur();
//			FncInformeTecnicoTareaGuardar();
//		}

		
}

/******************************************************************************/
function FncInformeTecnicoModalidadesEstablecer(oModalidadIngresoSigla){


//alert(oModalidadIngresoSigla);

	if($("#CmpModalidadId_"+oModalidadIngresoSigla).is(':checked')){

		if(oModalidadIngresoSigla=="MA"){
			$('#CmpMantenimientoKilometraje').removeAttr('disabled');
			//$('#Modalidad1').hide();
			
		}

		$("#CapModalidad"+oModalidadIngresoSigla).show();		
		$("#TabModalidad"+oModalidadIngresoSigla).show();
		
		
	}else{
		
		if(oModalidadIngresoSigla=="MA"){
			$('#CmpMantenimientoKilometraje').attr('disabled', true);			
			$('#CmpMantenimientoKilometraje').val("");
			//$('#Modalidad1').show();
		}
		
		$("#CapModalidad"+oModalidadIngresoSigla).hide();
		$("#TabModalidad"+oModalidadIngresoSigla).hide();
	}


		//if(oModalidadIngresoSigla=="MA"){
//			$('#CmpMantenimientoKilometraje').removeAttr('readonly');
//		}else{
//			$('#CmpMantenimientoKilometraje').attr('readonly', true);			
//			$('#CmpMantenimientoKilometraje').val("");
//		}


		
}

function FncInformeTecnicoProductoAutoCompletar(){
	
}

/******************************************************************************/

function FncVehiculoIngresoFuncion(){
	
	var ClienteId = $("#CmpVehiculoIngresoClienteId").val();
	
	$("#CmpClienteId").val(ClienteId);

	FncClienteBuscar('Id');

	FncInformeTecnicoDetalleListar();
}

/******************************************************************************/

function FncImprmir(oId){
	
	
	FncPopUp('formularios/InformeTecnicoIT200/FrmInformeTecnicoIT200Imprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

			
			

}


function FncVistaPreliminar(oId){
	
	
	
					
FncPopUp('formularios/InformeTecnicoIT200/FrmInformeTecnicoIT200Imprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
	
	
}



