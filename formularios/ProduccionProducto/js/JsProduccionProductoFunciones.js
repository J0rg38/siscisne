// JavaScript Document

function FncGuardar(){
	
	//HACK
	$("#CmpEstado").removeAttr('disabled');		
	
}

/************************************************************/
/************************************************************/

var FormularioCampos = ["CmpPersonal",
"CmpFecha",
"CmpAlmacen",
"CmpObservacion",
//"CmpEstado",

"CmpProductoCodigoOriginalEntrada",
"CmpProductoCodigoAlternativoEntrada",
"CmpProductoNombreEntrada",
"CmpProductoUnidadMedidaConvertirEntrada",

"CmpProductoCostoEntrada",
"CmpProductoCantidadEntrada",
"CmpProductoImporteEntrada",

"CmpProductoCodigoOriginalSalida",
"CmpProductoCodigoAlternativoSalida",
"CmpProductoNombreSalida",
"CmpProductoUnidadMedidaConvertirSalida",

"CmpProductoPrecioSalida",
"CmpProductoCantidadSalida",
"CmpProductoImporteSalida"
];

//"CmpProduccionProductoDetalleCodigo",

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncAlmacenMovimientoNavegar(this.id);
		 }
	}); 
	
	/*$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 
	
	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	});*/
	
/*
Agregando Eventos
*/
	$("select#CmpAlmacen").change(function(){
		FncProduccionProductoDetalleSalidaListar();
	});

});
	
function FncAlmacenMovimientoNavegar(oCampo){
	
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
		
		if("CmpProductoImporteEntrada"==oCampo){
			$('#CmpProductoImporteEntrada').blur();
			FncProduccionProductoDetalleEntradaGuardar();
		}
		
		
		if("CmpProductoImporteSalida"==oCampo){
			$('#CmpProductoImporteSalida').blur();
			FncProduccionProductoDetalleSalidaGuardar();
		}
		
}



/************************************************************/
//EXTRAS

/************************************************************/
//IMPRESION

function FncImprmir(oId,oPpronario){
	FncPopUp('formularios/ProduccionProducto/FrmProduccionProductoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVistaPreliminar(oId,oPpronario){
	FncPopUp('formularios/ProduccionProducto/FrmProduccionProductoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}




















/************************************************************/
/************************************************************/



/*
* ENTRADA PRODUCTO
*/

$(function(){
	
	$("#BtnProductoEditarEntrada").hide();
	$("#BtnProductoRegistrarEntrada").show();
	
	function FncProductoFormato(row) {			
		
		return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td><td align='center'>"+row[9]+"</td><td align='center'>"+row[11]+"</td>";
		
	}
	

	$("#CmpProductoNombreEntrada").unautocomplete();
	$("#CmpProductoNombreEntrada").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
		width: 900,
		max: 100,
		formatItem: FncProductoFormato,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoNombreEntrada").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoIdEntrada").val(data[0]);				
			FncProductoBuscarEntrada("Id");	
		}		
	});

	$("#CmpProductoCodigoOriginalEntrada").unautocomplete();
	$("#CmpProductoCodigoOriginalEntrada").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&t=', {
		width: 900,
		max: 100,
		formatItem: FncProductoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoCodigoOriginalEntrada").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoIdEntrada").val(data[0]);				
			FncProductoBuscarEntrada("Id");	
		}		
	});
	
	$("#CmpProductoCodigoAlternativoEntrada").unautocomplete();
	$("#CmpProductoCodigoAlternativoEntrada").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoAlternativo&t=', {

		width: 900,
		max: 100,
		formatItem: FncProductoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoCodigoAlternativoEntrada").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoIdEntrada").val(data[0]);				
			FncProductoBuscarEntrada("Id");	
		}		
	});
	
	
	
});





function FncProductoEscogerEntrada(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oAmdId,oProValorVenta){	

	$('#CmpProductoIdEntrada').val(oProId);
	$('#CmpProductoNombreEntrada').val(oProNombre);
	
	$('#CmpProductoCostoEntrada').val(oProCosto);
	$('#CmpProductoPrecioEntrada').val(oProPrecio);
	$('#CmpProductoCantidadEntrada').val("1");
	$('#CmpProductoImporteEntrada').val("1");
	
	$('#CmpProductoUnidadMedidaEntrada').val(oUmeId);
	$('#CmpProductoUnidadMedidaIngresoEntrada').val(oUnidadMedidaIngreso);

	if(oUmeId==""){
		alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
	}
	
	$('#CmpProductoCodigoOriginalEntrada').val(oProCodigoOriginal);
	$('#CmpProductoCodigoAlternativoEntrada').val(oProCodigoAlternativo);
	
	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo="+UnidadMedidaTipo+"&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){

		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if(oUnidadMedidaIngreso == j[i].UmeId){
				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
			}

		}
		$("select#CmpProductoUnidadMedidaConvertirEntrada").html(options);
	})
	
	$('#CmpProductoUnidadMedidaConvertirEntrada').unbind('change');
	$("select#CmpProductoUnidadMedidaConvertirEntrada").change(function(){
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){
			$("#CmpProductoUnidadMedidaEquivalenteEntrada").val(j[0].UmcEquivalente);
			$('#CmpProductoCostoEntrada').val($('#CmpProductoCostoEntrada').val() * j[0].UmcEquivalente);
			$('#CmpProductoImporteEntrada').val($('#CmpProductoCostoEntrada').val() * $('#CmpProductoCantidadEntrada').val());			
		})
	});

	$("#CmpProductoCantidadEntrada").select();

	$("#BtnProductoEditarEntrada").show();
	$("#BtnProductoRegistrarEntrada").hide();
	
	FncProductoFuncionEntrada();

}


function FncProductoFuncionEntrada(){
	
}



function FncProductoBuscarEntrada(oCampo){
	
	var Dato = $('#CmpProducto'+oCampo+'Entrada').val()
	
	if(Dato!=""){

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){

					FncProductoEscogerEntrada(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProPrecio,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);
				}else{
					$('#CmpProducto'+oCampo+'Entrada').focus();
					$('#CmpProducto'+oCampo+'Entrada').select();						
				}
				
			}
		});
		
	}

}


/*
* Funciones PopUp Formulario
*/

function FncProductoCargarFormularioEntrada(oForm){

	var ProductoId = $('#CmpProductoIdEntrada').val();
	var ProductoNombre = $('#CmpProductoNombreEntrada').val();
	var ProductoUnidadMedida = $('#CmpProductoUnidadMedidaEntrada').val();
	var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginalEntrada').val();	
	var ProductoCodigoAlternativo = $('#CmpProductoCodigoAlternativoEntrada').val();	
	
tb_show(this.title,'principal2.php?Mod=Producto&Form='+oForm+'&Dia=1&ProductoId='+ProductoId+'&Id='+ProductoId+'&ProductoCodigoOriginal='+ProductoCodigoOriginal+'&ProductoNombre='+ProductoNombre+'&ProductoCodigoAlternativo='+ProductoCodigoAlternativo+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	


}





/*
* SALIDA PRODUCTO
*/

$(function(){
	
	$("#BtnProductoEditarSalida").hide();
	$("#BtnProductoRegistrarSalida").show();
	
	function FncProductoFormato(row) {			
		
		return "<td>"+row[8]+"</td><td>"+row[7]+"</td><td align='left'>"+row[1]+"</td><td align='center'>"+row[2]+"</td><td align='center'>"+row[3]+"</td><td align='center'>"+row[4]+"</td><td align='center'>"+row[9]+"</td><td align='center'>"+row[11]+"</td>";
		
	}
	
	$("#CmpProductoNombreSalida").unautocomplete();
	$("#CmpProductoNombreSalida").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProNombre', {
		width: 900,
		max: 100,
		formatItem: FncProductoFormato,
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoNombreSalida").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoIdSalida").val(data[0]);				
			FncProductoBuscarSalida("Id");	
		}		
	});

	$("#CmpProductoCodigoOriginalSalida").unautocomplete();
	$("#CmpProductoCodigoOriginalSalida").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoOriginal&t=', {
		width: 900,
		max: 100,
		formatItem: FncProductoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoCodigoOriginalSalida").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoIdSalida").val(data[0]);				
			FncProductoBuscarSalida("Id");	
		}		
	});
	
	$("#CmpProductoCodigoAlternativoSalida").unautocomplete();
	$("#CmpProductoCodigoAlternativoSalida").autocomplete('comunes/Producto/XmlProducto.php?Cbu=ProCodigoAlternativo&t=', {

		width: 900,
		max: 100,
		formatItem: FncProductoFormato,				
		minChars: 2,
		delay: 1000,
		cacheLength: 50,
		scroll: true,
		scrollHeight: 200
	});	
	
	$("#CmpProductoCodigoAlternativoSalida").result(function(event, data, formatted) {
		if (data){
			$("#CmpProductoIdSalida").val(data[0]);				
			FncProductoBuscarSalida("Id");	
		}		
	});
	
	
	
});





function FncProductoEscogerSalida(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oAmdId,oProValorVenta){	

	$('#CmpProductoIdSalida').val(oProId);
	$('#CmpProductoNombreSalida').val(oProNombre);
	$('#CmpProductoCostoSalida').val(oProCosto);
	
	$('#CmpProductoCantidadSalida').val("1");
	$('#CmpProductoImporteSalida').val(oProPrecio);
	$('#CmpProductoPrecioSalida').val(oProPrecio);

	$('#CmpProductoUnidadMedidaSalida').val(oUmeId);
	$('#CmpProductoUnidadMedidaIngresoSalida').val(oUnidadMedidaIngreso);

	if(oUmeId==""){
		alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
	}
	
	$('#CmpProductoCodigoOriginalSalida').val(oProCodigoOriginal);
	$('#CmpProductoCodigoAlternativoSalida').val(oProCodigoAlternativo);
	
	$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo="+UnidadMedidaTipo+"&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){

		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if(oUnidadMedidaIngreso == j[i].UmeId){
				options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
			}

		}
		$("select#CmpProductoUnidadMedidaConvertirSalida").html(options);
	})
	
	$('#CmpProductoUnidadMedidaConvertirSalida').unbind('change');
	$("select#CmpProductoUnidadMedidaConvertirSalida").change(function(){
		$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
		function(j){
			$("#CmpProductoUnidadMedidaEquivalenteSalida").val(j[0].UmcEquivalente);
			$('#CmpProductoCostoSalida').val($('#CmpProductoCostoSalida').val() * j[0].UmcEquivalente);
			$('#CmpProductoImporteSalida').val($('#CmpProductoCostoSalida').val() * $('#CmpProductoCantidadSalida').val());			
		})
	});

	$("#CmpProductoCantidadSalida").select();

	$("#BtnProductoEditarSalida").show();
	$("#BtnProductoRegistrarSalida").hide();
	
	FncProductoFuncionSalida();

}


function FncProductoFuncionSalida(){
	
}



function FncProductoBuscarSalida(oCampo){
	
	var Dato = $('#CmpProducto'+oCampo+'Salida').val()
	
	if(Dato!=""){

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Producto/acc/AccProductoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsProducto){
										
				if(InsProducto.ProId!="" & InsProducto.ProId!=null){

					FncProductoEscogerSalida(InsProducto.ProId,InsProducto.ProNombre,InsProducto.ProPrecio,InsProducto.ProCosto,InsProducto.ProFoto,InsProducto.ProEspecificacion,InsProducto.RtiId,InsProducto.UmeId,InsProducto.ProCodigoOriginal,InsProducto.ProCodigoAlternativo,InsProducto.UmeIdIngreso,InsProducto.ProCostoIngreso,InsProducto.ProCostoIngresoNeto,InsProducto.AmdId);
				}else{
					$('#CmpProducto'+oCampo+'Salida').focus();
					$('#CmpProducto'+oCampo+'Salida').select();						
				}
				
			}
		});
		
	}

}


/*
* Funciones PopUp Formulario
*/

function FncProductoCargarFormularioSalida(oForm){

	var ProductoId = $('#CmpProductoIdSalida').val();
	var ProductoNombre = $('#CmpProductoNombreSalida').val();
	var ProductoUnidadMedida = $('#CmpProductoUnidadMedidaSalida').val();
	var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginalSalida').val();	
	var ProductoCodigoAlternativo = $('#CmpProductoCodigoAlternativoSalida').val();	
	
tb_show(this.title,'principal2.php?Mod=Producto&Form='+oForm+'&Dia=1&ProductoId='+ProductoId+'&Id='+ProductoId+'&ProductoCodigoOriginal='+ProductoCodigoOriginal+'&ProductoNombre='+ProductoNombre+'&ProductoCodigoAlternativo='+ProductoCodigoAlternativo+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	


}



$().ready(function() {

	$("#CmpProductoPrecioSalida").keyup(function (event) {  
		FncProductoCalcularImporteSalida();
	});

	$("#CmpProductoImporteSalida").keyup(function (event) {  
		FncProductoCalcularPrecioSalida();
	});
	
	$("#CmpProductoCantidadSalida").keyup(function (event) {  
		FncProductoCalcularImporteSalida();
	});



	
	$("#CmpProductoCostoEntrada").keyup(function (event) {  
		FncProductoCalcularImporteEntrada();
	});

	$("#CmpProductoImporteEntrada").keyup(function (event) {  
		FncProductoCalcularCostoEntrada();
	});
	
	$("#CmpProductoCantidadEntrada").keyup(function (event) {  
		FncProductoCalcularImporteEntrada();
	});
	
});



function FncProductoCalcularCostoEntrada(){

	var Costo;
	var Cantidad = $('#CmpProductoCantidadEntrada').val();
	var Importe = $('#CmpProductoImporteEntrada').val();	

//alert(Cantidad);

	if(Cantidad!=""){
		if(Importe!=""){
			Costo = Importe/Cantidad;
			//var Tipo=parseFloat(Tipo);
			//Tipo=Math.round(Tipo*100000)/100000 ;
//			document.getElementById('CmpProducto'+oTipo).value = Tipo;
			$('#CmpProductoCostoEntrada').val(Costo);
		}else{
			//document.getElementById('CmpProductoImporte').value = 0.00;
		}
	}else{
		//document.getElementById('CmpProductoCantidad').value = 0.00;
	}
}

function FncProductoCalcularImporteEntrada(){
	
//	alert(oTipo);

	var Costo = $('#CmpProductoCostoEntrada').val();
	var Cantidad = $('#CmpProductoCantidadEntrada').val();
	var Importe;
		
//	alert(Tipo);
	if(Cantidad!=""){
		if(Costo!=""){
			Importe = Costo * Cantidad;
			//var Importe=parseFloat(Importe);
			//Importe=Math.round(Importe*100000)/100000 ;
			//document.getElementById('CmpProductoImporte').value = Importe;
			$('#CmpProductoImporteEntrada').val(Importe);
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpProductoCantidad').value = 0.00;
	}
}





function FncProductoCalcularCostoSalida(){

	var Precio;
	var Cantidad = $('#CmpProductoCantidadSalida').val();
	var Importe = $('#CmpProductoImporteSalida').val();	

//alert(Cantidad);

	if(Cantidad!=""){
		if(Importe!=""){
			Precio = Importe/Cantidad;
			//var Tipo=parseFloat(Tipo);
			//Tipo=Math.round(Tipo*100000)/100000 ;
//			document.getElementById('CmpProducto'+oTipo).value = Tipo;
			$('#CmpProductoPrecioSalida').val(Precio);
		}else{
			//document.getElementById('CmpProductoImporte').value = 0.00;
		}
	}else{
		//document.getElementById('CmpProductoCantidad').value = 0.00;
	}
}

function FncProductoCalcularImporteSalida(oTipo){
	
//	alert(oTipo);

	var Precio = $('#CmpProductoPrecioSalida').val();
	var Cantidad = $('#CmpProductoCantidadSalida').val();
	var Importe;
		
//	alert(Tipo);
	if(Cantidad!=""){
		if(Precio!=""){
			Importe = Precio * Cantidad;
			//var Importe=parseFloat(Importe);
			//Importe=Math.round(Importe*100000)/100000 ;
			//document.getElementById('CmpProductoImporte').value = Importe;
			$('#CmpProductoImporteSalida').val(Importe);
		}else{
			//document.getElementById('CmpProducto'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpProductoCantidad').value = 0.00;
	}
}




function FncProductoReemplazoCargar(oProductoCodigoOriginal){

	tb_show('','formularios/VentaConcretada/DiaProductoReemplazoBuscar.php?ProductoCodigoOriginal='+oProductoCodigoOriginal+
'&placeValuesBeforeTB_=savedValues','');	
  
}


function FncProductoConsultarCargar(oProductoId){

	tb_show('','formularios/Producto/DiaProductoConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}

function FncAlmacenStockConsultarCargar(oProductoId){

	tb_show('','formularios/AlmacenStock/DiaAlmacenStockConsultar.php?ProductoId='+oProductoId+
'&placeValuesBeforeTB_=savedValues','');	
  
}