// JavaScript Document

function FncPagoVehiculoIngresoDetalleNuevo(){
	
	console.log("FncPagoVehiculoIngresoDetalleNuevo");
	
	$('#CmpPagoVehiculoIngresoDetalleId').val("");
	
	$('#CmpPagoVehiculoIngresoDetalleObservacion').val("");
	
	$('#CmpPagoVehiculoIngresoDetalleCantidad').val("");
	$('#CmpPagoVehiculoIngresoDetalleCosto').val("");
	$('#CmpPagoVehiculoIngresoDetalleImporte').val("");	
	
	$('#CmpPagoVehiculoIngresoDetalleEstado').val("3");
	
	$('#CmpVehiculoId').val("");
	$('#CmpVehiculoCodigoIdentificador').val("");
	
	$('#CmpVehiculoItem').val("");	
			
	$('#CapVehiculoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVehiculoIngresoVIN').select();
			
	$('#CmpPagoVehiculoIngresoDetalleAccion').val("AccPagoVehiculoIngresoDetalleRegistrar.php");

	$('#CmpVehiculoIngresoVIN').removeAttr('readonly');
	
	FncVehiculoIngresoNuevo();
	
}

function FncPagoVehiculoIngresoDetalleGuardar(){
	
	console.log("FncPagoVehiculoIngresoDetalleGuardar");
	
	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpPagoVehiculoIngresoDetalleAccion').val();		
	
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
	
	var PagoVehiculoIngresoDetalleEstado = $('#CmpPagoVehiculoIngresoDetalleEstado').val();
	var PagoVehiculoIngresoDetalleObservacion = $('#CmpPagoVehiculoIngresoDetalleObservacion').val();
	
	var PagoVehiculoIngresoDetalleId = $('#CmpPagoVehiculoIngresoDetalleId').val();
	
	var Item = $('#CmpVehiculoItem').val();
	
	var Accion = $('#CmpPagoVehiculoIngresoDetalleAccion').val();
	
	if(VehiculoIngresoId==""){
		
		
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No se ha ingresado correctamente el VIN",
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
						$('#CmpVehiculoIngresoVIN').focus();	
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
					url: 'formularios/PagoVehiculoIngreso/acc/'+Acc,
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

					'&PagoVehiculoIngresoDetalleEstado='+PagoVehiculoIngresoDetalleEstado+
					'&PagoVehiculoIngresoDetalleObservacion='+PagoVehiculoIngresoDetalleObservacion+

					'&PagoVehiculoIngresoDetalleId='+PagoVehiculoIngresoDetalleId+
					'&Item='+Item,
					success: function(){
						console.log("Listo");
						$('#CapVehiculoAccion').html('Listo');							
						FncPagoVehiculoIngresoDetalleListar();
					}
					
				});
				
				FncPagoVehiculoIngresoDetalleNuevo();	
			
			
	}
	
}


function FncPagoVehiculoIngresoDetalleListar(){

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
		url: 'formularios/PagoVehiculoIngreso/FrmPagoVehiculoIngresoDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+PagoVehiculoIngresoDetalleEditar+
		'&Eliminar='+PagoVehiculoIngresoDetalleEliminar+
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVehiculoAccion').html('Listo');	
			$("#CapPagoVehiculoIngresoDetalles").html("");
			$("#CapPagoVehiculoIngresoDetalles").append(html);
			
		}
	});
	
}


function FncPagoVehiculoIngresoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoAccion').html('Editando...');
	
	$('#CmpPagoVehiculoIngresoDetalleAccion').val("AccPagoVehiculoIngresoDetalleEditar.php");


//SesionObjeto-PagoVehiculoIngresoDetalle
//Parametro1 = PvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = PvdCosto
//Parametro5 = PvdCantidad
//Parametro6 = PvdImporte
//Parametro7 = PvdTiempoCreacion
//Parametro8 = PvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = PvdUtilidad
//Parametro14 = PvdUtilidadPorcentaje
//Parametro15 = PvdCostoAnterior
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = PvdEstado
//Parametro26 = VehCodigoIdentificador
//Parametro27 = UmeId
//Parametro28 = UmeNombre

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PagoVehiculoIngreso/acc/AccPagoVehiculoIngresoDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsPagoVehiculoIngresoDetalle){
			
				$('#CmpVehiculoId').val(InsPagoVehiculoIngresoDetalle.Parametro12);		
				$('#CmpVehiculoCodigoIdentificador').val(InsPagoVehiculoIngresoDetalle.Parametro26);	
				
				$('#CmpVehiculoIngresoId').val(InsPagoVehiculoIngresoDetalle.Parametro2);	
				$('#CmpVehiculoIngresoVIN').val(InsPagoVehiculoIngresoDetalle.Parametro3);		
				
				$('#CmpVehiculoIngresoVIN').val(InsPagoVehiculoIngresoDetalle.Parametro3);		
				$('#CmpVehiculoIngresoNumeroMotor').val(InsPagoVehiculoIngresoDetalle.Parametro9);		
				$('#CmpVehiculoIngresoAnoFabricacion').val(InsPagoVehiculoIngresoDetalle.Parametro10);		
				$('#CmpVehiculoIngresoAnoModelo').val(InsPagoVehiculoIngresoDetalle.Parametro11);		
				$('#CmpVehiculoIngresoColor').val(InsPagoVehiculoIngresoDetalle.Parametro17);		
				$('#CmpVehiculoIngresoColorInterior').val(InsPagoVehiculoIngresoDetalle.Parametro18);
				
				$('#CmpVehiculoIngresoMarca').val(InsPagoVehiculoIngresoDetalle.Parametro19);
				$('#CmpVehiculoIngresoModelo').val(InsPagoVehiculoIngresoDetalle.Parametro20);
				$('#CmpVehiculoIngresoVersion').val(InsPagoVehiculoIngresoDetalle.Parametro21);
				
				$('#CmpVehiculoIngresoMarcaId').val(InsPagoVehiculoIngresoDetalle.Parametro22);
				$('#CmpVehiculoIngresoModeloId').val(InsPagoVehiculoIngresoDetalle.Parametro23);
				$('#CmpVehiculoIngresoVersionId').val(InsPagoVehiculoIngresoDetalle.Parametro24);
				
				$('#CmpPagoVehiculoIngresoDetalleEstado').val(InsPagoVehiculoIngresoDetalle.Parametro25);

				$('#CmpVehiculoItem').val(InsPagoVehiculoIngresoDetalle.Item);

				$('#CmpPagoVehiculoIngresoDetalleCantidad').select();
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

function FncPagoVehiculoIngresoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PagoVehiculoIngreso/acc/AccPagoVehiculoIngresoDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoAccion').html("Eliminado");	
				FncPagoVehiculoIngresoDetalleListar();
			}
		});
		
		FncPagoVehiculoIngresoDetalleNuevo();

	}
	
}



function FncPagoVehiculoIngresoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PagoVehiculoIngreso/acc/AccPagoVehiculoIngresoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoAccion').html('Eliminado');	
				FncPagoVehiculoIngresoDetalleListar();
			}
		});	
			
		FncPagoVehiculoIngresoDetalleNuevo();
	}
	
}


/*
* Funciones Detalle
*/

