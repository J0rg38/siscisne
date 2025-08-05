


function FncVehiculoEscoger(oVehId,oVmaNombre,oVmoNombre,oVveNombre,oVtiNombre,oVehColor){	

	$('#CmpVehiculoId').val(oVehId);
	$('#CmpVehiculoMarca').val(oVmaNombre);
	$('#CmpVehiculoModelo').val(oVmoNombre);
	$('#CmpVehiculoVersion').val(oVveNombre);
	$('#CmpVehiculoTipo').val(oVtiNombre);
	$('#CmpVehiculoColor').val(oVehColor);

	try{
		tb_remove();
	}catch(e){
		
	}

}

function FncVehiculoBuscar(oCampo){
	
	var Dato = $('#CmpVehiculo'+oCampo).val()
	
	if(Dato!=""){
	
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: Ruta+'comunes/Vehiculo/acc/AccVehiculoBuscar.php',
			data: 'Campo='+oCampo+'&Dato='+Dato,
			success: function(InsVehiculo){
										
				if(InsVehiculo.VehId!="" & InsVehiculo.VehId!=null){
					FncVehiculoEscoger(InsVehiculo.VehId,InsVehiculo.VmaNombre,InsVehiculo.VmoNombre,InsVehiculo.VveNombre,InsVehiculo.VtiNombre,InsVehiculo.VehColor);
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

function FncVehiculoCalcularMonto(oTipo){

	var Tipo;
	var Cantidad = $('#CmpVehiculoCantidad').val();
	var Importe = $('#CmpVehiculoImporte').val();	

	if(Cantidad!=""){
		if(Importe!=""){
			Tipo = Importe/Cantidad;
			//var Tipo=parseFloat(Tipo);
			//Tipo=Math.round(Tipo*100000)/100000 ;
			document.getElementById('CmpVehiculo'+oTipo).value = Tipo;
		}else{
			//document.getElementById('CmpVehiculoImporte').value = 0.00;
		}
	}else{
		//document.getElementById('CmpVehiculoCantidad').value = 0.00;
	}
}

function FncVehiculoCalcularImporte(oTipo){

	var Tipo = document.getElementById('CmpVehiculo'+oTipo).value;
	var Cantidad = $('#CmpVehiculoCantidad').val();
	var Importe;
		
	if(Cantidad!=""){
		if(Tipo!=""){
			Importe = Tipo*Cantidad;
			//var Importe=parseFloat(Importe);
			//Importe=Math.round(Importe*100000)/100000 ;
			document.getElementById('CmpVehiculoImporte').value = Importe;
		}else{
			//document.getElementById('CmpVehiculo'+oTipo).value = 0.00;
		}
	}else{
		//document.getElementById('CmpVehiculoCantidad').value = 0.00;
	}
}


