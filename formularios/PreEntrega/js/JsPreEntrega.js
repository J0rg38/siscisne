/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Funciones complementarias
*/
function FncPreEntregaVerificar(){

	$.ajax({
		type: 'POST',
		url: 'formularios/PreEntrega/acc/AccPreEntregaVerificar.php',
		data: '',
		success: function(respuesta){

			if(respuesta != ""){
				$.ionSound.play("door_bell");
				//alert(respuesta);
				dhtmlx.message({ type:"error", text:respuesta,expire:5 });
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
	
	
	FncPreEntregaVerificar();

	setInterval("FncPreEntregaVerificar();",60000);
	
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

//Acciones - Borrar

function FncGenerarExcel(){


//	var Tipo = prompt("Escoja el tipo de reporte \n 1 = Resumido\n 2 = Detallado", "1");
			
//			if(Tipo !== null){
//				switch(Tipo.toUpperCase()){
//					case "1":
	document.getElementById("FrmListado").action = "formularios/PreEntrega/acc/AccPreEntregaGenerarExcel.php";
//					break;
					
//					case "2":
//	document.getElementById("FrmListado").action = "formularios/PreEntrega/acc/AccPreEntregaGenerarExcel2.php";
//					break;
//				
//				}
//				
//			}

	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";

}


function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/PreEntrega/FrmFichaIngresoListadoImprimir.php"
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



function FncEnviarOrdenTrabajoTallerSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE TRABAJO seleccionadas a TALLER?")){

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



			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						if(
							$(this).attr('personal')==""
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			
			
			if(actualizar){
				if(actualizar2){
					$("#Acc").val("EnviarOrdenTrabajoTaller");
					$("#FrmListado").submit();	
				}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique si tiene un TECNICO ASIGNADO.");					
				}
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a TALLER las ORDENES DE TRABAJO con estado: \n - RECEPCION [Pendiente]");
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
		if(confirm("¿Realmente desea REGRESAR las ORDENES DE TRABAJO seleccionadas a RECEPCION?")){

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
				$("#Acc").val("EnviarOrdenTrabajoRecepcion");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser REGRESADAS a RECEPCION las ORDENES DE TRABAJO con estado: \n\ - RECEPCION [Enviado]");
//				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}



function FncEnviarFichaIngresoAlmacenSeleccionados(){

var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE TRABAJO seleccionadas a ALMACEN?. ADVERTENCIA: No se puede revertir esta accion una vez realizada")){

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



			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						if(
							$(this).attr('personal')==""
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			
			
			if(actualizar){
				if(actualizar2){
					$("#Acc").val("EnviarOrdenTrabajoAlmacen");
					$("#FrmListado").submit();	
				}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique si tiene un TECNICO ASIGNADO.");					
				}
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a ALMACEN las ORDENES DE TRABAJO con estado: \n - RECEPCION [Pendiente]");
			}
			
		}
	}
	
	
}


/*
function FncEnviarOrdenTrabajoContabilidadSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE TRABAJO a CONTABILIDAD de los elementos seleccionados?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

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

						if(
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							
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
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}
*/



/*
* IMPRESION
*/

function FncImprmir(oId){
	
		var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato PDS \n 2 = Ficha Tecnica\n 3 = Pre-Entrega ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimirPDS.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimirFT.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
					break;

					case "3":

						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);


					break;


				
				}
				
			}

}


function FncVistaPreliminar(oId){
	
var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato PDS \n 2 = Ficha Tecnica\n 3 = Pre-Entrega ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
						
						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimirPDS.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
						
					break;
					
					case "2":
	
						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;

					case "3":

						FncPopUp('formularios/PreEntrega/FrmPreEntregaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;

				}
				
			}

}

function FncVehiculoRecepcionVistaPreliminar(oId){

	FncPopUp('formularios/VehiculoRecepcion/FrmVehiculoRecepcionImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

/*
* FORMULARIOS
*/


function FncClienteCargarFormulario(oForm,oClienteId){

	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId)
//	function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){

//	tb_show(this.title,'principal2.php?Mod=VehiculoIngreso&Form='+oForm+'&Dia=1&Id='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncCampanaCargarFormulario(oForm,oCampanaId){

	tb_show(this.title,'principal2.php?Mod=Campana&Form='+oForm+'&Dia=1&Id='+oCampanaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}



function FncFichaAccionModalidadIngresoEditar(oFichaIngresoId){

	tb_show(this.title,'principal2.php?Mod=FichaAccionModalidadIngreso&Form=Editar&Dia=1&Id='+oFichaIngresoId+
'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		

}


function FncFichaIngresoModalidadIngresoEditar(oFichaIngresoId){

	FncCargarVentana("FichaIngresoModalidadIngreso","Editar",oFichaIngresoId);
	
}


function FncTallerPedidoModalidadIngresoEditar(oFichaIngresoId){

	FncCargarVentana("TallerPedidoModalidadIngreso","Editar",oFichaIngresoId);
	
}




function FncTBCerrarFunncion(oModulo){

}

