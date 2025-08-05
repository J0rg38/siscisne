
$().ready(function() {
	
	$("#BtnFiltrarEntrega").click(function(){
			FncVehiculoIngresoControlRecepcionCargarListado();
	});
		
		
	$("#BtnLimpiar").click(function(){
		
		$("#CmpBuscarVIN").val("");
		FncVehiculoIngresoControlRecepcionCargarListado();
		
	});
		
		
});



function FncVehiculoIngresoControlRecepcionCargarListado(){
	
		$("#CapVehiculoIngresoControlRecepcion").html("Cargando...");
		
		var SucursalId = $("#CmpSucursalId").val();
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var BuscarVIN = $("#CmpBuscarVIN").val();
			$.ajax({
				type: 'POST',
				url: 'formularios/VehiculoIngreso/IfrVehiculoIngresoControlRecepcion.php',
				data: 'Sucursal='+SucursalId+'&Ano='+Ano+'&Mes='+Mes+'&BuscarVIN='+BuscarVIN,
				success: function(html){
				
					$("#CapVehiculoIngresoControlRecepcion").html(html);
					
						$('input[type=checkbox]').each(function () {
	
							if($(this).attr('etiqueta')=="vehiculo_ingreso_entrega"){
								
								var Id = $(this).val();
								
								$("#CmpControlGuiaRemisionNumeroOtro_"+Id).keyup(function(){
									//console.log("#Fila"+Id+" CLICK");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoControlRecepcionEditar('EIN','EinControlGuiaRemisionNumeroOtro','CmpControlGuiaRemisionNumeroOtro','"+Id+"','');", 1500);
									  $(this).data('timer', wait);
									 
								});
								
								$("#CmpControlGuiaRemisionNumero_"+Id).keyup(function(){
									//console.log("#Fila"+Id+" CLICK");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoControlRecepcionEditar('EIN','EinControlGuiaRemisionNumero','CmpControlGuiaRemisionNumero','"+Id+"','');", 1500);
									  $(this).data('timer', wait);

								});
								
								
								$("#CmpControlEmpresaTransporte_"+Id).keyup(function(){
									//console.log("#Fila"+Id+" CLICK");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoControlRecepcionEditar('EIN','EinControlEmpresaTransporte','CmpControlEmpresaTransporte','"+Id+"','');", 1500);
									  $(this).data('timer', wait);

								});
								
								
								$("#CmpControlFechaRecepcion_"+Id).keyup(function(){
									//console.log("#Fila"+Id+" CLICK");
									
									 clearTimeout($.data(this, 'timer'));
									  var wait = setTimeout("FncVehiculoIngresoControlRecepcionEditar('EIN','EinControlFechaRecepcion','CmpFechaRecepcion','"+Id+"','1');", 1500);
									  $(this).data('timer', wait);
									  
								});
								
									Calendar.setup({ 
									inputField : "CmpControlFechaRecepcion_"+Id,  // id del campo de texto 
									ifFormat   : "%d/%m/%Y",  //  
									button     : "BtnControlFechaRecepcion_"+Id,// el id del botón que  
									onUpdate       :    FncVehiculoIngresoControlRecepcionEditarControlFechaRecepcion
									});
									
							}			 
					
						});
	
				}
			});
			
	
}

/***/




function FncVehiculoIngresoControlRecepcionEditar(oTipo,oCampo,oInput,oId,oFecha){
	
	console.log("FncVehiculoIngresoControlRecepcionEditar");

	var Dato = $("#"+oInput+"_"+oId).val();
	
	$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html(ImagenGuardadoCargando);
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoControlRecepcionEditar.php',
		data: 'Tipo='+oTipo+'&Campo='+oCampo+'&Dato='+Dato+'&Id='+oId+'&Fecha='+oFecha,
		success: function(html){
		
			console.log("ResultadoEditar: "+html);
			
			if(html=="1"){
				//$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html("Guardado");
				$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html(ImagenGuardadoSi);
			}else{
				//$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html("Guardado");
				$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html(ImagenGuardadoNo);
			
			}
			
			setTimeout("$(\"#CapVehiculoIngresoControlRecepcionEstado_"+oId+"\").html('');", 1500);
			
			
			
		},
		error:function(html){
			
			//$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html("Error");
			$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html(ImagenGuardadoError);
			
		}
	});

	
}



function FncVehiculoIngresoControlRecepcionEditarControlFechaRecepcion(calendar){
	
	console.log("FncVehiculoIngresoControlRecepcionEditarControlFechaRecepcion");
	
	var Dato = $("#"+calendar.params.inputField.name).val();
	var Campo = "#"+calendar.params.inputField.name; 
	
	
	
	var res = Campo.split("_");	
	var Id = res[1];

	$("#CapVehiculoIngresoControlRecepcionEstado_"+Id).html(ImagenGuardadoCargando);
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoControlRecepcionEditar.php',
		data: 'Tipo=EIN&Campo=EinControlFechaRecepcion&Dato='+Dato+'&Id='+Id+'&Fecha=1',
		success: function(html){

			console.log("ResultadoEditar: "+html);
			
			if(html=="1"){
				//$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html("Guardado");
				$("#CapVehiculoIngresoControlRecepcionEstado_"+Id).html(ImagenGuardadoSi);
			
			}else{
				//$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html("Guardado");
				$("#CapVehiculoIngresoControlRecepcionEstado_"+Id).html(ImagenGuardadoNo);
			
			}
			
			//setTimeout("$('#CapVehiculoIngresoControlRecepcionEstado_'"+oId+").val('');", 1500);
			setTimeout("$(\"#CapVehiculoIngresoControlRecepcionEstado_"+Id+"\").html('');", 1500);
			
		},
		error:function(html){
			//$("#CapVehiculoIngresoControlRecepcionEstado_"+oId).html("Error");
			$("#CapVehiculoIngresoControlRecepcionEstado_"+Id).html(ImagenGuardadoError);
			
			
		}
	});

}