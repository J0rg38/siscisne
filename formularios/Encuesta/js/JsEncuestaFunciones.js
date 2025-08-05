// JavaScript Document


function FncValidar(){

	var Fecha = $("#CmpFecha").val();

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

	
});



function FncEncuestaImprmir(oFichaIngresoId,oOrdenVentaVehiculo){
	
	FncPopUp('formularios/Encuesta/FrmEncuestaImprimir.php?FichaIngresoId='+oFichaIngresoId+'&oOrdenVentaVehiculo'+OrdenVentaVehiculo+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);


}

function FncEncuestaVistaPreliminar(oFichaIngresoId,oOrdenVentaVehiculo){
	
	FncPopUp('formularios/Encuesta/FrmEncuestaImprimir.php?FichaIngresoId='+oFichaIngresoId+'&oOrdenVentaVehiculo'+OrdenVentaVehiculo+'&P=2',0,0,1,0,0,1,0,screen.height,screen.width);


}


/*
* COMUNES
*/
function FncFichaIngresoFuncion(InsFichaIngreso){
	
	console.log("FncFichaIngresoFuncion");
	
	$('#CmpSucursal').val(InsFichaIngreso.SucId);	
	
	$('#CmpVehiculoIngresoVIN').val(InsFichaIngreso.EinVIN);
	$('#CmpVehiculoIngresoPlaca').val(InsFichaIngreso.EinPlaca);
	$('#CmpVehiculoMarca').val(InsFichaIngreso.VmaNombre);
	$('#CmpVehiculoModelo').val(InsFichaIngreso.VmoNombre);
	
	$('#CmpClienteNombre').val(InsFichaIngreso.CliNombre+ " " + InsFichaIngreso.CliApellidoPaterno + " " + InsFichaIngreso.CliApellidoMaterno);
	$('#CmpClienteId').val(InsFichaIngreso.CliId);
	
	FncEstablecerFichaIngresoAutocompletar();
	
}