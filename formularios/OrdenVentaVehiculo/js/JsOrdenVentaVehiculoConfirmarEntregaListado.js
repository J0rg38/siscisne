


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


//	var Tipo = prompt("Escoja el tipo de reporte \n 1 = Resumido\n 2 = Detallado", "1");
//			
//			if(Tipo !== null){
//				switch(Tipo.toUpperCase()){
//					case "1":
	document.getElementById("FrmListado").action = "formularios/CotizacionVehiculo/acc/AccCotizacionGenerarExcel.php";
//					break;
//					
//					case "2":
//	document.getElementById("FrmListado").action = "formularios/CotizacionVehiculo/acc/AccCotizacionGenerarExcel2.php";
//					break;
//				
//				}
//				
//			}
			
			

	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
	

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





function FncOrdenVentaVehiculoEnviarFacturacionSeleccionados(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
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
							$(this).attr('aprobacion1')!="1" ||
							$(this).attr('aprobacion2')!="1"
						){
							actualizar2 = false;
							return false;
						}
						

					}
				}

			});
			
			if(actualizar){
				
				if(actualizar2){
					$("#Acc").val("OrdenVentaVehiculoEnviarFacturacion");
					$("#FrmListado").submit();					
				}else{
					alert("Uno o mas de los elementos seleccionados no tiene aprobacion..");					
				}
		
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
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

			if(actualizar){
				$("#Acc").val("OrdenVentaVehiculoActualizarEmitido");
				$("#FrmListado").submit();	
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
	
	
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
		
						if(
							$(this).attr('aprobacion1')!="1" ||
							$(this).attr('aprobacion2')!="1"
						){
							actualizar4 = false;
							return false;
						}
						

					}
				}

			});


			
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

function FncOrdenCobroCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form=OrdenCobro'+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncAbonoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form=Abono'+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncPagoOrdenVentaVehiculoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form='+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

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

//function FncOrdenVentaVehiculoLlamadaCargarFormulario(oOrdenVentaVehiculoId){
//
//	FncCargarVentana("OrdenVentaVehiculo","Llamada",oOrdenVentaVehiculoId);
//	
//}

function FncGenerarPago(oId){

	var Tipo = prompt("Escoja el tipo de registro \n 1 = Abono  \n 2 = Orden de Cobro", "1");

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








function FncImprmir(oId){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Declaracion Jurada\n 3 = Planes de Mantenimiento\n 4 = ROP\n 5 = Acta de Entrega\n 6 = Autorizacion de uso de datos personales  ", "1");

	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = DJ Con membrete\n  2 = DJ sin Membrete  ", "2");
						
				if(Tipo !== null){
					
					switch(Tipo.toUpperCase()){
						case "1":
						
							FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirDJ.php?M=1&Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
						break;
						
						case "2":
				
							FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirDJ.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
						break;		
				
					}
					
				}
				
			break;
			
			case "3":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPM.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "4":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirROP.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "5":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirAE.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "6":
	
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirRDP.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
		}
		
	}

}


function FncVistaPreliminar(oId){
	
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Carta Responsabilidad (CR) \n 3 = Carta Compromiso (CC) ", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
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
			
		
	
		}
		
	}

}




/*
* VISTA PRELIMINAR
*/

function FncFacturaVistaPreliminar(oId,oTalonario){

	FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncBoletaVistaPreliminar(oId,oTalonario){

	FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

}

/*
* FORMULARIOS
*/
function FncEncuestaCargarFormulario(oForm,oEncuestaId,oOrdenVentaVehiculoId){//tb_show(this.title,'principal2.php?Mod=Garantia&Form=SeguimientoCliente&Dia=1&Id='+oGarantiaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&modal=true',this.rel);	
	//FncCargarVentana("FichaIngreso","SeguimientoCliente",oFichaIngresoId);//CARGADO DESDE FICHA INGRESO
	FncCargarVentanaFull("Encuesta",oForm,'Id='+oEncuestaId+'&OrdenVentaVehiculoId='+oOrdenVentaVehiculoId+'&Tipo=VENTA')
	
}

function FncEntregaVentaVehiculoCargarFormulario(oMod,oForm,oOrdenVentaVehiculoId){
	
	FncCargarVentanaFull(oMod,oForm,'&OvvId='+oOrdenVentaVehiculoId+'&Origen=OrdenVentaVehiculo');
	
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

