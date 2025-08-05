// JavaScript Document

/*
Agregando Eventos
*/
/*$().ready(function() {

	$("select#CmpRegimenId").change(function(){
		FncRegimenBuscar('Id');
	});

});*/
	
function FncRegimenBuscar(oCampo){
	
	var Dato = $('#CmpRegimen'+oCampo).val();	
	
	if(Dato!=""){
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Regimen/acc/AccRegimenBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsRegimen){

			if(InsRegimen.RegId!=""){
				FncRegimenEscoger(InsRegimen.RegId,InsRegimen.RegPorcentaje,InsRegimen.RegAplicacion,InsRegimen.RegNombre);
			}				
			}
		});	
	}
}

function FncRegimenEscoger(oRegimenId,oRegimenPorcentaje,oRegimenAplicacion,oRegimenNombre){


	$('#CapRegimenBuscar').html("");
	
	$('#CmpRegimenId').val(oRegimenId);	
	
	var Regimen = "";
	
	/*if($('#CmpRegimenPorcentaje').length > 0) {
		$('#CmpRegimenPorcentaje').val(oRegimenPorcentaje);
	}else{
		Regimen = Regimen + '<input size="10" type="hidden" name="CmpRegimenPorcentaje" id="CmpRegimenPorcentaje" value="' +oRegimenPorcentaje +'">';
	}*/
	
	if($('#CmpRegimenAplicacion').length > 0) {
		$('#CmpRegimenAplicacion').val(oRegimenAplicacion);
	}else{
		Regimen = Regimen + '<input size="10" type="hidden" name="CmpRegimenAplicacion" id="CmpRegimenAplicacion" value="' +oRegimenAplicacion +'">';	
	}
	
	
	if($('#CmpRegimenNombre').length > 0) {
		$('#CmpRegimenNombre').val(oRegimenNombre);
	}else{
		Regimen = Regimen + '<input size="10" type="hidden" name="CmpRegimenNombre" id="CmpRegimenNombre" value="' +oRegimenNombre +'">';	
	}
	
	$('#CapRegimenBuscar').html(Regimen);


	if ($.isFunction(window.FncRegimenFuncion)){
        FncRegimenFuncion();
	}

	//if(RegimenFuncion!=""){
//		eval(RegimenFuncion+"();");
//	}


}
