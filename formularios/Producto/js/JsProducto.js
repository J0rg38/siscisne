/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Funciones complementarias
*/
$(document).ready(function (){
	
//	function toncheck(id, state) {	
//		document.getElementById('CmpCategoria').value = tree.getAllChecked();
//	};
//	 
//	tree = new dhtmlXTreeObject("treeboxbox_tree", "100%", "100%", 0);
//	 
//	tree.setSkin('dhx_skyblue');
//	tree.setImagePath(RutLibrerias+"dhtmlxTree/dhtmlxTree/codebase/imgs/csh_bluebooks/");
//	tree.enableCheckBoxes(1);
//	tree.enableThreeStateCheckboxes(true);
//	
//	tree.setOnCheckHandler(toncheck);	
//	
//	tree.loadXML(RutComunes+"ProductoCategoria/XmlProductoCategoria.php", function() {
//    tree.loadOpenStates("CooProductoCategoria")
//    });
	
});


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
//	tree.saveOpenStates("CooProductoCategoria");
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

/*


*/

function FncGenerarExcel(){

	document.getElementById("FrmListado").action = "formularios/Producto/acc/AccProductoGenerarExcel.php"
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";


}

function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/Producto/FrmProductoListadoImprimir.php"
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


function FncActualizarActivoInactivoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{


			var Tipo = prompt("Escoja una accion \n 1 = Actualizar a Activo\n 2 = Actualizar a Inactivo", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						if(confirm("¿Realmente deseas actualizar como Activo los elementos seleccionados?")){
							$("#Acc").val("ActualizarActivo");
							$("#FrmListado").submit();	
						}
					
					break;
					
					case "2":
						if(confirm("¿Realmente deseas actualizar como Inactivo los elementos seleccionados?")){
							$("#Acc").val("ActualizarInactivo");
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



function FncActualizarCriticoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{


			var Tipo = prompt("Escoja una accion \n 1 = Actualizar a Critico\n 2 = Actualizar a Normal", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						if(confirm("¿Realmente deseas actualizar como Critico los elementos seleccionados?")){
							$("#Acc").val("ActualizarCriticoSi");
							$("#FrmListado").submit();	
						}
					
					break;
					
					case "2":
						if(confirm("¿Realmente deseas actualizar como Normal los elementos seleccionados?")){
							$("#Acc").val("ActualizarCriticoNo");
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





function FncActualizarDescontinuadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{


			var Tipo = prompt("Escoja una accion \n 1 = Actualizar a Descontinuado\n 2 = Actualizar a Vigente", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						if(confirm("¿Realmente deseas actualizar como Descontinuado los elementos seleccionados?")){
							$("#Acc").val("ActualizarDescontinuadoSi");
							$("#FrmListado").submit();	
						}
					
					break;
					
					case "2":
						if(confirm("¿Realmente deseas actualizar como Vigente los elementos seleccionados?")){
							$("#Acc").val("ActualizarDescontinuadoNo");
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


function FncActualizarCalculoPrecioSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{


			var Tipo = prompt("Escoja una accion \n 1 = Calculo Automatico de Precio \n 2 = Calculo Manual de Precio", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						if(confirm("¿Realmente deseas actualizar los elementos seleccionados?")){
							$("#Acc").val("CalculoPrecioSi");
							$("#FrmListado").submit();	
						}
					
					break;
					
					case "2":
						if(confirm("¿Realmente deseas actualizar los elementos seleccionados?")){
							$("#Acc").val("CalculoPrecioNo");
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
    
function FncListaPrecioCargarFormulario(oForm,oListaPrecioId){

	FncCargarVentanaFull("ListaPrecio",oForm,"Id="+oListaPrecioId);		

}

function FncProductoPrecioCalculoCargarFormulario(oProductoId){

	FncCargarVentanaFull("Producto","PrecioCalculo","ProId="+oProductoId);
	
}

function FncProductoUsoEditar(oForm,oProductoId){

	FncCargarVentanaFull("Producto",oForm,"Id="+oProductoId);
	
}

function FncProductoEditarCodigoOriginal(oProductoId){

	FncCargarVentanaFull("Producto","EditarCodigoOriginal","Id="+oProductoId);
	
}


function FncProcesarProductoListaPrecioGMSolo(oProductoId){
	FncCargarVentanaFullv2("Simple","tareas/TarProcesarProductoListaPrecioGMSolo.php","","","","","ProId="+oProductoId)
}


