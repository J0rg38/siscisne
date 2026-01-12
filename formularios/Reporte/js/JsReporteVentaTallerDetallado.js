var Variables = "";

var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";

var VehiculoMarca = "";
var VehiculoModelo = "";
var TipoReporte = "";

var Orden = "";
var Sentido = "";

function FncObtenerVariables() {
  FechaInicio = $("#CmpFechaInicio").val();
  FechaFin = $("#CmpFechaFin").val();
  Sucursal = $("#CmpSucursal").val();

  VehiculoMarca = $("#CmpVehiculoMarca").val();
  VehiculoModelo = $("#CmpVehiculoModelo").val();
  TipoReporte = $("#CmpTipoReporte").val();

  Orden = $("#CmpOrden").val();
  Sentido = $("#CmpSentido").val();

  Variables =
    "CmpFechaInicio=" +
    FechaInicio +
    "&CmpFechaFin=" +
    FechaFin +
    "&CmpSucursal=" +
    Sucursal +
    "&CmpVehiculoMarca=" +
    VehiculoMarca +
    "&CmpVehiculoModelo=" +
    VehiculoModelo +
    "&CmpTipoReporte=" +
    TipoReporte +
    "&CmpOrden=" +
    Orden +
    "&CmpSentido=" +
    Sentido;

  return Variables;
}

// JavaScript Document
function FncValidar() {
  var respuesta = true;

  FncObtenerVariables();

  if (FechaInicio == "") {
    alert("No ha escogido una fecha de inicio.");
    respuesta = false;
  } else if (FechaFin == "") {
    alert("No ha escogido una fecha fin.");
    respuesta = false;
  }

  return respuesta;
}

$().ready(function () {
  $("#BtnVer").on("click", function () {
    if (FncValidar()) {
      FncReporteVentaTallerDetalladoVer("");
    }
  });

  $("#BtnImprimir").on("click", function () {
    if (FncValidar()) {
      FncReporteVentaTallerDetalladoImprimir("");
    }
  });

  $("#BtnExcel").on("click", function () {
    if (FncValidar()) {
      FncReporteVentaTallerDetalladoGenerarExcel("");
    }
  });

  //var Ancho = $( document ).width();
  var Ancho = $(window).width();
  Ancho = Ancho - Ancho * 0.08;
  $(".EstReporteCapaListado").width(Ancho);

  //
});

function FncReporteVentaTallerDetalladoVer() {
  if (FncValidar()) {
    $("#CapReporteVentaTallerDetallado").html("Cargando...");

    $.ajax({
      type: "GET",
      url: "formularios/Reporte/IfrReporteVentaTallerDetallado.php",
      data: FncObtenerVariables(),
      success: function (html) {
        $("#CapReporteVentaTallerDetallado").html(html);
      },
    });
  }
}

function FncReporteVentaTallerDetalladoImprimir() {
  if (FncValidar()) {
    FncPopUp(
      "formularios/Reporte/IfrReporteVentaTallerDetallado.php?" +
        FncObtenerVariables() +
        "&P=1"
    );
  }
}

function FncReporteVentaTallerDetalladoGenerarExcel() {
  if (FncValidar()) {
    FncPopUp(
      "formularios/Reporte/XLSReporteVentaTallerDetallado.php?" +
        FncObtenerVariables() +
        "&P=2"
    );
  }
}

function FncReporteVentaTallerDetalladoNuevo() {}
