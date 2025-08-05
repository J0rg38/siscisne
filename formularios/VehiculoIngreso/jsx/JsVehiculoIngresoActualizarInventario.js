// JavaScript Document

//function FncVehiculoIngresoActualizarInventarioImprimir(oIndice){
//	var Accion = document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).action;
//	
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).target = '_blank';
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).submit();
//	
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).target = 'IfrVehiculoIngresoActualizarInventario'+oIndice;
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).action = Accion;
//	
//}
//
//function FncVehiculoIngresoActualizarInventarioGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).action;
//	
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).target = '_blank';
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).submit();
//	
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).target = 'IfrVehiculoIngresoActualizarInventario'+oIndice;
//	document.getElementById('FrmVehiculoIngresoActualizarInventario'+oIndice).action = Accion;
//	
//}
//
//
//
//function FncVehiculoIngresoActualizarInventarioNuevo(){
//
//		
//}


//
//
//function FncVehiculoIngresoActualizarInventarioValidar(){
//	
//	var respuesta = true
//	
//	var Sucursal = $("#CmpSucursal").val();
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//	
//	if(Sucursal==""){
//		alert("No ha escogido una sucursal.");
//		respuesta = false;
//	}
//	
//	return respuesta;
//	
//}
//
//
//
//
//
//
//
//
//function FncVehiculoIngresoActualizarInventarioCargarListado(){
//	
//	
//	if(FncVehiculoIngresoActualizarInventarioValidar()){
//		
//		var Sucursal = $("#CmpSucursal").val();
//		var VehiculoMarca = $("#CmpVehiculoMarca").val();
//		
//		
//		$("#CapVehiculoIngresoActualizarInventario").html("Cargando...");
//		
//			$.ajax({
//				type: 'POST',
//				url: 'formularios/VehiculoIngreso/IfrVehiculoIngresoActualizarInventario.php',
//				data: 'Sucursal='+Sucursal+'&VehiculoMarca='+VehiculoMarca,
//				success: function(html){
//				
//					$("#CapVehiculoIngresoActualizarInventario").html(html);
//					
//					
//						$('input[type=checkbox]').each(function () {
//	
//							if($(this).attr('etiqueta')=="vehiculo_ingreso"){
//								//FncVehiculoIngresoActualizarInventarioCargar($(this).val(),1);
//								var Id = $(this).val();
//								//console.log("#Fila_"+Id);
//								
//								$("#Fila_"+Id).click(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									
//									//FncFacturaEstablecerMoneda();
//									tb_show("EDITAR VEHICULO INGRESO",'principal2.php?Mod=VehiculoIngreso&Form=Editar&Id='+Id+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=890&modal=false',this.rel);		
//
//								});
//							}			 
//					
//						});
//	
//				}
//			});
//	}
//	
//	
//
//	/***/				
//}
//
//
//
//function FncVehiculoIngresoActualizarInventarioAccion(oClienteId){
//
//	var ClienteCSIIncluir = 2;
//	var ClienteCSIExcluirMotivo = $("#CapClienteCSIExcluirMotivo_"+oClienteId).val();
//	
//	if($("#CmpClienteCSIincluir_"+oClienteId).is(':checked')){
//		 ClienteCSIIncluir = 1;
//	}
//	
//	$("#CapVehiculoIngresoActualizarInventarioAccion_"+oClienteId).html("Guardando...");
//	
//	if(ClienteCSIExcluirMotivo==""){
//		alert("Debe ingresar un motivo");
//	}else{
//		
//		$.ajax({
//			type: 'POST',
//			url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoActualizarInventario.php',
//			data: 'ClienteId='+oClienteId+'&ClienteCSIIncluir='+ClienteCSIIncluir+'&ClienteCSIExcluirMotivo='+ClienteCSIExcluirMotivo,
//			success: function(html){
//	
//				FncVehiculoIngresoActualizarInventarioCargar(oClienteId,1);	
//					
//	
//			}
//		});
//		
//	}
//		
//	
//		
//	
//	
//	
//	
//		
//		
//}


//
//function FncVehiculoIngresoActualizarInventarioCargar(oClienteId,oCambioColor){
//
//	$("#CapVehiculoIngresoActualizarInventarioAccion_"+oClienteId).html("Cargando...");
//	
//	$.ajax({
//		type: 'POST',
//		url: 'formularios/VehiculoIngreso/CapVehiculoIngresoActualizarInventario.php',
//		data: 'ClienteId='+oClienteId,
//		success: function(html){
//
//			$("#CapVehiculoIngresoActualizarInventarioAccion_"+oClienteId).html(html);
//
//			if(oCambioColor==1){
//				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#CCCCCC');
//			}else{
//				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');	
//			}
//			
//			$("#CapClienteCSIExcluirMotivo_"+oClienteId).keyup(function (event) {  
//				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');
//			}); 
//	
//
//		}
//
//	});
//
//}



//function FncVehiculoIngresoActualizarInventarioIncluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=2&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//function FncVehiculoIngresoActualizarInventarioExcluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//
//
//function FncClienteBuscar(){
//	FncVehiculoIngresoActualizarInventarioCargarListado();
//}

$().ready(function() {

	$('input[type=checkbox]').each(function () {

			if($(this).attr('etiqueta')=="sucursal"){

				var Id = $(this).val();
								
				$("#BtnFiltrar_"+Id).click(function(){
					FncVehiculoIngresoActualizarInventarioCargarListadov2(Id);
				});
				
			}			 
	
		});
	
		//BtnFiltrarEntrega_OTRO
		$("#BtnFiltrarEntrega_OTROS").click(function(){
				FncVehiculoIngresoActualizarInventarioOtrosCargarListado("OTRO");
		});
		
});



function FncVehiculoIngresoActualizarInventarioCargarListadov2(oSigla){
	
		$("#CapVehiculoIngresoActualizarInventario_"+oSigla).html("Cargando...");
		
		var SucursalId = $("#CmpSucursalId_"+oSigla).val();
		var BuscarVIN = $("#CmpBuscarVIN_"+oSigla).val();
		
		
			$.ajax({
				type: 'POST',
				url: 'formularios/VehiculoIngreso/IfrVehiculoIngresoActualizarInventario.php',
				data: 'Sucursal='+SucursalId+'&BuscarVIN='+BuscarVIN,
				success: function(html){
				
					$("#CapVehiculoIngresoActualizarInventario_"+oSigla).html(html);
					
					
						$('input[type=checkbox]').each(function () {
	
							if($(this).attr('etiqueta')=="vehiculo_ingreso"){
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
									
									FncVehiculoIngresoActualizarInventarioCargarListadov2(Id);

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
									//FncVehiculoIngresoActualizarInventarioEditar("EIN","EinDatoAdicional","CmpDatoAdicional",Id,"");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoActualizarInventarioEditar('EIN','EinDatoAdicional','CmpDatoAdicional','"+Id+"','');", 1500);
									  $(this).data('timer', wait);
									  

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

//$("#CmpUbicacionReferencia_"+Id).focusin(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									setInterval("FncVehiculoIngresoActualizarInventarioEditar('EIN','EinUbicacionReferencia','CmpUbicacionReferencia','"+Id+"','');",3000);
//									
//
//								});
//								
//								$("#CmpUbicacionReferencia_"+Id).focusout(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									$(this).unbind();
//
//								});
//								
								
								
//								
								//$("#CmpFechaUltimoInventario_"+Id).change(function(){
//
//									console.log("#CmpFechaUltimoInventario_"+Id+" CHANGE");
//									
//									 FncVehiculoIngresoActualizarInventarioEditar("EIN","EinFechaUltimoInventario","CmpFechaUltimoInventario",Id,"1")
//								});
																								
								Calendar.setup({ 
									inputField : "CmpFechaUltimoInventario_"+Id,  // id del campo de texto 
									ifFormat   : "%d/%m/%Y",  //  
									button     : "BtnFechaUltimoInventario_"+Id,// el id del botón que  
									//onUpdate   : FncVehiculoIngresoActualizarInventarioEditar("EIN","EinFechaUltimoInventario","CmpFechaUltimoInventario",Id,"1")
									onUpdate   : FncVehiculoIngresoActualizarInventarioEditarFechaUltimoInventario
									//onUpdate   : auxx
								});
									
									
							}			 
					
						});
	
				}
			});
			
	
}






function FncVehiculoIngresoActualizarInventarioEditar(oTipo,oCampo,oInput,oId,oFecha){
	
	console.log("FncVehiculoIngresoActualizarInventarioEditar");
//$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html("Cargando...");
	//console.log("#"+oInput+"_"+oId);
	
	var Dato = $("#"+oInput+"_"+oId).val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoActualizarEntregaEditar.php',
		data: 'Tipo='+oTipo+'&Campo='+oCampo+'&Dato='+Dato+'&Id='+oId+'&Fecha='+oFecha,
		success: function(html){
		
			//$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html(html);
			console.log("ResultadoEditar: "+html);
	
		}
	});

	
}



function FncVehiculoIngresoActualizarInventarioEditarActaEntregaFecha(calendar){
	
	console.log("FncVehiculoIngresoActualizarInventarioEditarFechaUltimoInventario");
	
	//console.log("#"+calendar.params.inputField.name);	
	var Dato = $("#"+calendar.params.inputField.name).val();
	var Campo = "#"+calendar.params.inputField.name; 
	
//	console.log("#"+calendar.params.inputField);
	
	var res = Campo.split("_");	
	var Id = res[1];
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoActualizarEntregaEditar.php',
		data: 'Tipo=OVV&Campo=OvvActaEntregaFecha&Dato='+Dato+'&Id='+Id+'&Fecha=1',
		success: function(html){
		
			//$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html(html);
			console.log("ResultadoEditar: "+html);
	
		}
	});

}

function FncVehiculoIngresoActualizarInventarioEditarFechaUltimoInventario(calendar){
	
	console.log("FncVehiculoIngresoActualizarInventarioEditarFechaUltimoInventario");
	
	//console.log("#"+calendar.params.inputField.name);	
	var Dato = $("#"+calendar.params.inputField.name).val();
	var Campo = "#"+calendar.params.inputField.name; 
	
//	console.log("#"+calendar.params.inputField);
	
	var res = Campo.split("_");	
	var Id = res[1];
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoActualizarEntregaEditar.php',
		data: 'Tipo=EIN&Campo=EinFechaUltimoInventario&Dato='+Dato+'&Id='+Id+'&Fecha=1',
		success: function(html){
		
			//$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html(html);
			console.log("ResultadoEditar: "+html);
	
		}
	});

}




/***/



function FncVehiculoIngresoActualizarInventarioOtrosCargarListado(oSigla){
	
		$("#CapVehiculoIngresoActualizarInventarioOtro_"+oSigla).html("Cargando...");
		
		var SucursalId = $("#CmpSucursalId_"+oSigla).val();
		
			$.ajax({
				type: 'POST',
				url: 'formularios/VehiculoIngreso/IfrVehiculoIngresoActualizarInventarioOtro.php',
				data: 'Sucursal='+SucursalId,
				success: function(html){
				
					$("#CapVehiculoIngresoActualizarInventarioOtro_"+oSigla).html(html);
					
					
						$('input[type=checkbox]').each(function () {
	
							if($(this).attr('etiqueta')=="vehiculo_ingreso"){
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
									
									FncVehiculoIngresoActualizarInventarioCargarListadov2(Id);

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
									//FncVehiculoIngresoActualizarInventarioEditar("EIN","EinDatoAdicional","CmpDatoAdicional",Id,"");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoActualizarInventarioEditar('EIN','EinDatoAdicional','CmpDatoAdicional','"+Id+"','');", 1500);
									  $(this).data('timer', wait);
									  

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

//$("#CmpUbicacionReferencia_"+Id).focusin(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									setInterval("FncVehiculoIngresoActualizarInventarioEditar('EIN','EinUbicacionReferencia','CmpUbicacionReferencia','"+Id+"','');",3000);
//									
//
//								});
//								
//								$("#CmpUbicacionReferencia_"+Id).focusout(function(){
//									//console.log("#Fila_"+Id+" CLICK");
//									$(this).unbind();

//
//								});
//								
								
								
//								
								//$("#CmpFechaUltimoInventario_"+Id).change(function(){
//
//									console.log("#CmpFechaUltimoInventario_"+Id+" CHANGE");
//									
//									 FncVehiculoIngresoActualizarInventarioEditar("EIN","EinFechaUltimoInventario","CmpFechaUltimoInventario",Id,"1")
//								});
																								
								Calendar.setup({ 
									inputField : "CmpFechaUltimoInventario_"+Id,  // id del campo de texto 
									ifFormat   : "%d/%m/%Y",  //  
									button     : "BtnFechaUltimoInventario_"+Id,// el id del botón que  
									//onUpdate   : FncVehiculoIngresoActualizarInventarioEditar("EIN","EinFechaUltimoInventario","CmpFechaUltimoInventario",Id,"1")
									onUpdate   : FncVehiculoIngresoActualizarInventarioEditarFechaUltimoInventario
									//onUpdate   : auxx
								});
									
									
							}			 
					
						});
	
				}
			});
			
	
}

