
$(function(){

	$("#BtnServicioRepuestoEditar").hide();
	$("#BtnServicioRepuestoRegistrar").show();
	
});

function FncServicioRepuestoNuevo(){

	$('#CmpServicioRepuestoId').val("");
	$('#CmpServicioRepuestoNombre').val("");
	
	$("#BtnServicioRepuestoEditar").hide();
	$("#BtnServicioRepuestoRegistrar").show();
		
}

function FncServicioRepuestoEscoger(InsServicioRepuesto){	

	$('#CmpServicioRepuestoId').val(InsServicioRepuesto.SreId);
	$('#CmpServicioRepuestoNombre').val(InsServicioRepuesto.SreNombre);
	
	$("#CmpServicioRepuestoNombre").select();
	
	
	$("#BtnServicioRepuestoEditar").show();
	$("#BtnServicioRepuestoRegistrar").hide();
	
	FncServicioRepuestoFuncion();

}


function FncServicioRepuestoFuncion(){
	
}






function FncServicioRepuestoBuscar(oCampo){
	
	var Dato = $('#CmpServicioRepuesto'+oCampo).val()
	
	if(Dato!=""){
	
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/ServicioRepuesto/acc/AccServicioRepuestoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsServicioRepuesto){
										
				if(InsServicioRepuesto.SreId!="" & InsServicioRepuesto.SreId!=null){

					FncServicioRepuestoEscoger(InsServicioRepuesto);
				}else{
					
					dhtmlx.alert({
						title:"Aviso",
						type:"alert-error",
						text:"No se encontraron datos",
						callback: function(result){
						
						}
					});
				
				
					$('#CmpServicioRepuesto'+oCampo).focus();
					$('#CmpServicioRepuesto'+oCampo).select();						
				}
				
			}
		});
		

	

	}

}






/*
* Funciones PopUp Formulario
*/

function FncServicioRepuestoCargarFormulario(oForm){

	var ServicioRepuestoId = $('#CmpServicioRepuestoId').val();
	var ServicioRepuestoNombre = $('#CmpServicioRepuestoNombre').val();
	var TipoGastoId = $('#CmpTipoGasto').val();

	var Ancho = $( window ).width();
	var Alto = $( window ).height();

	Ancho = Ancho - (Ancho*(0.2));
	Alto = Alto - (Alto*(0.1));
	
	tb_show(this.title,'principal2.php?Mod=ServicioRepuesto&Form='+oForm+'&Dia=1&ServicioRepuestoId='+ServicioRepuestoId+'&Id='+ServicioRepuestoId+'&ServicioRepuestoNombre='+ServicioRepuestoNombre+'&TipoGastoId='+TipoGastoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height='+Alto+'&width='+Ancho+'&modal=true',this.rel);	

}

function FncTBCerrarFunncion(oModulo){



	if (typeof oModulo == 'string' || oModulo instanceof String){
		if(oModulo!="" && oModulo!=null && oModulo!="undefined"){
			
			//eval("Fnc"+oModulo+"Buscar('Id');");		
			try{
				eval("Fnc"+oModulo+"Buscar('Id');");		
			}catch(e){
				
			}
		}
	}

}

/*
* Funciones PopUp Listado
*/

function FncServicioRepuestoListar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	
	else if(e) keyCode=e.which;
	
	if (keyCode==13){		
		FncServicioRepuestoListar2();		
	}	
	
}

function FncServicioRepuestoListar2(){	

	var ServicioRepuestoTipo = $('#CmpServicioRepuestoTipos').val();
	var Campo = $('#CmpServicioRepuestoCampo').val();
	var Condicion = $('#CmpServicioRepuestoCondicion').val();
	var Filtro = $('#CmpServicioRepuestoFiltro').val();		

	$.ajax({
		type: 'POST',
		dataType : 'html',
		url: Ruta+ 'comunes/ServicioRepuesto/FrmServicioRepuestoListado.php',
		data: 'ServicioRepuestoTipo='+ServicioRepuestoTipo+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
		success: function(html){
			$('#CapServicioRepuestos').html("");
			$('#CapServicioRepuestos').append(html);
		}
	});

}

/*
* Funciones Detalle
*/

function FncServicioRepuestoCalcularMonto(oTipo){

	var Tipo;
	var Cantidad = $('#CmpServicioRepuestoCantidad').val();
	var Importe = $('#CmpServicioRepuestoImporte').val();	

//alert(Cantidad);

	if(Cantidad!=""){
		if(Importe!=""){
			Tipo = Importe/Cantidad;
			//var Tipo=parseFloat(Tipo);
			//Tipo=Math.round(Tipo*100000)/100000 ;
//			document.getElementById('CmpServicioRepuesto'+oTipo).value = Tipo;
			$('#CmpServicioRepuesto'+oTipo).val(Tipo);
		}else{
			//document.getElementById('CmpServicioRepuestoImporte').value = 0.00;
		}
	}else{
		//document.getElementById('CmpServicioRepuestoCantidad').value = 0.00;
	}
}

function FncServicioRepuestoCalcularImporte(oTipo){
	
//	alert(oTipo);

	var Tipo = $('#CmpServicioRepuesto'+oTipo).val();
//	alert('#CmpServicioRepuesto'+oTipo);
	var Cantidad = $('#CmpServicioRepuestoCantidad').val();
	var Importe;
		
//	alert(Tipo);
	if(Cantidad!=""){
		if(Tipo!=""){
			Importe = Tipo * Cantidad;
			//var Importe=parseFloat(Importe);
			//Importe=Math.round(Importe*100000)/100000 ;
			//document.getElementById('CmpServicioRepuestoImporte').value = Importe;
			$('#CmpServicioRepuestoImporte').val(Importe);
		}else{
			//document.getElementById('CmpServicioRepuesto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpServicioRepuestoCantidad').value = 0.00;
	}
}

function FncServicioRepuestoListadorEscoger(oServicioRepuestoId){

	$('#CmpServicioRepuestoId').val(oServicioRepuestoId);
	FncServicioRepuestoBuscar("Id");
	tb_remove();

}








