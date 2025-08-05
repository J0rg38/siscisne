// JavaScript Document

function FncVehiculoIngresoPredictivoMantenimientoImprimir(oIndice){
	var Accion = document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).action;
	
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).target = '_blank';
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).submit();
	
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).target = 'IfrVehiculoIngresoPredictivoMantenimiento'+oIndice;
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).action = Accion;
	
}

function FncVehiculoIngresoPredictivoMantenimientoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).action;
	
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).target = '_blank';
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).submit();
	
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).target = 'IfrVehiculoIngresoPredictivoMantenimiento'+oIndice;
	document.getElementById('FrmVehiculoIngresoPredictivoMantenimiento'+oIndice).action = Accion;
	
}



function FncVehiculoIngresoPredictivoMantenimientoNuevo(){

		
}







$().ready(function() {

	$("#BtnVer").click(function(){
		FncVehiculoIngresoPredictivoMantenimientoCargarListado();
	});
	
	$("#BtnMensajeTexto").click(function(){
		FncVehiculoIngresoMensajeTextos();
	});
	
	$("#BtnGenerarExcelMensajeTexto").click(function(){
		FncVehiculoIngresoGenerarExcelMensajeTextos();
	});

	
		//var Ancho = $( document ).width();
	var Ancho = $( window ).width();
	 
	Ancho = Ancho - (Ancho*(0.08));
	 
	$('.EstFormularioCapaListado').width(Ancho);
	
	
	
});





function FncVehiculoIngresoPredictivoMantenimientoCargarListado(){
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Sucursal = $("#CmpSucursal").val();
	
	$("#CapVehiculoIngresoPredictivoMantenimiento").html("Cargando...");
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/IfrVehiculoIngresoPredictivoMantenimiento.php',
			data: 'FechaInicio='+FechaInicio+'&FechaFin='+FechaFin+'&Orden='+Orden+'&Sentido='+Sentido+'&VehiculoMarca='+VehiculoMarca+'&Sucursal='+Sucursal,
			success: function(html){
			
				$("#CapVehiculoIngresoPredictivoMantenimiento").html(html);
				
					$('input[type=checkbox]').each(function () {

						if($(this).attr('etiqueta')=="cliente"){
							
							//FncVehiculoIngresoPredictivoMantenimientoCargar($(this).val(),1);
							//CmpPredictivoObservacion_
							
							var Id = $(this).val();
				
							$("#CmpPredictivoObservacion_"+Id).keyup(function(){
											
								 clearTimeout($.data(this, 'timer'));
								  var wait = setTimeout("FncVehiculoIngresoPredictivoMantenimientoEditarCampo('EinPredictivoObservacion','CmpPredictivoObservacion','"+Id+"');", 1500);
								  $(this).data('timer', wait);
			
			
							});
										
							
						}			 
				
					});

			}
		});
					
}



function FncVehiculoIngresoPredictivoMantenimientoAccion(oClienteId){

	var ClienteCSIVentaIncluir = 2;
	var ClienteCSIVentaExcluirMotivo = $("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).val();
	
	if($("#CmpClienteCSIVentaincluir_"+oClienteId).is(':checked')){
		 ClienteCSIVentaIncluir = 1;
	}
	
	$("#CapVehiculoIngresoPredictivoMantenimientoAccion_"+oClienteId).html("Guardando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoPredictivoMantenimiento.php',
		data: 'ClienteId='+oClienteId+'&ClienteCSIVentaIncluir='+ClienteCSIVentaIncluir+'&ClienteCSIVentaExcluirMotivo='+ClienteCSIVentaExcluirMotivo,
		success: function(html){

			FncVehiculoIngresoPredictivoMantenimientoCargar(oClienteId,1);	
				

		}
	});
	
	
		
		
}



function FncVehiculoIngresoPredictivoMantenimientoCargar(oClienteId,oCambioColor){

	console.log("FncVehiculoIngresoPredictivoMantenimientoCargar");
	
	$("#CapVehiculoIngresoPredictivoMantenimientoAccion_"+oClienteId).html("Cargando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/CapVehiculoIngresoPredictivoMantenimiento.php',
		data: 'ClienteId='+oClienteId,
		success: function(html){

			$("#CapVehiculoIngresoPredictivoMantenimientoAccion_"+oClienteId).html(html);

			if(oCambioColor==1){
				$("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).css('background-color', '#CCCCCC');
			}else{
				$("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');	
			}
			
			$("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).keypress(function (event) {  
				$("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');
			}); 
	

		}

	});

}



//function FncVehiculoIngresoPredictivoMantenimientoIncluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=2&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//function FncVehiculoIngresoPredictivoMantenimientoExcluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//
//
//function FncClienteBuscar(){
//	FncVehiculoIngresoPredictivoMantenimientoCargarListado();
//}
function FncVehiculoIngresoMensajeTextos(){
	
	var CmpFechaInicio = $("#CmpFechaInicio").val();
	var CmpFechaFin = $("#CmpFechaFin").val();
	
	//tb_show('','principal2.php?Mod=MensajeTexto&Form=Enviar&FechaInicio='+CmpFechaInicio+'&FechaFin='+CmpFechaFin+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
	tb_show('','tarea/TarEnviarMensajeTextos.php?1=1&FechaInicio='+CmpFechaInicio+'&FechaFin='+CmpFechaFin+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
				
}


function FncVehiculoIngresoGenerarExcelMensajeTextos(){
	
	var CmpFechaInicio = $("#CmpFechaInicio").val();
	var CmpFechaFin = $("#CmpFechaFin").val();
	var CmpVehiculoMarca = $("#CmpVehiculoMarca").val();
	
	//tb_show('','principal2.php?Mod=MensajeTexto&Form=Enviar&FechaInicio='+CmpFechaInicio+'&FechaFin='+CmpFechaFin+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
	tb_show('','formularios/VehiculoIngreso/acc/AccVehiculoIngresoGenerarExcelMensajeTextos.php?1=1&FechaInicio='+CmpFechaInicio+'&FechaFin='+CmpFechaFin+'&VehiculoMarca='+CmpVehiculoMarca+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
				
}






function FncVehiculoIngresoPredictivoMantenimientoEditarCampo(oCampo,oInput,oId){
	
	console.log("FncVehiculoIngresoPredictivoMantenimientoEditarCampo");

	var Dato = $("#"+oInput+"_"+oId).val();
	
	$.ajax({
		type: 'POST',
		dataType: 'JSON',
		url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoEditarCampo.php',
		data: '&Campo='+oCampo+'&Dato='+Dato+'&Id='+oId,
		success: function(Resultado){
		
			//$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html(html);
			console.log("ResultadoEditar: "+Resultado['Respuesta']);
	
		}
	});


}



function FncVehiculoMantenimientoResumenListado(oVehiculoIngresoId){
	
	if(oVehiculoIngresoId!=""){
		
		tb_show(this.title,'comunes/Vehiculo/FrmVehiculoMantenimientoListado.php?VehiculoIngresoId='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=false',this.rel);	
	}else{
		alert("No se encontro vehiculo");
	}

}

