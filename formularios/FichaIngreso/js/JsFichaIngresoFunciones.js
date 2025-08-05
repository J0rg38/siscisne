
function FncValidar(){

	var Fecha = $("#CmpFecha").val();
	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var ClienteNombre = $("#CmpClienteNombre").val();
	var PlanMantenimiento = $("#CmpPlanMantenimiento").val();
	var PlanMantenimientoIdAux = $("#CmpPlanMantenimientoIdAux").val();
	
	
	var ClienteCelular = $("#CmpClienteCelular").val();
	var ClienteEmail = $("#CmpClienteEmail").val();
		
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
			
		}else if(ClienteCelular == "" && ClienteEmail == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar celular o email",
					callback: function(result){
						//$("#CmpClienteCelular").focus();
					}
				});
				
			return false;
			
		}else if(ClienteNombre == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un cliente",
					callback: function(result){
						$("#CmpClienteNombre").focus();
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
			
		}else if(PlanMantenimientoIdAux == "" && $("#CmpModalidadId_MA").is(':checked') ){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No se ha cargado totalmente el plan de mantenimiento",
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
				$('#CmpPlanMantenimientoId').removeAttr('disabled');			
				
				
				
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
				$('#CmpPlanMantenimientoId').removeAttr('disabled');			
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



function FncGuardar(){
//
////HACK
//$('#CmpMantenimientoKilometraje').removeAttr('disabled');			
//$('#CmpClienteTipoDocumento').removeAttr('disabled');			
//		
//	$('input[type=checkbox]').each(function () {
//		if($(this).attr('etiqueta')=="modalidad"){
//			
//			$("#CmpModalidadId_"+$(this).attr('sigla')).removeAttr('disabled');	
//			
//		}			 
//	});					
}




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
//	$("input,select,textarea").keypress(function (event) {  
//		 if (event.keyCode == '13' && this.type !== "hidden") {
//			FncAlmacenMovimientoNavegar(this.id);
//		 }
//	}); 
//	
//	$("input,select,textarea").focus(function () {  
//		if (this.type !== "hidden" & this.type !=="image") {
//		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
//		}
//	}); 
//	
//	$("input,select,textarea").blur(function () {  
//		if (this.type !== "hidden" & this.type !=="image") {
//			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
//		}
//	}); 
	
/*
* EVENTOS - INICIALES
*/	
	//COMUNES VEHICULO

	console.log("lol");
	
	$("#CmpMantenimientoKilometraje").change(function(){
		FncFichaIngresoMantenimientoListar("MA");
		///////////FncFichaIngresoPresupuestoListar();
	});

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			FncFichaIngresoModalidadesEstablecerPrimero($(this).attr('sigla'));
		}			 
	});

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			$("#CmpModalidadId_"+$(this).attr('sigla')).change(function(){
				FncFichaIngresoModalidadesEstablecer($(this).attr('sigla'));
			});
		}			 
	});
	
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();
	
	$("#BtnAvisoCargarFormulario").unbind();
	$("#BtnAvisoCargarFormulario").FncAvisoIniciarFormulario({
		
		'Id':VehiculoIngresoId,
		'CapaFormulario':'CapAvisoCargarFormulario'
		
	});

	$("#BtnAvisoCargarListado").unbind();
	$("#BtnAvisoCargarListado").FncAvisoIniciarListado({
		
		'Id':VehiculoIngresoId,
		'CapaFormulario':'CapAvisoCargarFormulario',
		'Limite':'1'
		
	});

	
	$("#CmpPlanMantenimientoId").change(function(){
			
		FncFichaIngresoMantenimientoListar("MA");
			
	});
	
	
	//$("#CmpModalidadId_MA").click(function(){
//		
//		if($(this).is(':checked')){
//			FncVehiculoPromocionVerificar();
//		}else{
//			FncVehiculoPromocionNuevo();
//		}
//		
//	});
	
	
	//$("#CmpModalidadId_CA").click(function(){
//		
//		if($(this).is(':checked')){
//			FncCampanaVehiculoVerificar();
//		}else{
//			FncCampanaVehiculoNuevo();
//		}
//		
//	});
	
	
	
	
	
	
//$('input[type=checkbox]').each(function () {
//		if($(this).attr('etiqueta')=="modalidad"){
//			
//			
//			var Sigla = $(this).attr('sigla');
//			
//			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").unautocomplete();
//			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
//				width: 900,
//				max: 100,
//				formatItem: FncProductoFormato,
//				minChars: 2,
//				delay: 1000,
//				cacheLength: 50,
//				scroll: true,
//				scrollHeight: 200
//			});	
//
//			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").result(function(event, data, formatted) {
//				if (data){
//					$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
//					FncProductoBuscar("Id",Sigla);	
//				}		
//			});
//		
//		}			 
//	});
//	
//	
//	
//	
//	$('input[type=checkbox]').each(function () {
//		if($(this).attr('etiqueta')=="modalidad"){
//			
//			
//			var Sigla = $(this).attr('sigla');
//			
//			$("#Cmp"+$(this).attr('sigla')+"SuministroNombre").unautocomplete();
//			$("#Cmp"+$(this).attr('sigla')+"SuministroNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&ProductoTipoId=RTI-10003', {
//				width: 900,
//				max: 100,
//				formatItem: FncSuministroFormato,
//				minChars: 2,
//				delay: 1000,
//				cacheLength: 50,
//				scroll: true,
//				scrollHeight: 200
//			});	
//
//			$("#Cmp"+$(this).attr('sigla')+"SuministroNombre").result(function(event, data, formatted) {
//				if (data){
//					$("#Cmp"+Sigla+"SuministroId").val(data[0]);				
//					FncSuministroBuscar("Id",Sigla);	
//				}		
//			});
//
//			
//		}			 
//	});
		
		
/*
Agregando Eventos
*/

//alert(":4");


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


/*
* FUNCIONES -AUXILIARES
*/


function FncFichaIngresoModalidadesEstablecerPrimero(oModalidadIngresoSigla){

	console.log("FncFichaIngresoModalidadesEstablecerPrimero_"+oModalidadIngresoSigla);
	
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();

	if($("#CmpModalidadId_"+oModalidadIngresoSigla).is(':checked')){
		
		console.log("checked");
		
	//	if(oModalidadIngresoSigla=="MA"){
//			
//			if(FichaIngresoMantenimientoEditar==1){
//				
//				$('#CmpMantenimientoKilometraje').removeAttr('disabled');	
//				
//				$("#CapPresupuesto").show();	
//				$("#TabPresupuesto").show();	
//				
//				//FncPlanMantenimientoVehiculoVerificar();
//				//FncOrdenVentaVehiculoMantenimientoVerificar(VehiculoIngresoId);
//				//FncVehiculoPromocionVerificar();//20K  30K OTROS
//	
//			}
//
//		}

		$("#CapModalidad"+oModalidadIngresoSigla).show();		
		$("#TabModalidad"+oModalidadIngresoSigla).show();
		
	}else{
		
		console.log("no checked");
		
//		if(oModalidadIngresoSigla=="MA"){
//			
//			$('#CmpMantenimientoKilometraje').attr('disabled', true);			
//			$('#CmpMantenimientoKilometraje').val("");
//			
//			$("#CapPresupuesto").hide();			
//			$("#TabPresupuesto").hide();
//			
//			FncOrdenVentaVehiculoMantenimientoNuevo();
//			FncVehiculoPromocionNuevo();
//		}
		
		$("#CapModalidad"+oModalidadIngresoSigla).hide();
		$("#TabModalidad"+oModalidadIngresoSigla).hide();
		
	}

}



function FncFichaIngresoModalidadesEstablecer(oModalidadIngresoSigla){

	console.log("FncFichaIngresoModalidadesEstablecer_"+oModalidadIngresoSigla);
	
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();

	if($("#CmpModalidadId_"+oModalidadIngresoSigla).is(':checked')){
		//console.log("checked");
		
		if(oModalidadIngresoSigla=="MA"){
			
			if(FichaIngresoMantenimientoEditar==1){
				
				$('#CmpMantenimientoKilometraje').removeAttr('disabled');	
				
				$("#CapPresupuesto").show();	
				$("#TabPresupuesto").show();	
				
				//FncPlanMantenimientoVehiculoVerificar();
				
				FncOrdenVentaVehiculoMantenimientoVerificar(VehiculoIngresoId);
				FncVehiculoPromocionVerificar();//20K  30K OTROS

					
			}

		}

		$("#CapModalidad"+oModalidadIngresoSigla).show();		
		$("#TabModalidad"+oModalidadIngresoSigla).show();
		
	}else{
		
		//console.log("no checked");
		
		if(oModalidadIngresoSigla=="MA"){
			
			$('#CmpMantenimientoKilometraje').attr('disabled', true);			
			$('#CmpMantenimientoKilometraje').val("");
			
			$("#CapPresupuesto").hide();			
			$("#TabPresupuesto").hide();
			
			FncOrdenVentaVehiculoMantenimientoNuevo();
			FncVehiculoPromocionNuevo();
		}
		
		$("#CapModalidad"+oModalidadIngresoSigla).hide();
		$("#TabModalidad"+oModalidadIngresoSigla).hide();
		
	}

}

function FncFichaIngresoMantenimientoKilometrajeEstablecer(){
	
	
	console.log("FncFichaIngresoMantenimientoKilometrajeEstablecer");
	
	
	var VehiculoMarcaId = $('#CmpVehiculoIngresoMarcaId').val();
	var PlanMantenimientoKilometraje = $('#CmpMantenimientoKilometrajeAux').val();

	$.getJSON("comunes/Vehiculo/JnPlanMantenimientoKilometraje.php?VehiculoMarcaId="+VehiculoMarcaId,{}, function(j){

		var options = '';
		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {

			if(PlanMantenimientoKilometraje == j[i].PmkKilometraje){
				options += '<option value="' + j[i].PmkKilometraje + '" selected="selected">' + j[i].PmkEtiqueta+ ' km</option>';				
			}else{
				options += '<option value="' + j[i].PmkKilometraje + '" >' + j[i].PmkEtiqueta+ ' km</option>';				
			}

		}

		$('select#CmpMantenimientoKilometraje').html(options);
		
			$('input[type=checkbox]').each(function () {
				if($(this).attr('etiqueta')=="modalidad"){

					FncFichaIngresoTareaListar($(this).attr('sigla'));
					FncFichaIngresoManoObraListar($(this).attr('sigla'));
					FncFichaIngresoProductoListar($(this).attr('sigla'));
					FncFichaIngresoMantenimientoListar($(this).attr('sigla'));
					FncFichaIngresoSuministroListar($(this).attr('sigla'));

				}			 
			});
			
			///////////FncFichaIngresoPresupuestoListar();
		
	})
	
}






/*
* FUNCIONES COMUNES
*/


/*
* VEHICULO PROMOCION
*/

//function FncVehiculoPromocionNuevoFuncion(InsVehiculoPromocion){
//	
//	//$("#CmpModalidadId_MA").attr('checked', false);	
//	
//	FncFichaIngresoModalidadesEstablecer("MA");
//	
//}



//function FncVehiculoPromocionFuncion(InsVehiculoPromocion){
//	
//	var ObsequioId = $("#CmpObsequioId").val();
//	
//	if(ObsequioId!=""){
//		
//		$("#CmpModalidadId_MA").attr('checked', true);	
//		FncFichaIngresoModalidadesEstablecer("MA");
//		
//	}
//	
//}



/*
* VEHICULO INGRESO
*/

function FncVehiculoIngresoSimpleNuevoFuncion(){

	FncClienteSimpleNuevo();
	
	FncFichaIngresoHistorialListar();
	///////////FncFichaIngresoPresupuestoListar();
	
	FncFichaIngresoMantenimientoListar();

	$('select#CmpMantenimientoKilometraje').html('');


	$("#CmpModalidadId_CA").attr('checked', false);	
	FncFichaIngresoModalidadesEstablecer("CA");
	
	FncCampanaVehiculoNuevo();
	
	FncVehiculoPromocionNuevo();

}


function FncVehiculoIngresoSimpleFuncion(InsVehiculoIngreso){
	
	console.log("FncVehiculoIngresoSimpleFuncion");
	FncClienteSimpleNuevo();
	
	var ClienteId = $("#CmpVehiculoIngresoClienteId").val();
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();
	
	$("#CmpPlanMantenimientoId").val(InsVehiculoIngreso.PmaId);
	$("#CmpOrdenVentaVehiculoId").val(InsVehiculoIngreso.OvvId);
	
	if(ClienteId!=""){

		$("#CmpClienteId").val(ClienteId);
		FncClienteSimpleBuscar('Id');
		
	}
	
	//if(VehiculoIngresoId!=""){
//
//		FncVehiculoAvisoVerificar();
//		
//	}

	FncFichaIngresoMantenimientoListar("MA");
	
	FncFichaIngresoHistorialListar();	
	
	///////////FncFichaIngresoPresupuestoListar();
	FncFichaIngresoMantenimientoKilometrajeEstablecer();
	
	FncFichaIngresoPresupuestoMantenimientoKilometrajeEstablecer();
	
	
	
	FncCitaVerificar();//SOLO CITAS
		
	FncFichaIngresoVerificarPendiente(VehiculoIngresoId);//NUEVA FORAM TRABAJO
	
	
	
	FncCampanaVehiculoVerificar();//SOLO CAMPAÑAS

	if($("#CmpModalidadId_MA").is(':checked')){
	
		FncVehiculoPromocionVerificar();//PROMOCIONES 20K 30K
		
		FncOrdenVentaVehiculoMantenimientoVerificar(VehiculoIngresoId);
	
	}



	
//	$("#BtnAvisoCargarFormulario").FncAvisoIniciarFormulario({
//		
//		'Id':VehiculoIngresoId,
//		'CapaFormulario':'CapAvisoCargarFormulario'
//		
//	});
//	
//	
//	$("#BtnAvisoCargarListado").FncAvisoIniciarListado({
//		
//		'Id':VehiculoIngresoId,
//		'CapaFormulario':'CapAvisoCargarFormulario',
//		'Limite':'1'
//		
//	});
	
	
}



function FncVehiculoIngresoSimpleFormularioFuncion(){
	
	FncVehiculoIngresoSimpleBuscar("Id");

}



function FncClienteSimpleFuncion(InsCliente){

	FncClienteNotaVerificar();
	
	$('#CmpClienteCelular').val(InsCliente.CliCelular);
	
	
}

function FncClienteSimpleNuevoFuncion(){
	
	$('#CmpClienteContacto').val("");
	
}


/*
* ORDEN VENTA VEHICULO MANTENIMIENTO
*/ 

function FncOrdenVentaVehiculoMantenimientoFuncion(InsOrdenVentaVehiculoMantenimiento){

	console.log("FncOrdenVentaVehiculoMantenimientoFuncion");
	
	//alert(InsOrdenVentaVehiculoMantenimiento.OvmId);
	if(InsOrdenVentaVehiculoMantenimiento!=null){
			if(InsOrdenVentaVehiculoMantenimiento.OvmId!=null){		
			
				
					var notas = "";
					
					if(InsOrdenVentaVehiculoMantenimiento.OvvObservacion!=null){	
						if(InsOrdenVentaVehiculoMantenimiento.OvvObservacion!=""){	
						
							notas += "<b>NOTA: </b>";
							notas += InsOrdenVentaVehiculoMantenimiento.OvvObservacion;
							
						}
					}
					
					
				dhtmlx.confirm("Vehiculo con Mantenimiento Gratuito : \""+ InsOrdenVentaVehiculoMantenimiento.OvmKilometraje +" km \" "+notas, function(result){
					if(result==true){
							
							$('#CmpOrdenVentaVehiculoMantenimientoId').val(InsOrdenVentaVehiculoMantenimiento.OvmId);
							$('#CmpOrdenVentaVehiculoMantenimientoKilometraje').val(InsOrdenVentaVehiculoMantenimiento.OvmKilometraje);
					
							$("#CmpMantenimientoKilometraje").val(InsOrdenVentaVehiculoMantenimiento.OvmKilometraje);
							$("#CmpFichaIngresoModalidadObsequio_MA").attr('checked', true);
							
					}else{
						
							$('#CmpOrdenVentaVehiculoMantenimientoId').val("");
							$('#CmpOrdenVentaVehiculoMantenimientoKilometraje').val("");
					
							//$("#CmpMantenimientoKilometraje").val("");
							//$("#CmpFichaIngresoModalidadObsequio_MA").attr('checked', false);
							
					}
				});
	
	
//			if(confirm("Vehiculo con Mantenimiento Gratuito : \""+ InsOrdenVentaVehiculoMantenimiento.OvmKilometraje +" km \" ")){
//				
//				$('#CmpOrdenVentaVehiculoMantenimientoId').val(InsOrdenVentaVehiculoMantenimiento.OvmId);
//				$('#CmpOrdenVentaVehiculoMantenimientoKilometraje').val(InsOrdenVentaVehiculoMantenimiento.OvmKilometraje);
//		
//				$("#CmpMantenimientoKilometraje").val(InsOrdenVentaVehiculoMantenimiento.OvmKilometraje);
//				$("#CmpFichaIngresoModalidadObsequio_MA").attr('checked', true);
//	
//				
//				
//			}else{
//				
//				
//			}
		
		}	
	}

	
	
}

/*
* CAMPAÑA
*/
function FncCampanaVehiculoFuncion(){
	
	console.log("FncCampanaVehiculoFuncion");
		
	var CampanaNombre = $('#CmpCampanaNombre').val();
	var CampanaFecha = $("#CmpCampanaFecha").val();
	
//	if(confirm("Vehiculo en campaña : \""+ CampanaNombre +"\" ¿Desea agregar la modalidad CAMPAÑA a la ORDEN DE TRABAJO?")){
//		
//		$("#CmpModalidadId_CA").attr('checked', true);	
//		FncFichaIngresoModalidadesEstablecer("CA");
//		
//	}else{
//		
//		FncCampanaVehiculoNuevo();	
//	}
	
	dhtmlx.confirm("Vehiculo en campaña : \""+ CampanaNombre +"\" ¿Desea agregar la modalidad CAMPAÑA a la ORDEN DE TRABAJO?", function(result){
		if(result==true){
			$("#CmpModalidadId_CA").attr('checked', true);	
			FncFichaIngresoModalidadesEstablecer("CA");
		}else{
			$("#CmpModalidadId_CA").attr('checked', false);	
			FncFichaIngresoModalidadesEstablecer("CA");
			FncCampanaVehiculoNuevo();	
		}
	});
		  
}

/*
* PROMOCION 20K Y 30K
*/

function FncVehiculoPromocionNuevoFuncion(){
	$('#CmpFichaIngresoModalidadObsequio_MA').prop('checked', false);
}


function FncVehiculoPromocionFuncion(InsVehiculoPromocion){
	
	console.log("FncVehiculoPromocionFuncion");
	
	if(InsVehiculoPromocion.ObsId!=null){
		
		dhtmlx.confirm("Vehiculo con promocion : \""+ InsVehiculoPromocion.ObsNombre +"\" ", function(result){
			if(result==true){
				  
				console.log("FncVehiculoPromocionFuncion true");
				
				$('#CmpFichaIngresoModalidadObsequio_MA').prop('checked', true);
				$("#CmpModalidadId_MA").attr('checked', true);	
				
				FncFichaIngresoModalidadesEstablecer("MA");
				
				$("#CmpFichaIngresoModalidadObsequio_MA").attr('checked', true);
	
			}else{
				  
				console.log("FncVehiculoPromocionFuncion false"); 
				
				//$('#CmpFichaIngresoModalidadObsequio_MA').prop('checked', false);
				//$("#CmpModalidadId_MA").attr('checked', false);	
				  
				//FncFichaIngresoModalidadesEstablecer("MA");
				  
				$("#CmpFichaIngresoModalidadObsequio_MA").attr('checked', false);
			  
				FncVehiculoPromocionNuevo();
			}
		});
															
	//	if(confirm("Vehiculo en campaña : \""+ InsVehiculoPromocion.ObsNombre +"\" ")){
//
//			$("#CmpFichaIngresoModalidadObsequio_MA").attr('checked', true);
//			//$("#CmpModalidadId_MA").attr('checked', true);	
//			//FncFichaIngresoModalidadesEstablecer("MA");
//			//FncFichaIngresoMantenimientoListar("MA");
//
//		}else{
//		}
	
	}
}




/*
* PLAN MANTENIMIENTO
*/

function FncPlanMantenimientoVehiculoFuncion(){
	
	var PlanMantenimientoId = $('#CmpPlanMantenimientoId').val();

	if(PlanMantenimientoId == ""){
		
		alert("No se encontro plan de mantenimiento para este vehiculo");
		
	}else{
		
	}
	
	
}




/*
* FUNCIONES IMPRESION
*/

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


/*
*
*/



/******************************************************************************/
function PlanMantenimientoPresupuestoVer(){

	var VehiculoMarcaId = $('#CmpVehiculoMarcaId').val();
	var VehiculoModeloId = $('#CmpVehiculoModeloId').val();
	var ClienteTipoId = $('#CmpClienteTipoId').val();
	
	tb_show(this.title,'principal2.php?Mod=PlanMantenimientoPresupuesto&Form=Consulta&Dia=1&VehiculoMarcaId='+VehiculoMarcaId+'&VehiculoModeloId='+VehiculoModeloId+'&ClienteTipoId='+ClienteTipoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=980&modal=true',this.rel);		

}


function FncPlanMantenimientoVer(){

	var PlanMantenimientoId = $('#CmpPlanMantenimientoId').val();

	tb_show(this.title,'principal2.php?Mod=PlanMantenimiento&Form=Ver&Dia=1&Id='+PlanMantenimientoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		


}

function  FncPlanMantenimientoBuscar(){
	
}


function  FncPlanMantenimientoPresupuestoBuscar(){
	
}




function FncCitaFuncion(InsCita){	

	if(InsCita.PerIdMecanico!=null && InsCita.PerIdMecanico!=""){

		$("#CmpPersonal").val(InsCita.PerIdMecanico);
		
		
	}
	
	if(InsCita.CitDescripcion!=null && InsCita.CitDescripcion!=""){

		$("#CmpNota").val(InsCita.CitDescripcion);
	}
	
}










// JavaScript Document

/******************************************************************************/
//function FncProductoFormato(row) {			
//	return "<td>"+row[1]+"</td>";
//}

function FncProductoFormatoFull(row) {			
	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td>";
}


function FncProductoEscoger(oModalidadIngresoSigla,InsProducto,oProId,oProNombre,oProCodigoOriginal,oProCodigoAlternativo){	

	$('#Cmp'+oModalidadIngresoSigla+'ProductoId').val(InsProducto.ProId);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoNombre').val(InsProducto.ProNombre);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoCodigoOriginal').val(InsProducto.ProCodigoOriginal);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoCodigoAlternativo').val(InsProducto.ProCodigoAlternativo);
		
	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProducto.RtiId+"&Tipo=2&UnidadMedidaId="+InsProducto.UmeIdIngreso,{}, function(j){
		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if(InsProducto.UmeIdIngreso == j[i].UmeId){
				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
			}
		}
		$('select#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaConvertir').html(options);
	})

	$('select#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaConvertir').change(function(){
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+InsProducto.UmeId+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){
			//$('#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaEquivalente').val(j[0].UmcEquivalente);
			$('#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaEquivalente').val(j.UmcEquivalente);
		})
	});
	
	$('#Cmp'+oModalidadIngresoSigla+'ProductoCantidad').focus();
	
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
	//FncProductoFuncion();
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
					
					//FncProductoEscoger(oModalidadIngresoSigla,InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo);
					FncProductoEscoger(oModalidadIngresoSigla,InsProducto);
					
					
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
				width: 600,
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
						width: 600,
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
						width: 600,
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
			
			
			
			
			
			
			
			
			
			
			
			$("#Cmp"+$(this).attr('sigla')+"ManoObraNombre").unautocomplete();	
			$("#Cmp"+$(this).attr('sigla')+"ManoObraNombre").autocomplete('comunes/Producto/XmlServicio.php?Cbu=SerNombre', {
				width: 600,
				max: 100,
				formatItem: FncProductoFormatoFull,
				minChars: 2,
				delay: 1000,
				cacheLength: 50,
				scroll: true,
				scrollHeight: 200
			});	

			$("#Cmp"+$(this).attr('sigla')+"ManoObraNombre").result(function(event, data, formatted) {
				if (data){
					$("#Cmp"+Sigla+"ManoObraNombre").val(data[0]);				
					$("#Cmp"+Sigla+"ManoObraImporte").val(data[0]);	
				}		
			});
			
			
			
			
		
		}			 
	});
	

});



