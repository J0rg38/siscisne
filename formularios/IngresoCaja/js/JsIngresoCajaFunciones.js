// JavaScript Document

function FncGuardar(){
	
	//HACK
	$("#CmpMonedaId").removeAttr('disabled');	
	$("#CmpClienteTipoDocumento").removeAttr('disabled');	
	
}

var FormularioCampos = [
"CmpFecha",
"CmpCondicionPago",
"CmpCuenta",
"CmpMonedaId",
"CmpManoObra",
"CmpManoObra"];

$().ready(function() {

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncIngresoNavegar(this.id);
		 }
	}); 

	$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 

	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 

/*
Agregando Eventos
*/

	$("select#CmpMonedaId").change(function(){
		FncIngresoEstablecerMoneda();
		FncCuentaCargar();
	});
	
	$("select#CmpCuenta").change(function(){
		FncIngresoEstablecerCuenta();
	});


	/*$("select#CmpTipoDestino").change(function(){
		FncIngresoEstablecerTipoDestino($(this).val());
	});*/
	
	
	/*$("#CmpTipoDestino").click(function(){
		FncIngresoEstablecerTipoDestino($(this).val());
	});*/


	$("input[name='CmpTipoDestino']").change(function(){
		FncIngresoEstablecerTipoDestino($(this).val());
	});


//	$("input[name=CmpTipoDestino]").click(function () {    
//      //  alert("La edad seleccionada es: " + $('input:radio[name=edad]:checked').val());
//        //alert("La edad seleccionada es: " + $(this).val());
//		
//		//FncIngresoEstablecerTipoDestino($('input:radio[name=CmpTipoDestino]:checked').val());
//		FncIngresoEstablecerTipoDestino($(this).val());
//    });
//	
	

});
	
function FncIngresoNavegar(oCampo){
	
	for(var i=0; i< FormularioCampos.length; i++) {
		if(FormularioCampos.length !== i + 1){
			
			if(FormularioCampos[i]==oCampo){
				
				if($('#'+FormularioCampos[i+1]).attr('type')=="text"){
					$('#'+FormularioCampos[i]).blur();
					$('#'+FormularioCampos[i+1]).focus();
					$('#'+FormularioCampos[i+1]).select();	
				}else{
					$('#'+FormularioCampos[i]).blur();	
					$('#'+FormularioCampos[i+1]).focus();	
				}
								
			}				
			
		}
			
	}
	
}


/*
* FUNCIONES
*/

function FncIngresoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			}
		}
		FncMonedaBuscar('Id');
	}

}

function FncIngresoEstablecerCuenta(){
	
	var CuentaId = $('#CmpCuentaId').val();
	
	$.getJSON("comunes/Moneda/JnCuenta.php?CuentaId="+CuentaId,{}, 
		function(j){
			$("#CmpMonedaId").val(j.MonId);
			FncIngresoEstablecerMoneda();

	});

}


function FncIngresoEstablecerTipoDestino(oValor){
	
	switch(oValor){
		
		case "1":
			$("#CapProveedor").show();
			$("#CapCliente").hide();
			$("#CapPersonal").hide();
		break;
		
		case "2":
			$("#CapProveedor").hide();
			$("#CapCliente").show();
			$("#CapPersonal").hide();
		break;
		
		case "3":
			$("#CapProveedor").hide();
			$("#CapCliente").hide();
			$("#CapPersonal").show();
		break;
		
		default:
			$("#CapProveedor").hide();
			$("#CapCliente").hide();
			$("#CapPersonal").hide();
		break;
		
	}

}






function FncImprmir(oId){
	
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Recibo) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){

			case "1":
			
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaImprimir2.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
						
			case "3":
	
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaGenerarPDF.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			default:
				
				alert("No ha escogido una opcion valida");
				
			break;
					
		}
		
	}
	
	
}


function FncVistaPreliminar(oId){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Recibo) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
				
			break;
			
			case "2":
	
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "3":
	
				FncPopUp('formularios/IngresoCaja/FrmIngresoCajaGenerarPDF.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			default:
				
				alert("No ha escogido una opcion valida");
				
			break;
			
		
		}
		
	}

}