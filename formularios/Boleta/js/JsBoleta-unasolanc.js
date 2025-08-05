
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
	
	FncBoletaVerificarSinPago();

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
	
	
	
	var Tipo = prompt("Escoja el tipo de excel \n 1 = General \n 2 = Solo lista actual", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				
				document.getElementById("FrmListado").action = "formularios/Boleta/acc/AccBoletaGenerarExcel.php?F=1"
				document.getElementById("FrmListado").submit();
				document.getElementById("FrmListado").action = "#";
			
				$('#CmpSucursal').removeAttr('disabled');	
				
				$('#CmpSucursal').attr('disabled', true);
	
			break;
			
			case "2":
				//document.getElementById("FrmListado").action = "formularios/AsignacionVentaVehiculo/acc/AccAprobacionVentaVehiculoGenerarExcelFechaEntrega.php";
				
				document.getElementById("FrmListado").action = "formularios/Boleta/acc/AccBoletaGenerarExcel.php"
				document.getElementById("FrmListado").submit();
				document.getElementById("FrmListado").action = "#";
				
				$('#CmpSucursal').removeAttr('disabled');	
				
				$('#CmpSucursal').attr('disabled', true);

			break;
			
			//case "3":
//document.getElementById("FrmListado").action = "formularios/CotizacionVehiculo/acc/AccCotizacionGenerarExcel2.php";
//			break;
		
		}
		
	}
			
			

	
	


}

function FncListadoImprimir(){

	document.getElementById("FrmListado").action = "formularios/Boleta/FrmBoletaListadoImprimir.php"
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
						$("#FrmListado").attr("action","principal.php?Mod=NotaCredito&Form=Registrar&Ori=Boleta");
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
						$("#FrmListado").attr("action","principal.php?Mod=NotaDebito&Form=Registrar&Ori=Boleta");
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
* IMPRESION
*/


function FncBoletaImprmir(oId,oTalonario,oOpcion){
	
	if(oOpcion==null){
		oOpcion = "1";
	}

	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", oOpcion);
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

						FncPopUp('formularios/Boleta/FrmBoletaImprimir2.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}


function FncBoletaVistaPreliminar(oId,oTalonario,oOpcion){
	
	if(oOpcion==null){
		oOpcion = "1";
	}
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)",
oOpcion);
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario+'',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

						FncPopUp('formularios/Boleta/FrmBoletaImprimir2.php?Id='+oId+'&Ta='+oTalonario+'',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

						FncPopUp('formularios/Boleta/FrmBoletaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
				}
				
			}
			
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
function FncTallerPedidoVistaPreliminar(oId){
		
	FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

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

//function FncPagoBoletaCargarFormulario(oForm,oBoletaId,oBoletaTalonarioId){
//		
//	tb_show(this.title,'principal2.php?Mod=PagoBoleta&Form='+oForm+'&Dia=1&BolId='+oBoletaId+'&BtaId='+oBoletaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//
//}


function FncPagoBoletaCargarFormulario(oForm,oBoletaId,oBoletaTalonarioId){
	
	//tb_show(this.title,'principal2.php?Mod=PagoBoleta&Form='+oForm+'&Dia=1&FacId='+oBoletaId+'&FtaId='+oBoletaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=PagoBoleta&Form="+oForm,"true","true","savedValues","","Dia=1&BolId="+oBoletaId+'&BtaId='+oBoletaTalonarioId)
	
	
}

function FncVentaConcretadaCargarFormulario(oForm,oVentaConcretadaId){
		
	tb_show(this.title,'principal2.php?Mod=VentaConcretada&Form='+oForm+'&Dia=1&Id='+oVentaConcretadaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncFichaIngresoCargarFormulario(oForm,oFichaIngreso){
	
	tb_show(this.title,'principal2.php?Mod=FichaIngreso&Form='+oForm+'&Dia=1&Id='+oFichaIngreso+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncVentaDirectaCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncCotizacionVehiculoCargarFormulario(oForm,oCotizacionVehiculoId){
	
	tb_show(this.title,'principal2.php?Mod=CotizacionVehiculo&Form='+oForm+'&Dia=1&Id='+oCotizacionVehiculoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);

}

function FncOrdenVentaVehiculoCargarFormulario(oForm,oOrdenVentaVehiculoId){
	
	tb_show(this.title,'principal2.php?Mod=OrdenVentaVehiculo&Form='+oForm+'&Dia=1&Id='+oOrdenVentaVehiculoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);

}

//function FncClienteCargarFormulario(oForm,oClienteId){
//
//	tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//
//}
function FncClienteCargarFormulario(oForm,oClienteId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId)
	
}
/*
* TAREAS SUNAT
*/

function FncBoletaGenerarPDF(oId,oTalonario){
	
	FncPopUp('formularios/Boleta/FrmBoletaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
		
}


/*function FncBoletaConsultarEstadoTicket(oId,oTalonario,oTicket){
	
	if(oTicket==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No se encontro ticket de sunat",
			callback: function(result){
				
			}
		});
		
	}else{
		
		FncPopUp('formularios/Boleta/FrmBoletaConsultarEstadoTicket.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);
	
	}
	
		
}*/



function FncBoletaGenerarXML(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La boleta ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/Boleta/FrmBoletaGenerarXML.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=&EnviarSUNAT=',0,0,1,0,0,1,0,350,150);
	}
		
}


function FncBoletaProcesarXML(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La boleta ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/Boleta/FrmBoletaGenerarXML.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	}
		
}


/*function FncBoletaGenerarXML(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La boleta ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/Boleta/FrmBoletaGenerarXML.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	}
		
}
*/
function FncBoletaSolicitarBaja(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/Boleta/FrmBoletaGenerarBajaXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);

}

function FncBoletaRecibirZIP(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/Boleta/FrmBoletaRecibirZIP.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}

function FncBoletaRecibirBajaZIP(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/Boleta/FrmBoletaRecibirBajaZIP.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}


function FncBoletaRecibirXML(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/Boleta/FrmBoletaRecibirXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}

function FncBoletaRecibirCDR(oId,oTalonario,oTicket){
	
	FncPopUp('formularios/Boleta/FrmBoletaRecibirCDR.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);

}

//
//function FncBoletaSunatTareas(oId,oTalonario,oTicket){
//
//	//var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar comprobante \n 3 = Solicitar baja de comprobante", "1");			
//	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar comprobante \n 3 = Solicitar baja de comprobante \n 4 = Descargar XML \n 5 = Descargar CDR", "1");			
//	
//	if(Tipo !== null){
//		switch(Tipo.toUpperCase()){
//			case "1":	
////				FncBoletaGenerarXML(oId,oTalonario,oTicket);
//				FncBoletaProcesarXML(oId,oTalonario,oTicket);
//			break;
//			
//			case "3":
//				FncBoletaSolicitarBaja(oId,oTalonario,oTicket);
//			break;
//			
//			case "4":
//				FncBoletaRecibirXML(oId,oTalonario,oTicket);
//			break;
//			
//			case "5":
//				FncBoletaRecibirCDR(oId,oTalonario,oTicket);
//			break;
//			
//			
//			
//			case "7":
//				FncBoletaGenerarXML(oId,oTalonario,oTicket);
//			break;
//			
//			case "8":
//				FncBoletaRecibirBajaZIP(oId,oTalonario,oTicket);
//			break;
//			
//			case "9":
//				FncBoletaRecibirZIP(oId,oTalonario,oTicket);
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
//
//



/*
* FACTURACION v2
*/


function FncBoletaFirmarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT){
	
	//tb_show(this.title,'formularios/Factura/FrmFacturaFirmarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);
	tb_show(this.title,'formularios/Boleta/FrmBoletaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);
	
}


function FncBoletaGenerarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT){

//	if(oTicket!=""){
//		
//		dhtmlx.alert({
//			title:"Aviso",
//			type:"alert-error",
//			text:"La boleta ya se encuentra procesada",
//			callback: function(result){
//
//			}
//		});
//
//	}else{

//		FncPopUp('formularios/Boleta/FrmBoletaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT,0,0,1,0,0,1,0,350,150);
		tb_show(this.title,'formularios/Boleta/FrmBoletaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);

	//}

}

function FncBoletaGenerarBajaXMLv2(oId,oTalonario,oTicket){
	
	//FncPopUp('formularios/Boleta/FrmBoletaGenerarBajaXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	tb_show(this.title,'formularios/Boleta/FrmBoletaGenerarBajaXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1&EnviarSUNAT=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);
		
}


function FncBoletaConsultarCDR(oId,oTalonario){
	
	//FncPopUp('formularios/Boleta/FrmBoletaConsultarCDR.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,350,150);
	tb_show(this.title,'formularios/Boleta/FrmBoletaConsultarCDR.php?Id='+oId+'&Ta='+oTalonario+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);
		
}

/*
function FncBoletaConsultarEstadoTicket(oId,oTalonario,oTicket){
	
	if(oTicket==""){
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No se encontro ticket de SUNAT",
					callback: function(result){
						
					}
				});
				
	}else{
		
		FncPopUp('formularios/Boleta/FrmBoletaConsultarEstadoTicket.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket,0,0,1,0,0,1,0,350,150);
	
	}
	
		
}
*/

function FncBoletaDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta!=""){
		
		
		FncPopUp('formularios/Boleta/FrmBoletaDescargarXML.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	
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

function FncBoletaDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
	if(oEnvioRespuesta==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante aun no se ha enviado a SUNAT",
			callback: function(result){
				
			}
		});	
		
	}else if(oEnvioRespuesta!=""){
		
		
		FncPopUp('formularios/Boleta/FrmBoletaDescargarCDR.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
	
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


function FncBoletaEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){
	
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
		
		FncPopUp('formularios/Boleta/FrmBoletaEnviarCorreo.php?Id='+oId+'&Ta='+oTalonario+'&Ticket='+oTicket+'&Procesar=1',0,0,1,0,0,1,0,350,150);						
		
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

function FncBoletaReenviar(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.confirm("¿Realmente desea reenviar el elemento?", function(result){
			if(result==true){		
				
				//FncPopUp('formularios/Boleta/FrmBoletaProcesarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
				tb_show(this.title,'formularios/Boleta/FrmBoletaProcesarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);


			}else{
				
			}
		});
		
				
	}else{
		
		//FncPopUp('formularios/Boleta/FrmBoletaProcesarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
		tb_show(this.title,'formularios/Boleta/FrmBoletaProcesarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);


		
	}
		
}

function FncBoletaSunatTareasv2(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){

	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar Comprobante \n 2 = Solicitar Baja \n 3 = Consultar Estado CDR  \n 5 = Descargar Archivo XML \n 6 = Descargar Archivo CDR \n 7 = Enviar Correo Electronico", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				FncBoletaGenerarXMLv2(oId,oTalonario,oTicket,1,1);		
			break;
			
			case "2":
				FncBoletaGenerarBajaXMLv2(oId,oTalonario,oTicket);
			break;
			
			case "3":
				//FncBoletaConsultarEstadoTicket(oId,oTalonario,oTicket);
				FncBoletaConsultarCDR(oId,oTalonario);
			break;
			
			case "4":
				FncBoletaReenviar(oId,oTalonario,oTicket);
			break;
			
			
			//DESCARGAR ARCHIVOS
			case "5":
				FncBoletaDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;

			case "6":
				FncBoletaDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;
			
			//ENVIOS			
			case "7":
				FncBoletaEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;
			
			//GENERAR 
			case "8":
				FncBoletaGenerarXMLv2(oId,oTalonario,oTicket,2,2);		
			break;
			
			//FIRMAR
			case "9":
				FncBoletaFirmarXMLv2(oId,oTalonario,oTicket,3,2);		
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
/*




*/
function FncBoletaProcesarXMLv3(oId,oTalonario,oTicket){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La boleta ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/Boleta/FrmBoletaProcesarXMLv3.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
	}
		
}


function FncBoletaSunatTareasv3(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja){

	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Procesar Comprobante \n 2 = Solicitar Baja \n 3 = Consultar estado de Ticket  \n 4 = Reenviar Comprobante \n 5 = Descargar Archivo XML \n 6 = Descargar Archivo CDR \n 7 = Enviar Correo Electronico", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				FncBoletaProcesarXMLv3(oId,oTalonario,oTicket);		
			break;
			
			case "2":
				//FncBoletaGenerarBajaXMLv2(oId,oTalonario,oTicket);
			break;
			
			case "3":
				//FncBoletaConsultarEstadoTicket(oId,oTalonario,oTicket);
			break;
			
			case "4":
				//FncBoletaReenviar(oId,oTalonario,oTicket);
			break;
			
			
			//DESCARGAR ARCHIVOS
			case "5":
				//FncBoletaDescargarXML(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;

			case "6":
				//FncBoletaDescargarCDR(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
			break;
			
			//ENVIOS			
			case "7":
				FncBoletaEnviarCorreo(oId,oTalonario,oTicket,oEnvioCodigo,oEnvioRespuesta,oTicketBaja);
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
* RESUMEN DIARIO
*/
function FncBoletaEnviarResumenDiario(oSeleccionados){
	
	FncPopUp('formularios/Boleta/FrmBoletaGenerarResumenDiarioXML.php?Seleccionados='+oSeleccionados+'&Procesar=1',0,0,1,0,0,1,0,350,150);
		
}

function FncGenerarResumenXmlSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	var actualizar3 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		aux = seleccionados.split("#");
			
		$('input[type=checkbox]').each(function () {

			if($(this).attr('name')=="cmp_seleccionar[]"){
				if($(this).is(':checked')){
					
					console.log($(this).attr('ticket'));
					
					if($(this).attr('ticket')==""){
						actualizar2 = false;
						return false;
					}
				}
			}

		});	
		
		var fecha = "";
		
		$('input[type=checkbox]').each(function () {

			if($(this).attr('name')=="cmp_seleccionar[]"){
				if($(this).is(':checked')){
					
					if(fecha!=""){
						if($(this).attr('fecha') != fecha){
							actualizar3 = false;
							return false;
						}
					}

					fecha = $(this).attr('fecha');	
					
				}
			}

		});	
		
		if(actualizar){
			if(actualizar2){
				if(actualizar3){
					if(confirm("¿Realmente desea enviar resumen diario de los elementos seleccionados?")){
						console.log(seleccionados+"LOL");
						
						var nseleccionados = seleccionados.replace(/#/g, "@");
						
						FncBoletaEnviarResumenDiario(nseleccionados);
					}	
				}else{
					alert("Uno de los elementos no puede ser enviado en el resumen, no tiene fechas de emision iguales");		
				}
				
			}else{
				alert("Uno de los elementos no puede ser enviado en el resumen, no se encontro ticket");	
			}
		}else{
			alert("Solo puede escoger 5 elementos");
		}
		
	}

}




/*
* FORMULARIOS
*/

function FncBoletaSunatHistorialCargar(oId,oTa){

	tb_show("",'formularios/Boleta/FrmBoletaSunatHistorial.php?Id='+oId+'&Ta='+oTa+'&placeValuesBeforeTB_=savedValues&TB_iframe=false&height=400&width=600&modal=false&Id='+oId+'&Ta='+oTa,this.rel);		

}






function FncBoletaNotaCreditoCargar(oId,oTa){
	
	FncCargarVentanaFullv2("Simple","formularios/Boleta/DiaNotaCreditoListado.php","","","","","Id="+oId+"&Ta="+oTa);	

}

function FncBoletaNotaDebitoCargar(oId,oTa){

	FncCargarVentanaFullv2("Simple","formularios/Boleta/DiaNotaDebitoListado.php","","","","","Id="+oId+"&Ta="+oTa);
	
}



function FncTBCerrarFunncion(oModulo){
	
	console.log("FncTBCerrarFunncion");
	
	//FncFiltrar();
	
}





function FncBoletaVerificarSinPago(){

	var Sucursal = $("#CmpSucursal").val();
	
	if(Sucursal!=""){
				
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: 'formularios/Boleta/acc/AccBoletaVerificarSinPago.php',
			data: 'Sucursal='+Sucursal,
			success: function(Respuesta){
				
				if(Respuesta['Total']>0){
					/*
					
					
					Mensaje = Respuesta['Mensaje'];
					
					dhtmlx.alert({
						title:"Aviso",
						type:"alert-error",
						text: Mensaje,
						callback: function(result){
							
						}
					});*/
					
					var Mensaje = "";
					
					Mensaje = Respuesta['Mensaje'];
					
					dhtmlx.message({
						text:Mensaje,
						expire:1000
						
					});
					
					
	//tb_show("",'formularios/Boleta/FrmBoletaSunatHistorial.php?Id='+oId+'&Ta='+oTa+'&placeValuesBeforeTB_=savedValues&TB_iframe=false&height=400&width=600&modal=false&Id='+oId+'&Ta='+oTa,this.rel);		

					
					
				}else{
					
				}
				
			},
			error: function(InsBoleta){
				
			}
		});
				
				
	}
			
}