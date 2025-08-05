// JavaScript Document


$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	


//alert($("#CmpOrdenCompraId").val());

	if($("#CmpOrdenCompraId").val()==""){
		$("#BtnOrdenCompraEditar").hide();
		$("#BtnOrdenCompraRegistrar").show();
		
		
	}else{
		$("#BtnOrdenCompraEditar").show();
		$("#BtnOrdenCompraRegistrar").hide();	
	}

});	



//function FncOrdenCompraGMNuevo(){
//	FncOrdenCompraNuevo();
//}

function FncOrdenCompraNuevo(){

	$('#CmpOrdenCompra').val("");
	$('#CmpOrdenCompraId').val("");
	$('#CmpOrdenCompraFecha').val("");	
	$('#CmpOrdenCompraProveedor').val("");

	$("#BtnOrdenCompraEditar").hide();
	$("#BtnOrdenCompraRegistrar").show();

	$('#CmpOrdenCompra').removeAttr('readonly');
	
	FncOrdenCompraNuevoFuncion();
}

function FncOrdenCompraNuevoFuncion(){
	
}
//function FncOrdenCompraGMBuscar(oCampo){
//	FncOrdenCompraBuscar(oCampo);
//}

function FncOrdenCompraBuscar(oCampo){

	var Dato = $('#CmpOrdenCompra'+oCampo).val();
	
	if(Dato==""){
		$('#CmpOrdenCompra'+oCampo).focus();
		$('#CmpOrdenCompra'+oCampo).select();		
	}else{				
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/OrdenCompra/acc/AccOrdenCompraBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsOrdenCompra){
				if(InsOrdenCompra.OcoId!=null){					
					FncOrdenCompraEscoger(InsOrdenCompra.OcoId,InsOrdenCompra.OcoFecha,InsOrdenCompra.PrvNombre);
				}
			}
		});	
	}

}

//function FncOrdenCompraGMEscoger(oOrdenCompraId,oOrdenCompraFecha,oOrdenCompraProveedorNombre){
//
//	 FncOrdenCompraEscoger(oOrdenCompraId,oOrdenCompraFecha,oOrdenCompraProveedorNombre);
//
//}


function FncOrdenCompraEscoger(oOrdenCompraId,oOrdenCompraFecha,oOrdenCompraProveedorNombre){

	$('#CapOrdenCompraBuscar').html('');

	$('#CmpOrdenCompra').val(oOrdenCompraId);	
	$('#CmpOrdenCompraId').val(oOrdenCompraId);
	$('#CmpOrdenCompraFecha').val(oOrdenCompraFecha);
	$('#CmpOrdenCompraProveedor').val(oOrdenCompraProveedorNombre);

	$("#BtnOrdenCompraEditar").show();
	$("#BtnOrdenCompraRegistrar").hide();
	
	
	$('#CmpOrdenCompra').attr('readonly', true);
	
	FncOrdenCompraFuncion();
}

function FncOrdenCompraFuncion(){

}

/*
* Funciones PopUp Formulario
*/
function FncOrdenCompraCargarFormulario(oForm){

	//var OrdenCompraId = $('#CmpOrdenCompraId').val();
	//tb_show(this.title,'principal2.php?Mod=OrdenCompraGM&Form='+oForm+'&Dia=1&Id='+OrdenCompraId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);
	
	var OrdenCompraId = $('#CmpOrdenCompraId').val();
	tb_show(this.title,'principal2.php?Mod=OrdenCompra&Form='+oForm+'&Dia=1&Id='+OrdenCompraId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	
			

}
