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


$('#FrmListado').on('submit', function() {
		
		$('#CmpSucursal').removeAttr('disabled');		
		
		return true;

	});


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

function FncGenerarExcel(){


	var Tipo = prompt("Escoja el tipo de reporte \n 1 = Resumido\n 2 = Detallado", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
	document.getElementById("FrmListado").action = "formularios/VentaDirecta/acc/AccVentaDirectaGenerarExcel.php";
					break;
					
					case "2":
	document.getElementById("FrmListado").action = "formularios/VentaDirecta/acc/AccVentaDirectaGenerarExcelDetallado.php";
					break;
				
				}
				
			}
			
			

	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
	

}


function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/VentaDirecta/FrmVentaDirectaListadoImprimir.php"
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
			$("#Acc").val("Eliminar");
			$("#FrmListado").submit();	
		}
	}
	
}






function FncImprmir(oId){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Orden de Venta \n 2 = Hoja de Despacho", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/VentaDirecta/FrmVentaDirectaDespachoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}
//			
			

}


function FncVistaPreliminar(oId){
	
	
		var Tipo = prompt("Escoja el tipo de impresion \n 1 = Orden de Venta \n 2 = Hoja de Despacho", "1");
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir.php?Id='+oId+'',0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

						FncPopUp('formularios/VentaDirecta/FrmVentaDirectaDespachoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
					break;
				
				}
				
			}
		

}


function FncEnviarCotizacionProductoContabilidadSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE VENTA a CONTABILIDAD de los elementos seleccionados?")){

			$('input[type=checkbox]').each(function () {
				//2,3,4,5,6,7,8,9
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if($(this).attr('factura')=="Si" || $(this).attr('estado')=="1" ){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("EnviarVentaDirectaContabilidad");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados estan no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}









function FncActualizarEstadoAnuladoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea marcar como ANULADO las ORDENES DE VENTA seleccionadas?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
							$(this).attr('estado')=="1" //||
							//$(this).attr('guia_remision')=="Si" ||
							//$(this).attr('factura')=="Si" ||
							//$(this).attr('boleta')=="Si"

						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("VentaDirectaAnulado");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}

}





function FncActualizarEstadoRealizadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea marcar como REALIZADO las ORDENES DE VENTA seleccionadas?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
							$(this).attr('estado')=="3" 
						
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("VentaDirectaRealizado");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}

}






function FncActualizarEstadoPendienteSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea marcar como PENDIENTE las ORDENES DE VENTA seleccionadas?")){
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
							$(this).attr('estado')=="1" ||
							$(this).attr('estado')=="6"
							
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("VentaDirectaPendiente");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}

}


/*
* PAGOS
*/

function FncOrdenCobroCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoVentaDirecta&Form=OrdenCobro'+oForm+'&Dia=1&VdiId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncAbonoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoVentaDirecta&Form=Abono'+oForm+'&Dia=1&VdiId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncPagoVentaDirectaCargarFormulario(oForm,oVentaDirectaId){
	
	//tb_show(this.title,'principal2.php?Mod=PagoVentaDirecta&Form='+oForm+'&Dia=1&VdiId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables)
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=PagoVentaDirecta&Form="+oForm,"true","true","savedValues","","Dia=1&VdiId="+oVentaDirectaId);
	
}


function FncClienteCargarFormulario(oForm,oClienteId){

	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId)
	
}

function FncCotizacionProductoCargarFormulario(oForm,oCotizacionProductoId){

	tb_show(this.title,'principal2.php?Mod=CotizacionProducto&Form='+oForm+'&Dia=1&Id='+oCotizacionProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncTBCerrarFunncion(oModulo){

}






function FncGenerarPDF(oId){
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Orden Venta c/ Codigo) \n 2 = Formato 2 (Orden Venta s/ Codigo) \n 3 = Formato 3 (Guia de Salida)", "1");	
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/VentaDirecta/acc/AccVentaDirectaGenerarPDF.php?Id='+oId+'&ImprimirCodigo=1&ImprimirPrecio=1',0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

FncPopUp('formularios/VentaDirecta/acc/AccVentaDirectaGenerarPDF.php?Id='+oId+'&ImprimirPrecio=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/VentaDirecta/acc/AccVentaDirectaGenerarPDF.php?Id='+oId+'&GuiaSalida=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
				
				}
				
			}
		

}





function FncGenerarPago(oId){

		var Tipo = prompt("Escoja el tipo de registro \n 1 = Abono (Voucher de Pago, Transferencia, etc)  \n 2 = Orden de Cobro (Recibos de Caja) ", "1");

	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":

				FncAbonoCargarFormulario('Registrar',oId);

			break;
			
			case "2":

				FncOrdenCobroCargarFormulario('Registrar',oId);

			break;
			
			default:
				alert("Opcion no encontrada");
			break;
		
		}
		
	}	

}

function FncVentaDirectaEnviarMensajeTexto(oVentaDirectaId){
	
	FncPopUp('formularios/VentaDirecta/FrmVentaDirectaEnviarMensajeTexto.php?VdiId='+oVentaDirectaId,0,0,1,0,0,1,0,300,200);
	
	
}





function FncGenerarPedidoCompra(oId){

	var Tipo = prompt("Escoja el tipo de registro \n 1 = Pedido a Otros Proveedores  \n 2 = Pedido a GM", "1");

	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
	
				window.location.href = "principal.php?Mod=PedidoCompraSimple&Form=Registrar&Origen=VentaDirecta&VdiId="+oId;
			
			break;
			
			case "2":

				window.location.href = "principal.php?Mod=PedidoCompra&Form=Registrar&Origen=VentaDirecta&VdiId="+oId;
				
			break;
			
			default:
				alert("Opcion no encontrada");
			break;
		
		}
		
	}	

}



function FncTBCerrarFunncion(oModulo){
	
	console.log("FncTBCerrarFunncion");
	
FncFiltrar();
}