/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$().ready(function() {

	$("#Fil").focus();
	$("#Fil").select();

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

	$('input[type=checkbox]').each(function () {
		
		if($(this).is(':checked')){
			if($(this).attr('name')=="cmp_seleccionar[]"){
				seleccionados = seleccionados + '#'+ $(this).val();
			}
		}
		
	});
		
	$("#cmp_seleccionados").val(seleccionados);

}

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
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ELIMINAR los elementos seleccionados?")){
			$("#Acc").val("Eliminar");
			$("#FrmListado").submit();	
		}
	}
	
}






function FncListadoImprimir(){
	$("#FrmListado").attr("action","formularios/GuiaRemision/FrmGuiaRemisionListadoImprimir.php");
	$("#FrmListado").attr("target","_blank");
	$("#FrmListado").submit();	
	$("#FrmListado").attr("action","#");
	$("#FrmListado").attr("target","_self");
}


function FncGenerarExcel(){
	$("#FrmListado").attr("action","formularios/GuiaRemision/acc/AccGuiaRemisionGenerarExcel.php");
	$("#FrmListado").submit();	
	$("#FrmListado").attr("action","#");
}




function FncCortarSeleccionados(){
	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
	
		aux = seleccionados.split("#");
			
		if(aux.length<3){

			if(confirm("¿Realmente desea CORTAR los elementos seleccionados? \n NOTA: Una vez realizado el corte no habra forma de restaurarlo.")){

				var Cantidad = prompt("Ingrese la cantidad de items que quiere que existan por cada GUIA DE REMISION generada", "10");

				if(Cantidad != "" && Cantidad != null){
					$("#Can").val(Cantidad);					
					$("#Acc").val("Cortar");
					$("#FrmListado").submit();
				}
			}

		}else{
			alert("Solo se pueden CORTAR una GUIA DE REMISION.");
		}
		
	}
}







function FncGuiaRemisionImprmir(oId,oTalonario){
	
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


function FncGuiaRemisionVistaPreliminar(oId,oTalonario){

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


function FncGuiaRemisionGenerarPDF(oId,oTalonario){
	
	FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
		
}





/*
* FACTURACION v2
*/

function FncGuiaRemisionGenerarXMLv2(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La boleta ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	}
		
}

function FncGuiaRemisionGenerarBajaXMLv2(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionGenerarBajaXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	
}


function FncGuiaRemisionConsultarEstadoTicket(oId,oTalonario,oTicket){
	
	if(oTicket==""){
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No se encontro ticket de SUNAT",
					callback: function(result){
						
					}
				});
				
	}else{
		
		FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionConsultarEstadoTicket.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);
	
	}
	
		
}


function FncGuiaRemisionDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta!=""){
		
		
		FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionDescargarXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	
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

function FncGuiaRemisionDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta!=""){
		
		
		FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionDescargarCDR.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	
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


function FncGuiaRemisionEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
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
		
		FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionEnviarCorreo.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	
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

function FncGuiaRemisionSunatTareasv2(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){

	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar Comprobante \n 2 = Solicitar Baja \n 3 = Consultar estado de Ticket  \n 5 = Descargar Archivo XML \n 6 = Descargar Archivo CDR \n 7 = Enviar Correo Electronico", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				FncGuiaRemisionGenerarXMLv2(oId,oTalonario,oTicket);		
			break;
			
			case "2":
				FncGuiaRemisionGenerarBajaXMLv2(oId,oTalonario,oTicket);
			break;
			
			case "3":
				FncGuiaRemisionConsultarEstadoTicket(oId,oTalonario,oTicket);
			break;
			
			//DESCARGAR ARCHIVOS
			case "5":
				FncGuiaRemisionDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;

			case "6":
				FncGuiaRemisionDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;
			
			//ENVIOS			
			case "7":
				FncGuiaRemisionEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
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

function FncGuiaRemisionSunatHistorialCargar(oId,oTa){

	tb_show("",'formularios/GuiaRemision/FrmGuiaRemisionSunatHistorial.php?Id='+oId+'&Ta='+oTa+'&placeValuesBeforeTB_=savedValues&TB_iframe=false&height=400&width=600&modal=false&Id='+oId+'&Ta='+oTa,this.rel);		

}


