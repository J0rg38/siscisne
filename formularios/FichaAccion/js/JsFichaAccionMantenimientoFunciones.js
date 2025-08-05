// JavaScript Document

function FncTareaProductoCargar(oVehiculoModeloId,oMantenimientoKilometraje,oPlanMantenimientoTareaId){

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaAccion/jn/JnTareaProducto.php',
		data: 'VehiculoModeloId='+oVehiculoModeloId+'&MantenimientoKilometraje='+oMantenimientoKilometraje+'&PlanMantenimientoTareaId='+oPlanMantenimientoTareaId,
		success: function(JnTareaProducto){

			$("#Cmp"+oPlanMantenimientoTareaId+"ProductoId").val(JnTareaProducto.ProId);
			$("#Cmp"+oPlanMantenimientoTareaId+"ProductoCodigoOriginal").val(JnTareaProducto.ProCodigoOriginal);
			$("#Cmp"+oPlanMantenimientoTareaId+"ProductoNombre").val(JnTareaProducto.ProNombre);
			$("#Cmp"+oPlanMantenimientoTareaId+"ProductoUnidadMedidaConvertir").val(JnTareaProducto.UmeId);
			$("#Cmp"+oPlanMantenimientoTareaId+"ProductoCantidad").val(JnTareaProducto.TprCantidad);

			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+JnTareaProducto.RtiId+"&Tipo=1&UnidadMedidaId="+JnTareaProducto.UmeId,{}, function(j){
				var options = '';
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(j[i].UmeId == JnTareaProducto.UmeId){
						options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}else{
						options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}
				}
				$('select#Cmp'+oPlanMantenimientoTareaId+'ProductoUnidadMedidaConvertir').html(options);
			});
				
				
				
		}
	});

}

function FncTareaProductoNuevo(oPlanMantenimientoTareaId){

	$("#Cmp"+oPlanMantenimientoTareaId+"ProductoId").val("");
	$("#Cmp"+oPlanMantenimientoTareaId+"ProductoCodigoOriginal").val("");
	$("#Cmp"+oPlanMantenimientoTareaId+"ProductoNombre").val("");
	$("#Cmp"+oPlanMantenimientoTareaId+"ProductoUnidadMedidaConvertir").val("");
	$("#Cmp"+oPlanMantenimientoTareaId+"ProductoCantidad").val("");
	
}

function FncFichaAccionMantenimientoLlenadoAutomatico(oModalidadIngreso){

	var MantenimientoLlenadoAutomatico = $('#CmpMantenimientoLlenadoAutomatico').val();

	if(confirm("¿Realmente desea LLENAR AUTOMATICAMENTE el plan de mantenimiento?")){
		$('#CmpMantenimientoLlenadoAutomatico').val("1");
		FncFichaAccionMantenimientoListar(oModalidadIngreso);
	}

}


function FncFichaAccionMantenimientoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	var VehiculoVersion = $('#CmpVehiculoIngresoVersionId').val();
	var VehiculoModelo = $('#CmpVehiculoIngresoModeloId').val();
	var VehiculoMarca = $('#CmpVehiculoIngresoMarcaId').val();
	var VehiculoAnoFabricacion = $('#CmpVehiculoIngresoAnoFabricacion').val();	 

	var MantenimientoKilometraje = $('#CmpFichaIngresoMantenimientoKilometraje').val();

	var MantenimientoLlenadoAutomatico = $('#CmpMantenimientoLlenadoAutomatico').val();
	
	var PlanMantenimientoId = $('#CmpPlanMantenimientoId').val();
//	var MantenimientoLlenadoAutomatico  = 2;

//	if($('#CmpMantenimientoLlenadoAutomatico').attr('checked')){
//		MantenimientoLlenadoAutomatico  = 1;
//	}

	$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Cargando...');
	$("#CapFichaAccion"+oModalidadIngreso+"Mantenimientos").html('Cargando...');


	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionMantenimientoListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&VehiculoAnoFabricacion='+VehiculoAnoFabricacion+'&VehiculoMarca='+VehiculoMarca+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&MantenimientoKilometraje='+MantenimientoKilometraje+'&MantenimientoLlenadoAutomatico='+MantenimientoLlenadoAutomatico+'&Editar='+FichaAccionMantenimientoEditar+'&Eliminar='+FichaAccionMantenimientoEliminar+'&RecibirEditar='+FichaAccionRecibirMantenimientoEditar+'&PlanMantenimientoId='+PlanMantenimientoId,     //
		success: function(html){
			$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Mantenimientos").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Mantenimientos").append(html);
			
				$('input[type=checkbox]').each(function () {
					
					if($(this).attr('etiqueta')=="tarea"){
					
						var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
						var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
						var VersionId = $("#CmpVehiculoIngresoVersionId").val();
						var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();
				
						var Sigla = $(this).val();
					
						if(FichaAccionMantenimientoEditar==1){
							
						
							$("#Cmp"+$(this).val()+"ProductoNombre").unautocomplete();	
							$("#Cmp"+$(this).val()+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
								width: 900,
								max: 100,
								formatItem: FncProductoFormato,
								minChars: 2,
								delay: 1000,
								cacheLength: 50,
								scroll: true,
								scrollHeight: 200
							});	
					
							$("#Cmp"+$(this).val()+"ProductoNombre").result(function(event, data, formatted) {
								if (data){
									$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
									FncProductoBuscar("Id",Sigla);	
								}		
							});
							
							
							$("#Cmp"+$(this).val()+"ProductoNombre").result(function(event, data, formatted) {
								if (data){
									$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
									FncProductoBuscar("Id",Sigla);	
								}		
							});
							
							
							$('#Cmp'+$(this).val()+'ProductoNombre').unbind("keyup");		
							$('#Cmp'+$(this).val()+'ProductoNombre').keyup(function(){
								if($("#Cmp"+Sigla+"ProductoNombre").val()==""){
									$("#Cmp"+Sigla+"ProductoId").val("");
									
									FncFichaAccionProductoNuevo(Sigla);
									
								}
							});
							
							
							$('#Cmp'+$(this).val()+'ProductoCantidad').unbind("keyup");						
							$('#Cmp'+$(this).val()+'ProductoCantidad').keyup(function(event){
								
								if (event.keyCode != '13' && event.keyCode != '8' && event.keyCode != '32' ) {
									
									if($("#Cmp"+Sigla+"ProductoId").val()==""){
										alert("Digite primero el nombre del PRODUCTO, para la TAREA");
										$('#Cmp'+Sigla+'ProductoCantidad').val("0.00");
									}								
									
								}
		
							});
						
						}	//alert(MarcaId);
						
						
						
						
								//console.log("#BtnEstablecerAccionNinguna_"+Sigla);
							
							$("#BtnEstablecerAccionNinguna_"+Sigla).click(function(){
								//
								///console.log("Accion: "+$(this).attr('accion'));
								
								
										if(FichaAccionMantenimientoEditar==1){
											
											$("#CmpPlanMantenimientoDetalleAccion_"+Sigla).val($(this).attr('accion'));
											
											FncFichaAccionProductoNuevo(Sigla);
										
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											
											FncTareaProductoNuevo(Sigla)
										}
										
								
								
								
							});
							
						
							
							switch(MarcaId){
								
								//case "VMA-10017"://CHEVROLET
								default://CHEVROLET
								
								
								
								//console.log("#BtnEstablecerAccion_"+Sigla);
							
							$("#BtnEstablecerAccion_"+Sigla).click(function(){
								
								//console.log("Accion: "+$(this).attr('accion'));
								
								$("#CmpPlanMantenimientoDetalleAccion_"+Sigla).val($(this).attr('accion'));
								
								if($(this).attr('accion')=="C" || $(this).attr('accion')=="U"){
								
										if(FichaAccionMantenimientoEditar==1){

											$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
											
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
											
											
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											
											FncTareaProductoCargar(ModeloId,MantenimientoKilometraje,Sigla);
											
											$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
											
										}

										
										
											
								}
								
							});
							
							
							
								
							$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).unbind("change");
							$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).change(function(){
								
								switch($(this).val()){
	
									case "C":
										
										if(FichaAccionMantenimientoEditar==1){

											$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
											
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
											
											
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											
											FncTareaProductoCargar(ModeloId,MantenimientoKilometraje,Sigla);
											
										}

										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
										
										
										/*$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).change(function(){
											FncTareaProductoCargar(ModeloId,MantenimientoKilometraje);
										});*/
										
										
											
									break;
									
									case "I":
										
										if(FichaAccionMantenimientoEditar==1){
										
											FncFichaAccionProductoNuevo(Sigla);
											
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
											
									
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");	
											
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
										
	
	
									break;
									
									case "R":
	
										if(FichaAccionMantenimientoEditar==1){
											
											FncFichaAccionProductoNuevo(Sigla);
	
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
		
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											
										}
										
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
											
										
										
									break;
									
									case "X":
									
										if(FichaAccionMantenimientoEditar==1){
											
											FncFichaAccionProductoNuevo(Sigla);
										
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											
											FncTareaProductoNuevo(Sigla)
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);
										//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
		
										
									break;
									
									
									case "U":
										
										if(FichaAccionMantenimientoEditar==1){
											
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
											
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											
											FncTareaProductoCargar(ModeloId,MantenimientoKilometraje,Sigla);
											
										}
										
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
									break;
									
									
									
									
									default:
									
										if(FichaAccionMantenimientoEditar==1){
										
											FncFichaAccionProductoNuevo(Sigla);
										
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
												
												FncTareaProductoNuevo(Sigla);
												
											}	

										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');

									break;
									
									
									
									
								}
	
							});
							
								break;
								
								case "VMA-10018"://ISUZU
								
								
								//console.log("#BtnEstablecerAccion_"+Sigla);
							
							$("#BtnEstablecerAccion_"+Sigla).click(function(){
								
								//console.log("Accion: "+$(this).attr('accion'));
								
								$("#CmpPlanMantenimientoDetalleAccion_"+Sigla).val($(this).attr('accion'));
								
								if($(this).attr('accion')=="R" || $(this).attr('accion')=="U"){
								
										if(FichaAccionMantenimientoEditar==1){

											$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
											
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
											
											
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											
											FncTareaProductoCargar(ModeloId,MantenimientoKilometraje,Sigla);
											
											$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
											
										}

										
										
											
								}
								
							});
							
							
							
							
							$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).unbind("change");
							$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).change(function(){
								
								switch($(this).val()){
	
									case "R":
										
										if(FichaAccionMantenimientoEditar==1){

											$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
										
											$('#Cmp'+Sigla+'ProductoOriginal').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
											
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											
											FncTareaProductoCargar(ModeloId,MantenimientoKilometraje,Sigla);
											
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
									break;
									
									case "I":
										
										if(FichaAccionMantenimientoEditar==1){

											FncFichaAccionProductoNuevo(Sigla);
											
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
											
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');

									break;
									
									case "A":
	
										if(FichaAccionMantenimientoEditar==1){
										
											FncFichaAccionProductoNuevo(Sigla);
		
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");

										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
									break;
									
									
									case "T":
										
										if(FichaAccionMantenimientoEditar==1){
											
											FncFichaAccionProductoNuevo(Sigla);
	
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
		
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
									break;
									
									
									case "L":
	
	
										if(FichaAccionMantenimientoEditar==1){
											
											FncFichaAccionProductoNuevo(Sigla);

											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();

											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);

											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
									break;
									
									
									case "U":
										
										if(FichaAccionMantenimientoEditar==1){

											$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
										
											$('#Cmp'+Sigla+'ProductoOriginal').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
											$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
											
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
											
											FncTareaProductoCargar(ModeloId,MantenimientoKilometraje,Sigla);
											
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
									break;
									
									
									case "X":
										
										if(FichaAccionMantenimientoEditar==1){

											FncFichaAccionProductoNuevo(Sigla);
										
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											
											FncTareaProductoNuevo(Sigla);
											
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);
									break;
									
									default:
									
										if(FichaAccionMantenimientoEditar==1){

											FncFichaAccionProductoNuevo(Sigla);
										
											$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
										
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
											$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);
		
											$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
											
											
											$('#Cmp'+Sigla+'ProductoCodigoOriginal').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
											
											FncTareaProductoNuevo(Sigla);
											
										}
										
										$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
										
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
	
	
	
		}
	});
	
}



/*

function FncFichaAccionMantenimientoListarRecibir(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	var VehiculoVersion = $('#CmpVehiculoIngresoVersionId').val();
	var VehiculoModelo = $('#CmpVehiculoIngresoModeloId').val();
	var VehiculoMarca = $('#CmpVehiculoIngresoMarcaId').val();
	var VehiculoAnoFabricacion = $('#CmpVehiculoIngresoAnoFabricacion').val();	 

	var MantenimientoKilometraje = $('#CmpFichaIngresoMantenimientoKilometraje').val();

	var MantenimientoLlenadoAutomatico = $('#CmpMantenimientoLlenadoAutomatico').val();


	$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Cargando...');


	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionMantenimientoListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&VehiculoAnoFabricacion='+VehiculoAnoFabricacion+'&VehiculoMarca='+VehiculoMarca+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&MantenimientoKilometraje='+MantenimientoKilometraje+'&MantenimientoLlenadoAutomatico='+MantenimientoLlenadoAutomatico+'&Editar='+FichaAccionMantenimientoEditar+'&Eliminar='+FichaAccionMantenimientoEliminar+'&RecibirEditar='+FichaAccionRecibirMantenimientoEditar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Mantenimientos").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Mantenimientos").append(html);
			
				$('input[type=checkbox]').each(function () {
					
					if($(this).attr('etiqueta')=="tarea"){
					
						var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
						var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
						var VersionId = $("#CmpVehiculoIngresoVersionId").val();
						var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();
				
						var Sigla = $(this).val();
	
						$("#Cmp"+$(this).val()+"ProductoNombre").unautocomplete();	
						$("#Cmp"+$(this).val()+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
							width: 900,
							max: 100,
							formatItem: FncProductoFormato,
							minChars: 2,
							delay: 1000,
							cacheLength: 50,
							scroll: true,
							scrollHeight: 200
						});	
				
						$("#Cmp"+$(this).val()+"ProductoNombre").result(function(event, data, formatted) {
							if (data){
								$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
								FncProductoBuscar("Id",Sigla);	
							}		
						});
						
						
						$("#Cmp"+$(this).val()+"ProductoNombre").result(function(event, data, formatted) {
							if (data){
								$("#Cmp"+Sigla+"ProductoId").val(data[0]);				
								FncProductoBuscar("Id",Sigla);	
							}		
						});
						
						
						$('#Cmp'+$(this).val()+'ProductoNombre').unbind("keyup");		
						$('#Cmp'+$(this).val()+'ProductoNombre').keyup(function(){
							if($("#Cmp"+Sigla+"ProductoNombre").val()==""){
								$("#Cmp"+Sigla+"ProductoId").val("");
								
								FncFichaAccionProductoNuevo(Sigla);
								
							}
						});
						
						
						$('#Cmp'+$(this).val()+'ProductoCantidad').unbind("keyup");						
						$('#Cmp'+$(this).val()+'ProductoCantidad').keyup(function(event){
							
							if (event.keyCode != '13' && event.keyCode != '8' && event.keyCode != '32' ) {
								
								if($("#Cmp"+Sigla+"ProductoId").val()==""){
									alert("Digite primero el nombre del PRODUCTO, para la TAREA");
									$('#Cmp'+Sigla+'ProductoCantidad').val("0.00");
								}								
								
							}
	
						});
						
						//alert(MarcaId);
						switch(MarcaId){
							
							//case "VMA-10017"://CHEVROLET
							default://CHEVROLET
							
						$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).unbind("change");
						$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).change(function(){
							
							switch($(this).val()){

								case "C":
								
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
								
									$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
									$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
									
									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									
									
									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									
								break;
								
								case "I":

									FncFichaAccionProductoNuevo(Sigla);
									
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
									
									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);


									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");


								break;
								
								case "R":

									FncFichaAccionProductoNuevo(Sigla);

									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();

									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
									
								break;
								
								case "X":
								
									FncFichaAccionProductoNuevo(Sigla);
								
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
								
									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
								break;
								
								
								case "U":
								
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
								
									$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
									$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
									
									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									
									
									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									
								break;
								
								
								default:
								
									
									
									FncFichaAccionProductoNuevo(Sigla);
								
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
								
									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
								break;
							}

						});
						
							break;
							
							case "VMA-10018"://ISUZU
							
						$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).unbind("change");
						$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).change(function(){
							
							switch($(this).val()){

								case "R":
									
									///alert();
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').show();
								
									$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
									$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
									
									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									
									//alert('#Cmp'+Sigla+'ProductoNombre');
									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									
								break;
								
								case "I":

									FncFichaAccionProductoNuevo(Sigla);
									
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
									
									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);


									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");


								break;
								
								case "A":

									FncFichaAccionProductoNuevo(Sigla);

									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();

									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
									
								break;
								
								
								case "T":

									FncFichaAccionProductoNuevo(Sigla);

									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();

									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
									
								break;
								
								
								case "L":

									FncFichaAccionProductoNuevo(Sigla);

									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();

									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
									
								break;
								
								
								case "X":
								
									FncFichaAccionProductoNuevo(Sigla);
								
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
								
									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
								break;
								
								default:
								
									
									
									FncFichaAccionProductoNuevo(Sigla);
								
									$('#Btn'+Sigla+'FichaAccionProductoNuevo').hide();
								
									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
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
	
	
	
		}
	});
	
}*/
