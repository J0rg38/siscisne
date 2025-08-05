/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Configuraciones
*/
var Modulo = "AlmacenStock";
/*
* Funciones complementarias
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
			dhtmlx.alert({
						title:"Aviso",
						//type:"alert-error",
						type:"alert",
						text: "Solo puede escoger un elemento",
						callback: function(result){
							
						}
					});
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
			dhtmlx.alert({
						title:"Aviso",
						//type:"alert-error",
						type:"alert",
						text: "Solo puede escoger un elemento",
						callback: function(result){
							
						}
					});
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


/*
* FORMULARIOS
*/

function FncListaPrecioCargarFormulario(oForm,oListaPrecioId){

//	FncCargarVentanaNuevo('principal2.php?Mod=ListaPrecio&Form='+oForm+'&Dia=1&Id='+oListaPrecioId,"","","");
	
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=ListaPrecio&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oListaPrecioId)
	//tb_show(this.title,'principal2.php?Mod=ListaPrecio&Form='+oForm+'&Dia=1&Id='+oListaPrecioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncProductoUsoEditar(oForm,oProId){

//	FncCargarVentana("Producto",oForm,oProId);
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Producto&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oProId)
	
}




function FncProductoReemplazoCargar(oProductoCodigoOriginal){
	
	//tb_show("",'formularios/AlmacenStock/DiaProductoReemplazoBuscar.php?height=440&width=850&ProductoCodigoOriginal='+oProductoCodigoOriginal,"");		
	FncCargarVentanaFullv2("Simple","formularios/AlmacenStock/DiaProductoReemplazoBuscar.php","","","","","ProductoCodigoOriginal="+oProductoCodigoOriginal)
	
	
	//FncCargarVentanaFullv2(oRuta,oIframe,oModal,oValues,oTitulo){
//	FncCargarVentanaFullv2('formularios/AlmacenStock/DiaProductoReemplazoBuscar.php?ProductoCodigoOriginal='+oProductoCodigoOriginal,"","","","");
	//formularios/TallerPedido/DiaAlmacenMovimientoListado.php?height=440&width=850&FinId=<?php echo $dat->FinId?>
	
	/*tb_show('','formularios/AlmacenStock/DiaProductoReemplazoBuscar.php?ProductoCodigoOriginal='+oProductoCodigoOriginal+
'&placeValuesBeforeTB_=savedValues','');	
  */
}





function FncPedidoClienteCargarFormulario(oProductoId){

	//ncCargarVentanaNuevo('principal2.php?Mod=ListaPrecio&Form='+oForm+'&Dia=1&Id='+oListaPrecioId,"","","");
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","formularios/AlmacenStock/DiaAlmacenStockPedidoCliente.php","true","true","savedValues","","Dia=1&ProductoId="+oProductoId)
	//tb_show(this.title,'principal2.php?Mod=ListaPrecio&Form='+oForm+'&Dia=1&Id='+oListaPrecioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

/************************************************************/
//IMPRESION

function FncImprmir(oId,oAlmacen,oSucursal,oAno){
	FncPopUp('formularios/AlmacenStock/FrmAlmacenStockImprimir.php?Id='+oId+'&P=1&AlmId='+oAlmacen+'&SucId='+oSucursal+'&Ano='+oAno,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId,oAlmacen,oSucursal,oAno){
	FncPopUp('formularios/AlmacenStock/FrmAlmacenStockImprimir.php?Id='+oId+'&P=&AlmId='+oAlmacen+'&SucId='+oSucursal+'&Ano='+oAno,0,0,1,0,0,1,0,screen.height,screen.width);
}

