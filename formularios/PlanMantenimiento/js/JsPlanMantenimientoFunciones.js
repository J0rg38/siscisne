
function FncGuardar(){
	
	//HACK
	$("#CmpPlanMantenimientoDetalleAccion").removeAttr('disabled');
	
			
}





function FncTareaProductoCargarFormulario(oForm,oId,oPlanMantenimientoDetalleId,oPlanMantenimientoId,oPlanMantenimientoTareaId,oPlanMantenimientoDetalleKilometraje){

	FncCargarVentanaFull("TareaProducto",oForm,"Id="+oId+"&PlanMantenimientoId="+oPlanMantenimientoId+"&PlanMantenimientoTareaId="+oPlanMantenimientoTareaId+"&PlanMantenimientoDetalleKilometraje="+oPlanMantenimientoDetalleKilometraje+"&PlanMantenimientoDetalleId="+oPlanMantenimientoDetalleId);

}

function FncTareaProductoListar(oTareaProductoId,oPlanMantenimientoId,oPlanMantenimientoTareaId,oPlanMantenimientoDetalleId,oPlanMantenimientoDetalleKilometraje,oPlanMantenimientoDetalleAccion){

//$GET_TareaProductoId = $_POST['TareaProductoId'];
//$GET_PlanMantenimientoId = $_POST['PlanMantenimientoId'];
//$GET_PlanMantenimientoTareaId = $_POST['PlanMantenimientoTareaId'];
//$GET_PlanMantenimientoDetalleId = $_POST['PlanMantenimientoDetalleId'];
//$GET_PlanMantenimientoDetalleKilometraje = $_POST['PlanMantenimientoDetalleKilometraje'];
//$GET_PlanMantenimientoDetalleAccion = $_POST['PlanMantenimientoDetalleAccion'];

	$.ajax({
		type: 'POST',
		url: 'formularios/PlanMantenimiento/CapTareaProductoVer.php',
		data: 'TareaProductoId='+oTareaProductoId+		
		'&PlanMantenimientoId='+oPlanMantenimientoId+
		'&PlanMantenimientoTareaId='+oPlanMantenimientoTareaId+
		'&PlanMantenimientoDetalleId='+oPlanMantenimientoDetalleId+
		'&PlanMantenimientoDetalleKilometraje='+oPlanMantenimientoDetalleKilometraje+
		'&PlanMantenimientoDetalleAccion='+oPlanMantenimientoDetalleAccion,
		success: function(html){


			$("#CapPlanMantenimientoDetalle_"+oPlanMantenimientoTareaId+"_"+oPlanMantenimientoDetalleKilometraje).html(html);
			//CapPlanMantenimientoDetalle_<?php echo $DatPlanMantenimientoTarea->PmtId;?>_<?php echo $DatKilometro['eq'];?>
		}
	});

}












function FncPlanMantenimientoDetalleCargarFormulario(oForm,oPlanMantenimientoDetalleId,oPlanMantenimientoId,oPlanMantenimientoTareaId,oPlanMantenimientoDetalleKilometraje){
		//tb_show(this.title,'principal2.php?Mod=PlanMantenimientoDetalle&Form='+oForm+'&Dia=1&Id='+oPlanMantenimientoDetalleId+'&PlanMantenimientoId='+oPlanMantenimientoId+'&PlanMantenimientoTareaId='+oPlanMantenimientoTareaId+'&PlanMantenimientoDetalleKilometraje='+oPlanMantenimientoDetalleKilometraje+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		
	FncCargarVentanaFull("PlanMantenimientoDetalle",oForm,"PlanMantenimientoId="+oPlanMantenimientoId+"&PlanMantenimientoTareaId="+oPlanMantenimientoTareaId+"&PlanMantenimientoDetalleKilometraje="+oPlanMantenimientoDetalleKilometraje+"&Id="+oPlanMantenimientoDetalleId);

}



function FncPlanMantenimientoDetalleListar(oPlanMantenimientoDetalleId){

	$.ajax({
		type: 'POST',
		url: 'formularios/PlanMantenimiento/PlanMantenimientoDetalleVer.php',
		data: 'PlanMantenimientoDetalleId='+oPlanMantenimientoDetalleId,
		success: function(html){

			$(".CapPlanMantenimientoDetalle_"+oPlanMantenimientoDetalleId).html(html);
			
		}
	});

}























//
//function FncTareaProductoBuscar (){
//	
//}
//
//
//function FncTareaProductoCargarFormulario(oForm,oTareaProductoId,oPlanMantenimientoId,oPlanMantenimientoDetalleId,oPlanMantenimientoTareaId,oKilometraje){
////tb_show(this.title,'principal2.php?Mod=Cliente&Form='+oForm+'&Dia=1&ClienteId='+ClienteId+'&Id='+ClienteId+'&ClienteNombre='+ClienteNombre+'&TipoDocumentoId='+TipoDocumentoId+'&ClienteNumeroDocumento='+ClienteNumeroDocumento+'&ClienteDireccion='+ClienteDireccion+'&ClienteTipoId='+ClienteTipoId+'&ClienteEmail='+ClienteEmail+'&ClienteTelefono='+ClienteTelefono+'&ClienteCelular='+ClienteCelular+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);	
//
//	tb_show(this.title,'principal2.php?Mod=TareaProducto&Form='+oForm+'&Dia=1&Id='+oTareaProductoId+'&PmaId='+oPlanMantenimientoId+'&PmdId='+oPlanMantenimientoDetalleId+'&PmtId='+oPlanMantenimientoTareaId+'&Kilometraje='+oKilometraje+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		
//
////tb_show(this.title,'principal2.php?Mod=TareaProducto&Form='+oForm+'&Dia=1&Id='+oTareaProductoId+'&PmaId='+oPlanMantenimientoId+'PmdId='+oPlanMantenimientoDetalleId+'&PmtId='+oPlanMantenimientoTareaId+'&Kilometraje='+oKilometraje+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=540&width=890&modal=true',this.rel);		
//
//
//}
//
//
//function FncPlanMantenimientoTareaProductoListar(oPlanMantenimientoDetalleId,oPlanMantenimientoId,oMantenimientoKilometraje,oPlanMantenimientoTareaId){
//
//	$.ajax({
//		type: 'POST',
//		url: 'formularios/PlanMantenimiento/TareaProductoVer.php',
//		data: 'PlanMantenimientoId='+oPlanMantenimientoId+'&MantenimientoKilometraje='+oMantenimientoKilometraje+'&PlanMantenimientoTareaId='+oPlanMantenimientoTareaId,
//		success: function(html){
//
//			$().html(oPlanMantenimientoDetalleId);
//			
//		}
//	});
//
//}