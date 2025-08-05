// JavaScript Document

function FncClienteCSIEditarImprimir(oIndice){
	var Accion = document.getElementById('FrmClienteCSIEditar'+oIndice).action;
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = '_blank';
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmClienteCSIEditar'+oIndice).submit();
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = 'IfrClienteCSIEditar'+oIndice;
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion;
	
}

function FncClienteCSIEditarGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmClienteCSIEditar'+oIndice).action;
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = '_blank';
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmClienteCSIEditar'+oIndice).submit();
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = 'IfrClienteCSIEditar'+oIndice;
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion;
	
}



function FncClienteCSIEditarNuevo(){

		
}







$().ready(function() {
	
	
	$("#BtnVer").click(function(){
						
		FncClienteCSIEditarCargarListado();

	});


});


function FncClienteCSIEditarCargarListado(){
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Modalidad = $("#CmpModalidad").val();
	var IncluirCSI = $("#CmpIncluirCSI").val();
	
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
	
	$("#CapClienteCSIEditar").html("Cargando...");
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Cliente/IfrClienteCSIEditarListado.php',
			data: 'FechaInicio='+FechaInicio
			+'&FechaFin='+FechaFin
			+'&Sucursal='+Sucursal
			
			+'&VehiculoMarca='+VehiculoMarca
			+'&Modalidad='+Modalidad
			
			+'&IncluirCSI='+IncluirCSI
			
			+'&Orden='+Orden
			+'&Sentido='+Sentido,
			success: function(html){
			
				$("#CapClienteCSIEditar").html(html);
			
				$('input[type=checkbox]').each(function () {

					if($(this).attr('etiqueta')=="cliente"){
						
						var Sigla = $(this).val();
						
						
						$("#CmpFichaIngresoObservacionCallcenter_"+Sigla).keyup(function(){
							
							var FichaIngresoId = $(this).attr('ficha_ingreso');
							
							clearTimeout($.data(this, 'timer'));
							var wait = setTimeout("FncFichaIngresoEditarObservacionCallcenter('"+Sigla+"','"+FichaIngresoId+"','"+$(this).val()+"');", 1500);
							$(this).data('timer', wait);
							
						});
						
						/*$("#CmpClienteCSIExcluirMotivo_"+Id).keyup(function(){
						
							 clearTimeout($.data(this, 'timer'));
							  var wait = setTimeout("FncClienteCSIEditarAccion('"+Id+"');", 1500);
							  $(this).data('timer', wait);
		
						});*/
			
						$("#CmpClienteCSIincluir_"+Sigla).click(function(){
								
							// clearTimeout($.data(this, 'timer'));
//							  var wait = setTimeout("FncClienteCSIEditarAccion('"+Id+"');", 1500);
//							  $(this).data('timer', wait);
								
								
								if($(this).is(':checked')==false){
									
									var MotivoExcluir = prompt("Debes ingresar un motivo", "");		
									
									var ClienteId = $(this).attr('cliente');
									
									if(MotivoExcluir !== null && MotivoExcluir!=""){
										
										FncClienteCSIEditar($(this).val(),ClienteId,2,MotivoExcluir);
										
									}else{
										
										//FncClienteCSIEditar($(this).val(),ClienteId,1,"");
										
										$(this).prop( "checked", true );
										
										alert("No se pudo excluir del CSI, debes ingresar un motivo");	
										
									}
									
								}else{
									
									FncClienteCSIEditar($(this).val(),ClienteId,1,"");
									
								}
								
								
								
								
		
						});
						
						
						//$("#BtnRegistrarEncuesta_"+Sigla).click(function(){
//							
//							var FichaIngresoId = $(this).attr('ficha_ingreso');
//							
//							//tb_show("REGISTRAR ENCUESTA",'principal2.php?Mod=Encuesta&Form=Registrar&FinId='+FichaIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);
//							
//							//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables)
//							FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Encuesta&Form=Registrar&Dia=1","true","false","savedValues","REGISTRAR ENCUESTA","FichaIngresoId="+FichaIngresoId)
//							
//						});
						
						//$("#BtnRegistrarLlamada_"+Sigla).click(function(){
//								
//							
//							//tb_show("REGISTRAR LLAMADA",'principal2.php?Mod=FichaIngresoLlamada&Form=Registrar&FinId='+FichaIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);
//							
//							FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Encuesta&Form=Registrar&Dia=1","true","false","savedValues","REGISTRAR LLAMADA","FichaIngresoId="+FichaIngresoId)
//							
//		
//		
//						});
						
						

						//FncClienteCSIEditarCargar($(this).val(),1);
						
							//var Id = $(this).val();
//				
//							$("#CapClienteCSIExcluirMotivo_"+Id).keyup(function(){
//											
//								 clearTimeout($.data(this, 'timer'));
//								  var wait = setTimeout("FncAsignacionVentaVehiculoMonitoreoEditarCampo('OvvObservacionAsignacion','CmpOrdenVentaVehiculoObservacionAsignacion','"+Id+"');", 1500);
//								  $(this).data('timer', wait);
//			
//			
//							});
							
							/*yo solo recuerdo de mi facturita
							el cliente loco con mi facturita
							un poco de igv*/
							
					}			 
			
				});

			}
		});
					
}


function FncClienteCSIEditar(oSigla,oClienteId,oClienteCSIIncluir,oClienteCSIExcluirMotivo){
//
//	var ClienteCSIIncluir = 2;
	
//	var ClienteId = $("#CmpClienteCSIincluir_"+oSigla).attr('cliente');
//	var ClienteCSIExcluirMotivo = $("#CmpClienteCSIExcluirMotivo_"+oSigla).val();
//	
//	if($("#CmpClienteCSIincluir_"+oSigla).is(':checked')){
//		 ClienteCSIIncluir = 1;
//	}
	
	//$("#CapClienteCSIEditarAccion_"+oClienteId).html("Guardando...");
	$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoCargando);
	
	
	//if(ClienteCSIExcluirMotivo==""){
	//	alert("Debe ingresar un motivo");
	//}else{
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Cliente/acc/AccClienteCSIEditar.php',
			data: 'ClienteId='+oClienteId+'&ClienteCSIIncluir='+oClienteCSIIncluir+'&ClienteCSIExcluirMotivo='+oClienteCSIExcluirMotivo,
			success: function(Resultado){
					
					
				
				//FncClienteCSIEditarCargar(oClienteId,1);	
				if(Resultado['Respuesta']==1){			
				
					$("#CapCliCSIExcluirFecha_"+oSigla).html(Resultado['CliCSIExcluirFecha']);
					$("#CapCliCSIExcluirMotivo_"+oSigla).html(Resultado['CliCSIExcluirMotivo']);
					$("#CapCliCSIExcluirUsuario_"+oSigla).html(Resultado['CliCSIExcluirUsuario']);
				
					$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoSi);
					
				}else{					
				
					$("#CapCliCSIExcluirFecha_"+oSigla).html("");
					$("#CapCliCSIExcluirMotivo_"+oSigla).html("");
					$("#CapCliCSIExcluirUsuario_"+oSigla).html("");
				
				
				
					$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoNo);
				}	
				
				setTimeout("$(\"#CapClienteCSIEditarAccion_"+oSigla+"\").html('');", 1500);
			
				
				
				
			},
			error:function(html){
				
				$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoError);
				
			}
		});

	
		
		
}






function FncFichaIngresoEditarObservacionCallcenter(oSigla,oFichaIngresoId,oFichaIngresoObservacionCallcenter){
	
	$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoCargando);
	
	$.ajax({
		type: 'POST',
		dataType: "json",
		url: 'formularios/Cliente/acc/AccClienteFichaIngresoEditar.php',
		data: 'FichaIngresoId='+oFichaIngresoId+'&FichaIngresoObservacionCallcenter='+oFichaIngresoObservacionCallcenter,
		success: function(Respuesta){

			//FncClienteCSIEditarCargar(oClienteId,1);	
			if(Respuesta['Resultado']==1){			
				$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoSi);
			}else{					
				$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoNo);
			
			}	
			
			setTimeout("$(\"#CapClienteCSIEditarAccion_"+oSigla+"\").html('');", 1500);
		
		},
		error:function(html){
			
			$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoError);
			
		}
	});

		
}



//
//
//function FncClienteCSIEditarAccion(oSigla){
//
//	var ClienteCSIIncluir = 2;
//	
////	var ClienteId = $("#CmpClienteCSIincluir_"+oSigla).attr('cliente');
//	var ClienteCSIExcluirMotivo = $("#CmpClienteCSIExcluirMotivo_"+oSigla).val();
//	
//	if($("#CmpClienteCSIincluir_"+oSigla).is(':checked')){
//		 ClienteCSIIncluir = 1;
//	}
//	
//	//$("#CapClienteCSIEditarAccion_"+oClienteId).html("Guardando...");
//	$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoCargando);
//	
//	
//	//if(ClienteCSIExcluirMotivo==""){
//	//	alert("Debe ingresar un motivo");
//	//}else{
//		
//		$.ajax({
//			type: 'POST',
//			url: 'formularios/Cliente/acc/AccClienteCSIEditar.php',
//			data: 'ClienteId='+ClienteId+'&ClienteCSIIncluir='+ClienteCSIIncluir+'&ClienteCSIExcluirMotivo='+ClienteCSIExcluirMotivo,
//			success: function(html){
//	
//				//FncClienteCSIEditarCargar(oClienteId,1);	
//				if(html=="1"){
//			
//					$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoSi);
//				}else{
//					
//					$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoNo);
//				
//				}	
//				
//				setTimeout("$(\"#CapClienteCSIEditarAccion_"+oSigla+"\").html('');", 1500);
//			
//	
//			},
//			error:function(html){
//				
//				$("#CapClienteCSIEditarAccion_"+oSigla).html(ImagenGuardadoError);
//				
//			}
//		});
//		
//	//}
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
//function FncClienteCSIEditarCargar(oClienteId,oCambioColor){
//
//	$("#CapClienteCSIEditarAccion_"+oClienteId).html("Cargando...");
//	
//	$.ajax({
//		type: 'POST',
//		url: 'formularios/Cliente/CapClienteCSIEditar.php',
//		data: 'ClienteId='+oClienteId,
//		success: function(html){
//
//			$("#CapClienteCSIEditarAccion_"+oClienteId).html(html);
//
//		//	if(oCambioColor==1){
////				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#CCCCCC');
////			}else{
////				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');	
////			}
//			
//			//$("#CapClienteCSIExcluirMotivo_"+oClienteId).keypress(function (event) {  
////			
////				$("#CapClienteCSIExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');
////				
////			}); 
//			
//				
//			
//		}
//
//	});
//
//}



//function FncClienteCSIEditarIncluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=2&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//function FncClienteCSIEditarExcluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//
//
//function FncClienteBuscar(){
//	FncClienteCSIEditarCargarListado();
//}

