// JavaScript Document


function FncGuardar(){
	
	//HACK
	$("#CmpClienteTipoDocumento").removeAttr('disabled');	
	$("#CmpEstado").removeAttr('disabled');		
	$("#CmpOrigen").removeAttr('disabled');	
	$("#CmpIncluyeImpuesto").removeAttr('disabled');		
	
	//var ClienteId = $("#CmpClienteId").val();
//	
//	alert(ClienteId);
//	if(ClienteId==""){
//
//		alert("No ha registrado al cliente");
//		FncClienteSimpleCargarFormulario("Registrar")
//		return false
//
//	}

	
}


$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});


/************************************************************/
/************************************************************/

var FormularioCampos = ["CmpFecha",
"CmpClienteNombre",
"CmpClienteTipoDocumento",
"CmpClienteNumeroDocumento",
"CmpObservacion",
"CmpOrigen",
"CmpOrdenCompra",

"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",


"CmpRegistroOperacionUIFDetalleAno",
"CmpRegistroOperacionUIFDetalleModelo",
"CmpProductoPrecio",
"CmpProductoCantidad",
"CmpProductoImporte"
];

//"CmpRegistroOperacionUIFDetalleCodigo",

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
		FncRegistroOperacionUIFEstablecerMoneda();
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
		
		
}



/************************************************************/
//EXTRAS

function FncRegistroOperacionUIFEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();
	
	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncRegistroOperacionUIFDetalleListar();
		alert("Debe Escoger una moneda");
	}else{
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");
			}

		}
		FncMonedaBuscar('Id');
	}

}


/************************************************************/
//IMPRESION

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/RegistroOperacionUIF/FrmRegistroOperacionUIFImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/RegistroOperacionUIF/FrmRegistroOperacionUIFImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}






// JavaScript Document

function FncValidar(){

	var Transaccion = $("#CmpTransaccion").val();
	var MonedaId = $("#CmpMonedaId").val();
	var Importe = $("#CmpImporte").val();
	var ClienteId = $("#CmpClienteId").val();
	var ClienteNombre = $("#CmpClienteNombre").val();
	
	var OrigenFondo = $("#CmpOrigenFondo").val();
	var Personal = $("#CmpPersonal").val();

		if(Transaccion == ""){		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una descripcion en el campo transaccion",
					callback: function(result){
						$("#CmpTransaccion").focus();
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
		}else if(Importe == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un importe",
					callback: function(result){
						$("#CmpImporte").focus();
					}
				});

			
			return false;
		}else if(Importe == "0.00"){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un importe",
					callback: function(result){
						$("#CmpImporte").focus();
					}
				});

			
			return false;
			
		}else if(ClienteNombre==""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar un cliente",
					callback: function(result){
						$("#CmpClienteNombre").focus(); 
					}
				});

			
			return false;
		}else if(ClienteId == "" && (ClienteNombre!="") ){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No se ha podido identificar al cliente, intente ingresarlo nuevamente",
					callback: function(result){
						$("#CmpClienteNombre").focus(); 
					}
				});

			
			return false;
			
		}else if( OrigenFondo == "" ){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar el origen de los fondos",
					callback: function(result){
						$("#CmpOrigenFondo").focus(); 
					}
				});

			
			return false;
			
		}else if( Personal == "" ){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger un responsable del registro",
					callback: function(result){
						$("#CmpPersonal").focus(); 
					}
				});

			
			return false;
			
		}else{
			return true;
		}
		
}



function FncClienteSimpleNuevoFuncion(){
	$("#CmpDireccion").val("");
}

function FncClienteSimpleFuncion(InsCliente){
	$("#CmpDireccion").val(InsCliente.CliDireccion);
	$("#CmpTelefono").val(InsCliente.CliTelefono);
	$("#CmpCelular").val(InsCliente.CliCelular);
}








