// JavaScript Document


function FncGastoNuevo(){

 	$('#CmpGastoId').val("");
	$('#CmpGastoComprobanteNumero').val("");
	$('#CmpGastoComprobanteFecha').val("");
	$('#CmpGastoTipoCambio').val("");
	$('#CmpGastoFecha').val("");
	$('#CmpGastoTotal').val("");
	
	$('#CmpProveedorNombre').val("");
	$('#CmpProveedorApellidoPaterno').val("");
	$('#CmpProveedorApellidoMaterno').val("");
	
	$('#CmpGastoMonedaNombre').val("");
	$('#CmpGastoMonedaSimbolo').val("");
	
	$('#CmpGastoComprobanteNumero').removeAttr('readonly');

	$("#BtnGastoEditar").hide();
	$("#BtnGastoRegistrar").show();

}

function FncGastoEscoger(InsGasto){	

	$('#CmpGastoId').val(InsGasto.GasId);
	$('#CmpGastoComprobanteNumero').val(InsGasto.GasComprobanteNumero);
	$('#CmpGastoComprobanteFecha').val(InsGasto.GasComprobanteFecha);
	$('#CmpGastoTipoCambio').val(InsGasto.GasTipoCambio);
	$('#CmpGastoFecha').val(InsGasto.GasFecha);
	$('#CmpGastoTotal').val(InsGasto.GasTotal);
	$('#CmpGastoConcepto').val(InsGasto.GasConcepto);
	$('#CmpGastoFoto').val(InsGasto.GasFoto);
	
	$('#CmpProveedorNombre').val(InsGasto.PrvNombre);
	$('#CmpProveedorApellidoPaterno').val(InsGasto.PrvApellidoPaterno);
	$('#CmpProveedorApellidoMaterno').val(InsGasto.PrvApellidoMaterno);
	
	$('#CmpGastoMonedaNombre').val(InsGasto.MonNombre);
	$('#CmpGastoMonedaSimbolo').val(InsGasto.MonSimbolo);
	$('#CmpGastoMonedaId').val(InsGasto.MonId);
	
	$('#CmpGastoComprobanteNumero').attr('readonly', true);
	
	$("#BtnGastoEditar").show();
	$("#BtnGastoRegistrar").hide();

}


function FncGastoBuscar(oCampo){
	
	var Dato = $('#CmpGasto'+oCampo).val()
	
	if(Dato!=""){
	
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Documento/acc/AccGastoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsGasto){

				if(InsGasto.GasId!="" && InsGasto.GasId!=null){
					FncGastoEscoger(InsGasto);
				}else{
					$('#CmpGasto'+oCampo).focus();
					$('#CmpGasto'+oCampo).select();						
				}

			}
		});
		
	}

}



/*
* Funciones PopUp Formulario
*/

function FncGastoCargarFormulario(oForm){
	
	var GastoComprobanteNumero = $("#CmpGastoComprobanteNumero").val();
	var GastoId = $("#CmpGastoId").val();
	//tb_show(this.title,'principal2.php?Mod=Gasto&Form='+oForm+'&Dia=1&GastoId='+oGastoId+'&Id='+oGastoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	
	
	FncCargarVentana("Gasto",oForm,'GastoId='+GastoId+'&Id='+GastoId+'&GastoComprobanteNumero='+GastoComprobanteNumero);

}