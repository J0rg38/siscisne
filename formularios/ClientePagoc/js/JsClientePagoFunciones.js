$().ready(function() {
	//$("select#CmpMonedaId").change(function(){
	$("#CmpMonedaId").change(function(){
		FncClientePagoEstablecerMoneda();
	});
	
	$("#CmpFormaPago").change(function(){
		FncEstablecerClientePagoFormaPago();
	});
	
});


function FncCalcularMontoReal(){
	var Monto = ($('#CmpMonto').val());	
	var RetencionPorcentaje = ($('#CmpRetencionPorcentaje').val());

	if(RetencionPorcentaje==""){
		RetencionPorcentaje = 0;
	}

	if(Monto==""){
		Monto = 0;
	}

	var Retencion = (((RetencionPorcentaje)/100)*(Monto));

	$('#CmpRetencion').val((Retencion));
	
	var MontoReal = parseFloat(Monto) - parseFloat(Retencion);
	
	$('#CmpMontoReal').val(MontoReal);

}

function FncEstablecerClientePagoFormaPago(){

	var FormaPago = $('#CmpFormaPago').val();	

	var TarjetaNumero = $('#CmpTarjetaNumeroAux').val();
	var TarjetaTipo = $('#CmpTarjetaTipoAux').val();
	
	var TarjetaMarca = $('#CmpTarjetaMarcaAux').val();
	var TarjetaMarcaId = $('#CmpTarjetaMarcaIdAux').val();
	
	var TarjetaEntidad = $('#CmpTarjetaEntidadAux').val();
	var TarjetaEntidadId = $('#CmpTarjetaEntidadIdAux').val();
	
	var Banco = $('#CmpBancoAux').val();
	var BancoId = $('#CmpBancoIdAux').val();
	
	var BancoDepositar = $('#CmpBancoDepositarAux').val();
	var BancoDepositarId = $('#CmpBancoDepositarIdAux').val();
	
	var ChequeNumero = $('#CmpChequeNumeroAux').val();	
	var TransaccionNumero = $('#CmpTransaccionNumeroAux').val();

	var RetencionPorcentaje = $('#CmpRetencionPorcentajeAux').val();
	var NumeroReferencia = $('#CmpNumeroReferenciaAux').val();

	var TransaccionSituacion = $('#CmpTransaccionSituacionAux').val();	
	
	
	var Monto = $('#CmpMonto').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var MonedaId = $('#CmpMonedaId').val();

			
	if(TipoCambio==""){
		TipoCambio = 1;
	}
	
	$('#CapMonedaMonto').html(MonedaSimbolo);
	
	switch(FormaPago){
		//PAGO EFECTIVO
		case 'FPA-10000':

			$.ajax({
			type: 'POST',
			url: Ruta+'comunes/FormaPago/Efectivo.php',
			data: 'Monto='+Monto+'&TipoCambio='+TipoCambio+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TarjetaNumero='+TarjetaNumero+'&TarjetaTipo='+TarjetaTipo+'&TarjetaMarca='+TarjetaMarca+'&TarjetaMarcaId='+TarjetaMarcaId+'&TarjetaEntidad='+TarjetaEntidad+'&TarjetaEntidadId='+TarjetaEntidadId+'&Banco='+Banco+'&BancoId='+BancoId+'&BancoDepositar='+BancoDepositar+'&BancoDepositarId='+BancoDepositarId+'&ChequeNumero='+ChequeNumero+'&TransaccionNumero='+TransaccionNumero+'&RetencionPorcentaje='+RetencionPorcentaje+'&NumeroReferencia='+NumeroReferencia+'&TransaccionSituacion='+TransaccionSituacion+'&FormaPagoEditar='+FormaPagoEditar,
				success: function(html){
					$('#CapFormaPago').html(html);
				}
			});

		break;
		
		//DEPOSITO BANCARIO
		case 'FPA-10001':

			$.ajax({
			type: 'POST',
			url: Ruta+'comunes/FormaPago/DepositoBancario.php',
			data: 'Monto='+Monto+'&TipoCambio='+TipoCambio+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TarjetaNumero='+TarjetaNumero+'&TarjetaTipo='+TarjetaTipo+'&TarjetaMarca='+TarjetaMarca+'&TarjetaMarcaId='+TarjetaMarcaId+'&TarjetaEntidad='+TarjetaEntidad+'&TarjetaEntidadId='+TarjetaEntidadId+'&Banco='+Banco+'&BancoId='+BancoId+'&BancoDepositar='+BancoDepositar+'&BancoDepositarId='+BancoDepositarId+'&ChequeNumero='+ChequeNumero+'&TransaccionNumero='+TransaccionNumero+'&RetencionPorcentaje='+RetencionPorcentaje+'&NumeroReferencia='+NumeroReferencia+'&TransaccionSituacion='+TransaccionSituacion+'&FormaPagoEditar='+FormaPagoEditar,
				success: function(html){
					
					$('#CapFormaPago').html(html);
				
					
					
					FncBancoDepositarAutocompletarCargar();

					
					/*$('#CmpBancoDepositar').unautocomplete();				

					$('#CmpBancoDepositar').autocomplete(Ruta+'comunes/FormaPago/XmlBanco.php', {
						width: 500,
						selectFirst: false
					});	

					$("#CmpBancoDepositar").result(function(event, data, formatted) {
						if (data){
							$("#CmpBancoDepositarId").val(data[1]);
						}		
					});		*/
			

				}
			});

		break;
		//CHEQUE
		case 'FPA-10002':
			
			$.ajax({
			type: 'POST',
			url: Ruta+'comunes/FormaPago/Cheque.php',
			data: 'Monto='+Monto+'&TipoCambio='+TipoCambio+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TarjetaNumero='+TarjetaNumero+'&TarjetaTipo='+TarjetaTipo+'&TarjetaMarca='+TarjetaMarca+'&TarjetaMarcaId='+TarjetaMarcaId+'&TarjetaEntidad='+TarjetaEntidad+'&TarjetaEntidadId='+TarjetaEntidadId+'&Banco='+Banco+'&BancoId='+BancoId+'&BancoDepositar='+BancoDepositar+'&BancoDepositarId='+BancoDepositarId+'&ChequeNumero='+ChequeNumero+'&TransaccionNumero='+TransaccionNumero+'&RetencionPorcentaje='+RetencionPorcentaje+'&NumeroReferencia='+NumeroReferencia+'&TransaccionSituacion='+TransaccionSituacion+'&FormaPagoEditar='+FormaPagoEditar,
				success: function(html){

					$('#CapFormaPago').html(html);

					//BANCO
					FncBancoAutocompletarCargar();
					
					/*$('#CmpBanco').unautocomplete();					
					$('#CmpBanco').autocomplete(Ruta+'comunes/FormaPago/XmlBanco.php', {
						width: 500,
						selectFirst: false
					});
					
					$("#CmpBanco").result(function(event, data, formatted) {
						if (data){
							$("#CmpBancoId").val(data[1]);
						}		
					});*/
					
					//BANCO DEPOSITAR
					FncBancoDepositarAutocompletarCargar();
					
					/*$('#CmpBancoDepositar').unautocomplete();
					$('#CmpBancoDepositar').autocomplete(Ruta+'comunes/FormaPago/XmlBanco.php', {
						width: 500,
						selectFirst: false
					});
						
					$("#CmpBancoDepositar").result(function(event, data, formatted) {
						if (data){
							$("#CmpBancoId").val(data[1]);
						}		
					});*/
					
				}
			});
			
		break;

		//TARJETA
		case 'FPA-10003':
			
			$.ajax({
			type: 'POST',
			url: Ruta+'comunes/FormaPago/Tarjeta.php',
			data: 'Monto='+Monto+'&TipoCambio='+TipoCambio+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TarjetaNumero='+TarjetaNumero+'&TarjetaTipo='+TarjetaTipo+'&TarjetaMarca='+TarjetaMarca+'&TarjetaMarcaId='+TarjetaMarcaId+'&TarjetaEntidad='+TarjetaEntidad+'&TarjetaEntidadId='+TarjetaEntidadId+'&Banco='+Banco+'&BancoId='+BancoId+'&BancoDepositar='+BancoDepositar+'&BancoDepositarId='+BancoDepositarId+'&ChequeNumero='+ChequeNumero+'&TransaccionNumero='+TransaccionNumero+'&RetencionPorcentaje='+RetencionPorcentaje+'&NumeroReferencia='+NumeroReferencia+'&TransaccionSituacion='+TransaccionSituacion+'&FormaPagoEditar='+FormaPagoEditar,
				success: function(html){
					
					$('#CapFormaPago').html(html);
					//TARJETA MARCA
					FncTarjetaMarcaAutocompletarCargar();
					
					/*$('#CmpTarjetaMarca').unautocomplete();					
					$('#CmpTarjetaMarca').autocomplete(Ruta+'comunes/FormaPago/XmlTarjetaMarca.php', {
						width: 500,
						selectFirst: false
					});	
					
					$("#CmpTarjetaMarca").result(function(event, data, formatted) {
						if (data){
							$("#CmpTarjetaMarcaId").val(data[1]);
						}		
					});*/
					
					//ENTIDAD
					FncTarjetaEntidadAutocompletarCargar();
					/*$('#CmpTarjetaEntidad').unautocomplete();					
					$('#CmpTarjetaEntidad').autocomplete(Ruta+'comunes/FormaPago/XmlTarjetaEntidad.php', {
						width: 500,
						selectFirst: false
					});
						
					$("#CmpTarjetaEntidad").result(function(event, data, formatted) {
						if (data){
							$("#CmpTarjetaMarcaId").val(data[1]);
						}		
					});*/
					
					//BANCO DEPOSITAR
					FncBancoDepositarAutocompletarCargar();
					
					/*$('#CmpBancoDepositar').unautocomplete();					
					$('#CmpBancoDepositar').autocomplete(Ruta+'comunes/FormaPago/XmlBanco.php', {
						width: 500,
						selectFirst: false
					});
					
					$("#CmpBancoDepositar").result(function(event, data, formatted) {
						if (data){
							$("#CmpBancoDepositarId").val(data[1]);
						}		
					});*/
					
					//FncCalcularMontoReal();
									
				}
			});
			
		break;


		//NOTA DE CREDITO
		case 'FPA-10005':

			$.ajax({
			type: 'POST',
			url: Ruta+'comunes/FormaPago/NotaCredito.php',
			data: 'Monto='+Monto+'&TipoCambio='+TipoCambio+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TarjetaNumero='+TarjetaNumero+'&TarjetaTipo='+TarjetaTipo+'&TarjetaMarca='+TarjetaMarca+'&TarjetaMarcaId='+TarjetaMarcaId+'&TarjetaEntidad='+TarjetaEntidad+'&TarjetaEntidadId='+TarjetaEntidadId+'&Banco='+Banco+'&BancoId='+BancoId+'&BancoDepositar='+BancoDepositar+'&BancoDepositarId='+BancoDepositarId+'&ChequeNumero='+ChequeNumero+'&TransaccionNumero='+TransaccionNumero+'&RetencionPorcentaje='+RetencionPorcentaje+'&NumeroReferencia='+NumeroReferencia+'&TransaccionSituacion='+TransaccionSituacion+'&FormaPagoEditar='+FormaPagoEditar,
				success: function(html){
					$('#CapFormaPago').html(html);
				}
			});

		break;
	
		case '':
			$('#CapFormaPago').html('');
		break;	
		
		default:
			$('#CapFormaPago').html('');
		break;		
	}
	
}



function FncClientePagoEstablecerMoneda(){
	
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var MonedaId = $('#CmpMonedaId').val();
	
	if(MonedaId==""){
		/*if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
			$('#CmpTipoCambio').attr('readonly', true);		
		}else{
			$('#CmpTipoCambio').removeAttr('readonly');	
		}*/
		
		$('#CmpTipoCambio').val('');
		$('#CmpTipoCambio').attr('readonly', true);	
		
		alert("Debe Escoger una moneda");
		
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
			$('#CmpTipoCambio').attr('readonly', true);	
		}else{
			$('#CmpTipoCambio').removeAttr('readonly');	
		}

		FncMonedaBuscar('Id');
	}
	
	$('#CapMonedaMonto').html(MonedaSimbolo);
	
}

function FncMonedaFuncion(){
	FncEstablecerClientePagoFormaPago();

}