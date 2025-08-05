// JavaScript Document

function FncVentaDirectaPendienteEntregaImprimir(oIndice){
	var Accion = document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).action;
	
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).target = '_blank';
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).submit();
	
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).target = 'IfrVentaDirectaPendienteEntrega'+oIndice;
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).action = Accion;
	
}

function FncVentaDirectaPendienteEntregaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).action;
	
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).target = '_blank';
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).submit();
	
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).target = 'IfrVentaDirectaPendienteEntrega'+oIndice;
	document.getElementById('FrmVentaDirectaPendienteEntrega'+oIndice).action = Accion;
	
}



function FncVentaDirectaPendienteEntregaNuevo(){

		
}







$().ready(function() {



});





function FncVentaDirectaPendienteEntregaCargarListado(){
	
	var CmpFechaInicio = $("#CmpFechaInicio").val();
	var CmpFechaFin = $("#CmpFechaFin").val();
	var CmpOrden = $("#CmpOrden").val();
	var CmpSentido = $("#CmpSentido").val();
	
	$("#CapVentaDirectaPendienteEntrega").html("Cargando...");
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/IfrVentaDirectaPendienteEntrega.php',
			data: 'CmpFechaInicio='+CmpFechaInicio+'&CmpFechaFin='+CmpFechaFin+'&CmpOrden='+CmpOrden+'&CmpSentido='+CmpSentido,
			success: function(html){
			
				$("#CapVentaDirectaPendienteEntrega").html(html);
				
				
				
				
				
					$('input[type=checkbox]').each(function () {
						if($(this).attr('etiqueta')=="vddetalle"){
							
							var VentaDirectaDetalleId = $(this).val();
							
							//console.log(VentaDirectaDetalleId);
							//console.log("BtnVentaDirectaDetalleGuardar_"+VentaDirectaDetalleId);
							/*$.ajax({
								type: 'POST',
								url: 'formularios/VentaDirecta/CapVentaDirectaDetalleNotaVer.php',
								data: 'VentaDirectaDetalleId='+VentaDirectaDetalleId,
								success: function(html){
									//MOSTRAR FORMULARIO
									$("#CapVentaDirectaDetalleFormulario_"+VentaDirectaDetalleId).html(html);
									
								}
							});*/
							
						/*	$("#BtnVentaDirectaDetalleAtendidoPendiente_"+VentaDirectaDetalleId).click(function (event) {
								
								//BARRA ESTADO - CARGANDO
								$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("Cargando...");

								$.ajax({
									type: 'POST',
									url: 'formularios/VentaDirecta/acc/AccVentaDirectaPendienteEntregaEditarAtendido.php',
									data: 'VentaDirectaDetalleId='+VentaDirectaDetalleId+'&VentaDirectaDetalleAtendido=1',
									success: function(respuesta){
										//BARRA ESTADO - LIMPIAR
										$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("");
										
										switch(respuesta){
											case "1":		
											
												//console.log("#BtnVentaDirectaDetalleAtendidoPendiente_"+VentaDirectaDetalleId);
												//console.log("#BtnVentaDirectaDetalleAtendidoRealizado_"+VentaDirectaDetalleId);
												
												$("#BtnVentaDirectaDetalleAtendidoPendiente_"+VentaDirectaDetalleId).hide();										
												$("#BtnVentaDirectaDetalleAtendidoRealizado_"+VentaDirectaDetalleId).show();										
												
												$('.error').text("Se marco como atendido el registro").fadeIn(400).delay(3000).fadeOut(400); 												
											break;
											
											case "2":
												$('.error').text("No se pudo marcar como atendido el registro").fadeIn(400).delay(3000).fadeOut(400);												
											break;
											
											default:											
												$('.error').text("Ha ocurrido un error interno").fadeIn(400).delay(3000).fadeOut(400);
											break;
										}
										
									}
								});
								
								
							});
							
							
							$("#BtnVentaDirectaDetalleAtendidoRealizado_"+VentaDirectaDetalleId).click(function (event) {
								
								//BARRA ESTADO - CARGANDO
								$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("Cargando...");

								$.ajax({
									type: 'POST',
									url: 'formularios/VentaDirecta/acc/AccVentaDirectaPendienteEntregaEditarAtendido.php',
									data: 'VentaDirectaDetalleId='+VentaDirectaDetalleId+'&VentaDirectaDetalleAtendido=2',
									success: function(respuesta){
										//BARRA ESTADO - LIMPIAR
										$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("");
										
										switch(respuesta){
											case "1":
												$("#BtnVentaDirectaDetalleAtendidoPendiente_"+VentaDirectaDetalleId).show();										
												$("#BtnVentaDirectaDetalleAtendidoRealizado_"+VentaDirectaDetalleId).hide();										
												
												//console.log("#BtnVentaDirectaDetalleAtendidoPendiente_"+VentaDirectaDetalleId);
												//console.log("#BtnVentaDirectaDetalleAtendidoRealizado_"+VentaDirectaDetalleId);
												
												
												$('.error').text("Se marco como NO atendido el registro").fadeIn(400).delay(3000).fadeOut(400); 
											break;
											
											case "2":
												$('.error').text("No se pudo marcar como NO atendido el registro").fadeIn(400).delay(3000).fadeOut(400);
											break;
											
											default:
												$('.error').text("Ha ocurrido un error interno").fadeIn(400).delay(3000).fadeOut(400);
											break;
										}
										
									}
								});
							
							});
*/
							
							
							
							$("#ChkVentaDirectaDetalleAtendido_"+VentaDirectaDetalleId).click(function (event) {
								
								var VentaDirectaDetalleAtendido = "0";
								
								if($(this).is(':checked')){									
									var VentaDirectaDetalleAtendido = "1";
								}else{
									var VentaDirectaDetalleAtendido = "2";
								}
								
								//BARRA ESTADO - CARGANDO
								$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("Cargando...");

								$.ajax({
									type: 'POST',
									url: 'formularios/VentaDirecta/acc/AccVentaDirectaPendienteEntregaEditarAtendido.php',
									data: 'VentaDirectaDetalleId='+VentaDirectaDetalleId+'&VentaDirectaDetalleAtendido='+VentaDirectaDetalleAtendido,
									success: function(respuesta){
										//BARRA ESTADO - LIMPIAR
										$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("");
										
										switch(respuesta){
											case "1":
												if(VentaDirectaDetalleAtendido=="1"){
													$('.error').text("Se marco como atendido el registro").fadeIn(400).delay(3000).fadeOut(400); 
												}else{
													$('.error').text("Se marco como NO atendido el registro").fadeIn(400).delay(3000).fadeOut(400); 
												}
											break;
											
											case "2":
												if(VentaDirectaDetalleAtendido=="1"){
													$('.error').text("No se pudo marcar como atendido el registro").fadeIn(400).delay(3000).fadeOut(400);
												}else{
													$('.error').text("No se pudo marcar como NO atendido el registro").fadeIn(400).delay(3000).fadeOut(400);
												}
											break;
											
											default:
											
												$('.error').text("Ha ocurrido un error interno").fadeIn(400).delay(3000).fadeOut(400);
											break;
										}
										
									}
								});
								
							});
							
							
							
							$("#BtnVentaDirectaDetalleMostrarFormulario_"+VentaDirectaDetalleId).click(function (event) {  
								
								//BARRA ESTADO - CARGAR
								$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("Cargando...");
								//OCULTAR BOTON 
								$(this).hide();
								
								$.ajax({
									type: 'POST',
									url: 'formularios/VentaDirecta/CapVentaDirectaNotaRegistrar.php',
									data: 'VentaDirectaDetalleId='+VentaDirectaDetalleId,
									success: function(html){
										
										//BARRA ESTADO - LIMPIAR
										$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("");
								
										//MOSTRAR FORMULARIO
										$("#CapVentaDirectaDetalleFormulario_"+VentaDirectaDetalleId).html(html);
										
										//BOTON GUARDAR
										$("#BtnVentaDirectaDetalleGuardar_"+VentaDirectaDetalleId).click(function (event) {  
											
												//BARRA ESTADO
												$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("Cargando...");
				
												var VentaDirectaDetalleNota = $("#CmpVentaDirectaDetalleNota_"+VentaDirectaDetalleId).val();
												
												$.ajax({
													type: 'POST',
													url: 'formularios/VentaDirecta/acc/AccVentaDirectaPendienteEntregaRegistrarNota.php',
													data: 'VentaDirectaDetalleId='+VentaDirectaDetalleId+'&VentaDirectaDetalleNota='+VentaDirectaDetalleNota,
													success: function(respuesta){
														
														switch(respuesta){
															case "1":
																
																$('.error').text("Se guardo correctamente la nota").fadeIn(400).delay(3000).fadeOut(400); 
																
																//BARRA ESTADO - LIMPIAR
																$("#CapVentaDirectaDetalleEstado_"+VentaDirectaDetalleId).html("");
																//BORRAR FORMULARIO
																$("#CapVentaDirectaDetalleFormulario_"+VentaDirectaDetalleId).html("");
																//MOSRAR BOTON
																$("#BtnVentaDirectaDetalleMostrarFormulario_"+VentaDirectaDetalleId).show();
														
														
															break;
															
															case "2":
															
																$('.error').text("No se pudo guardar la nota").fadeIn(400).delay(3000).fadeOut(400);
															break;
															
															default:
															
																$('.error').text("Ha ocurrido un error interno").fadeIn(400).delay(3000).fadeOut(400);
															break;
														}
										
										
														
														
													}
												});
												
										}); 
										
										
										//BOTON LIMPIAR
										$("#BtnVentaDirectaDetalleLimpiar_"+VentaDirectaDetalleId).click(function (event) {  
											$("#CmpVentaDirectaDetalleNota_"+VentaDirectaDetalleId).val("");
										}); 
										
										//BOTON OCULTAR
										$("#BtnVentaDirectaDetalleOcultar_"+VentaDirectaDetalleId).click(function (event) {  
											//BORRAR FORMULARIO
											$("#CapVentaDirectaDetalleFormulario_"+VentaDirectaDetalleId).html("");
											//MOSRAR BOTON
											$("#BtnVentaDirectaDetalleMostrarFormulario_"+VentaDirectaDetalleId).show();

										}); 
			
			
									}
								});
									
							}); 
							
							$("#BtnVentaDirectaDetalleOcultarFormulario_"+VentaDirectaDetalleId).click(function (event) {  
								
							}); 
							
							
							
							
							
			
						}		
					});

			}
		});
					
}



function FncVentaDirectaPendienteEntregaAccion(oClienteId){

	var ClienteCSIIncluir = 2;
	var ClienteCSIExcluirMotivo = $("#CapClienteCSIExcluirMotivo_"+oClienteId).val();
	
	if($("#CmpClienteCSIincluir_"+oClienteId).is(':checked')){
		 ClienteCSIIncluir = 1;
	}
	
	$("#CapVentaDirectaPendienteEntregaAccion_"+oClienteId).html("Guardando...");
	
	if(ClienteCSIExcluirMotivo==""){
		alert("Debe ingresar un motivo");
	}else{
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaDirecta/acc/AccVentaDirectaPendienteEntrega.php',
			data: 'ClienteId='+oClienteId+'&ClienteCSIIncluir='+ClienteCSIIncluir+'&ClienteCSIExcluirMotivo='+ClienteCSIExcluirMotivo,
			success: function(html){
	
				FncVentaDirectaPendienteEntregaCargar(oClienteId,1);	
					
	
			}
		});
		
	}
		
	
		
	
	
	
	
		
		
}



function FncVentaDirectaPendienteEntregaCargar(oClienteId,oCambioColor){

	$("#CapVentaDirectaPendienteEntregaAccion_"+oClienteId).html("Cargando...");
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/CapVentaDirectaPendienteEntrega.php',
		data: 'ClienteId='+oClienteId,
		success: function(html){

			$("#CapVentaDirectaPendienteEntregaAccion_"+oClienteId).html(html);

			if(oCambioColor==1){
				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#CCCCCC');
			}else{
				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');	
			}
			
			$("#CapClienteCSIExcluirMotivo_"+oClienteId).keypress(function (event) {  
				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');
			}); 
	

		}

	});

}



//function FncVentaDirectaPendienteEntregaIncluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=2&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//function FncVentaDirectaPendienteEntregaExcluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//
//
//function FncClienteBuscar(){
//	FncVentaDirectaPendienteEntregaCargarListado();
//}

