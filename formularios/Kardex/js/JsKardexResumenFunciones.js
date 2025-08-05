// JavaScript Document


$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

	$("#BtnVer").click(function(){

		FncKardexResumenVer();
		
	});
	
	$("#BtnImprimir").click(function(){
	
		FncKardexResumenImprimir();
		
	});
	
	$("#BtnExcel").click(function(){

		FncKardexResumenGenerarExcel();
		
	});
	
	$("#CmpSucursal").change(function(){

		FncAlmacenesCargar();
		
	});


});	

			
			

// JavaScript Document
function FncKardexResumenValidar(){
	
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

function FncKardexResumenVer(){
	
	if(FncKardexResumenValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Almacen = $("#CmpAlmacen").val();
		
		$('#CapKardexResumen').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Kardex/IfrKardexResumen.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Almacen="+Almacen,
			success: function(html){
				$('#CapKardexResumen').html(html);	
			}
		});

	}

}


function FncKardexResumenImprimir(){
	
	if(FncKardexResumenValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Almacen = $("#CmpAlmacen").val();
		

		FncPopUp("formularios/Kardex/IfrKardexResumen.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Almacen="+Almacen+"&P=1");
	
	}

}

function FncKardexResumenGenerarExcel(){
	
	if(FncKardexResumenValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Almacen = $("#CmpAlmacen").val();
		
		FncPopUp("formularios/Kardex/IfrKardexResumen.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Almacen="+Almacen+"&P=2");
	
		//FncPopUp("formularios/Reporte/XLSKardexResumen.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Almacen="+Almacen+"&P=2");
		
	}
	
}

function FncKardexResumenNuevo(){

}




//function FncKardexResumenImprimir(oIndice){
//	var Accion = document.getElementById('FrmKardexResumen'+oIndice).action;
//
//	document.getElementById('FrmKardexResumen'+oIndice).target = '_blank';
//	document.getElementById('FrmKardexResumen'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmKardexResumen'+oIndice).submit();
//
//	document.getElementById('FrmKardexResumen'+oIndice).target = 'IfrKardexResumen'+oIndice;
//	document.getElementById('FrmKardexResumen'+oIndice).action = Accion;
//}
//
//function FncKardexResumenGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmKardexResumen'+oIndice).action;
//
//	document.getElementById('FrmKardexResumen'+oIndice).target = '_blank';
//	document.getElementById('FrmKardexResumen'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmKardexResumen'+oIndice).submit();
//
//	document.getElementById('FrmKardexResumen'+oIndice).target = 'IfrKardexResumen'+oIndice;
//	document.getElementById('FrmKardexResumen'+oIndice).action = Accion;
//}
//
//
//
//function FncKardexResumenNuevo(){
//
//	
//				
//}

