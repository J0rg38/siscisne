// JavaScript Document

function FncClienteCSIVentaEditarImprimir(oIndice){
	var Accion = document.getElementById('FrmClienteCSIVentaEditar'+oIndice).action;
	
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).target = '_blank';
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).submit();
	
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).target = 'IfrClienteCSIVentaEditar'+oIndice;
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).action = Accion;
	
}

function FncClienteCSIVentaEditarGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmClienteCSIVentaEditar'+oIndice).action;
	
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).target = '_blank';
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).submit();
	
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).target = 'IfrClienteCSIVentaEditar'+oIndice;
	document.getElementById('FrmClienteCSIVentaEditar'+oIndice).action = Accion;
	
}



function FncClienteCSIVentaEditarNuevo(){

		
}



$().ready(function() {

	$("#BtnVer").click(function(){
						
		FncClienteCSIVentaEditarCargarListado();

	});

});



function FncClienteCSIVentaEditarCargarListado(){
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var IncluirCSI = $("#CmpIncluirCSI").val();
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
	
	
	$("#CapClienteCSIVentaEditar").html("Cargando...");
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Cliente/IfrClienteCSIVentaEditarListado.php',
			data: 'FechaInicio='+FechaInicio+'&FechaFin='+FechaFin+'&Orden='+Orden+'&Sentido='+Sentido,
			success: function(html){
			
				$("#CapClienteCSIVentaEditar").html(html);
				
				
					$('input[type=checkbox]').each(function () {
						if($(this).attr('etiqueta')=="cliente"){
							
							var Sigla = $(this).val();
							
						
						$("#CmpFichaIngresoObservacionCallcenter_"+Sigla).keyup(function(){
							
							var FichaIngresoId = $(this).attr('ficha_ingreso');
							
							clearTimeout($.data(this, 'timer'));
							var wait = setTimeout("FncOrdenVentaVehiculoEditarObservacionCallcenter('"+Sigla+"','"+FichaIngresoId+"','"+$(this).val()+"');", 1500);
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
						
							
							///FncClienteCSIVentaEditarCargar($(this).val(),1);
							
							
						}		
					});

			}
		});
					
}


//
//function FncClienteCSIVentaEditarAccion(oClienteId){
//
//	var ClienteCSIVentaIncluir = 2;
//	var ClienteCSIVentaExcluirMotivo = $("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).val();
//	
//	if($("#CmpClienteCSIVentaincluir_"+oClienteId).is(':checked')){
//		 ClienteCSIVentaIncluir = 1;
//	}
//	
//	$("#CapClienteCSIVentaEditarAccion_"+oClienteId).html(ImagenGuardadoCargando);
//	
//	$.ajax({
//		type: 'POST',
//		url: 'formularios/Cliente/acc/AccClienteCSIVentaEditar.php',
//		data: 'ClienteId='+oClienteId+'&ClienteCSIVentaIncluir='+ClienteCSIVentaIncluir+'&ClienteCSIVentaExcluirMotivo='+ClienteCSIVentaExcluirMotivo,
//		success: function(html){
//			
//			if(html=="1"){
//			
//				$("#CapClienteCSIVentaEditarAccion_"+oId).html(ImagenGuardadoSi);
//			}else{
//				
//				$("#CapClienteCSIVentaEditarAccion_"+oId).html(ImagenGuardadoNo);
//			
//			}
//			
//			setTimeout("$(\"#CapClienteCSIVentaEditarAccion_"+oId+"\").html('');", 1500);
//			
//		},
//		error:function(html){
//			
//			$("#CapClienteCSIVentaEditarAccion_"+oId).html(ImagenGuardadoError);
//			
//		}
//	});
//	
//	
//		
//		
//}


//
//function FncClienteCSIVentaEditarCargar(oClienteId,oCambioColor){
//
//	$("#CapClienteCSIVentaEditarAccion_"+oClienteId).html("Cargando...");
//	
//	$.ajax({
//		type: 'POST',
//		url: 'formularios/Cliente/CapClienteCSIVentaEditar.php',
//		data: 'ClienteId='+oClienteId,
//		success: function(html){
//
//			$("#CapClienteCSIVentaEditarAccion_"+oClienteId).html(html);
//
//			if(oCambioColor==1){
//				$("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).css('background-color', '#CCCCCC');
//			}else{
//				$("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');	
//			}
//			
//			$("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).keypress(function (event) {  
//				$("#CapClienteCSIVentaExcluirMotivo_"+oClienteId).css('background-color', '#FFFFFF');
//			}); 
//	
//
//		}
//
//	});
//
//}



//function FncClienteCSIVentaEditarIncluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=2&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//function FncClienteCSIVentaEditarExcluir(oClienteId){
//	
//	tb_show('','principal2.php?Mod=Cliente&Form=CSIEditar&Dia=1&CSIIncluir=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=true',this.rel);		
//				
//}
//
//
//
//
//function FncClienteBuscar(){
//	FncClienteCSIVentaEditarCargarListado();
//}

