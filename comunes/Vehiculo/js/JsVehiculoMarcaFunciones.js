// JavaScript Document

var VehiculoMarcaHabilitado = 1;
var VehiculoMarcaVigencia = 0


$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	

	//if($("#CmpVehiculoMarcaId").val()==""){
	if($("#CmpVehiculoMarcaId").val()=="" || $("#CmpVehiculoMarcaId").val() == null){
		$("#BtnVehiculoMarcaEditar").hide();
		$("#BtnVehiculoMarcaRegistrar").show();
	}else{
		$("#BtnVehiculoMarcaEditar").show();
		$("#BtnVehiculoMarcaRegistrar").hide();
	}


});	



/*
* Funciones PopUp Formulario
*/

function FncVehiculoMarcaCargarFormulario(oForm){

	var VehiculoMarcaId = $("#CmpVehiculoMarca").val();
	var VehiculoMarcaNombre = $("#CmpVehiculoMarcaNombre").val();
	
	tb_show(this.title,'principal2.php?Mod=VehiculoMarca&Form='+oForm+'&Dia=1&Id='+VehiculoMarcaId+'&VehiculoMarcaNombre='+VehiculoMarcaNombre+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=450&modal=true',this.rel);	
		
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

function FncVehiculoMarcaBuscar(oCampo){
	FncVehiculoMarcasCargar();
}

function FncVehiculoMarcasCargar(){
	
	var VehiculoMarcaId = $("#CmpVehiculoMarcaId").val();
	//	
//	if(VehiculoMarcaHabilitado==1){
//		$('#CmpVehiculoMarca').removeAttr('disabled');
//	}else{
//		$('#CmpVehiculoMarca').attr('disabled', 'disabled');
//	}
	


		$("select#CmpVehiculoMarca").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Vehiculo/JnVehiculoMarca.php",{VehiculoMarcaVigencia:VehiculoMarcaVigencia}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					if(VehiculoMarcaId == j[i].VmaId){
						options += '<option selected="selected" value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';					
					}else{
						options += '<option value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';				
					}
				}
				
			}else{
			
				alert("No se encontraron marcas");
				
			}
			
			$("select#CmpVehiculoMarca").html(options);
			
			if($("#CmpVehiculoMarca").val()=="" || $("#CmpVehiculoMarca").val() == null){
				$("#BtnVehiculoMarcaEditar").hide();
				$("#BtnVehiculoMarcaRegistrar").show();
			}else{
				$("#BtnVehiculoMarcaEditar").show();
				$("#BtnVehiculoMarcaRegistrar").hide();
			}
	
	
			FncVehiculoMarcaFuncion();
			
		});		
		
	
}


function FncVehiculoMarcaFuncion(){
	
}