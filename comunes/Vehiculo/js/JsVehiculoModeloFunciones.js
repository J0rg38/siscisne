// JavaScript Document

var VehiculoModeloHabilitado = 1;
var VehiculoModeloVigencia = 0


$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	
	if($("#CmpVehiculoModeloId").val()=="" || $("#CmpVehiculoModeloId").val() == null){
		$("#BtnVehiculoModeloEditar").hide();
		$("#BtnVehiculoModeloRegistrar").show();
	}else{
		$("#BtnVehiculoModeloEditar").show();
		$("#BtnVehiculoModeloRegistrar").hide();
	}

});	



/*
* Funciones PopUp Formulario
*/

function FncVehiculoModeloCargarFormulario(oForm){

	var VehiculoModeloId = $("#CmpVehiculoModelo").val();
	var VehiculoModeloNombre = $("#CmpVehiculoModeloNombre").val();
	
	var VehiculoMarca = $("#CmpVehiculoMarca").val();

	tb_show(this.title,'principal2.php?Mod=VehiculoModelo&Form='+oForm+'&Dia=1&Id='+VehiculoModeloId+'&VehiculoModeloNombre='+VehiculoModeloNombre+'&VehiculoMarca='+VehiculoMarca+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=450&modal=true',this.rel);	

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
function FncVehiculoModeloBuscar(oCampo){
	FncVehiculoModelosCargar();
}




function FncVehiculoModelosCargar(){
	
	console.log("FncVehiculoModelosCargar");
	
	var VehiculoMarcaId = $("#CmpVehiculoMarca").val();
	var VehiculoModeloId = $("#CmpVehiculoModeloId").val();
	
	var VehiculoModelo = $("#CmpVehiculoModelo").val();

	console.log("VehiculoMarcaId: "+VehiculoMarcaId);
	//if(VehiculoModeloHabilitado==1){
//		$('#CmpVehiculoModelo').removeAttr('disabled');
//	}else{
//		$('#CmpVehiculoModelo').attr('disabled', 'disabled');
//	}
	
	if(VehiculoMarcaId != ""){

//$("#CmpVehiculoModelo").unbind();

		$("select#CmpVehiculoModelo").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Vehiculo/JnVehiculoModelo.php",{Marca: VehiculoMarcaId,VehiculoModeloVigencia:VehiculoModeloVigencia}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					var nombre = "";
					
					if(j[i].VmoNombreComercial!="" && j[i].VmoNombreComercial!=null){
						nombre += ' (' + j[i].VmoNombreComercial + ')'
					}
					
					if(j[i].VmoVigenciaVenta=="1"){
						nombre += ' [*]'
					}
					
					if(VehiculoModeloId == j[i].VmoId){
						
						//if(j[i].VmoNombreComercial!="" && j[i].VmoNombreComercial!=null){
						//	options += '<option selected="selected" value="' + j[i].VmoId + '">' + j[i].VmoNombre + ' (' + j[i].VmoNombreComercial + ')</option>';					
						//}else{
							options += '<option selected="selected" value="' + j[i].VmoId + '">' + j[i].VmoNombre +' '+nombre+ '</option>';					
						//}
						
						
						
					}else{
						
						//if(j[i].VmoNombreComercial!="" && j[i].VmoNombreComercial!=null){
						//	options += '<option value="' + j[i].VmoId + '">' + j[i].VmoNombre + ' ('+ j[i].VmoNombreComercial + ')</option>';		
						//}else{
							options += '<option value="' + j[i].VmoId + '">' + j[i].VmoNombre  +' '+nombre+ '</option>';		
						//}
						
								
					}
				}
				
			}else{
			
				alert("No se encontraron modelos");
				
			}
			
			
			
			
			$("select#CmpVehiculoModelo").change(function(){

				$.getJSON("comunes/Vehiculo/JnVehiculoModeloDatos.php",{VehiculoModeloId: $(this).val()}, function(j){
					if(j.length != 0){
						
						$("#CmpVehiculoIngresoNombre").val(j.VmoNombre);
						
					}
				});	
		
			});
			
			
			
			$("select#CmpVehiculoModelo").html(options);
			
			
			if($("#CmpVehiculoModelo").val()=="" || $("#CmpVehiculoModelo").val() == null){
				$("#BtnVehiculoModeloEditar").hide();
				$("#BtnVehiculoModeloRegistrar").show();
			}else{
				$("#BtnVehiculoModeloEditar").show();
				$("#BtnVehiculoModeloRegistrar").hide();
			}


			FncVehiculoModeloFuncion();
			
		});		
		
	}else{

		$("#BtnVehiculoModeloEditar").hide();
		$("#BtnVehiculoModeloRegistrar").show();

		$("select#CmpVehiculoModelo").html("");

	}
}


function FncVehiculoModeloFuncion(){
	
}