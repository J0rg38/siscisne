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

//	$('input[type=checkbox]').each(function () {
//		if($(this).attr('name')=="cmp_seleccionar[]"){
//			
//			var FichaIngresoId = $(this).val();
//
//			$('#MenContextual_'+FichaIngresoId).contextPopup({
//				title: 'Relacionados',
//				items: [
//				
//				{label:'Fichas de Salida',	icon:'imagenes/acciones/enlace.gif',	action:function() { FncFichaSalidaMostrar(FichaIngresoId); } },
//				{label:'Ficha Tecnica',		icon:'imagenes/acciones/enlace.gif',		action:function() { alert('clicked 2') } },
//				{label:'Ord. Compra',		icon:'imagenes/acciones/enlace.gif',	action:function() { alert('clicked 3') } },
//				null, // divider
//				{label:'Cotizaciones',		icon:'imagenes/acciones/enlace.gif',action:function() { alert('clicked 4') } },
//				{label:'Hojas de Garantia',	icon:'imagenes/acciones/enlace.gif',			 action:function() { alert('clicked 5') } }
//				
//				]
//			});
//			
//		}
//	});
	


});


function FncTallerPedidoVerificar(){

	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/acc/AccTallerPedidoVerificar.php',
		data: '',
		success: function(respuesta){

			//if(respuesta == 2){
			if(respuesta != ""){
				//alert("Hay Ordenes de Trabajo pendientes por revisar");				
//				$.ionSound.play("door_bell");

//	$.ionSound({
//		sounds: [                       // set needed sounds names
//			"almacen_alerta",
//		],
//		path: "audios/",                // set path to sounds
//		multiPlay: true,               // playing only 1 sound at once
//		volume: "0.9"                   // not so loud please
//	});
	
	 $.ionSound.play("door_bell");
	 
	 
				//alert(respuesta);
				
				dhtmlx.message({ 
				type:"info", 
				text:"<p><img src='imagenes/mensajes/alerta.png' width='25' height='25' border='0' > "+respuesta+"</p>",
				 });
				
			//	dhtmlx.message({ type:"error", text:respuesta });
				
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
		multiPlay: true,           // playing only 1 sound at once
		volume: "0.9"                   // not so loud please
	});

	FncTallerPedidoVerificar();

	setInterval("FncTallerPedidoVerificar();",3000);
	
	//setInterval("location.reload();",130000);	
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
}/*
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

//function FncEnviarFichaIngresoTallerSeleccionados(){
//
//	var seleccionados = $("#cmp_seleccionados").val();
//	var actualizar = true;
//	
//	if(seleccionados==""){
//		alert("No ha seleccionado ningun elemento.");
//	}else{
//		if(confirm("¿Realmente desea ENVIAR las ORDENES DE TRABAJO seleccionadas a TALLER?")){
//
//			$('input[type=checkbox]').each(function () {
////5,6,7,71,72,8,9
///*
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
//*/if($(this).attr('name')=="cmp_seleccionar[]"){
//					if($(this).is(':checked')){
//						if(
//							$(this).attr('estado')=="1" || //QUITAR 
//							$(this).attr('estado')=="11" || //QUITAR 
//							$(this).attr('estado')=="2" || //QUITAR 
//							$(this).attr('estado')=="3" || //QUITAR
//							$(this).attr('estado')=="4" || //QUITAR 
//							//$(this).attr('estado')=="5" || //QUITAR 
//							//$(this).attr('estado')=="6" || //QUITAR 
//							
//							$(this).attr('estado')=="7" ||
//							$(this).attr('estado')=="71" ||
////							$(this).attr('estado')=="72" ||
//
//							$(this).attr('estado')=="73" || 
//							$(this).attr('estado')=="74" || 
//							$(this).attr('estado')=="75" || 
//							$(this).attr('estado')=="8" || 
//							$(this).attr('estado')=="9"
//						){
//							actualizar = false;
//							return false;
//						}
//
//					}
//				}
//
//			});
//
//			if(actualizar){
//						$("#Acc").val("EnviarPedidoTaller");
//			$("#FrmListado").submit();	
//			}else{
//				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a TALLER las ORDENES DE TRABAJO con estado: \n - ALMACEN [Revisado Pedido] \n - ALMACEN [Preparando Pedido] \n - ALMACEN [Pedido Extornado]");
//				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
//			}
//			
//			
//		}
//	}
//	
//}

//
//function FncEnviarFichaIngresoTallerSeleccionados2(){
//
//	var seleccionados = $("#cmp_seleccionados").val();
//	
//	var actualizar = true;
//		
//	if(seleccionados==""){
//		alert("No ha seleccionado ningun elemento.");
//	}else{
//		if(confirm("¿Realmente desea RECHAZAR las ORDENES DE TRABAJO(Pedido) de TALLER seleccionadas?")){
//			
//			$('input[type=checkbox]').each(function () {
//				
////2,3,4,5,6,7,71,72,73,8,9
///*
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
//*/
//				if($(this).attr('name')=="cmp_seleccionar[]"){
//					if($(this).is(':checked')){
//						if(
//						
//							$(this).attr('estado')=="1" || 
//							$(this).attr('estado')=="11" || 
//							$(this).attr('estado')=="2" || 
//							$(this).attr('estado')=="3" || 
//
//							$(this).attr('estado')=="5" || 
//							$(this).attr('estado')=="6" || 
//							$(this).attr('estado')=="7" || 
//							$(this).attr('estado')=="71" || 
//							$(this).attr('estado')=="72" ||
//							$(this).attr('estado')=="73" ||
//							$(this).attr('estado')=="74" ||
//							$(this).attr('estado')=="75" ||
//							$(this).attr('estado')=="8" || 
//							$(this).attr('estado')=="9"
//
//						){
//							actualizar = false;
//							return false;
//						}
//
//					}
//				}
//
//			});
//
//			if(actualizar){
//				$("#Acc").val("CancelarPedidoAlmacen");
//				$("#FrmListado").submit();	
//			}else{
//				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser RECHAZADAS  las ORDENES DE TRABAJO(Pedido) con estado: \n - TALLER [Pedido Enviado]");
//			}
//			
//		}
//	}
//
//}
//





/*
* ANULAR
*/

function FncEnviarFichaIngresoTallerSeleccionados3(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ANULAR las RECEPCIONES de las ORDENES DE TRABAJO(Pedido) seleccionadas?")){
			
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
						
						//if($this->FinEstado == 3 || $this->FinEstado == 5 || $this->FinEstado == 6 
						//		|| $this->FinEstado == 7 ){								

							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							//$(this).attr('estado')=="5" || 
							//$(this).attr('estado')=="6" || 
							//$(this).attr('estado')=="7" || 
							$(this).attr('estado')=="71" || 
							//$(this).attr('estado')=="72" ||
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
				$("#Acc").val("AnularRecepcionPedidoTaller");
				$("#FrmListado").submit();	
			}else{

				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ANULADAS las RECEPCIONES de las ORDENES DE TRABAJO(Pedido) con estado: \n - ALMACEN [Revisado Pedido] \n - ALMACEN [Preparando Pedido]");
				
			}
			
		}
	}

}










function FncMarcarTrabajoTerminadoSeleccionados(oRapido){

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
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
//							$(this).attr('estado')=="6" || 
//							$(this).attr('estado')=="7" || 	
//							
//							$(this).attr('estado')=="71" || 
//							$(this).attr('estado')=="72" || 
							
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
				if(oRapido=="1"){
					$("#Acc").val("MarcarTrabajoTerminadoRapido");
				}else{
					$("#Acc").val("MarcarTrabajoTerminado");
				}			
				
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser MARCADAS como TRABAJO TERMINADO las ORDENES DE TRABAJO con estado:  \n - ALMACEN [Preparando Pedido] \n - ALMACEN [Pedido Enviado] \n - TALLER [Pedido Recibido] \n - ALMACEN [Pedido Extornado]");
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}




//
//
//
//function FncDesmarcarTrabajoTerminadoSeleccionados(){
//
//	var seleccionados = $("#cmp_seleccionados").val();
//	var actualizar = true;
//	
//	if(seleccionados==""){
//		alert("No ha seleccionado ningun elemento.");
//	}else{
//		if(confirm("¿Realmente desea DESMARCAR las ORDENES DE TRABAJO seleccionadas como TRABAJO TERMINADO?")){
//
//			$('input[type=checkbox]').each(function () {
//
///*
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
//*/
//				
//				if($(this).attr('name')=="cmp_seleccionar[]"){
//					if($(this).is(':checked')){
//						if(
//							$(this).attr('estado')=="1" || 
//							$(this).attr('estado')=="11" || 
//							$(this).attr('estado')=="2" || 
//							$(this).attr('estado')=="3" || 
//							$(this).attr('estado')=="4" || 
//							$(this).attr('estado')=="5" || 
//							$(this).attr('estado')=="6" || 
//							$(this).attr('estado')=="7" || 
//							$(this).attr('estado')=="71" || 
//							$(this).attr('estado')=="72" || 
//
//							$(this).attr('estado')=="74" || 
//							$(this).attr('estado')=="75" || 
//							$(this).attr('estado')=="8" || 
//							$(this).attr('estado')=="9"
//						){
//							actualizar = false;
//							return false;
//						}
//					}
//				}
//
//			});
//
//			if(actualizar){
//				$("#Acc").val("DesmarcarTrabajoTerminado");
//				$("#FrmListado").submit();	
//			}else{
//				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser DESMARCADAS como TRABAJO TERMINADO las ORDENES DE TRABAJO con estado: \n - TALLER [Trabajo Terminado]");
//			}
//			
//		}
//	}
//
//}
//
//
//






//
//function FncDesmarcarTrabajoConcluidoSeleccionados(){
//
//	var seleccionados = $("#cmp_seleccionados").val();
//	var actualizar = true;
//	
//	if(seleccionados==""){
//		alert("No ha seleccionado ningun elemento.");
//	}else{
//		if(confirm("¿Realmente desea DESMARCAR TRABAJO CONCLUIDO de las ORDENES DE TRABAJO?")){
//
//			$('input[type=checkbox]').each(function () {
//
//				if($(this).attr('name')=="cmp_seleccionar[]"){
//					if($(this).is(':checked')){
//		
//						if(
//							$(this).attr('concluido')==""
//						){
//							actualizar = false;
//							return false;
//						}
//
//					}
//				}
//
//			});
//
//			  if(actualizar){
//				  $("#Acc").val("DesmarcarTrabajoConcluido");
//				  $("#FrmListado").submit();	
//			  }else{
//				  alert("Uno o mas de los elementos seleccionados no se puede DESMARCAR TRABAJO CONCLUIDO, verifique que esten realmente concluidos.");	
//			  }
//
//		}
//	}
//
//}


//
//function FncGenerarGarantiaSeleccionados(){
//
//	var seleccionados = $("#cmp_seleccionados").val();
//	var actualizar = true;
//	var actualizar2 = true;
//	
//	if(seleccionados==""){
//		alert("No ha seleccionado ningun elemento.");
//	}else{
//		if(confirm("¿Realmente desea GENERAR GARANTIAS de las ORDENES DE TRABAJO?")){
//
//			$('input[type=checkbox]').each(function () {
//
//				if($(this).attr('name')=="cmp_seleccionar[]"){
//					if($(this).is(':checked')){
//
//						/*
//						case 1:		$Estado = "RECEPCION [Pendiente]";
//						case 11:	$Estado = "RECEPCION [Enviado]";
//						case 2:		$Estado = "TALLER [Revisando]";
//						case 3:		$Estado = "TALLER [Preparando Pedido]";
//						case 4:		$Estado = "TALLER [Pedido Enviado]";
//						case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//						case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//						case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//						case 71:	$Estado = "TALLER [Pedido Recibido]";
//						case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//						
//						case 73:$Estado = "TALLER [Trabajo Terminado]";
//						case 74:$Estado = "RECEPCION [Revisando]";
//						
//						case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//						case 8:	$Estado = "TALLER [Por Facturar]";
//						case 9:	$Estado = "CONTABILIDAD [Facturado]";						
//						*/		
//		
//						if(
//							$(this).attr('estado')=="1" || 
//							$(this).attr('estado')=="11" || 
//							$(this).attr('estado')=="2" || 
//							$(this).attr('estado')=="3" || 
//							$(this).attr('estado')=="4" || 
//							//$(this).attr('estado')=="5" || 
//							//$(this).attr('estado')=="6" || 
//							
//							//$(this).attr('estado')=="7" ||
//							//$(this).attr('estado')=="71" || 
//							$(this).attr('estado')=="72" ||
//							//$(this).attr('estado')=="73" ||
//							//$(this).attr('estado')=="74" ||
//							//$(this).attr('estado')=="75" ||
//							$(this).attr('estado')=="8" //|| 
//							//$(this).attr('estado')=="9"
//						){
//							actualizar = false;
//							return false;
//						}
//
//					}
//				}
//
//			});
//			
//			
//			
//			
//			
//			$('input[type=checkbox]').each(function () {
//
//				if($(this).attr('name')=="cmp_seleccionar[]"){
//					if($(this).is(':checked')){
//			
//						if(
//							$(this).attr('garantia')=="No" 
//						){
//							actualizar2 = false;
//							return false;
//						}
//
//					}
//				}
//
//			});
//			
//			if(actualizar2){
//				if(actualizar){
//					$("#Acc").val("GenerarGarantia");
//					$("#FrmListado").submit();	
//				}else{
//					alert("Uno o mas de los elementos seleccionados no se puede GENERAR GARANTIAS, verifique sus ESTADOS.");	
//				}
//			}else{
//				alert("Uno o mas de los elementos seleccionados no se  puede GENERAR GARANTIAS, no posee la MODALIDAD.");	
//			}
//			
//		}
//		
//		
//
//	}
//
//}



function FncFichaTecnicaVistaPreliminar(oId){
	
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);


}

function FncFichaInternaVistaPreliminar(oId){
	
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFI.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);


}

/**********************************************************************************************/
/**********************************************************************************************/

//Acciones - Declarar

function FncImprmir(oId){
	
	FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncVistaPreliminar(oId){
	
	FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

/**********************************************************************************************/
/**********************************************************************************************/

function FncClienteCargarFormulario(oForm,oClienteId){

	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId)

}

function FncOrdenVentaVehiculoVerPlan(oId,oNumeroMantenimiento){
	
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPM.php?Id='+oId+'&NumeroMantenimiento='+oNumeroMantenimiento+'&Completo=No',0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncVehiculoRecepcionVistaPreliminar(oId){

	FncPopUp('formularios/VehiculoRecepcion/FrmVehiculoRecepcionImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){

	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=VehiculoIngreso&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oVehiculoIngresoId)

}


/*
FUNCIONES MENU CONTEXTUAL
*/

//function FncFichaSalidaMostrar(oFichaIngresoId){
//	
//	FncCargarVentanaNuevo('formularios/TallerPedido/DiaAlmacenMovimientoListado.php?FinId='+oFichaIngresoId,"false","false","Fichas de Salida");
//	
//
//}


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


function FncAvisoCargarFormulario(oVehiculoIngresoId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//	FncCargarVentana("Aviso",oForm,oVehiculoIngresoId);

	tb_show(this.title,'principal2.php?Mod=Aviso&Form=Listado&Dia=1&EinId='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=true',this.rel);	
		
}


function FncTallerPedidoVerFichas(oId){

	var Ancho = $( window ).width();
	var Alto = $( window ).height();

	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.2));
	
	var Tipo = prompt("Escoja el tipo de ficha \n 1 = Fichas de Salida \n 2 = Ficha Tecnica \n 3 = Ficha Interna \n 4 = Ordenes de Compra \n 5 = Cotizaciones \n 6 = Hojas de Garantia \n 7 = Resumen Salida de Repuestos", "1");			
	
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
			
				case "7":
			
				//tb_show("RESUMEN SALIDA DE REPUESTOS",'formularios/TallerPedido/FrmTallerPedidoResumenImprimir.php?FinId='+oId+'&placeValuesBeforeTB_=savedValues&width='+Ancho+'&heigth='+Alto+'',this.rel);	
				
				FncPopUp('formularios/TallerPedido/FrmTallerPedidoResumenImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);



			break;
			
			
		}
		
	}

}





function FncEnviarOrdenTrabajoContabilidadSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE TRABAJO a FACTURACION?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

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
						
						if(
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							//$(this).attr('estado')=="6" || 

							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							//$(this).attr('estado')=="73" ||
							
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
				$("#Acc").val("EnviarOrdenTrabajoContabilidad");
				$("#FrmListado").submit();	
			}else{
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a FACTURACION las ORDENES DE TRABAJO con estado: \n - RECEPCION [Revisando]");
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}


function FncActualiarCierreSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		if(confirm("¿Realmente desea actualizar el cierre de O.T. la orden de trabajo?")){
			
			var Tipo = prompt("Escoja una accion \n 1 = Cerrar O.T.\n 2 = Abrir O.T.", "1");
			
			if(Tipo !== null){
				
				switch(Tipo.toUpperCase()){
					
					case "1":				
						
						$('input[type=checkbox]').each(function () {
						
							if($(this).attr('name')=="cmp_seleccionar[]"){
								if($(this).is(':checked')){
									
									if(
										$(this).attr('cierre')=="1" 
									){
										actualizar = false;
										return false;
									}
						
								}
							}
						
						});
						
						if(actualizar){
							$("#Acc").val("ActualizarCierreSi");
							$("#FrmListado").submit();	
						}else{
							alert("Uno o mas de los elementos seleccionados ya se encuentra cerrado.");
						}
													
					break;
				
					case "2":
							
						$('input[type=checkbox]').each(function () {
						
							if($(this).attr('name')=="cmp_seleccionar[]"){
								if($(this).is(':checked')){
									
									if(
										$(this).attr('cierre')=="2" 
									){
										actualizar = false;
										return false;
									}
						
								}
							}
						
						});
						
						if(actualizar){
							$("#Acc").val("ActualizarCierreNo");
							$("#FrmListado").submit();	
						}else{
							alert("Uno o mas de los elementos seleccionados ya se encuentra abierto.");
						}
							
					break;
				}
				
			}
			
		}
	
	}
	
}


function FncVehiculoIngresoSimpleCargarFormulario(oForm,oVehiculoIngresoId){
	//tb_show(this.title,'principal2.php?Mod=&Form='+oForm+'&Dia=1&Id='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width='+Ancho+'&modal=true',this.rel);		
	FncCargarVentana("VehiculoIngresoSimple",oForm,oVehiculoIngresoId);

}