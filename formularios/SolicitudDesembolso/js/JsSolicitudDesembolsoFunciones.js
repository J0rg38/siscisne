// JavaScript Document


function FncValidar(){

		var Fecha = $("#CmpFecha").val();
		var MonedaId = $("#CmpMonedaId").val();
		var TipoCambio = $("#CmpTipoCambio").val();
		var Cliente = $("#CmpCliente").val();
		var Area = $("#CmpArea").val();
		var Monto = $("#CmpMonto").val();
		
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
			
		}else if(MonedaId == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger un moneda",
					callback: function(result){
						$("#CmpMonedaId").focus();
					}
				});

			
			return false;
			
		}else if(Area == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un area",
					callback: function(result){
						$("#CmpArea").focus();
					}
				});
			
			return false;
			
		/*}else if(Monto == "" || Monto == "0" || Monto == "0.00"){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un monto",
					callback: function(result){
						$("#CmpMonto").focus();
					}
				});
			
			return false;*/
			
		}else{
			return true;
		}
		
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');		
		$("#CmpOrigen").removeAttr('disabled');	
		$("#CmpProveedorTipoDocumento").removeAttr('disabled');	

		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');		
		$("#CmpOrigen").removeAttr('disabled');	
		$("#CmpProveedorTipoDocumento").removeAttr('disabled');	
		
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});





function FncGuardar(){
	
	//HACK
//	$("#CmpClienteTipoDocumento").removeAttr('disabled');	
//	$("#CmpEstado").removeAttr('disabled');		
//	$("#CmpOrigen").removeAttr('disabled');		
	
	//var ClienteId = $("#CmpClienteId").val();
//	
//	alert(ClienteId);
//	if(ClienteId==""){
//
//		alert("No ha registrado al cliente");
//		FncClienteCargarFormulario("Registrar")
//		return false
//
//	}

	
}

/************************************************************/
/************************************************************/

var FormularioCampos = ["CmpFecha",
"CmpMonedaId",
"CmpTipoCambio",
"CmpTipoGasto",
"CmpArea",
"CmpCliente",
"CmpVIN",
"CmpPlaca",
"CmpMonto",

"CmpPersonal",
"CmpObservacion",
"CmpObservacionImpresa",

"CmpServicioRepuestoNombre",
"CmpSolicitudDesembolsoDetalleCantidad",
"CmpSolicitudDesembolsoDetalleImporte"
];

//"CmpSolicitudDesembolsoDetalleCodigo",

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncAlmacenMovimientoNavegar(this.id);
		 }
	}); 
	

	
/*
Agregando Eventos
*/
	$("select#CmpMonedaId").change(function(){
		FncSolicitudDesembolsoEstablecerMoneda();
	});
	
	$("select#CmpIncluyeImpuesto").change(function(){
		FncSolicitudDesembolsoDetalleListar();
	});
	
	$("select#CmpArea").change(function(){
		
		if($("#CmpArea option:selected").text()=="ALMACEN"){
			$('#CmpObservacionImpresa').val("Repuesto para stock");
		}
		
	});
	

});
	
function FncAlmacenMovimientoNavegar(oCampo){
	
		for(var i=0; i< FormularioCampos.length; i++) {
			if(FormularioCampos.length !== i + 1){
				
				if(FormularioCampos[i]==oCampo){
					
					if($('#'+FormularioCampos[i+1]).attr('type')=="text"){
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
		
		if("CmpSolicitudDesembolsoDetalleImporte"==oCampo){
			$('#CmpSolicitudDesembolsoDetalleImporte').blur();
			FncSolicitudDesembolsoDetalleGuardar();
		}
		
}



/************************************************************/
//EXTRAS

function FncSolicitudDesembolsoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncSolicitudDesembolsoDetalleListar();
		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
			FncSolicitudDesembolsoDetalleListar();
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");
			}

		}
		FncMonedaBuscar('Id');
	}

}



function FncTipoCambioFuncion(InsTipoCambio){

	FncSolicitudDesembolsoDetalleListar();

}

function FncFichaIngresoFuncion(InsFichaIngreso){

	$('#CmpVIN').val(InsFichaIngreso.EinVIN);
	$('#CmpPlaca').val(InsFichaIngreso.EinPlaca);

	if(InsFichaIngreso.CliNombreCompleto!="" && InsFichaIngreso.CliNombreCompleto!=null){
		$('#CmpCliente').val(InsFichaIngreso.CliNombreCompleto);
	}else{
		$('#CmpCliente').val(InsFichaIngreso.CliNombre+" "+InsFichaIngreso.CliApellidoPaterno +" "+InsFichaIngreso.CliApellidoPaterno);
	}
	

}

/************************************************************/
//IMPRESION

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/SolicitudDesembolso/FrmSolicitudDesembolsoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/SolicitudDesembolso/FrmSolicitudDesembolsoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}
