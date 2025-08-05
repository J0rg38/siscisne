


/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Funciones complementarias
*/
$().ready(function() {


 
	
	
	
	

	$('#BtnDescargarBaseDatosCotizacionVehiculoXLS').on('click', function() {
		
		var FechaInicio = $("#CmpFechaInicio2").val();
		var FechaFin = $("#CmpFechaFin2").val();
		var Sucursal = $("#CmpSucursal2").val();
		
		var Tipo = prompt("Escoja la tarea a realizar \n 1 = Todas las Sucursales \n 2 = Sucursal Actual", "1");			
		
		if(Tipo !== null){
			switch(Tipo.toUpperCase()){
				
				case "1":
				
					FncPopUp("formularios/InformeMarketing/acc/AccInformeMarketingGenerarBaseDatosCotizacionVehiculoXLS.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal=&P=2&C=1");
				
				break;
				
					case "2":
				
					FncPopUp("formularios/InformeMarketing/acc/AccInformeMarketingGenerarBaseDatosCotizacionVehiculoXLS.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=2&C=2");
				
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
	
	

	$('#BtnDescargarBaseDatosOrdenVentaVehiculoXLS').on('click', function() {
		
		var FechaInicio = $("#CmpFechaInicio3").val();
		var FechaFin = $("#CmpFechaFin3").val();
		var Sucursal = $("#CmpSucursal3").val();
		
		var Tipo = prompt("Escoja la tarea a realizar \n 1 = Todas las Sucursales \n 2 = Sucursal Actual", "1");			
		
		if(Tipo !== null){
			switch(Tipo.toUpperCase()){
				
				case "1":
				
					FncPopUp("formularios/InformeMarketing/acc/AccInformeMarketingGenerarBaseDatosOrdenVentaVehiculoXLS.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal=&P=2&C=1");
				
				break;
				
					case "2":
				
					FncPopUp("formularios/InformeMarketing/acc/AccInformeMarketingGenerarBaseDatosOrdenVentaVehiculoXLS.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=2&C=2");
				
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


