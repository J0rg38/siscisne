// JavaScript Document

function FncValidar(){
	
	var respuesta = true;
	
	if(FncValidarPlanMantenimientoAlmacen()==false){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger un almacen de salida para cada item de repuesto",
			callback: function(result){
				//$("#CmpFechaProgramada").focus();
			}
		});

		 respuesta = false;
		 
	}else if(FncValidarPlanMantenimientoEstado()==false){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger un estado para cada item de repuesto",
			callback: function(result){
				//$("#CmpFechaProgramada").focus();
			}
		});
		
		 respuesta = false;
		 
	}else if(FncValidarPlanMantenimientoCantidad()==false){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar una cantidad para cada item de repuesto",
			callback: function(result){
				//$("#CmpFechaProgramada").focus();
			}
		});

		 respuesta = false;
		 
	}else if(FncValidarPlanMantenimientoImporte()==false){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un importe para cada item de repuesto",
			callback: function(result){
				//$("#CmpFechaProgramada").focus();
			}
		});
		 respuesta = false;
		
	}else if(FncValidarPlanMantenimientoUnidadMedida()==false){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger una unidad de medida para cada item de repuesto",
			callback: function(result){
				//$("#CmpFechaProgramada").focus();
			}
		});
		
		 respuesta = false;
		
	}else if(FncValidarTallerPedidoDetalleAlmacen()==false){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger un almacen para cada item de repuesto",
			callback: function(result){
				//$("#CmpFechaProgramada").focus();
			}
		});
		
		 respuesta = false;
		 
	}else if(FncValidarPersonal()==false){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger un tecnico para cada modalidad de la orden de trabajo",
			callback: function(result){
				//$("#CmpFechaProgramada").focus();
			}
		});
		
		 respuesta = false;	
		 
	}else if(FncValidarTallerPedidoDetalleEstado()==false){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger un estado para cada item de repuesto",
			callback: function(result){
				//$("#CmpFechaProgramada").focus();
			}
		});
		
		 respuesta = false;
		
	}
	
	
//	respuesta = false;
	
	return respuesta;
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		  $('input[type=checkbox]').each(function () {
			  
			  if($(this).attr('etiqueta')=="tarea"){
				  var Sigla = $(this).val();
				  
				  $("#Cmp"+Sigla+"ProductoUnidadMedidaConvertir").removeAttr('disabled');
				  $("#CmpAlmacenId_"+Sigla).removeAttr('disabled');
				  $("#Cmp"+Sigla+"TallerPedidoDetalleEstado").removeAttr('disabled');
				  
				  $("#CmpAlmacen_"+Sigla).removeAttr('disabled');
				  $("#CmpTallerPedidoDetalleEstado_"+Sigla+"").removeAttr('disabled');
					
			  }		
			  
			  
			   if($(this).attr('etiqueta')=="producto"){
				  var Sigla = $(this).val();
				  
				  $("#CmpAlmacen_"+Sigla).removeAttr('disabled');
				  $("#CmpTallerPedidoDetalleEstado_"+Sigla+"").removeAttr('disabled');
					
			  }		
			  	 
		  });
	
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$('input[type=checkbox]').each(function () {
			  
			  if($(this).attr('etiqueta')=="tarea"){
				  var Sigla = $(this).val();
				  
				  $("#Cmp"+Sigla+"ProductoUnidadMedidaConvertir").removeAttr('disabled');
				   $("#CmpAlmacenId_"+Sigla).removeAttr('disabled');
				   
				   $("#Cmp"+Sigla+"TallerPedidoDetalleEstado").removeAttr('disabled');
				  
			  }		
			  
			   
			   if($(this).attr('etiqueta')=="producto"){
				 
					var Sigla = $(this).val();
				  
				  $("#CmpAlmacen_"+Sigla).removeAttr('disabled');
				  $("#CmpTallerPedidoDetalleEstado_"+Sigla+"").removeAttr('disabled');
					
			  }		
			  	 
				 
				 	 
		  });

			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			var Sigla = $(this).val();
			var Sigla = $(this).attr('sigla');
			
			console.log("#BtnTallerPedidoEstablecerMoneda_"+Sigla+"");
			
			$("#BtnTallerPedidoEstablecerMoneda_"+Sigla+"").click(function(){
				
				FncTallerPedidoEstablecerMoneda(Sigla);
				
			});
			
		
			$("#CmpFichaAccionManoObra_"+Sigla+"").keypress(function(){
				
				FncTallerPedidoEstablecerMoneda(Sigla);
				
			});

			$("#CmpDescuento_"+Sigla+"").keypress(function(){
				
				FncTallerPedidoEstablecerMoneda(Sigla);
				
			});
			
			
			
			
		}
	});
});


 
function FncValidarPersonal(){
	
	console.log("FncValidarPersonal");
	
	var respuesta = true;
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			var Sigla = $(this).attr('sigla');
			
			if($("select#CmpPersonal_"+Sigla).val()==""){
				
				respuesta = false;
				
			}
			
				
		}	
				 
	});
	
	return respuesta;
	
}

function FncValidarPlanMantenimientoAlmacen(){
	
	console.log("FncValidarPlanMantenimientoAlmacen");
	
	var respuesta = true;
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="tarea"){
			
			var Sigla = $(this).val();
			var ModalidadSigla = $(this).attr('modalidad_sigla');
			
			console.log( "#Cmp"+Sigla+"ProductoId");
			console.log( $("#Cmp"+Sigla+"ProductoId").val() + " " + $("#CmpAlmacenId_"+Sigla).val());
		
			if( $("#Cmp"+Sigla+"ProductoId").val() != "" && $("#CmpAlmacenId_"+Sigla).val() == "" ){
				
				$("#CmpAlmacenId_"+Sigla).removeClass("EstFormularioCombo").addClass("EstFormularioComboRevisar");	
				
				respuesta = false
			}else{
				
				$("#CmpAlmacenId_"+Sigla).removeClass("EstFormularioComboRevisar").addClass("EstFormularioCombo");	
				
			}
				
		}	
				 
	});
	
	return respuesta;
	
}

function FncValidarPlanMantenimientoEstado(){

	console.log("FncValidarPlanMantenimientoEstado");
	
	var respuesta = true;
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="tarea"){
			
			var Sigla = $(this).val();
			var ModalidadSigla = $(this).attr('modalidad_sigla');
			
		
			if( $("#Cmp"+Sigla+"ProductoId").val() != "" && $("#Cmp"+Sigla+"TallerPedidoDetalleEstado").val() == "" ){
				
				$("#Cmp"+Sigla+"TallerPedidoDetalleEstado").removeClass("EstFormularioCombo").addClass("EstFormularioComboRevisar");	
				
				
				respuesta = false
			}else{
				
				$("#Cmp"+Sigla+"TallerPedidoDetalleEstado").removeClass("EstFormularioComboRevisar").addClass("EstFormularioCombo");	
				
			}
				
		}	
				 
	});
	
	return respuesta;
	
}

function FncValidarPlanMantenimientoCantidad(){

	console.log("FncValidarPlanMantenimientoEstado");
	
	var respuesta = true;
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="tarea"){
			
			var Sigla = $(this).val();
			var ModalidadSigla = $(this).attr('modalidad_sigla');
			
		
			if( $("#Cmp"+Sigla+"ProductoId").val() != "" && $("#Cmp"+Sigla+"ProductoCantidad").val() == "" ){
				
				$("#Cmp"+Sigla+"ProductoCantidad").removeClass("EstFormularioCaja").addClass("EstFormularioCajaRevisar");	
				
				
				respuesta = false
			}else{
				
				$("#Cmp"+Sigla+"ProductoCantidad").removeClass("EstFormularioCajaRevisar").addClass("EstFormularioCaja");	
				
			}
				
		}	
				 
	});
	
	return respuesta;
	
}


function FncValidarPlanMantenimientoImporte(){

	console.log("FncValidarPlanMantenimientoEstado");
	
	var respuesta = true;
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="tarea"){
			
			var Sigla = $(this).val();
			var ModalidadSigla = $(this).attr('modalidad_sigla');
			
		
			if( $("#Cmp"+Sigla+"ProductoId").val() != "" && $("#Cmp"+Sigla+"ProductoImporte").val() == "" ){
				
				$("#Cmp"+Sigla+"ProductoImporte").removeClass("EstFormularioCaja").addClass("EstFormularioCajaRevisar");	
				
				
				respuesta = false
			}else{
				
				$("#Cmp"+Sigla+"ProductoImporte").removeClass("EstFormularioCajaRevisar").addClass("EstFormularioCaja");	
				
			}
				
		}	
				 
	});
	
	return respuesta;
	
}



function FncValidarPlanMantenimientoUnidadMedida(){

	console.log("FncValidarPlanMantenimientoEstado");
	
	var respuesta = true;
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="tarea"){
			
			var Sigla = $(this).val();
			var ModalidadSigla = $(this).attr('modalidad_sigla');
			
		
			if( $("#Cmp"+Sigla+"ProductoId").val() != "" && $("#Cmp"+Sigla+"ProductoUnidadMedidaConvertir").val() == "" ){
				
				$("#Cmp"+Sigla+"ProductoUnidadMedidaConvertir").removeClass("EstFormularioCombo").addClass("EstFormularioComboRevisar");	
				
				
				respuesta = false
			}else{
				
				$("#Cmp"+Sigla+"ProductoUnidadMedidaConvertir").removeClass("EstFormularioComboRevisar").addClass("EstFormularioCombo");	
				
			}
				
		}	
				 
	});
	
	return respuesta;
	
}

/******************************************************************************/



function FncValidarTallerPedidoDetalleAlmacen(){
	
	console.log("FncValidarTallerPedidoDetalleAlmacen");
	
	var respuesta = true;
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="producto"){
			
			var Sigla = $(this).val();
			
			if($("#CmpAlmacen_"+Sigla).val()==""){
			
				$("#CmpAlmacen_"+Sigla).removeClass("EstFormularioCombo").addClass("EstFormularioComboRevisar");
				respuesta = false	
			
			}else{
			
				$("#CmpAlmacen_"+Sigla).removeClass("EstFormularioComboRevisar").addClass("EstFormularioCombo");	
			
			}
			
		}	
				 
	});
	
	return respuesta;
	
}

function FncValidarTallerPedidoDetalleEstado(){

	console.log("FncValidarTallerPedidoDetalleEstado");
	
	var respuesta = true;
	
	$('input[type=checkbox]').each(function () {
	
		if($(this).attr('etiqueta')=="producto"){
			
			var Sigla = $(this).val();
			
			if( $("#CmpTallerPedidoDetalleEstado_"+Sigla+"").val() == "" ){
				
				$("#CmpTallerPedidoDetalleEstado_"+Sigla+"").removeClass("EstFormularioCombo").addClass("EstFormularioComboRevisar");	
				respuesta = false
				
			}else{
				
				$("#CmpTallerPedidoDetalleEstado_"+Sigla+"").removeClass("EstFormularioComboRevisar").addClass("EstFormularioCombo");	
				
			}
				
		}	
				 
	});
	
	return respuesta;
	
}


/******************************************************************************/
var FormularioCampos = [];

$().ready(function() {

	var i = 0;
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			console.log($(this).val());
			console.log($(this).attr('sigla'));
			
			var Sigla = $(this).val();
			
			
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoNombre";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoUnidadMedidaConvertir";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoCantidad";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoPrecio";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+$(this).attr('sigla')+"ProductoImporte";i++;
				console.log(FormularioCampos[i] );
	
 		}
	});
		
	/*$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="tarea"){
			
			console.log($(this).val());		
			var Sigla = $(this).val();
			
			FormularioCampos[i] = "Cmp"+Sigla+"ProductoCodigoOriginal";i++;
			console.log(FormularioCampos[i] );
			
			FormularioCampos[i] = "Cmp"+Sigla+"ProductoNombre";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+Sigla+"ProductoUnidadMedidaConvertir";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+Sigla+"ProductoCantidad";i++;
				console.log(FormularioCampos[i] );
			FormularioCampos[i] = "Cmp"+Sigla+"ProductoImporte";i++;
				console.log(FormularioCampos[i] );
				
		}	
				 
	});*/
	
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			var Sigla = $(this).attr('sigla');
			
			$("select#CmpMonedaId_"+Sigla).change(function(){
				FncTallerPedidoEstablecerMoneda(Sigla);
			});
			
			$("#CmpTipoCambio_"+Sigla).keypress(function(){
				FncTallerPedidoDetalleListar(Sigla);
			});
			
		}
	});	
	
});


/******************************************************************************/

$().ready(function() {
	
	//console.log(FormularioCampos);
	
	$("input,select,textarea").keypress(function (event) {  	
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncTallerPedidoNavegar(this.id);
		 }
	}); 
	
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
	Agregando Eventos
	*/

});




function FncTallerPedidoNavegar(oCampo){

	console.log("FncTallerPedidoNavegar");
	
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

			if("Cmp"+$(this).attr('sigla')+"ProductoImporte"==oCampo){

				$('#Cmp'+$(this).attr('sigla')+'ProductoImporte').blur();
				
				FncTallerPedidoDetalleGuardar($(this).attr('sigla'));

			}
			
			/*if("Cmp"+$(this).attr('sigla')+"SuministroCantidad"==oCampo){
				$('#Cmp'+$(this).attr('sigla')+'SuministroCantidad').blur();
				FncFichaAccionSuministroGuardar($(this).attr('sigla'));
			}
*/
		}			 
	});
		
}


/*
* FUNCIONES: AUXILIARES
*/
function FncTallerPedidoEstablecerMoneda(oSigla){
	
	console.log("FncTallerPedidoEstablecerMoneda");
	console.log("oSigla: "+oSigla);
	
	var MonedaId = $('#CmpMonedaId_'+oSigla).val();
	var TipoCambio = $('#CmpTipoCambio_'+oSigla).val();
	var Fecha = $('#CmpFecha_'+oSigla).val();

	if(MonedaId==""){
		
		$('#CmpTipoCambio_'+oSigla).val('');
		
		FncTallerPedidoDetalleListar(oSigla);
		alert("Debe Escoger una moneda");
		
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio_'+oSigla).val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,oSigla);				
			}
		}
		
		FncMonedaBuscar('Id',oSigla);

	}

}


/******************************************************************************/

/*
* FUNCIONES: TIPO CAMBIO
*/

function FncTipoCambioCargar(oMonedaId,oFecha,oModalidadIngresoSigla){
	
	console.log("oMonedaId: "+oMonedaId);
	console.log("oFecha");
	console.log("oModalidadIngresoSigla");

	console.log("FncTipoCambioCargar");
	
	if(oMonedaId!=""){
		
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: 'comunes/TipoCambio/JnTipoCambio.php',
			data: 'MonedaId='+oMonedaId+'&Fecha='+oFecha,
			success: function(InsTipoCambio){
				
				$('#CmpTipoCambio_'+oModalidadIngresoSigla).val(InsTipoCambio.TcaMontoComercial);	
			}
		});
		
	}
					
}

/*
* FUNCIONES: MONEDA
*/

function FncMonedaBuscar(oCampo,oModalidadIngresoSigla){
	
	var Dato = $('#CmpMoneda'+oCampo+'_'+oModalidadIngresoSigla).val();	

	if(Dato!=""){
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: Ruta+'comunes/Moneda/acc/AccMonedaBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsMoneda){
				if(InsMoneda.MonId!=""){
					FncMonedaEscoger(oModalidadIngresoSigla,InsMoneda.MonId,InsMoneda.MonNombre,InsMoneda.MonSimbolo,InsMoneda.TcaMontoCompra,InsMoneda.TcaMontoComercial);
				}				
			}
		});	
	}
	
}

function FncMonedaEscoger(oModalidadIngresoSigla,oMonedaId,oMonedaNombre,oMonedaSimbolo,oTipoCambioCompra,oTipoCambioVenta){

	$('#CmpMonedaId_'+oModalidadIngresoSigla).val(oMonedaId);
	
	FncMonedaFuncion(oModalidadIngresoSigla);

}

function FncMonedaFuncion(oModalidadIngresoSigla){

}

/*
* FUNCIONES: PRODUCTO
*/

function FncTallerPedidoProductoFormato(row) {			
	
	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td>";
	
}

function FncProductoEscoger(oSigla,oModalidadIngresoSigla,oProId,oProNombre,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,ProCostoIngreso,oProCalcularPrecio){	

	//console.log(oSigla) ;			
	//var Almacen = $("CmpAlmacen_"+oSigla).val();
	var FichaIngresoModalidadObsequio = $("#CmpFichaIngresoModalidadObsequio_"+oModalidadIngresoSigla).val();
	var FichaIngresoModalidadObsequio = $("#CmpFichaIngresoModalidadObsequio_"+oModalidadIngresoSigla).val();
	var AlmacenId = $("#CmpAlmacenId_"+oSigla).val();
	
	
	console.log("#CmpFichaIngresoModalidadObsequio_"+oModalidadIngresoSigla);	
	console.log(FichaIngresoModalidadObsequio) ;
		
	var ClienteTipoId = $("#CmpClienteTipo").val();
	var Importe = 0;

	$('#Cmp'+oSigla+'ProductoId').val(oProId);
	$('#Cmp'+oSigla+'ProductoCantidad').val("");
	$('#Cmp'+oSigla+'ProductoNombre').val(oProNombre);
	$('#Cmp'+oSigla+'ProductoTipo').val(oRtiId);
	$('#Cmp'+oSigla+'ProductoUnidadMedida').val(oUmeId);
	$('#Cmp'+oSigla+'ProductoUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
	$('#Cmp'+oSigla+'ProductoCodigoOriginal').val(oProCodigoOriginal);
	$('#Cmp'+oSigla+'ProductoCodigoAlternativo').val(oProCodigoAlternativo);

	$('#Cmp'+oSigla+'TallerPedidoDetalleCompraOrigen').val("G");
	$('#Cmp'+oSigla+'TallerPedidoDetalleEstado').val("3");
	$('#Cmp'+oSigla+'TallerPedidoDetalleReingreso').val("2");	
	
	var PorcentajeMantenimiento = $("#CmpPorcentajeMantenimiento_"+oModalidadIngresoSigla).val();
	
	var MonedaId = $("#CmpMonedaId_"+oModalidadIngresoSigla).val();
	var TipoCambio = $("#CmpTipoCambio_"+oModalidadIngresoSigla).val();
	var IncluyeImpuesto = 1;
	
	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo=2&UnidadMedidaId="+oUmeId,{}, function(j){
		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if(oUnidadMedidaIngreso == j[i].UmeId){
				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
			}
		}
		$('select#Cmp'+oSigla+'ProductoUnidadMedidaConvertir').html(options);
	})

	$('select#Cmp'+oSigla+'ProductoUnidadMedidaConvertir').unbind();
	$('select#Cmp'+oSigla+'ProductoUnidadMedidaConvertir').change(function(){
	
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){

			$('#Cmp'+oSigla+'ProductoUnidadMedidaEquivalente').val(j.UmcEquivalente);

		});
		
				if(oModalidadIngresoSigla == "GA" 
				|| oModalidadIngresoSigla == "CA" 
				|| oModalidadIngresoSigla == "PO"  
				|| oModalidadIngresoSigla == "IF" 
				|| oModalidadIngresoSigla == "AD" 
				|| oModalidadIngresoSigla == "PP" 
				|| oModalidadIngresoSigla == "OB" 
				|| FichaIngresoModalidadObsequio == "1"
				){
				
					$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId=LTI-10015&UnidadMedidaId="+$(this).val(),{}, function(j){
						
						if(IncluyeImpuesto == "1"){
		
							console.log("Incluye impuesto A") ;				
							console.log(EmpresaMonedaId+" "+MonedaId) ;
							
							if(EmpresaMonedaId == MonedaId){
								console.log("soles") ;
								
								Costo = (j.LprCosto);
							}else{
								
								if(EmpresaMonedaId == MonedaId ){
								//if(j.MonId == MonedaId ){
									console.log("otra moneda 1") ;
			
									Costo = j.LprCosto / j.ProTipoCambio;
									console.log(j.LprCosto+ " - "+j.ProTipoCambio) ;						
								}else{
									console.log("otra moneda 2") ;
									console.log(j.LprCosto) ;
									console.log(TipoCambio) ;
									Costo = j.LprCosto / TipoCambio;
								}
								
								
							}
							
							if(IncluyeImpuesto == "1"){
								Costo = (Costo * 1) + ( (Costo * 1) * ( (EmpresaImpuestoVenta * 1)/100)) ;
							}
							
							Costo = Math.ceil(Costo);
						 	Costo = Costo.toFixed(2);
								
							$('#Cmp'+oSigla+'ProductoPrecio').val(Costo);
							$('#Cmp'+oSigla+'ProductoImporte').val(Costo);
							
						}else{ //NO EXISTE ACTUALMENTE / REVISAR T.C.
							
							console.log("NO Incluye impuesto A") ;		
							//if(EmpresaMonedaId == MonedaId){
		//						Costo = (j.LprCosto);
		//					}else{
		//						Costo = j.LprCosto / TipoCambio;
		//					}
		//					
		//					//Costo = Math.ceil(Costo);
		//					Costo = Costo.toFixed(2);
		//						
		//					$('#Cmp'+oModalidadIngresoSigla+'ProductoPrecio').val(Costo);
		//					$('#Cmp'+oModalidadIngresoSigla+'ProductoImporte').val(Costo);
		//					
						}
						
						
					});
					
				}else{
									
					$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+$(this).val(),{}, function(j){
							
						if(IncluyeImpuesto == "1"){
							
							console.log("Incluye impuesto B") ;		
							
							if(EmpresaMonedaId == MonedaId){
								Precio = (j.LprPrecio);
							}else{
								Precio = j.LprPrecio / TipoCambio;
							}
							console.log(Precio) ;	
						
							if(PorcentajeMantenimiento != ""){
								//PorcentajeMantenimiento=parseFloat(PorcentajeMantenimiento);
								Precio = (Precio * 1) + ( (Precio * 1) * ( (PorcentajeMantenimiento * 1)/100)) ;
							}
		
							Precio = Math.ceil(Precio);
							Precio = Precio.toFixed(2);
							
							console.log(Precio);
							
							$('#Cmp'+oSigla+'ProductoPrecio').val(Precio);
							$('#Cmp'+oSigla+'ProductoImporte').val(Precio);

		
						}else{ //NO EXISTE ACTUALMENTE / REVISAR T.C.
							console.log("NO Incluye impuesto B") ;		
		//					if(EmpresaMonedaId == MonedaId){
		//						Costo = (j.LprCosto);
		//					}else{
		//						Costo = j.LprCosto / TipoCambio;
		//					}
		//				
		//					Costo = Math.ceil(Costo);
		//					Costo = Costo.toFixed(2);
		//					
		//					$('#Cmp'+oModalidadIngresoSigla+'ProductoPrecio').val(Costo);
		//					$('#Cmp'+oModalidadIngresoSigla+'ProductoImporte').val(Costo);
		
						}
						
					});
				
				}
	
			$('#Cmp'+oSigla+'ProductoCantidad').select();
			
	});
	
	//<input type="hidden" name="CmpFichaIngresoModalidadObsequio_<?php echo $DatTallerPedido->MinSigla?>" id="CmpFichaIngresoModalidadObsequio_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $FichaIngresoModalidadObsequio;?>" />
	
	if(oModalidadIngresoSigla == "GA" 
	|| oModalidadIngresoSigla == "CA" 
	|| oModalidadIngresoSigla == "PO" 
	|| oModalidadIngresoSigla == "IF" 
	|| oModalidadIngresoSigla == "AD" 
	|| oModalidadIngresoSigla == "PP" 
	|| oModalidadIngresoSigla == "OB"
	|| FichaIngresoModalidadObsequio == "1"
	 ){
	
		console.log("Garantia identificada");
			
		$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId=LTI-10015&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){

			if(IncluyeImpuesto == "1"){
				
				console.log("Incluye impuesto A") ;				
				console.log(j.MonId+" - "+EmpresaMonedaId+" - "+MonedaId) ;
				
				if(EmpresaMonedaId == MonedaId){					
					console.log("soles") ;					
					Costo = (j.LprCosto);
				}else{
					
//					if(j.MonId == MonedaId ){
					if(EmpresaMonedaId == MonedaId ){
						console.log("otra moneda 1") ;
						console.log(j.LprCosto+ " - "+j.ProTipoCambio) ;
						Costo = j.LprCosto	
					}else{
						console.log("otra moneda 2") ;//AAA
						console.log(j.LprCosto) ;
						console.log(TipoCambio) ;
						Costo = j.LprCosto / TipoCambio;
					}
					
				}
				
				if(IncluyeImpuesto == "1"){
					Costo = (Costo * 1) + ( (Costo * 1) * ( (EmpresaImpuestoVenta * 1)/100)) ;
				}
				
				//Costo = Math.ceil(Costo);
				//Costo = Costo.toFixed(2);					
				$('#Cmp'+oSigla+'ProductoPrecio').val(Costo);
				$('#Cmp'+oSigla+'ProductoImporte').val(Costo);
				
			}else{ //NO EXISTE ACTUALMENTE / REVISAR T.C.
			
				//console.log("No Incluye impuesto B") ;				
				//if(EmpresaMonedaId == MonedaId){
//						Costo = (j.LprCosto);
//					}else{
//						Costo = j.LprCosto / TipoCambio;
//					}
//					
//					//Costo = Math.ceil(Costo);
//					Costo = Costo.toFixed(2);
//						
//					$('#Cmp'+oModalidadIngresoSigla+'ProductoPrecio').val(Costo);
//					$('#Cmp'+oModalidadIngresoSigla+'ProductoImporte').val(Costo);
//					
			}
				
		});
		
	}else{
				
		console.log("RUEBA") ;
						
		$.getJSON("comunes/Producto/JnListaPrecio.php?ProductoId="+oProId+"&ProductoTipoId="+oRtiId+"&ClienteTipoId="+ClienteTipoId+"&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){
				
			if(IncluyeImpuesto == "1"){
				
				console.log("Incluye impuesto C") ;
				console.log(EmpresaMonedaId+" "+MonedaId) ;
				console.log(TipoCambio) ;
				
				console.log(j.LprPrecio) ;
				
				if(EmpresaMonedaId == MonedaId){
					console.log("soles") ;
					Precio = (j.LprPrecio);
				}else{
					console.log("otra moneda") ;
					console.log(TipoCambio) ;
					Precio = j.LprPrecio / TipoCambio;
				}
				
				if(PorcentajeMantenimiento != ""){
					PorcentajeMantenimiento=parseFloat(PorcentajeMantenimiento);
					Precio = (Precio * 1) + ( (Precio * 1) * ( (PorcentajeMantenimiento * 1)/100)) ;
				}
					
				//console.log(Precio) ;
				//Precio = Math.ceil(Precio);
				//Precio = Precio.toFixed(2);
				
				$('#Cmp'+oSigla+'ProductoPrecio').val(Precio);
				$('#Cmp'+oSigla+'ProductoImporte').val(Precio);
				
			}else{ //NO EXISTE ACTUALMENTE / REVISAR T.C.
				
				//console.log("No Incluye impuesto D") ;
				
				//if(EmpresaMonedaId == MonedaId){
//						Costo = (j.LprCosto);
//					}else{
//						Costo = j.LprCosto / TipoCambio;
//					}
//				
//					Costo = Math.ceil(Costo);
//					Costo = Costo.toFixed(2);
//					
//					$('#Cmp'+oModalidadIngresoSigla+'ProductoPrecio').val(Costo);
//					$('#Cmp'+oModalidadIngresoSigla+'ProductoImporte').val(Costo);
				
			}
				
				
				
		});
	
	}		
	
	
	FncCargarProductoStock(oSigla);
	
/*	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/CapProductoStock.php',
		data: 'ProductoId='+oProId+
		'&AlmacenId='+AlmacenId,
		success: function(html){
			$('#CapTallerPedidoDetalleStock_'+oSigla).html(html);
		}
	});*/
			
								
	$('#Cmp'+oSigla+'ProductoCantidad').select();
	
	$('#CmpTallerPedidoDetalleFecha_'+oSigla).val(FechaHoy);	
	
	
	
		 
	if(EmpresaAlmacenId==""){
		console.log("EmpresaAlmacenId Vacio");
		$("#CmpAlmacenId_"+oSigla).prop("selectedIndex", 1);
		
	}else{
			console.log("EmpresaAlmacenId Lleno");
		$('#CmpAlmacenId_'+oSigla).val(EmpresaAlmacenId);	
	}
						
	
	//$('#CmpProductoCantidad').select();		
	//console.log(FechaHoy+"-"+Almacen);		
	
		//if(oProCalcularPrecio=="1"){
//			 
//			$('#Cmp'+oSigla+'ProductoPrecio').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//			$("#CmpProductoImporte").removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
//			$('#Cmp'+oSigla+'ProductoPrecio').removeAttr('readonly');
//			$('#Cmp'+oSigla+'ProductoImporte').removeAttr('readonly');
//		 }else{
//			 
//			 $('#Cmp'+oSigla+'ProductoPrecio').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
//			$('#Cmp'+oSigla+'ProductoImporte').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
//			 $('#Cmp'+oSigla+'ProductoPrecio').attr('readonly', true);
//			 $('#Cmp'+oSigla+'ProductoImporte').attr('readonly', true);
//			
//		 }

	FncProductoFuncion(oSigla);

	try{
		tb_remove();
	}catch(e){
		
	}
}

function FncProductoFuncion(oSigla){
	
}

function FncProductoBuscar(oCampo,oSigla,oModalidadIngresoSigla){
	
	var Dato = $('#Cmp'+oSigla+'Producto'+oCampo).val()
	
	if(Dato!=""){
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" && InsProducto.ProId!=null){
					FncProductoEscoger(oSigla,oModalidadIngresoSigla,InsProducto.ProId,InsProducto.ProNombre,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso);
				}else{
					alert("No se encontraron datos");
					$('#Cmp'+oSigla+'Producto'+oCampo).focus();
					$('#Cmp'+oSigla+'Producto'+oCampo).select();						
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
				width: 600,
				max: 100,
				formatItem: FncTallerPedidoProductoFormato,
				minChars: 2,
				delay: 1000,
				cacheLength: 50,
				scroll: true,
				scrollHeight: 200
			});	
			
			$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").result(function(event, data, formatted) {
				if (data){
					$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
					FncProductoBuscar("Id",Sigla,Sigla);	
				}		
			});
			
			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal").unautocomplete();					
			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal").autocomplete('comunes/Producto/XmlProducto.php?t=1&Cbu=ProCodigoOriginal&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
			  width: 600,
			  max: 100,
			  formatItem: FncTallerPedidoProductoFormato,
			  minChars: 2,
			  delay: 1000,
			  cacheLength: 50,
			  scroll: true,
			  scrollHeight: 200
			});	
			
			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoOriginal").result(function(event, data, formatted) {
			  if (data){
				  $("#Cmp"+Sigla+"ProductoId").val(data[0]);				
				  FncProductoBuscar("Id",Sigla,Sigla);	
			  }		
			});
			
			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo").unautocomplete();
			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo").autocomplete('comunes/Producto/XmlProducto.php?t=1&Cbu=ProCodigoAlternativo&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
			  width: 600,
			  max: 100,
			  formatItem: FncTallerPedidoProductoFormato,
			  minChars: 2,
			  delay: 1000,
			  cacheLength: 50,
			  scroll: true,
			  scrollHeight: 200
			});	
			
			$("#Cmp"+$(this).attr('sigla')+"ProductoCodigoAlternativo").result(function(event, data, formatted) {
			  if (data){
				  $("#Cmp"+Sigla+"ProductoId").val(data[0]);				
				  FncProductoBuscar("Id",Sigla,Sigla);	
			  }		
			});

		}			 
	});


});



function FncCargarProductoStock(oSigla){
	
	var ProductoId = $("#Cmp"+oSigla+"ProductoId").val();
	var AlmacenId = $("#CmpAlmacenId_"+oSigla).val();
	
	if(ProductoId!=""){
		if(AlmacenId!=""){
			$.ajax({
				type: 'POST',
				url: 'formularios/TallerPedido/CapProductoStock.php',
				data: 'ProductoId='+ProductoId+
				'&AlmacenId='+AlmacenId,
				success: function(html){
					$('#CapTallerPedidoDetalleStock_'+oSigla).html(html);
				}
			});
		}else{
			$('#CapTallerPedidoDetalleStock_'+oSigla).html("");
		}
	}else{
		$('#CapTallerPedidoDetalleStock_'+oSigla).html("");
	}
	
		
}


/*
* Funciones Detalle
*/

function FncProductoCalcularMonto(oSigla){

	var Precio = 0;
	var Cantidad = $('#Cmp'+oSigla+'ProductoCantidad').val();
	var Importe = $('#Cmp'+oSigla+'ProductoImporte').val();	

	if(Cantidad!=""){
		if(Importe!=""){
			Precio = Importe/Cantidad;
			$('#Cmp'+oSigla+'ProductoPrecio').val(Precio);
		}else{
			
		}
	}else{
		
	}
}

function FncProductoCalcularImporte(oSigla){
	
	//console.log('#Cmp'+oModalidadIngresoSigla+'ProductoPrecio');
	//console.log('#Cmp'+oModalidadIngresoSigla+'ProductoCantidad');
	var Precio = $('#Cmp'+oSigla+'ProductoPrecio').val();
	var Cantidad = $('#Cmp'+oSigla+'ProductoCantidad').val();
	var Importe;
	//console.log(Precio);
	//console.log(Cantidad);
	if(Cantidad!=""){
		if(Precio!=""){
			Importe = Precio * Cantidad;
			//var Importe=parseFloat(Importe);
			//Importe=Math.round(Importe*100000)/100000 ;
			//document.getElementById('CmpProductoImporte').value = Importe;
			$('#Cmp'+oSigla+'ProductoImporte').val(Importe);
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpProductoCantidad').value = 0.00;
	}

}



function FncTallerPedidoCalcularMantenimientTotal(){

	var MantenimientoTotal = 0;
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="tarea"){

			var Sigla = $(this).val();
			var Importe = $("#Cmp"+Sigla+"ProductoImporte").val();

			if(Importe!=""){
				MantenimientoTotal = parseFloat(MantenimientoTotal) + parseFloat(Importe);
			}
			
		}
	});
		
	$('#CmpMantenimientoTotal').val(MantenimientoTotal);
	
	FncTallerPedidoTotalListar("MA");
}


function FncProductoReemplazoCargar(oProductoCodigoOriginal){

	tb_show('','formularios/TallerPedido/DiaProductoReemplazoBuscar.php?ProductoCodigoOriginal='+oProductoCodigoOriginal+
'&placeValuesBeforeTB_=savedValues','');	
  
}


function FncProductoConsultarCargar(oProductoId){

	tb_show('','formularios/Producto/DiaProductoConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}

function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}



function FncTallerPedidoFichasVerListado(oFichaIngresoId){


var Ancho = $( window ).width();
	var Alto = $( window ).height();

	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.2));

			
		tb_show('','formularios/TallerPedido/DiaAlmacenMovimientoListado.php?Precio=&FinId='+oFichaIngresoId+
'&placeValuesBeforeTB_=savedValues&height='+(Alto)+'&width='+(Ancho));	

}

