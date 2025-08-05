
// JavaScript Document

$().ready(function() {

	//$("#CmpOrdenCompraPedidoCancelado").click(function(){
//		FncOrdenCompraPagar();
//		
//	});

});

	
function FncOrdenCompraPagoImprimirAccion(){
	
	window.print();
	
}

function FncOrdenCompraPagoImprimir(oIndice){

	var Accion = document.getElementById('FrmOrdenCompraPago'+oIndice).action;
	
	document.getElementById('FrmOrdenCompraPago'+oIndice).target = '_blank';
	document.getElementById('FrmOrdenCompraPago'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmOrdenCompraPago'+oIndice).submit();
	
	document.getElementById('FrmOrdenCompraPago'+oIndice).target = 'IfrOrdenCompraPago';
	document.getElementById('FrmOrdenCompraPago'+oIndice).action = Accion;

}

function FncOrdenCompraPagoGenerarExcel(oIndice){

	var Accion = document.getElementById('FrmOrdenCompraPago'+oIndice).action;
	
	document.getElementById('FrmOrdenCompraPago'+oIndice).target = '_blank';
	//document.getElementById('FrmOrdenCompraPago'+oIndice).action = Accion+'?P=2';

	var Tipo = prompt("Escoja el tipo de excel \n 1 = Forum\n 2 = Normal", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
	document.getElementById('FrmOrdenCompraPago'+oIndice).action = Accion+'?P=2&C=1';
			break;
			
			case "2":
	document.getElementById('FrmOrdenCompraPago'+oIndice).action = Accion+'?P=2';
			break;
		
		}
		
	}

	document.getElementById('FrmOrdenCompraPago'+oIndice).submit();
	document.getElementById('FrmOrdenCompraPago'+oIndice).target = 'IfrOrdenCompraPago'+oIndice;
	document.getElementById('FrmOrdenCompraPago'+oIndice).action = Accion;

}



function FncOrdenCompraPagoNuevo(){

		
}






