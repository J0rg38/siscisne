/*function FncArticuloNuevo(){	

	$('#CmpArticuloId').val("");
	$('#CmpArticuloNombre').val("");
	document.getElementById('CmpArticuloUnidadMedida').value = "";
	$('#CmpArticuloPrecio').val("");	
	$('#CmpArticuloCosto').val("");		
	$('#CmpArticuloTipo').val("");	
	
}*/

function FncArticuloDatoCambiar(oCampo,e,oTipo){

	switch(oCampo){
	
		case "Cantidad":
			FncArticuloCalcularImporte(oTipo)
		break;	
		
		case "Precio":
			FncArticuloCalcularImporte(oTipo)
		break;
		
		case "Costo":
			FncArticuloCalcularImporte(oTipo)
		break;
		
		case "Importe":
			FncArticuloCalcularMonto(oTipo)
		break;
	}
	
	if(window.event)keyCode=window.event.keyCode;
	
	else if(e) keyCode=e.which;
	
	if((oCampo=="FechaRealizacion" || oCampo=="Fecha") & keyCode!==8){

		var Fecha = document.getElementById('CmpArticulo'+oCampo).value;
		
		if(Fecha.length==2){
			document.getElementById('CmpArticulo'+oCampo).value = Fecha + "/";
		}else if (Fecha.length==5){
			document.getElementById('CmpArticulo'+oCampo).value = Fecha + "/";			
		}
		
	}
		
	if (keyCode==13){		
		
		var Dato = document.getElementById('CmpArticulo'+oCampo).value;
				
		if(Dato!="" & oCampo!="Cantidad" & oCampo != "Precio" & oCampo != "Costo" & oCampo!= "Importe" & oCampo != "Serie" & oCampo != "Cartucho" & oCampo != "Peso" & oCampo != "Fecha" & oCampo != "FechaRealizacion" & oCampo!="Nombre"){
			
			FncArticuloBuscar(oCampo);
//		}else if(oCampo=="CodigoBarra"){	
		}else {	
			
			//eval(ArticuloFuncion+"Guardar();");
			//alert("No ha ingresado un dato");
			//document.getElementById("CmpArticulo"+oCampo).select();	
		}
	}

}

//function FncArticuloEscoger(oArtId,oArtNombre,oArtUnidadMedida,oArtPrecio,oArtCosto,oArtTipo,oArtValidarStock,oArtStock){	
function FncArticuloEscoger(oArtId,oArtNombre,oArtUnidadMedida,oArtPrecio,oArtCosto,oArtTipo,oArtValidarStock,oArtNombreCorto,oArtPeso){	

	document.getElementById('CmpArticuloId').value = oArtId;
	document.getElementById('CmpArticuloNombre').value = oArtNombre;
	document.getElementById('CmpArticuloUnidadMedida').value = oArtUnidadMedida;
	
//	document.getElementById('CmpArticuloPrecio').value = oArtPrecio;
//	document.getElementById('CmpArticuloCosto').value = oArtCosto;
	
	document.getElementById('CmpArticuloCantidad').value = "";
//	document.getElementById('CmpArticuloImporte').value = "";
	
//	document.getElementById('CmpArticuloTipo').value = oArtTipo;

	try {
		document.getElementById('CmpArticuloImporte').value = "";
	} catch(e) {
		
	}
	
	try {
		document.getElementById('CmpArticuloTipo').value = oArtTipo;
	} catch(e) {
		
	}
		
	
	try {
		document.getElementById('CmpArticuloCosto').value = oArtCosto;
	} catch(e) {
		
	}
	
	try {
		document.getElementById('CmpArticuloPrecio').value = oArtPrecio;
	} catch(e) {
		
	}
	
	
	try {
		document.getElementById('CmpArticuloValidarStock').value = oArtValidarStock;
	} catch(e) {
		
	}
	
	try {
		document.getElementById('CmpArticuloCartucho').value = oArtNombreCorto;
	} catch(e) {
		
	}
	
	try {
		document.getElementById('CmpArticuloPeso').value = oArtPeso;
	} catch(e) {
		
	}
	
	try{
		FncStockVer();	
	}catch(e){
		
	}

/*	
	try {
		document.getElementById('CmpArticuloStock').value = oArtStock;
	} catch(e) {
		
	}
*/

	try{
		document.getElementById('PopArticulos').style.display='none';
	}catch(e){
		
	}
	
	document.getElementById(ArticuloEnfoque).focus();	
}

function FncArticuloBuscar(oCampo){
	
	var Dato = document.getElementById("CmpArticulo"+oCampo).value;
	
	try{
		var Lec = document.getElementById("CmpArticuloLector");
		
		if(Lec.checked){
			var Lector = 1;
		}else{
			var Lector = 0;
		}
		
	}catch(e){
		var Lector = 0;
	}

AjaxArticuloBuscar('comunes/Articulo/acc/AccArticuloBuscar.php','CapArticuloBuscar','Campo='+oCampo+'&Dato='+Dato,Lector,ArticuloFuncion,oCampo);
	
	//AjaxArticuloBuscar('comunes/Articulo/acc/AccArticuloBuscar.php','CapArticuloBuscar','Campo='+oCampo+'&Dato='+Dato+'&ValidarStock='+ArticuloValidarStock,Lector,ArticuloFuncion);		
}


/*
* Funciones PopUp Listado
*/

function FncPopArticulosCerrar(){
	document.getElementById('PopArticulos').style.display='none';
}

function FncPopArticulosAbrir(oCapa){	
	fireMyPopup(oCapa);	
	AjaxArticulo('comunes/Articulo/FrmArticuloBuscar.php',oCapa,'Tipo='+ArticuloTipo);	
}

function FncArticuloListar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	
	else if(e) keyCode=e.which;
	
	if (keyCode==13){		
		FncArticuloListar2();		
	}	
	
}

function FncArticuloListar2(){
	var AcaId = document.getElementById('CmpArticuloCategorias').value;
//		var Sucursal = document.getElementById('CmpSucursal').value;	
//		var Area = document.getElementById('CmpArea').value;	
	
		var Campo = document.getElementById('CmpArticuloCampo').value;
		var Condicion = document.getElementById('CmpArticuloCondicion').value;	
		var Filtro = document.getElementById('CmpArticuloFiltro').value;
		
		var Tipo = document.getElementById('CmpTipo').value;		
		
		//AjaxArticulo('comunes/Articulo/FrmArticuloListado.php','CapArticulos','AcaId='+AcaId+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro+'&Sucursal='+Sucursal+'&Area='+Area);	
		AjaxArticulo('comunes/Articulo/FrmArticuloListado.php','CapArticulos','AcaId='+AcaId+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro+'&Tipo='+Tipo);		
}

/*
* Funciones Detalle
*/

function FncArticuloCalcularMonto(oTipo){

	var Tipo;
	var Cantidad = document.getElementById('CmpArticuloCantidad').value;
	var Importe = $('#CmpArticuloImporte').val();	

	if(Cantidad!=""){

		if(Importe!=""){
			Tipo = Importe/Cantidad;
			
			var Tipo=parseFloat(Tipo);
			Tipo=Math.round(Tipo*100000)/100000 ;
			document.getElementById('CmpArticulo'+oTipo).value = Tipo;
	

		}else{
			//document.getElementById('CmpArticuloImporte').value = 0.00;
		}
	}else{
		//document.getElementById('CmpArticuloCantidad').value = 0.00;
	}
}

function FncArticuloCalcularImporte(oTipo){

	var Tipo = document.getElementById('CmpArticulo'+oTipo).value;
	var Cantidad = document.getElementById('CmpArticuloCantidad').value;
	var Importe;
		
	if(Cantidad!=""){
		
		if(Tipo!=""){
			Importe = Tipo*Cantidad;
		
			var Importe=parseFloat(Importe);
			Importe=Math.round(Importe*100000)/100000 ;
			
			document.getElementById('CmpArticuloImporte').value = Importe;
			
		}else{
			//document.getElementById('CmpArticulo'+oTipo).value = 0.00;
		}
		
	}else{
		//document.getElementById('CmpArticuloCantidad').value = 0.00;
	}
}
