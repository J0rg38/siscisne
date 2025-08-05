// JavaScript Document


$().ready(function() {

	
	
/*
* EVENTOS GENERALES
*/

	$("#BtnAlmacenCierreGenerarExcel").click(function(){
		
		FncAlmacenCierreGenerarExcel();
		
	});

/*
* EVENTOS - NAVEGACION
*/		



});





function FncAlmacenCierreGenerarExcel(){
	
	$('#BtnAlmacenCierreGenerarExcel').attr('disabled', 'disabled');
	
	var FechaInicio = FechaHoy;
	var FechaFin = FechaHoy;
//	var FechaInicio = $("#CmpFechaInicio").val();
	// FechaFin = $("#CmpFechaFin").val();
	
//	if(FechaInicio!=""){
//if(FechaFin!=""){

					$('#CapAlmacenCierreArchivo').html("Generando archivo...");	
					$.ajax({
						type: 'POST',
						url: 'formularios/AlmacenCierre/acc/AccAlmacenCierreGenerarExcel.php',
						data: 'FechaInicio='+FechaInicio+'&FechaFin='+FechaFin,
						success: function(html){
							
							$("#BtnAlmacenCierreGenerarExcel").removeAttr('disabled');
							
							$('#CapAlmacenCierreArchivo').html(html);	
						}
					});

			
	//	}
	//}
					
					
	
}

