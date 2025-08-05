
function FncVehiculoNuevo(){
	
	console.log("FncVehiculoNuevo");
	
	$('#CmpVehiculoId').val("");
	$('#CmpVehiculoNombre').val("");
	$('#CmpVehiculoCodigoIdentificador').val("");	

	$("select#CmpVehiculoUnidadMedidaConvertir").html("");
	
	$("#BtnVehiculoEditar").hide();
	$("#BtnVehiculoRegistrar").show();
		
}


function FncVehiculoEscoger(InsVehiculo){	
	
	console.log("FncVehiculoEscoger");
	
	$('#CmpVehiculoId').val(InsVehiculo.VehId);
	$('#CmpVehiculoNombre').val(InsVehiculo.VehNombre);
	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculo.VehCodigoIdentificador);
	
	$('#CmpVehiculoMarca').val(InsVehiculo.VmaNombre);
	$('#CmpVehiculoModelo').val(InsVehiculo.VmoNombre);
	$('#CmpVehiculoVersion').val(InsVehiculo.VveNombre);
	
	$('#CmpVehiculoUnidadMedida').val(InsVehiculo.UmeId);
	
	$("#CmpVehiculoNombre").select();
	
	$("#BtnVehiculoEditar").show();
	$("#BtnVehiculoRegistrar").hide();
	
	
	FncVehiculoFuncion(InsVehiculo);

}



function FncVehiculoFuncion(InsVehiculo){
	
}


function FncVehiculoBuscar(oCampo){
	
	console.log("FncVehiculoBuscar");
	
	var Dato = $('#CmpVehiculo'+oCampo).val()
	
	console.log("#CmpVehiculo"+oCampo);
	
	console.log("Dato: "+Dato);
	
	if(Dato!=""){
	
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Vehiculo/acc/AccVehiculoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsVehiculo){
										
				if(InsVehiculo.VehId!="" & InsVehiculo.VehId!=null){
					FncVehiculoEscoger(InsVehiculo);
				}else{
					$('#CmpVehiculo'+oCampo).focus();
					$('#CmpVehiculo'+oCampo).select();						
				}
				
			}
		});

	}

}

/*
* Funciones PopUp Listado
*/

function FncVehiculoListar(e){
	
	if(window.event)keyCode=window.event.keyCode;
	
	else if(e) keyCode=e.which;
	
	if (keyCode==13){		
		FncVehiculoListar2();		
	}	
	
}

function FncVehiculoListar2(){	
	
	var VehiculoTipo = $('#CmpVehiculoTipos').val();
	var Campo = $('#CmpVehiculoCampo').val();
	var Condicion = $('#CmpVehiculoCondicion').val();
	var Filtro = $('#CmpVehiculoFiltro').val();		
	
		
	$.ajax({
		type: 'POST',
		dataType : 'html',
		url: Ruta+ 'comunes/Vehiculo/FrmVehiculoListado.php',
		data: 'VehiculoTipo='+VehiculoTipo+'&Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro,
		success: function(html){
			$('#CapVehiculos').html("");
			$('#CapVehiculos').append(html);
		}
	});

}

/*
* Funciones Detalle
*/



