// JavaScript Document
// JavaScript Document
$(document).ready(function (){
	
/*
* EVENTOS - INICIALES
*/
	$("#BtnCitaPresupuestoVer").click(function(){
		FncCitaPresupuestoListar();
	});
	
});




function FncCitaPresupuestoValidar(){
	
	var respuesta = true
	var CitaPresupuestoMantenimientoKilometraje = $("#CmpCitaPresupuestoMantenimientoKilometraje").val();
	var CitaPresupuestoClienteTipo = $("#CmpCitaPresupuestoClienteTipo").val();

	if(CitaPresupuestoMantenimientoKilometraje=="" || CitaPresupuestoMantenimientoKilometraje ==null ){
	
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un kilometraje",
					callback: function(result){
						$("#CmpCitaPresupuestoMantenimientoKilometraje").focus();
					}
				});
		respuesta = false;
		
	}else if(CitaPresupuestoClienteTipo=="" || CitaPresupuestoClienteTipo ==null){
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de cliente",
					callback: function(result){
						$("#CmpCitaPresupuestoClienteTipo").focus();
					}
				});
		respuesta = false
	}
	
	return respuesta;
	
}


function FncCitaPresupuestoListar(){
	
	if(FncCitaPresupuestoValidar()){
		
		
		var VehiculoMarca = $("#CmpVehiculoMarcaId").val();
		var VehiculoModelo = $("#CmpVehiculoModeloId").val();
		var MantenimientoKilometraje = $("#CmpCitaPresupuestoMantenimientoKilometraje").val();
		var ClienteTipo = $("#CmpCitaPresupuestoClienteTipo").val();
		
		$('#CapCitaPresupuesto').html("Cargando...");	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Cita/IfrCitaPresupuesto.php',
			data: 'VehiculoMarca='+VehiculoMarca
			+'&VehiculoModelo='+VehiculoModelo
			+'&MantenimientoKilometraje='+MantenimientoKilometraje
			+'&ClienteTipo='+ClienteTipo,
			success: function(html){
				
				$('#CapCitaPresupuesto').html(html);	
				
					$("#BtnImprimir").click(function(){
						FrmPresupuesto.submit();
					});
				
					$("<div id='CapAutoCompletar' />").appendTo(document.body);
	
					var VehiculoMarcaId = $("#CmpVehiculoMarcaId").val();
					var VehiculoModeloId = $("#CmpVehiculoModeloId").val();
					var VehiculoVersionId = $("#CmpVehiculoVersionId").val();
					
					var PlanMantenimientoId = $("#CmpPlanMantenimientoId").val();
					//var MantenimientoKilometraje = $("#CmpMantenimientoKilometraje").val();
					
					var ClienteTipoId = $("#CmpClienteTipo").val();
				
					$("#CmpManoObra").keyup(function(){
					
						FncPlanMantenimientoPresupuestoConsultaCalcularTotal();
					
					});
				
						/*
						* EVENTOS - INICIALES
						*/
						$('input[type=checkbox]').each(function () {
							if($(this).attr('etiqueta')=="tarea"){
								
								var Sigla = $(this).val();
						
								switch(VehiculoMarcaId){
													
													//case "VMA-10017"://CHEVROLET
									default://CHEVROLET
										
											//$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).unbind("change");
											$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).change(function(){
												
												console.log($(this).val());
												
												switch($(this).val()){
					
													case "C":
														FncTareaProductoBuscar(PlanMantenimientoId,"",Sigla,Sigla,ClienteTipoId,VehiculoMarcaId);
													break;
													
													case "I":										
														FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);									
													break;
													
													case "R":
														FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);
													break;
													
													case "X":									
														FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);									
													break;
																						
													case "U":													
														FncTareaProductoBuscar(PlanMantenimientoId,"",Sigla,Sigla,ClienteTipoId,VehiculoMarcaId);
													break;
													
													default:
													break;
												}		
			
											});
									
									break;
													
									case "VMA-10018"://ISUZU
									
										//$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).unbind("change");
										$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).change(function(){
				
											switch($(this).val()){
				
												case "R":
													FncTareaProductoBuscar(PlanMantenimientoId,"",Sigla,Sigla,ClienteTipoId,VehiculoMarcaId);		
													//FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);
												break;
												
												case "I":
													FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);
												break;
												
												case "A":
													FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);
												break;
																				
												case "T":
													FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);
												break;
												
												case "L":
													FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);
												break;
												
												case "X":		
													FncPlanMantenimientoDetalleNuevo(Sigla,VehiculoMarcaId);									
												break;
												
												case "U":
													FncTareaProductoBuscar(PlanMantenimientoId,"",Sigla,Sigla,ClienteTipoId,VehiculoMarcaId);
													break;
												
												default:
												break;
											}
				
										});
									
									break;
													
									case "":
										alert("No se encontro la MARCA DEL VEHICULO");
									break;
								}
							}
						
						});
						
						
						
						
						
						
						
						
							var VehiculoMarcaId = $("#CmpVehiculoMarcaId").val();
							var VehiculoModeloId = $("#CmpVehiculoModeloId").val();
							var VehiculoVersionId = $("#CmpVehiculoVersionId").val();
							
							var PlanMantenimientoId = $("#CmpPlanMantenimientoId").val();
							//var MantenimientoKilometraje = $("#CmpMantenimientoKilometraje").val();
							
							var ClienteTipoId = $("#CmpClienteTipo").val();
						
							$('input[type=checkbox]').each(function () {
									if($(this).attr('etiqueta')=="adicional"){
								
										var Sigla = $(this).val()
										
										function FncFormato(row) {			
											
											return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td>";
										}
						
										$("#CmpProductoNombre_"+Sigla).unautocomplete();	
										$("#CmpProductoNombre_"+Sigla).autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+VehiculoMarcaId+'&ModeloId='+VehiculoModeloId+'&VersionId='+VehiculoVersionId+'&AnoFabricacion=', {
										
											  width: 600,
											  max: 100,
											  formatItem: FncFormato,
											  minChars: 2,
											  delay: 1000,
											  cacheLength: 50,
											  scroll: true,
											  scrollHeight: 200
										  });	
								  
										  $("#CmpProductoNombre_"+Sigla).result(function(event, data, formatted) {
											  if (data){
												  $("#CmpProductoId_"+Sigla).val(data[0]);				
												  FncProductoBuscar("Id",Sigla);	
											  }		
										  });
												
												//console.log("#CmpProductoCodigoOriginal_"+Sigla);
												
										$("#CmpProductoCodigoOriginal_"+Sigla).unautocomplete();
										$("#CmpProductoCodigoOriginal_"+Sigla).autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&MarcaId='+VehiculoMarcaId+'&ModeloId='+VehiculoModeloId+'&VersionId='+VehiculoVersionId+'&AnoFabricacion=', {
											width: 600,
											max: 100,
											formatItem: FncFormato,
											minChars: 2,
											delay: 1000,
											cacheLength: 50,
											scroll: true,
											scrollHeight: 200
										});	
										
										$("#CmpProductoCodigoOriginal_"+Sigla).result(function(event, data, formatted) {
						
											if (data){		
												$("#CmpProductoId_"+Sigla).val(data[0]);												
												FncProductoBuscar("Id",Sigla);	
											}		
						
										});		
										
										$("#CmpProductoCantidad_"+Sigla).keyup(function(){
											
											FncProductoCalcularImporte(Sigla);					
											FncPlanMantenimientoPresupuestoConsultaCalcularAdicional();
											
											//console.log("tra");
											
										});
								
									
									}			 
							});
		
		
		
						
					
					
			}
		});
		
		
	//	var Identificador = $('#Identificador').val();
//		
//			
//			var VehiculoModelo = $("#CmpVehiculoIngresoModeloId").val();
//			var VehiculoModelo = $("#CmpVehiculoIngresoModeloId").val();
//			var VehiculoVersion = $("#CmpVehiculoIngresoVersionId").val();	
//		
//			var VehiculoKilometraje = $("#CmpVehiculoKilometraje").val();
//			var MantenimientoKilometraje = $("#CmpMantenimientoKilometraje").val();
//			
//			$('#CapMantenimientoAccion').html('Cargando...');
//			
//			$.ajax({
//				type: 'POST',
//				url: 'formularios/Cita/FrmCitaPresupuestoListado.php',
//				data: 'Identificador='+Identificador+'&ModalidadIngreso=&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&VehiculoKilometraje='+VehiculoKilometraje+'&MantenimientoKilometraje='+MantenimientoKilometraje,
//				success: function(html){
//					$('#CapMantenimientoAccion').html('Listo');	
//					$("#CapCitaPresupuesto").html("");
//					$("#CapCitaPresupuesto").append(html);
//				}
//			});
			
	}
	
	
}




function FncPlanMantenimientoDetalleNuevo(oSigla,oVehiculoMarcaId){
	
	console.log("FncPlanMantenimientoDetalleNuevo");
	
	$('#CmpProductoId_'+oSigla).val("");
	$('#CmpProductoCodigoOriginal_'+oSigla).val("");
	$('#CmpProductoNombre_'+oSigla).val("");
	$('#CmpProductoCantidad_'+oSigla).val("");
	
	$('#CmpProductoPrecio_'+oSigla).val("");
	$('#CmpProductoImporte_'+oSigla).val("");
	$('#CmpProductoStockReal_'+oSigla).val("");
	$('#CmpProductoTienePromocion_'+oSigla).val("");
		
	FncPlanMantenimientoPresupuestoConsultaCalcularMantenimiento(oVehiculoMarcaId);	
	FncPlanMantenimientoPresupuestoConsultaCalcularAdicional();
	
}


function FncTareaProductoBuscar(oPlanMantenimientoId,oMantenimientoKilometraje,oPlanMantenimientoTareaId,oSigla,oClienteTipoId,oVehiculoMarcaId){

//
//	var PlanMantenimientoId = $('#Cmp'+Sigla+'ProductoId').val();
//	var Kilometraje = $('#CmpKilometraje').val();
//	var PlanMantenimientoTareaId = $('#CmpPlanMantenimientoTareaId').val();
									
	if( oPlanMantenimientoId!="" || oMantenimientoKilometraje!="" || oPlanMantenimientoTareaId!="" ){

		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/TareaProducto/acc/AccTareaProductoBuscar.php',
		data: 'PlanMantenimientoId='+oPlanMantenimientoId+
		'&MantenimientoKilometraje='+oMantenimientoKilometraje+
		'&PlanMantenimientoTareaId='+oPlanMantenimientoTareaId,

		success: function(InsTareaProducto){

				if(InsTareaProducto.TprId!=""){

					$('#CmpProductoId_'+oSigla).val(InsTareaProducto.ProId);
					$('#CmpProductoCodigoOriginal_'+oSigla).val(InsTareaProducto.ProCodigoOriginal);
					$('#CmpProductoNombre_'+oSigla).val(InsTareaProducto.ProNombre);
					$('#CmpProductoCantidad_'+oSigla).val(InsTareaProducto.TprCantidad);

					$('#CmpProductoPrecio_'+oSigla).val(0);
					$('#CmpProductoImporte_'+oSigla).val(0);	

					$('#CmpProductoUnidadMedida_'+oSigla).val(InsTareaProducto.UmeId);	
					
					
					$('#CmpProductoStockReal_'+oSigla).val(InsTareaProducto.ProStockReal);
					$('#CmpProductoTienePromocion_'+oSigla).val(InsTareaProducto.ProTienePromocion);
					
					//$('#CmpProductoUnidadMedidaConvertir_'+oSigla).val(InsTareaProducto.UmeId);	
					
					$.getJSON("comunes/UnidadMedida/JnUnidadMedida.php?RtiId=&Tipo=&UnidadMedidaId=",{}, function(j){
						var options = '';
				
						options += '<option value="">Escoja una opcion</option>';
						for (var i = 0; i < j.length; i++) {
							if(InsTareaProducto.UmeId == j[i].UmeId){
								options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
							}else{
								options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
							}
						}
						$('#CmpProductoUnidadMedidaConvertir_'+oSigla).html(options);
					});	
					
					var TareaProductoCantidad = InsTareaProducto.TprCantidad;
					var ProductoId = InsTareaProducto.ProId;
					var UnidadMedidaId = InsTareaProducto.UmeId;
					
					$.ajax({
					type: 'GET',
					dataType : 'json',
					url: 'comunes/Producto/JnListaPrecio.php',
					data: 'ProductoId='+ProductoId+
					'&ClienteTipoId='+oClienteTipoId+
					'&UnidadMedidaId='+UnidadMedidaId,

						success: function(InsListaPrecio){

							//var Precio = (InsListaPrecio.LprPrecio)*1.1;//10%MANT
							var Precio = (InsListaPrecio.LprPrecio);//10%MANT
							var Cantidad = TareaProductoCantidad;
							var Importe = (Precio*1) * (Cantidad*1);
							
							console.log(Precio);
							
							Precio = Math.ceil(Precio);
							Precio = Precio.toFixed(2);
							
							Importe = Math.ceil(Importe);
							Importe = Importe.toFixed(2);
							
							//$('#CmpProductoPrecio_'+oSigla).val(InsListaPrecio.LprPrecio);
							$('#CmpProductoPrecio_'+oSigla).val(Precio);
							$('#CmpProductoImporte_'+oSigla).val(Importe);
							
							FncPlanMantenimientoPresupuestoConsultaCalcularMantenimiento(oVehiculoMarcaId);	
							//FncPlanMantenimientoPresupuestoConsultaCalcularAdicional();
					
						}
						
					});

				}else{
					alert("No se encontraron datos");	
				}
							
			}
		});
			
	}
		
}

function FncPlanMantenimientoPresupuestoConsultaCalcularMantenimiento(oVehiculoMarcaId){

	console.log("FncPlanMantenimientoPresupuestoConsultaCalcularMantenimiento");
	
	var TotalMantenimiento = 0;
	
	$('input[type=checkbox]').each(function () {
			if($(this).attr('etiqueta')=="tarea"){
				
			var Sigla = $(this).val();
			var Accion = $('#CmpPlanMantenimientoDetalleAccion_'+$(this).val()).val();
			
				switch(oVehiculoMarcaId){
					
					//case "VMA-10017"://CHEVROLET
					default://CHEVROLET
				
						switch(Accion){
				
							case "C":
								var Importe = ($('#CmpProductoImporte_'+$(this).val()).val());
								TotalMantenimiento = parseFloat(TotalMantenimiento) + parseFloat(Importe);
							break;
							
							case "U":
								var Importe = ($('#CmpProductoImporte_'+$(this).val()).val());
								TotalMantenimiento = parseFloat(TotalMantenimiento) + parseFloat(Importe);
							break;
							
							default:
							break;
						}
				
					break;
					
					case "VMA-10018"://ISUZU
												
						switch(Accion){
				
							case "R":
								var Importe = $('#CmpProductoImporte_'+$(this).val()).val();
								TotalMantenimiento = parseFloat(TotalMantenimiento) + parseFloat(Importe);
							break;
							
							case "U":
								var Importe = $('#CmpProductoImporte_'+$(this).val()).val();
								TotalMantenimiento = parseFloat(TotalMantenimiento) + parseFloat(Importe);
							break;
							
							default:
							break;
						}					
					
					break;
					
					case "":
					break;
					
				}
				
		}
	
	});
		
	$('#CmpMantenimientoTotal').val(TotalMantenimiento);
		
	FncPlanMantenimientoPresupuestoConsultaCalcularTotal();
	
}




function FncPlanMantenimientoPresupuestoConsultaCalcularAdicional(){

	var TotalAdicional = 0;
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="adicional"){
			
			var Sigla = $(this).val();
			
			//console.log(Sigla);
			var Importe = $('#CmpProductoImporte_'+Sigla).val();
			//console.log(Importe);
			if(Importe!=""){
				TotalAdicional = parseFloat(TotalAdicional) + parseFloat(Importe);
			}
			
			
		}
	});
		
	$('#CmpAdicionalTotal').val(TotalAdicional);
	
	FncPlanMantenimientoPresupuestoConsultaCalcularTotal();
	
}


function FncPlanMantenimientoPresupuestoConsultaCalcularTotal(){

	var PresupuestoTotal = 0;
	var ManoObra = $("#CmpManoObra").val();
	var MantenimientoTotal = $("#CmpMantenimientoTotal").val();
	var AdicionalTotal = $("#CmpAdicionalTotal").val();
	
	if((ManoObra)==""){
		ManoObra = 0;
	}
	
	if((MantenimientoTotal)==""){
		MantenimientoTotal = 0;
	}
	
	if((AdicionalTotal)==""){
		AdicionalTotal = 0;
	}
	
	PresupuestoTotal = parseFloat(ManoObra) + parseFloat(MantenimientoTotal) + parseFloat(AdicionalTotal);

	$('#CmpPresupuestoTotal').val(PresupuestoTotal);	
	
}



function FncProductoBuscar(oCampo,oSigla){
	
	var Dato = $('#CmpProducto'+oCampo+'_'+oSigla).val()

	if(Dato!=""){

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: 'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato+'&Sigla='+oSigla,
			success: function(InsProducto){

				if(InsProducto.ProId!="" && InsProducto.ProId!=null){
	//FncProductoEscoger(oModalidadIngresoSigla,InsProducto.ProId,InsProducto.ProNombre,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso);
					FncProductoEscoger(InsProducto,oSigla);

				}else{

					$('#CmpProducto'+oCampo+'_'+oSigla).focus();
					$('#CmpProducto'+oCampo+'_'+oSigla).select();		

				}

			}
		});

	}

}



//function FncProductoEscoger(oSigla,oProId,oProNombre,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,ProCostoIngreso){	
function FncProductoEscoger(InsProducto,oSigla){	

	var ClienteTipoId = $("#CmpClienteTipo").val();
	var Importe = 0;

	$('#CmpProductoId_'+oSigla).val(InsProducto.ProId);
	$('#CmpProductoCantidad_'+oSigla).val("1");
	$('#CmpProductoNombre_'+oSigla).val(InsProducto.ProNombre);
	$('#CmpProductoTipo_'+oSigla).val(InsProducto.RtiId);
	$('#CmpProductoUnidadMedida_'+oSigla).val(InsProducto.UmeId);
	$('#CmpProductoUnidadMedidaIngreso_'+oSigla).val(InsProducto.UmeIdIngreso);
	$('#CmpProductoCodigoOriginal_'+oSigla).val(InsProducto.ProCodigoOriginal);
	$('#CmpProductoCodigoAlternativo_'+oSigla).val(InsProducto.ProCodigoAlternativo);
	
	$('#CmpTallerPedidoDetalleEstado_'+oSigla).val("3");
	$('#CmpTallerPedidoDetalleReingreso_'+oSigla).val("2");	
	
	$('#CmpProductoStockReal_'+oSigla).val(InsProducto.ProStockReal);
	$('#CmpProductoTienePromocion_'+oSigla).val(InsProducto.ProTienePromocion);
					
					

	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsProducto.RtiId+"&Tipo=2&UnidadMedidaId="+InsProducto.UmeIdIngreso,{}, function(j){
		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if(InsProducto.UmeIdIngreso == j[i].UmeId){
				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
			}
		}
		$('select#CmpProductoUnidadMedidaConvertir_'+oSigla).html(options);
	});
			
	
	$.ajax({
	type: 'GET',
	dataType : 'json',
	url: 'comunes/Producto/JnListaPrecio.php',
	data: 'ProductoId='+InsProducto.ProId+
	'&ClienteTipoId='+ClienteTipoId+
	'&UnidadMedidaId='+InsProducto.UmeId,
	
		success: function(InsListaPrecio){
			
			console.log("calculando precio");
					
			//var Precio = (InsListaPrecio.LprPrecio)*1.1;//10%MANT
			var Precio = (InsListaPrecio.LprPrecio);//10%MANT
			var Cantidad = 1;
			var Importe = (Precio*1) * (Cantidad*1);
			
			//console.log(Precio);
			
			if(Precio!="" && Precio != null){
				
				$('#CmpProductoPrecio_'+oSigla).val(Precio);
				$('#CmpProductoImporte_'+oSigla).val(Importe);
			
			}else{
				$('#CmpProductoPrecio_'+oSigla).val("0");
				$('#CmpProductoImporte_'+oSigla).val("0");	
			}
			
			
			FncPlanMantenimientoPresupuestoConsultaCalcularAdicional();	
	
		}
		
	});
	
	
}


function FncProductoCalcularImporte(oModalidadIngresoSigla){
	
	console.log('#CmpProductoPrecio_'+oModalidadIngresoSigla);
	console.log('#CmpProductoCantidad_'+oModalidadIngresoSigla);

	var Precio = $('#CmpProductoPrecio_'+oModalidadIngresoSigla).val();
	var Cantidad = $('#CmpProductoCantidad_'+oModalidadIngresoSigla).val();
	var Importe;

	if(Cantidad!=""){
		if(Precio!=""){
			Importe = Precio * Cantidad;
			//var Importe=parseFloat(Importe);
			//Importe=Math.round(Importe*100000)/100000 ;
			//document.getElementById('CmpProductoImporte').value = Importe;
			$('#CmpProductoImporte_'+oModalidadIngresoSigla).val(Importe);
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpProductoCantidad').value = 0.00;
	}
}