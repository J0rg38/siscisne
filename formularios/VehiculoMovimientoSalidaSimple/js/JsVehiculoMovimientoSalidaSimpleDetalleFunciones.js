// JavaScript Document

function FncVehiculoMovimientoSalidaSimpleDetalleNuevo(){
	
	console.log("FncVehiculoMovimientoSalidaSimpleDetalleNuevo");
	
	$('#CmpVehiculoMovimientoSalidaDetalleId').val("");
	
	$('#CmpVehiculoMovimientoSalidaDetalleId').val("");
	$('#CmpVehiculoMovimientoSalidaDetalleCantidad').val("1");
	$('#CmpVehiculoMovimientoSalidaDetalleCosto').val("");
	$('#CmpVehiculoMovimientoSalidaDetalleCostoIngreso').val("");
	$('#CmpVehiculoMovimientoSalidaDetalleImporte').val("");	
	$('#CmpVehiculoMovimientoSalidaDetalleEstado').val("3");
	$('#CmpVehiculoMovimientoSalidaDetalleObservacion').val("");
	
	$('#CmpVehiculoMovimientoSalidaSimpleDetalleUnidadMedida').val("");
	
	$('#CmpVehiculoId').val("");
	$('#CmpVehiculoCodigoIdentificador').val("");
	
	$('#CmpVehiculoItem').val("");	
			
	$('#CapVehiculoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVehiculoIngresoVIN').select();
			
	$('#CmpVehiculoMovimientoSalidaDetalleAccion').val("AccVehiculoMovimientoSalidaSimpleDetalleRegistrar.php");

	$('#CmpVehiculoIngresoVIN').removeAttr('readonly');
	
	FncVehiculoIngresoNuevo();
	
}

function FncVehiculoMovimientoSalidaSimpleDetalleGuardar(){
	
	console.log("FncVehiculoMovimientoSalidaSimpleDetalleGuardar");
	
	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpVehiculoMovimientoSalidaDetalleAccion').val();		
	
	var VehiculoIngresoId = $('#CmpVehiculoIngresoId').val();
	var VehiculoIngresoVIN = $('#CmpVehiculoIngresoVIN').val();
	var VehiculoId = $('#CmpVehiculoId').val();
	var VehiculoCodigoIdentificador = $('#CmpVehiculoCodigoIdentificador').val();
	
	var VehiculoIngresoMarca = $('#CmpVehiculoIngresoMarca').val();
	var VehiculoIngresoModelo = $('#CmpVehiculoIngresoModelo').val();
	var VehiculoIngresoVersion = $('#CmpVehiculoIngresoVersion').val();
	
	var VehiculoIngresoMarcaId = $('#CmpVehiculoIngresoMarcaId').val();
	var VehiculoIngresoModeloId = $('#CmpVehiculoIngresoModeloId').val();
	var VehiculoIngresoVersionId = $('#CmpVehiculoIngresoVersionId').val();
	
	var VehiculoIngresoColor = $('#CmpVehiculoIngresoColor').val();
	var VehiculoIngresoColorInterior = $('#CmpVehiculoIngresoColorInterior').val();
	var VehiculoIngresoAnoFabricacion = $('#CmpVehiculoIngresoAnoFabricacion').val();
	var VehiculoIngresoAnoModelo = $('#CmpVehiculoIngresoAnoModelo').val();
	
	var VehiculoMovimientoSalidaSimpleDetalleUnidadMedida = $('#CmpVehiculoMovimientoSalidaSimpleDetalleUnidadMedida').val();
	
	var VehiculoMovimientoSalidaDetalleCantidad = $('#CmpVehiculoMovimientoSalidaDetalleCantidad').val();
	var VehiculoMovimientoSalidaDetalleCosto = $('#CmpVehiculoMovimientoSalidaDetalleCosto').val();
	var VehiculoMovimientoSalidaDetalleCostoIngreso = $('#CmpVehiculoMovimientoSalidaDetalleCostoIngreso').val();
	var VehiculoMovimientoSalidaDetalleImporte = $('#CmpVehiculoMovimientoSalidaDetalleImporte').val();
	var VehiculoMovimientoSalidaDetalleEstado = $('#CmpVehiculoMovimientoSalidaDetalleEstado').val();
	var VehiculoMovimientoSalidaDetalleObservacion = $('#CmpVehiculoMovimientoSalidaDetalleObservacion').val();
	
	var VehiculoMovimientoSalidaDetalleId = $('#CmpVehiculoMovimientoSalidaDetalleId').val();
	
	var Item = $('#CmpVehiculoItem').val();
	
	var Accion = $('#CmpVehiculoMovimientoSalidaDetalleAccion').val();
	
	if(VehiculoIngresoId==""){
	
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No existe el VIN, verifique que se encuentra previamente registrado",
			callback: function(result){
				$('#CmpVehiculoIngresoVIN').select();	
			}
		});
		
		
	}else if(VehiculoIngresoVIN==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un VIN",
			callback: function(result){
				$('#CmpVehiculoIngresoVIN').select();	
			}
		});
				
	}else if(VehiculoMovimientoSalidaDetalleCantidad=="" || VehiculoMovimientoSalidaDetalleCantidad <=0){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar una cantidad",
			callback: function(result){
				$('#CmpVehiculoMovimientoSalidaDetalleCantidad').select();	
			}
		});
 	
	}else if(VehiculoMovimientoSalidaDetalleImporte==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un valor total referencial",
			callback: function(result){
				$('#CmpVehiculoMovimientoSalidaDetalleImporte').select();		
			}
		});
		
		
	}else if(VehiculoMovimientoSalidaSimpleDetalleUnidadMedida==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger una unidad de medida",
			callback: function(result){
				$('#CmpVehiculoMovimientoSalidaSimpleDetalleUnidadMedida').focus();		
			}
		});
				
	}else if(VehiculoCodigoIdentificador==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un codigo identificador unico de vehiculo",
			callback: function(result){
				$('#CmpVehiculoCodigoIdentificador').focus();		
			}
		});	
						
	}else{
		
		$('#CapVehiculoAccion').html('Guardando...');
		
				$.ajax({
					type: 'POST',
					url: 'formularios/VehiculoMovimientoSalidaSimple/acc/'+Acc,
					data: 'Identificador='+Identificador+
					'&VehiculoIngresoId='+VehiculoIngresoId+
					'&VehiculoId='+VehiculoId+
					
					'&VehiculoIngresoVIN='+VehiculoIngresoVIN+
					'&VehiculoCodigoIdentificador='+VehiculoCodigoIdentificador+
					
					'&VehiculoIngresoMarca='+VehiculoIngresoMarca+
					'&VehiculoIngresoModelo='+VehiculoIngresoModelo+
					'&VehiculoIngresoVersion='+VehiculoIngresoVersion+
					
					'&VehiculoIngresoMarcaId='+VehiculoIngresoMarcaId+
					'&VehiculoIngresoModeloId='+VehiculoIngresoModeloId+
					'&VehiculoIngresoVersionId='+VehiculoIngresoVersionId+
	
					'&VehiculoIngresoColor='+VehiculoIngresoColor+
					'&VehiculoIngresoColorInterior='+VehiculoIngresoColorInterior+
					'&VehiculoIngresoAnoFabricacion='+VehiculoIngresoAnoFabricacion+
					'&VehiculoIngresoAnoModelo='+VehiculoIngresoAnoModelo+
					
					'&VehiculoMovimientoSalidaDetalleCantidad='+VehiculoMovimientoSalidaDetalleCantidad+
					'&VehiculoMovimientoSalidaDetalleCosto='+VehiculoMovimientoSalidaDetalleCosto+
					'&VehiculoMovimientoSalidaDetalleCostoIngreso='+VehiculoMovimientoSalidaDetalleCostoIngreso+
					'&VehiculoMovimientoSalidaDetalleImporte='+VehiculoMovimientoSalidaDetalleImporte+
					'&VehiculoMovimientoSalidaDetalleEstado='+VehiculoMovimientoSalidaDetalleEstado+
					'&VehiculoMovimientoSalidaDetalleObservacion='+VehiculoMovimientoSalidaDetalleObservacion+
					'&VehiculoMovimientoSalidaSimpleDetalleUnidadMedida='+VehiculoMovimientoSalidaSimpleDetalleUnidadMedida+
			
					'&VehiculoMovimientoSalidaDetalleId='+VehiculoMovimientoSalidaDetalleId+
					'&Item='+Item,
					success: function(){
						console.log("Listo");
						$('#CapVehiculoAccion').html('Listo');							
						FncVehiculoMovimientoSalidaSimpleDetalleListar();
					}
					
				});
				
				FncVehiculoMovimientoSalidaSimpleDetalleNuevo();	
			
			
	}
	
}


function FncVehiculoMovimientoSalidaSimpleDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoAccion').html('Cargando...');
	
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	
	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoMovimientoSalidaSimple/FrmVehiculoMovimientoSalidaSimpleDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+VehiculoMovimientoSalidaDetalleEditar+
		'&Eliminar='+VehiculoMovimientoSalidaDetalleEliminar+
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVehiculoAccion').html('Listo');	
			$("#CapVehiculoMovimientoSalidaDetalles").html("");
			$("#CapVehiculoMovimientoSalidaDetalles").append(html);
			
		}
	});
	
}


function FncVehiculoMovimientoSalidaSimpleDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoAccion').html('Editando...');
	
	$('#CmpVehiculoMovimientoSalidaDetalleAccion').val("AccVehiculoMovimientoSalidaSimpleDetalleEditar.php");


//SesionObjeto-VehiculoMovimientoEntradaDetalle
//Parametro1 = VmdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = VmdCosto
//Parametro5 = VmdCantidad
//Parametro6 = VmdImporte
//Parametro7 = VmdTiempoCreacion
//Parametro8 = VmdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = VmdUtilidad
//Parametro14 = VmdUtilidadPorcentaje
//Parametro15 = VmdCostoAnterior
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = VmdEstado
//Parametro26 = VehCodigoIdentificador
//Parametro27 = UmeId
//Parametro28 = UmeNombre
//Parametro29 = VmdCostoIngreso

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoMovimientoSalidaSimple/acc/AccVehiculoMovimientoSalidaSimpleDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsVehiculoMovimientoSalidaDetalle){
			
				$('#CmpVehiculoId').val(InsVehiculoMovimientoSalidaDetalle.Parametro12);		
				$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoMovimientoSalidaDetalle.Parametro26);	
				
				$('#CmpVehiculoIngresoId').val(InsVehiculoMovimientoSalidaDetalle.Parametro2);	
				$('#CmpVehiculoIngresoVIN').val(InsVehiculoMovimientoSalidaDetalle.Parametro3);		
				
				$('#CmpVehiculoMovimientoSalidaDetalleCosto').val(InsVehiculoMovimientoSalidaDetalle.Parametro4);	
				$('#CmpVehiculoMovimientoSalidaDetalleCostoIngreso').val(InsVehiculoMovimientoSalidaDetalle.Parametro29);	
				$('#CmpVehiculoMovimientoSalidaDetalleCantidad').val(InsVehiculoMovimientoSalidaDetalle.Parametro5);	
				$('#CmpVehiculoMovimientoSalidaDetalleImporte').val(InsVehiculoMovimientoSalidaDetalle.Parametro6);
				$('#CmpVehiculoMovimientoSalidaDetalleObservacion').val(InsVehiculoMovimientoSalidaDetalle.Parametro16);
				$('#CmpVehiculoMovimientoSalidaSimpleDetalleUnidadMedida').val(InsVehiculoMovimientoSalidaDetalle.Parametro27);
				
				$('#CmpVehiculoIngresoVIN').val(InsVehiculoMovimientoSalidaDetalle.Parametro3);		
				$('#CmpVehiculoIngresoNumeroMotor').val(InsVehiculoMovimientoSalidaDetalle.Parametro9);		
				$('#CmpVehiculoIngresoAnoFabricacion').val(InsVehiculoMovimientoSalidaDetalle.Parametro10);		
				$('#CmpVehiculoIngresoAnoModelo').val(InsVehiculoMovimientoSalidaDetalle.Parametro11);		
				$('#CmpVehiculoIngresoColor').val(InsVehiculoMovimientoSalidaDetalle.Parametro17);		
				$('#CmpVehiculoIngresoColorInterior').val(InsVehiculoMovimientoSalidaDetalle.Parametro18);
				
				$('#CmpVehiculoIngresoMarca').val(InsVehiculoMovimientoSalidaDetalle.Parametro19);
				$('#CmpVehiculoIngresoModelo').val(InsVehiculoMovimientoSalidaDetalle.Parametro20);
				$('#CmpVehiculoIngresoVersion').val(InsVehiculoMovimientoSalidaDetalle.Parametro21);
				
				$('#CmpVehiculoIngresoMarcaId').val(InsVehiculoMovimientoSalidaDetalle.Parametro22);
				$('#CmpVehiculoIngresoModeloId').val(InsVehiculoMovimientoSalidaDetalle.Parametro23);
				$('#CmpVehiculoIngresoVersionId').val(InsVehiculoMovimientoSalidaDetalle.Parametro24);
				
				
				$('#CmpVehiculoMovimientoSalidaDetalleEstado').val(InsVehiculoMovimientoSalidaDetalle.Parametro25);

				$('#CmpVehiculoItem').val(InsVehiculoMovimientoSalidaDetalle.Item);

				$('#CmpVehiculoMovimientoSalidaDetalleImporte').select();
		}
	});
	
	$('#CmpVehiculoId').attr('readonly', true);
	$('#CmpVehiculoCodigoOriginal').attr('readonly', true);
	$('#CmpVehiculoCodigoAlternativo').attr('readonly', true);
	$('#CmpVehiculoNombre').attr('readonly', true);

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnVehiculoIngresoEditar").show();
	$("#BtnVehiculoIngresoRegistrar").hide();
	
		
}

function FncVehiculoMovimientoSalidaSimpleDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoSalidaSimple/acc/AccVehiculoMovimientoSalidaSimpleDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoAccion').html("Eliminado");	
				FncVehiculoMovimientoSalidaSimpleDetalleListar();
			}
		});
		
		FncVehiculoMovimientoSalidaSimpleDetalleNuevo();

	}
	
}



function FncVehiculoMovimientoSalidaSimpleDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoSalidaSimple/acc/AccVehiculoMovimientoSalidaSimpleDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoAccion').html('Eliminado');	
				FncVehiculoMovimientoSalidaSimpleDetalleListar();
			}
		});	
			
		FncVehiculoMovimientoSalidaSimpleDetalleNuevo();
	}
	
}


/*
* Funciones Detalle
*/

function FncVehiculoMovimientoSalidaSimpleDetalleCalcularCosto(){

	var Costo = 0;
	var Cantidad = $('#CmpVehiculoMovimientoSalidaDetalleCantidad').val();
	var Importe = $('#CmpVehiculoMovimientoSalidaDetalleImporte').val();	

	if(Cantidad!=""){
		if(Importe!=""){
			
			Costo = Importe/Cantidad;
			$('#CmpVehiculoMovimientoSalidaDetalleCosto').val(Costo);
			
		}else{
		
		}
	}else{
		
	}
	
}

function FncVehiculoMovimientoSalidaSimpleDetalleCalcularImporte(){

	var Costo = $('#CmpVehiculoMovimientoSalidaDetalleCosto').val();
	var Cantidad = $('#CmpVehiculoMovimientoSalidaDetalleCantidad').val();
	var Importe = 0;

	if(Cantidad!=""){
		if(Costo!=""){
			
			Importe = Costo * Cantidad;			
			$('#CmpVehiculoMovimientoSalidaDetalleImporte').val(Importe);
			
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpVehiculoMovimientoSalidaDetalleCantidad').value = 0.00;
	}
	
}
