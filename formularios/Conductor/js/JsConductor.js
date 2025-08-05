/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



/*
* Funciones complementarias
*/



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

		if(confirm("¿Realmente desea eliminar los elementos seleccionados?")){
			$("#Acc").val("Eliminar");
			$("#FrmListado").submit();	
		}
	}
	
}



function FncHabilitarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		if(confirm("¿Realmente desea HABILITAR los elementos seleccionados?")){
			$("#Acc").val("Habilitar");
			$("#FrmListado").submit();	
		}
	}
	
}


function FncDeshabilitarSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var eliminar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{

		if(confirm("¿Realmente desea DESHABILITAR los elementos seleccionados?")){
			$("#Acc").val("Deshabilitar");
			$("#FrmListado").submit();	
		}
	}
	
}
















function FncConductorImprmir(oId){

	FncPopUp('formularios/Conductor/FrmConductorImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncConductorVistaPreliminar(oId){

	FncPopUp('formularios/Conductor/FrmConductorImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncConductorGenerarExcel(oId){

	FncPopUp('formularios/Conductor/FrmConductorGenerarExcel.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

/*

			$('.conductor-ubicacion').fancybox({
				
				href : 'http://rt214v2.ddns.net:777/apptaxi114/principal2.php?Mod=Conductor&Form=Ubicacion&ConductorNumeroDocumento='+oConductorNumeroDocumento,
				type : 'iframe',
				padding : 5
					
				*	
			});*/


/*				$.fancybox.open({
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
		*/		

			
function FncConductorUbicaciones(oConductorNumeroDocumento){
				//tb_show(this.title,'http://rt214v2.ddns.net:777/apptaxi114/principal2.php?Mod=Conductor&Form=Ubicacion&ConductorNumeroDocumento='+oConductorNumeroDocumento+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=true',this.rel);	
	FncPopUp('http://rt214v2.ddns.net:777/apptaxi114/principal2.php?Mod=Conductor&Form=Ubicacion&ConductorNumeroDocumento='+oConductorNumeroDocumento,0,0,1,0,0,1,0,800,600);

}


			
function FncConductorCalificaciones(oConductorNumeroDocumento){
				//tb_show(this.title,'http://rt214v2.ddns.net:777/apptaxi114/principal2.php?Mod=Conductor&Form=Ubicacion&ConductorNumeroDocumento='+oConductorNumeroDocumento+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=true',this.rel);	
	FncPopUp('http://rt214v2.ddns.net:777/apptaxi114/principal2.php?Mod=Conductor&Form=Calificacion&ConductorNumeroDocumento='+oConductorNumeroDocumento,0,0,1,0,0,1,0,800,600);

}








function FncConductorCargarSolo(oConductorId){
	
	//FncPopUp('formularios/AlmacenMovimientoEntrada/DiaNotaCreditoCompraListado.php?AmoId='+oAmoId,0,0,1,0,0,1,0,screen.height,screen.width);
	
	tb_show("SINCRONIZANDO DATOS DE CONDUCTOR",'tareas/TarConductorSincronizarSolo.php?ConId='+oConductorId,this.rel);		
	
}




function FncConductorResetearSolo(oConductorId){
	
	//FncPopUp('formularios/AlmacenMovimientoEntrada/DiaNotaCreditoCompraListado.php?AmoId='+oAmoId,0,0,1,0,0,1,0,screen.height,screen.width);
	
	tb_show("RESETEANDO DATOS DE EQUIPO DE CONDUCTOR",'tareas/TarConductorResetearSolo.php?ConId='+oConductorId,this.rel);		
	
}


function FncConductorMostrarFoto(oRuta){
	
	//FncPopUp('formularios/AlmacenMovimientoEntrada/DiaNotaCreditoCompraListado.php?AmoId='+oAmoId,0,0,1,0,0,1,0,screen.height,screen.width);
	
//	tb_show("Foto",oRuta+"?placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890",this.rel);		
	tb_show("",oRuta+"?placeValuesBeforeTB_=savedValues&TB_iframe=true&height="+(screen.height-(screen.height*0.3))+"&width="+(screen.width-(screen.width*0.5)),"");		
	
}