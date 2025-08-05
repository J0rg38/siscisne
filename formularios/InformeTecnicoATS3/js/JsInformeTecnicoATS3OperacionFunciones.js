// JavaScript Document

function FncInformeTecnicoATS3OperacionNuevo(){
			
	$('#CmpInformeTecnicoATS3OperacionId').val("");

	$('#CmpInformeTecnicoATS3OperacionNumero').val("");
	$('#CmpInformeTecnicoATS3OperacionTiempo').val("");
	$('#CmpInformeTecnicoATS3OperacionCostoHora').val("");
	$('#CmpInformeTecnicoATS3OperacionValorTotal').val("");
//	$('#CmpInformeTecnicoATS3OperacionEstado').val("");	
	$('#CmpInformeTecnicoATS3OperacionItem').val("");	
	
	$('#CapInformeTecnicoATS3OperacionAccion').html('Listo para registrar elementos');	
			
	$('#CmpInformeTecnicoATS3OperacionNumero').select();
			
	$('#CmpInformeTecnicoATS3OperacionAccion').val("AccInformeTecnicoATS3OperacionRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncInformeTecnicoATS3OperacionGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpInformeTecnicoATS3OperacionAccion').val();		

	var InformeTecnicoATS3OperacionId = $('#CmpInformeTecnicoATS3OperacionId').val();
	var InformeTecnicoATS3OperacionNumero = $('#CmpInformeTecnicoATS3OperacionNumero').val();			
	var InformeTecnicoATS3OperacionTiempo = $('#CmpInformeTecnicoATS3OperacionTiempo').val();
	var InformeTecnicoATS3OperacionCostoHora = $('#CmpInformeTecnicoATS3OperacionCostoHora').val();
	var InformeTecnicoATS3OperacionValorTotal = $('#CmpInformeTecnicoATS3OperacionValorTotal').val();

	var InformeTecnicoATS3OperacionEstado = $('#CmpInformeTecnicoATS3OperacionEstado').val();

	var Item = $('#CmpInformeTecnicoATS3OperacionItem').val();
	
	if(InformeTecnicoATS3OperacionNumero==""){
		$('#CmpInformeTecnicoATS3OperacionNumero').focus();
		
	}else if(InformeTecnicoATS3OperacionTiempo==""){
		$('#CmpInformeTecnicoATS3OperacionTiempo').focus();
		
	}else if(CmpInformeTecnicoATS3OperacionCostoHora=="" || CmpInformeTecnicoATS3OperacionCostoHora <=0){
		$('#CmpInformeTecnicoATS3OperacionCostoHora').focus();	
		
	}else if(InformeTecnicoATS3OperacionValorTotal=="" || InformeTecnicoATS3OperacionValorTotal <=0){
		$('#CmpInformeTecnicoATS3OperacionValorTotal').focus();	
		
	}else{
		$('#CapInformeTecnicoATS3OperacionAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/'+Acc,
			data: 'Identificador='+Identificador+
			'&InformeTecnicoATS3OperacionId='+InformeTecnicoATS3OperacionId+
			'&InformeTecnicoATS3OperacionNumero='+InformeTecnicoATS3OperacionNumero+
			'&InformeTecnicoATS3OperacionTiempo='+InformeTecnicoATS3OperacionTiempo+
			'&InformeTecnicoATS3OperacionCostoHora='+InformeTecnicoATS3OperacionCostoHora+
			'&InformeTecnicoATS3OperacionValorTotal='+InformeTecnicoATS3OperacionValorTotal+
			'&InformeTecnicoATS3OperacionEstado='+InformeTecnicoATS3OperacionEstado+
			'&Item='+Item,
			success: function(){
				
			$('#CapInformeTecnicoATS3OperacionAccion').html('Listo');							
				FncInformeTecnicoATS3OperacionListar();
			}
		});
		
		FncInformeTecnicoATS3OperacionNuevo();
	}
	
}


function FncInformeTecnicoATS3OperacionListar(){

	var Identificador = $('#Identificador').val();

	$('#CapInformeTecnicoATS3OperacionAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/InformeTecnicoATS3/FrmInformeTecnicoATS3OperacionListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+InformeTecnicoATS3OperacionEditar+
		'&Eliminar='+InformeTecnicoATS3OperacionEliminar+
		'&MonedaId='+MonedaId+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapInformeTecnicoATS3OperacionAccion').html('Listo');	
			$("#CapInformeTecnicoATS3Operaciones").html("");
			$("#CapInformeTecnicoATS3Operaciones").append(html);
		}
	});

}



function FncInformeTecnicoATS3OperacionEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapInformeTecnicoATS3OperacionAccion').html('Editando...');
	$('#CmpInformeTecnicoATS3OperacionAccion').val("AccInformeTecnicoATS3OperacionEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3OperacionEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsInformeTecnicoATS3Operacion){


		//SesionObjeto-InsInformeTecnicoATS3Operacion
		//Parametro1 = ItoId
		//Parametro2 = ItoNumero
		//Parametro3 = ItoTiempo
		//Parametro4 = ItoCostoHora
		//Parametro5 = ItoValorTotal
		//Parametro6 = ItoEstado
		//Parametro7 = ItoTiempoCreacion
		//Parametro8 = ItoTiempoModificacion
		//Parametro9 = FaeId

			$('#CmpInformeTecnicoATS3OperacionNumero').val(InsInformeTecnicoATS3Operacion.Parametro2);	
			$('#CmpInformeTecnicoATS3OperacionTiempo').val(InsInformeTecnicoATS3Operacion.Parametro3);
			$('#CmpInformeTecnicoATS3OperacionCostoHora').val(InsInformeTecnicoATS3Operacion.Parametro4);
			$('#CmpInformeTecnicoATS3OperacionValorTotal').val(InsInformeTecnicoATS3Operacion.Parametro5);
			
			$('#CmpInformeTecnicoATS3OperacionEstado').val(InsInformeTecnicoATS3Operacion.Parametro6);
			
			$('#CmpInformeTecnicoATS3OperacionItem').val(InsInformeTecnicoATS3Operacion.Item);
			
			$('#CmpInformeTecnicoATS3OperacionNumero').select();
				
		}
	});
	
	

	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncInformeTecnicoATS3OperacionEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapInformeTecnicoATS3OperacionAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3OperacionEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapInformeTecnicoATS3OperacionAccion').html("Eliminado");	
				FncInformeTecnicoATS3OperacionListar();
			}
		});

		FncInformeTecnicoATS3OperacionNuevo();

	}
	
}

function FncInformeTecnicoATS3OperacionEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapInformeTecnicoATS3OperacionAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/InformeTecnicoATS3/acc/AccInformeTecnicoATS3OperacionEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapInformeTecnicoATS3OperacionAccion').html('Eliminado');	
				FncInformeTecnicoATS3OperacionListar();
			}
		});	
			
		FncInformeTecnicoATS3OperacionNuevo();
	}
	
}












function FncInformeTecnicoATS3OperacionCalcularValorTotal(){

	var Tiempo = $('#CmpInformeTecnicoATS3OperacionTiempo').val();
	var CostoHora = $('#CmpInformeTecnicoATS3OperacionCostoHora').val();
	var ValorTotal = 0;	
	
	if(Tiempo!=""){
		if(CostoHora!=""){
			
			ValorTotal = Tiempo * CostoHora;
			ValorTotal = Math.round(ValorTotal*100000)/100000;
			
			$('#CmpInformeTecnicoATS3OperacionValorTotal').val(ValorTotal);
		}else{
			$('#CmpInformeTecnicoATS3OperacionCostoHora').val("0");
		}
	}else{
		$('#CmpInformeTecnicoATS3OperacionTiempo').val("0");
	}
	
}

function FncInformeTecnicoATS3OperacionCalcularTiempo(){

	var Tiempo = 0;
	var CostoHora = $('#CmpInformeTecnicoATS3OperacionCostoHora').val();
	var ValorTotal = $('#CmpInformeTecnicoATS3OperacionValorTotal').val();	

//alert(Cantidad);
	if(CostoHora!=""){
		if(ValorTotal!=""){
			
			Tiempo = ValorTotal / CostoHora;
			Tiempo = Math.round(Tiempo*100000)/100000;
			
			$('#CmpInformeTecnicoATS3OperacionTiempo').val(Tiempo);
		}else{
			$('#CmpInformeTecnicoATS3OperacionValorTotal').val("0");
		}
	}else{
		$('#CmpInformeTecnicoATS3OperacionCostoHora').val("0");
	}
}

$().ready(function() {

	$("#CmpInformeTecnicoATS3OperacionTiempo").keyup(function (event) {  
		FncInformeTecnicoATS3OperacionCalcularValorTotal();
	});

	$("#CmpInformeTecnicoATS3OperacionValorTotal").keyup(function (event) {  
		FncInformeTecnicoATS3OperacionCalcularTiempo();
	});
	
	
	$("#CmpInformeTecnicoATS3OperacionCostoHora").keyup(function (event) {  
		FncInformeTecnicoATS3OperacionCalcularValorTotal();
	});

});


