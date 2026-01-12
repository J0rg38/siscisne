// JavaScript Document

var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";
var Filtro = "";

var Orden = "";
var Sentido = "";

var Variables = "";

function FncObtenerVariables() {
  Moneda = $("#CmpMoneda").val();
  FechaInicio = $("#CmpFechaInicio").val();
  FechaFin = $("#CmpFechaFin").val();
  Sucursal = $("#CmpSucursal").val();
  Filtro = $("#CmpFiltro").val();

  Orden = $("#CmpOrden").val();
  Sentido = $("#CmpSentido").val();

  Variables =
    "CmpMoneda=" +
    Moneda +
    "&CmpFechaInicio=" +
    FechaInicio +
    "&CmpFechaFin=" +
    FechaFin +
    "&CmpSucursal=" +
    Sucursal +
    "&CmpFiltro=" +
    Filtro +
    "&CmpOrden=" +
    Orden +
    "&CmpSentido=" +
    Sentido;
}

function FncValidar() {
  var respuesta = true;
  FncObtenerVariables();

  if (FechaInicio == "") {
    dhtmlx.alert({
      title: "Aviso",
      type: "alert-error",
      text: "No ha escogido una fecha de inicio.",
      callback: function (result) {
        $("#CmpFechaInicio").focus();
      },
    });
    respuesta = false;
  } else if (FechaFin == "") {
    dhtmlx.alert({
      title: "Aviso",
      type: "alert-error",
      text: "No ha escogido una fecha fin.",
      callback: function (result) {
        $("#CmpFechaFin").focus();
      },
    });
    respuesta = false;
  }

  return respuesta;
}

$().ready(function () {
  $("#BtnVer").on("click", function () {
    if (FncValidar()) {
      FncReporteComprobanteNoProcesadoVer("");
    }
  });

  $("#BtnImprimir").on("click", function () {
    if (FncValidar()) {
      FncReporteComprobanteNoProcesadoImprimir("");
    }
  });

  $("#BtnExcel").on("click", function () {
    if (FncValidar()) {
      FncReporteComprobanteNoProcesadoGenerarExcel("");
    }
  });

  //var Ancho = $( document ).width();
  var Ancho = $(window).width();

  Ancho = Ancho - Ancho * 0.08;

  $(".EstReporteCapaListado").width(Ancho);

  //
});

function FncReporteComprobanteNoProcesadoImprimir(oIndice) {
  FncObtenerVariables();

  var Accion = "formularios/Reporte/IfrReporteComprobanteNoProcesado.php";

  FncPopUp(
    Accion + "?" + Variables + "&P=1",
    0,
    0,
    1,
    0,
    0,
    1,
    0,
    screen.height,
    screen.width
  );
}

function FncReporteComprobanteNoProcesadoGenerarExcel(oIndice) {
  FncObtenerVariables();

  var Accion = "formularios/Reporte/XLSReporteComprobanteNoProcesado.php";

  FncPopUp(
    Accion + "?" + Variables + "&P=2",
    0,
    0,
    1,
    0,
    0,
    1,
    0,
    screen.height,
    screen.width
  );
}

function FncReporteComprobanteNoProcesadoVer(oIndice) {
  FncObtenerVariables();

  $("#CapReporteComprobanteNoProcesado").html("Cargando...");

  $.ajax({
    type: "GET",
    url: "formularios/Reporte/IfrReporteComprobanteNoProcesado.php",
    data: Variables,
    success: function (html) {
      $("#CapReporteComprobanteNoProcesado").html(html);
    },
  });
}
