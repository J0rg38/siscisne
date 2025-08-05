// JavaScript Document

function FncGuiaRemisionImprimir(){
	
	window.print();
	
/*	
	var Tipo = prompt("Escoja el formato de impresion \n 1 = Normal\n 2 = Antiguo", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
						window.print() ;
					break;
					
					case "2":
						
					break;
				
				}
				
	}
			
			
	if(){
		
	}*/
	
//alert(jsPrintSetup.getPaperSizeList());
	/*var StrImpresoras = jsPrintSetup.getPrintersList();
	var ArrImpresoras = StrImpresoras.split(",");
	var Imprimir = true;
	
	for(i=0;i<ArrImpresoras.length;i++){
		
		//alert(ArrImpresoras[i]);
		if(ArrImpresoras[i]=="FACTURA"){
			Imprimir = true;			
		}
	}
	
	//(jsPrintSetup.getGlobalOption());
	
	
	
//	alert(jsPrintSetup.getPaperMeasure ());

	if(Imprimir==true){
		
		//jsPrintSetup.setPrinter("FACTURA");	
		jsPrintSetup.setPrinter("EPSON LX-300+II ESC/P");	
		//alert(jsPrintSetup.getOption('paperWidth'));
		
		// set portrait orientation
		
		jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);//kLandscapeOrientation
		
		// set top margins in millimeters
		jsPrintSetup.setOption('marginTop', 0);
		jsPrintSetup.setOption('marginBottom',0);
		jsPrintSetup.setOption('marginLeft', 0);
		jsPrintSetup.setOption('marginRight', 0);
		// set page header
		jsPrintSetup.setOption('headerStrLeft', '');
		jsPrintSetup.setOption('headerStrCenter', '');
		jsPrintSetup.setOption('headerStrRight', '');
		// set empty page footer
		jsPrintSetup.setOption('footerStrLeft', '');
		jsPrintSetup.setOption('footerStrCenter', '');
		jsPrintSetup.setOption('footerStrRight', '');

		jsPrintSetup.setOption('paperHeight', '15.40');
		jsPrintSetup.setOption('paperWidth', '25.50');
		//jsPrintSetup.setOption('paperData', 	'215.89');		
		
		 
		//jsPrintSetup.setOption('paperSizeType', 	jsPrintSetup.kPaperSizeNativeData);
		jsPrintSetup.setOption('paperSizeType', 	jsPrintSetup.kPaperSizeDefined);

		// clears user preferences always silent print value
		// to enable using 'printSilent' option
		jsPrintSetup.clearSilentPrint();
		// Suparess print dialog (for this context only)
		jsPrintSetup.setOption('printSilent', 0);
		// Do Print 
		// When print is submitted it is executed asynchronous and
		// script flow continues after print independently of completetion of print process! 
		jsPrintSetup.print();
		// next commands
				
	}else{
		alert("No se pudo encontrar la impresora prederminada para la impresion de facturas.");	
	}*/

}