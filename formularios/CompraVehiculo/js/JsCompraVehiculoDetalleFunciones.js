// JavaScript Document

function FncCompraVehiculoDetalleNuevo(){
	
	console.log("FncCompraVehiculoDetalleNuevo");
	
	$('#CmpCompraVehiculoDetalleId').val("");
	
	$('#CmpCompraVehiculoDetalleId').val("");
	$('#CmpCompraVehiculoDetalleCantidad').val("");
	$('#CmpCompraVehiculoDetalleCosto').val("");
	$('#CmpCompraVehiculoDetalleImporte').val("");	
	$('#CmpCompraVehiculoDetalleEstado').val("3");

	
	$('#CmpVehiculoItem').val("");	
			
	$('#CapVehiculoAccion').html('Listo para registrar elementos');	
			
	$('#CmpVehiculoIngresoVIN').select();
			
	$('#CmpCompraVehiculoDetalleAccion').val("AccCompraVehiculoDetalleRegistrar.php");

	$('#CmpVehiculoIngresoVIN').removeAttr('readonly');
	
	FncVehiculoIngresoNuevo();
	
}

function FncCompraVehiculoDetalleGuardar(){
	
	console.log("FncCompraVehiculoDetalleGuardar");
	
	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpCompraVehiculoDetalleAccion').val();		
	
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
	
	var CompraVehiculoDetalleCantidad = $('#CmpCompraVehiculoDetalleCantidad').val();
	var CompraVehiculoDetalleCosto = $('#CmpCompraVehiculoDetalleCosto').val();
	var CompraVehiculoDetalleImporte = $('#CmpCompraVehiculoDetalleImporte').val();
	var CompraVehiculoDetalleEstado = $('#CmpCompraVehiculoDetalleEstado').val();
	
	var CompraVehiculoDetalleId = $('#CmpCompraVehiculoDetalleId').val();
	
	var Item = $('#CmpVehiculoItem').val();
	
	var Accion = $('#CmpCompraVehiculoDetalleAccion').val();
	
	if(VehiculoIngresoId==""){
		
		alert("No existe el VIN");
		//FncVehiculoIngresoCargarFormulario("Registrar");
		
	}else if(VehiculoIngresoVIN==""){
		
		$('#CmpVehiculoIngresoVIN').select();	
	
	}else if(CompraVehiculoDetalleCantidad=="" || CompraVehiculoDetalleCantidad <=0){
		
		$('#CmpCompraVehiculoDetalleCantidad').select();	
		
	}else if(CompraVehiculoDetalleCosto==""){
		
		$('#CmpCompraVehiculoDetalleCosto').select();
			
	}else if(CompraVehiculoDetalleImporte==""){
		
		$('#CmpCompraVehiculoDetalleImporte').select();		
						
	}else{
		
		$('#CapVehiculoAccion').html('Guardando...');
		
				$.ajax({
					type: 'POST',
					url: 'formularios/CompraVehiculo/acc/'+Acc,
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
					
					'&CompraVehiculoDetalleCantidad='+CompraVehiculoDetalleCantidad+
					'&CompraVehiculoDetalleCosto='+CompraVehiculoDetalleCosto+
					'&CompraVehiculoDetalleImporte='+CompraVehiculoDetalleImporte+
					'&CompraVehiculoDetalleEstado='+CompraVehiculoDetalleEstado+
			
					'&CompraVehiculoDetalleId='+CompraVehiculoDetalleId+
					'&Item='+Item,
					success: function(){
						console.log("Listo");
						$('#CapVehiculoAccion').html('Listo');							
						FncCompraVehiculoDetalleListar();
					}
					
				});
				
				FncCompraVehiculoDetalleNuevo();	
			
			
	}
	
}


function FncCompraVehiculoDetalleListar(){

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
		url: 'formularios/CompraVehiculo/FrmCompraVehiculoDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+CompraVehiculoDetalleEditar+
		'&Eliminar='+CompraVehiculoDetalleEliminar+
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVehiculoAccion').html('Listo');	
			$("#CapCompraVehiculoDetalles").html("");
			$("#CapCompraVehiculoDetalles").append(html);
			
		}
	});
	
}


function FncCompraVehiculoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoAccion').html('Editando...');
	
	$('#CmpCompraVehiculoDetalleAccion').val("AccCompraVehiculoDetalleEditar.php");


//SesionObjeto-CompraVehiculoDetalle
//Parametro1 = CvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = CvdCosto
//Parametro5 = CvdCantidad
//Parametro6 = CvdImporte
//Parametro7 = CvdTiempoCreacion
//Parametro8 = CvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = CvdUtilidad
//Parametro14 = CvdUtilidadPorcentaje
//Parametro15 = CvdCostoAnterior
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = CvdEstado

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/CompraVehiculo/acc/AccCompraVehiculoDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsCompraVehiculoDetalle){
			
				$('#CmpVehiculoId').val(InsCompraVehiculoDetalle.Parametro12);		
				
				$('#CmpVehiculoIngresoId').val(InsCompraVehiculoDetalle.Parametro2);	
				$('#CmpVehiculoIngresoVIN').val(InsCompraVehiculoDetalle.Parametro3);		
				
				$('#CmpCompraVehiculoDetalleCosto').val(InsCompraVehiculoDetalle.Parametro4);	
				$('#CmpCompraVehiculoDetalleCantidad').val(InsCompraVehiculoDetalle.Parametro5);	
				$('#CmpCompraVehiculoDetalleImporte').val(InsCompraVehiculoDetalle.Parametro6);
				
				$('#CmpVehiculoIngresoVIN').val(InsCompraVehiculoDetalle.Parametro3);		
				$('#CmpVehiculoIngresoNumeroMotor').val(InsCompraVehiculoDetalle.Parametro9);		
				$('#CmpVehiculoIngresoAnoFabricacion').val(InsCompraVehiculoDetalle.Parametro10);		
				$('#CmpVehiculoIngresoAnoModelo').val(InsCompraVehiculoDetalle.Parametro11);		
				$('#CmpVehiculoIngresoColor').val(InsCompraVehiculoDetalle.Parametro17);		
				$('#CmpVehiculoIngresoColorInterior').val(InsCompraVehiculoDetalle.Parametro18);
				
				$('#CmpVehiculoIngresoMarca').val(InsCompraVehiculoDetalle.Parametro19);
				$('#CmpVehiculoIngresoModelo').val(InsCompraVehiculoDetalle.Parametro20);
				$('#CmpVehiculoIngresoVersion').val(InsCompraVehiculoDetalle.Parametro21);
				
				$('#CmpVehiculoIngresoMarcaId').val(InsCompraVehiculoDetalle.Parametro22);
				$('#CmpVehiculoIngresoModeloId').val(InsCompraVehiculoDetalle.Parametro23);
				$('#CmpVehiculoIngresoVersionId').val(InsCompraVehiculoDetalle.Parametro24);
				
						
				
				$('#CmpCompraVehiculoDetalleEstado').val(InsCompraVehiculoDetalle.Parametro25);

				$('#CmpVehiculoItem').val(InsCompraVehiculoDetalle.Item);

				$('#CmpCompraVehiculoDetalleCantidad').select();
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

function FncCompraVehiculoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoAccion').html('Eliminando...');			
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CompraVehiculo/acc/AccCompraVehiculoDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoAccion').html("Eliminado");	
				FncCompraVehiculoDetalleListar();
			}
		});
		
		FncCompraVehiculoDetalleNuevo();

	}
	
}



function FncCompraVehiculoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CompraVehiculo/acc/AccCompraVehiculoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoAccion').html('Eliminado');	
				FncCompraVehiculoDetalleListar();
			}
		});	
			
		FncCompraVehiculoDetalleNuevo();
	}
	
}


/*
* Funciones Detalle
*/

function FncCompraVehiculoDetalleCalcularCosto(){

	var Costo = 0;
	var Cantidad = $('#CmpCompraVehiculoDetalleCantidad').val();
	var Importe = $('#CmpCompraVehiculoDetalleImporte').val();	

	if(Cantidad!=""){
		if(Importe!=""){
			
			Costo = Importe/Cantidad;
			$('#CmpCompraVehiculoDetalleCosto').val(Costo);
			
		}else{
		
		}
	}else{
		
	}
	
}

function FncCompraVehiculoDetalleCalcularImporte(){

	var Costo = $('#CmpCompraVehiculoDetalleCosto').val();
	var Cantidad = $('#CmpCompraVehiculoDetalleCantidad').val();
	var Importe = 0;

	if(Cantidad!=""){
		if(Costo!=""){
			
			Importe = Costo * Cantidad;			
			$('#CmpCompraVehiculoDetalleImporte').val(Importe);
			
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpCompraVehiculoDetalleCantidad').value = 0.00;
	}
	
}
