// JavaScript Document

$(function(){

	$("#BtnGastoEditar").hide();
	$("#BtnGastoRegistrar").show();
	
});

function FncGastoFormato(row) {			
	
	return "<td>"+row[2]+"</td><td>"+row[1]+"</td><td align='left'>"+row[3]+"</td><td align='center'>"+row[4]+"</td><td align='center'>"+row[5]+"</td>";
	
}

$(function(){
	
	$("#CmpGastoComprobanteNumero").unautocomplete();
	$("#CmpGastoComprobanteNumero").autocomplete('comunes/Documento/XmlGasto.php?Campo=GasComprobanteNumero', {
		width: 900,
		max: 100,
		formatItem: FncGastoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpGastoComprobanteNumero").result(function(event, data, formatted) {
		if (data){
			$("#CmpGastoId").val(data[0]);				
			FncGastoBuscar("Id");	
		}		
	});
	
});