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


	var Tipo = prompt("Escoja el tipo de reporte \n 1 = Resumido\n 2 = Detallado", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
	document.getElementById("FrmListado").action = "formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaGenerarExcel.php";
					break;
					
					case "2":
	document.getElementById("FrmListado").action = "formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaGenerarExcel2.php";
					break;
				
				}
				
			}
			
			

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
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

						if(
							$(this).attr('nota_credito_compra')=="Si" ||
							$(this).attr('cierre')=="1"
						){
							eliminar = false;
							return false;
						}

					}
				}

			});
			
			if(eliminar){
				
				$("#Acc").val("Eliminar");
				$("#FrmListado").submit();	

			}else{
				
				alert("Uno o mas de los elementos seleccionados no puede ser eliminado. Verifique si tiene Nota de Credito o se encuentra cerrado.");
									
			}
			

		}
	}
	
}


//Acciones - Declarar


function FncMarcarRevisadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{


		var Tipo = prompt("Escoja una opcion \n 1 = Marcar como REVISADO \n 2 = Marcar como NO REVISADO", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
						document.getElementById('Acc').value= 'RevisadoSi';
						$("#FrmListado").submit();
					break;
					
					case "2":
						document.getElementById('Acc').value= 'RevisadoNo';
						$("#FrmListado").submit();
					break;
					
					default:
						alert("Opcion no encontrada");
					break;
				
				}
				
			}
			
	}
}






function FncActualizarEstadoPendienteSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea actualizar como No Realizado los ingresos a almacen seleccionados?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						

						$(this).attr('estado')=="1" ||
						$(this).attr('guia_remision')=="Si" ||
						$(this).attr('factura')=="Si" ||
						$(this).attr('boleta')=="Si" ||
						$(this).attr('cierre')=="1"
						
						
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				
					$("#Acc").val("ActualizarAlmacenMovimientoEntradaEstadoPendiente");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado. Verifique si tiene Nota de Credito o se encuentra cerrado.");
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
		if(confirm("¿Realmente desea actualizar como Realizado los ingresos a almacen seleccionados?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(
						
						$(this).attr('estado')=="3"||
						$(this).attr('cierre')=="1"
						
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("ActualizarAlmacenMovimientoEntradaEstadoRealizado");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado. Verifique si tiene Nota de Credito o se encuentra cerrado.");
			}
			
		}
	}

}



/************************************************************/
//IMPRESION

function FncImprmir(oId){
	FncPopUp('formularios/AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId){
	FncPopUp('formularios/AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}













function FncProveedorCargarFormulario(oForm,oProveedorId){

	tb_show(this.title,'principal2.php?Mod=Proveedor&Form='+oForm+'&Dia=1&Id='+oProveedorId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}



function FncOrdenCompraCargarFormulario(oForm,oOrdenCompraId){

	tb_show(this.title,'principal2.php?Mod=OrdenCompra&Form='+oForm+'&Dia=1&Id='+oOrdenCompraId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}




