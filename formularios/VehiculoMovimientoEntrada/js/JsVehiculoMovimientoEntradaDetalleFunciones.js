// JavaScript Document

function FncVehiculoMovimientoEntradaDetalleNuevo(){
	
	console.log("FncVehiculoMovimientoEntradaDetalleNuevo");
	

	
	$('#CmpVehiculoMovimientoEntradaDetalleId').val("");
	$('#CmpVehiculoMovimientoEntradaDetalleCantidad').val("");
	$('#CmpVehiculoMovimientoEntradaDetalleCosto').val("");
	$('#CmpVehiculoMovimientoEntradaDetalleImporte').val("");	
	$('#CmpVehiculoMovimientoEntradaDetalleEstado').val("3");
	
	$('#CmpVehiculoMovimientoEntradaDetalleUnidadMedida').val("");

	
	$('#CmpVehiculoId').val("");
	$('#CmpVehiculoCodigoIdentificador').val("");
	
	$('#CmpVehiculoItem').val("");	
			
	$('#CapVehiculoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVehiculoIngresoVIN').select();
			
	$('#CmpVehiculoMovimientoEntradaDetalleAccion').val("AccVehiculoMovimientoEntradaDetalleRegistrar.php");

	$('#CmpVehiculoIngresoVIN').removeAttr('readonly');
	
	FncVehiculoIngresoNuevo();
	
}

function FncVehiculoMovimientoEntradaDetalleGuardar(){
	
	console.log("FncVehiculoMovimientoEntradaDetalleGuardar");
	
	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpVehiculoMovimientoEntradaDetalleAccion').val();		
	
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
	
	
	var VehiculoMovimientoEntradaDetalleUnidadMedida = $('#CmpVehiculoMovimientoEntradaDetalleUnidadMedida').val();
	
	var VehiculoMovimientoEntradaDetalleCantidad = $('#CmpVehiculoMovimientoEntradaDetalleCantidad').val();
	var VehiculoMovimientoEntradaDetalleCosto = $('#CmpVehiculoMovimientoEntradaDetalleCosto').val();
	var VehiculoMovimientoEntradaDetalleImporte = $('#CmpVehiculoMovimientoEntradaDetalleImporte').val();
	var VehiculoMovimientoEntradaDetalleEstado = $('#CmpVehiculoMovimientoEntradaDetalleEstado').val();
	
	var VehiculoMovimientoEntradaDetalleId = $('#CmpVehiculoMovimientoEntradaDetalleId').val();
	
	var Item = $('#CmpVehiculoItem').val();
	
	var Accion = $('#CmpVehiculoMovimientoEntradaDetalleAccion').val();
	
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
	
	}else if(VehiculoMovimientoEntradaDetalleCantidad=="" || VehiculoMovimientoEntradaDetalleCantidad <=0){
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una cantidad",
					callback: function(result){
						$('#CmpVehiculoMovimientoEntradaDetalleCantidad').focus();	
					}
				});
				
	}else if(VehiculoMovimientoEntradaDetalleCosto==""){
		
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una cantidad",
					callback: function(result){
						$('#CmpVehiculoMovimientoEntradaDetalleCosto').focus();
					}
				});
				
	}else if(VehiculoMovimientoEntradaDetalleImporte==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un importe",
			callback: function(result){
				$('#CmpVehiculoMovimientoEntradaDetalleImporte').focus();		
			}
		});
		
}else if(VehiculoMovimientoEntradaDetalleUnidadMedida==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger una unidad de medida",
			callback: function(result){
				$('#CmpVehiculoMovimientoEntradaDetalleUnidadMedida').focus();		
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
					url: 'formularios/VehiculoMovimientoEntrada/acc/'+Acc,
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
					
					'&VehiculoMovimientoEntradaDetalleCantidad='+VehiculoMovimientoEntradaDetalleCantidad+
					'&VehiculoMovimientoEntradaDetalleCosto='+VehiculoMovimientoEntradaDetalleCosto+
					'&VehiculoMovimientoEntradaDetalleImporte='+VehiculoMovimientoEntradaDetalleImporte+
					'&VehiculoMovimientoEntradaDetalleEstado='+VehiculoMovimientoEntradaDetalleEstado+
					'&VehiculoMovimientoEntradaDetalleUnidadMedida='+VehiculoMovimientoEntradaDetalleUnidadMedida+
			
					'&VehiculoMovimientoEntradaDetalleId='+VehiculoMovimientoEntradaDetalleId+
					'&Item='+Item,
					success: function(){
						console.log("Listo");
						$('#CapVehiculoAccion').html('Listo');							
						FncVehiculoMovimientoEntradaDetalleListar();
					}
					
				});
				
				FncVehiculoMovimientoEntradaDetalleNuevo();	
			
			
	}
	
}


function FncVehiculoMovimientoEntradaDetalleListar(){

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
		url: 'formularios/VehiculoMovimientoEntrada/FrmVehiculoMovimientoEntradaDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+VehiculoMovimientoEntradaDetalleEditar+
		'&Eliminar='+VehiculoMovimientoEntradaDetalleEliminar+
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVehiculoAccion').html('Listo');	
			$("#CapVehiculoMovimientoEntradaDetalles").html("");
			$("#CapVehiculoMovimientoEntradaDetalles").append(html);
			
		}
	});
	
}


function FncVehiculoMovimientoEntradaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoAccion').html('Editando...');
	
	$('#CmpVehiculoMovimientoEntradaDetalleAccion').val("AccVehiculoMovimientoEntradaDetalleEditar.php");


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

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoMovimientoEntrada/acc/AccVehiculoMovimientoEntradaDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsVehiculoMovimientoEntradaDetalle){
			
				$('#CmpVehiculoId').val(InsVehiculoMovimientoEntradaDetalle.Parametro12);		
				$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoMovimientoEntradaDetalle.Parametro26);	
				
				$('#CmpVehiculoIngresoId').val(InsVehiculoMovimientoEntradaDetalle.Parametro2);	
				$('#CmpVehiculoIngresoVIN').val(InsVehiculoMovimientoEntradaDetalle.Parametro3);		
				
				$('#CmpVehiculoMovimientoEntradaDetalleCosto').val(InsVehiculoMovimientoEntradaDetalle.Parametro4);	
				$('#CmpVehiculoMovimientoEntradaDetalleCantidad').val(InsVehiculoMovimientoEntradaDetalle.Parametro5);	
				$('#CmpVehiculoMovimientoEntradaDetalleImporte').val(InsVehiculoMovimientoEntradaDetalle.Parametro6);
				$('#CmpVehiculoMovimientoEntradaDetalleUnidadMedida').val(InsVehiculoMovimientoEntradaDetalle.Parametro27);
				

				$('#CmpVehiculoIngresoVIN').val(InsVehiculoMovimientoEntradaDetalle.Parametro3);		
				$('#CmpVehiculoIngresoNumeroMotor').val(InsVehiculoMovimientoEntradaDetalle.Parametro9);		
				$('#CmpVehiculoIngresoAnoFabricacion').val(InsVehiculoMovimientoEntradaDetalle.Parametro10);		
				$('#CmpVehiculoIngresoAnoModelo').val(InsVehiculoMovimientoEntradaDetalle.Parametro11);		
				$('#CmpVehiculoIngresoColor').val(InsVehiculoMovimientoEntradaDetalle.Parametro17);		
				$('#CmpVehiculoIngresoColorInterior').val(InsVehiculoMovimientoEntradaDetalle.Parametro18);
				
				$('#CmpVehiculoIngresoMarca').val(InsVehiculoMovimientoEntradaDetalle.Parametro19);
				$('#CmpVehiculoIngresoModelo').val(InsVehiculoMovimientoEntradaDetalle.Parametro20);
				$('#CmpVehiculoIngresoVersion').val(InsVehiculoMovimientoEntradaDetalle.Parametro21);
				
				$('#CmpVehiculoIngresoMarcaId').val(InsVehiculoMovimientoEntradaDetalle.Parametro22);
				$('#CmpVehiculoIngresoModeloId').val(InsVehiculoMovimientoEntradaDetalle.Parametro23);
				$('#CmpVehiculoIngresoVersionId').val(InsVehiculoMovimientoEntradaDetalle.Parametro24);
				
						
				
				$('#CmpVehiculoMovimientoEntradaDetalleEstado').val(InsVehiculoMovimientoEntradaDetalle.Parametro25);

				$('#CmpVehiculoItem').val(InsVehiculoMovimientoEntradaDetalle.Item);

				$('#CmpVehiculoMovimientoEntradaDetalleCantidad').select();
		}
	});
	
	$('#CmpVehiculoId').attr('readonly', true);
	$('#CmpVehiculoCodigoOriginal').attr('readonly', true);
	$('#CmpVehiculoCodigoAlternativo').attr('readonly', true);
	$('#CmpVehiculoNombre').attr('readonly', true);

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnVehiculoEditar").show();
	$("#BtnVehiculoRegistrar").hide();
	
		
}

function FncVehiculoMovimientoEntradaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoEntrada/acc/AccVehiculoMovimientoEntradaDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoAccion').html("Eliminado");	
				FncVehiculoMovimientoEntradaDetalleListar();
			}
		});
		
		FncVehiculoMovimientoEntradaDetalleNuevo();

	}
	
}



function FncVehiculoMovimientoEntradaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoMovimientoEntrada/acc/AccVehiculoMovimientoEntradaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoAccion').html('Eliminado');	
				FncVehiculoMovimientoEntradaDetalleListar();
			}
		});	
			
		FncVehiculoMovimientoEntradaDetalleNuevo();
	}
	
}


/*
* Funciones Detalle
*/

function FncVehiculoMovimientoEntradaDetalleCalcularCosto(){

	var Costo = 0;
	var Cantidad = $('#CmpVehiculoMovimientoEntradaDetalleCantidad').val();
	var Importe = $('#CmpVehiculoMovimientoEntradaDetalleImporte').val();	

	if(Cantidad!=""){
		if(Importe!=""){
			
			Costo = Importe/Cantidad;
			$('#CmpVehiculoMovimientoEntradaDetalleCosto').val(Costo);
			
		}else{
		
		}
	}else{
		
	}
	
}

function FncVehiculoMovimientoEntradaDetalleCalcularImporte(){

	var Costo = $('#CmpVehiculoMovimientoEntradaDetalleCosto').val();
	var Cantidad = $('#CmpVehiculoMovimientoEntradaDetalleCantidad').val();
	var Importe = 0;

	if(Cantidad!=""){
		if(Costo!=""){
			
			Importe = Costo * Cantidad;			
			$('#CmpVehiculoMovimientoEntradaDetalleImporte').val(Importe);
			
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpVehiculoMovimientoEntradaDetalleCantidad').value = 0.00;
	}
	
}
