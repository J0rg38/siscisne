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


/*
Estado Reservado
*/


function FncGenerarExcel(){
	document.getElementById("FrmListado").action = "formularios/Factura/acc/AccFacturaGenerarExcel.php"
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
}

function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/Factura/FrmFacturaListadoImprimir.php"
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







/* 
* ACCIONES SELECTIVAS
*/

function FncVentaConcretadaActualizarNoFacturableSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		if(confirm("¿Realmente desea MARCAR como NO FACTURABLE los elementos seleccionados?")){
			$("#Acc").val("ActualizarNoFacturable");
			$("#FrmListado").submit();	
		}
	}
	
}



function FncVentaConcretadaActualizarFacturableSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		if(confirm("¿Realmente desea MARCAR como FACTURABLE los elementos seleccionados?")){
			$("#Acc").val("ActualizarFacturable");
			$("#FrmListado").submit();	
		}
	}
	
}



function FncVentaConcretadaGenerarFacturaSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	var cliente_ant = "";
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{


		$('input[type=checkbox]').each(function () {
				
			if($(this).attr('name')=="cmp_seleccionar[]"){
				if($(this).is(':checked')){
					
					
					if($(this).attr('cliente')!=cliente_ant && cliente_ant != ""){
						actualizar = false;
						
						return false;
					}
					
					cliente_ant = $(this).attr('cliente');
				}
			}
		
		});	
			
		if(actualizar){
			
			if(confirm("¿Realmente desea GENERAR FACTURA con los elementos seleccionados?")){
				
				$("#FrmListado").attr("action","principal.php?Mod=Factura&Form=Registrar&Ori=VentaConcretada");
				$("#FrmListado").submit();	
				$("#FrmListado").attr("action","#");

			}
			
		}else{
			alert("Verifique que las fichas pertenezcan al mismo cliente");
		}
		

	}

}


function FncVentaConcretadaGenerarBoletaSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	var cliente_ant = "";
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{


		$('input[type=checkbox]').each(function () {
				
			if($(this).attr('name')=="cmp_seleccionar[]"){
				if($(this).is(':checked')){
					
					
					if($(this).attr('cliente')!=cliente_ant && cliente_ant != ""){
						actualizar = false;
						
						return false;
					}
					
					cliente_ant = $(this).attr('cliente');
				}
			}
		
		});	
			
		if(actualizar){
			
			
			if(confirm("¿Realmente desea GENERAR BOLETA con los elementos seleccionados?")){
				$("#FrmListado").attr("action","principal.php?Mod=Boleta&Form=Registrar&Ori=VentaConcretada");
				$("#FrmListado").submit();	
				$("#FrmListado").attr("action","#");
			}
			
		}else{
			alert("Verifique que las fichas pertenezcan al mismo cliente");
		}
		

	}

}


/**
* ACCIONES GENERALES
*/

function FncComprobanteVentaMonitoreoFichaIngresoGenerarExcel(){
	
		document.getElementById("FrmListado").action = "formularios/ComprobanteVenta/acc/AccComprobanteVentaMonitoreoVentaConcretadaGenerarExcel.php"
		document.getElementById("FrmListado").submit();
		document.getElementById("FrmListado").action = "#";
	
	
}


/*
* VISTAS PRELIMINARES
*/
function FncVentaConcretadaVistaPreliminar(oId){
	
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncAlmacenMovimientoSalidaVistaPreliminar(oId){
	
	FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
}


function FncVentaDirectaVistaPreliminar(oId){

	FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}



/*
* CARGA DE FORMULARIOS
*/



function FncVentaConcretadaCargarFormulario(oForm,oVentaConcretadaId){

	tb_show(this.title,'principal2.php?Mod=VentaConcretada&Form='+oForm+'&Dia=1&Id='+oVentaConcretadaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncVentaDirectaCargarFormulario(oForm,oVentaConcretadaId){

	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaConcretadaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncCotizacionProductoCargarFormulario(oForm,oCotizacionProductoId){

	tb_show(this.title,'principal2.php?Mod=CotizacionProducto&Form='+oForm+'&Dia=1&Id='+oCotizacionProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncPagoOrdenVentaVehiculoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoOrdenVentaVehiculo&Form='+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){
	//tb_show(this.title,'principal2.php?Mod=&Form='+oForm+'&Dia=1&Id='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width='+Ancho+'&modal=true',this.rel);		
	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}

function FncPagoVentaDirectaCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=PagoVentaDirecta&Form='+oForm+'&Dia=1&VdiId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}
