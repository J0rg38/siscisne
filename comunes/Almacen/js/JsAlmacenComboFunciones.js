// JavaScript Document

var AlmacenHabilitado = 1;


$().ready(function() {	

/*
* POPUP REGISTRAR/EDITAR
*/	
	//if($("#CmpAlmacenId").val()=="" || $("#CmpAlmacenId").val() == null){
//		$("#BtnAlmacenEditar").hide();
//		$("#BtnAlmacenRegistrar").show();
//	}else{
//		$("#BtnAlmacenEditar").show();
//		$("#BtnAlmacenRegistrar").hide();
//	}

});	



/*
* Funciones PopUp Formulario
*/

//function FncAlmacenCargarFormulario(oForm){
//
//	var AlmacenId = $("#CmpAlmacen").val();
//	var AlmacenNombre = $("#CmpAlmacenNombre").val();
//	
//	var VehiculoMarca = $("#CmpVehiculoMarca").val();
//
//	tb_show(this.title,'principal2.php?Mod=Almacen&Form='+oForm+'&Dia=1&Id='+AlmacenId+'&AlmacenNombre='+AlmacenNombre+'&VehiculoMarca='+VehiculoMarca+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=450&modal=true',this.rel);	
//
//}


//function FncTBCerrarFunncion(oModulo){
//	
//	if (typeof oModulo == 'string' || oModulo instanceof String){
//		if(oModulo!="" && oModulo!=null && oModulo!="undefined"){
//			try{
//				eval("Fnc"+oModulo+"Buscar('Id');");		
//			}catch(e){
//				
//			}	
//		}
//	}
//
//}
//function FncAlmacenBuscar(oCampo){
//	FncAlmacensCargar();
//}




function FncAlmacensCargar(){
	
	console.log("FncAlmacensCargar");
	
	var SucursalId = $("#CmpSucursal").val();
	var AlmacenEscogido = $("#CmpAlmacenId").val();
	//var Almacen = $("#CmpAlmacen").val();

	
	if(SucursalId != ""){

//$("#CmpAlmacen").unbind();

		$("select#CmpAlmacen").html('<option value="">Escoja una opcion</option>');

		$.getJSON("comunes/Almacen/JnAlmacenes.php",{SucursalId: SucursalId}, function(j){
			
			var options = '';
			options += '<option value="">Escoja una opcion</option>';			
			
			if(j.length!=0){
				
				for (var i = 0; i < j.length; i++) {
					
					if(AlmacenEscogido == j[i].AlmId){
						
						options += '<option selected="selected" value="' + j[i].AlmId + '">' + j[i].AlmNombre + '</option>';					
						
					}else{
						
						options += '<option value="' + j[i].AlmId + '">' + j[i].AlmNombre  + '</option>';		
						
					}
				}
				
			}else{
			
				alert("No se encontraron almacenes");
				
			}
			
			
			
			
			//$("select#CmpAlmacen").change(function(){
//
//				$.getJSON("comunes/Vehiculo/JnAlmacenDatos.php",{AlmacenId: $(this).val()}, function(j){
//					if(j.length != 0){
//						
//						$("#CmpVehiculoIngresoNombre").val(j.AlmNombre);
//						
//					}
//				});	
//		
//			});
			
			
			
			$("select#CmpAlmacen").html(options);
			
			$("#CmpAlmacen").prop("selectedIndex", 1);
			
			//if($("#CmpAlmacen").val()=="" || $("#CmpAlmacen").val() == null){
//				$("#BtnAlmacenEditar").hide();
//				$("#BtnAlmacenRegistrar").show();
//			}else{
//				$("#BtnAlmacenEditar").show();
//				$("#BtnAlmacenRegistrar").hide();
//			}


			FncAlmacenFuncion();
			
		});		
		
	}else{

		//$("#BtnAlmacenEditar").hide();
//		$("#BtnAlmacenRegistrar").show();

		$("select#CmpAlmacen").html("");

	}
}


function FncAlmacenFuncion(){
	
}