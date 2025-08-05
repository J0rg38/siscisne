// JavaScript Document

function FncVehiculoMovimientoEntradaSimpleDetalleNuevo(){
	
	console.log("FncVehiculoMovimientoEntradaSimpleDetalleNuevo");
	
	$('#CmpVehiculoMovimientoEntradaSimpleDetalleId').val("");
	
	$('#CmpVehiculoMovimientoEntradaSimpleDetalleCantidad').val("");
	$('#CmpVehiculoMovimientoEntradaSimpleDetalleCosto').val("");
	$('#CmpVehiculoMovimientoEntradaSimpleDetalleImporte').val("");	
	$('#CmpVehiculoMovimientoEntradaSimpleDetalleEstado').val("3");
	
	$('#CmpVehiculoMovimientoEntradaSimpleDetalleUnidadMedida').val("");

	$('#CmpVehiculoId').val("");
	$('#CmpVehiculoCodigoIdentificador').val("");
	
	$('#CmpVehiculoItem').val("");	
			
	$('#CapVehiculoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVehiculoIngresoVIN').select();
			
	$('#CmpVehiculoMovimientoEntradaSimpleDetalleAccion').val("AccVehiculoMovimientoEntradaSimpleDetalleRegistrar.php");

	$('#CmpVehiculoIngresoVIN').removeAttr('readonly');
	
	FncVehiculoIngresoNuevo();
	
}

function FncVehiculoMovimientoEntradaSimpleDetalleGuardar(){
	
	console.log("FncVehiculoMovimientoEntradaSimpleDetalleGuardar");
	
	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpVehiculoMovimientoEntradaSimpleDetalleAccion').val();		
	
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
	
	
	var VehiculoMovimientoEntradaSimpleDetalleUnidadMedida = $('#CmpVehiculoMovimientoEntradaSimpleDetalleUnidadMedida').val();
	
	var VehiculoMovimientoEntradaSimpleDetalleCantidad = $('#CmpVehiculoMovimientoEntradaSimpleDetalleCantidad').val();
	var VehiculoMovimientoEntradaSimpleDetalleCosto = $('#CmpVehiculoMovimientoEntradaSimpleDetalleCosto').val();
	var VehiculoMovimientoEntradaSimpleDetalleCostoIngreso = $('#CmpVehiculoMovimientoEntradaSimpleDetalleCostoIngreso').val();
	var VehiculoMovimientoEntradaSimpleDetalleImporte = $('#CmpVehiculoMovimientoEntradaSimpleDetalleImporte').val();
	var VehiculoMovimientoEntradaSimpleDetalleEstado = $('#CmpVehiculoMovimientoEntradaSimpleDetalleEstado').val();
	
	var VehiculoMovimientoEntradaSimpleDetalleId = $('#CmpVehiculoMovimientoEntradaSimpleDetalleId').val();
	
	var Item = $('#CmpVehiculoItem').val();
	
	var Accion = $('#CmpVehiculoMovimientoEntradaSimpleDetalleAccion').val();
	
	if(VehiculoIngresoId==""){
		
	//	alert("No existe el VIN");
		//FncVehiculoIngresoCargarFormulario("Registrar");
		
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
	
	}else if(VehiculoMovimientoEntradaSimpleDetalleCantidad=="" || VehiculoMovimientoEntradaSimpleDetalleCantidad <=0){
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una cantidad",
					callback: function(result){
						$('#CmpVehiculoMovimientoEntradaSimpleDetalleCantidad').focus();	
					}
				});
				
	}else if(VehiculoMovimientoEntradaSimpleDetalleCosto==""){
		
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un valor unitario",
					callback: function(result){
						$('#CmpVehiculoMovimientoEntradaSimpleDetalleCosto').focus();
					}
				});
				
	}else if(VehiculoMovimientoEntradaSimpleDetalleImporte==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un valor total",
			callback: function(result){
				$('#CmpVehiculoMovimientoEntradaSimpleDetalleImporte').focus();		
			}
		});
		
}else if(VehiculoMovimientoEntradaSimpleDetalleUnidadMedida==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger una unidad de medida",
			callback: function(result){
				$('#CmpVehiculoMovimientoEntradaSimpleDetalleUnidadMedida').focus();		
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
					url: 'formularios/VehiculoMovimientoEntradaSimple/acc/'+Acc,
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
					
					'&VehiculoMovimientoEntradaSimpleDetalleCantidad='+VehiculoMovimientoEntradaSimpleDetalleCantidad+
					'&VehiculoMovimientoEntradaSimpleDetalleCosto='+VehiculoMovimientoEntradaSimpleDetalleCosto+
					'&VehiculoMovimientoEntradaSimpleDetalleCostoIngreso='+VehiculoMovimientoEntradaSimpleDetalleCostoIngreso+
					'&VehiculoMovimientoEntradaSimpleDetalleImporte='+VehiculoMovimientoEntradaSimpleDetalleImporte+
					'&VehiculoMovimientoEntradaSimpleDetalleEstado='+VehiculoMovimientoEntradaSimpleDetalleEstado+
					'&VehiculoMovimientoEntradaSimpleDetalleUnidadMedida='+VehiculoMovimientoEntradaSimpleDetalleUnidadMedida+
			
					'&VehiculoMovimientoEntradaSimpleDetalleId='+VehiculoMovimientoEntradaSimpleDetalleId+
					'&Item='+Item,
					success: function(){
						console.log("Listo");
						$('#CapVehiculoAccion').html('Listo');							
						FncVehiculoMovimientoEntradaSimpleDetalleListar();
					}
					
				});
				
				FncVehiculoMovimientoEntradaSimpleDetalleNuevo();	
			
			
	}
	
}


function FncVehiculoMovimientoEntradaSimpleDetalleListar(){

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
		url: 'formularios/VehiculoMovimientoEntradaSimple/FrmVehiculoMovimientoEntradaSimpleDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+VehiculoMovimientoEntradaSimpleDetalleEditar+
		'&Eliminar='+VehiculoMovimientoEntradaSimpleDetalleEliminar+
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVehiculoAccion').html('Listo');	
			$("#CapVehiculoMovimientoEntradaSimpleDetalles").html("");
			$("#CapVehiculoMovimientoEntradaSimpleDetalles").append(html);
			
		}
	});
	
}


function FncVehiculoMovimientoEntradaSimpleDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoAccion').html('Editando...');
	
	$('#CmpVehiculoMovimientoEntradaSimpleDetalleAccion').val("AccVehiculoMovimientoEntradaSimpleDetalleEditar.php");


//SesionObjeto-VehiculoMovimientoEntradaSimpleDetalle
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

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoMovimientoEntradaSimple/acc/AccVehiculoMovimientoEntradaSimpleDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsVehiculoMovimientoEntradaSimpleDetalle){
			
				$('#CmpVehiculoId').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro12);		
				$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro26);	
				
				$('#CmpVehiculoIngresoId').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro2);	
				$('#CmpVehiculoIngresoVIN').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro3);		
				
				$('#CmpVehiculoMovimientoEntradaSimpleDetalleCosto').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro4);	
				$('#CmpVehiculoMovimientoEntradaSimpleDetalleCantidad').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro5);	
				$('#CmpVehiculoMovimientoEntradaSimpleDetalleImporte').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro6);
				$('#CmpVehiculoMovimientoEntradaSimpleDetalleUnidadMedida').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro27);
				

				$('#CmpVehiculoIngresoVIN').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro3);		
				$('#CmpVehiculoIngresoNumeroMotor').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro9);		
				$('#CmpVehiculoIngresoAnoFabricacion').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro10);		
				$('#CmpVehiculoIngresoAnoModelo').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro11);		
				$('#CmpVehiculoIngresoColor').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro17);		
				$('#CmpVehiculoIngresoColorInterior').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro18);
				
				$('#CmpVehiculoIngresoMarca').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro19);
				$('#CmpVehiculoIngresoModelo').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro20);
				$('#CmpVehiculoIngresoVersion').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro21);
				
				$('#CmpVehiculoIngresoMarcaId').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro22);
				$('#CmpVehiculoIngresoModeloId').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro23);
				$('#CmpVehiculoIngresoVersionId').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro24);
				
				
				$('#CmpVehiculoMovimientoEntradaSimpleDetalleEstado').val(InsVehiculoMovimientoEntradaSimpleDetalle.Parametro25);

				$('#CmpVehiculoItem').val(InsVehiculoMovimientoEntradaSimpleDetalle.Item);

				$('#CmpVehiculoMovimientoEntradaSimpleDetalleCantidad').select();
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

function FncVehiculoMovimientoEntradaSimpleDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoEntradaSimple/acc/AccVehiculoMovimientoEntradaSimpleDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoAccion').html("Eliminado");	
				FncVehiculoMovimientoEntradaSimpleDetalleListar();
			}
		});
		
		FncVehiculoMovimientoEntradaSimpleDetalleNuevo();

	}
	
}



function FncVehiculoMovimientoEntradaSimpleDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoEntradaSimple/acc/AccVehiculoMovimientoEntradaSimpleDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoAccion').html('Eliminado');	
				FncVehiculoMovimientoEntradaSimpleDetalleListar();
			}
		});	
			
		FncVehiculoMovimientoEntradaSimpleDetalleNuevo();
	}
	
}


/*
* Funciones Detalle
*/

function FncVehiculoMovimientoEntradaSimpleDetalleCalcularCosto(){

	var Costo = 0;
	var Cantidad = $('#CmpVehiculoMovimientoEntradaSimpleDetalleCantidad').val();
	var Importe = $('#CmpVehiculoMovimientoEntradaSimpleDetalleImporte').val();	

	if(Cantidad!=""){
		if(Importe!=""){
			
			Costo = Importe/Cantidad;
			$('#CmpVehiculoMovimientoEntradaSimpleDetalleCosto').val(Costo);
			
		}else{
		
		}
	}else{
		
	}
	
}

function FncVehiculoMovimientoEntradaSimpleDetalleCalcularImporte(){

	var Costo = $('#CmpVehiculoMovimientoEntradaSimpleDetalleCosto').val();
	var Cantidad = $('#CmpVehiculoMovimientoEntradaSimpleDetalleCantidad').val();
	var Importe = 0;

	if(Cantidad!=""){
		if(Costo!=""){
			
			Importe = Costo * Cantidad;			
			$('#CmpVehiculoMovimientoEntradaSimpleDetalleImporte').val(Importe);
			
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpVehiculoMovimientoEntradaSimpleDetalleCantidad').value = 0.00;
	}
	
}
