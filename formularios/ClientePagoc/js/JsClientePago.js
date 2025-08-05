/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$().ready(function() {
	$("#CapListadoTotal").html($("#CmpListadoTotal").val());
});

/*
* Funciones complementarias
*/

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

	$('input[type=checkbox]').each(function () {
		
		if($(this).is(':checked')){
			if($(this).attr('name')=="cmp_seleccionar[]"){
				seleccionados = seleccionados + '#'+ $(this).val();
			}
		}
		
	});
		
	$("#cmp_seleccionados").val(seleccionados);

}
//Acciones - Borrar

/*function FncBorrarSeleccionado(id){
	if(confirm("¿Realmente desea borrar el elemento?")){
		$("#cmp_seleccionados").val(id);
		$("#Acc").val("Borrar");
		
		$("#FrmListado").submit();
	}
}

function FncBorrarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea borrar los elementos seleccionados?")){
			$("#Acc").val("Borrar");
			$("#FrmListado").submit();
		}
	}
	
}*/



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

		if(confirm("¿Realmente desea eliminar los elementos seleccionados?")){
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if($(this).attr('accept')=="2"){
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
				alert("Uno o mas de los elementos seleccionados estan bloqueados por cierre de caja.");
			}
			
		}
	}
	
}






/*



*/