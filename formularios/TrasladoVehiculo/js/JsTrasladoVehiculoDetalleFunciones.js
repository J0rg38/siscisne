// JavaScript Document

function FncTrasladoVehiculoDetalleNuevo(){
	
	console.log("FncTrasladoVehiculoDetalleNuevo");
	
	$('#CmpTrasladoVehiculoDetalleId').val("");
	
	$('#CmpVehiculoCodigoIdentificador').val("");
	$('#CmpTrasladoVehiculoDetalleId').val("");
	$('#CmpTrasladoVehiculoDetalleCantidad').val("1");
	$('#CmpTrasladoVehiculoDetalleObservacion').val("");
	
	$('#CmpTrasladoVehiculoDetalleCosto').val("");
	$('#CmpTrasladoVehiculoDetalleImporte').val("");	
	$('#CmpTrasladoVehiculoDetalleEstado').val("3");

	
	$('#CmpVehiculoItem').val("");	
			
	$('#CapVehiculoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVehiculoIngresoVIN').select();
			
	$('#CmpTrasladoVehiculoDetalleAccion').val("AccTrasladoVehiculoDetalleRegistrar.php");

	$('#CmpVehiculoIngresoVIN').removeAttr('readonly');
	
	FncVehiculoIngresoNuevo();
	
}

function FncTrasladoVehiculoDetalleGuardar(){
	
	console.log("FncTrasladoVehiculoDetalleGuardar");
	
	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpTrasladoVehiculoDetalleAccion').val();		
	
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
	
	var TrasladoVehiculoDetalleCantidad = $('#CmpTrasladoVehiculoDetalleCantidad').val();
	var TrasladoVehiculoDetalleCosto = $('#CmpTrasladoVehiculoDetalleCosto').val();
	var TrasladoVehiculoDetalleImporte = $('#CmpTrasladoVehiculoDetalleImporte').val();
	
	var TrasladoVehiculoDetalleObservacion = $('#CmpTrasladoVehiculoDetalleObservacion').val();
	var TrasladoVehiculoDetalleEstado = $('#CmpTrasladoVehiculoDetalleEstado').val();
	
	var TrasladoVehiculoDetalleId = $('#CmpTrasladoVehiculoDetalleId').val();
	
	var Item = $('#CmpVehiculoItem').val();
	
	var Accion = $('#CmpTrasladoVehiculoDetalleAccion').val();
	
	if(VehiculoIngresoId==""){
		
		alert("No existe el VIN");
		//FncVehiculoIngresoCargarFormulario("Registrar");
		
	}else if(VehiculoIngresoVIN==""){
		
		$('#CmpVehiculoIngresoVIN').select();	
	
	}else if(TrasladoVehiculoDetalleCantidad=="" || TrasladoVehiculoDetalleCantidad <=0){
		
		$('#CmpTrasladoVehiculoDetalleCantidad').select();	
		
	}else if(TrasladoVehiculoDetalleCosto==""){
		
		$('#CmpTrasladoVehiculoDetalleCosto').select();
			
	}else if(TrasladoVehiculoDetalleImporte==""){
		
		$('#CmpTrasladoVehiculoDetalleImporte').select();		
						
	}else{
		
		$('#CapVehiculoAccion').html('Guardando...');
		
				$.ajax({
					type: 'POST',
					url: 'formularios/TrasladoVehiculo/acc/'+Acc,
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
					
					'&TrasladoVehiculoDetalleCantidad='+TrasladoVehiculoDetalleCantidad+
					'&TrasladoVehiculoDetalleCosto='+TrasladoVehiculoDetalleCosto+
					'&TrasladoVehiculoDetalleImporte='+TrasladoVehiculoDetalleImporte+
					'&TrasladoVehiculoDetalleEstado='+TrasladoVehiculoDetalleEstado+
					
					'&TrasladoVehiculoDetalleObservacion='+TrasladoVehiculoDetalleObservacion+
			
					'&TrasladoVehiculoDetalleId='+TrasladoVehiculoDetalleId+
					'&Item='+Item,
					success: function(){
						console.log("Listo");
						$('#CapVehiculoAccion').html('Listo');							
						FncTrasladoVehiculoDetalleListar();
					}
					
				});
				
				FncTrasladoVehiculoDetalleNuevo();	
			
			
	}
	
}


function FncTrasladoVehiculoDetalleListar(){

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
		url: 'formularios/TrasladoVehiculo/FrmTrasladoVehiculoDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+TrasladoVehiculoDetalleEditar+
		'&Eliminar='+TrasladoVehiculoDetalleEliminar+
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVehiculoAccion').html('Listo');	
			$("#CapTrasladoVehiculoDetalles").html("");
			$("#CapTrasladoVehiculoDetalles").append(html);
			
		}
	});
	
}


function FncTrasladoVehiculoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoAccion').html('Editando...');
	
	$('#CmpTrasladoVehiculoDetalleAccion').val("AccTrasladoVehiculoDetalleEditar.php");


//SesionObjeto-TrasladoVehiculoDetalle
//Parametro1 = TvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = TvdCosto
//Parametro5 = TvdCantidad
//Parametro6 = TvdImporte
//Parametro7 = TvdTiempoCreacion
//Parametro8 = TvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = TvdUtilidad
//Parametro14 = TvdUtilidadPorcentaje
//Parametro15 = TvdObservacion
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = TvdEstado
//Parametro26 = VehCodigoIdentificador

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TrasladoVehiculo/acc/AccTrasladoVehiculoDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsTrasladoVehiculoDetalle){
			
				$('#CmpVehiculoId').val(InsTrasladoVehiculoDetalle.Parametro12);		
				
				$('#CmpVehiculoIngresoId').val(InsTrasladoVehiculoDetalle.Parametro2);	
				$('#CmpVehiculoIngresoVIN').val(InsTrasladoVehiculoDetalle.Parametro3);		
				$('#CmpVehiculoCodigoIdentificador').val(InsTrasladoVehiculoDetalle.Parametro26);
				
				
				$('#CmpTrasladoVehiculoDetalleCosto').val(InsTrasladoVehiculoDetalle.Parametro4);	
				$('#CmpTrasladoVehiculoDetalleCantidad').val(InsTrasladoVehiculoDetalle.Parametro5);	
				$('#CmpTrasladoVehiculoDetalleImporte').val(InsTrasladoVehiculoDetalle.Parametro6);
				
				$('#CmpVehiculoIngresoVIN').val(InsTrasladoVehiculoDetalle.Parametro3);		
				$('#CmpVehiculoIngresoNumeroMotor').val(InsTrasladoVehiculoDetalle.Parametro9);		
				$('#CmpVehiculoIngresoAnoFabricacion').val(InsTrasladoVehiculoDetalle.Parametro10);		
				$('#CmpVehiculoIngresoAnoModelo').val(InsTrasladoVehiculoDetalle.Parametro11);		
				$('#CmpVehiculoIngresoColor').val(InsTrasladoVehiculoDetalle.Parametro17);		
				$('#CmpVehiculoIngresoColorInterior').val(InsTrasladoVehiculoDetalle.Parametro18);
				
				$('#CmpVehiculoIngresoMarca').val(InsTrasladoVehiculoDetalle.Parametro19);
				$('#CmpVehiculoIngresoModelo').val(InsTrasladoVehiculoDetalle.Parametro20);
				$('#CmpVehiculoIngresoVersion').val(InsTrasladoVehiculoDetalle.Parametro21);
				
				$('#CmpVehiculoIngresoMarcaId').val(InsTrasladoVehiculoDetalle.Parametro22);
				$('#CmpVehiculoIngresoModeloId').val(InsTrasladoVehiculoDetalle.Parametro23);
				$('#CmpVehiculoIngresoVersionId').val(InsTrasladoVehiculoDetalle.Parametro24);
				
				$('#CmpTrasladoVehiculoDetalleObservacion').val(InsTrasladoVehiculoDetalle.Parametro15);
						
				$('#CmpTrasladoVehiculoDetalleEstado').val(InsTrasladoVehiculoDetalle.Parametro25);

				$('#CmpVehiculoItem').val(InsTrasladoVehiculoDetalle.Item);

				//$('#CmpTrasladoVehiculoDetalleCantidad').select();
				
				//tb_show(this.title,'principal2.php?Mod=VehiculoIngreso&Form=Editar&Dia=1&Id='+InsTrasladoVehiculoDetalle.Parametro2+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
					
					
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

function FncTrasladoVehiculoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoVehiculo/acc/AccTrasladoVehiculoDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoAccion').html("Eliminado");	
				FncTrasladoVehiculoDetalleListar();
			}
		});
		
		FncTrasladoVehiculoDetalleNuevo();

	}
	
}



function FncTrasladoVehiculoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoVehiculo/acc/AccTrasladoVehiculoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoAccion').html('Eliminado');	
				FncTrasladoVehiculoDetalleListar();
			}
		});	
			
		FncTrasladoVehiculoDetalleNuevo();
	}
	
}


/*
* Funciones Detalle
*/

function FncTrasladoVehiculoDetalleCalcularCosto(){

	var Costo = 0;
	var Cantidad = $('#CmpTrasladoVehiculoDetalleCantidad').val();
	var Importe = $('#CmpTrasladoVehiculoDetalleImporte').val();	

	if(Cantidad!=""){
		if(Importe!=""){
			
			Costo = Importe/Cantidad;
			$('#CmpTrasladoVehiculoDetalleCosto').val(Costo);
			
		}else{
		
		}
	}else{
		
	}
	
}

function FncTrasladoVehiculoDetalleCalcularImporte(){

	var Costo = $('#CmpTrasladoVehiculoDetalleCosto').val();
	var Cantidad = $('#CmpTrasladoVehiculoDetalleCantidad').val();
	var Importe = 0;

	if(Cantidad!=""){
		if(Costo!=""){
			
			Importe = Costo * Cantidad;			
			$('#CmpTrasladoVehiculoDetalleImporte').val(Importe);
			
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpTrasladoVehiculoDetalleCantidad').value = 0.00;
	}
	
}
