// JavaScript Document
var PuntoPartidaDepartamentoHabilitado = 1;
var PuntoPartidaProvinciaHabilitado = 1;
var PuntoPartidaDistritoHabilitado = 1;

var PuntoLlegadaDepartamentoHabilitado = 1;
var PuntoLlegadaProvinciaHabilitado = 1;
var PuntoLlegadaDistritoHabilitado = 1;

function FncValidar(){

	var FechaEmision = $("#CmpFechaEmision").val();
	var FechaInicioTraslado = $("#CmpFechaInicioTraslado").val();
	
	var ClienteId = $("#CmpClienteId").val();
	var ClienteNombre = $("#CmpClienteNombre").val();
	
	var Talonario = $("#CmpTalonario").val();
	
	var PuntoPartida = $("#CmpPuntoPartida").val();
	var PuntoLlegada = $("#CmpPuntoLlegada").val();
	
	var PuntoPartidaCodigoUbigeo = $("#CmpPuntoPartidaCodigoUbigeo").val();
	var PuntoLlegadaCodigoUbigeo = $("#CmpPuntoLlegadaCodigoUbigeo").val();
	
	var PesoTotal = $("#CmpPesoTotal").val();
	
	var Placa = $("#CmpPlaca").val();
	var ChoferNumeroDocumento = $("#CmpChoferNumeroDocumento").val();
	var ProveedorNombre = $("#CmpProveedorNombre").val();
	var ProveedorNumeroDocumento = $("#CmpProveedorNumeroDocumento").val();
		
		if(FechaEmision == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de emision",
					callback: function(result){
						$("#CmpFechaEmision").focus();
					}
				});
				
			return false;
		
		}else if(Talonario == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una serie de guia de remision",
					callback: function(result){
						$("#CmpTalonario").focus();
					}
				});
				
			return false;
			

		}else if(FechaInicioTraslado == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de inicio de traslado",
					callback: function(result){
						$("#CmpFechaInicioTraslado").focus();
					}
				});
				
			return false;
			
		}else if(ClienteId == "" && ClienteNombre !=""){		

				//alert("Debes ingresar una fecha de inicio");		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No has ingresado correctamente al destinatario",
					callback: function(result){
						$("#CmpClienteNombre").select();
					}
				});
							
			
			return false;
			
			
		}else if(ClienteNombre == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un cliente destino",
					callback: function(result){
						$("#CmpClienteNombre").focus();
					}
				});
				
			return false;
			
		}else if(PuntoPartida == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un punto de partida",
					callback: function(result){
						$("#CmpPuntoPartida").focus();
					}
				});
				
			return false;
			
		}else if(PuntoLlegada == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un punto de llegada ",
					callback: function(result){
						$("#CmpPuntoLlegada").focus();
					}
				});
				
			return false;

		}else if(PuntoPartidaCodigoUbigeo == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar el codigo de ubigeo para el punto de partida",
					callback: function(result){
						$("#CmpPuntoPartidaCodigoUbigeo").focus();
					}
				});
				
			return false;
			
		}else if(PuntoLlegadaCodigoUbigeo == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar el codigo ubigeo para el punto de llegada ",
					callback: function(result){
						$("#CmpPuntoLlegadaCodigoUbigeo").focus();
					}
				});
				
			return false;
		}else if(PesTotal == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un peso total aproximado ",
					callback: function(result){
						$("#CmpPesoTotal").focus();
					}
				});
				
			return false;
			
		}else if(ProveedorNumeroDocumento == "" && ChoferNumeroDocumento == "" && ProveedorNombre == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar al menos una unidad de transporte",
					callback: function(result){
						$("#CmpProveedorNombre").focus();
					}
				});
				
			return false;
			
		}else if(ProveedorNumeroDocumento == "" && ProveedorNombre == "" && ChoferNumeroDocumento != "" && Placa == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una numero de placa",
					callback: function(result){
						$("#CmpPlaca").focus();
					}
				});
				
			return false;	
			
		}else if(ProveedorNumeroDocumento == "" && ProveedorNombre == "" && ChoferNumeroDocumento == "" && Placa != ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar el Num. Documento del chofer",
					callback: function(result){
						$("#CmpChoferNumeroDocumento").focus();
					}
				});
				
			return false;	
			
		}else if(ProveedorNumeroDocumento != "" && ChoferNumeroDocumento == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un Num. Documento del proveedor de transporte",
					callback: function(result){
						$("#CmpProveedorNumeroDocumento").focus();
					}
				});
				
			return false;	
			
		}else if(ProveedorNombre != "" && ChoferNumeroDocumento == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar nombre del proveedor de transporte",
					callback: function(result){
						$("#CmpProveedorNombre").focus();
					}
				});
				
			return false;
				
		}else{
			return true;
		}
		
	var PesoTotal = $("#CmpPlaca").val();
	var ChoferNumeroDocumento = $("#CmpChoferNumeroDocumento").val();
	var ProveedorNombre = $("#CmpProveedorNombre").val();
	var ProveedorNumeroDocumento = $("#CmpProveedorNumeroDocumento").val();
		
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});

var FormularioCampos = ["CmpDestinoNumeroDocumento",
"CmpDestinatarioNombre",
"CmpDestinatarioNumeroDocumento1",
"CmpDestinatarioNumeroDocumento2",
"CmpClienteNombre",
"CmpClienteNumeroDocumento",
"CmpProveedorNombre",
"CmpProveedorNumeroDocumento",
"CmpNumeroRegistro",
"CmpNumeroConstanciaInscripcion",
"CmpChofer",
"CmpNumeroLicenciaConducir",
"CmpMarca",
"CmpPlaca",
"CmpFechaInicioTraslado",
"CmpPuntoPartida",
"CmpPuntoLlegada",
"CmpObservacion",
"CmpObservacionImpresa",
"CmpEstado",

"CmpGuiaRemisionDetalleCodigo",
"CmpGuiaRemisionDetalleDescripcion",
"CmpGuiaRemisionDetalleCantidad",
"CmpGuiaRemisionDetalleUnidadMedida",
"CmpGuiaRemisionDetallePesoNeto",
"CmpGuiaRemisionDetallePesoTotal"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncGuiaRemisionNavegar(this.id);
		 }
	}); 

	$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 

	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 

});
	
function FncGuiaRemisionNavegar(oCampo){
	
		for(var i=0; i< FormularioCampos.length; i++) {
			if(FormularioCampos.length !== i + 1){
				
				if(FormularioCampos[i]==oCampo){
					
					if(document.getElementById(FormularioCampos[i+1]).type=="text"){
						$('#'+FormularioCampos[i]).blur();
						$('#'+FormularioCampos[i+1]).focus();
						$('#'+FormularioCampos[i+1]).select();	
					}else{
						$('#'+FormularioCampos[i]).blur();	
						$('#'+FormularioCampos[i+1]).focus();	
					}
									
				}				
				
			}
				
		}

		if("CmpGuiaRemisionDetallePesoTotal"==oCampo){
			$('#CmpGuiaRemisionDetallePesoTotal').blur();		
			FncGuiaRemisionDetalleGuardar();	
		}
	
}

function FncGenerarGuiaRemisionId(oTalonario){

	if(oTalonario!=""){
	
		$.ajax({
			type: 'POST',
			url: 'formularios/GuiaRemision/acc/AccGuiaRemisionGenerarId.php',
			data: 'Talonario='+oTalonario,
			success: function(data){
				$('#CmpId').val(lTrim(data));	
			}
		});

	}else{
		$('#CmpId').val("");	
	}
		
}



function FncTBCerrarFunncion(oModulo){

}



/***************************************************************/
/***************************************************************/


function FncProductoFormato(row) {			
	return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td>";
}




$(function(){


	$("#CmpGuiaRemisionDetalleDescripcion").unautocomplete();
	$("#CmpGuiaRemisionDetalleDescripcion").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
		width: 900,
		max: 100,
		formatItem: FncProductoFormato,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpGuiaRemisionDetalleDescripcion").result(function(event, data, formatted) {
		if (data){
			$("#CmpGuiaRemisionDetalleCodigo").val(data[0]);				
			FncProductoBuscar("CmpGuiaRemisionDetalleCodigo","Id");	
		}		
	});

	$("#CmpGuiaRemisionDetalleCodigo").unautocomplete();
	$("#CmpGuiaRemisionDetalleCodigo").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&t=', {
		width: 900,
		max: 100,
		formatItem: FncProductoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpGuiaRemisionDetalleCodigo").result(function(event, data, formatted) {
		if (data){
			$("#CmpGuiaRemisionDetalleCodigo").val(data[0]);				
			FncProductoBuscar("CmpGuiaRemisionDetalleCodigo","Id");	
		}		
	});
	
});



function FncProductoBuscar(oCampo,oTablaCampo){
	
	var Dato = $('#'+oCampo).val()
	
	if(Dato!=""){
	
	var ProductoLector = $('#CmpProductoLector:checked').val();
	
	if(ProductoLector=="1"){
		
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
				data: 'Campo='+oTablaCampo+'&Dato='+Dato,
				success: function(InsProducto){

						if(InsProducto.ProId!="" & InsProducto.ProId!=null){

							FncProductoEscoger(InsProducto.ProCodigoOriginal,InsProducto.ProNombre,InsProducto.UmeNombre);

							var ProductoNombre = $('#CmpProductoNombre').val();

							if(ProductoNombre!="undefined" & ProductoNombre!=""){
								$('#CmpGuiaRemisionDetalleCantidad').val(1);
							}

						}else{
							$('#'+oCampo).focus();
							$('#'+oCampo).select();											
						}
					
				}
			});
			

	}else{
		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oTablaCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){
					FncProductoEscoger(InsProducto.ProCodigoOriginal,InsProducto.ProNombre,InsProducto.UmeNombre);
				}else{
					$('#'+oCampo).focus();
					$('#'+oCampo).select();						
				}
				
			}
		});
		

	}

}

}

function FncProductoEscoger(oProductoCodigoOriginal,oProNombre,oUnidadMedidaNombre){	

	$('#CmpGuiaRemisionDetalleDescripcion').val(oProNombre);
	$('#CmpGuiaRemisionDetalleCodigo').val(oProductoCodigoOriginal);
	$('#CmpGuiaRemisionDetalleUnidadMedida').val(oUnidadMedidaNombre);
	$('#CmpGuiaRemisionDetalleCantidad').val("");
	$('#CmpGuiaRemisionDetallePesoNeto').val(0);
	$('#CmpGuiaRemisionDetallePesoTotal').val(0);
	
	$('#CmpGuiaRemisionDetalleCantidad').focus();

}









function FncImprmir(oId,oTalonario){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionImprimir2.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}


function FncVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");			
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}




/*
* PUNTO PARTIDA
*/

/*
* DEPARTAMENTO
*/
function FncPuntoPartidaDepartamentosCargar(){
	
	var DepartamentoAux = $("#CmpPuntoPartidaDepartamentoAux").val();
	var ProvinciaAux = $("#CmpPuntoPartidaProvinciaAux").val();
	
	if(PuntoPartidaDepartamentoHabilitado==1){
		$('#CmpPuntoPartidaDepartamento').removeAttr('disabled');
	}else{
		$('#CmpPuntoPartidaDepartamento').attr('disabled', 'disabled');
	}
	
	$("select#CmpPuntoPartidaDepartamento").html('<option value="">Escoja una opcion</option>');
	
	$.getJSON("comunes/Ubigeo/jn/JnDepartamentos.php",{Departamento:1}, function(j){
		
		var options = '';
		options += '<option value="">Escoja una opcion</option>';			
		
		if(j.length!=0){
			
			for (var i = 0; i < j.length; i++) {
			//	console.log(DepartamentoAux+" = "+j[i].UbiDepartamento);
				if(DepartamentoAux == j[i].UbiDepartamento){
					options += '<option selected="selected" value="' + j[i].UbiDepartamento + '">' + j[i].UbiDepartamento + '</option>';					
				}else{
					options += '<option value="' + j[i].UbiDepartamento + '">' + j[i].UbiDepartamento + '</option>';				
				}
			}
			
		}else{
		
			alert("No se encontraron departamentos");
			
		}
		
		$("select#CmpPuntoPartidaDepartamento").html(options);
	
		$("select#CmpPuntoPartidaDepartamento").unbind();	
		$("select#CmpPuntoPartidaDepartamento").change(function(){
	
			FncPuntoPartidaProvinciasCargar();
	
		});
		
		if(ProvinciaAux!=""){
			FncPuntoPartidaProvinciasCargar();
		}
		
		
	});		
		
	
}


/*
* PROVINCIAS
*/

function FncPuntoPartidaProvinciasCargar(){
	
	var Departamento = $("#CmpPuntoPartidaDepartamento").val();
	var ProvinciaAux = $("#CmpPuntoPartidaProvinciaAux").val();
	var DistritoAux = $("#CmpPuntoPartidaDistritoAux").val();
	
	if(PuntoPartidaProvinciaHabilitado==1){
		$('#CmpPuntoPartidaProvincia').removeAttr('disabled');
	}else{
		$('#CmpPuntoPartidaProvincia').attr('disabled', 'disabled');
	}
	
	if(Departamento != ""){

		$("select#CmpPuntoPartidaProvincia").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnProvincias.php",{Departamento: Departamento}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(ProvinciaAux == j[i].UbiProvincia){
						options += '<option selected="selected" value="' + j[i].UbiProvincia + '">' + j[i].UbiProvincia + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiProvincia + '">' + j[i].UbiProvincia + '</option>';	
					}
				}
				
			}else{
			
				alert("No se encontraron provincias");
				
			}
			
			$("select#CmpPuntoPartidaProvincia").html(options);
			
			$("select#CmpPuntoPartidaProvincia").unbind();	
			$("select#CmpPuntoPartidaProvincia").change(function(){

				FncPuntoPartidaDistritosCargar();
		
			});
			
			if(DistritoAux!=""){
				FncPuntoPartidaDistritosCargar();
			}
			
		});		
		
	}else{

		$("select#CmpPuntoPartidaProvincia").html("");

	}
}


/*
* DISTRITO
*/



function FncPuntoPartidaDistritosCargar(){
	
	var Provincia = $("#CmpPuntoPartidaProvincia").val();
	var DistritoAux = $("#CmpPuntoPartidaDistritoAux").val();
	
	if(PuntoPartidaDistritoHabilitado==1){
		$('#CmpPuntoPartidaDistrito').removeAttr('disabled');
	}else{
		$('#CmpPuntoPartidaDistrito').attr('disabled', 'disabled');
	}
	
	if(Provincia != ""){

		$("select#CmpPuntoPartidaDistrito").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnDistritos.php",{Provincia: Provincia}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(DistritoAux == j[i].UbiDistrito){
						options += '<option selected="selected" value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';	
					}
				}
				
			}else{
			
				alert("No se encontraron distritos");
				
			}
			
			$("select#CmpPuntoPartidaDistrito").html(options);
			
			$("select#CmpPuntoPartidaDistrito").unbind();		
			$("select#CmpPuntoPartidaDistrito").change(function(){

				$.ajax({
					type: 'GET',
					dataType: 'json',
					url: Ruta+'comunes/Ubigeo/jn/JnDistrito.php',
					data: 'Distrito='+$(this).val(),
					success: function(InsDistrito){
												
						if(InsDistrito.UbiId!="" & InsDistrito.UbiId!=null){
							//FncVehiculoEscoger(InsVehiculo.VehId,InsVehiculo.VmaNombre,InsVehiculo.VmoNombre,InsVehiculo.VveNombre,InsVehiculo.VtiNombre,InsVehiculo.VehColor);
							$("#CmpPuntoPartidaCodigoUbigeo").val(InsDistrito.UbiCodigo);
							
						}else{
							$("#CmpPuntoPartidaCodigoUbigeo").val("");
							//$('#CmpVehiculo'+oCampo).focus();
							//$('#CmpVehiculo'+oCampo).select();						
						}
						
					}
				});
		
			});
			
			
		});		
		
	}else{

		$("select#CmpPuntoPartidaDistrito").html("");

	}
}


/*
* PUNTO LLEGADA
*/

/*
* DEPARTAMENTO
*/

function FncPuntoLlegadaDepartamentosCargar(){
	
	var DepartamentoAux = $("#CmpPuntoLlegadaDepartamentoAux").val();
	
	var ProvinciaAux = $("#CmpPuntoLlegadaProvinciaAux").val();/**/
		
	if(PuntoLlegadaDepartamentoHabilitado==1){
		$('#CmpPuntoLlegadaDepartamento').removeAttr('disabled');
	}else{
		$('#CmpPuntoLlegadaDepartamento').attr('disabled', 'disabled');
	}
	
		$("select#CmpPuntoLlegadaDepartamento").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnDepartamentos.php",{Departamento:1}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					if(DepartamentoAux == j[i].UbiDepartamento){
						options += '<option selected="selected" value="' + j[i].UbiDepartamento + '">' + j[i].UbiDepartamento + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiDepartamento + '">' + j[i].UbiDepartamento + '</option>';				
					}
				}
				
			}else{
			
				alert("No se encontraron departamentos");
				
			}
			
			$("select#CmpPuntoLlegadaDepartamento").html(options);
		
			$("select#CmpPuntoLlegadaDepartamento").unbind();
			$("select#CmpPuntoLlegadaDepartamento").change(function(){

				FncPuntoLlegadaProvinciasCargar();
		
			});
			
			if(ProvinciaAux!=""){
				
				FncPuntoLlegadaProvinciasCargar();
				
			}
			
		});		
		
	
}


/*
* PROVINCIAS
*/

function FncPuntoLlegadaProvinciasCargar(){
	
	var Departamento = $("#CmpPuntoLlegadaDepartamento").val();
	
	var ProvinciaAux = $("#CmpPuntoLlegadaProvinciaAux").val();
	var DistritoAux = $("#CmpPuntoLlegadaDistritoAux").val();
	
	if(PuntoLlegadaProvinciaHabilitado==1){
		$('#CmpPuntoLlegadaProvincia').removeAttr('disabled');
	}else{
		$('#CmpPuntoLlegadaProvincia').attr('disabled', 'disabled');
	}
	
	if(Departamento != ""){

		$("select#CmpPuntoLlegadaProvincia").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnProvincias.php",{Departamento: Departamento}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(ProvinciaAux == j[i].UbiProvincia){
						options += '<option selected="selected" value="' + j[i].UbiProvincia + '">' + j[i].UbiProvincia + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiProvincia + '">' + j[i].UbiProvincia + '</option>';	
					}
				}
				
			}else{
			
				alert("No se encontraron provincias");
				
			}
			
			$("select#CmpPuntoLlegadaProvincia").html(options);
			
			$("select#CmpPuntoLlegadaProvincia").unbind();			
			$("select#CmpPuntoLlegadaProvincia").change(function(){

				FncPuntoLlegadaDistritosCargar();
		
			});
			
			if(DistritoAux!=""){
				
				FncPuntoLlegadaDistritosCargar();
				
			}
			
		});		
		
	}else{

		$("select#CmpPuntoLlegadaProvincia").html("");

	}
}


/*
* DISTRITO
*/



function FncPuntoLlegadaDistritosCargar(){
	
	var Provincia = $("#CmpPuntoLlegadaProvincia").val();
	var DistritoAux = $("#CmpPuntoLlegadaDistritoAux").val();
	
	if(PuntoLlegadaDistritoHabilitado==1){
		$('#CmpPuntoLlegadaDistrito').removeAttr('disabled');
	}else{
		$('#CmpPuntoLlegadaDistrito').attr('disabled', 'disabled');
	}
	
	if(Provincia != ""){

		$("select#CmpPuntoLlegadaDistrito").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Ubigeo/jn/JnDistritos.php",{Provincia: Provincia}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(DistritoAux == j[i].UbiDistrito){
						options += '<option selected="selected" value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';					
					}else{
						options += '<option value="' + j[i].UbiDistrito + '">' + j[i].UbiDistrito + '</option>';	
					}
				}
				
			}else{
			
				alert("No se encontraron distritos");
				
			}
			
			$("select#CmpPuntoLlegadaDistrito").html(options);
			
			$("select#CmpPuntoLlegadaDistrito").unbind();		
			$("select#CmpPuntoLlegadaDistrito").change(function(){

				$.ajax({
					type: 'GET',
					dataType: 'json',
					url: Ruta+'comunes/Ubigeo/jn/JnDistrito.php',
					data: 'Distrito='+$(this).val(),
					success: function(InsDistrito){
												
						if(InsDistrito.UbiId!="" & InsDistrito.UbiId!=null){
							//FncVehiculoEscoger(InsVehiculo.VehId,InsVehiculo.VmaNombre,InsVehiculo.VmoNombre,InsVehiculo.VveNombre,InsVehiculo.VtiNombre,InsVehiculo.VehColor);
							$("#CmpPuntoLlegadaCodigoUbigeo").val(InsDistrito.UbiCodigo);
							
						}else{
							$("#CmpPuntoLlegadaCodigoUbigeo").val("");
							//$('#CmpVehiculo'+oCampo).focus();
							//$('#CmpVehiculo'+oCampo).select();						
						}
						
					}
				});
		
			});
			
		});		
		
	}else{

		$("select#CmpPuntoLlegadaDistrito").html("");

	}
}

