/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Funciones complementarias
*/
$().ready(function() {

	$("#Fil").focus();
	$("#Fil").select();

	$("#CapListadoSubTotal").html($("#CmpListadoSubTotal").val());
	$("#CapListadoImpuesto").html($("#CmpListadoImpuesto").val());
	$("#CapListadoTotal").html($("#CmpListadoTotal").val());
});

/*
* Funciones Listado
*/

function FncOrdenar(p_ord,p_sen){
	$("#Ord").val(p_ord);
	$("#Sen").val(p_sen);
	$("#FrmListado").submit();
}



function FncPaginar(p_pag,p_p){
	$("#P").val(p_p);
	$("#Pag").val(p_pag);
	$("#FrmListado").submit();	
}

function FncBuscar(){
	$("#Pag").val('0,'+$("#Num").val());
	$("#Ord").val("");
	$("#Sen").val("");
	
	$("#FrmListado").submit();
}

function FncFiltrar(){
	$("#Fil").val("");
	$("#Pag").val('0,'+$("#Num").val());
	$("#Ord").val("");
	$("#Sen").val("");
	
	$("#FrmListado").submit();
}


function FncListar(p_num){
	$("#Pag").val('0,'+p_num);
	$("#Ord").val("");
	$("#Sen").val("");
	
	$("#FrmListado").submit();
}

//Acciones Seleccionar checkboxes

function FncSeleccionarTodo(){

	$("#cmp_seleccionados").val("");
	var seleccionados = '';
	var indice = 0;
	
	if($("#cmp_seleccionar_todo").is(':checked')){
		$('input[type=checkbox]').each(function () {
			if($(this).attr('name')=="cmp_seleccionar[]"){
				$(this).attr('checked', true);		
				$('#Fila_'+indice).css('background-color', '#CEE7FF');		
				seleccionados = seleccionados + '#'+ $(this).val();
			}			 
			indice = indice + 1;
		});
	}else{
		$('input[type=checkbox]').each(function () {
			if($(this).attr('name')=="cmp_seleccionar[]"){
				$(this).attr('checked', false);
				$('#Fila_'+indice).css('background-color', '#FFFFFF');
			}
			indice = indice + 1;
		});
	}
	
	$("#cmp_seleccionados").val(seleccionados);

}

//Acciones Seleccionar checkbox
function FncAgregarSeleccionado(){

	$("#cmp_seleccionados").val("");
	var seleccionados = '';
	var indice = 0;
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('name')=="cmp_seleccionar[]"){
			if($(this).is(':checked')){
				seleccionados = seleccionados + '#'+ $(this).val();
				$('#Fila_'+indice).css('background-color', '#CEE7FF');
			}else{
				$('#Fila_'+indice).css('background-color', '#FFFFFF');				
			}
		}
		indice = indice + 1;
	});
	
	$("#cmp_seleccionados").val(seleccionados);
}
//Acciones - Borrar






/*
Estado Pendiente
*/
function FncActualizarEstadoPendienteSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea cambiar a estado PENDIENTE los elementos?")){
			document.getElementById('Acc').value= 'ActualizarEstadoPendiente';
			$("#FrmListado").submit();
		}
	}
}

/*
Estado Entregado
*/

function FncActualizarEstadoEntregadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		if(confirm("¿Realmente desea cambiar a estado ENTREGADO los elementos?")){
			document.getElementById('Acc').value= 'ActualizarEstadoEntregado';
			$("#FrmListado").submit();
		}
		
		
	}
}

/*
Estado Anulado
*/

function FncActualizarEstadoAnuladoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		if(confirm("¿Realmente desea cambiar a estado ANULADO los elementos?")){
			document.getElementById('Acc').value= 'ActualizarEstadoAnulado';
			$("#FrmListado").submit();
		}
	}
}

/*
Estado Reservado
*/

function FncActualizarEstadoReservadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		if(confirm("¿Realmente desea cambiar a estado RESERVADO los elementos?")){
			document.getElementById('Acc').value= 'ActualizarEstadoReservado';
			$("#FrmListado").submit();
		}
	}
}

function FncGenerarExcel(){
	document.getElementById("FrmListado").action = "formularios/ComprobanteRetencion/acc/AccComprobanteRetencionGenerarExcel.php"
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
}

function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/ComprobanteRetencion/FrmComprobanteRetencionListadoImprimir.php"
	document.getElementById("FrmListado").target = '_blank';
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
	document.getElementById("FrmListado").target = '_self';
}


function FncGenerarGuiaRemisionSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	var primero = true;
	var aux = "";
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						
						if(primero){
							aux = $(this).attr('cliente');
							primero = false;
						}else{
							if($(this).attr('cliente')!=aux){
								actualizar = false;
								return false;
							}
						}

					}
				}

			});	
			
			

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if($(this).attr('estado')=="6"){
							actualizar2 = false;
							return false;
						}
					}
				}

			});	
			
				
		
		if(actualizar){
			if(actualizar2){
				$("#FrmListado").attr("action","principal.php?Mod=GuiaRemision&Form=Registrar&Tip=ComprobanteRetencion");
				$("#FrmListado").submit();	
				$("#FrmListado").attr("action","#");
			}else{
				alert("Uno o mas de los elementos seleccionados se encuentra en estado ANULADO.");
			}

		}else{
			alert("Uno o mas de los elementos seleccionados no se encuentran registrados con el mismo CLIENTE.");
		}
	}
}



function FncGenerarNotaCreditoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	var actualizar3 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		
		if(confirm("¿Realmente desea generar nota de credito de los elementos seleccionados?")){
			aux = seleccionados.split("#");
			
			if((aux.length-1)>1){
				var actualizar = false;			
			}
			
				$('input[type=checkbox]').each(function () {
	
					if($(this).attr('name')=="cmp_seleccionar[]"){
						if($(this).is(':checked')){
							if($(this).attr('estado')=="6"){
								actualizar2 = false;
								return false;
							}
						}
					}
	
				});	
				
				$('input[type=checkbox]').each(function () {
	
					if($(this).attr('name')=="cmp_seleccionar[]"){
						if($(this).is(':checked')){
							if($(this).attr('nota_credito')=="Si"){
								actualizar3 = false;
								return false;
							}
						}
					}
	
				});	
				
			
			if(actualizar){
	
				if(actualizar2){
					if(actualizar3){
						$("#FrmListado").attr("action","principal.php?Mod=NotaCredito&Form=Registrar&Ori=ComprobanteRetencion");
						$("#FrmListado").submit();	
						$("#FrmListado").attr("action","#");
						//alert("Generando GR");
					}else{
						alert("Uno o mas de los elementos seleccionados ya posee NOTA DE CREDITO.");					
					}
				}else{
					alert("Uno o mas de los elementos seleccionados se encuentra en estado ANULADO.");
				}
	
			}else{
				dhtmlx.alert({
						title:"Aviso",
						//type:"alert-error",
						type:"alert",
						text: "Solo puede escoger un elemento",
						callback: function(result){
							
						}
					});
			}
		}
		
	}
}



function FncGenerarNotaDebitoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	var actualizar3 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		
		if(confirm("¿Realmente desea generar nota de debito de los elementos seleccionados?")){
			aux = seleccionados.split("#");
			
			if((aux.length-1)>1){
				var actualizar = false;			
			}
			
				$('input[type=checkbox]').each(function () {
	
					if($(this).attr('name')=="cmp_seleccionar[]"){
						if($(this).is(':checked')){
							if($(this).attr('estado')=="6"){
								actualizar2 = false;
								return false;
							}
						}
					}
	
				});	
				
				$('input[type=checkbox]').each(function () {
	
					if($(this).attr('name')=="cmp_seleccionar[]"){
						if($(this).is(':checked')){
							if($(this).attr('nota_debito')=="Si"){
								actualizar3 = false;
								return false;
							}
						}
					}
	
				});	
				
			
			if(actualizar){
	
				if(actualizar2){
					if(actualizar3){
						$("#FrmListado").attr("action","principal.php?Mod=NotaDebito&Form=Registrar&Ori=ComprobanteRetencion");
						$("#FrmListado").submit();	
						$("#FrmListado").attr("action","#");
						//alert("Generando GR");
					}else{
						alert("Uno o mas de los elementos seleccionados ya posee NOTA DE DEBITO.");					
					}
				}else{
					alert("Uno o mas de los elementos seleccionados se encuentra en estado ANULADO.");
				}
	
			}else{
				dhtmlx.alert({
						title:"Aviso",
						//type:"alert-error",
						type:"alert",
						text: "Solo puede escoger un elemento",
						callback: function(result){
							
						}
					});
			}
		}
		
	}
}
/*
* Funciones Papelera
*/


//Acciones - Eliminar

function FncEliminarSeleccionado(id){
	if(confirm("¿Realmente desea eliminar el elemento?")){
		$("#cmp_seleccionados").val(id);
		$("#Acc").val("Eliminar");
		
		$("#FrmListado").submit();
	}
}

function FncEliminarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		if(confirm("¿Realmente desea ELIMINAR los elementos seleccionados?")){
			$("#Acc").val("Eliminar");
			$("#FrmListado").submit();	
		}
	}
	
}




















function FncComprobanteRetencionImprmir(oId,oTalonario){
	
/*	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			*/
				FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

		/*	break;
			
			case "2":
	
				FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionImprimir2.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;

		}

	}*/

}


function FncComprobanteRetencionVistaPreliminar(oId,oTalonario){

	/*var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":*/
			
				FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
		/*	break;
			
			case "2":
	
				FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
		
		}
		
	}*/

}






/*
* VISTA PRELIMINAR
*/

function FncVentaConcretadaVistaPreliminar(oId){
			
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncAlmacenMovimientoSalidaVistaPreliminar(oId){
		
	FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncVentaDirectaVistaPreliminar(oId){
		
	FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncFichaIngresoVistaPreliminar(oId){
		
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncCotizacionVehiculoVistaPreliminar(oId){
		
	FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncOrdenVentaVehiculoVistaPreliminar(oId){
		
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncCotizacionProductoVistaPreliminar(oId){
		
	FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}



/*
* FORMULARIOS
*/
function FncPagoComprobanteRetencionCargarFormulario(oForm,oComprobanteRetencionId,oComprobanteRetencionTalonarioId){
	
	//tb_show(this.title,'principal2.php?Mod=PagoComprobanteRetencion&Form='+oForm+'&Dia=1&CrnId='+oComprobanteRetencionId+'&CrtId='+oComprobanteRetencionTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=PagoComprobanteRetencion&Form="+oForm,"true","true","savedValues","","Dia=1&CrnId="+oComprobanteRetencionId+'&CrtId='+oComprobanteRetencionTalonarioId)
	
	
}

function FncVentaConcretadaCargarFormulario(oForm,oVentaConcretadaId){
	
	tb_show(this.title,'principal2.php?Mod=VentaConcretada&Form='+oForm+'&Dia=1&Id='+oVentaConcretadaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncFichaIngresoCargarFormulario(oForm,oFichaIngreso){
	
	tb_show(this.title,'principal2.php?Mod=FichaIngreso&Form='+oForm+'&Dia=1&Id='+oFichaIngreso+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncVentaDirectaCargarFormulario(oForm,oVentaDirectadaId){
	
	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaDirectadaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncCotizacionVehiculoCargarFormulario(oForm,oCotizacionVehiculoId){
	
	tb_show(this.title,'principal2.php?Mod=CotizacionVehiculo&Form='+oForm+'&Dia=1&Id='+oCotizacionVehiculoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);

}

function FncOrdenVentaVehiculoCargarFormulario(oForm,oOrdenVentaVehiculoId){
	
	tb_show(this.title,'principal2.php?Mod=OrdenVentaVehiculo&Form='+oForm+'&Dia=1&Id='+oOrdenVentaVehiculoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);

}

function FncClienteCargarFormulario(oForm,oClienteId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId)
	
}

/*
* SUNAT
*/

function FncComprobanteRetencionGenerarPDF(oId,oTalonario){
	
	FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
		
}

function FncComprobanteRetencionConsultarEstadoTicket(oId,oTalonario,oTicket){
	
	if(oTicket==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No se encontro ticket de sunat",
			callback: function(result){
				
			}
		});
		
	}else{
		
		FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionConsultarEstadoTicket.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);
	
	}
	
		
}


function FncComprobanteRetencionGenerarXML(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La factura ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarXML.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=&EnviarSUNAT=',0,0,1,0,0,1,0,350,150);
	}
		
}


function FncComprobanteRetencionProcesarXML(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La factura ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarXML.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	}
		
}


function FncComprobanteRetencionSolicitarBaja(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarBajaXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	
}

function FncComprobanteRetencionRecibirZIP(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionRecibirZIP.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}

function FncComprobanteRetencionRecibirBajaZIP(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionRecibirBajaZIP.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}

function FncComprobanteRetencionRecibirXML(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionRecibirXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}


function FncComprobanteRetencionRecibirCDR(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionRecibirCDR.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}


function FncComprobanteRetencionSunatTareas(oId,oTalonario,oTicket){

	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar comprobante \n 3 = Solicitar baja de comprobante \n 4 = Descargar XML \n 5 = Descargar CDR", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":	
				FncComprobanteRetencionProcesarXML(oId,oTalonario,oTicket);
			break;
			
			case "3":
				FncComprobanteRetencionSolicitarBaja(oId,oTalonario,oTicket);
			break;
			
			case "4":
				FncComprobanteRetencionRecibirXML(oId,oTalonario,oTicket);
			break;
			
			case "5":
				FncComprobanteRetencionRecibirCDR(oId,oTalonario,oTicket);
			break;





			case "7":
				FncComprobanteRetencionGenerarXML(oId,oTalonario,oTicket);
			break;
			
			case "8":
				FncComprobanteRetencionRecibirBajaZIP(oId,oTalonario,oTicket);
			break;
			
			case "9":
				FncComprobanteRetencionRecibirZIP(oId,oTalonario,oTicket);
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

}



/*
* COMPROBANTE DE RETENCIONCION v2
*/

function FncComprobanteRetencionGenerarXMLv2(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La factura ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	}
		
}

function FncComprobanteRetencionGenerarBajaXMLv2(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionGenerarBajaXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	
}


function FncComprobanteRetencionConsultarEstadoTicket(oId,oTalonario,oTicket){
	
	if(oTicket==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No se encontro ticket de SUNAT",
			callback: function(result){
				
			}
		});
				
	}else{
		
		FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionConsultarEstadoTicket.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);
	
	}
		
}


function FncComprobanteRetencionDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta!=""){
		
		FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionDescargarXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	}else{
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Ha ocurrido un error interno",
			callback: function(result){
				
			}
		});
		
	}
		
}

function FncComprobanteRetencionDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta!=""){
		
		FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionDescargarCDR.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	}else{
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Ha ocurrido un error interno",
			callback: function(result){
				
			}
		});
		
	}
	
}


function FncComprobanteRetencionEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta=="EXCEPCION"){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante no esta aprobado por SUNAT, tiene excepciones, no se puede enviar correo electronico",
			callback: function(result){
				
			}
		});
		
	}else if(oEnvioRespuesta=="RECHAZO"){
		
			dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante fue rechazado por SUNAT, no se puede enviar correo electronico",
			callback: function(result){
				
			}
		});
		
	}else if(oEnvioRespuesta=="APROBADO" || oEnvioRespuesta=="OBSERVADO"){
		
		FncPopUp('formularios/ComprobanteRetencion/FrmComprobanteRetencionEnviarCorreo.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	}else{
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Ha ocurrido un error interno",
			callback: function(result){
				
			}
		});
		
	}
	
		
}

function FncComprobanteRetencionSunatTareasv2(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){

	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar Comprobante \n 2 = Solicitar Baja \n 3 = Consultar estado de Ticket  \n 5 = Descargar Archivo XML \n 6 = Descargar Archivo CDR \n 7 = Enviar Correo Electronico", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				FncComprobanteRetencionGenerarXMLv2(oId,oTalonario,oTicket);		
			break;
			
			case "2":
				FncComprobanteRetencionGenerarBajaXMLv2(oId,oTalonario,oTicket);
			break;
			
			case "3":
				FncComprobanteRetencionConsultarEstadoTicket(oId,oTalonario,oTicket);
			break;
			
			//DESCARGAR ARCHIVOS
			case "5":
				FncComprobanteRetencionDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;

			case "6":
				FncComprobanteRetencionDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;
			
			//ENVIOS			
			case "7":
				FncComprobanteRetencionEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
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

}

function FncComprobanteRetencionSunatHistorialCargar(oId,oTa){

	tb_show("",'formularios/ComprobanteRetencion/FrmComprobanteRetencionSunatHistorial.php?Id='+oId+'&Ta='+oTa+'&placeValuesBeforeTB_=savedValues&TB_iframe=false&height=400&width=600&modal=false&Id='+oId+'&Ta='+oTa,this.rel);		

}





function FncComprobanteRetencionNotaCreditoCargar(oId,oTa){
	
	FncCargarVentanaFullv2("Simple","formularios/ComprobanteRetencion/DiaNotaCreditoListado.php","","","","","Id="+oId+"&Ta="+oTa)
	
}

function FncComprobanteRetencionNotaDebitoCargar(oId,oTa){

	FncCargarVentanaFullv2("Simple","formularios/ComprobanteRetencion/DiaNotaDebitoListado.php","","","","","Id="+oId+"&Ta="+oTa)
	
}