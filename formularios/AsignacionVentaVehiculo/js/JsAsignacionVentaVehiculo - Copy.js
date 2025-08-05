


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





function FncAsignacionVentaVehiculoEnviarFacturacionSeleccionados(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE VENTA DE VEHICULO a FACTURACION?")){

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

			if(actualizar){
				$("#Acc").val("AsignacionVentaVehiculoEnviarFacturacion");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}


}




function FncAsignacionVentaVehiculoActualizarEmitidoSeleccionados(){
	
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea cambiar a EMITIDO las ORDENES DE VENTA DE VEHICULO?")){

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
				//$("#Acc").val("AsignacionVentaVehiculoVentaAnularEnvioFacturacion");
				$("#Acc").val("AsignacionVentaVehiculoActualizarEmitido");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}


}



/*

function FncAsignacionVentaVehiculoAnularEnvioFacturacionSeleccionados(){
	
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ANULAR ENVIO A FACTURACION de las ORDENES DE VENTA DE VEHICULO?")){

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
				$("#Acc").val("AsignacionVentaVehiculoVentaAnularEnvioFacturacion");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}


}

*/


function FncAsignacionVentaVehiculoActualizarAnuladoSeleccionados(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	var actualizar3 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ANULAR las ORDENES DE VENTA DE VEHICULO?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							
							$(this).attr('estado')=="4" 
							
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
							
							$("#Acc").val("AsignacionVentaVehiculoActualizarAnulado");
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









/*
* PAGOS
*/

function FncOrdenCobroCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoAsignacionVentaVehiculo&Form=OrdenCobro'+oForm+'&Dia=1&AvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncAbonoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoAsignacionVentaVehiculo&Form=Abono'+oForm+'&Dia=1&AvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}





function FncPagoAsignacionVentaVehiculoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoAsignacionVentaVehiculo&Form='+oForm+'&Dia=1&AvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncClienteCargarFormulario(oForm,oClienteId){

//	tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

//	FncCargarVentana("Cliente",oForm,oClienteId);

	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId);
	
	
}

function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){

	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}

function FncAsignacionVentaVehiculoCargarFormulario(oForm,oAsignacionVentaVehiculoId){
		
	FncCargarVentana("AsignacionVentaVehiculo",oForm,oAsignacionVentaVehiculoId);

}


//function FncAsignacionVentaVehiculoLlamadaCargarFormulario(oAsignacionVentaVehiculoId){
//
//	FncCargarVentana("AsignacionVentaVehiculo","Llamada",oAsignacionVentaVehiculoId);
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
			
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = DJ Con membrete\n  2 = DJ sin Membrete  ", "2");
						
				if(Tipo !== null){
					
					switch(Tipo.toUpperCase()){
						case "1":
						
							FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirDJ.php?M=1&Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
						break;
						
						case "2":
				
							FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirDJ.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
						break;		
				
					}
					
				}
				
			break;
			
			case "3":
	
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirPM.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
				case "4":
	
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirROP.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "5":
	
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirAE.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "6":
	
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirRDP.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
		}
		
	}

}


function FncVistaPreliminar(oId){
	
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ord. Venta Vehiculo\n 2 = Declaracion Jurada\n 3 = Planes de Mantenimiento\n 4 = ROP\n 5 = Acta de Entrega\n 6 = Autorizacion de uso de datos personales  ", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
			
				var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = DJ Con membrete\n  2 = DJ sin Membrete  ", "2");
						
				if(Tipo !== null){
					
					switch(Tipo.toUpperCase()){
						case "1":
						
							FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirDJ.php?M=1&Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
						break;
						
						case "2":
				
							FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirDJ.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
						break;		
				
					}
					
				}
	
				//FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirDJ.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
			case "3":
	
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirPM.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "4":
	
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirROP.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
			case "5":
	
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirAE.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "6":
	
				FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimirRDP.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
	
		}
		
	}

}







function FncFacturaVistaPreliminar(oId,oTalonario){

	FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncBoletaVistaPreliminar(oId,oTalonario){

	FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncEncuestaCargarFormulario(oForm,oEncuestaId,oAsignacionVentaVehiculoId){//tb_show(this.title,'principal2.php?Mod=Garantia&Form=SeguimientoCliente&Dia=1&Id='+oGarantiaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&modal=true',this.rel);	
	//FncCargarVentana("FichaIngreso","SeguimientoCliente",oFichaIngresoId);//CARGADO DESDE FICHA INGRESO
	FncCargarVentanaFull("Encuesta",oForm,'Id='+oEncuestaId+'&AsignacionVentaVehiculoId='+oAsignacionVentaVehiculoId+'&Tipo=VENTA')
	
}