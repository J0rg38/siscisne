var Ventas = "1";

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

	$('#CmpSucursal').on('change', function() {
	
		FncPersonalesCargar();	
	
	});


	$("#CapListadoSubTotal").html($("#CmpListadoSubTotal").val());
	$("#CapListadoImpuesto").html($("#CmpListadoImpuesto").val());
	$("#CapListadoTotal").html($("#CmpListadoTotal").val());
	
		FncVerificarSinEntrega();
		
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


	var Tipo = prompt("Escoja el tipo de reporte \n 1 = General \n 2 = Formato Call Center \n 3 = Formato Ventas Simple", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				document.getElementById("FrmListado").action = "formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoGenerarExcel.php";
			break;
			
			case "2":
				document.getElementById("FrmListado").action = "formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoGenerarExcelCallCenter.php";
			break;
			
			case "3":
				document.getElementById("FrmListado").action = "formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoGenerarExcelVentaSimple.php";
			break;
			
			//case "3":
//document.getElementById("FrmListado").action = "formularios/CotizacionVehiculo/acc/AccCotizacionGenerarExcel2.php";
//			break;
		
		}
		
	}
			
			
	$('#CmpSucursal').removeAttr('disabled');	
	$('#CmpPersonal').removeAttr('disabled');	

	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";

	$('#CmpSucursal').attr('disabled', true);
	$('#CmpPersonal').attr('disabled', true);
	//location.reload();
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




function FncOrdenVentaVehiculoSolicitarAsignacionVehiculoSeleccionados(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){

		alert("No ha seleccionado ningun elemento.");
		
	}else{
		
		if(confirm("¿Realmente desea reenviar solicitud de Asignacion de VIN?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						if(
							$(this).attr('aprobacion1')=="1" ||
							$(this).attr('aprobacion1')=="3"
						){
							actualizar = false;
							return false;
						}
						
					}
				}

			});
			
			
			if(actualizar){
				
				$("#Acc").val("OrdenVentaVehiculoSolicitarAsignacionVIN");
				$("#FrmListado").submit();					
				
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser reenviado, verifique que se encuentre Rechazado.");
			}
		
			
		}
	}


}

/*
function FncOrdenVentaVehiculoSolicitarAprobacionVehiculoSeleccionados(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){

		alert("No ha seleccionado ningun elemento.");
		
	}else{
		
		if(confirm("¿Realmente desea reenviar solicitud de Aprobacion de Facturacion?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						if(
							$(this).attr('aprobacion2')=="1" ||
							$(this).attr('aprobacion2')=="3"
						){
							actualizar = false;
							return false;
						}
						

					}
				}

			});
			
			
			if(actualizar){
				
				$("#Acc").val("OrdenVentaVehiculoSolicitarAprobacionVIN");
				$("#FrmListado").submit();					
				
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser reenviado, verifique que se encuentre Rechazado.");
			}
		
			
		}
	}


}
*/

function FncOrdenVentaVehiculoEnviarFacturacionSeleccionados(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	var actualizar3 = true;
	var actualizar4 = true;
	
	if(seleccionados==""){

		alert("No ha seleccionado ningun elemento.");
		
	}else{
		
		if(confirm("¿Realmente desea ENVIAR la(s) Ord. de Venta de Vehiculo a FACTURACION?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						if(
							$(this).attr('estado')=="4" ||
							$(this).attr('estado')=="5"
						){
							actualizar = false;
							return false;
						}
						

					}
				}

			});
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
		
						if(
							$(this).attr('aprobacion1')=="2"
						){
							actualizar2 = false;
							return false;
						}
						
					}
				}

			});
			
/*			
//			286878193
93i9fm
*/			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
		
						if(
							$(this).attr('aprobacion1')=="3"
						){
							actualizar4 = false;
							return false;
						}
						
					}
				}

			});
			
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
		
						if(
							$(this).attr('pago')=="No"
						){
							actualizar3 = false;
							return false;
						}
						

					}
				}

			});
			
			if(actualizar){
				
				if(actualizar2){
					
					if(actualizar4){
							
						if(actualizar3){
							$("#Acc").val("OrdenVentaVehiculoEnviarFacturacion");
							$("#FrmListado").submit();					
						}else{
							alert("Uno o mas de los elementos seleccionados no tiene abonos registrados.");					
						}
						
					}else{
						alert("Uno o mas de los elementos seleccionados aun no tiene aprobacion (1).");		
					}
					
					
				}else{
					alert("Uno o mas de los elementos seleccionados ha sido rechazado.");					
				}
		
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus Estados.");
			}
		
			
		}
	}


}


function FncOrdenVentaVehiculoActualizarEmitidoSeleccionados(){
	
/*
1 Pendiente
3 Emitido
4 Por Facturar
5 Facturado
6 Anulado 
*/

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente deseas marcar a Listo la(s) Ord. de Venta de Vehiculo?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						if(
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="5" 
						){
							actualizar = false;
							return false;
						}
						

					}
				}

			});
			
			
			/*$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						
						if(
							$(this).attr('pago')=="No" 
							
						){
							actualizar2 = false;
							return false;
						}


					}
				}

			});*/


			if(actualizar){
				
				if(actualizar2){
					$("#Acc").val("OrdenVentaVehiculoActualizarEmitido");
					$("#FrmListado").submit();	
				}else{
					alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique que tenga abonos registrados.");
				}
				
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}

			
		}
	}


}



/*

function FncOrdenVentaVehiculoAnularEnvioFacturacionSeleccionados(){
	
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ANULAR ENVIO A FACTURACION de la(s) Ord. de Venta de Vehiculo?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						if(
							$(this).attr('estado')=="1" ||
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							
							$(this).attr('estado')=="5" 
							
							
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("OrdenVentaVehiculoVentaAnularEnvioFacturacion");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}


}

*/



function FncOrdenVentaVehiculoActualizarPendienteSeleccionados(){
	
/*
1 Pendiente
3 Emitido
4 Por Facturar
5 Facturado
6 Anulado 
*/


	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	var actualizar3 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea marcar como Pendiente la(s) Ord. de Venta de Vehiculo?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							
							$(this).attr('estado')=="4" ||
							$(this).attr('estado')=="5" ||
							$(this).attr('estado')=="6" 
							
							
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							$(this).attr('factura_estado')=="1" ||
							$(this).attr('factura_estado')=="5" ||
							$(this).attr('factura_estado')=="7" ||
							
							$(this).attr('boleta_estado')=="1"  ||
							$(this).attr('boleta_estado')=="5"  ||
							$(this).attr('boleta_estado')=="7" 
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							
							$(this).attr('estado')=="6" 
							
						){
							actualizar3 = false;
							return false;
						}

					}
				}

			});
				
				if(actualizar){
					
					if(actualizar2){	
					
						if(actualizar3){	
							
							$("#Acc").val("OrdenVentaVehiculoActualizarPendiente");
							$("#FrmListado").submit();
						
						}else{
							alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no se encuentre ya anulado anteriormente.");
						}
					
					
					}else{
						alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que su COMPROBANTE DE PAGO se encuentre previamente ANULADO por CONTABILIDAD.");
					}
					
					
				}else{
					alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no se ha enviado a FACTURAR.");
				}
			
			
		}
	}


}



function FncOrdenVentaVehiculoActualizarAnuladoSeleccionados(){

/*
1 Pendiente
3 Emitido
4 Por Facturar
5 Facturado
6 Anulado 
*/

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	var actualizar3 = true;
	var actualizar4 = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea marcar como Anulado la(s) Ord. de Venta de Vehiculo?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							
							$(this).attr('estado')=="4"  ||
							$(this).attr('estado')=="6" 
							
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							$(this).attr('factura_estado')=="1" ||
							$(this).attr('factura_estado')=="5" ||
							$(this).attr('factura_estado')=="7" ||
							
							
							$(this).attr('boleta_estado')=="1"  ||
							$(this).attr('boleta_estado')=="5"  ||
							$(this).attr('boleta_estado')=="7" 
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			
			/*
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							
							$(this).attr('estado')=="6" 
							
						){
							actualizar3 = false;
							return false;
						}

					}
				}

			});
			*/
	
	
			/*$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
		
						if(
						
							$(this).attr('aprobacion1')!="1" ||
							$(this).attr('aprobacion2')!="1" ||
							$(this).attr('aprobacion1')!="3" ||
							$(this).attr('aprobacion2')!="3"
							
						){
							actualizar4 = false;
							return false;
						}
						

					}
				}

			});*/


			
				if(actualizar){
					
					if(actualizar2){	
					
						//if(actualizar3){	
						
						
						if(actualizar4){	
							
							$("#Acc").val("OrdenVentaVehiculoActualizarAnulado");
							$("#FrmListado").submit();
						
						}else{
							alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no tenga aprobaciones de area registradas.");	
						}
							
						//}else{
						//	alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no se encuentre ya anulado anteriormente.");
						//}
					
					
					}else{
						alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que su COMPROBANTE DE PAGO se encuentre previamente ANULADO por CONTABILIDAD.");
					}
					
					
				}else{
					alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no se ha enviado a FACTURAR.");
				}
			
			
		}
	}


}



function FncOrdenVentaVehiculoSolicitarAprobacionAsignacionVINSeleccionados(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	var actualizar3 = true;
	
	if(seleccionados==""){
		
		alert("No ha seleccionado ningun elemento.");
		
	}else{
		if(confirm("¿Realmente desea SOLICITAR APROBACION de la(s) Ord. de Venta de Vehiculo?")){

			aux = seleccionados.split("#");
			console.log(aux[0]);
			if((aux.length-1)>1){
				var actualizar = false;			
			}
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							
							$(this).attr('estado')=="1" ||
							//$(this).attr('estado')=="3" ||
							$(this).attr('estado')=="5" ||
							$(this).attr('estado')=="6" 
							
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});

			
				
				if(actualizar){
					
					if(actualizar2){	
					
						FncOrdenVentaVehiculoSolicitarAprobacionVIN(aux[1]);
						
					}else{
						alert("Uno o mas de los elementos seleccionados no se puede solicitar aprobacion, debido a que no se encuentra en estado Emitido.");
					}
					
					
				}else{
					alert("Solo puede escoger un elemento");
				}
			
			
		}
	}


}


/*
* PAGOS
*/

function FncGenerarPago(oId){

	var Tipo = prompt("Escoja el tipo de registro \n 1 = Abono (Voucher de Pago, Transferencia, etc)  \n 2 = Orden de Cobro (Recibos de Caja) \n 3 = Credito", "1");

	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":

				FncAbonoCargarFormulario('Registrar',oId);

			break;
			
			case "2":

				FncOrdenCobroCargarFormulario('Registrar',oId);

			break;
			
				case "3":

				FncCreditoCargarFormulario('Registrar',oId);

			break;
			
			default:
				alert("Opcion no encontrada");
			break;
		
		}
		
	}	

}

function FncOrdenCobroCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form=OrdenCobro'+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncAbonoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form=Abono'+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncCreditoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form=Credito'+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}



function FncPagoOrdenVentaVehiculoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form='+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

	
function FncTBCerrarFunncion(oModulo){
	
	console.log("FncTBCerrarFunncion");
	
	FncFiltrar();
	
}

//function FncOrdenVentaVehiculoLlamadaCargarFormulario(oOrdenVentaVehiculoId){
//
//	FncCargarVentana("OrdenVentaVehiculo","Llamada",oOrdenVentaVehiculoId);
//	
//}


/*
* IMPRESION
*/

function FncImprmir(oId){

	//var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Declaracion Jurada\n 3 = Planes de Mantenimiento\n 4 = ROP\n 5 = Acta de Entrega\n 6 = Autorizacion de uso de datos personales  ", "1");
//	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Carta Responsabilidad (CR) \n 3 = Carta Compromiso (CC) \n 4 = Hoja de Pedido (HP)", "1");
//	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Carta Responsabilidad (CR) \n 3 = Carta Compromiso (CC) \n 4 = Acta de Entrega (AE)", "1");
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Carta Responsabilidad (CR) \n 3 = Carta Compromiso (CC) \n 4 = Acta de Entrega (AE) \n 5 = Declaracion Juarada (MP1)\n 6 = Declaracion Juarada (MP2)\n 7 = Ficha Inamtriculacion (FI)\n 8 = Ficha Inmatriculacion 2 (FI2) \n 9 = Carta Poder AAP \n 10 = Carta Poder SUNARP \n 11 = Anexo Placa Particular \n 12 = D.J. Placa Taxi", "1");
	
	
	if(Tipo !== null){
		
		switch(Tipo.toUpperCase()){
			
			case "1":
			
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirOV.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
			
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirCR.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
				
			/*	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = DJ Con membrete\n  2 = DJ sin Membrete  ", "2");
						
				if(Tipo !== null){
					
					switch(Tipo.toUpperCase()){
						case "1":
						
							FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirDJ.php?M=1&Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
						break;
						
						case "2":
				
							FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirCC.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
						break;		
				
					}
					
				}*/
	
				//FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirDJ.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
			case "3":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirCC.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
		
			case "4":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirAE.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
				
			case "5":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirMP1.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "6":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirMP2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
				case "7":
	
				FncPopUp('formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoGenerarExcelFI1.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "8":
	
				FncPopUp('formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoGenerarExcelFI2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "9":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirAAP.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "10":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirSUNARP.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "11":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirAnexoPlacaParticular.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "12":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPlacaTaxi.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
		}
		
	}

}


function FncVistaPreliminar(oId){
	
	//var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Carta Responsabilidad (CR) \n 3 = Carta Compromiso (CC) \n 4 = Hoja de Pedido (HP)", "1");
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Carta Responsabilidad (CR) \n 3 = Carta Compromiso (CC) \n 4 = Acta de Entrega (AE) \n 5 = Declaracion Juarada (MP1)\n 6 = Declaracion Juarada (MP2)\n 7 = Ficha Inamtriculacion (FI)\n 8 = Ficha Inmatriculacion 2 (FI2) \n 9 = Carta Poder AAP \n 10 = Carta Poder SUNARP \n 11 = Anexo Placa Particular \n 12 = D.J. Placa Taxi", "1");
		
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirOV.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
			
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirCR.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
				
			/*	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = DJ Con membrete\n  2 = DJ sin Membrete  ", "2");
						
				if(Tipo !== null){
					
					switch(Tipo.toUpperCase()){
						case "1":
						
							FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirDJ.php?M=1&Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
						break;
						
						case "2":
				
							FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirCC.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
						break;		
				
					}
					
				}*/
	
				//FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirDJ.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
			case "3":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirCC.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
		
			case "4":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirAE.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "5":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirMP1.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "6":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirMP2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "7":
	
				FncPopUp('formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoGenerarExcelFI1.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
		case "8":
	
				FncPopUp('formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoGenerarExcelFI2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "9":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirAAP.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "10":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirSUNARP.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "11":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirAnexoPlacaParticular.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "12":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPlacaTaxi.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
		}
		
	}

}




/*
* VISTA PRELIMINAR OTROS
*/



function FncFacturaVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				FncPopUp('formularios/Factura/FrmFacturaImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "3":
	
				FncPopUp('formularios/Factura/FrmFacturaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
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
* FORMULARIOS
*/
function FncEncuestaCargarFormulario(oForm,oEncuestaId,oOrdenVentaVehiculoId){//tb_show(this.title,'principal2.php?Mod=Garantia&Form=SeguimientoCliente&Dia=1&Id='+oGarantiaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&modal=true',this.rel);	
	//FncCargarVentana("FichaIngreso","SeguimientoCliente",oFichaIngresoId);//CARGADO DESDE FICHA INGRESO
	FncCargarVentanaFull("Encuesta",oForm,'Id='+oEncuestaId+'&OrdenVentaVehiculoId='+oOrdenVentaVehiculoId+'&Tipo=VENTA')
	
}

function FncEntregaVentaVehiculoCargarFormulario(oMod,oForm,oOrdenVentaVehiculoId,oFecha){
	
	if(oFecha!="" &&  oFecha!="00/00/0000" && oFecha!="null"){
		
		dhtmlx.confirm("Esta orden ya tiene fecha de entrega "+oFecha+". ¿Deseas cambiar la fecha previamente ingresada?", function(result){
			if(result==true){		
				
				FncCargarVentanaFull(oMod,oForm,'&OvvId='+oOrdenVentaVehiculoId+'&Origen=OrdenVentaVehiculo');
				
			}else{
				
			}
		});
		
	}else{
		
		FncCargarVentanaFull(oMod,oForm,'&OvvId='+oOrdenVentaVehiculoId+'&Origen=OrdenVentaVehiculo');
		
		
	}
	
	
	
	
}

function FncClienteCargarFormulario(oForm,oClienteId){

	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId);

}

function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){

	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}

function FncOrdenVentaVehiculoCargarFormulario(oForm,oOrdenVentaVehiculoId){
		
	FncCargarVentana("OrdenVentaVehiculo",oForm,oOrdenVentaVehiculoId);

}

/*
* OTRAS ACCIONES
*/


function FncOrdenVentaVehiculoSolicitarAprobacionVIN(oId){
	
	if(oId==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No se encontro Id de la Orden de Venta de Vehiculo",
			callback: function(result){
				
			}
		});	
		
		
	}else{
		
		FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoSolicitarAprobacionVIN.php?Id='+oId,0,0,1,0,0,1,0,350,150);						
		
	}
	
		
}




function FncOrdenVentaVehiculoSolicitarVIN(oId,oVIN,oLineaCreditoActiva){
	
	if(oVIN == ""){
			
		window.location = "principal.php?Mod=OrdenVentaVehiculo&Form=SolicitarVIN&Id="+oId;	

	}else{
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Esta orden ya tiene VIN asignado",
					callback: function(result){

					}
				});	
	}
	
}





function FncVerificarSinEntrega(){

	var Personal = $("#CmpPersonal").val();
	
	if(Personal!=""){
				
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoVerificarSinEntrega.php',
			data: 'Personal='+Personal,
			success: function(Respuesta){
				
				if(Respuesta['Total']>0){
					
					var Mensaje = "";
					
					Mensaje = Respuesta['Mensaje'];
					
					dhtmlx.alert({
						title:"Aviso",
						type:"alert-error",
						text: Mensaje,
						callback: function(result){
							
						}
					});
					
				}else{
					
				}
				
			},
			error: function(InsVehiculoIngreso){
				
			}
		});
				
				
	}
			
}
