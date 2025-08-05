// JavaScript Document

function FncSolicitudDesembolsoDetalleNuevo(){
	
	$('#CmpServicioRepuestoId').val("");
	$('#CmpServicioRepuestoNombre').val("");
	
	$('#CmpSolicitudDesembolsoDetalleCantidad').val("");
	$('#CmpSolicitudDesembolsoDetalleImporte').val("");

	$('#CmpServicioRepuestoItem').val("");	
			
	$('#CapServicioRepuestoAccion').html('Listo para registrar elementos');	

	$('#CmpServicioRepuestoNombre').select();
			
	$('#CmpSolicitudDesembolsoDetalleAccion').val("AccSolicitudDesembolsoDetalleRegistrar.php");


	$('#CmpServicioRepuestoNombre').removeAttr('readonly');

	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnServicioRepuestoEditar").hide();
	$("#BtnServicioRepuestoRegistrar").show();
	
}

function FncSolicitudDesembolsoDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpSolicitudDesembolsoDetalleAccion').val();		
			
			
			var ServicioRepuestoId = $('#CmpServicioRepuestoId').val();
			var ServicioRepuestoNombre = $('#CmpServicioRepuestoNombre').val();
			var SolicitudDesembolsoDetalleImporte = $('#CmpSolicitudDesembolsoDetalleImporte').val();
			var SolicitudDesembolsoDetalleCantidad = $('#CmpSolicitudDesembolsoDetalleCantidad').val();
			
			var Item = $('#CmpServicioRepuestoItem').val();
			
			if(ServicioRepuestoId == ""){
				
				alert("No existe lo requerido");

				FncServicioRepuestoCargarFormulario("Registrar");
			
			}else if(ServicioRepuestoNombre==""){
				
				$('#CmpServicioRepuestoNombre').select();	
			
			}else{
				$('#CapServicioRepuestoAccion').html('Guardando...');
				
				$.ajax({
					type: 'POST',
					url: 'formularios/SolicitudDesembolso/acc/'+Acc,
					data: 'Identificador='+Identificador+
					'&ServicioRepuestoId='+ServicioRepuestoId+
					'&ServicioRepuestoNombre='+ServicioRepuestoNombre+
					'&SolicitudDesembolsoDetalleImporte='+SolicitudDesembolsoDetalleImporte+
					'&SolicitudDesembolsoDetalleCantidad='+SolicitudDesembolsoDetalleCantidad+
					'&Item='+Item,
					success: function(){
						
					$('#CapServicioRepuestoAccion').html('Listo');							
						FncSolicitudDesembolsoDetalleListar();
					}
				});
						
				FncSolicitudDesembolsoDetalleNuevo();	
					
		}
	
}

/*function FncSolicitudDesembolsoDetalleConfirmar(oItem){

	var Identificador = $('#Identificador').val();

	$('#CapServicioRepuestoAccion').html('Guardando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/SolicitudDesembolso/acc/AccSolicitudDesembolsoDetalleConfirmar.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(){

			$('#CapServicioRepuestoAccion').html('Listo');							
			//FncSolicitudDesembolsoDetalleListar();
		}

	});

}*/

function FncSolicitudDesembolsoDetalleListar(){

//console.log("FncSolicitudDesembolsoDetalleListar");
	var Identificador = $('#Identificador').val();
	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	
	$('#CapServicioRepuestoAccion').html('Cargando...');

	
	$('#CapSolicitudDesembolsoDetalles').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/SolicitudDesembolso/FrmSolicitudDesembolsoDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&MonedaId='+MonedaId+
		'&TipoCambio='+TipoCambio+
		'&Editar='+SolicitudDesembolsoDetalleEditar+
		'&Eliminar='+SolicitudDesembolsoDetalleEliminar ,
		success: function(html){
			
			$('#CapServicioRepuestoAccion').html('Listo');	
			$("#CapSolicitudDesembolsoDetalles").html("");
			$("#CapSolicitudDesembolsoDetalles").append(html);
				
		}
	});
	
}

function FncSolicitudDesembolsoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	var Redondear = $("#CmpRedondear").attr('checked', true);		
	
	$('#CapServicioRepuestoAccion').html('Editando...');
	$('#CmpSolicitudDesembolsoDetalleAccion').val("AccSolicitudDesembolsoDetalleEditar.php");
	
	var ClienteMargenUtilidad = $("#CmpClienteMargenUtilidad").val();
	var Flete = $("#CmpPorcentajeOtroCosto").val();
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/SolicitudDesembolso/acc/AccSolicitudDesembolsoDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsSolicitudDesembolsoDetalle){

		//	SesionObjeto-SolicitudDesembolsoDetalle
		//	Parametro1 = SddId
		//	Parametro2 = SdsId
		//	Parametro3 = SreId
		//	Parametro4 = SddDescripcion
		//	Parametro5 = SddCantidad
		//	Parametro6 = SddImporte
		//	Parametro7 = SddTiempoCreacion
		//	Parametro8 = SddTiempoModificacion
		//	Parametro9 = SddEstado
		//	Parametro10 = SreNombre
		//	Parametro11 = SdeCosto

			$('#CmpServicioRepuestoId').val(InsSolicitudDesembolsoDetalle.Parametro3);	
			$('#CmpServicioRepuestoNombre').val(InsSolicitudDesembolsoDetalle.Parametro10);
			$('#CmpSolicitudDesembolsoDetalleImporte').val(InsSolicitudDesembolsoDetalle.Parametro6);
			$('#CmpSolicitudDesembolsoDetalleCantidad').val(InsSolicitudDesembolsoDetalle.Parametro5);
			
			$('#CmpServicioRepuestoItem').val(InsSolicitudDesembolsoDetalle.Item);

			$('#CmpServicioRepuestoNombre').select();
		}
	});

	$('#CmpServicioRepuestoId').attr('readonly', true);
	$('#CmpServicioRepuestoNombre').attr('readonly', true);

	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnServicioRepuestoEditar").show();
	$("#BtnServicioRepuestoRegistrar").hide();
	
}

function FncSolicitudDesembolsoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapServicioRepuestoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/SolicitudDesembolso/acc/AccSolicitudDesembolsoDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapServicioRepuestoAccion').html("Eliminado");	
				FncSolicitudDesembolsoDetalleListar();
			}
		});

		FncSolicitudDesembolsoDetalleNuevo("");	

	}
	
}


function FncSolicitudDesembolsoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapServicioRepuestoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/SolicitudDesembolso/acc/AccSolicitudDesembolsoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapServicioRepuestoAccion').html('Eliminado');	
				FncSolicitudDesembolsoDetalleListar();
			}
		});	
			
		FncSolicitudDesembolsoDetalleNuevo("");	
	}
	
}
