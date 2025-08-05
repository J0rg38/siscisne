


$().ready(function() {

	
	
		$("#BtnFiltrarEntrega_ENTREGA").click(function(){
				FncVehiculoIngresoActualizarEntregaCargarListadov2("ENTREGA");
		});
		
});



function FncVehiculoIngresoActualizarEntregaCargarListadov2(oSigla){
	
		$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html("Cargando...");
		
		var SucursalId = $("#CmpSucursalId_"+oSigla).val();
		
		var Ano = $("#CmpAno_"+oSigla).val();
		var Mes = $("#CmpMes_"+oSigla).val();
		var BuscarVIN = $("#CmpBuscarVIN_"+oSigla).val();
			$.ajax({
				type: 'POST',
				url: 'formularios/VehiculoIngreso/IfrVehiculoIngresoActualizarEntrega.php',
				data: 'Sucursal='+SucursalId+'&Ano='+Ano+'&Mes='+Mes+'&BuscarVIN='+BuscarVIN,
				success: function(html){
				
					$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html(html);
					
					
						$('input[type=checkbox]').each(function () {
	
							if($(this).attr('etiqueta')=="vehiculo_ingreso_entrega"){
								//FncVehiculoIngresoActualizarInventarioCargar($(this).val(),1);
								var Id = $(this).val();
								//console.log("#Fila_"+Id);
								
								$("#Fila_"+Id).click(function(){
									//console.log("#Fila_"+Id+" CLICK");
									
									//FncFacturaEstablecerMoneda();
									tb_show("EDITAR VEHICULO INGRESO",'principal2.php?Mod=VehiculoIngreso&Form=Editar&Id='+Id+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=890&modal=false',this.rel);		

								});
								
								
								$("#CmpEstadoVehicular_"+Id).change(function(){
									//console.log("#Fila_"+Id+" CLICK");
									
									FncVehiculoIngresoActualizarInventarioEditar("EIN","EinEstadoVehicular","CmpEstadoVehicular",Id,"");

								});
								
								$("#CmpNota_"+Id).keyup(function(){
									//console.log("#Fila_"+Id+" CLICK");
									
									//FncVehiculoIngresoActualizarInventarioEditar("EIN","EinNota","CmpNota",Id,"");
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoActualizarInventarioEditar('EIN','EinNota','CmpNota','"+Id+"','');", 1500);
									  $(this).data('timer', wait);

								});
								
								$("#CmpDatoAdicional_"+Id).keyup(function(){
									//console.log("#Fila_"+Id+" CLICK");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoActualizarInventarioEditar('EIN','EinDatoAdicional','CmpDatoAdicional','"+Id+"','');", 1500);
									  $(this).data('timer', wait);
									  
									  
									//FncVehiculoIngresoActualizarInventarioEditar("EIN","EinDatoAdicional","CmpDatoAdicional",Id,"");

								});
								
								$("#CmpSucursal_"+Id).change(function(){
									//console.log("#Fila_"+Id+" CLICK");
									
									FncVehiculoIngresoActualizarInventarioEditar("EIN","SucId","CmpSucursal",Id,"");

								});
								
								$("#CmpUbicacionReferencia_"+Id).keyup(function(){
									//console.log("#Fila_"+Id+" CLICK");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoActualizarInventarioEditar('EIN','EinUbicacionReferencia','CmpUbicacionReferencia','"+Id+"','');", 1500);
									  $(this).data('timer', wait);

									//FncVehiculoIngresoActualizarInventarioEditar("EIN","EinUbicacionReferencia","CmpUbicacionReferencia",Id,"");

								});
								
								
								$("#CmpFechaUltimoInventario_"+Id).keyup(function(){
									//console.log("#Fila_"+Id+" CLICK");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoActualizarInventarioEditar('EIN','EinFechaUltimoInventario','CmpFechaUltimoInventario','"+Id+"','1');", 1500);
									  $(this).data('timer', wait);//FncVehiculoIngresoActualizarInventarioEditar("EIN","EinUbicacionReferencia","CmpUbicacionReferencia",Id,"");

								});
								
								$("#CmpFechaEntrega_"+Id).keyup(function(){
									//console.log("#Fila_"+Id+" CLICK");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoActualizarInventarioEditar('OVV','OvvActaEntregaFecha','CmpFechaEntrega','"+Id+"','1');", 1500);
									  $(this).data('timer', wait);//FncVehiculoIngresoActualizarInventarioEditar("EIN","EinUbicacionReferencia","CmpUbicacionReferencia",Id,"");

								});
								
							//	$("#CmpUbicacionReferencia_"+Id).focusout(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									$(this).unbind();
//
//								});
//								
//								
								
								//$("#CmpUbicacionReferencia_"+Id).focusin(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									setInterval('FncVehiculoIngresoActualizarInventarioEditar("EIN","EinUbicacionReferencia","CmpUbicacionReferencia",Id,"");',3000);
//									
//
//								});
//								
//								$("#CmpUbicacionReferencia_"+Id).focusout(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									$(this).unbind();
//
//								});
								
								
								//$("#CmpFechaUltimoInventario_"+Id).change(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									
//									 FncVehiculoIngresoActualizarInv//entarioEditar("EIN","EinFechaUltimoInventario","CmpFechaUltimoInventario",Id,"1")
//								});
								
								
								//	Calendar.setup({ 
//									inputField : "CmpFechaEntrega_"+Id,  // id del campo de texto 
//									ifFormat   : "%d/%m/%Y",  //  
//									button     : "BtnFechaEntrega_"+Id,// el id del botón que  
//									onUpdate       :    FncVehiculoIngresoActualizarInventarioEditarActaEntregaFecha
//									});
									
									Calendar.setup({ 
									inputField : "CmpFechaUltimoInventario_"+Id,  // id del campo de texto 
									ifFormat   : "%d/%m/%Y",  //  
									button     : "BtnFechaUltimoInventario_"+Id,// el id del botón que  
									//onUpdate   :  FncVehiculoIngresoActualizarInventarioEditar("EIN","EinFechaUltimoInventario","CmpFechaUltimoInventario",Id,"1")
									onUpdate   : FncVehiculoIngresoActualizarInventarioEditarFechaUltimoInventario
									});
									
						
							}			 
					
						});
	
				}
			});
			
	
}

/***/


