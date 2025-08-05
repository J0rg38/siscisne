// JavaScript Document

function FncVehiculoMantenimientoResumenListado(){
	
	var VehiculoIngresoId =  $('#CmpVehiculoIngresoId').val();

	if(VehiculoIngresoId!=""){
		
		tb_show(this.title,'comunes/Vehiculo/FrmVehiculoMantenimientoListado.php?VehiculoIngresoId='+VehiculoIngresoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&width=890&modal=false',this.rel);	
	}else{
		alert("No se encontro vehiculo");
	}
	
	

}

