// JavaScript Document



$().ready(function() {
	
	//FncEntregaVentaVehiculoVerCalendarioVer();
	
	$('#BtnVer').on('click', function() {
		FncEntregaVentaVehiculoVerCalendarioVer();
	});

	//$('#BtnImprimir').on('click', function() {
//		FncEntregaVentaVehiculoVerCalendarioImprimir();
//	});
//
//	$('#BtnExcel').on('click', function() {
//		FncEntregaVentaVehiculoVerCalendarioGenerarExcel();
//	});

});



function FncEntregaVentaVehiculoVerCalendarioValidar(){
	
	var respuesta = true
	var Sucursal = $("#CmpSucursal").val();
	//var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	
//	if(FechaInicio==""){
//		alert("No ha ingresado la fecha de inicio.");
//		respuesta = false;
//	}else if(FechaFin==""){
//		alert("No ha ingresado la fecha de termino.");
//		respuesta = false;		
//	}

	if(Sucursal==""){
		alert("No ha escogido una sucursal.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncEntregaVentaVehiculoVerCalendarioVer(){
	
	if(FncEntregaVentaVehiculoVerCalendarioValidar()){
		
		var PersonalMecanico = $("#CmpPersonalMecanico").val();
		var Personal = $("#CmpPersonal").val();
		var Sucursal = $("#CmpSucursal").val();
		
		$('.error').text("Cargando informacion...").fadeIn(400).delay(2000).fadeOut(400);
		
		init(Personal,PersonalMecanico,Sucursal);
	
	}

}

//
//function FncEntregaVentaVehiculoVerCalendarioImprimir(oIndice){
//	
//	if(FncEntregaVentaVehiculoVerCalendarioValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//
//		FncPopUp("formularios/EntregaVentaVehiculo/IfrEntregaVentaVehiculoVerCalendario.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=1");
//		
//	}
//
//}
//
//function FncEntregaVentaVehiculoVerCalendarioGenerarExcel(oIndice){
//	
//	if(FncEntregaVentaVehiculoVerCalendarioValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//	
////		FncPopUp("formularios/Producto/IfrEntregaVentaVehiculoVerCalendario.php?ProductoCodigoOriginal="+ProductoCodigoOriginal+"&P=2");
//		FncPopUp("formularios/EntregaVentaVehiculo/IfrEntregaVentaVehiculoVerCalendario.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=2");
//		
//	}
//	
//}
//
//
//
//function FncEntregaVentaVehiculoVerCalendarioNuevo(){
//				
//}
//


function FncEntregaVentaVehiculoBuscar(oTest){
	
}



function FncEntregaVehiculoReprogramarCerrar(){
	
	tb_remove();
	//
//	var PersonalMecanico = $("#CmpPersonalMecanico").val();
//	var Personal = $("#CmpPersonal").val();
//	var Sucursal = $("#CmpSucursal").val();
//	
//	init(Personal,PersonalMecanico,Sucursal,date);
											
}

function FncEntregaVehiculoReprogramar(oId,oFecha,oHora,oDuracion,oObservacion,oNotificar){
	
	var date = scheduler.getState().date;
	
			$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/EntregaVentaVehiculo/acc/AccEntregaVentaVehiculoReprogramar.php',
					data: 'EntregaVentaVehiculoId='+oId+'&Duracion='+oDuracion+'&Observacion='+oObservacion+'&Fecha='+oFecha+'&Hora='+oHora+'&Notificar='+oNotificar,
					success: function(respuesta){					
						
						switch(respuesta['CodigoRespuesta']){
							case 1:
								
								dhtmlx.alert({
										title:"Aviso",
										type:"alert",
										text:"Se reprogramo correctamente la entrega de vehiculo",
										callback: function(result){
											
											tb_remove();
											
											var PersonalMecanico = $("#CmpPersonalMecanico").val();
											var Personal = $("#CmpPersonal").val();
											var Sucursal = $("#CmpSucursal").val();
	
											init(Personal,PersonalMecanico,Sucursal,date);
	
										}
									});
									
							break;
							
							case 2:
								
									dhtmlx.alert({
										title:"Aviso",
										type:"alert-error",
										text:"No se pudo reprogramar la entrega de vehiculo",
										callback: function(result){
											
										}
									});
									
							break;
							
							default:
								dhtmlx.alert({
									title:"Aviso",
									type:"alert-error",
									text:"Ha ocurrido un error interno, intente nuevamente",
									callback: function(result){
										
									}
								});
							break;
						}
						
					},
					error: function(InsVehiculoIngreso){
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"Ha ocurrido un error interno, intente nuevamente",
							callback: function(result){
								
							}
						});
					}
				});
				
				
}




function FncEntregaVehiculoActualizar(oId,oDuracion,oObservacion){
	
	var date = scheduler.getState().date;
	
			$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/EntregaVentaVehiculo/acc/AccEntregaVentaVehiculoActualizar.php',
					data: 'EntregaVentaVehiculoId='+oId+'&Duracion='+oDuracion+'&Observacion='+oObservacion,
					success: function(respuesta){					
						
						switch(respuesta['CodigoRespuesta']){
							case 1:
								
								dhtmlx.alert({
										title:"Aviso",
										type:"alert",
										text:"Se actualizo correctamente la entrega de vehiculo programada",
										callback: function(result){
											
											var PersonalMecanico = $("#CmpPersonalMecanico").val();
											var Personal = $("#CmpPersonal").val();
											var Sucursal = $("#CmpSucursal").val();
	
											init(Personal,PersonalMecanico,Sucursal,date);
	
										}
									});
									
							break;
							
							case 2:
								
									dhtmlx.alert({
										title:"Aviso",
										type:"alert-error",
										text:"No se pudo actualizar la entrega de vehiculo programada",
										callback: function(result){
											
										}
									});
									
							break;
							
							default:
								dhtmlx.alert({
									title:"Aviso",
									type:"alert-error",
									text:"Ha ocurrido un error interno, intente nuevamente",
									callback: function(result){
										
									}
								});
							break;
						}
						
					},
					error: function(InsVehiculoIngreso){
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"Ha ocurrido un error interno, intente nuevamente",
							callback: function(result){
								
							}
						});
					}
				});
				
				
}


function FncEntregaVehiculoAnulado(oId,oNotificar){
	
	var date = scheduler.getState().date;
	
			$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/EntregaVentaVehiculo/acc/AccEntregaVentaVehiculoAnulado.php',
					data: 'EntregaVentaVehiculoId='+oId,
					success: function(respuesta){					
						
						switch(respuesta['CodigoRespuesta']){
							case 1:
								
								dhtmlx.alert({
										title:"Aviso",
										type:"alert",
										text:"Se marco como anulado correctamente la entrega de vehiculo programada",
										callback: function(result){
											
											var PersonalMecanico = $("#CmpPersonalMecanico").val();
											var Personal = $("#CmpPersonal").val();
											var Sucursal = $("#CmpSucursal").val();
	
											init(Personal,PersonalMecanico,Sucursal,date);
	
										}
									});
									
							break;
							
							case 2:
								
									dhtmlx.alert({
										title:"Aviso",
										type:"alert-error",
										text:"No se pudo marcar como anulado la entrega de vehiculo programada",
										callback: function(result){
											
										}
									});
									
							break;
							
							default:
								dhtmlx.alert({
									title:"Aviso",
									type:"alert-error",
									text:"Ha ocurrido un error interno, intente nuevamente",
									callback: function(result){
										
									}
								});
							break;
						}
						
					},
					error: function(InsVehiculoIngreso){
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"Ha ocurrido un error interno, intente nuevamente",
							callback: function(result){
								
							}
						});
					}
				});
				
				
}



function FncEntregaVehiculoRealizado(oId,oNotificar){
	
	var date = scheduler.getState().date;
	
			$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/EntregaVentaVehiculo/acc/AccEntregaVentaVehiculoRealizado.php',
					data: 'EntregaVentaVehiculoId='+oId,
					success: function(respuesta){					
						
						switch(respuesta['CodigoRespuesta']){
							case 1:
								
								dhtmlx.alert({
										title:"Aviso",
										type:"alert",
										text:"Se marco como realizado correctamente la entrega de vehiculo programada",
										callback: function(result){
											
											var PersonalMecanico = $("#CmpPersonalMecanico").val();
											var Personal = $("#CmpPersonal").val();
											var Sucursal = $("#CmpSucursal").val();
	
											init(Personal,PersonalMecanico,Sucursal,date);
	
										}
									});
									
							break;
							
							case 2:
								
									dhtmlx.alert({
										title:"Aviso",
										type:"alert-error",
										text:"No se pudo marcar como realizado la entrega de vehiculo programada",
										callback: function(result){
											
										}
									});
									
							break;
							
							default:
								dhtmlx.alert({
									title:"Aviso",
									type:"alert-error",
									text:"Ha ocurrido un error interno, intente nuevamente",
									callback: function(result){
										
									}
								});
							break;
						}
						
					},
					error: function(InsVehiculoIngreso){
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"Ha ocurrido un error interno, intente nuevamente",
							callback: function(result){
								
							}
						});
					}
				});
				
				
}




function FncEntregaVehiculoPendiente(oId,oNotificar){
	
	var date = scheduler.getState().date;
	
	//alert(date);
			$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/EntregaVentaVehiculo/acc/AccEntregaVentaVehiculoPendiente.php',
					data: 'EntregaVentaVehiculoId='+oId,
					success: function(respuesta){					
						
						switch(respuesta['CodigoRespuesta']){
							case 1:
								
								dhtmlx.alert({
										title:"Aviso",
										type:"alert",
										text:"Se marco como pendiente correctamente la entrega de vehiculo programada",
										callback: function(result){
											
											var PersonalMecanico = $("#CmpPersonalMecanico").val();
											var Personal = $("#CmpPersonal").val();
											var Sucursal = $("#CmpSucursal").val();
	
											init(Personal,PersonalMecanico,Sucursal,date);
	
										}
									});
									
							break;
							
							case 2:
								
									dhtmlx.alert({
										title:"Aviso",
										type:"alert-error",
										text:"No se pudo marcar como pendiente la entrega de vehiculo programada",
										callback: function(result){
											
										}
									});
									
							break;
							
							default:
								dhtmlx.alert({
									title:"Aviso",
									type:"alert-error",
									text:"Ha ocurrido un error interno, intente nuevamente",
									callback: function(result){
										
									}
								});
							break;
						}
						
					},
					error: function(InsVehiculoIngreso){
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"Ha ocurrido un error interno, intente nuevamente",
							callback: function(result){
								
							}
						});
					}
				});
				
				
}