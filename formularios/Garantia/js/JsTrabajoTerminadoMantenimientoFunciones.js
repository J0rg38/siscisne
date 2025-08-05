// JavaScript Document



function FncGarantiaMantenimientoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	var VehiculoVersion = $('#CmpVehiculoIngresoVersionId').val();
	var VehiculoModelo = $('#CmpVehiculoIngresoModeloId').val();
	
	var MantenimientoKilometraje = $('#CmpFichaIngresoMantenimientoKilometraje').val();
	
	$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaMantenimientoListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&MantenimientoKilometraje='+MantenimientoKilometraje+'&Editar='+FichaAccionMantenimientoEditar+'&Eliminar='+FichaAccionMantenimientoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'MantenimientoAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Mantenimientos").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Mantenimientos").append(html);
			
			
			
				$('input[type=checkbox]').each(function () {
					
					//alert($(this).attr('etiqueta'));
					if($(this).attr('etiqueta')=="tarea"){
					
						var MarcaId = $("#CmpVehiculoIngresoMarcaId").val();
						var ModeloId = $("#CmpVehiculoIngresoModeloId").val();
						var VersionId = $("#CmpVehiculoIngresoVersionId").val();
						var AnoFabricacion = $("#CmpVehiculoIngresoAnoFabricacion").val();
				
						var Sigla = $(this).val();
	
	
						function FncProductoFormato(row) {			
							return "<td>"+row[1]+"</td>";
						}

						$("#Cmp"+$(this).val()+"ProductoNombre").unautocomplete();	
						$("#Cmp"+$(this).val()+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre&MarcaId='+MarcaId+'&ModeloId='+ModeloId+'&VersionId='+VersionId+'&AnoFabricacion='+AnoFabricacion, {
				
	//						$("#Cmp"+$(this).val()+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
						//$("#Cmp"+$(this).val()+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
						//$("#Cmp"+$(this).attr('sigla')+"ProductoNombre").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
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
						
							
						$("#CmpPlanMantenimientoDetalleAccion_"+$(this).val()).change(function(){
							
							switch($(this).val()){
								case "C":
									$('#Cmp'+Sigla+'ProductoNombre').removeAttr('readonly');
									$('#Cmp'+Sigla+'ProductoCantidad').removeAttr('readonly');
									
									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').removeAttr('disabled');
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									
									
									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									
								break;
								
								case "I":
									FncGarantiaProductoNuevo(Sigla);
									
									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);


									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");


								break;
								
								case "R":
									FncGarantiaProductoNuevo(Sigla);

									$('#Cmp'+Sigla+'ProductoNombre').attr('readonly', true);
									$('#Cmp'+Sigla+'ProductoCantidad').attr('readonly', true);

									$('#Cmp'+Sigla+'ProductoUnidadMedidaConvertir').attr('disabled', true);
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).removeAttr('disabled');
									//$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);

									$('#Cmp'+Sigla+'ProductoNombre').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#Cmp'+Sigla+'ProductoCantidad').removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
									
								break;
								
								default:
									$('#CmpPlanMantenimientoDetalleVerificar1_'+Sigla).attr('disabled', true);
								break;
							}
	
						});
							
						
					}			 
				});
	
	
	
		}
	});
	
}
