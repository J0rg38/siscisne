/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Funciones complementarias
*/
function FncTrabajoTerminadoVerificar(){

	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoVerificar.php',
		data: '',
		success: function(respuesta){

			if(respuesta != ""){
//				$.ionSound.play("door_bell");
$.ionSound.play("orden_pendiente2");
				//alert(respuesta);
				dhtmlx.message({ type:"error", text:respuesta,expire:-5 });
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
	
	
	FncTrabajoTerminadoVerificar();

	setInterval("FncTrabajoTerminadoVerificar();",60000);
	
});
//dhtmlx.message({ type:"error", text:respuesta });


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
			
//			if(Tipo !== null){
//				switch(Tipo.toUpperCase()){
//					case "1":
	document.getElementById("FrmListado").action = "formularios/FichaIngreso/acc/AccFichaIngresoGenerarExcel.php";
//					break;
					
//					case "2":
//	document.getElementById("FrmListado").action = "formularios/FichaIngreso/acc/AccFichaIngresoGenerarExcel2.php";
//					break;
//				
//				}
//				
//			}

	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";

}


function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/FichaIngreso/FrmFichaIngresoListadoImprimir.php"
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




function FncEnviarFichaIngresoTallerSeleccionados (){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE TRABAJO a TALLER?")){

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
*/if(
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
				$("#Acc").val("EnviarOrdenTrabajoTaller");
				$("#FrmListado").submit();	
			}else{
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a FACTURACION las ORDENES DE TRABAJO con estado: \n - RECEPCION [Revisando]");
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
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




function FncEnviarOrdenTrabajoRecepcionSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea CANCELAR EL ENVIO de las ORDENES DE TRABAJO a FACTURACION?")){

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
*/if(
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
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||

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
				$("#Acc").val("EnviarOrdenTrabajoRecepcion");
				$("#FrmListado").submit();	
			}else{
//				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser CANCELADOS LOS ENVIOS a FACTURACION las ORDENES DE TRABAJO con estado: \n - RECEPCION [Conforme/Por Facturar]");
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}






function FncEnviarOrdenTrabajoTallerSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea REGRESAR las ORDENES DE TRABAJO a TALLER?")){

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
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							//$(this).attr('estado')=="73" ||
							//$(this).attr('estado')=="74" ||
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
				$("#Acc").val("EnviarOrdenTrabajoTaller");
				$("#FrmListado").submit();	
			}else{
				//alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser REGRESADOS A TALLER las ORDENES DE TRABAJO con estado: \n - TALLER [Trabajo Terminado] \n - RECEPCION [Revisando]");
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
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
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" ||
							
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							$(this).attr('estado')=="7" || 
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
//							$(this).attr('estado')=="73" ||
//							$(this).attr('estado')=="74" ||
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
				$("#Acc").val("EnviarOrdenTrabajoAlmacen");
				$("#FrmListado").submit();	
			}else{

//				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a ALMACEN las ORDENES DE TRABAJO con estado: \n - TALLER [Trabajo Terminado] \n - RECEPCION [Revisando]");
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}



















function FncGenerarGarantiaSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea GENERAR GARANTIAS de las ORDENES DE TRABAJO?")){

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
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							//$(this).attr('estado')=="73" ||
							//$(this).attr('estado')=="74" ||
							//$(this).attr('estado')=="75" ||
							$(this).attr('estado')=="8" //|| 
							//$(this).attr('estado')=="9"
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
							$(this).attr('garantia')=="No" 
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			

			if(actualizar2){
				if(actualizar){
					$("#Acc").val("GenerarGarantia");
					$("#FrmListado").submit();	
				}else{
					alert("Uno o mas de los elementos seleccionados no se puede GENERAR GARANTIAS, verifique sus ESTADOS.");	
				}
			}else{
				alert("Uno o mas de los elementos seleccionados no se  puede GENERAR GARANTIAS, no posee la MODALIDAD.");	
			}
			
		}
	}

}





function FncEnviarOrdenTrabajoNoFacturableSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea CAMBIAR las ORDENES DE TRABAJO a NO FACTURABLE?")){
			
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

case 73:	$Estado = "TALLER [Trabajo Terminado]";
case 74:	$Estado = "RECEPCION [Revisando]";

case 75:	$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:		$Estado = "TALLER [Por Facturar]";
case 9:		$Estado = "CONTABILIDAD [Facturado]";	
case 10:	$Estado = "RECEPCION [No Facturable]";	
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
//							$(this).attr('estado')=="73" ||
//							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9" || 
							$(this).attr('estado')=="10"
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("EnviarOrdenTrabajoNoFacturable");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}

}





function FncEnviarOrdenTrabajoNoFacturableCancelarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea CANCELAR la orden NO FACTURABLE de las ORDENES DE TRABAJO?")){
			
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

case 73:	$Estado = "TALLER [Trabajo Terminado]";
case 74:	$Estado = "RECEPCION [Revisando]";

case 75:	$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:		$Estado = "TALLER [Por Facturar]";
case 9:		$Estado = "CONTABILIDAD [Facturado]";	
case 10:	$Estado = "RECEPCION [No Facturable]";	
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
				$("#Acc").val("EnviarOrdenTrabajoNoFacturableCancelar");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
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



/*
* FUNCIONES - IMPRESION
*/
function FncImprmir(oId){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario\n 4 = Acta de Entrega\n 5 = Ficha Interna ", "1");

	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "3":
	
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
			case "4":
	
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirActaEntrega.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "5":
	
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFI.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
		
		}
		
	}

}


function FncVistaPreliminar(oId){
	
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario\n 4 = Acta de Entrega\n 5 = Ficha Interna ", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":

				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "3":
	
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "4":
			
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirActaEntrega.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "5":
			
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFI.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
	
		}
		
	}

}


function FncGenerarPDF(oId){
	
	var Tipo = prompt("Escoja el tipo de PDF \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
			
				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoGenerarPDF.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":

				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoGenerarPDFFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			//case "3":
//	
//				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
//	
//			break;
//			
//			case "4":
//			
//				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirActaEntrega.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
//	
//			break;
//			
//			case "5":
//			
//				FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFI.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
//	
//			break;
	
		}
		
	}

}


/*
* FORMULARIOS
*/

function FncAvisoCargarFormulario(oVehiculoIngresoId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//	FncCargarVentana("Aviso",oForm,oVehiculoIngresoId);

	tb_show(this.title,'principal2.php?Mod=Aviso&Form=Listado&Dia=1&EinId='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=true',this.rel);	
		
}

function FncClienteCargarFormulario(oForm,oClienteId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	
	
	FncCargarVentanaFull("Cliente",oForm,'Id='+oClienteId)	

}

function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){

	//tb_show(this.title,'principal2.php?Mod=VehiculoIngreso&Form='+oForm+'&Dia=1&Id='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	
	FncCargarVentanaFull("VehiculoIngreso",oForm,'Id='+oVehiculoIngresoId)
	//FncCargarVentanaFull(oMod,oForm,oVariables)
}


function FncFichaIngresoSeguimientoClienteCargarFormulario(oFichaIngresoId){//tb_show(this.title,'principal2.php?Mod=Garantia&Form=SeguimientoCliente&Dia=1&Id='+oGarantiaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&modal=true',this.rel);	
	//FncCargarVentana("FichaIngreso","SeguimientoCliente",oFichaIngresoId);//CARGADO DESDE FICHA INGRESO
	FncCargarVentanaFull("FichaIngreso","SeguimientoCliente",'Id='+oFichaIngresoId)
	
}

function FncEncuestaCargarFormulario(oForm,oEncuestaId,oFichaIngresoId){//tb_show(this.title,'principal2.php?Mod=Garantia&Form=SeguimientoCliente&Dia=1&Id='+oGarantiaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&modal=true',this.rel);	
	//FncCargarVentana("FichaIngreso","SeguimientoCliente",oFichaIngresoId);//CARGADO DESDE FICHA INGRESO
	FncCargarVentanaFull("Encuesta",oForm,'Id='+oEncuestaId+'&FichaIngresoId='+oFichaIngresoId+'&Tipo=POSTVENTA')
	
}



function FncTrabajoTerminadoEnviarMensajeTexto(oFichaIngresoId){
	
	//if(confirm("¿Realmente desea enviar un mensaje de texto al cliente?")){
	
		FncPopUp('formularios/TrabajoTerminado/FrmTrabajoTerminadoEnviarMensajeTexto.php?FinId='+oFichaIngresoId,0,0,1,0,0,1,0,450,250);
		
	//}
	
}








function FncOrdenVentaVehiculoVerPlan(oId,oNumeroMantenimiento){
	
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPM.php?Id='+oId+'&NumeroMantenimiento='+oNumeroMantenimiento,0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncTBCerrarFunncion(oModulo){

}



function FncVehiculoRecepcionVistaPreliminar(oId){

	FncPopUp('formularios/VehiculoRecepcion/FrmVehiculoRecepcionImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}





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



