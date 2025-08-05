/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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



function FncPagoImprmir(oId,oTipo){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");			
	
	
	
	switch(oTipo.toUpperCase()){
			case "VDI":
				oTipo = "VentaDirecta";
			break;
			
			case "OVV":
				oTipo = "OrdenVentaVehiculo";
			break;
			
			case "FAC":
				oTipo = "Factura";
			break;
			
			case "BOL":
				oTipo = "Boleta";
			break;
			
			default:
				oTipo = "";
			break;
		}
		
		
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
				FncPopUp('formularios/Pago'+oTipo+'/FrmPago'+oTipo+'Imprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "2":
				FncPopUp('formularios/Pago'+oTipo+'/FrmPago'+oTipo+'Imprimir2.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "2":
				FncPopUp('formularios/Pago'+oTipo+'/acc/AccGenerarPago'+oTipo+'PDF.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			default:
				alert("Opcion incorrecta");
			break;
		}
		
	}
	


}


function FncPagoVistaPreliminar(oId,oTipo){
		
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");			
	
	
	switch(oTipo.toUpperCase()){
			case "VDI":
				oTipo = "VentaDirecta";
			break;
			
			case "OVV":
				oTipo = "OrdenVentaVehiculo";
			break;
			
			case "FAC":
				oTipo = "Factura";
			break;
			
			case "BOL":
				oTipo = "Boleta";
			break;
			
			default:
				oTipo = "";
			break;
		}
		
	if(Tipo !== null){	
		switch(Tipo.toUpperCase()){
			case "1":
				FncPopUp('formularios/Pago'+oTipo+'/FrmPago'+oTipo+'Imprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "2":
				FncPopUp('formularios/Pago'+oTipo+'/FrmPago'+oTipo+'Imprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "3":
				FncPopUp('formularios/Pago'+oTipo+'/acc/AccGenerarPago'+oTipo+'PDF.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			default:
				alert("Opcion incorrecta");
			break;
		}
	}	

}









function FncVentaDirectaVistaPreliminar(oId){
	

	FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	

}



function FncOrdenVentaVehiculoVistaPreliminar(oId){
	

			
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	


}


function FncPagoCargarFormulario(oForm,oId,oVentaDirectaId){
	
	tb_show(this.title,'principal2.php?Mod=Pago&Form='+oForm+'&Dia=1&Id='+oId+'&VdiId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);

}




function FncActualizarUtilizadoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		var Tipo = prompt("Escoja una opcion \n 1 = Marcar como APLICADO \n 2 = Marcar como NO APLICADO", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
						document.getElementById('Acc').value= 'AplicadoSi';
						$("#FrmListado").submit();
					break;
					
					case "2":
						document.getElementById('Acc').value= 'AplicadoNo';
						$("#FrmListado").submit();
					break;
					
					default:
						alert("Opcion no encontrada");
					break;
				
				}
				
			}
			
	}
}






function FncPagoActualizarEmitidoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		
		alert("No ha seleccionado ningun elemento.");
		
	}else{
		if(confirm("¿Realmente deseas marcar a Emitido los abonos de repuestos?")){

			if(actualizar){
				$("#Acc").val("PagoActualizarEmitido");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}


}


function FncPagoActualizarAnuladoSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		
		alert("No ha seleccionado ningun elemento.");
		
	}else{
		if(confirm("¿Realmente deseas marcar a Anulado los abonos de repuestos?")){

			if(actualizar){
				$("#Acc").val("PagoActualizarAnulado");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser actualizado, verifique sus ESTADOS.");
			}
			
		}
	}


}


function FncGenerarExcel(){
	
	
		//var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario ", "1");
	
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Todos\n 2 = Listado Actual ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						document.getElementById("FrmListado").action = "formularios/Pago/acc/AccPagoGenerarExcel.php?Todos=Si"
						document.getElementById("FrmListado").submit();
						document.getElementById("FrmListado").action = "#";
						
					break;
					
					case "2":

						document.getElementById("FrmListado").action = "formularios/Pago/acc/AccPagoGenerarExcel.php"
						document.getElementById("FrmListado").submit();
						document.getElementById("FrmListado").action = "#";
						
					break;

				}
				
			}
			
			
	
}