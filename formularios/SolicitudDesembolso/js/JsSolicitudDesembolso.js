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
			
//			if(Tipo !== null){
//				switch(Tipo.toUpperCase()){
//					case "1":
	document.getElementById("FrmListado").action = "formularios/SolicitudDesembolso/acc/AccSolicitudDesembolsoGenerarExcel.php";
//					break;
//					
//					case "2":
//	document.getElementById("FrmListado").action = "formularios/SolicitudDesembolso/acc/AccSolicitudDesembolsoGenerarExcel2.php";
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
	
	document.getElementById("FrmListado").action = "formularios/SolicitudDesembolso/FrmSolicitudDesembolsoListadoImprimir.php"
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
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No ha seleccionado ningun elemento.",
					callback: function(result){

					}
				});	
	}else{

		if(confirm("¿Realmente desea ELIMINAR los elementos seleccionados?")){
			$("#Acc").val("Eliminar");
			$("#FrmListado").submit();	
		}
	}
	
}



//
//function FncEnviarCotizacionProductoContabilidadSeleccionados(){
//
//	var seleccionados = $("#cmp_seleccionados").val();
//	var actualizar = true;
//	
//	if(seleccionados==""){
//		dhtmlx.alert({
//					title:"Aviso",
//					type:"alert-error",
//					text:"No ha seleccionado ningun elemento.",
//					callback: function(result){
//
//					}
//				});	
//	}else{
//		if(confirm("¿Realmente desea ENVIAR las ORDENES DE VENTA a CONTABILIDAD de los elementos seleccionados?")){
//
//			$('input[type=checkbox]').each(function () {
//				//2,3,4,5,6,7,8,9
//				if($(this).attr('name')=="cmp_seleccionar[]"){
//					if($(this).is(':checked')){
//						if($(this).attr('factura')=="Si" || $(this).attr('estado')=="1" ){
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
//				$("#Acc").val("EnviarSolicitudDesembolsoContabilidad");
//				$("#FrmListado").submit();	
//			}else{
//				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
//			}
//			
//		}
//	}
//
//}
//




function FncGenerarOrdenCompraSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No ha seleccionado ningun elemento.",
					callback: function(result){

					}
				});	
	}else{
		if(confirm("¿Realmente desea GENERAR la ORDEN DE COMPRA con los elementos seleccionados?")){

			$('input[type=checkbox]').each(function () {
				//2,3,4,5,6,7,8,9
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if($(this).attr('orden_compra') != "" ){
							actualizar = false;
							return false;
						}

					}
				}

			});
			
			

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						
						
						var MonedaId = $(this).attr('moneda');
					
						$('input[type=checkbox]').each(function () {
			
							if($(this).attr('name')=="cmp_seleccionar[]"){
								if($(this).is(':checked')){
									
									if( $(this).attr('moneda') != MonedaId ){
										actualizar2 = false
										return false;
									}
									
								}
							}
			
						});
			
			
						
					}
				}

			});
			

			if(actualizar){
				
				if(actualizar2){
				
					$("#FrmListado").attr("action","principal.php?Mod=OrdenCompra&Form=Registrar&Ori=SolicitudDesembolso");
					$("#FrmListado").submit();	
					$("#FrmListado").attr("action","#");
				
				}else{
					alert("Uno o mas de los elementos seleccionados no puede ser incluido, tiene MONEDA distinta.");
				}
				//$("#Acc").val("GenerarOrdenCompra");
				//$("#FrmListado").submit();	
				
					
					
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser incluido, ya tiene ORDEN DE COMPRA.");
			}
			
		}
	}

}





function FncVentaDirectaCargarFormulario(oForm,oVentaDirectaId){

	tb_show(this.title,'principal2.php?Mod=VentaDirecta&Form='+oForm+'&Dia=1&Id='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncCotizacionProductoCargarFormulario(oForm,oCotizacionProductoId){

	tb_show(this.title,'principal2.php?Mod=CotizacionProducto&Form='+oForm+'&Dia=1&Id='+oCotizacionProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncOrdenCompraCargarFormulario(oForm,oOrdenCompraId){

	tb_show(this.title,'principal2.php?Mod=OrdenCompra&Form='+oForm+'&Dia=1&Id='+oOrdenCompraId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncTBCerrarFunncion(oModulo){

}







function FncVentaDirectaVistaPreliminar(oId){
	
	FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncCotizacionProductoVistaPreliminar(oId){
		
	FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncOrdenCompraVistaPreliminar(oId){
		
	FncPopUp('formularios/OrdenCompra/FrmOrdenCompraImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncFichaIngresoVistaPreliminar(oId){
		
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}



function FncActualizarAprobadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;

	if(seleccionados==""){
		
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No ha seleccionado ningun elemento.",
					callback: function(result){

					}
				});	
		
		
				
				
	}else{
		
		dhtmlx.confirm("¿Realmente marcar como APROBADO los elementos seleccionados?", function(result){
			if(result==true){		
				
				aux = seleccionados.split("#");
				
				if((aux.length-1)>1){
					var actualizar = false;			
				}
	
				if(actualizar){
					
					$("#Acc").val("ActualizarAprobado");
					$("#FrmListado").submit();	
				
				}else{
					

					dhtmlx.alert({
						title:"Aviso",
						//type:"alert-error",
						type:"alert",
						text: "Solo puede escoger un elemento",
						callback: function(result){
							
						}
					});
					
					
				}
					
			}else{
				
			}
		});
		
		
		//if(confirm("¿Realmente marcar como APROBADO los elementos seleccionados?")){
//			aux = seleccionados.split("#");
//			
//			if((aux.length-1)>1){
//				var actualizar = false;			
//			}
//
//			if(actualizar){
//				
//				$("#Acc").val("ActualizarAprobado");
//				$("#FrmListado").submit();	
//			
//			}else{
//				
//				alert("Solo puede escoger un elemento");
//				
//			}
//
//		}
//		
	}

}



function FncActualizarDesaprobadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;

	if(seleccionados==""){
		
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No ha seleccionado ningun elemento.",
					callback: function(result){

					}
				});	
		
	}else{
		
		
		dhtmlx.confirm("¿Realmente deseas marcar como DESAPROBADO los elementos seleccionados?", function(result){
			if(result==true){		
				
				aux = seleccionados.split("#");
			
				if((aux.length-1)>1){
					var actualizar = false;			
				}
	
				if(actualizar){
					
					$("#Acc").val("ActualizarDesaprobado");
					$("#FrmListado").submit();	
				
				}else{
					
					dhtmlx.alert({
						title:"Aviso",
						//type:"alert-error",
						type:"alert",
						text: "Solo puede escoger un elemento",
						callback: function(result){
							
						}
					});
					
				}
	
			}else{
				
			}
		});
		
		
		
		//if(confirm("¿Realmente deseas marcar como DESAPROBADO los elementos seleccionados?")){
//			aux = seleccionados.split("#");
//			
//			if((aux.length-1)>1){
//				var actualizar = false;			
//			}
//
//			if(actualizar){
//				
//				$("#Acc").val("ActualizarDesaprobado");
//				$("#FrmListado").submit();	
//			
//			}else{
//				
//				alert("Solo puede escoger un elemento");
//				
//			}
//
//		}
		
	}

}

function FncSolicitudDesembolsoSolicitarAutorizacion(oId,oAprobado){
	console.log("test");
	if(oAprobado == "2"){
		
		window.location = "principal.php?Mod=SolicitudDesembolso&Form=SolicitarAutorizacion&Id="+oId;	
		
	}else{
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Esta solicitud ya se encuentra aprobado",
			callback: function(result){
		
			}
		});	
		
	}

}

			