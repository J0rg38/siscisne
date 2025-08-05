// JavaScript Document

// JavaScript Document

function FncVehiculoProformaDetalleNuevo(){
	
	$('#CmpVehiculoProformaDetalleId').val("");
	
	$('#CmpVehiculoIngresoId').val("");
	$('#CmpVehiculoIngresoVIN').val("");
	
	//$('#CmpVehiculoMarca').val("");
	$('#CmpVehiculoModelo').val("");
	$('#CmpVehiculoVersion').val("");
	
	$('#CmpVehiculoIngresoColor').val("");
	$('#CmpVehiculoIngresoAnoFabricacion').val("");
	$('#CmpVehiculoIngresoAnoModelo').val("");
	$('#CmpVehiculoIngresoNumeroMotor').val("");
	
	$('#CmpVehiculoProformaDetalleCosto').val("");
	
	$('#CmpVehiculoProformaDetallItem').val("");	


	$('#CapVehiculoProformaAccion').html('Listo para registrar elementos');	

	$('#CmpVehiculoModelo').focus();
	
	$('#CmpVehiculoProformaDetalleAccion').val("AccVehiculoProformaDetalleRegistrar.php");
	
	
	$('#CmpVehiculoIngresoVIN').removeAttr('readonly');
	
	$('#CmpVehiculoMarca').removeAttr('disabled');
	$('#CmpVehiculoModelo').removeAttr('disabled');
	$('#CmpVehiculoVersion').removeAttr('disabled');
	
	$('#CmpVehiculoIngresoColor').removeAttr('readonly');
	$('#CmpVehiculoIngresoAnoModelo').removeAttr('readonly');
	$('#CmpVehiculoIngresoAnoFabricacion').removeAttr('readonly');
	$('#CmpVehiculoIngresoMotor').removeAttr('readonly');
	
	//$("#CmpVehiculoIngresoVIN").unbind();
	
//	$("#CmpVehiculoMarca").unbind();
//	$("#CmpVehiculoModelo").unbind();
//	$("#CmpVehiculoVersion").unbind();
	
//	$("#CmpVehiculoIngresoColor").unbind();
//	$("#CmpVehiculoIngresoAnoModelo").unbind();
//	$("#CmpVehiculoIngresoAnoFabricacion").unbind();
//	
//	$("#CmpVehiculoIngresoNumeroMotor").unbind();
						
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnVehiculoIngresoEditar").hide();
	$("#BtnVehiculoIngresoRegistrar").show();
}

function FncVehiculoProformaDetalleGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpVehiculoProformaDetalleAccion').val();		
	
	var VehiculoProformaDetalleId = $('#CmpVehiculoProformaDetalleId').val();
	
	
	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
	
	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
	
	var VehiculoMarcaId = $('#CmpVehiculoMarca').val();
	var VehiculoModeloId = $('#CmpVehiculoModelo').val();
	var VehiculoVersionId = $('#CmpVehiculoVersion').val();
	
	var VehiculoIngresoColor = $('#CmpVehiculoIngresoColor').val();
	var VehiculoIngresoAnoFabricacion = $('#CmpVehiculoIngresoAnoFabricacion').val();
	var VehiculoIngresoAnoModelo = $('#CmpVehiculoIngresoAnoModelo').val();
	var VehiculoIngresoNumeroMotor = $('#CmpVehiculoIngresoNumeroMotor').val();
	
	var VehiculoProformaDetalleCosto = $('#CmpVehiculoProformaDetalleCosto').val().replace(",", "");
	
	var Item = $('#CmpVehiculoProformaDetalleItem').val();

	/*if(VehiculoIngresoId == ""){
		//alert("No existe el VEHICULO, se va a REGISTRAR");
		//FncVehiculoIngresoGuardarSimple();
		//FncVehiculoIngresoCargarFormulario("Registrar");
	}else*/ if(VehiculoMarcaId == ""){
		$('#CmpVehiculoMarca').focus();
	}else if(VehiculoIngresoVIN==""){
		$('#CmpVehiculoIngresoVIN').select();	
	}else if(VehiculoProformaDetalleCosto==""){
		$('#CmpVehiculoProformaDetalleCosto').select();	
	}else{
	
		$('#CapVehiculoProformaAccion').html('Guardando...');
	
		$.ajax({
		  type: 'POST',
		  url: 'formularios/VehiculoProforma/acc/'+Acc,
		  data: 'Identificador='+Identificador+
			'&VehiculoIngresoId='+VehiculoIngresoId+
			'&VehiculoMarcaId='+VehiculoMarcaId+
			'&VehiculoModeloId='+VehiculoModeloId+
			'&VehiculoVersionId='+VehiculoVersionId+
			'&VehiculoProformaDetalleCosto='+VehiculoProformaDetalleCosto+
			'&VehiculoIngresoVIN='+VehiculoIngresoVIN+
			'&VehiculoIngresoColor='+VehiculoIngresoColor+
			'&VehiculoIngresoAnoFabricacion='+VehiculoIngresoAnoFabricacion+
			'&VehiculoIngresoAnoModelo='+VehiculoIngresoAnoModelo+
			'&VehiculoIngresoNumeroMotor='+VehiculoIngresoNumeroMotor+
			'&Item='+Item,
		  success: function(){
			  $('#CapVehiculoProformaAccion').html('Listo');							
			  FncVehiculoProformaDetalleListar();
		  }
		});
	
		FncVehiculoProformaDetalleNuevo();	
	
	}
			
}


function FncVehiculoProformaDetalleListar(){

	var Identificador = $('#Identificador').val();

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$('#CapVehiculoProformaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoProforma/FrmVehiculoProformaDetalleListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+VehiculoProformaDetalleEditar+
'&Eliminar='+VehiculoProformaDetalleEliminar+
'&MonedaId='+MonedaId+
'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVehiculoProformaAccion').html('Listo');	
			$("#CapVehiculoProformaDetalles").html("");
			$("#CapVehiculoProformaDetalles").append(html);
		}
	});
	
}

function FncVehiculoProformaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	var VentaDirectaId = $('#CmpVentaDirectaId').val();

	$('#CapVehiculoProformaAccion').html('Editando...');
	$('#CmpVehiculoProformaDetalleAccion').val("AccVehiculoProformaDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoProforma/acc/AccVehiculoProformaDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsVehiculoProformaDetalle){

			/*
			SesionObjeto-VehiloListaPrecioDetalle
			Parametro1 = VpdId
			Parametro2 = EinId
			Parametro3 = 
			Parametro4 = VmaId
			Parametro5 = VmoId
			Parametro6 = VveId
			
			Parametro7 = VpdTiempoCreacion
			Parametro8 = VpdTiempoModificacion
			
			Parametro9 = VpdCosto
			Parametro10 = 
			Parametro11 = 
			
			Parametro12 = VmaNombre
			Parametro13 = VmoNombre
			Parametro14 = VveNombre
			Parametro15 = EinVIN
			Parametro16 = EinColor
			Parametro17 = EinAnoFabricacion
			Parametro18 = EinAnoModelo
			Parametro19 = EinNumeroMotor
			*/
			
			$('#CmpVehiculoIngresoId').val(InsVehiculoProformaDetalle.Parametro2);
			
			$('#CmpVehiculoIngresoVIN').val(InsVehiculoProformaDetalle.Parametro15);
			
			$('#CmpVehiculoMarcaId').val(InsVehiculoProformaDetalle.Parametro4);
			$('#CmpVehiculoModeloId').val(InsVehiculoProformaDetalle.Parametro5);
			$('#CmpVehiculoVersionId').val(InsVehiculoProformaDetalle.Parametro6);
			
			$('#CmpVehiculoMarca').val(InsVehiculoProformaDetalle.Parametro4);
			$('#CmpVehiculoModelo').val(InsVehiculoProformaDetalle.Parametro5);
			$('#CmpVehiculoVersion').val(InsVehiculoProformaDetalle.Parametro6);
			
			$('#CmpVehiculoIngresoColor').val(InsVehiculoProformaDetalle.Parametro16);
			$('#CmpVehiculoIngresoAnoFabricacion').val(InsVehiculoProformaDetalle.Parametro17);
			$('#CmpVehiculoIngresoAnoModelo').val(InsVehiculoProformaDetalle.Parametro18);
			$('#CmpVehiculoIngresoNumeroMotor').val(InsVehiculoProformaDetalle.Parametro19);
			
			$('#CmpVehiculoProformaDetalleCosto').val(InsVehiculoProformaDetalle.Parametro9);
			
			$('#CmpVehiculoProformaDetalleItem').val(InsVehiculoProformaDetalle.Item);	
			
			$("select#CmpVehiculoMarca").html('<option value="">Escoja una opcion</option>');
			
			$.getJSON("comunes/Vehiculo/JnVehiculoMarca.php",{}, function(j){
			
				var options = '';
				options += '<option value="">Escoja una opcion</option>';			
			
				if(j.length!=0){
			
					for (var i = 0; i < j.length; i++) {
						if(InsVehiculoProformaDetalle.Parametro4 == j[i].VmaId){
							options += '<option selected="selected" value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';					
						}else{
							options += '<option value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';				
						}
					}
			
				}else{
					alert("No se encontraron marcas");
				}
			
				$("select#CmpVehiculoMarca").html(options);
			
			});		
			
			$("select#CmpVehiculoModelo").html('<option value="">Escoja una opcion</option>');
			
			$.getJSON("comunes/Vehiculo/JnVehiculoModelo.php",{Marca: InsVehiculoProformaDetalle.Parametro4}, function(j){
				
				var options = '';
				options += '<option value="">Escoja una opcion</option>';			
				
				if(j.length!=0){
			
					for (var i = 0; i < j.length; i++) {
						if( InsVehiculoProformaDetalle.Parametro5 == j[i].VmoId){
							options += '<option selected="selected" value="' + j[i].VmoId + '">' + j[i].VmoNombre + '</option>';					
						}else{
							options += '<option value="' + j[i].VmoId + '">' + j[i].VmoNombre + '</option>';				
						}
					}
			
				}else{
					alert("No se encontraron marcas");
				}
			
				$("select#CmpVehiculoModelo").html(options);
			
			});		
			
			
			$("select#CmpVehiculoVersion").html('<option value="">Escoja una opcion</option>');
				
			$.getJSON("comunes/Vehiculo/JnVehiculoVersion.php",{Modelo: InsVehiculoProformaDetalle.Parametro5}, function(j){
			
				var options = '';
			
				options += '<option value="">Escoja una opcion</option>';
			
					if(j.length != 0){							
						for (var i = 0; i < j.length; i++) {
							if(InsVehiculoProformaDetalle.Parametro6 == j[i].VveId){
								options += '<option selected="selected" value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';		
							}else{
								options += '<option value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';				
							}
						}							
					}else{
						alert("No se encontraron versiones");
					}
			
					$("select#CmpVehiculoVersion").html(options);
			
				});	
				
					$('#CmpVehiculoIngresoVIN').attr('readonly', true);
			
					//$('#CmpVehiculoMarca').attr('disabled', true);
			//						$('#CmpVehiculoModelo').attr('disabled', true);
			//						$('#CmpVehiculoVersion').attr('disabled', true);
			//						
			//						$('#CmpVehiculoIngresoColor').attr('readonly', true);
			//						$('#CmpVehiculoIngresoAnoModelo').attr('readonly', true);
			//						$('#CmpVehiculoIngresoAnoFabricacion').attr('readonly', true);
			//						$('#CmpVehiculoIngresoNumeroMotor').attr('readonly', true);					
					
					$('#CmpVehiculoProformaDetalleCosto').select();
					
					
			//					
			//						$("#CmpVehiculoMarca").click(function (event) {  
			//							
			//							FncVehiculoIngresoCargarFormulario("Editar");
			//							
			//						}); 
			//						
			//						$("#CmpVehiculoModelo").click(function (event) {  
			//							
			//							FncVehiculoIngresoCargarFormulario("Editar");
			//							
			//						}); 
			//
			//						$("#CmpVehiculoVersion").click(function (event) {  
			//							
			//							FncVehiculoIngresoCargarFormulario("Editar");
			//							
			//						}); 
			
					
			
					//$("#CmpVehiculoIngresoVIN").keyup(function (event) {  
			//							 if (event.keyCode >= 48 && event.keyCode <= 90) {
			//
			//								FncVehiculoIngresoCargarFormulario("Editar");
			//
			//							 }
			//						}); 
			//						
					
			
			//						$("#CmpVehiculoIngresoColor").keyup(function (event) {  
			//							 if (event.keyCode >= 48 && event.keyCode <= 90) {
			//
			//								FncVehiculoIngresoCargarFormulario("Editar");
			//
			//							 }
			//						}); 
			//						
			//						
			//						$("#CmpVehiculoIngresoAnoModelo").keyup(function (event) {  
			//							 if (event.keyCode >= 48 && event.keyCode <= 90) {
			//
			//								FncVehiculoIngresoCargarFormulario("Editar");
			//
			//							 }
			//						}); 
			//						
			//						
			//						$("#CmpVehiculoIngresoAnoFabricacion").keyup(function (event) {  
			//							 if (event.keyCode >= 48 && event.keyCode <= 90) {
			//
			//								FncVehiculoIngresoCargarFormulario("Editar");
			//
			//							 }
			//						}); 
			//
			//
			//						$("#CmpVehiculoIngresoNumeroMotor").keyup(function (event) {  
			//							 if (event.keyCode >= 48 && event.keyCode <= 90) {
			//
			//								FncVehiculoIngresoCargarFormulario("Editar");
			//
			//							 }
			//						}); 
			
				}
			});


/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnVehiculoIngresoEditar").show();
	$("#BtnVehiculoIngresoRegistrar").hide();
}

function FncVehiculoProformaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoProformaAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoProforma/acc/AccVehiculoProformaDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoProformaAccion').html("Eliminado");	
				FncVehiculoProformaDetalleListar();
			}
		});

		FncVehiculoProformaDetalleNuevo();
	}
	
}

function FncVehiculoProformaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoProformaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoProforma/acc/AccVehiculoProformaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoProformaAccion').html('Eliminado');	
				FncVehiculoProformaDetalleListar();
			}
		});	
			
		FncVehiculoProformaDetalleNuevo();
	}
	
}



