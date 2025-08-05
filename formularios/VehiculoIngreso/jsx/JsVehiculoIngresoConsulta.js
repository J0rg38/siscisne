// JavaScript Document


function FncValidar(){

	var CmpVehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var CmpVehiculoIngresoPlaca = $("#CmpVehiculoIngresoPlaca").val();

		if(CmpVehiculoIngresoVIN == "" && CmpVehiculoIngresoPlaca == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un VIN o Placa de vehiculo",
					callback: function(result){
						$("#CmpVehiculoIngresoVIN").focus();
					}
				});
				
			return false;
	
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}


/*
*** EVENTOS
*/

$().ready(function() {

/*
* EVENTOS - INICIALES
*/

	/*$('#FrmVehiculoIngresoConsulta').on('submit', function() {
		
		//return FncValidar();
		return false;
	});*/


	$('#BtnVer').on('click', function() {
		
		if(FncValidar()){
			FrmVehiculoIngresoConsultaVer();
		}
		
	});
	
	$('#BtnImprimir').on('click', function() {
		
		if(FncValidar()){
			FrmVehiculoIngresoConsultaImprimir();
		}
		
	});
	
	$('#BtnExcel').on('click', function() {
		
		if(FncValidar()){
			FrmVehiculoIngresoConsultaGenerarExcel();
		}
		
	});


});




function FrmVehiculoIngresoConsultaVer(){
	
	var CmpVehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var CmpVehiculoIngresoPlaca = $("#CmpVehiculoIngresoPlaca").val();
	
	$('#CapVehiculoIngresoConsulta').html("Cargando...");	
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/IfrVehiculoIngresoConsulta.php',
		data: 'CmpVehiculoIngresoVIN='+CmpVehiculoIngresoVIN+"&CmpVehiculoIngresoPlaca="+CmpVehiculoIngresoPlaca,
		success: function(html){
			$('#CapVehiculoIngresoConsulta').html(html);	
		}
	});

}

function FrmVehiculoIngresoConsultaImprimir(){
	
	var CmpVehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var CmpVehiculoIngresoPlaca = $("#CmpVehiculoIngresoPlaca").val();
	
	
	FncPopUp('formularios/VehiculoIngreso/IfrVehiculoIngresoConsulta.php?P=1&CmpVehiculoIngresoVIN='+CmpVehiculoIngresoVIN+"&CmpVehiculoIngresoPlaca="+CmpVehiculoIngresoPlaca,0,0,1,0,0,1,0,screen.height,screen.width);
	
}

function FrmVehiculoIngresoConsultaGenerarExcel(){
	
	var CmpVehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	var CmpVehiculoIngresoPlaca = $("#CmpVehiculoIngresoPlaca").val();
	
	FncPopUp('formularios/VehiculoIngreso/IfrVehiculoIngresoConsulta.php?P=2&CmpVehiculoIngresoVIN='+CmpVehiculoIngresoVIN+"&CmpVehiculoIngresoPlaca="+CmpVehiculoIngresoPlaca,0,0,1,0,0,1,0,screen.height,screen.width);
	
}


/*
FORMULARIOS
*/



function FncClienteCargarFormulario(oForm,oClienteId){

	tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&Id='+oClienteId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+(screen.height-200)+'&width='+(screen.width-100)+'&modal=true',this.rel);		

}