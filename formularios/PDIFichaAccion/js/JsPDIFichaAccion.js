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
		url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionVerificar.php',
		data: '',
		success: function(respuesta){

			if(respuesta != ""){
				$.ionSound.play("door_bell");
				//alert(respuesta);
				dhtmlx.message({ type:"error", text:respuesta,expire:-2 });
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
	
});




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










function FncEnviarFichaIngresoRecepcionSeleccionados2(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea REGRESAR las ORDENES DE TRABAJO seleccionadas a RECEPCION?")){
			
			$('input[type=checkbox]').each(function () {
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/	

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(

							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
														
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
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/	

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
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
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
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/	

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




function FncEnviarFichaIngresoTallerExternoCancelarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea REGRESAR las ORDENES DE TRABAJO seleccionadas a TALLER?")){
			
			$('input[type=checkbox]').each(function () {
				
//2,3,4,5,6,7,71,72,73,8,9
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
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





function FncEnviarFichaIngresoTallerExternoRetornoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea RETORNAR las ORDENES DE TRABAJO seleccionadas del  TALLER EXTERNO?")){
			
			$('input[type=checkbox]').each(function () {
				
//2,3,4,5,6,7,71,72,73,8,9
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/



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



           

















function FncMarcarTrabajoTerminadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea MARCAR las ORDENES DE TRABAJO seleccionadas como TRABAJO TERMINADO?")){

			$('input[type=checkbox]').each(function () {

/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
				
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

/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
				
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





function FncPlanMantenimientoVer(){

	var PlanMantenimientoId = $('#CmpPlanMantenimientoId').val();

	tb_show(this.title,'principal2.php?Mod=PlanMantenimiento&Form=Ver&Dia=1&Id='+PlanMantenimientoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		

}



function FncFichaAccionModalidadIngresoEditar(oFichaIngresoId){

	tb_show(this.title,'principal2.php?Mod=FichaAccionModalidadIngreso&Form=Editar&Dia=1&Id='+oFichaIngresoId+
'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		

}
