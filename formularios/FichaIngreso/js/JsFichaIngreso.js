/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* Funciones complementarias
*/
function FncFichaIngresoVerificar(){

	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/acc/AccFichaIngresoVerificar.php',
		data: '',
		success: function(respuesta){

			if(respuesta != ""){
				$.ionSound.play("door_bell");
				//alert(respuesta);
				dhtmlx.message({ type:"error", text:respuesta,expire:-2 });
			}

		}
	});
	
}

$().ready(function() {
	
	$.ionSound({
		sounds: [                       // set needed sounds names
			"door_bell"
		],
		path: "librerias/ion.sound-1.3.0/sounds/",                // set path to sounds
		multiPlay: true,               // playing only 1 sound at once
		volume: "0.9"                   // not so loud please
	});
	
	
	FncFichaIngresoVerificar();

	setInterval("FncFichaIngresoVerificar();",60000);
	
	
	function FncCargarFichaIngresoPersonalEditar(oFichaIngresoId,oPersonalId){

		//PRE CARGA
		$("#CapFichaIngresoPersonal_"+oFichaIngresoId).html("Cargando...");

		$.ajax({
			type: 'POST',
			url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalEditar.php',
			data: 'FichaIngresoId='+oFichaIngresoId+'&PersonalId='+oPersonalId,
			success: function(res){
				
				//CARGANDO DATOS HTML
				$("#CapFichaIngresoPersonal_" + oFichaIngresoId).html(res);

				$("#BtnFichaIngresoPersonalGuardar_"+oFichaIngresoId).click(function (event) {  		
					
					var FichaIngresoPersonal = $("#CmpFichaIngresoPersonal_"+oFichaIngresoId).val();
					
					if(FichaIngresoPersonal == ""){
						
						alert("No ha escogido un tecnico");
						
					}else{
						
						//PRE CARGA
						$("#CapFichaIngresoPersonalEstado"+oFichaIngresoId).html("Guardando...");
	
						$.ajax({
							type: 'POST',
							url: 'comunes/FichaIngresoPersonal/acc/AccFichaIngresoPersonalEditar.php',
							data: 'FichaIngresoId='+oFichaIngresoId+'&PersonalId='+FichaIngresoPersonal,
							success: function(res){
								
								switch(res){
									case "001":
										FncCargarFichaIngresoPersonalVer(oFichaIngresoId,FichaIngresoPersonal);
										alert("Se cambio correctamente al TECNICO");
									break;
									
									case "002":
										alert("No se pudo registrar al TECNICO, intente nuevamente");
									break;
									
									case "003":
										 if (confirm("Se cambio correctamente al TECNICO. \n¿Desea ENVIAR la ORDEN DE TRABAJO a TALLER?") == true) {
											 
											 FncCargarFichaIngresoPersonalVer(oFichaIngresoId,FichaIngresoPersonal);									 
											 
											 $.ajax({
												type: 'POST',
												url: 'comunes/FichaIngreso/acc/AccFichaIngresoEnviarTaller.php',
												data: 'FichaIngresoId='+oFichaIngresoId,
												success: function(res){
													
													switch(res){
														case "001":
															FncCargarFichaIngresoEstadoVer(oFichaIngresoId);
															alert("Se envio correctamente la ORDEN DE TRABAJO");
														break;
														
														case "002":
															alert("No se pudo enviar la ORDEN DE TRABAJO");
														break;
														
														default:
															alert("Ha ocurrido un error interno");
														break;
													}
													
												}
											});
											 
											 
											 
										 }else{
											 FncCargarFichaIngresoPersonalVer(oFichaIngresoId,FichaIngresoPersonal);
										 }
									break;
									
									default:
										alert("Ha ocurrido un error interno");
									break;
								}
								
							}
						});
						
					}
					
								
					//return false;
				}); 
				
				//AGREGANDO EVENTO CLICK - CANCELAR
				$("#BtnFichaIngresoPersonalCancelar_"+oFichaIngresoId).click(function (event) {  		
					
					FncCargarFichaIngresoPersonalVer(oFichaIngresoId,oPersonalId);
						
				}); 
				
		
			}
		});
	}
	
	function FncCargarFichaIngresoPersonalRegistrar(oFichaIngresoId){
		
		//PRE CARGA
		$("#CapFichaIngresoPersonal_" + oFichaIngresoId).html("Cargando...");

		$.ajax({
		type: 'POST',
		url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalRegistrar.php',
		data: 'FichaIngresoId='+oFichaIngresoId,
		success: function(res){
			
			//CARGANDO DATOS HTML
			$("#CapFichaIngresoPersonal_"+oFichaIngresoId).html(res);
			
			//AGREGANDO EVENTO CLICK - GUARDAR
			$("#BtnFichaIngresoPersonalGuardar_"+oFichaIngresoId).click(function (event) {  		
				
				var FichaIngresoPersonal = $("#CmpFichaIngresoPersonal_"+oFichaIngresoId).val();
					
				if(FichaIngresoPersonal == ""){
					alert("No ha escogido un tecnico");
				}else{

					//PRE CARGA
					$("#CapFichaIngresoPersonalEstado"+oFichaIngresoId).html("Guardando...");
					
					$.ajax({
						type: 'POST',
						url: 'comunes/FichaIngresoPersonal/acc/AccFichaIngresoPersonalRegistrar.php',
						data: 'FichaIngresoId='+oFichaIngresoId+'&PersonalId='+FichaIngresoPersonal,
						success: function(res){
							
							switch(res){
								case "001":
								
									FncCargarFichaIngresoPersonalVer(oFichaIngresoId,FichaIngresoPersonal);
									alert("Se registro correctamente al TECNICO");
									
								break;
								
								case "002":
								
									alert("No se pudo registrar al tecnico, intente nuevamente");
									
								break;
								
								case "003":
										 if (confirm("Se registro correctamente al TECNICO. \n ¿Desea ENVIAR la ORDEN DE TRABAJO a TALLER?") == true) {
											 
											 FncCargarFichaIngresoPersonalVer(oFichaIngresoId,FichaIngresoPersonal);									 
											 
											 $.ajax({
												type: 'POST',
												url: 'comunes/FichaIngreso/acc/AccFichaIngresoEnviarTaller.php',
												data: 'FichaIngresoId='+oFichaIngresoId,
												success: function(res){
													
													switch(res){
														case "001":
															FncCargarFichaIngresoEstadoVer(oFichaIngresoId);
															alert("Se envio correctamente la ORDEN DE TRABAJO");
														break;
														
														case "002":
															alert("No se pudo enviar la ORDEN DE TRABAJO");
														break;
														
														default:
															alert("Ha ocurrido un error interno");
														break;
													}
													
												}
											});
											 
											 
											 
										 }else{
											 FncCargarFichaIngresoPersonalVer(oFichaIngresoId,FichaIngresoPersonal);
										 }
									break;
									
									default:
										alert("Ha ocurrido un error interno");
									break;
									
									
							}
	
						}
					});
					
				}
						
				//return false;
			}); 
			
			
			//AGREGANDO EVENTO CLICK - CANCELAR
			$("#BtnFichaIngresoPersonalCancelar_"+oFichaIngresoId).click(function (event) {  		
				
				//PRE CARGA
				//$("#CapFichaIngresoPersonal_"+oFichaIngresoId).html("Cargando...");
	
				FncCargarFichaIngresoPersonalNuevo(oFichaIngresoId);

			}); 
			
			
			
			
		}
		});
							
							
							
	}
	
	function FncCargarFichaIngresoPersonalVer(oFichaIngresoId,oPersonalId){

		//PRE CARGA
		$("#CapFichaIngresoPersonal_"+oFichaIngresoId).html("Cargando...");

		$.ajax({
			type: 'POST',
			url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalVer.php',
			data: 'FichaIngresoId='+oFichaIngresoId,
			success: function(res){
				
				//CARGANDO DATOS HTML
				$("#CapFichaIngresoPersonal_" + oFichaIngresoId).html(res);
				
				$("#BtnFichaIngresoPersonalEditar_"+oFichaIngresoId).click(function (event) {  		
					
					FncCargarFichaIngresoPersonalEditar(oFichaIngresoId,oPersonalId);
					
					return false;
				}); 
		
			}
		});
				
				
	}
	
	function FncCargarFichaIngresoPersonalNuevo(oFichaIngresoId){

		$("#CapFichaIngresoPersonal_" + oFichaIngresoId).html("<a id='BtnFichaIngresoPersonalRegistrar_"+oFichaIngresoId+"' href=''>Agregar Tecnico</a>");

		$("#BtnFichaIngresoPersonalRegistrar_"+oFichaIngresoId).click(function (event) {  		

			FncCargarFichaIngresoPersonalRegistrar(oFichaIngresoId);
			return false;

		}); 

	}
	




	function FncCargarFichaIngresoEstadoVer(oFichaIngresoId){

		//PRE CARGA
		$("#CapFichaIngresoEstado_"+oFichaIngresoId).html("Cargando...");

		$.ajax({
			type: 'POST',
			url: 'comunes/FichaIngreso/CapFichaIngresoEstadoVer.php',
			data: 'FichaIngresoId='+oFichaIngresoId,
			success: function(res){
				
				//CARGANDO DATOS HTML
				$("#CapFichaIngresoEstado_" + oFichaIngresoId).html(res);
				
			}
		});
				
				
	}
	
	
	$('input[type=checkbox]').each(function () {
		
		if($(this).attr('name')=="cmp_seleccionar[]"){
			
			if($(this).attr('personal')==""){
				
				FncCargarFichaIngresoPersonalNuevo($(this).val())		
			}else{
			
				FncCargarFichaIngresoPersonalVer($(this).val(),$(this).attr('personal'))		
				FncCargarFichaIngresoEstadoVer($(this).val());
			}

			
		}
		
	});
		
		
		
	//
//	$('input[type=checkbox]').each(function () {
//		
//		if($(this).attr('name')=="cmp_seleccionar[]"){
//			
////			$().
////			$(this).val()
//	
//	
//	
//			if($(this).attr('personal')==""){
//				
//				var FichaIngresoId = $(this).val();
//				
//				$("#CapFichaIngresoPersonal_" + FichaIngresoId).html("<a id='BtnFichaIngresoPersonalRegistrar_"+FichaIngresoId+"' href=''>Agregar Tecnico</a>");
//				
//
//				$("#BtnFichaIngresoPersonalRegistrar_"+FichaIngresoId).click(function (event) {  		
//					
//					$.ajax({
//						type: 'POST',
//						url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalRegistrar.php',
//						data: 'FichaIngresoId='+FichaIngresoId,
//						success: function(res){
//							
//							//CARGANDO DATOS HTML
//							$("#CapFichaIngresoPersonal_" + FichaIngresoId).html(res);
//							
//							//AGREGANDO EVENTO CLICK - GUARDAR
//							$("#BtnFichaIngresoPersonalGuardar_"+FichaIngresoId).click(function (event) {  		
//								
//								var FichaIngresoPersonal = $("#CmpFichaIngresoPersonal_"+FichaIngresoId).val();
//									
//									if(FichaIngresoPersonal == ""){
//										alert("No ha escogido un tecnico");
//									}else{
//										
//										//PRE CARGA
//										$("#CapFichaIngresoPersonalEstado"+FichaIngresoId).htnl("Guardando...");
//	
//										$.ajax({
//											type: 'POST',
//											url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalVer.php',
//											data: 'FichaIngresoId='+FichaIngresoId,
//											success: function(res){
//												
//												//CARGANDO DATOS HTML
//												$("#CapFichaIngresoPersonal_" + FichaIngresoId).html(res);
//												
//												//AGREGANDO EVENTO CLICK - EDITAR
//												$("#BtnFichaIngresoPersonalEditar_"+FichaIngresoId).click(function (event) {  		
//													
//													//PRE CARGA
//													$("#CapFichaIngresoPersonal_" + FichaIngresoId).html("Cargando...");
//													
//													$.ajax({
//														type: 'POST',
//														url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalEditar.php',
//														data: 'FichaIngresoId='+FichaIngresoId,
//														success: function(res){
//								
//															$("#CapFichaIngresoPersonal_" + FichaIngresoId).html(res);
//															
//														}
//													});
//																
//													//return false;
//												}); 
//												
//		
//											}
//										});
//										
//									}
//									
//									
//											
//								//return false;
//							}); 
//							
//							
//							//AGREGANDO EVENTO CLICK - CANCELAR
//							$("#BtnFichaIngresoPersonalCancelar_"+FichaIngresoId).click(function (event) {  		
//								
//								//PRE CARGA
//								$("#CapFichaIngresoPersonal_" + FichaIngresoId).html("Cargando...");
//								
//								$.ajax({
//									type: 'POST',
//									url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalVer.php',
//									data: 'FichaIngresoId='+FichaIngresoId,
//									success: function(res){
//			
//										//$("#CapFichaIngresoPersonal_" + FichaIngresoId).html(res);
//										$("#CapFichaIngresoPersonal_" + FichaIngresoId).html("<a id='BtnFichaIngresoPersonalRegistrar_"+FichaIngresoId+"' href=''>Agregar Tecnico</a>");
//				
//										
//									}
//								});
//												
//											
//								
//							}); 
//							
//							
//							
//							
//						}
//					});
//								
//					return false;
//				}); 
//							
//			}else{
//			
//				var FichaIngresoId = $(this).val();
//				var PersonalId = $(this).attr('personal');
//				
//				//PRE CARGA
//				$("#CapFichaIngresoPersonal_" + FichaIngresoId).html("Cargando...");
//				
//				$.ajax({
//					type: 'POST',
//					url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalVer.php',
//					data: 'FichaIngresoId='+FichaIngresoId,
//					success: function(res){
//						
//						//CARGANDO DATOS HTML
//						$("#CapFichaIngresoPersonal_" + FichaIngresoId).html(res);
//						
//							$("#BtnFichaIngresoPersonalEditar_"+FichaIngresoId).click(function (event) {  		
//								
//								//PRE CARGA
//								$("#CapFichaIngresoPersonal_" + FichaIngresoId).html("Cargando...");
//								
//								$.ajax({
//									type: 'POST',
//									url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalEditar.php',
//									data: 'FichaIngresoId='+FichaIngresoId+'&PersonalId='+PersonalId,
//									success: function(res){
//				
//										$("#CapFichaIngresoPersonal_" + FichaIngresoId).html(res);
//										
//										
//										
//										$("#BtnFichaIngresoPersonalGuardar_"+FichaIngresoId).click(function (event) {  		
//													
//											//PRE CARGA
//											$("#CapFichaIngresoPersonal_" + FichaIngresoId).html("Cargando...");
//											
//											$.ajax({
//												type: 'POST',
//												url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalEditar.php',
//												data: 'FichaIngresoId='+FichaIngresoId,
//												success: function(res){
//						
//													$("#CapFichaIngresoPersonal_" + FichaIngresoId).html(res);
//													
//												}
//											});
//														
//											//return false;
//										}); 
//										
//										$("#BtnFichaIngresoPersonalCancelar_"+FichaIngresoId).click(function (event) {  		
//											
//											//PRE CARGA
//											$("#CapFichaIngresoPersonal_" + FichaIngresoId).html("Cargando...");
//											
//											$.ajax({
//												type: 'POST',
//												url: 'comunes/FichaIngresoPersonal/CapFichaIngresoPersonalVer.php',
//												data: 'FichaIngresoId='+FichaIngresoId,
//												success: function(res){
//						
//													$("#CapFichaIngresoPersonal_" + FichaIngresoId).html(res);
//													
//												}
//											});
//															
//														
//											//return false;
//										}); 
//										
//										
//										
//										
//									}
//								});
//											
//								//return false;
//							}); 
//				
//					}
//				});
//				
//									
//				
//			}
//
//	
//			
//		}
//		
//	});
//		
		
	
});


$().ready(function() {

	$("#Fil").focus();
	$("#Fil").select();


$('#FrmListado').on('submit', function() {
		
		$('#CmpSucursal').removeAttr('disabled');		
		
		return true;

	});
	
	

	
	
});



$('input[type=checkbox]').each(function () {
	if($(this).attr('name')=="cmp_seleccionar[]"){
		$(this).attr('checked', false);
		$('#Fila_'+indice).css('background-color', '#FFFFFF');
	}
	indice = indice + 1;
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







function FncEnviarOrdenTrabajoAnularSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las O.T. seleccionadas a ANULAR? \n ADVERTENCIA: ESTE PROCESO NO PUEDE SER REVERTIDO")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

/*
case 777:	$Estado = "RECEPCION [Anulado]";

case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
						if(
							//$(this).attr('estado')=="1" || 
							//$(this).attr('estado')=="11" || 
							//$(this).attr('estado')=="2" || 
//							$(this).attr('estado')=="3" || 
//							$(this).attr('estado')=="4" || 
//							$(this).attr('estado')=="5" || 
//							$(this).attr('estado')=="6" || 
//							
//							$(this).attr('estado')=="7" ||
//							$(this).attr('estado')=="71" || 
//							$(this).attr('estado')=="72" ||
//							$(this).attr('estado')=="73" ||
//							$(this).attr('estado')=="74" ||
//							$(this).attr('estado')=="75" ||
//							
//							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				
					$("#Acc").val("EnviarOrdenTrabajoAnular");
					$("#FrmListado").submit();	
				
			}else{
				
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: No se pueden ser ENVIADAS a ANULAR las O.T. con estado: \n - CONTABILIDAD [Facturado]");
			}
			
		}
	}

}





function FncEnviarOrdenTrabajoTallerSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las O.T. seleccionadas a TALLER?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

/*
case 777:	$Estado = "RECEPCION [Anulado]";

case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
						if(
							$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
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
							$(this).attr('personal')==""
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			
			
			if(actualizar){
				if(actualizar2){
					$("#Acc").val("EnviarOrdenTrabajoTaller");
					$("#FrmListado").submit();	
				}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique si tiene un TECNICO ASIGNADO.");					
				}
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a TALLER las O.T. con estado: \n - RECEPCION [Pendiente]");
			}
			
		}
	}

}



function FncEnviarOrdenTrabajoRecepcionSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea REGRESAR las O.T. seleccionadas a RECEPCION?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
						if(
							$(this).attr('estado')=="1" || 

							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("EnviarOrdenTrabajoRecepcion");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser REGRESADAS a RECEPCION las O.T. con estado: \n\ - RECEPCION [Enviado]");
//				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}








function FncEnviarFichaIngresoAlmacenSeleccionados(oRapido){

var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las O.T. seleccionadas a ALMACEN?. ADVERTENCIA: No se puede revertir esta accion una vez realizada")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
						if(
							//$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
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
							$(this).attr('personal')==""
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			
			
			if(actualizar){
				if(actualizar2){
					
					if(oRapido=="1"){
						$("#Acc").val("EnviarOrdenTrabajoAlmacenRapido");	
					}else{
						$("#Acc").val("EnviarOrdenTrabajoAlmacen");
					}
					
					$("#FrmListado").submit();	
				}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique si tiene un TECNICO ASIGNADO.");					
				}
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS. \n\n NOTA: Solo pueden ser ENVIADAS a ALMACEN las O.T. con estado: \n - RECEPCION [Pendiente]");
			}
			
		}
	}
	
	
}




function FncEnviarFichaIngresoTrabajoTerminadoSeleccionados(oRapido){

var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	var actualizar2 = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las O.T. seleccionadas como TRABAJO TERMINADO?. ADVERTENCIA: No se puede revertir esta accion una vez realizada")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/
						if(
							//$(this).attr('estado')=="11" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							$(this).attr('estado')=="74" ||
							$(this).attr('estado')=="75" ||
							
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
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
							$(this).attr('personal')==""
						){
							actualizar2 = false;
							return false;
						}

					}
				}

			});
			
			
			if(actualizar){
				if(actualizar2){
					
					//if(oRapido="1"){
//						$("#Acc").val("EnviarOrdenTrabajoTrabajoTerminadoRapido");
//					}else{
						$("#Acc").val("EnviarOrdenTrabajoTrabajoTerminado");
					//}
					
					$("#FrmListado").submit();	
				}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique si tiene un TECNICO ASIGNADO.");					
				}
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique que no se ha enviado a TALLER o ALMACEN.");
			}
			
		}
	}
	
	
}





/*
function FncEnviarOrdenTrabajoContabilidadSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	var actualizar = true;
	
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		if(confirm("¿Realmente desea ENVIAR las O.T. a CONTABILIDAD de los elementos seleccionados?")){

			$('input[type=checkbox]').each(function () {

				if($(this).attr('name')=="cmp_seleccionar[]"){
					if($(this).is(':checked')){

//
//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:		$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";						

						if(
							$(this).attr('estado')=="1" || 
							$(this).attr('estado')=="2" || 
							$(this).attr('estado')=="3" || 
							$(this).attr('estado')=="4" || 
							$(this).attr('estado')=="5" || 
							$(this).attr('estado')=="6" || 
							
							$(this).attr('estado')=="7" ||
							$(this).attr('estado')=="71" || 
							$(this).attr('estado')=="72" ||
							$(this).attr('estado')=="73" ||
							
							$(this).attr('estado')=="8" || 
							$(this).attr('estado')=="9"
						){
							actualizar = false;
							return false;
						}

					}
				}

			});

			if(actualizar){
				$("#Acc").val("EnviarOrdenTrabajoContabilidad");
				$("#FrmListado").submit();	
			}else{
				alert("Uno o mas de los elementos seleccionados no puede ser enviado, verifique sus ESTADOS.");
			}
			
		}
	}

}
*/


function FncImprmir(oId){
	
	//var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario ", "1");
	
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 3 = Inventario ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					/*case "2":

						FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;*/

					case "3":

						FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;


				
				}
				
			}

}


function FncVistaPreliminar(oId){
	
	//var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario ", "1");
	
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 3 = Inventario ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					/*case "2":
	
						FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;*/

					case "3":

						FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

					break;

				}
				
			}

}



function FncVehiculoRecepcionVistaPreliminar(oId){

	FncPopUp('formularios/VehiculoRecepcion/FrmVehiculoRecepcionImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

/*
* FORMULARIOS
*/

function FncAvisoCargarFormulario(oVehiculoIngresoId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//	FncCargarVentana("Aviso",oForm,oVehiculoIngresoId);

	tb_show(this.title,'principal2.php?Mod=Aviso&Form=Listado&Dia=1&EinId='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=true',this.rel);	
		
}

function FncClienteCargarFormulario(oForm,oClienteId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	FncCargarVentana("Cliente",oForm,oClienteId);
}

function FncClienteSimpleCargarFormulario(oForm,oClienteId){

	//tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	FncCargarVentana("ClienteSimple",oForm,oClienteId);
}

function FncVehiculoIngresoSimpleCargarFormulario(oForm,oVehiculoIngresoId){
	//tb_show(this.title,'principal2.php?Mod=&Form='+oForm+'&Dia=1&Id='+oVehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width='+Ancho+'&modal=true',this.rel);		
	FncCargarVentana("VehiculoIngresoSimple",oForm,oVehiculoIngresoId);


}

function FncCampanaCargarFormulario(oForm,oCampanaId){

	//tb_show(this.title,'principal2.php?Mod=Campana&Form='+oForm+'&Dia=1&Id='+oCampanaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	FncCargarVentana("Campana",oForm,oCampanaId);
}



function FncFichaAccionModalidadIngresoEditar(oFichaIngresoId){

	//tb_show(this.title,'principal2.php?Mod=FichaAccionModalidadIngreso&Form=Editar&Dia=1&Id='+oFichaIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		
	FncCargarVentana("FichaAccionModalidadIngreso","Editar",oFichaIngresoId);
}

function FncFichaIngresoModalidadIngresoEditar(oFichaIngresoId){
//tb_show(this.title,'principal2.php?Mod=FichaAccionModalidadIngreso&Form=Editar&Dia=1&Id='+oFichaIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		
	FncCargarVentana("FichaIngresoModalidadIngreso","Editar",oFichaIngresoId);
}


function FncTallerPedidoModalidadIngresoEditar(oFichaIngresoId){

	FncCargarVentana("TallerPedidoModalidadIngreso","Editar",oFichaIngresoId);
//	tb_show(this.title,'principal2.php?Mod=TallerPedidoModalidadIngreso&Form=Editar&Dia=1&Id='+oFichaIngresoId+
//'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		

}

function FncOrdenVentaVehiculoVerPlan(oId,oNumeroMantenimiento){
	
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirPM.php?Id='+oId+'&NumeroMantenimiento='+oNumeroMantenimiento,0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FncFichaIngresoSeguimientoClienteCargarFormulario(oFichaIngresoId){//tb_show(this.title,'principal2.php?Mod=Garantia&Form=SeguimientoCliente&Dia=1&Id='+oGarantiaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&modal=true',this.rel);	
	
	FncCargarVentana("FichaIngreso","SeguimientoCliente",oFichaIngresoId);

}

	
function FncTBCerrarFunncion(oModulo){

}





function FncOrdenVentaVehiculoVistaPreliminar(oId){
	
	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncGenerarExcel(){
	
	
		//var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Orden de Trabajo\n 2 = Ficha Tecnica\n 3 = Inventario ", "1");
	
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Todos\n 2 = Listado Actual ", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						document.getElementById("FrmListado").action = "formularios/FichaIngreso/acc/AccFichaIngresoGenerarExcel.php?Todos=Si"
						document.getElementById("FrmListado").submit();
						document.getElementById("FrmListado").action = "#";
						
					break;
					
					case "2":

						document.getElementById("FrmListado").action = "formularios/FichaIngreso/acc/AccFichaIngresoGenerarExcel.php"
						document.getElementById("FrmListado").submit();
						document.getElementById("FrmListado").action = "#";
						
					break;

				}
				
			}
			
			
	
}




function FncActualiarCierreSeleccionados(){

	var seleccionados = $("#cmp_seleccionados").val();
	
	var actualizar = true;
		
	if(seleccionados==""){
		alert("No ha seleccionado ningun elemento.");
	}else{
		
		if(confirm("¿Realmente desea actualizar el cierre de O.T. la orden de trabajo?")){
			
			var Tipo = prompt("Escoja una accion \n 1 = Cerrar O.T.\n 2 = Abrir O.T.", "1");
			
			if(Tipo !== null){
				
				switch(Tipo.toUpperCase()){
					
					case "1":				
						
						$('input[type=checkbox]').each(function () {
						
							if($(this).attr('name')=="cmp_seleccionar[]"){
								if($(this).is(':checked')){
									
									if(
										$(this).attr('cierre')=="1" 
									){
										actualizar = false;
										return false;
									}
						
								}
							}
						
						});
						
						if(actualizar){
							$("#Acc").val("ActualizarCierreSi");
							$("#FrmListado").submit();	
						}else{
							alert("Uno o mas de los elementos seleccionados ya se encuentra cerrado.");
						}
													
					break;
				
					case "2":
							
						$('input[type=checkbox]').each(function () {
						
							if($(this).attr('name')=="cmp_seleccionar[]"){
								if($(this).is(':checked')){
									
									if(
										$(this).attr('cierre')=="2" 
									){
										actualizar = false;
										return false;
									}
						
								}
							}
						
						});
						
						if(actualizar){
							$("#Acc").val("ActualizarCierreNo");
							$("#FrmListado").submit();	
						}else{
							alert("Uno o mas de los elementos seleccionados ya se encuentra abierto.");
						}
							
					break;
				}
				
			}
			
		}
		
		
		
		
	}
	
	
	

}
