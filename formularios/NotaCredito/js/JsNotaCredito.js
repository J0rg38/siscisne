/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$().ready(function() {
	$("#CapListadoSubTotal").html($("#CmpListadoSubTotal").val());
	$("#CapListadoImpuesto").html($("#CmpListadoImpuesto").val());
	$("#CapListadoTotal").html($("#CmpListadoTotal").val());
	
	
});


$().ready(function() {

	$("#Fil").focus();
	$("#Fil").select();


$('#FrmListado').on('submit', function() {
		
		$('#CmpSucursal').removeAttr('disabled');		
		
		return true;

	});

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
	//var indice = 0;
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('name')=="cmp_seleccionar[]"){

			var indice = $(this).attr('indice');
			
			if($(this).is(':checked')){
				seleccionados = seleccionados + '#'+ $(this).val();
				$('#Fila_'+indice).css('background-color', '#CEE7FF');
			}else{
				$('#Fila_'+indice).css('background-color', '#FFFFFF');				
			}
			
		}
		//indice = indice + 1;
	});
	
	$("#cmp_seleccionados").val(seleccionados);
}//Acciones - Borrar






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



function FncGenerarExcel(){
	document.getElementById("FrmListado").action = "formularios/NotaCredito/acc/AccNotaCreditoGenerarExcel.php"
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
}

function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/NotaCredito/FrmNotaCreditoListadoImprimir.php"
	document.getElementById("FrmListado").target = '_blank';
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
	document.getElementById("FrmListado").target = '_self';
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
			
			$('input[type=checkbox]').each(function () {
			
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						
						if($(this).attr('respuesta')=="0001" || $(this).attr('respuesta')=="P101"){
							eliminar = false;
							return false;
						}
						
						
						
						
					}
				}
			
			});	
				
			if(eliminar){
				$("#Acc").val("Eliminar");
				$("#FrmListado").submit();	
			}else{
				alert("Uno de los elementos no puede ser eliminado, ya fue procesado por sunat");
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
						$("#FrmListado").attr("action","principal.php?Mod=NotaDebito&Form=Registrar&Ori=NotaCredito");
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





















function FncImprmir(oId,oTalonario){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato A4 \n 3 = Formato PDF", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/NotaCredito/FrmNotaCreditoImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}


function FncVistaPreliminar(oId,oTalonario){
	
		var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato A4 \n 3 = Formato PDF", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/NotaCredito/FrmNotaCreditoImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarPDF.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}

function FncClienteCargarFormulario(oForm,oClienteId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId)
	
}













/*
* SUNAT
*/

function FncNotaCreditoGenerarPDF(oId,oTalonario){
	
	FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
		
}

/*function FncNotaCreditoConsultarEstadoTicket(oId,oTalonario,oTicket){
	
	if(oTicket==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No se encontro ticket de sunat",
			callback: function(result){
				
			}
		});
		
	}else{
		
		FncPopUp('formularios/NotaCredito/FrmNotaCreditoConsultarEstadoTicket.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);
	
	}
	
		
}
*/

function FncNotaCreditoGenerarXML(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante ya se encuentra procesado",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarXML.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=&EnviarSUNAT=',0,0,1,0,0,1,0,350,150);
	}
		
}


function FncNotaCreditoProcesarXML(oId,oTalonario,oTicket){
	
	console.log("test");
	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante ya se encuentra procesado",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarXML.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	}
		
}

function FncNotaCreditoSolicitarBaja(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarBajaXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	
}

function FncNotaCreditoRecibirZIP(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/NotaCredito/FrmNotaCreditoRecibirZIP.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}

function FncNotaCreditoRecibirBajaZIP(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/NotaCredito/FrmNotaCreditoRecibirBajaZIP.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}

function FncNotaCreditoRecibirXML(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/NotaCredito/FrmNotaCreditoRecibirXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}

//
//function FncNotaCreditoSunatTareas(oId,oTalonario,oTicket){
//
//	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar comprobante \n 2 = Consultar estado de ticket \n 3 = Solicitar baja de comprobante", "1");			
//	
//	if(Tipo !== null){
//		switch(Tipo.toUpperCase()){
//			case "1":	
//				FncNotaCreditoProcesarXML(oId,oTalonario,oTicket);
//			break;
//									
//			case "3":
//				FncNotaCreditoSolicitarBaja(oId,oTalonario,oTicket);
//			break;
//			
//			case "4":
//				FncNotaCreditoRecibirXML(oId,oTalonario,oTicket);
//			break;
//			
//
//			case "7":
//				FncNotaCreditoGenerarXML(oId,oTalonario,oTicket);
//			break;
//			
//			case "8":
//				FncNotaCreditoRecibirBajaZIP(oId,oTalonario,oTicket);
//			break;
//			
//			case "9":
//				FncNotaCreditoRecibirZIP(oId,oTalonario,oTicket);
//			break;
//			
//			default:
//					dhtmlx.alert({
//						title:"Aviso",
//						type:"alert-error",
//						text:"No escogio una tarea",
//						callback: function(result){
//						
//						}
//					});
//			break;
//		
//		}
//		
//	}
//
//}





/*
* FACTURACION v2
*/

function FncNotaCreditoFirmarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT){
	
	//tb_show(this.title,'formularios/Factura/FrmFacturaFirmarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);
	tb_show(this.title,'formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);
	
}



function FncNotaCreditoGenerarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT,oValidar){
	
	if(oValidar){
		
		if(oTicket!=""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"El comprobante ya se encuentra procesado",
				callback: function(result){
					
				}
			});
					
		}else{
			//FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
			//FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT,0,0,1,0,0,1,0,350,150);
			tb_show(this.title,'formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);

		}
		
	}else{
		
		//FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT,0,0,1,0,0,1,0,350,150);
		tb_show(this.title,'formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);

		
	}
	
		
}

function FncNotaCreditoGenerarBajaXMLv2(oId,oTalonario,oTicket){
	
	//FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarBajaXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	tb_show(this.title,'formularios/NotaCredito/FrmNotaCreditoGenerarBajaXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);

}

function FncNotaCreditoConsultarCDR(oId,oTalonario){
	
	//FncPopUp('formularios/NotaCredito/FrmNotaCreditoConsultarCDR.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,350,150);
	tb_show(this.title,'formularios/NotaCredito/FrmNotaCreditoConsultarCDR.php?Id='+oId+'&Ta='+oTalonario+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);

}

/*function FncNotaCreditoConsultarEstadoTicket(oId,oTalonario,oTicket){
	
	if(oTicket==""){
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No se encontro ticket de SUNAT",
					callback: function(result){
						
					}
				});
				
	}else{
		
		FncPopUp('formularios/NotaCredito/FrmNotaCreditoConsultarEstadoTicket.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);
	
	}
	
		
}
*/

function FncNotaCreditoDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta!=""){
		
		
		FncPopUp('formularios/NotaCredito/FrmNotaCreditoDescargarXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	
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

function FncNotaCreditoDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta!=""){
		
		
		FncPopUp('formularios/NotaCredito/FrmNotaCreditoDescargarCDR.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	
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


function FncNotaCreditoEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
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
		
		FncPopUp('formularios/NotaCredito/FrmNotaCreditoEnviarCorreo.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	
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

function FncNotaCreditoSunatTareasv2(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){

	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar Comprobante \n 2 = Solicitar Baja \n 3 = Consultar Estado CDR  \n 5 = Descargar Archivo XML \n 6 = Descargar Archivo CDR \n 7 = Enviar Correo Electronico", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				FncNotaCreditoGenerarXMLv2(oId,oTalonario,oTicket,1,1,true);		
			break;
			
			case "11":
				FncNotaCreditoGenerarXMLv2(oId,oTalonario,oTicket,1,1,false);		
			break;
			
			case "2":
				FncNotaCreditoGenerarBajaXMLv2(oId,oTalonario,oTicket);
			break;
			
			case "3":
				//FncNotaCreditoConsultarEstadoTicket(oId,oTalonario,oTicket);
				FncNotaCreditoConsultarCDR(oId,oTalonario);
			break;
			
			//DESCARGAR ARCHIVOS
			case "5":
				FncNotaCreditoDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;

			case "6":
				FncNotaCreditoDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;
			
			//ENVIOS			
			case "7":
				FncNotaCreditoEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;
			
			
				//GENERAR 
			case "8":
				FncNotaCreditoGenerarXMLv2(oId,oTalonario,oTicket,2,2);		
			break;
			
				//FIRMAR
			case "9":
				FncNotaCreditoFirmarXMLv2(oId,oTalonario,oTicket,3,2);		
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
* FACTURACION v3
*/

/*function FncNotaCreditoProcesarXMLv3(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La boleta ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/NotaCredito/FrmNotaCreditoProcesarXMLv3.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	}
		
}*/

/*
function FncNotaCreditoSunatTareasv3(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){

	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar Comprobante \n 2 = Solicitar Baja \n 3 = Consultar estado de Ticket  \n 4 = Reenviar Comprobante \n 5 = Descargar Archivo XML \n 6 = Descargar Archivo CDR \n 7 = Enviar Correo Electronico", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				FncNotaCreditoProcesarXMLv3(oId,oTalonario,oTicket);		
			break;
			
			case "2":
				//FncNotaCreditoGenerarBajaXMLv2(oId,oTalonario,oTicket);
			break;
			
			case "3":
				//FncNotaCreditoConsultarEstadoTicket(oId,oTalonario,oTicket);
			break;
			
			case "4":
				//FncNotaCreditoReenviar(oId,oTalonario,oTicket);
			break;
			
			
			//DESCARGAR ARCHIVOS
			case "5":
				//FncNotaCreditoDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;

			case "6":
				//FncNotaCreditoDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;
			
			//ENVIOS			
			case "7":
				FncNotaCreditoEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
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
*/





function FncNotaCreditoSunatHistorialCargar(oId,oTa){

	tb_show("",'formularios/NotaCredito/FrmNotaCreditoSunatHistorial.php?Id='+oId+'&Ta='+oTa+'&placeValuesBeforeTB_=savedValues&TB_iframe=false&height=400&width=600&modal=false&Id='+oId+'&Ta='+oTa,this.rel);		

}

