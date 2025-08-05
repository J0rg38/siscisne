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
			
//			if(Tipo !== null){
//				switch(Tipo.toUpperCase()){
//					case "1":
	document.getElementById("FrmListado").action = "formularios/VentaConcretada/acc/AccVentaConcretadaGenerarExcel.php";
//					break;
//					
//					case "2":
//	document.getElementById("FrmListado").action = "formularios/VentaConcretada/acc/AccVentaConcretadaGenerarExcel2.php";
//					break;
//				
//				}
//				
//			}
//			
			

	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
	

}


function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/VentaConcretada/FrmVentaConcretadaListadoImprimir.php"
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
function FncEnviarVentaConcretadaContabilidadSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las ORDENES DE VENTA a CONTABILIDAD de los elementos seleccionados?")){

			$('input[type=checkbox]').each(function () {
				//2,3,4,5,6,7,8,9
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if($(this).attr('factura')=="Si" || $(this).attr('estado')=="1" ){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("EnviarVentaConcretadaContabilidad");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}

*/




function FncActualizarEstadoPendienteSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
	var actualizar2 = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea actualizar a NO REALIZADO las VENTAS CONCRETADAS seleccionadas?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
						$(this).attr('estado')=="1"
					
						){
							actualizar = false;
							return false;
						}

					}
				}
				
				
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
						$(this).attr('guia_remision')=="Si" ||
						$(this).attr('factura')=="Si" ||
						$(this).attr('boleta')=="Si"
						
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				if(actualizar2){
		
					$("#Acc").val("AnularVentaConcretada");
					$("#FrmListado").submit();	
			
				}else{
					alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique que no tenga comprobante emitido (factura, boleta o guia de remision).");		
				}
			}else{
				
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");	
				
			}
			
		}
	}

}





function FncActualizarEstadoRealizadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea actualizar a estado REALIZADO las VENTAS CONCRETADAS seleccionadas?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
						$(this).attr('estado')=="3" 
						
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("DesanularVentaConcretada");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}

}





function FncGenerarGuiaRemisionSeleccionados(){

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

			if(confirm("¿Realmente desea GENERAR GUIA DE REMISION con los elementos seleccionados?")){

				$("#FrmListado").attr("action","principal.php?Mod=GuiaRemision&Form=Registrar&Ori=VentaConcretada");
				$("#FrmListado").submit();	
				$("#FrmListado").attr("action","#");

			}

		}else{
			alert("Verifique que las fichas pertenezcan al mismo cliente");
		}

	}

}


function FncVentaConcretadaCargarFormulario(oForm,oVentaConcretadaId){

	tb_show(this.title,'principal2.php?Mod=VentaConcretada&Form='+oForm+'&Dia=1&Id='+oVentaConcretadaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncVentaDirectaCargarFormulario(oForm,oVentaConcretadaId){

	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaConcretadaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncCotizacionProductoCargarFormulario(oForm,oCotizacionProductoId){

	tb_show(this.title,'principal2.php?Mod=CotizacionProducto&Form='+oForm+'&Dia=1&Id='+oCotizacionProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}





/************************************************************/
//IMPRESION

function FncVentaConcretadaImprmir(oId){
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVentaConcretadaVistaPreliminar(oId){
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVentaConcretadaGenerarPDF(oId){
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Venta Concretada c/ Codigo) \n 2 = Formato 2 (Venta Concretada s/ Codigo) \n 3 = Formato 3 (Guia de Salida)", "3");	
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/VentaConcretada/acc/AccVentaConcretadaGenerarPDF.php?Id='+oId+'&ImprimirCodigo=1&ImprimirPrecio=1',0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

						FncPopUp('formularios/VentaConcretada/acc/AccVentaConcretadaGenerarPDF.php?Id='+oId+'&ImprimirPrecio=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

						FncPopUp('formularios/VentaConcretada/acc/AccVentaConcretadaGenerarPDF.php?Id='+oId+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
					break;
				
				}
				
			}
		

}














/*
* VISTA PRELIMINAR
*/



function FncGuiaRemisionVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");			
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/GuiaRemision/FrmGuiaRemisionImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}








function FncFacturaVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");			
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/Factura/FrmFacturaImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}







function FncBoletaVistaPreliminar(oId,oTalonario){
	


	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

						FncPopUp('formularios/Boleta/FrmBoletaImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}




function FncVentaDirectaVistaPreliminar(oId){
	
	FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncCotizacionProductoVistaPreliminar(oId){
		
	FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);

}
