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
	document.getElementById("FrmListado").action = "formularios/CotizacionProducto/acc/AccCotizacionGenerarExcel.php";
//					break;
//					
//					case "2":
//	document.getElementById("FrmListado").action = "formularios/CotizacionProducto/acc/AccCotizacionGenerarExcel2.php";
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




function FncEnviarCotizacionProductoAlmacenSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las COTIZACIONES   a ALMACEN de los elementos seleccionados?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if($(this).attr('estado')=="2" || $(this).attr('estado')=="3" || $(this).attr('estado')=="4" || $(this).attr('estado')=="5"){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("EnviarCotizacionProductoAlmacen");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}






function FncEnviarCotizacionProductoVentasSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea CANCELAR EL ENVIO de las COTIZACIONES   a ALMACEN de los elementos seleccionados?")){
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						
						if(
						$(this).attr('estado')=="1" 
						//|| $(this).attr('estado')=="2" 
						|| $(this).attr('estado')=="3" 
						|| $(this).attr('estado')=="4" 
						|| $(this).attr('estado')=="5"
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("EnviarCotizacionProductoVentas");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}







function FncActualizarEstadoAnuladoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ANULAR las COTIZACIONES seleccionadas?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
						$(this).attr('estado')=="2" || 
						$(this).attr('estado')=="3" || 
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

			if(actualizar){
				$("#Acc").val("AnularCotizacionProducto");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}

}





function FncActualizarEstadoDesanuladoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea DESANULAR las COTIZACIONES seleccionadas?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						$(this).attr('estado')=="1" || 
						$(this).attr('estado')=="2" || 
						$(this).attr('estado')=="3" || 
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
				$("#Acc").val("DesanularCotizacionProducto");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}

}







/*
* FUNCIONES IMPRESION
*/

function FncImprmir(oId){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Cotizacion c/ Codigo) \n 2 = Formato 2 (Cotizacion s/ Codigo) \n 3 = Formato 3 (Cotizacion c/ Tipo Pedido)", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&P=1&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&P=1+ImprimirCodigo=1&ImprimirPedido=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}
			

}


function FncVistaPreliminar(oId){
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Cotizacion c/ Codigo) \n 2 = Formato 2 (Cotizacion s/ Codigo) \n 3 = Formato 3 (Cotizacion c/ Tipo Pedido)", "1");	
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
					break;
					
					case "2":

FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&ImprimirCodigo=1&ImprimirPedido=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}
		

}


function FncGenerarPDF(oId){
	
	
	//var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Cotizacion c/ Codigo) \n 2 = Formato 2 (Cotizacion s/ Codigo) \n 3 = Formato 3 (Cotizacion c/ Tipo Pedido)", "1");	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Cotizacion c/ Codigo) \n 2 = Formato 2 (Cotizacion s/ Codigo)", "1");	
	
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
	FncPopUp('formularios/CotizacionProducto/acc/AccCotizacionProductoGenerarPDF.php?Id='+oId+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "2":
	
	FncPopUp('formularios/CotizacionProducto/acc/AccCotizacionProductoGenerarPDF.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
		
		//	case "3":
//
//	FncPopUp('formularios/CotizacionProducto/AccCotizacionProductoGenerarPDF.php?Id='+oId+'&ImprimirCodigo=1&ImprimirPedido=1',0,0,1,0,0,1,0,screen.height,screen.width);
//
//			break;
					
		}
		
	}
		

}





function FncClienteCargarFormulario(oForm,oClienteId){

	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId)
	//function FncVehiculoIngresoSimpleCargarFormulario(oForm,oVehiculoIngresoId){

	//LOLtb_show(this.title,'principal2.php?Mod=VehiculoIngreso&Form='+oForm+'&Dia=1&Id='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncFichaIngresoCargarFormulario(oForm,oFichaIngresoId){

	tb_show(this.title,'principal2.php?Mod=FichaIngreso&Form='+oForm+'&Dia=1&Id='+oFichaIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}





function FncTBCerrarFunncion(oModulo){

}






function FncEditarVentaPerdidaSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		   
		var Tipo = prompt("Escoja una opcion \n 0 = Normal \n 1 = Venta Perdida por Precio \n 2 = Venta Perdida por Disponibilidad \n 3 = Venta Perdida por Importacion", "0");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "0":
						document.getElementById('Acc').value= 'ActualizarObservadoNormal';
						$("#FrmListado").submit();
					break;
					
					case "1":
						document.getElementById('Acc').value= 'ActualizarObservadoPrecio';
						$("#FrmListado").submit();
					break;				

					case "2":
						document.getElementById('Acc').value= 'ActualizarObservadoDisponibilidad';
						$("#FrmListado").submit();
					break;		
					
						case "3":
						document.getElementById('Acc').value= 'ActualizarObservadoImportacion';
						$("#FrmListado").submit();
					break;				

					default:
						alert("No ha escogido una opcion valida");
					break;


				}
				
			}
	}
}




function FncActualizarNivelInteresSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		var Tipo = prompt("Escoja una accion \n 1 = Normal \n 2 = Interesado \n 3 = Muy Interesado \n 4 = Venta Concluida", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres1");
							$("#FrmListado").submit();	
						}
					
					break;
					
					case "2":
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres2");
							$("#FrmListado").submit();	
						}
					break;
					
					case "3":
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres3");
							$("#FrmListado").submit();	
						}
					break;
					
					case "4":
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres4");
							$("#FrmListado").submit();	
						}
					break;
					
					default:
						dhtmlx.alert({
						title:"Aviso",
						type:"alert-error",
						text:"No escogio una accion",
						callback: function(result){
						
						}
					});
					break;
				
				}
				
			}
			
			
		
			
		 
	}
	
}

