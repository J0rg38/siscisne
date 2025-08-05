
$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	
	$("#BtnListaPrecioEditar").hide();
		
});	

//function FncListaPrecioNuevo(){
//
//	$("#BtnListaPrecioEditar").hide();
////	$("#BtnListaPrecioRegistrar").show();
//		
//}
//
//function FncListaPrecioEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oAmdId){	
//
//	$('#CmpListaPrecioId').val(oProId);
//
//
//	$("#BtnListaPrecioEditar").show();
////	$("#BtnListaPrecioRegistrar").hide();
//	
//	FncListaPrecioFuncion();
//}
//
//
//function FncListaPrecioFuncion(){
//	
//}
//
//
//
//
//
//
function FncListaPrecioBuscar(oCampo){
	
	FncProductoBuscar('Id');

}






/*
* Funciones PopUp Formulario
*/

function FncListaPrecioCargarFormulario(oForm){

	var ProductoId = $('#CmpProductoId').val();
	tb_show(this.title,'principal2.php?Mod=ListaPrecio&Form='+oForm+'&Dia=1&Id='+ProductoId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncTBCerrarFunncion(oModulo){


	if (typeof oModulo == 'string' || oModulo instanceof String){
		if(oModulo!="" && oModulo!=null && oModulo!="undefined"){
			try{
				eval("Fnc"+oModulo+"Buscar('Id');");		
			}catch(e){
				
			}			
		}
	}
	
	
}
