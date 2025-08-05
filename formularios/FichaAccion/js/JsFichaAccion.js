/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Funciones complementarias
*/
function FncFichaAccionVerificar(){

	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/acc/AccFichaAccionVerificar.php',
		data: '',
		success: function(respuesta){

			if(respuesta != ""){
				
					
//	$.ionSound({
//		sounds: [                       // set needed sounds names
//			"taller_alerta",
//		],
//		path: "audios/",                // set path to sounds
//		multiPlay: true,               // playing only 1 sound at once
//		volume: "0.9"                   // not so loud please
//	});
	
	 $.ionSound.play("door_bell");
	 
	 
				//$.ionSound.play("orden_pendiente2");
				//alert(respuesta);
				//dhtmlx.message({ type:"error", text:respuesta,expire:-2 });
				
					dhtmlx.message({ type:"info", text:"<p><img src='imagenes/mensajes/alerta.png' width='25' height='25' border='0' > "+respuesta+"</p>",expire:-2 });
					
					
					
			}

		}
	});
	
}

$().ready(function() {
	
	$.ionSound({
		sounds: [                       // set needed sounds names
			"door_bell"
		],
		path: "librerias/ion.sound-1.3.0/sounds/",                // set path to sounds
		multiPlay: true,               // playing only 1 sound at once
		volume: "0.9"                   // not so loud please
	});
	
	FncFichaAccionVerificar();

	//setInterval("FncFichaAccionVerificar();",60000);
	
	
/*	
	$('.EstTablaListadoReferencia').contextPopup({
          title: 'My Popup Menu',
          items: [
            {label:'Cotizaciones', action:function() { alert('clicked 1') } },
            {label:'Orden de Compra', action:function() { alert('clicked 2') } },
            {label:'Hoja de Garantia', action:function() { alert('clicked 3') } }          ]
	});*/
		
	/*	
	 {label:'Cotizaciones',     icon:'icons/shopping-basket.png',             action:function() { alert('clicked 1') } },
            {label:'Orden de Compra', icon:'icons/receipt-text.png',                action:function() { alert('clicked 2') } },
            {label:'Hoja de Garantia',     icon:'icons/book-open-list.png',              action:function() { alert('clicked 3') } }*/
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



/*
* Funciones Papelera
*/




/*
* CARGAR FORMULARIOS
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






/*
* anular
*/



function FncEnviarFichaIngresoRecepcionSeleccionados2(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea REGRESAR las ORDENES DE TRABAJO seleccionadas a RECEPCION?")){
			
			$('input[type=checkbox]').each(function () {
//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:	$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						
	

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(

							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
							
							//$(this).attr('estado')=="2" || 
							//$(this).attr('estado')=="3" || 
							
							//$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							$(this).attr('estado')=="7" || 
							//$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							//$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"

						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("AnularRecepcionFichaAccion");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ANULADAS las RECEPCIONES de las ORDENES DE TRABAJO con estado: \n - TALLER [Revisando] \n - TALLER [Preparando Pedido]");
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}












function FncEnviarFichaIngresoAlmacenSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE TRABAJO seleccionadas a ALMACEN?")){
			
			$('input[type=checkbox]').each(function () {
				
//2,3,4,5,6,7,71,72,73,8,9
//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:	$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						
	

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
//							$(this).attr('estado')=="2" || 
//							$(this).attr('estado')=="3" ||
							
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							$(this).attr('estado')=="7" || 
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("EnviarPedidoAlmacen");
				$("#FrmListado").submit();	
			}else{

				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a ALMACEN las ORDENES DE TRABAJO con estado: \n - TALLER [Revisando] \n - TALLER [Preparando Pedido]");
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}



function FncEnviarFichaIngresoTallerSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea REGRESAR las ORDENES DE TRABAJO seleccionadas a TALLER?")){
			
			$('input[type=checkbox]').each(function () {
				
//2,3,4,5,6,7,71,72,73,8,9
//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:	$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 

							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							$(this).attr('estado')=="7" || 
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"

						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("CancelarPedidoAlmacen");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser REGRESADAS a TALLER las ORDENES DE TRABAJO con estado: \n - TALLER [Pedido Enviado]");
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}


















/*

function FncEnviarFichaIngresoTallerExternoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE TRABAJO seleccionadas a TALLER EXTERNO?")){
			
			$('input[type=checkbox]').each(function () {
				
//2,3,4,5,6,7,71,72,73,8,9
//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:	$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						
//	

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
//							$(this).attr('estado')=="2" || 
//							$(this).attr('estado')=="3" ||
							
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							$(this).attr('estado')=="7" || 
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
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
							$(this).attr('taller_externo')=="No" 
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			
			

			if(actualizar){
				if(actualizar2){
					$("#Acc").val("EnviarPedidoTallerExterno");
					$("#FrmListado").submit();	
				}else{
					alert("Uno o mas de los elementos seleccionados no tiene ASIGNADO el TALLER EXTERNO");	
				}
			}else{
				
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a TALLER EXTERNO las ORDENES DE TRABAJO con estado: \n - TALLER [Revisando] \n - TALLER [Preparando Pedido]");
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}

*/

/*
function FncEnviarFichaIngresoTallerExternoCancelarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea REGRESAR las ORDENES DE TRABAJO seleccionadas a TALLER?")){
			
			$('input[type=checkbox]').each(function () {
				
//2,3,4,5,6,7,71,72,73,8,9
//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:	$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						





				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 

							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							$(this).attr('estado')=="7" || 
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"

						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("CancelarPedidoTallerExterno");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser REGRESADAS a TALLER las ORDENES DE TRABAJO con estado: \n - TALLER [Pedido Enviado]");
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}
*/


/*

function FncEnviarFichaIngresoTallerExternoRetornoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea RETORNAR las ORDENES DE TRABAJO seleccionadas del  TALLER EXTERNO?")){
			
			$('input[type=checkbox]').each(function () {
				
//2,3,4,5,6,7,71,72,73,8,9
//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:	$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						




				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 

							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							$(this).attr('estado')=="7" || 
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"

						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				
		
		
				$("#Acc").val("RetornarPedidoTallerExterno");//CancelarPedidoAlmacen//DesmarcarTrabajoTerminado

				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser RETORNADAS de TALLER EXTERNO las ORDENES DE TRABAJO con estado: \n - TALLER [Pedido Enviado]");
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}

*/

           

















function FncMarcarTrabajoTerminadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea MARCAR las ORDENES DE TRABAJO seleccionadas como TRABAJO TERMINADO?")){

			$('input[type=checkbox]').each(function () {

//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:	$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						

				
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							//$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="72" || 
							$(this).attr('estado')=="73" || 
							$(this).attr('estado')=="74" || 
							$(this).attr('estado')=="75" || 
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
						){
							actualizar = false;
							return false;
						}
					}
				}

			});

			if(actualizar){
				$("#Acc").val("MarcarTrabajoTerminado");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser MARCADAS como TRABAJO TERMINADO las ORDENES DE TRABAJO con estado: \n - TALLER [Preparando Pedido] \n - ALMACEN [Pedido Enviado] \n - TALLER [Pedido Recibido]");
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}

function FncDesmarcarTrabajoTerminadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea DESMARCAR las ORDENES DE TRABAJO seleccionadas como TRABAJO TERMINADO?")){

			$('input[type=checkbox]').each(function () {

//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:	$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						

				
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							$(this).attr('estado')=="7" || 
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" || 

							$(this).attr('estado')=="74" || 
							$(this).attr('estado')=="75" || 
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
						){
							actualizar = false;
							return false;
						}
					}
				}

			});

			if(actualizar){
				$("#Acc").val("DesmarcarTrabajoTerminado");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser DESMARCADAS como TRABAJO TERMINADO las ORDENES DE TRABAJO con estado: \n - TALLER [Trabajo Terminado]");
			}
			
		}
	}

}






function FncDesmarcarTrabajoConcluidoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea DESMARCAR TRABAJO CONCLUIDO de las ORDENES DE TRABAJO?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
		
						if(
							$(this).attr('concluido')==""
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			  if(actualizar){
				  $("#Acc").val("DesmarcarTrabajoConcluido");
				  $("#FrmListado").submit();	
			  }else{
				  alert("Uno o mas de los elementos seleccionados no se puede DESMARCAR TRABAJO CONCLUIDO, verifique que esten realmente concluidos.");	
			  }

		}
	}

}



function FncMarcarTrabajoConcluidoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea MARCAR TRABAJO CONCLUIDO de las ORDENES DE TRABAJO?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
		
						if(
							$(this).attr('concluido')==""
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			  if(actualizar){
				  $("#Acc").val("MarcarTrabajoConcluido");
				  $("#FrmListado").submit();	
			  }else{
				  alert("Uno o mas de los elementos seleccionados no se puede MARCAR TRABAJO CONCLUIDO, verifique que esten realmente concluidos.");	
			  }

		}
	}

}


/*
* CARGAR FORMULARIOS
*/

function FncAvisoCargarFormulario(oVehiculoIngresoId){

	tb_show(this.title,'principal2.php?Mod=Aviso&Form=Listado&Dia=1&EinId='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=true',this.rel);		

}




function FncPlanMantenimientoVer(){

	var PlanMantenimientoId = $('#CmpPlanMantenimientoId').val();

	tb_show(this.title,'principal2.php?Mod=PlanMantenimiento&Form=Ver&Dia=1&Id='+PlanMantenimientoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		

}



//function FncFichaAccionModalidadIngresoEditar(oFichaIngresoId){
//
//	tb_show(this.title,'principal2.php?Mod=FichaAccionModalidadIngreso&Form=Editar&Dia=1&Id='+oFichaIngresoId+
//'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		
//
//}


function FncOrdenVentaVehiculoVerPlan(oId,oNumeroMantenimiento){
	
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPM.php?Id='+oId+'&NumeroMantenimiento='+oNumeroMantenimiento,0,0,1,0,0,1,0,screen.height,screen.width);
	
}



function FncCotizacionProductoListadoCargar(oFichaIngresoId){

	tb_show(this.title,'formularios/FichaIngreso/DiaCotizacionProductoListado.php?FinId='+oFichaIngresoId+
'&placeValuesBeforeTB_=savedValues',this.rel);	
  
}

function FncPedidoCompraListadoCargar(oFichaIngresoId){

	tb_show(this.title,'formularios/TallerPedido/DiaPedidoCompraListado.php?FinId='+oFichaIngresoId+
'&placeValuesBeforeTB_=savedValues',this.rel);	
  
}

function FncHojaGarantiaListadoCargar(oFichaIngresoId){

	tb_show(this.title,'formularios/TrabajoTerminado/DiaGarantiaListado.php?FinId='+oFichaIngresoId+
'&placeValuesBeforeTB_=savedValues',this.rel);	
  
}




$(document).ready( function() {

				// Show menu when #myDiv is clicked
//				$("#myDiv").contextMenu({
//					menu: 'myMenu'
//				},
//					function(action, el, pos) {
//					alert(
//						'Action: ' + action + '\n\n' +
//						'Element ID: ' + $(el).attr('id') + '\n\n' +
//						'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\n\n' +
//						'X: ' + pos.docX + '  Y: ' + pos.docY+ ' (relative to document)'
//						);
//				});

				//// Show menu when a list item is clicked
//				$("#myList UL LI").contextMenu({
//					menu: 'myMenu'
//				}, function(action, el, pos) {
//					alert(
//						'Action: ' + action + '\n\n' +
//						'Element text: ' + $(el).text() + '\n\n' +
//						'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\n\n' +
//						'X: ' + pos.docX + '  Y: ' + pos.docY+ ' (relative to document)'
//						);
//				});
//
//				// Disable menus
//				$("#disableMenus").click( function() {
//					$('#myDiv, #myList UL LI').disableContextMenu();
//					$(this).attr('disabled', true);
//					$("#enableMenus").attr('disabled', false);
//				});
//
//				// Enable menus
//				$("#enableMenus").click( function() {
//					$('#myDiv, #myList UL LI').enableContextMenu();
//					$(this).attr('disabled', true);
//					$("#disableMenus").attr('disabled', false);
//				});
//
//				// Disable cut/copy
//				$("#disableItems").click( function() {
//					$('#myMenu').disableContextMenuItems('#cut,#copy');
//					$(this).attr('disabled', true);
//					$("#enableItems").attr('disabled', false);
//				});
//
//				// Enable cut/copy
//				$("#enableItems").click( function() {
//					$('#myMenu').enableContextMenuItems('#cut,#copy');
//					$(this).attr('disabled', true);
//					$("#disableItems").attr('disabled', false);
//				});

			});
			
			
			
			

/*
* FUNCIONES MODALDADES DE INGRESO
*/

function FncTallerPedidoModalidadIngresoEditar(oFichaIngresoId){
	FncCargarVentana("TallerPedidoModalidadIngreso","Editar",oFichaIngresoId);	
}

function FncFichaAccionModalidadIngresoEditar(oFichaIngresoId){
	FncCargarVentana("FichaAccionModalidadIngreso","Editar",oFichaIngresoId);
}

function FncFichaIngresoModalidadIngresoEditar(oFichaIngresoId){
	FncCargarVentana("FichaIngresoModalidadIngreso","Editar",oFichaIngresoId);
}




function FncOrdenVentaVehiculoVistaPreliminar(oId){
	
//	alert("s");
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}






function FncTallerPedidoEnviarCorreo(oFichaIngresoId){

	tb_show(this.title,'formularios/FichaAccion/DiaFichaAccionEnviarCorreo.php?FinId='+oFichaIngresoId+
'&placeValuesBeforeTB_=savedValues',this.rel);	

}



function FncTallerPedidoVerFichas(oId){

	var Ancho = $( window ).width();
	var Alto = $( window ).height();

	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.2));
	
	var Tipo = prompt("Escoja el tipo de ficha \n 1 = Fichas de Salida \n 2 = Ficha Tecnica \n 3 = Ficha Interna \n 4 = Ordenes de Compra \n 5 = Cotizaciones \n 6 = Hojas de Garantia", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){

			case "1":

				tb_show("FICHAS DE SALIDA",'formularios/TallerPedido/DiaAlmacenMovimientoListado.php?FinId='+oId+'&placeValuesBeforeTB_=savedValues&width='+Ancho+'&heigth='+Alto+'',this.rel);	
				
			break;
			
			case "2":
				
				FncFichaTecnicaVistaPreliminar(oId);
				
			break;
			
			case "3":
				
				FncFichaInternaVistaPreliminar(oId);
				
			break;
			
			case "4":

				tb_show("ORDENES DE COMPRA",'formularios/TallerPedido/DiaPedidoCompraListado.php?FinId='+oId+'&placeValuesBeforeTB_=savedValues&width='+Ancho+'&heigth='+Alto+'',this.rel);	
				
			break;
			
			case "5":
				
				tb_show("COTIZACIONES",'formularios/FichaIngreso/DiaCotizacionProductoListado.php?FinId='+oId+'&placeValuesBeforeTB_=savedValues&width='+Ancho+'&heigth='+Alto+'',this.rel);	
				
			break;
			
			case "6":
			
				tb_show("HOJAS DE GARANTIA",'formularios/TrabajoTerminado/DiaGarantiaListado.php?FinId='+oId+'&placeValuesBeforeTB_=savedValues&width='+Ancho+'&heigth='+Alto+'',this.rel);	
				
			break;
		
		}
		
	}

}




function FncFichaTecnicaVistaPreliminar(oId){
	
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);


}

function FncFichaInternaVistaPreliminar(oId){
	
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFI.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);


}
