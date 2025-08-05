// JavaScript Document


function FncValidar(){

	var Fecha = $("#CmpFecha").val();
	var OrdenVentaVehiculo = $("#CmpOrdenVentaVehiculo").val();
	var OrdenVentaVehiculoId = $("#CmpOrdenVentaVehiculoId").val();


	if(Fecha == ""){		
	
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar una fecha",
				callback: function(result){
					$("#CmpFecha").focus();
				}
			});
			
		return false;
	
	}else if(OrdenVentaVehiculo == ""){		
	
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar una orden de venta de vehiculo",
				callback: function(result){
					$("#CmpOrdenVentaVehiculo").focus();
				}
			});
			
		return false;
		
		}else if(OrdenVentaVehiculo != "" && OrdenVentaVehiculoId == ""){		
	
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado la orden correctamente, intente nuevamente",
				callback: function(result){
					$("#CmpOrdenVentaVehiculo").focus();
				}
			});
			
		return false;
	
	}else{
		return true;
	}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpTipo").removeAttr('disabled');		
		$("#CmpEstado").removeAttr('disabled');		
				$("#CmpSucursal").removeAttr('disabled');		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		$("#CmpTipo").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');	
				$("#CmpSucursal").removeAttr('disabled');		
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	//$('#CmpSucursal').on('change', function() {
//
//		FncEstablecerOrdenVentaAutocompletar();
//		
//
//	});


	
});



function FncEncuestaImprmir(oOrdenVentaVehiculoId,oOrdenVentaVehiculo){
	
	FncPopUp('formularios/Encuesta/FrmEncuestaImprimir.php?OrdenVentaVehiculoId='+oOrdenVentaVehiculoId+'&oOrdenVentaVehiculo'+OrdenVentaVehiculo+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);


}

function FncEncuestaVistaPreliminar(oOrdenVentaVehiculoId,oOrdenVentaVehiculo){
	
	FncPopUp('formularios/Encuesta/FrmEncuestaImprimir.php?OrdenVentaVehiculoId='+oOrdenVentaVehiculoId+'&oOrdenVentaVehiculo'+OrdenVentaVehiculo+'&P=2',0,0,1,0,0,1,0,screen.height,screen.width);


}



/*
* COMUNES
*/

//FncOrdenVentaVehiculoFuncion(InsOrdenVentaVehiculo);
function FncOrdenVentaVehiculoFuncion(InsOrdenVentaVehiculo){

	console.log("FncOrdenVentaVehiculoFuncion");
	
	$('#CmpSucursal').val(InsOrdenVentaVehiculo.SucId);	
	
	
	$('#CmpVehiculoIngresoId').val(InsOrdenVentaVehiculo.EinId);
	$('#CmpVehiculoIngresoVIN').val(InsOrdenVentaVehiculo.EinVIN);
	$('#CmpVehiculoIngresoPlaca').val(InsOrdenVentaVehiculo.EinPlaca);
	$('#CmpVehiculoMarca').val(InsOrdenVentaVehiculo.VmaNombre);
	$('#CmpVehiculoModelo').val(InsOrdenVentaVehiculo.VmoNombre);
	
	$('#CmpClienteNombre').val(InsOrdenVentaVehiculo.CliNombre+ " " + InsOrdenVentaVehiculo.CliApellidoPaterno + " " + InsOrdenVentaVehiculo.CliApellidoMaterno);
	$('#CmpClienteId').val(InsOrdenVentaVehiculo.CliId);
	
	FncEstablecerOrdenVentaVehiculoAutocompletar();
	
}