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
	
		
		
		
		
		//$("select#VehiculoMarca").html('<option value="">Escoja una opcion</option>');
//
//		$.getJSON("comunes/Vehiculo/JnVehiculoMarca.php",{}, function(j){
//			
//			var options = '';
//			options += '<option value="">Escoja una opcion</option>';			
//			
//			if(j.length!=0){
//				
//				for (var i = 0; i < j.length; i++) {
//					if(VehiculoMarcaId == j[i].VmaId){
//						options += '<option selected="selected" value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';					
//					}else{
//						options += '<option value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';				
//					}
//				}
//				
//			}else{
//			
//				alert("No se encontraron marcas");
//				
//			}
//			
//			
//		});	
		
		
	var options_vma = '';
	options_vma += '<option value="">Escoja una opcion</option>';	
			
	$.getJSON("comunes/Vehiculo/JnVehiculoMarcas.php",{}, function(j){
		if(j.length != 0){
			
			for (var i = 0; i < j.length; i++) {
				if(VehiculoMarcaId == j[i].VmaId){
					options_vma += '<option selected="selected" value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';					
				}else{
					options_vma += '<option value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';				
				}
			}
				
		}
		
		$("select#VehiculoMarca").html(options_vma);
		
	});	
		
	/*var options_vmo = '';
	options_vmo += '<option value="">Escoja una opcion</option>';	
	
	$.getJSON("comunes/Vehiculo/JnVehiculoModelos.php",{VehiculoMarcaId: VehiculoMarcaId}, function(j){
		if(j.length != 0){
			
			for (var i = 0; i < j.length; i++) {
				if(VehiculoModeloId == j[i].VmoId){
					options_vmo += '<option selected="selected" value="' + j[i].VmoId + '">' + j[i].VmoNombre + '</option>';					
				}else{
					options_vmo += '<option value="' + j[i].VmoId + '">' + j[i].VmoNombre + '</option>';				
				}
			}
				
		}
		
		$("select#VehiculoModelo").html(options_vmo);
		
	});	
	
	var options_vve = '';
	options_vve += '<option value="">Escoja una opcion</option>';			
	
	$.getJSON("comunes/Vehiculo/JnVehiculoVersiones.php",{VehiculoModeloId: VehiculoModeloId}, function(j){
		if(j.length != 0){			
			for (var i = 0; i < j.length; i++) {
				if(VehiculoVersionId == j[i].VveId){
					options_vve += '<option selected="selected" value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';					
				}else{
					options_vve += '<option value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';				
				}
			}				
		}
		
		$("select#VehiculoVersion").html(options_vve);
		
	});	*/
	
	
	
	
	
	
		
	$("select#VehiculoMarca").change(function(){
		
		var options = '';
		options += '<option value="">Escoja una opcion</option>';			
		
		$.getJSON("comunes/Vehiculo/JnVehiculoModelos.php",{VehiculoMarcaId: $(this).val()}, function(j){
			if(j.length != 0){				
				for (var i = 0; i < j.length; i++) {
					if(VehiculoModeloId == j[i].VmoId){
						options += '<option selected="selected" value="' + j[i].VmoId + '">' + j[i].VmoNombre + '</option>';					
					}else{
						options += '<option value="' + j[i].VmoId + '">' + j[i].VmoNombre + '</option>';				
					}
				}					
			}
			
			$("select#VehiculoModelo").html(options);
			
		});	
		
		
		//limpiando
		var options = '';
		options += '<option value="">Escoja una opcion</option>';	
		$("select#VehiculoVersion").html(options);		
		
	});
	

		
		
		
	
	$("select#VehiculoModelo").change(function(){
		
		var options = '';
		options += '<option value="">Escoja una opcion</option>';			
		
		$.getJSON("comunes/Vehiculo/JnVehiculoVersiones.php",{VehiculoModeloId: $(this).val()}, function(j){
			if(j.length != 0){
				
				for (var i = 0; i < j.length; i++) {
					if(VehiculoVersionId == j[i].VveId){
						options += '<option selected="selected" value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';					
					}else{
						options += '<option value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';				
					}
				}
					
			}
			
			$("select#VehiculoVersion").html(options);
			
		});	
		
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
	tree.saveOpenStates("CooVehiculoIngresoCategoria");
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
*/

function FncGenerarExcel(){

	document.getElementById("FrmListado").action = "formularios/VehiculoIngreso/acc/AccVehiculoIngresoGenerarExcel.php"
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";

}

/*
* Funciones Papelera
*/


//Acciones - Eliminar

function FncEliminarSeleccionado(id){
	
	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		
		var Tipo = prompt("Ingreso la clave para proceder con la eliminacion", "");
			
			if(Tipo !== null){
				if(Tipo.toUpperCase()=="1980"){

					$("#cmp_seleccionados").val(id);
					$("#Acc").val("Eliminar");
					$("#FrmListado").submit();
					
				}
			}

	
	
	}
	
}

function FncEliminarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		if(confirm("¿Realmente desea ELIMINAR los elementos seleccionados?")){
			
			
		
		var Tipo = prompt("Ingreso la clave para proceder con la eliminacion", "");
			
			if(Tipo !== null){
				if(Tipo.toUpperCase()=="1980"){

					
			$("#Acc").val("Eliminar");
			$("#FrmListado").submit();	
					
				}
			}
			
			
		}
	}
	
}




/*





*/






function FncActualizarValidarStockSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		var Tipo = prompt("Escoja una opcion \n 1 = VALIDAR STOCK: SI \n 2 = VALIDAR STOCK: NO", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
						document.getElementById('Acc').value= 'ActualizarValidarStockSi';
						$("#FrmListado").submit();
					break;
					
					case "2":
						document.getElementById('Acc').value= 'ActualizarValidarStockNo';
						$("#FrmListado").submit();
					break;				
				}
				
			}
	}
}



function FncActualizarConsiderarPedidoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		var Tipo = prompt("Escoja una opcion \n 1 = CONSIDERAR EN PEDIDO: SI \n 2 = CONSIDERAR EN PEDIDO: NO", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
						document.getElementById('Acc').value= 'ActualizarConsiderarPedidoSi';
						$("#FrmListado").submit();
					break;
					
					case "2":
						document.getElementById('Acc').value= 'ActualizarConsiderarPedidoNo';
						$("#FrmListado").submit();
					break;
				
				}
				
			}
	}
}


function FncDuplicarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	
		if(seleccionados==""){
			alert("No ha seleccionado ningun elemento.");
		}else{
			if(confirm("¿Realmente desea duplicar el elemento?")){
				aux = seleccionados.split("#");
					
				if((aux.length-1)>1){
					dhtmlx.alert({
						title:"Aviso",
						//type:"alert-error",
						type:"alert",
						text: "Solo puede escoger un elemento",
						callback: function(result){
							
						}
					});
				}else{
					document.getElementById('Acc').value= 'Duplicar';
					$("#FrmListado").submit();
				}
			}
			
		}

}








function FncVehiculoMarcaCargarFormulario(oForm,oVehiculoMarcaId){

	tb_show(this.title,'principal2.php?Mod=VehiculoMarca&Form='+oForm+'&Dia=1&Id='+oVehiculoMarcaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(screen.height-200)+'&width='+(screen.width-100)+'&modal=true',this.rel);		

}



function FncVehiculoModeloCargarFormulario(oForm,oVehiculoModeloId){

	tb_show(this.title,'principal2.php?Mod=VehiculoModelo&Form='+oForm+'&Dia=1&Id='+oVehiculoModeloId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(screen.height-200)+'&width='+(screen.width-100)+'&modal=true',this.rel);		

}


function FncVehiculoVersionCargarFormulario(oForm,oVehiculoVersionId){

	tb_show(this.title,'principal2.php?Mod=VehiculoVersion&Form='+oForm+'&Dia=1&Id='+oVehiculoVersionId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(screen.height-200)+'&width='+(screen.width-100)+'&modal=true',this.rel);		

}





