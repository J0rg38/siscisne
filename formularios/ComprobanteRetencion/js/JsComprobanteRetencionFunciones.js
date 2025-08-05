// JavaScript Document


function FncValidar(){

	var Talonario = $("#CmpTalonario").val();
	var Id = $("#CmpId").val();
	var ClienteId = $("#CmpClienteId").val();
	var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
	var ClienteNombreCompleto = $("#CmpClienteNombreCompleto").val();
	var FechaEmision = $("#CmpFechaEmision").val();
	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	
		if(Talonario == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una serie",
					callback: function(result){
						$("#CmpTalonario").focus();
					}
				});
				
			return false;
		}else if(Id == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un numero correlativo",
					callback: function(result){
						$("#CmpId").focus();
					}
				});
				
			return false;
		}else if(ClienteNumeroDocumento == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un numero de documento",
					callback: function(result){
						$("#CmpClienteNombreCompleto").focus();
					}
				});

			return false;

		}else if(ClienteNombreCompleto == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre de cliente",
					callback: function(result){
						$("#CmpDuracion").focus();
					}
				});

			return false;
			
		}else if(ClienteNombreCompleto != "" && ClienteId==""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar al cliente nuevamente",
					callback: function(result){
						$("#CmpDuracion").focus();
					}
				});

			return false;
						
		}else if(FechaEmision == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de emision",
					callback: function(result){
						$("#CmpFechaEmision").focus();
					}
				});

			return false;
			
			
		}else if(FechaEmision != "" && !isDate(FechaEmision)){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha con el formato dd/mm/yyyy",
					callback: function(result){
						$("#CmpFechaEmision").focus();
					}
				});

			return false;

		}else if(MonedaId == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#CmpMonedaId").focus();
					}
				});

			return false;
			
		}else if(TipoCambio == "" && MonedaId!=EmpresaMonedaId){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un tipo de cambio",
					callback: function(result){
						$("#CmpMonedaId").focus();
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





function FncPagoComprobanteRetencionBuscar(){
}


function FncGuardar(){
	
	//HACK
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	$("#CmpCancelado").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');
	
}



var FormularioCampos = ["CmpTalonario",
"CmpId",
"CmpClienteNumeroDocumento",
"CmpClienteNombreCompleto",
"CmpClienteDireccion",
"CmpFechaEmision",
"CmpObservacion",
"CmpObservacionImpresa",
"CmpMonedaId",
"CmpTipoCambio",
"CmpCancelado",
"CmpEstado",

"CmpComprobanteRetencionDetalleTipo",
"CmpComprobanteRetencionDetalleSerie",
"CmpComprobanteRetencionDetalleNumero",
"CmpComprobanteRetencionDetalleFechaEmision",
"CmpComprobanteRetencionDetalleTotal",
"CmpComprobanteRetencionDetallePorcentajeRetencion",
"CmpComprobanteRetencionDetalleRetenido",
"CmpComprobanteRetencionDetallePagado"

];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncComprobanteRetencionNavegar(this.id);
		 }
	}); 
	
	/*$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 
	
	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	});*/ 
	
/*
Agregando Eventos
*/

	$("#CmpComprobanteRetencionDetallePorcentajeRetencion").keyup(function (event) {  
		FncComprobanteRetencionDetalleCalcularRetenido();
	});
	
	$("#CmpComprobanteRetencionDetalleTotal").keyup(function (event) {  
		FncComprobanteRetencionDetalleCalcularRetenido();
	});
	
	$("select#CmpMonedaId").change(function(){
		FncComprobanteRetencionEstablecerMoneda();
	});
	

	
});
	
function FncComprobanteRetencionNavegar(oCampo){
	
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
	
	if("CmpComprobanteRetencionDetallePagado"==oCampo){
		$("#CmpComprobanteRetencionDetallePagado").blur();		
		FncComprobanteRetencionDetalleGuardar();	
	}
	
}




function FncGenerarComprobanteRetencionId(oTalonario){

	if(oTalonario!=""){
	
		$.ajax({
			type: 'POST',
			url: 'formularios/ComprobanteRetencion/acc/AccComprobanteRetencionGenerarId.php',
			data: 'Talonario='+oTalonario,
			success: function(data){
				$('#CmpId').val(lTrim(data));	
			}
		});

	}else{
		$('#CmpId').val("");	
	}

}








function FncComprobanteRetencionEstablecerMoneda(){

	//var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFechaEmision').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		$('#CmpTipoCambio').attr('readonly', true);	
		
		FncComprobanteRetencionDetalleListar();

		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
			$('#CmpTipoCambio').attr('readonly', true);	
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			}
			$('#CmpTipoCambio').removeAttr('readonly');	
			//$('#CmpTipoCambio').val(TcaMontoCompra)
		}

		FncMonedaBuscar('Id');
	}

//	$('#CapMonedaArticuloCosto').html(MonedaSimbolo);
//	$('#CapMonedaArticuloImporte').html(MonedaSimbolo);
	
	//FncCompraDetalleListar();
	//FncCompraGastoListar();
	//FncCompraDocumentoListar();
	
	
	//FncComprobanteRetencionDetalleListar();

}

function FncClienteFuncion(){

	FncClienteNotaVerificar();
	
}



/*
* IMPRESION
*/
function FncImprmir(oId,oTalonario){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){

			case "1":
			
				FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "3":
	
				FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
					
		}
		
	}

}


function FncVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato)  \n 3 = Formato 3 (Impresion PDF)", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			case "3":
	
				FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarPDF.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
		
		}
		
	}

}


/*
* ACCIONES
*/



/*
* FORMULARIOS
*/


/*
* COMUNES
*/

function FncMonedaFuncion(){
	FncComprobanteRetencionDetalleListar();
}











/*
* CALCULO
*/


function FncComprobanteRetencionDetalleCalcularRetenido(){

	var Total = $('#CmpComprobanteRetencionDetalleTotal').val();
	var PorcentajeRetencion = $('#CmpComprobanteRetencionDetallePorcentajeRetencion').val();
	var Retenido = 0;;
	var Pagado = 0;;
	
	if(Total!="" && PorcentajeRetencion!=""){
		
		Retenido = (parseFloat(Total) * parseFloat(PorcentajeRetencion)/100);
		
		$('#CmpComprobanteRetencionDetalleRetenido').val(Retenido);
		
		Pagado = parseFloat(Total) - Retenido;
	
		$('#CmpComprobanteRetencionDetallePagado').val(Pagado);
		
	}

}

