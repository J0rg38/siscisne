/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Funciones complementarias
 */
$().ready(function () {
  $("#BtnDescargarLibroElectronicoRegistroVenta").on("click", function () {
    var Ano = $("#CmpAno").val();
    var Mes = $("#CmpMes").val();
    var Sucursal = $("#CmpSucursal").val();

    FncPopUp(
      "formularios/LibroElectronico/acc/AccLibroElectronicoGenerarRegistroVentaTXTv2.php?Ano=" +
        Ano +
        "&Mes=" +
        Mes +
        "&Sucursal=" +
        Sucursal +
        "&P=2&C=2"
    );

    return true;
  });

  $("#BtnVistaPreliminarLibroElectronicoRegistroVenta").on(
    "click",
    function () {
      var Ano = $("#CmpAno").val();
      var Mes = $("#CmpMes").val();
      var Sucursal = $("#CmpSucursal").val();

      FncPopUp(
        "formularios/LibroElectronico/acc/AccLibroElectronicoGenerarRegistroVentaVP.php?Ano=" +
          Ano +
          "&Mes=" +
          Mes +
          "&Sucursal=" +
          Sucursal +
          "&VP=1&P=2&C=2"
      );

      return true;
    }
  );

  $("#BtnDescargarLibroElectronicoInventarioPermanenteValorizado").on(
    "click",
    function () {
      var Ano = $("#CmpAnoInventario").val();
      var Mes = $("#CmpMesInventario").val();
      var Sucursal = $("#CmpSucursal").val();

      FncPopUp(
        "formularios/LibroElectronico/acc/AccLibroElectronicoGenerarInventarioPermanenteValorizadoTXTv2.php?Ano=" +
          Ano +
          "&Mes=" +
          Mes +
          "&Sucursal=" +
          Sucursal +
          "&P=2&C=2"
      );

      return true;
    }
  );

  $("#BtnVistaPreliminarLibroElectronicoInventarioPermanenteValorizado").on(
    "click",
    function () {
      var Ano = $("#CmpAnoInventario").val();
      var Mes = $("#CmpMesInventario").val();
      var Sucursal = $("#CmpSucursal").val();

      FncPopUp(
        "formularios/LibroElectronico/acc/AccLibroElectronicoGenerarInventarioPermanenteValorizadoVP.php?Ano=" +
          Ano +
          "&Mes=" +
          Mes +
          "&Sucursal=" +
          Sucursal +
          "&P=2&C=2"
      );

      return true;
    }
  );

  /*

	$('#BtnDescargarReporteVentaXLS').on('click', function() {
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		

		var Tipo = prompt("Escoja la tarea a realizar \n 1 = Todos los comprobantes \n 2 = Solo con abono completo", "2");			
		
		if(Tipo !== null){
			switch(Tipo.toUpperCase()){
				
				case "1":
				
					FncPopUp("formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoGenerarComprobanteVentasXLS.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=2&C=1");
				
				break;
				
					case "2":
				
					FncPopUp("formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoGenerarComprobanteVentasXLS.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=2&C=2");
				
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

	});*/
});
