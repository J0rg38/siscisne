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


//Acciones - Declarar

function FncImprmir(oId){
	
//	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Ficha Ingreso General\n 2 = Ficha de Salida de Taller \n 3 = Ficha Tecnica", "1");
//			
//			if(Tipo !== null){
//				switch(Tipo.toUpperCase()){
//					case "1":
					
FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

//					break;
//					
//					case "2":
//
//FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirST.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
//
//					break;
//
//					case "3":
//
//FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
//
//					break;
//				
//				}
//				
//			}

}


function FncVistaPreliminar(oId){
	
	//var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Ficha Ingreso General\n 2 = Ficha de Salida de Taller \n 3 = Ficha Tecnica", "1");
			
			//if(Tipo !== null){
//				switch(Tipo.toUpperCase()){
//					case "1":
					
	FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

//					break;
//					
//					case "2":
//
//FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirST.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
//
//					break;
//
//					case "3":
//
//FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
//
//					break;

				
				//}
				
			//}

}




//
//
//function FncGenerarAlmacenMovimientoSalidaSeleccioados(){
//
//	var seleccionados = $("#cmp_seleccionados").val();
//	var transferir = true;
//
//	if(seleccionados==""){
//		alert("No ha seleccionado ningun elemento.");
//	}else{
//		
//		aux = seleccionados.split("#");
//		
//		if((aux.length-1)>1){
//			alert("Solo puede escoger un elemento");
//		}else{
//			
//			if(confirm("¿Realmente desea GENERAR UNA SALIDA DE ALMACEN con los elementos seleccionados?")){
//				
////				$('input[type=checkbox]').each(function () {
////	
////					if($(this).attr('name')=="cmp_seleccionar[]"){
////						if($(this).is(':checked')){
////							if($(this).attr('title')=="6"){
////								transferir = false;
////								return false;
////							}
////	
////						}
////					}
////	
////				});
//				
//				//if(transferir){
//					document.getElementById('FrmListado').action = "principal.php?Mod=AlmacenMovimientoSalida&Form=Registrar&Ori=FichaIngreso"//5
//					$("#FrmListado").submit();
//					document.getElementById('FrmListado').action = "#";	
//				//}else{
////					alert("Uno o mas de los elementos seleccionados no puede ser marcado para DEVOLUCION por su ESTADO.");
////				}
//				
//			}
//
//			
//		}
//		
//		
//		
//	}
//}