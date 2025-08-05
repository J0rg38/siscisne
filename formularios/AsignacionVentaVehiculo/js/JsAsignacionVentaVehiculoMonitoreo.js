


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
	
	
		$('input[type=checkbox]').each(function () {
			if($(this).attr('name')=="cmp_seleccionar[]"){
				
				var Id = $(this).val();
				
				$("#CmpOrdenVentaVehiculoObservacionAsignacion_"+Id).keyup(function(){
								
					 clearTimeout($.data(this, 'timer'));
					  var wait = setTimeout("FncAsignacionVentaVehiculoMonitoreoEditarCampo('OvvObservacionAsignacion','CmpOrdenVentaVehiculoObservacionAsignacion','"+Id+"');", 1500);
					  $(this).data('timer', wait);


				});
								
								
			}			 			
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





/*
* FORMULARIOS
*/

function FncClienteCargarFormulario(oForm,oClienteId){

	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId);
	
	
}
function FncPagoOrdenVentaVehiculoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form='+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


/*
* FORMULARIOS
*/


function FncOrdenVentaVehiculoVistaPreliminar(oId){

	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncOrdenVentaVehiculoVistaPreliminarOV(oId){

	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirOV.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}




function FncAsignacionVentaVehiculoAnular(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		if(confirm("¿Realmente desea anular la orden?")){
			$("#Acc").val("Anular");
			$("#FrmListado").submit();	
		}
		
	}
	
	
	
}


function FncAsignacionVentaVehiculoRechazar(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		if(confirm("¿Realmente desea rechazar la orden?")){
			$("#Acc").val("Rechazar");
			$("#FrmListado").submit();	
		}
		
	}
	
	
}





function FncGenerarExcel(){


	document.getElementById("FrmListado").action = "formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoMonitoreoGenerarExcel.php";

			
			
	$('#CmpSucursal').removeAttr('disabled');	
	$('#CmpPersonal').removeAttr('disabled');	

	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";

	$('#CmpSucursal').attr('disabled', true);
	$('#CmpPersonal').attr('disabled', true);
	//location.reload();
}




function FncAsignacionVentaVehiculoMonitoreoEditarCampo(oCampo,oInput,oId){
	
	console.log("FncAsignacionVentaVehiculoMonitoreoEditarCampo");

	
	var Dato = $("#"+oInput+"_"+oId).val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoEditarCampo.php',
		data: '&Campo='+oCampo+'&Dato='+Dato+'&Id='+oId,
		success: function(html){
		
			//$("#CapVehiculoIngresoActualizarEntrega_"+oSigla).html(html);
			console.log("ResultadoEditar: "+html);
	
		}
	});


}