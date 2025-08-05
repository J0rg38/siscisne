// JavaScript Document


	
$().ready(function() {

	$('#BtnImprimir').on('click', function() {
		
		$('#P').val("1");
		$('#FrmOrdenDia').submit();

	});
	
	/*$('#Fecha').on('change', function() {
		console.log("Fecha");
	});
	
	*/
});
	
function FncOrdenVentaVehiculoMP2Imprimir(){
	
	window.print();
	
}

function FncOrdenVentaVehiculoCargar(){
	
	$('#FrmOrdenDia').submit();
	
}
