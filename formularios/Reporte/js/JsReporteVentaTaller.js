// JavaScript Document
var Taller = "1";

var Moneda = "";
var FechaInicio = "";
var FechaFin = "";
var Sucursal = "";

var Filtro = "";

var Modalidad = "";
var VehiculoMarca = "";
var VehiculoModelo = "";

var Personal = "";

var Orden = "";
var Sentido = "";

var Variables = "";

function FncObtenerVariables() {
  Moneda = $("#CmpMoneda").val();
  FechaInicio = $("#CmpFechaInicio").val();
  FechaFin = $("#CmpFechaFin").val();
  Sucursal = $("#CmpSucursal").val();

  Filtro = $("#CmpFiltro").val();

  Modalidad = $("#CmpModalidad").val();
  VehiculoMarca = $("#CmpVehiculoMarca").val();
  VehiculoModelo = $("#CmpVehiculoModelo").val();

  Personal = $("#CmpPersonal").val();

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
    "&CmpModalidad=" +
    Modalidad +
    "&CmpVehiculoMarca=" +
    VehiculoMarca +
    "&CmpVehiculoModelo=" +
    VehiculoModelo +
    "&CmpPersonal=" +
    Personal +
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
      FncReporteVentaTallerVer("");
    }
  });

  $("#BtnImprimir").on("click", function () {
    if (FncValidar()) {
      FncReporteVentaTallerImprimir("");
    }
  });

  $("#BtnExcel").on("click", function () {
    if (FncValidar()) {
      FncReporteVentaTallerGenerarExcel("");
    }
  });

  //var Ancho = $( document ).width();
  var Ancho = $(window).width();
  Ancho = Ancho - Ancho * 0.08;
  $(".EstReporteCapaListado").width(Ancho);

  //
});

function FncReporteVentaTallerImprimir(oIndice) {
  FncObtenerVariables();

  var Accion = document.getElementById(
    "FrmReporteVentaTaller" + oIndice
  ).action;

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

function FncReporteVentaTallerGenerarExcel(oIndice) {
  FncObtenerVariables();

  var Accion = "formularios/Reporte/XLSReporteVentaTaller.php";

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

function FncReporteVentaTallerVer(oIndice) {
  FncObtenerVariables();

  $("#CapReporteVentaTaller").html("Cargando...");

  $.ajax({
    type: "GET",
    url: "formularios/Reporte/IfrReporteVentaTaller.php",
    //data: "Moneda="+Moneda+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Orden="+Orden+"&Sentido="+Sentido+"&ClienteNumeroDocumento="+ClienteNumeroDocumento+"&ClienteNombre="+ClienteNombre+"&ClienteId="+ClienteId,
    data: Variables,

    success: function (html) {
      $("#CapReporteVentaTaller").html(html);
    },
  });
}
