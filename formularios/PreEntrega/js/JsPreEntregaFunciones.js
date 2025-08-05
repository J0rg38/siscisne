
function FncValidar(){

	var Fecha = $("#CmpFecha").val();
	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var PlanMantenimiento = $("#CmpPlanMantenimiento").val();
		
		if(Fecha == ""){		
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});
				
			return false;
		
		}else if(VehiculoIngresoVIN == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un VIN",
					callback: function(result){
						$("#CmpVehiculoIngresoVIN").focus();
					}
				});
				
			return false;
	
		
		
		//if($("#CmpModalidadId_"+oModalidadIngresoSigla).is(':checked')){
		}else if(PlanMantenimiento == "" && $("#CmpModalidadId_MA").is(':checked') ){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No se encontro plan de mantenimiento",
					callback: function(result){
						//$("#CmpClienteNombre").focus();
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
		
		$('#CmpSucursal').removeAttr('disabled');		
		$('#CmpMantenimientoKilometraje').removeAttr('disabled');			
		$('#CmpClienteTipoDocumento').removeAttr('disabled');			
				
			$('input[type=checkbox]').each(function () {
				if($(this).attr('etiqueta')=="modalidad"){
					
					$("#CmpModalidadId_"+$(this).attr('sigla')).removeAttr('disabled');	
					
				}			 
			});		

		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		//HACK
		$('#CmpSucursal').removeAttr('disabled');	
		$('#CmpMantenimientoKilometraje').removeAttr('disabled');			
		$('#CmpClienteTipoDocumento').removeAttr('disabled');			
				
			$('input[type=checkbox]').each(function () {
				if($(this).attr('etiqueta')=="modalidad"){
					
					$("#CmpModalidadId_"+$(this).attr('sigla')).removeAttr('disabled');	
					
				}			 
			});		
	
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		


	
});



/*function FncGuardar(){

//HACK
$('#CmpMantenimientoKilometraje').removeAttr('disabled');			
$('#CmpClienteTipoDocumento').removeAttr('disabled');			
		
		$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			$("#CmpModalidadId_"+$(this).attr('sigla')).removeAttr('disabled');	
			
		}			 
	});					
}
*/



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
			FncPreEntregaNavegar(this.id);
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

			FncPreEntregaModalidadesEstablecer($(this).attr('sigla'));

		}			 
	});

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			$("#CmpModalidadId_"+$(this).attr('sigla')).change(function(){
				FncPreEntregaModalidadesEstablecer($(this).attr('sigla'));
			});

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

function FncPreEntregaNavegar(oCampo){
	
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


/*
* FUNCIONES -AUXILIARES
*/


function FncPreEntregaModalidadesEstablecer(oModalidadIngresoSigla){
		
		
	if($("#CmpModalidadId_"+oModalidadIngresoSigla).is(':checked')){

		$("#CapModalidad"+oModalidadIngresoSigla).show();		
		$("#TabModalidad"+oModalidadIngresoSigla).show();
		
	}else{
		
		$("#CapModalidad"+oModalidadIngresoSigla).hide();
		$("#TabModalidad"+oModalidadIngresoSigla).hide();
	}
	
	FncPreEntregaTareaListar(oModalidadIngresoSigla);
	FncPreEntregaProductoListar(oModalidadIngresoSigla);
	FncPreEntregaSuministroListar(oModalidadIngresoSigla);

}


/*
* FUNCIONES COMUNES
*/

function FncVehiculoIngresoFuncion(){

	FncClienteNuevo();
	
	var ClienteId = $("#CmpVehiculoIngresoClienteId").val();
	
	if(ClienteId!=""){

		$("#CmpClienteId").val(ClienteId);

		FncClienteBuscar('Id');
		
	}
			
	//var ClienteId = $("#CmpVehiculoIngresoClienteId").val();
	
	//$("#CmpClienteId").val(ClienteId);

	//FncClienteBuscar('Id');
	
	FncCampanaVehiculoVerificar();
	
	
	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
	
	console.log(VehiculoIngresoVIN);
	
	FncPreEntregaVerificar();
	
	FncPreEntregaClienteCargar();
	
}

function FncVehiculoIngresoNuevoFuncion(){

	FncClienteNuevo();

	$("#CmpModalidadId_CA").attr('checked', false);	
	
	FncPreEntregaModalidadesEstablecer("CA");
	
	FncCampanaVehiculoNuevo();
	
}

function FncCampanaVehiculoFuncion(){
	
	var CampanaNombre = $('#CmpCampanaNombre').val();
	var CampanaFecha = $("#CmpCampanaFecha").val();

	if(confirm("Vehiculo en campaña : \""+ CampanaNombre +"\" a partir del "+CampanaFecha+" ¿Desea agregar la modalidad CAMPAÑA a la ORDEN DE TRABAJO?")){
		
		$("#CmpModalidadId_CA").attr('checked', true);	
		FncPreEntregaModalidadesEstablecer("CA");
		
	}else{
		
		FncCampanaVehiculoNuevo();	
	}
}

function FncPreEntregaFuncion(){
	
	var PreEntregaId = $('#CmpPreEntregaId').val();
	
	if(PreEntregaId!=""){
		
		dhtmlx.alert({
						title:"Aviso",
						type:"alert-error",
						text:"Existe un PDS (" + PreEntregaId +") con este VIN.",
						callback: function(result){
							FncVehiculoIngresoNuevo();
						}
					});
					
					
		//alert("Existe un PDS (" + PreEntregaId +") con este numero de VIN");
		
	}
	
}




function FncVehiculoIngresoFormularioFuncion(){
	
	FncVehiculoIngresoBuscar("Id");

}

/*
* FUNCIONES IMPRESION
*/
function FncImprmir(oId){
	
var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato PDS \n 2 = Ficha Tecnica\n 3 = Pre-Entrega ", "1");
		
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
					
						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimirPDS.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;

					case "3":

FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);


					break;


				
				}
				
			}

}


function FncVistaPreliminar(oId){
	
var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato PDS \n 2 = Ficha Tecnica\n 3 = Pre-Entrega ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimirPDS.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;

					case "3":


						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);


					break;

				}
				
			}

}



/******************************************************************************/



function FncPlanMantenimientoVer(){

	var PlanMantenimientoId = $('#CmpPlanMantenimientoId').val();

	tb_show(this.title,'principal2.php?Mod=PlanMantenimiento&Form=Ver&Dia=1&Id='+PlanMantenimientoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		

}

function  FncPlanMantenimientoBuscar(){
	
}














// JavaScript Document

/******************************************************************************/
//function FncProductoFormato(row) {			
//	return "<td>"+row[1]+"</td>";
//}

function FncProductoFormatoFull(row) {			
	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td>";
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


$().ready(function() {
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
			var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
			var VersionId = $("#CmpVehiculoIngresoVersionId").val();
			var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();

			var Sigla = $(this).attr('sigla');
			
			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").unautocomplete();	
			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
				width: 900,
				max: 100,
				formatItem: FncProductoFormatoFull,
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
			
			
			
			




					$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal").unautocomplete();					
					$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
						width: 900,
				max: 100,
				formatItem: FncProductoFormatoFull,
				minChars: 2,
				delay: 1000,
				cacheLength: 50,
				scroll: true,
				scrollHeight: 200
					});	
					
					$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal").result(function(event, data, formatted) {
						if (data){
							$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
							FncProductoBuscar("Id",Sigla);	
						}		
					});
					

					$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo").unautocomplete();
					$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoAlternativo&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
						width: 900,
				max: 100,
				formatItem: FncProductoFormatoFull,
				minChars: 2,
				delay: 1000,
				cacheLength: 50,
				scroll: true,
				scrollHeight: 200
					});	
					
					$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal").result(function(event, data, formatted) {
						if (data){
							$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
							FncProductoBuscar("Id",Sigla);	
						}		
					});
			
			
			
		
		}			 
	});
	

});


/******************************************************************************/

function FncSuministroFormato(row) {			
	return "<td>"+row[1]+"</td>";
}

function FncSuministroEscoger(oModalidadIngresoSigla,oProId,oProNombre,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso){	

	$('#Cmp'+oModalidadIngresoSigla+'SuministroId').val(oProId);
	$('#Cmp'+oModalidadIngresoSigla+'SuministroCantidad').val("");
	$('#Cmp'+oModalidadIngresoSigla+'SuministroNombre').val(oProNombre);
	$('#Cmp'+oModalidadIngresoSigla+'SuministroTipo').val(oRtiId);
	$('#Cmp'+oModalidadIngresoSigla+'SuministroUnidadMedida').val(oUmeId);
	$('#Cmp'+oModalidadIngresoSigla+'SuministroUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
	$('#Cmp'+oModalidadIngresoSigla+'SuministroCodigoOriginal').val(oProCodigoOriginal);
	$('#Cmp'+oModalidadIngresoSigla+'SuministroCodigoAlternativo').val(oProCodigoAlternativo);
	
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
		$('select#Cmp'+oModalidadIngresoSigla+'SuministroUnidadMedidaConvertir').html(options);
	})

	$('select#Cmp'+oModalidadIngresoSigla+'SuministroUnidadMedidaConvertir').change(function(){
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){
			//$('#Cmp'+oModalidadIngresoSigla+'SuministroUnidadMedidaEquivalente').val(j[0].UmcEquivalente);
			$('#Cmp'+oModalidadIngresoSigla+'SuministroUnidadMedidaEquivalente').val(j.UmcEquivalente);
		})
	});
	
	FncSuministroFuncion();

	try{
		tb_remove();
	}catch(e){
		
	}
	

}

function FncSuministroFuncion(){
	
}

function FncSuministroBuscar(oCampo,oModalidadIngresoSigla){
	
	var Dato = $('#Cmp'+oModalidadIngresoSigla+'Suministro'+oCampo).val()
	
	if(Dato!=""){
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){
					FncSuministroEscoger(oModalidadIngresoSigla,InsProducto.ProId,InsProducto.ProNombre,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso);
				}else{
					$('#Cmp'+oModalidadIngresoSigla+'Suministro'+oCampo).focus();
					$('#Cmp'+oModalidadIngresoSigla+'Suministro'+oCampo).select();						
				}
				
			}
		});

	}

}



$().ready(function() {


	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			var Sigla = $(this).attr('sigla');

			$("#Cmp"+$(this).attr('sigla')+"SuministroNombre").unautocomplete();
			$("#Cmp"+$(this).attr('sigla')+"SuministroNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&ProductoTipoId=RTI-10003', {
				width: 900,
				max: 100,
				formatItem: FncSuministroFormato,
				minChars: 2,
				delay: 1000,
				cacheLength: 50,
				scroll: true,

				scrollHeight: 200
			});	

			$("#Cmp"+$(this).attr('sigla')+"SuministroNombre").result(function(event, data, formatted) {
				if (data){
					$("#Cmp"+Sigla+"SuministroId").val(data[0]);				
					FncSuministroBuscar("Id",Sigla);	
				}		
			});

			
		}			 
	});
		

});
