// JavaScript Document

function FncValidar(){

		var TipoOperacion = $("#CmpTipoOperacion").val();
		var ComprobanteTipo = $("#CmpComprobanteTipo").val();
		
		var Personal = $("#CmpPersonal").val();
		
		var Fecha = $("#CmpFecha").val();
		var FechaLlegada = $("#CmpFechaLlegada").val();
		
		var Sucursal = $("#CmpSucursal").val();
		var SucursalDestino = $("#CmpSucursalDestino").val();
	
		if(TipoOperacion == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de operacion",
					callback: function(result){
						$("#CmpTipoOperacion").focus();
					}
				});

			return false;
			
		}else if(ComprobanteTipo == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de comprobante",
					callback: function(result){
						$("#CmpComprobanteTipo").focus();
					}
				});

			return false;
				
		}else if(Personal == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un responsable",
					callback: function(result){
						$("#CmpPersonal").focus();
					}
				});

			return false;
			
		}else if(Fecha == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de salida",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});

			return false;
			
		}else if(FncValidarFecha(Fecha) == false){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de salida valida",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});

			return false;
		}else if(FechaLlegada == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de llegada",
					callback: function(result){
						$("#CmpFechaLlegada").focus();
					}
				});

			return false;
			
			}else if(FncValidarFecha(FechaLlegada) == false){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de llegada valida",
					callback: function(result){
						$("#CmpFechaLlegada").focus();
					}
				});

			return false;
		}else if(Sucursal == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una sucursal de origen",
					callback: function(result){
						$("#CmpSucursal").focus();
					}
				});

			return false;
		}else if(SucursalDestino == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una sucursal destino",
					callback: function(result){
						$("#CmpSucursalDestino").focus();
					}
				});

			return false;
	
		}else{
			return true;
		}
		
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpSucursal").removeAttr('disabled');	
		$("#CmpSucursalDestino").removeAttr('disabled');	
		$("#CmpTipoOperacion").removeAttr('disabled');	
		
		$("#CmpEstado").removeAttr('disabled');	
		return FncValidar();
		
	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpSucursal").removeAttr('disabled');	
		$("#CmpSucursalDestino").removeAttr('disabled');	
		$("#CmpTipoOperacion").removeAttr('disabled');	
		
		$("#CmpEstado").removeAttr('disabled');	
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	//VehiculoIngresoBuscarVariables = "Moneda="+$("#CmpMonedaId").val();
	
});


var FormularioCampos = ["CmpFecha",
"CmpFechaLlegada",
"CmpTipoOperacion",
"CmpComprobanteTipo",

"CmpReferenciaSerie",
"CmpTransferenciaNumero",

"CmpSucursal",
"CmpSucursalDestino",

"CmpObservacion",

"CmpEstado",


"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpProductoCantidad"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncAlmacenMovimientoNavegar(this.id);
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

	//$("select#CmpClienteTipo").change(function(){
	//	FncTrasladoProductoDetalleActualizarPrecio();
	//});
	
	$("#CmpDescuento").keyup(function(){
		FncTrasladoProductoDetalleListar();
	});
	
});
	
/*****************************************************************/


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
		
		if("CmpProductoCantidad"==oCampo){
			$('#CmpProductoCantidad').blur();
			FncTrasladoProductoDetalleGuardar();
		
		}
		
}

/*****************************************************************/

function FncTBCerrarFunncion(){
	
}




/*****************************************************************/



/*****************************************************************/

function FncImprmir(oId,oTalonario){
	FncPopUp('formularios/TrasladoProducto/FrmTrasladoProductoImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId,oTalonario){
	FncPopUp('formularios/TrasladoProducto/FrmTrasladoProductoImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
}





function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}
