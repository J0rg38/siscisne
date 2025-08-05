// JavaScript Document



(function($) {
 
  // Declaración del plugin.
  $.fn.FncAvisoIniciarFormulario = function(options) {
 	
    options = $.extend({}, $.fn.FncAvisoIniciarFormulario.defaultOptions, options);
 
	this.each(function() {
	var element = $(this);
	element.click(function (event) {  		
	
		if(options.Id == ""){
			
			alert("No ha escogido un numero de VIN");
			
		}else{
			
			$("#"+options.CapaFormulario).html("Cargando...");
			
			$.ajax({
			type: 'POST',
			url: 'comunes/AvisoRapido/CapAvisoRapidoRegistrar.php',
			data: 'VehiculoIngresoId='+options.Id,
				success: function(respuesta){
	
					$("#"+options.CapaFormulario).html(respuesta);
					
					$("#CmpAvisoObservacion").focus();
					
					$("#BtnAvisoGuardar").click(function (event) {  		
						
						var AvisoObservacion = $("#CmpAvisoObservacion").val();
						var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();
						
						if(AvisoObservacion==""){
							alert("No ha ingresado datos en la observacion");
						}else{
							
							$("#"+options.CapaEstado).html("Guardando...");
							
							$.ajax({
							type: 'POST',
							url: 'comunes/AvisoRapido/acc/AccAvisoRapidoRegistrar.php',
							data: 'AvisoObservacion='+AvisoObservacion+'&VehiculoIngresoId='+VehiculoIngresoId,
							success: function(res){
										
									$("#"+options.CapaEstado).html("");
										
									switch(res){
										case "AVI001":
											$("#"+options.CapaFormulario).html("");
											alert("Se guardo correctamente la nota.");
										break;
										
										case "AVI002":
											alert("No se pudo guardar la nota, intente nuevamente.");
										break;
										
										default:
											$("#"+options.CapaFormulario).html("");
											alert("Ha ocurrido un error interno.");
										break;
									}
									
								}
							});
						
						}
						
					}); 
					
					
					$("#BtnAvisoCancelar").click(function (event) {  		
						
						$("#"+options.CapaFormulario).html("");
						
					}); 
					
					
	
				}
			});	
			
		}
		
		return false;
	}); 
	  
	
    });
 
    return this;
  }
 
  // Parametros del plugin.
  $.fn.FncAvisoIniciarFormulario.defaultOptions = {
	Id: '',
	CapaFormulario: 'CapAvisoCargarFormulario',
	CapaEstado: 'CapAvisoEstado'
  }
 

 
})(jQuery);






(function($) {
 

 // Declaración del plugin.
  $.fn.FncAvisoIniciarListado = function(options) {
 	
    options = $.extend({}, $.fn.FncAvisoIniciarListado.defaultOptions, options);
 	
	function FncAvisoCargarListado(){
		
		$("#"+options.CapaFormulario).html("Cargando...");
			
			$.ajax({
			type: 'POST',
			url: 'comunes/AvisoRapido/CapAvisoRapidoListado.php',
			data: 'VehiculoIngresoId='+options.Id+'&Limite='+options.Limite,
				success: function(respuesta){
	
					$("#"+options.CapaFormulario).html(respuesta);
					
					$("#BtnAvisoCancelar").click(function (event) {  		
						
						$("#"+options.CapaFormulario).html("");
						
					}); 
					
					
					$('.AvisoListadoEliminar').each(function () {
						
						$(this).click(function (event) {  		
							
							 if (confirm("¿Realmente desea eliminar la nota?") == true) {
								 
								$("#"+options.CapaEstado).html("Eliminando...");
								
								$.ajax({
								type: 'POST',
								url: 'comunes/AvisoRapido/acc/AccAvisoRapidoEliminar.php',
								data: 'AvisoId='+$(this).attr('codigo'),
								success: function(res){
										
										switch(res){
											case "AVI001":
												$("#"+options.CapaFormulario).html("");
												alert("Se elimino correctamente la nota.");
											break;
											
											case "AVI002":
												alert("No se pudo eliminar la nota, intente nuevamente.");
											break;
											
											default:
												$("#"+options.CapaFormulario).html("");
												alert("Ha ocurrido un error interno.");
											break;
										}
										
										//$("#"+options.CapaEstado).html("");
										
										//$("#"+options.CapaFormulario).html("");
										FncAvisoCargarListado();
										
									}
								});
								
							 }
							
						}); 
						
					});
	
				}
			});	
			
	}
	
	
	this.each(function() {
	var element = $(this);
	element.click(function (event) {  		
	
		if(options.Id == ""){
			
			alert("No ha escogido un numero de VIN");
			
		}else{
			
			FncAvisoCargarListado();
			
			/*$("#"+options.CapaFormulario).html("Cargando...");
			
			$.ajax({
			type: 'POST',
			url: 'comunes/AvisoRapido/CapAvisoRapidoListado.php',
			data: 'VehiculoIngresoId='+options.Id+'&Limite='+options.Limite,
				success: function(respuesta){
	
					$("#"+options.CapaFormulario).html(respuesta);
					
					$("#BtnAvisoCancelar").click(function (event) {  		
						
						$("#"+options.CapaFormulario).html("");
						
					}); 
					
					
					$('.AvisoListadoEliminar').each(function () {
						
						$(this).click(function (event) {  		
							
							 if (confirm("¿Realmente desea eliminar la nota?") == true) {
								 
								$.ajax({
								type: 'POST',
								url: 'comunes/AvisoRapido/acc/AccAvisoRapidoEliminar.php',
								data: 'AvisoId='+$(this).attr('codigo'),
								success: function(res){
											
										$("#"+options.CapaEstado).html("");
											
										switch(res){
											case "AVI001":
												$("#"+options.CapaFormulario).html("");
												alert("Se elimino correctamente la nota.");
											break;
											
											case "AVI002":
												alert("No se pudo eliminar la nota, intente nuevamente.");
											break;
											
											default:
												$("#"+options.CapaFormulario).html("");
												alert("Ha ocurrido un error interno.");
											break;
										}
										
										$("#"+options.CapaFormulario).html("");
										
									}
								});
								
							 }
							
						}); 
						
					});
	
				}
			});	*/
			
		}
		
		return false;

	}); 
	  
	
    });
 
    return this;
  }
 
  // Parametros del plugin.
  $.fn.FncAvisoIniciarListado.defaultOptions = {
	Id: '',
	CapaFormulario: 'CapAvisoCargarFormulario',
	CapaEstado: 'CapAvisoEstado',
	Limite: '10'
  }




 
})(jQuery);



$().ready(function() {	

//$("#BtnAvisoCargarFormulario").FncAvisoIniciarFormulario({
//		
//		'Id':$("#CmpVehiculoIngresoId").val(),
//		'CapaFormulario':'CapAvisoCargarFormulario'
//		
//	});
	
});	
