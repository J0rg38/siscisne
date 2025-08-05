// JavaScript Document


function FncGuardar(){

//HACK
	$('input[type=checkbox]').each(function () {

		if($(this).attr('etiqueta')=="tarea"){

			var Sigla = $(this).val();

			$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
			$('#CmpPlanMantenimientoDetalleAccion_'+Sigla).removeAttr('disabled');
			$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
			$('#CmpFichaAccionMantenimientoVerificar2_'+Sigla).removeAttr('disabled');

		}	
		
		if($(this).attr('etiqueta')=="producto"){

			var Sigla = $(this).val();
			
			$('#CmpFichaAccionProducto_'+Sigla).removeAttr('disabled');
			$('#CmpFichaAccionProductoUnidadMedida_'+Sigla).removeAttr('disabled');
			
			
		}
		
		$($(this)).removeAttr('disabled');	
				 
	});

	$('#CmpFichaIngresoMantenimientoKilometraje').removeAttr('disabled');
	
	$('#CmpMonedaId').removeAttr('disabled');
			
}


/******************************************************************************/

var FormularioCampos = [];

$().ready(function() {
	
	var i = 0;
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
	
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal";i++;
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo";i++;
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoNombre";i++;
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoUnidadMedidaConvertir";i++;
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoCantidad";i++;
	
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"TareaDescripcion";i++;
	
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"TareaEspecificacion";i++;
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"TareaCosto";i++;
	
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"TareaAccion";i++;
	
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"SuministroNombre";i++;
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"SuministroUnidadMedidaConvertir";i++;
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"SuministroCantidad";i++;
	
		}			 
	});
	
});

/******************************************************************************/


$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncFichaAccionNavegar(this.id);
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

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			FncFichaAccionModalidadesEstablecer($(this).attr('sigla'));
		}			 
	});

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			$("#CmpModalidadId_"+$(this).attr('sigla')).change(function(){
				FncFichaAccionModalidadesEstablecer($(this).attr('sigla'));
			});
		}			 
	});


	$("#CmpFichaIngresoMantenimientoKilometraje").change(function(){
		FncFichaAccionMantenimientoListar("MA");
	});
	
	
	
	
	var IndicacionTecnico = $("#CmpFichaIngresoIndicacionTecnico").val();
	
//alert(IndicacionTecnico);
	if(IndicacionTecnico!=""){
		
		$.ionSound({
			sounds: [                       // set needed sounds names
				"button_tiny"
			],
			path: "librerias/ion.sound-1.3.0/sounds/",                // set path to sounds
			multiPlay: true,           // playing only 1 sound at once
			volume: "0.9"                   // not so loud please
		});
		
	
		console.log("IndicacionTecnico: lol");
		$.ionSound.play("button_tiny");
		
		dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/alerta.png' width='25' height='25' border='0' > "+IndicacionTecnico+"</p>",expire:-3  });
			
		
					
	}
	
	
	
});





function FncFichaAccionNavegar(oCampo){
	
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
		
		
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			if("Cmp"+$(this).attr('sigla')+"ProductoCantidad"==oCampo){
				$('#Cmp'+$(this).attr('sigla')+'ProductoCantidad').blur();
				FncFichaAccionProductoGuardar($(this).attr('sigla'));
			}
		}			 
	});
		
			
		
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
		
			if("Cmp"+$(this).attr('sigla')+"TareaDescripcion"==oCampo){
				$('#Cmp'+$(this).attr('sigla')+'TareaDescripcion').blur();
				FncFichaAccionTareaGuardar($(this).attr('sigla'));
			}
		}			 
	});
	
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
		
			if("Cmp"+$(this).attr('sigla')+"SuministroCantidad"==oCampo){
				$('#Cmp'+$(this).attr('sigla')+'SuministroCantidad').blur();
				FncFichaAccionSuministroGuardar($(this).attr('sigla'));
			}
		}			 
	});
			


		
}




/******************************************************************************/

function FncFichaAccionModalidadesEstablecer(oModalidadIngresoSigla){

	if($("#CmpModalidadId_"+oModalidadIngresoSigla).is(':checked')){
		$("#CapModalidad"+oModalidadIngresoSigla).show();		
		$("#TabModalidad"+oModalidadIngresoSigla).show();
	}else{
		$("#CapModalidad"+oModalidadIngresoSigla).hide();
		$("#TabModalidad"+oModalidadIngresoSigla).hide();
	}

}


function FncImprmir(oId){
	FncPopUp('formularios/FichaAccion/FrmFichaAccionImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId){
	FncPopUp('formularios/FichaAccion/FrmFichaAccionImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}




function FncProveedorNuevoFuncion(){

	$('#CmpFichaAccionSalidaExternaId').val("");

}






/******************************************************************************/
/******************************************************************************/

function FncProductoFormato(row) {			
	return "<td>"+row[1]+"</td>";
}

function FncProductoFormatoFull(row) {			
	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td>";
}


function FncProductoEscoger(oModalidadIngresoSigla,oProId,oProNombre,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso){	

	$('#Cmp'+oModalidadIngresoSigla+'ProductoId').val(oProId);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoCantidad').val("");
	$('#Cmp'+oModalidadIngresoSigla+'ProductoNombre').val(oProNombre);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoTipo').val(oRtiId);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedida').val(oUmeId);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoCodigoOriginal').val(oProCodigoOriginal);
	$('#Cmp'+oModalidadIngresoSigla+'ProductoCodigoAlternativo').val(oProCodigoAlternativo);
	
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
		$('select#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaConvertir').html(options);
	})

	$('select#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaConvertir').change(function(){
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){
			//$('#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaEquivalente').val(j[0].UmcEquivalente);
			$('#Cmp'+oModalidadIngresoSigla+'ProductoUnidadMedidaEquivalente').val(j.UmcEquivalente);
		})
	});
	
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
					FncProductoEscoger(oModalidadIngresoSigla,InsProducto.ProId,InsProducto.ProNombre,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso);
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
			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
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
			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
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
			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
				width: 900,
				max: 100,
				formatItem: FncProductoFormatoFull,
				minChars: 2,
				delay: 1000,
				cacheLength: 50,
				scroll: true,
				scrollHeight: 200
			});	

			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo").result(function(event, data, formatted) {
				if (data){
					$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
					FncProductoBuscar("Id",Sigla);	
				}		
			});

		}			 
	});
		

});


/******************************************************************************/


function FncHerramientaFormato(row) {			
	return "<td>"+row[1]+"</td>";
}

function FncHerramientaEscoger(oProId,oProNombre,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso){	

	$('#CmpHerramientaId').val(oProId);
	$('#CmpHerramientaCantidad').val("");
	$('#CmpHerramientaNombre').val(oProNombre);
	$('#CmpHerramientaTipo').val(oRtiId);
	$('#CmpHerramientaUnidadMedida').val(oUmeId);
	$('#CmpHerramientaUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
	$('#CmpHerramientaCodigoOriginal').val(oProCodigoOriginal);
	$('#CmpHerramientaCodigoAlternativo').val(oProCodigoAlternativo);
	
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
		$('select#CmpHerramientaUnidadMedidaConvertir').html(options);
	})

	$('select#CmpHerramientaUnidadMedidaConvertir').change(function(){
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){
			//$('#CmpHerramientaUnidadMedidaEquivalente').val(j[0].UmcEquivalente);
			$('#CmpHerramientaUnidadMedidaEquivalente').val(j.UmcEquivalente);
		})
	});
	
	FncHerramientaFuncion();

	try{
		tb_remove();
	}catch(e){
		
	}
}

function FncHerramientaFuncion(){
	
}

function FncHerramientaBuscar(oCampo){
	
	var Dato = $('#CmpHerramienta'+oCampo).val()
	
	if(Dato!=""){
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){
					FncHerramientaEscoger(InsProducto.ProId,InsProducto.ProNombre,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso);
				}else{
					$('#CmpHerramienta'+oCampo).focus();
					$('#CmpHerramienta'+oCampo).select();						
				}
				
			}
		});

	}

}

$().ready(function() {
	
	var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
	var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
	var VersionId = $("#CmpVehiculoIngresoVersionId").val();
	var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();
	
	var Sigla = $(this).attr('sigla');
//			$("#CmpHerramientaNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
	$("#CmpHerramientaNombre").unautocomplete();
	$("#CmpHerramientaNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&ProductoTipoId=RTI-10005', {
		width: 900,
		max: 100,
		formatItem: FncHerramientaFormato,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	

	$("#CmpHerramientaNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpHerramientaId").val(data[0]);				
			FncHerramientaBuscar("Id");	
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
			success: function(InsSuministro){
										
				if(InsSuministro.ProId!="" & InsSuministro.ProId!=null){
					FncSuministroEscoger(oModalidadIngresoSigla,InsSuministro.ProId,InsSuministro.ProNombre,InsSuministro.RtiId,InsSuministro.UmeId,InsSuministro.ProCodigoOriginal,InsSuministro.ProCodigoAlternativo,InsSuministro.UmeIdIngreso);
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
			
			var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
			var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
			var VersionId = $("#CmpVehiculoIngresoVersionId").val();
			var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();

			var Sigla = $(this).attr('sigla');
			
			$("#Cmp"+$(this).attr('sigla')+"SuministroNombre").unautocomplete();
			$("#Cmp"+$(this).attr('sigla')+"SuministroNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
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






function FncPlanMantenimientoVer(){

	var PlanMantenimientoId = $('#CmpPlanMantenimientoId').val();

	tb_show(this.title,'principal2.php?Mod=PlanMantenimiento&Form=Ver&Dia=1&Id='+PlanMantenimientoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		

}



function  FncPlanMantenimientoBuscar(){
	
}




function FncCitaCalendarioCargarFormulario(oForm,oPersonal){
	
	//FncCargarVentanaNuevo(oRuta,oIframe,oModal,oTitulo)
	FncCargarVentanaNuevo('principal2.php?Mod=Cita&Form='+oForm+'&Personal='+oPersonal+'&Dia=1',"true","true","");
//	tb_show(this.title,'principal2.php?Mod=Cita&Form='+oForm+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncTallerPedidoFichasVerListado(oFichaIngresoId){

var Ancho = $( window ).width();
	var Alto = $( window ).height();

	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.2));

			
		tb_show('','formularios/TallerPedido/DiaAlmacenMovimientoListado.php?Precio=NO&FinId='+oFichaIngresoId+
'&placeValuesBeforeTB_=savedValues&height='+(Alto)+'&width='+(Ancho));	

}