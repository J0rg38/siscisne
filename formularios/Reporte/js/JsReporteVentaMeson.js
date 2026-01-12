// JavaScript Document

function FncValidar() {
  var respuesta = true;
  //var VariablesFormulario = $('#FrmReporteVentaMeson').serialize();

  if ($("#CmpFechaInicio").val() == "") {
    dhtmlx.alert({
      title: "Aviso",
      type: "alert-error",
      text: "No ha escogido una fecha de inicio.",
      callback: function (result) {
        $("#CmpFechaInicio").focus();
      },
    });
    respuesta = false;
  } else if ($("#CmpFechaFin").val() == "") {
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
      FncReporteVentaMesonVer("");
    }
  });

  $("#BtnImprimir").on("click", function () {
    if (FncValidar()) {
      FncReporteVentaMesonImprimir("");
    }
  });

  $("#BtnExcel").on("click", function () {
    if (FncValidar()) {
      FncReporteVentaMesonGenerarExcel("");
    }
  });

  //var Ancho = $( document ).width();
  var Ancho = $(window).width();
  Ancho = Ancho - Ancho * 0.08;

  $(".EstReporteCapaListado").width(Ancho);
});

function FncReporteVentaMesonImprimir(oIndice) {
  var Accion = document.getElementById("FrmReporteVentaMeson" + oIndice).action;

  FncPopUp(
    Accion + "?" + $("#FrmReporteVentaMeson").serialize() + "&P=1",
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

function FncReporteVentaMesonGenerarExcel(oIndice) {
  var Accion = "formularios/Reporte/XLSReporteVentaMeson.php";

  FncPopUp(
    Accion + "?" + $("#FrmReporteVentaMeson").serialize() + "&P=2",
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

function FncReporteVentaMesonVer() {
  $("#CapReporteVentaMeson").html("Cargando...");

  $.ajax({
    type: "GET",
    url: "formularios/Reporte/IfrReporteVentaMeson.php",
    data: $("#FrmReporteVentaMeson").serialize(),

    success: function (html) {
      $("#CapReporteVentaMeson").html(html);
    },
    error: function (html) {
      $("#CapReporteVentaMeson").html(
        "Ha ocurrido un error inesperado, intente nuevamente."
      );
    },
    complete: function () {
		
	},
  });
}
