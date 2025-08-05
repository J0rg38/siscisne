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







function FncEncuestaImprmir(oId){
	
	FncPopUp('formularios/EncuestaVenta/FrmEncuestaVentaImprimir.php?Id=&Ta=&P=1&Tipo=VENTA&Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncEncuestaVistaPreliminar(oId){

	FncPopUp('formularios/EncuestaVenta/FrmEncuestaVentaImprimir.php?Id=&Ta=&Tipo=VENTA&Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
}



//
//
//function FncEncuestaImprmir(){
//	
//	var Tipo = prompt("Escoja el tipo de encuesta \n 1 = VENTA \n 2 = POSTVENTA", "1");
//			
//	if(Tipo !== null){
//		switch(Tipo.toUpperCase()){
//			case "1":
//			
//				FncPopUp('formularios/EncuestaVenta/FrmEncuestaImprimir2.php?Id=&Ta=&P=1&Tipo=VENTA',0,0,1,0,0,1,0,screen.height,screen.width);
//
//			break;
//			
//			case "2":
//	
//				FncPopUp('formularios/EncuestaVenta/FrmEncuestaImprimir2.php?Id=&Ta=&P=1&Tipo=POSTVENTA',0,0,1,0,0,1,0,screen.height,screen.width);
//	
//			break;
//
//		}
//
//	}
//
//}
//
//
//function FncEncuestaVistaPreliminar(){
//
//	var Tipo = prompt("Escoja el tipo de encuesta \n 1 = VENTA \n 2 = POSTVENTA", "1");
//	
//	if(Tipo !== null){
//		switch(Tipo.toUpperCase()){
//			case "1":
//			
//				FncPopUp('formularios/EncuestaVenta/FrmEncuestaImprimir2.php?Id=&Ta=&Tipo=VENTA',0,0,1,0,0,1,0,screen.height,screen.width);
//	
//			break;
//			
//			case "2":
//	
//				FncPopUp('formularios/EncuestaVenta/FrmEncuestaImprimir2.php?Id=&Ta=&Tipo=POSTVENTA',0,0,1,0,0,1,0,screen.height,screen.width);
//	
//			break;
//		
//		}
//		
//	}
//
//}
