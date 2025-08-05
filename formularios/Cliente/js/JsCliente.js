/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Configuraciones
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


function FncActualizarBloquearSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var bloquear = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{


		var Tipo = prompt("Escoja la accion a realizar \n 1 = Bloquear Cliente(s) \n 2 = Desbloquear Cliente(s) ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						if(confirm("¿Realmente desea bloquear los elementos seleccionados?")){
							$("#Acc").val("ActualizarBloquearSi");
							$("#FrmListado").submit();	
							
						}
					break;
					
					case "2":
					
					if(confirm("¿Realmente desea desbloquear los elementos seleccionados?")){
							$("#Acc").val("ActualizarBloquearNo");
							$("#FrmListado").submit();	
						}
					break;


				}
				
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
						window.location.href = "principal.php?Mod=Cliente&Form=Editar&Id="+$(this).val();
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
						window.location.href = "principal.php?Mod=Cliente&Form=Ver&Id="+$(this).val();
					}
				}			 
			});
			
		}
	}

}


function FncGenerarExcel(){
	document.getElementById("FrmListado").action = "formularios/Cliente/acc/AccClienteGenerarExcel.php"
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
}

function FncListadoImprimir(){
	document.getElementById("FrmListado").action = "formularios/Cliente/FrmClienteListadoImprimir.php"
	document.getElementById("FrmListado").target = '_blank';
	document.getElementById("FrmListado").submit();
	document.getElementById("FrmListado").action = "#";
	document.getElementById("FrmListado").target = '_self';
}



function FncClienteNotaCargarFormulario(oForm,oClienteId){
	
//	FncCargarVentanaNuevo('principal2.php?Mod=ClienteNota&Form='+oForm+'&Dia=1&CliId='+oClienteId,true,true,"");	
//	FncCargarVentana("ClienteNota",oForm,oClienteId);
	tb_show(this.title,'principal2.php?Mod=ClienteNota&Form='+oForm+'&Dia=1&CliId='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//	console.log('principal2.php?Mod=ClienteNota&Form='+oForm+'&Dia=1&CliId='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true');
	
}



function FncClienteSincronizarClaveElectronica(oId){
	
	if(oId==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No se escogio un cliente",
			callback: function(result){
				
			}
		});	
		
	}else{
		
		FncPopUp('formularios/Cliente/DiaClienteSincronizarClaveElectronica.php?Id='+oId,0,0,1,0,0,1,0,350,150);						
		
	}
	
		
}


function FncClienteEnviarCorreo(oId,oEmailFacturacion){
	
	if(oEmailFacturacion==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"No se encontro email de facturacion",
			callback: function(result){
				
			}
		});	
		
	
	
	}else{
		
		FncPopUp('formularios/Cliente/DiaClienteEnviarCorreo.php?Id='+oId,0,0,1,0,0,1,0,350,150);						
		
	}
	
		
}

function FncClienteSunatTareas(oId,oEmailFacturacion){

	var Tipo = prompt("Escoja la tarea a realizar \n 1 = Sincronizar Clave de Acceso \n 2 = Enviar Clave de Acceso ", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			
			case "1":	
				FncClienteSincronizarClaveElectronica(oId);
			break;
			
			case "2":	
				FncClienteEnviarCorreo(oId,oEmailFacturacion);
			break;
			
			default:
					dhtmlx.alert({
						title:"Aviso",
						type:"alert-error",
						text:"No escogio una tarea",
						callback: function(result){
						
						}
					});
			break;
		
		}
		
	}

}


//function FncClienteEnviarSMS(oClienteId){
//	
//	tb_show(this.title,'principal2.php?Mod=Cliente&Form=EnviarSMS&Dia=1&CliId='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//
//}



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

