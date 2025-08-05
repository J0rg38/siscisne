/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
 
 
$().ready(function() {

	
/*
Agregando Eventos
*/

	$("select#CmpMonedaId").change(function(){
		FncCuentaCargar();
	});


});
	

/*
* Configuraciones
*/
var Modulo = "IngresoCaja";

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

function FncEditarSeleccionado(){
	
	var seleccionados = $("#cmp_seleccionados").val();
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		aux = seleccionados.split("#");
			
		if((aux.length-1)>1){
			alert("Solo puede escoger un elemento");
		}else{
			$('input[type=checkbox]').each(function () {
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						window.location.href = "principal.php?Mod="+Modulo+"&Form=Editar&Id="+$(this).val();
					}
				}			 
			});
			
		}
	}
	
}




function FncVerSeleccionado(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		aux = seleccionados.split("#");

		if((aux.length-1)>1){
			alert("Solo puede escoger un elemento");
		}else{
			$('input[type=checkbox]').each(function () {
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						window.location.href = "principal.php?Mod="+Modulo+"&Form=Ver&Id="+$(this).val();
					}
				}			 
			});
			
		}
	}

}


function FncGenerarExcel(){
	document.getElementById("FrmListado").action = "formularios/"+Modulo+"/acc/Acc"+Modulo+"GenerarExcel.php"
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
}

function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/"+Modulo+"/Frm"+Modulo+"ListadoImprimir.php"
	document.getElementById("FrmListado").target = '_blank';
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
	document.getElementById("FrmListado").target = '_self';
}








function FncActualizarEstadoAnuladoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ANULAR los ingresos a caja seleccionadas?")){
			
			$('input[type=checkbox]').each(function () {

//1,2,3,4,5
				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
						if(

						$(this).attr('estado')=="6" 
						
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("AnuladoIngresoCaja");
				$("#FrmListado").submit();	
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
		if(confirm("¿Realmente desea INGANULAR los INGEMBOLSO seleccionadas?")){
			
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
				$("#Acc").val("RealizadoIngresoCaja");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}

}








function FncImprmir(oId){
	
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Recibo) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){

			case "1":
			
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaImprimir2.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			
			case "3":
	
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaGenerarPDF.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			default:
				
				alert("No ha escogido una opcion valida");
				
			break;
					
		}
		
	}
	
	
}


function FncVistaPreliminar(oId){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Recibo) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
			break;
			
			case "2":
	
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "3":
	
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaGenerarPDF.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			default:
				
				alert("No ha escogido una opcion valida");
				
			break;
			
		
		}
		
	}

}


