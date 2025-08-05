


/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Funciones complementarias
*/
$().ready(function() {



	$('#BtnDescargarReporteComprobanteVenta').on('click', function() {
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		

		var Tipo = prompt("Escoja la tarea a realizar \n 1 = Todos los comprobantes \n 2 = Solo con abono completo", "2");			
		
		if(Tipo !== null){
			switch(Tipo.toUpperCase()){
				
				case "1":
				
					FncPopUp("formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoGenerarComprobanteVentasPDF.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=2&C=1");
				
				break;
				
					case "2":
				
					FncPopUp("formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoGenerarComprobanteVentasPDF.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=2&C=2");
				
				break;
				
	
				default:
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"No escogio una tarea",
							callback: function(result){
							
							}
						});
				break;
			
			}
			
		}



		
		return true;

	});


});


