// JavaScript Document


function FncTallerPedidoMantenimientoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	var VehiculoVersion = $('#CmpVehiculoIngresoVersionId').val();
	var VehiculoModelo = $('#CmpVehiculoIngresoModeloId').val();
	
	var MantenimientoKilometraje = $('#CmpFichaIngresoMantenimientoKilometraje').val();
	
	$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Cargando...');

	$("#CapTallerPedido"+oModalidadIngreso+"Mantenimientos").html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoMantenimientoListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&MantenimientoKilometraje='+MantenimientoKilometraje+'&Editar='+TallerPedidoMantenimientoEditar+'&Eliminar='+TallerPedidoMantenimientoEliminar+'&PrimerRegistro='+PrimerRegistro,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Listo');	
			$("#CapTallerPedido"+oModalidadIngreso+"Mantenimientos").html("");
			$("#CapTallerPedido"+oModalidadIngreso+"Mantenimientos").append(html);
				
				var i = 0;
				
				$('input[type=checkbox]').each(function () {
					
					if($(this).attr('etiqueta')=="tarea"){
						
	
						var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
						var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
						var VersionId = $("#CmpVehiculoIngresoVersionId").val();
						var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();
			
						var Sigla = $(this).val();
						var ModalidadSigla = $(this).attr('modalidad_sigla');
									
						$("input,select,textarea").keypress(function (event) {  	
							 if (event.keyCode == '13' && this.type !== "hidden") {
								FncTallerPedidoNavegar(this.id);
							 }
						}); 
						
						FormularioCampos[i] = "Cmp"+Sigla+"ProductoCodigoOriginal";i++;
						FormularioCampos[i] = "Cmp"+Sigla+"ProductoNombre";i++;
						FormularioCampos[i] = "Cmp"+Sigla+"ProductoUnidadMedidaConvertir";i++;
						FormularioCampos[i] = "Cmp"+Sigla+"ProductoCantidad";i++;
						FormularioCampos[i] = "Cmp"+Sigla+"ProductoImporte";i++;
					
				
				
						/*Calendar.setup({ 
						inputField : "CmpTallerPedidoDetalleFecha_"+Sigla,  // id del campo de texto 
						ifFormat   : "%d/%m/%Y",  //  
						button     : "BtnTallerPedidoDetalleFecha_"+Sigla// el id del botón que  
						});*/
						
						$("#Cmp"+Sigla+"ProductoCantidad").keyup(function(){

							FncProductoCalcularImporte(Sigla);		
							FncTallerPedidoCalcularMantenimientTotal();

						});
						
						$("#Cmp"+Sigla+"ProductoImporte").keyup(function(){

							FncProductoCalcularMonto(Sigla);		
							FncTallerPedidoCalcularMantenimientTotal();

						});
			
						$("#Cmp"+$(this).val()+"ProductoNombre").unautocomplete();					
						$("#Cmp"+$(this).val()+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
				
							width: 600,
							max: 100,
							formatItem: FncTallerPedidoProductoFormato,
							minChars: 2,
							delay: 1000,
							cacheLength: 50,
							scroll: true,
							scrollHeight: 200
						});	
				
						$("#Cmp"+$(this).val()+"ProductoNombre").result(function(event, data, formatted) {
							if (data){
								$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
								FncProductoBuscar("Id",Sigla,ModalidadSigla);	
							}		
						});
						
						$("#Cmp"+$(this).val()+"ProductoCodigoOriginal").unautocomplete();
						$("#Cmp"+$(this).val()+"ProductoCodigoOriginal").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
							width: 600,
							max: 100,
							formatItem: FncTallerPedidoProductoFormato,
							minChars: 2,
							delay: 1000,
							cacheLength: 50,
							scroll: true,
							scrollHeight: 200
						});	
				
						$("#Cmp"+$(this).val()+"ProductoCodigoOriginal").result(function(event, data, formatted) {
							if (data){
								$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
								FncProductoBuscar("Id",Sigla,ModalidadSigla);	
							}		
						});
						
						//aldo.liendo61
						//aliendo2017
						switch(MarcaId){
						
							//case "VMA-10017"://CHEVROLET
							default://CHEVROLET

								$("#CmpFichaAccionMantenimientoAccion_"+$(this).val()).unbind("change");
								$("#CmpFichaAccionMantenimientoAccion_"+$(this).val()).change(function(){
									
								});

							break;
							
							case "VMA-10018"://ISUZU
						
								$("#CmpFichaAccionMantenimientoAccion_"+$(this).val()).unbind("change");
								$("#CmpFichaAccionMantenimientoAccion_"+$(this).val()).change(function(){
								});
					
							break;
							
							case "":
								alert("No se encontro la MARCA DEL VEHICULO");
							break;
						
						}
						
					  $("#BtnTareaProductoPredeterminar_"+Sigla).click(function(){
							
							console.log("BtnTareaProductoPredeterminar_click");
							
							var ProductoId = $("#Cmp"+Sigla+"ProductoId").val();
							var ProductoCantidad = $("#Cmp"+Sigla+"ProductoCantidad").val();
							var ProductoImporte = $("#Cmp"+Sigla+"ProductoImporte").val();
						
							var ProductoUnidadMedidaConvertir = $("#Cmp"+Sigla+"ProductoUnidadMedidaConvertir").val();
							var AlmacenId = $("#CmpAlmacenId_"+Sigla).val();									
							
							console.log(ProductoId);
							console.log(ProductoCantidad);
							console.log(ProductoImporte);
							console.log(ProductoUnidadMedidaConvertir);
							console.log(AlmacenId);
										
							if(ProductoId!=""){
								if(ProductoCantidad!="" || ProductoCantidad !=0){
									if(ProductoUnidadMedidaConvertir!=""){
										if(MarcaId!=""){
											if(ModeloId!=""){
												if(VersionId!=""){
													if(Sigla!=""){
														
														if(AlmacenId!=""){
															
															dhtmlx.confirm("¿Realmente desea predeterminar este producto para futuros mantenimientos?", function(result){
																if(result==true){
	
																	$.ajax({
																		type: 'POST',
																		url: 'formularios/TareaProducto/acc/AccTareaProductoPredeterminar.php',
																		data: 'ProductoId='+ProductoId+'&ProductoCantidad='+ProductoCantidad+'&ProductoImporte='+ProductoImporte+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&PlanMantenimientoTareaId='+Sigla+'&AlmacenId='+AlmacenId,
																		success: function(respuesta){
																			switch(respuesta){
																				case "1":
								
																					dhtmlx.alert({
																						title:"Aviso",
																						type:"alert",
																						text:"Se predetermino el producto correctamente",
																						callback: function(result){
																						}
																					});
								
																				break;
																				
																				case "2":
																				
																					dhtmlx.alert({
																						title:"Aviso",
																						type:"alert-error",
																						text:"No se pudo predeterminar el producto",
																						callback: function(result){
																						}
																					});
																				
																				break;
																				
																				default:
																				
																					dhtmlx.alert({
																						title:"Aviso",
																						type:"alert-error",
																						text:"Ha ocurrido un error interno",
																						callback: function(result){
																						}
																					});
																				
																				break;
																			}
																		}
																	});
	
																}else{
																	
																}
															});
															
														}else{
																dhtmlx.alert({
																	title:"Aviso",
																	type:"alert-error",
																	text:"No se encontro almacen a predeterminar",
																	callback: function(result){
																	}
																});	
														}
														
														
							
													}
												}
											}
										}
									}else{
										
										dhtmlx.alert({
											title:"Aviso",
											type:"alert-error",
											text:"No se encontro unidad de medida de producto a predeterminar",
											callback: function(result){
											}
										});	
										
									}
								}else{
									dhtmlx.alert({
										title:"Aviso",
										type:"alert-error",
										text:"No se encontro cantidad de producto a predeterminar",
										callback: function(result){
										}
									});	
								}
							}else{
									dhtmlx.alert({
										title:"Aviso",
										type:"alert-error",
										text:"No se encontro producto a predeterminar",
										callback: function(result){
										}
									});
							}
							
							
							

						});
						
						 
						if($("#CmpAlmacenId_"+Sigla).val()==""){
							//console.log("#CmpAlmacenId_"+Sigla);
							//$("#CmpAlmacenId_"+Sigla).val($("#CmpAlmacenId_"+Sigla+" option:first").val());	
							
							$("#CmpAlmacenId_"+Sigla).prop("selectedIndex", 1);
							//$("#CmpAlmacenId_"+Sigla+" option:first").attr('selected','selected');
							
						}else{
							//console.log("#CmpAlmacenId_"+Sigla+": "+$("#CmpAlmacenId_"+Sigla).val());
						}
						
						 
						if($("#Cmp"+Sigla+"TallerPedidoDetalleEstado").val()==""){
							//console.log("#Cmp"+Sigla+"TallerPedidoDetalleEstado"));
							//$("#CmpAlmacenId_"+Sigla).val($("#CmpAlmacenId_"+Sigla+" option:first").val());	
							
							$("#Cmp"+Sigla+"TallerPedidoDetalleEstado").prop("selectedIndex", 2);
							//$("#CmpAlmacenId_"+Sigla+" option:first").attr('selected','selected');
							
						}else{
							//console.log("#CmpAlmacenId_"+Sigla+": "+$("#CmpAlmacenId_"+Sigla).val());
						}
						
						
						
						$("#Cmp"+Sigla+"TallerPedidoDetalleEstado").change(function(){
							
							console.log("#Cmp"+Sigla+"TallerPedidoDetalleEstado");
							
							if($(this).val()=="1"){
								$(this).removeClass("EstFormularioCombo").addClass("EstFormularioComboAnulado");	
							}else{
								$(this).removeClass("EstFormularioComboAnulado").addClass("EstFormularioCombo");
							}
							
						});
						
						FncCargarProductoStock(Sigla);
						
					}			 
				});
	
				
				FncTallerPedidoTotalListar(oModalidadIngreso);
	
		}
	});
	
	
	
	
}
