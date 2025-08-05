// JavaScript Document


$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

	$("#BtnVer").click(function(){

		FncKardexGeneralVer();
		
	});
	
	$("#BtnImprimir").click(function(){
	
		FncKardexGeneralImprimir();
		
	});
	
	$("#BtnExcel").click(function(){

		FncKardexGeneralGenerarExcel();
		
	});
	
	$("#CmpSucursal").change(function(){

		FncAlmacenesCargar();
		
	});


});	

			
			

// JavaScript Document
function FncKardexGeneralValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var Almacen = $("#CmpAlmacen").val();
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncKardexGeneralVer(){
	
	if(FncKardexGeneralValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Almacen = $("#CmpAlmacen").val();
		
		var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
		var ProductoNombre = $("#CmpProductoNombre").val();
		var ProductoUnidadMedidaKardex = $("#CmpProductoUnidadMedidaKardex").val();
		var ProductoId = $("#CmpProductoId").val();
		
		$('#CapKardexGeneral').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Kardex/IfrKardexGeneral.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Almacen="+Almacen+"&ProductoCodigoOriginal="+ProductoCodigoOriginal+"&ProductoNombre="+ProductoNombre+"&ProductoUnidadMedidaKardex="+ProductoUnidadMedidaKardex+"&ProductoId="+ProductoId,
			success: function(html){
				$('#CapKardexGeneral').html(html);	
			}
		});

	}

}


function FncKardexGeneralImprimir(){
	
	if(FncKardexGeneralValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Almacen = $("#CmpAlmacen").val();
		

		var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
		var ProductoNombre = $("#CmpProductoNombre").val();
		var ProductoUnidadMedidaKardex = $("#CmpProductoUnidadMedidaKardex").val();
		var ProductoId = $("#CmpProductoId").val();
		
		FncPopUp("formularios/Kardex/IfrKardexGeneral.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Almacen="+Almacen+"&ProductoCodigoOriginal="+ProductoCodigoOriginal+"&ProductoNombre="+ProductoNombre+"&ProductoUnidadMedidaKardex="+ProductoUnidadMedidaKardex+"&ProductoId="+ProductoId+"&P=1");
	
	}

}

function FncKardexGeneralGenerarExcel(){
	
	if(FncKardexGeneralValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Almacen = $("#CmpAlmacen").val();
		
			var ProductoCodigoOriginal = $("#CmpProductoCodigoOriginal").val();
		var ProductoNombre = $("#CmpProductoNombre").val();
		var ProductoUnidadMedidaKardex = $("#CmpProductoUnidadMedidaKardex").val();
		var ProductoId = $("#CmpProductoId").val();
		
		
		FncPopUp("formularios/Kardex/IfrKardexGeneral.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Almacen="+Almacen+"&ProductoCodigoOriginal="+ProductoCodigoOriginal+"&ProductoNombre="+ProductoNombre+"&ProductoUnidadMedidaKardex="+ProductoUnidadMedidaKardex+"&ProductoId="+ProductoId+"&P=2");
	
		//FncPopUp("formularios/Reporte/XLSKardexGeneral.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Almacen="+Almacen+"&P=2");
		
	}
	
}

function FncKardexGeneralNuevo(){

}



//
//////////////////////////
//
//function FncKardexGeneralImprimir(oIndice){
//	var Accion = document.getElementById('FrmKardexGeneral'+oIndice).action;
//
//	document.getElementById('FrmKardexGeneral'+oIndice).target = '_blank';
//	document.getElementById('FrmKardexGeneral'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmKardexGeneral'+oIndice).submit();
//
//	document.getElementById('FrmKardexGeneral'+oIndice).target = 'IfrKardexGeneral'+oIndice;
//	document.getElementById('FrmKardexGeneral'+oIndice).action = Accion;
//}
//
//function FncKardexGeneralGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmKardexGeneral'+oIndice).action;
//
//	document.getElementById('FrmKardexGeneral'+oIndice).target = '_blank';
//	document.getElementById('FrmKardexGeneral'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmKardexGeneral'+oIndice).submit();
//
//	document.getElementById('FrmKardexGeneral'+oIndice).target = 'IfrKardexGeneral'+oIndice;
//	document.getElementById('FrmKardexGeneral'+oIndice).action = Accion;
//}
//
//
//
//function FncKardexGeneralNuevo(){
//
//	
//				
//}





function FncKardexNuevo(){

	$('#CmpProductoId').val("");		
	$('#CmpProductoCodigoAlternativo').val("");		
	$('#CmpProductoCodigoOriginal').val("");		
	$('#CmpProductoNombre').val("");	
	
	$('#CmpProductoUnidadMedidaKardex').html("");	
	
	
	$('#CmpProductoCodigoAlternativo').select();
				
}


function FncProductoFuncion(){
	
	var ProductoId = $("#CmpProductoId").val();

		$.getJSON("comunes/UnidadMedida/JnProductoKardexUnidadMedida.php?ProductoId="+ProductoId,{}, function(j){
		var options = '';

		options += '<option value="">Escoja una opcion</option>';
		for (var i = 0; i < j.length; i++) {
			if("3" == j[i].UmeUso){
				options += '<option value="' + j[i].UmeUso + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
			}else{
				options += '<option value="' + j[i].UmeUso + '" >' + j[i].UmeNombre+ '</option>';				
			}

		}
		$("select#CmpProductoUnidadMedidaKardex").html(options);
	})
}
