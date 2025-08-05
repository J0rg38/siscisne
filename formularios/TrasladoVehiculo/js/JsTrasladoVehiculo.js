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
	document.getElementById("FrmListado").action = "formularios/TrasladoVehiculo/acc/AccTrasladoVehiculoGenerarExcel.php";
					break;
					
					case "2":
	document.getElementById("FrmListado").action = "formularios/TrasladoVehiculo/acc/AccTrasladoVehiculoGenerarExcel2.php";
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
							$(this).attr('nota_credito_compra')=="Si"
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
				
				alert("Uno o mas de los elementos seleccionados no puede ser ELIMINADO, verifique si tiene NOTA DE CREDITO DE COMPRA.");
									
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







/************************************************************/
//IMPRESION

function FncImprmir(oId){
	FncPopUp('formularios/TrasladoVehiculo/FrmTrasladoVehiculoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId){
	FncPopUp('formularios/TrasladoVehiculo/FrmTrasladoVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}








/*
* FORMULARIOS
*/


function FncProveedorCargarFormulario(oForm,oProveedorId){

	tb_show(this.title,'principal2.php?Mod=Proveedor&Form='+oForm+'&Dia=1&Id='+oProveedorId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncOrdenCompraCargarFormulario(oForm,oOrdenCompraId){

	tb_show(this.title,'principal2.php?Mod=OrdenCompra&Form='+oForm+'&Dia=1&Id='+oOrdenCompraId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncNotaCreditoCompraListado(oTveId){
	
	//FncPopUp('formularios/TrasladoVehiculo/DiaNotaCreditoCompraListado.php?TveId='+oTveId,0,0,1,0,0,1,0,screen.height,screen.width);
	
	tb_show(this.title,'formularios/TrasladoVehiculo/DiaNotaCreditoCompraListado.php?TveId='+oTveId,this.rel);		
	
}


/*
* VISTAS PRELIMINARES
*/

function FncOrdenCompraVistaPreliminar(oId){
	FncPopUp('formularios/OrdenCompra/FrmOrdenCompraImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}





