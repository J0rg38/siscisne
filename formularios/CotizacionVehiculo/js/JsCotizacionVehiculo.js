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
		$('#CmpPersonal').removeAttr('disabled');	
		
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


	var Tipo = prompt("Escoja el tipo de reporte \n 1 = Formato Diario \n 2 = General", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":
				document.getElementById("FrmListado").action = "formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoFormatoDiarioGenerarExcel.php";
			break;
			
			case "2":
				document.getElementById("FrmListado").action = "formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoGenerarExcel.php";
			break;
			
			//case "3":
//document.getElementById("FrmListado").action = "formularios/CotizacionVehiculo/acc/AccCotizacionGenerarExcel2.php";
//			break;
		
		}
		
	}
			
			
	$('#CmpSucursal').removeAttr('disabled');	
	$('#CmpPersonal').removeAttr('disabled');	

	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";

	$('#CmpSucursal').attr('disabled', true);
	$('#CmpPersonal').attr('disabled', true);
	//location.reload();
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





function FncCotizacionVehiculoActualizarEmitidoSeleccionados(){
	
/*
1 Pendiente
3 Entregado
6 Anulado 
*/

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente deseas marcar a Listo la(s) Cotizaciones de Vehiculo?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							$(this).attr('orden_venta')!="" 
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("CotizacionVehiculoActualizarEmitido");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no tenga orden de venta de vehiculo.");
			}
			
		}
	}


}


function FncCotizacionVehiculoActualizarPendienteSeleccionados(){
	
/*
1 Pendiente
3 Entregado
6 Anulado 
*/


	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea marcar como Pendiente la(s) Cotizaciones de Vehiculo?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							$(this).attr('orden_venta')!="" 
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

		
			if(actualizar){	
				
				$("#Acc").val("CotizacionVehiculoActualizarPendiente");
				$("#FrmListado").submit();
			
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no tenga orden de venta de vehiculo.");
			}
					
				
			
			
		}
	}


}



function FncCotizacionVehiculoActualizarAnuladoSeleccionados(){

/*
1 Pendiente
3 Entregado
6 Anulado 
*/

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;

	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea marcar como Anulado la(s) Cotizaciones de Vehiculo?")){

			

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							$(this).attr('tiene_orden_venta') == "Si" 
						){
							actualizar = false;
							return false;
						}

					}
				}

			});
			
			
			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){
	
						if(
							
							$(this).attr('estado')=="6" 
							
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
					
					if(actualizar){	
					
						if(actualizar2){	
							
							$("#Acc").val("CotizacionVehiculoActualizarAnulado");
							$("#FrmListado").submit();
						
						}else{
							alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no se encuentre ya anulado anteriormente.");
						}
					
					
					}else{
						alert("Uno o mas de los elementos seleccionados no puede ser ANULADO, verifique que no tenga orden de venta de vehiculo.");
					}
					
				
			
			
		}
	}


}


function FncActualizarNivelInteresSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		

//		var Tipo = prompt("Escoja una accion \n 1 = Normal \n 2 = Interesado \n 3 = Muy Interesado \n 4 = Venta Concluida", "1");
		var Tipo = prompt("Escoja una accion \n 1 = Normal (Sin Interés) \n 2 = Poco Interesado \n 3 = Medianamente Interesado \n 4 = Interesado \n 5 = Muy Interesado ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres1");
							$("#FrmListado").submit();	
						}
					
					break;
					
					case "2":
					
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres11");
							$("#FrmListado").submit();	
						}
						
					break;
					
					case "3":
					
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres112");
							$("#FrmListado").submit();	
						}
						
					break;
					
					case "4":
					
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres2");
							$("#FrmListado").submit();	
						}
						
					break;
					
					case "5":
					
						if(confirm("¿Realmente desea actualizar el nivel de interes de los elementos seleccionados?")){
			
							$("#Acc").val("ActualizarNivelInteres3");
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








function FncImprmir(oId){


	//var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Normal) \n 2 = Formato 2 (Especial para municipalidades)", "1");
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Normal) \n 2 = Formato 2 (Mas Especificaciones)", "1");			
				
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir3.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

			break;
			
			case "2":
	
				FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;

		}

	}



	

}


function FncVistaPreliminar(oId){


	//var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Normal) \n 2 = Formato 2 (Especial para municipalidades)", "1");			
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Normal) \n 2 = Formato 2 (Mas Especificaciones)", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir3.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
		
		}
		
	}




	
	
}

function FncGenerarPDF(oId){

	FncPopUp('formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoGenerarPDF.php?Id='+oId+'&ImprimirCodigo=1',0,0,1,0,0,1,0,screen.height,screen.width);

}

/*
* FORMULARIOS
*/

function FncCotizacionVehiculoCargarFormulario(oForm,oCotizacionVehiculoId){
	
	FncCargarVentana("CotizacionVehiculo",oForm,oCotizacionVehiculoId);

}

function FncClienteCargarFormulario(oForm,oClienteId){

	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId)
	

}


function FncCotizacionVehiculoCargarFormulario(oForm,oCotizacionVehiculoId){
		
	FncCargarVentana("CotizacionVehiculo",oForm,oCotizacionVehiculoId);

}


/*function FncCotizacionVehiculoVistaPreliminar(oId){

	FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
		
}*/


function FncCotizacionVehiculoEnviarCorreo(oId){
	
		
	FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoGenerarPDF.php?Id='+oId,0,0,1,0,0,1,0,400,200);
	
}
