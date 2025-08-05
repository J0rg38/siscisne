// JavaScript Document

// JavaScript Document

function FncVehiculoListaPrecioDetalleNuevo(){
	
	$('#CmpVehiculoListaPrecioDetalleId').val("");
	
	//$('#CmpVehiculoMarca').val("");
	$('#CmpVehiculoModelo').val("");
	$('#CmpVehiculoVersion').val("");
	
	$('#CmpVehiculoListaPrecioDetalleFuente').val("");
	$('#CmpVehiculoListaPrecioDetalleCosto').val("");
	$('#CmpVehiculoListaPrecioDetallePrecioCierre').val("");
	$('#CmpVehiculoListaPrecioDetallePrecioLista').val("");
	
	$('#CmpVehiculoListaPrecioDetalleBonoGM').val("");
	$('#CmpVehiculoListaPrecioDetalleBonoDealer').val("");
	$('#CmpVehiculoListaPrecioDetalleDescuentoGerencia').val("");

	$('#CmpVehiculoListaPrecioDetallItem').val("");	

	$('#CapVehiculoListaPrecioAccion').html('Listo para registrar elementos');	

	$('#CmpVehiculoMarca').focus();
	
	$('#CmpVehiculoListaPrecioDetalleAccion').val("AccVehiculoListaPrecioDetalleRegistrar.php");

	$('#CmpVehiculoMarca').removeAttr('disabled');
	$('#CmpVehiculoModelo').removeAttr('disabled');
	$('#CmpVehiculoVersion').removeAttr('disabled');

/*
* POPUP REGISTRAR/EDITAR
*/
	
}

function FncVehiculoListaPrecioDetalleGuardar(){

		var Identificador = $('#Identificador').val();

			var Acc = $('#CmpVehiculoListaPrecioDetalleAccion').val();		

			var VehiculoListaPrecioId = $('#CmpVehiculoListaPrecioDetalleId').val();

			var VehiculoMarcaId = $('#CmpVehiculoMarca').val();
			var VehiculoModeloId = $('#CmpVehiculoModelo').val();
			var VehiculoVersionId = $('#CmpVehiculoVersion').val();

			var VehiculoListaPrecioDetalleFuente = $('#CmpVehiculoListaPrecioDetalleFuente').val();
			var VehiculoListaPrecioDetalleCosto = $('#CmpVehiculoListaPrecioDetalleCosto').val();
			
			var VehiculoListaPrecioDetallePrecioCierre = $('#CmpVehiculoListaPrecioDetallePrecioCierre').val();
			var VehiculoListaPrecioDetallePrecioLista = $('#CmpVehiculoListaPrecioDetallePrecioLista').val();
			
			var VehiculoListaPrecioDetalleBonoGM = $('#CmpVehiculoListaPrecioDetalleBonoGM').val();
			var VehiculoListaPrecioDetalleBonoDealer = $('#CmpVehiculoListaPrecioDetalleBonoDealer').val();
			var VehiculoListaPrecioDetalleDescuentoGerencia = $('#CmpVehiculoListaPrecioDetalleDescuentoGerencia').val();

			var Item = $('#CmpVehiculoListaPrecioDetalleItem').val();
	
			if(VehiculoMarcaId == ""){
				$('#CmpVehiculoMarca').focus();	
			}else if(VehiculoModeloId==""){
				$('#CmpVehiculoModelo').focus();	
			}else if(VehiculoVersionId==""){
				$('#CmpVehiculoVersion').focus();	
			}else if(VehiculoListaPrecioDetalleFuente==""){
				$('#CmpVehiculoListaPrecioDetalleFuente').select();	
			}else if(VehiculoListaPrecioDetalleCosto==""){
				$('#CmpVehiculoListaPrecioDetalleCosto').select();	
			}else if(VehiculoListaPrecioDetallePrecioCierre==""){
				$('#CmpVehiculoListaPrecioDetallePrecioCierre').select();						
			}else if(VehiculoListaPrecioDetallePrecioLista==""){
				$('#CmpVehiculoListaPrecioDetallePrecioLista').select();						
			}else{

				$('#CapVehiculoListaPrecioAccion').html('Guardando...');
				
				$.ajax({
				  type: 'POST',
				  url: 'formularios/VehiculoListaPrecio/acc/'+Acc,
				  data: 'Identificador='+Identificador+'&VehiculoMarcaId='+VehiculoMarcaId+'&VehiculoModeloId='+VehiculoModeloId+'&VehiculoVersionId='+VehiculoVersionId+'&VehiculoListaPrecioDetalleFuente='+VehiculoListaPrecioDetalleFuente+'&VehiculoListaPrecioDetalleCosto='+VehiculoListaPrecioDetalleCosto+'&VehiculoListaPrecioDetallePrecioCierre='+VehiculoListaPrecioDetallePrecioCierre+'&VehiculoListaPrecioDetallePrecioLista='+VehiculoListaPrecioDetallePrecioLista+'&VehiculoListaPrecioDetalleDescuentoGerencia='+VehiculoListaPrecioDetalleDescuentoGerencia+'&VehiculoListaPrecioDetalleBonoDealer='+VehiculoListaPrecioDetalleBonoDealer+'&VehiculoListaPrecioDetalleBonoGM='+VehiculoListaPrecioDetalleBonoGM+'&Item='+Item,
				  success: function(){
					  $('#CapVehiculoListaPrecioAccion').html('Listo');							
					  FncVehiculoListaPrecioDetalleListar();
				  }
				});
						
				FncVehiculoListaPrecioDetalleNuevo();	
					
			}
			
}


function FncVehiculoListaPrecioDetalleListar(){

	var Identificador = $('#Identificador').val();

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$('#CapVehiculoListaPrecioAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoListaPrecio/FrmVehiculoListaPrecioDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+VehiculoListaPrecioDetalleEditar+'&Eliminar='+VehiculoListaPrecioDetalleEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapVehiculoListaPrecioAccion').html('Listo');	
			$("#CapVehiculoListaPrecioDetalles").html("");
			$("#CapVehiculoListaPrecioDetalles").append(html);
		}
	});
	
}



function FncVehiculoListaPrecioDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	var VentaDirectaId = $('#CmpVentaDirectaId').val();
	
	
	$('#CapVehiculoListaPrecioAccion').html('Editando...');
	$('#CmpVehiculoListaPrecioDetalleAccion').val("AccVehiculoListaPrecioDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoListaPrecio/acc/AccVehiculoListaPrecioDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsVehiculoListaPrecioDetalle){

/*
SesionObjeto-VehiloListaPrecioDetalle
Parametro1 = VldId
Parametro2 = 
Parametro3 = VldFuente
Parametro4 = VmaId
Parametro5 = VmoId
Parametro6 = VveId
Parametro7 = VldTiempoCreacion
Parametro8 = VldTiempoModificacion
Parametro9 = VldCosto
Parametro10 = VldPrecioCierre
Parametro11 = VldPrecioLista
Parametro12 = VmaNombre
Parametro13 = VmoNombre
Parametro14 = VveNombre
Parametro15 = VldTexto

Parametro16 = VldBonoGM
Parametro17 = VldBonoDealer
Parametro18 = VldDescuentoGerencia
*/
					$('#CmpVehiculoMarca').val(InsVehiculoListaPrecioDetalle.Parametro4);
					$('#CmpVehiculoModelo').val(InsVehiculoListaPrecioDetalle.Parametro5);
					$('#CmpVehiculoVersion').val(InsVehiculoListaPrecioDetalle.Parametro6);
					
					$('#CmpVehiculoListaPrecioDetalleFuente').val(InsVehiculoListaPrecioDetalle.Parametro3);
					$('#CmpVehiculoListaPrecioDetalleCosto').val(InsVehiculoListaPrecioDetalle.Parametro9);
					$('#CmpVehiculoListaPrecioDetallePrecioCierre').val(InsVehiculoListaPrecioDetalle.Parametro10);
					$('#CmpVehiculoListaPrecioDetallePrecioLista').val(InsVehiculoListaPrecioDetalle.Parametro11);

					$('#CmpVehiculoListaPrecioDetalleBonoGM').val(InsVehiculoListaPrecioDetalle.Parametro16);
					$('#CmpVehiculoListaPrecioDetalleBonoDealer').val(InsVehiculoListaPrecioDetalle.Parametro17);
					$('#CmpVehiculoListaPrecioDetalleDescuentoGerencia').val(InsVehiculoListaPrecioDetalle.Parametro18);
				
					$('#CmpVehiculoListaPrecioDetalleItem').val(InsVehiculoListaPrecioDetalle.Item);	



				$("select#CmpVehiculoMarca").html('<option value="">Escoja una opcion</option>');

				$.getJSON("comunes/Vehiculo/JnVehiculoMarca.php",{}, function(j){

					var options = '';
					options += '<option value="">Escoja una opcion</option>';			

					if(j.length!=0){

						for (var i = 0; i < j.length; i++) {
							if(InsVehiculoListaPrecioDetalle.Parametro4 == j[i].VmaId){
								options += '<option selected="selected" value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';					
							}else{
								options += '<option value="' + j[i].VmaId + '">' + j[i].VmaNombre + '</option>';				
							}
						}

					}else{
						alert("No se encontraron marcas");
					}

					$("select#CmpVehiculoMarca").html(options);

				});		
		

		
				$("select#CmpVehiculoModelo").html('<option value="">Escoja una opcion</option>');

				$.getJSON("comunes/Vehiculo/JnVehiculoModelo.php",{Marca: InsVehiculoListaPrecioDetalle.Parametro4}, function(j){
					
					var options = '';
					options += '<option value="">Escoja una opcion</option>';			
					
					if(j.length!=0){

						for (var i = 0; i < j.length; i++) {
							if( InsVehiculoListaPrecioDetalle.Parametro5 == j[i].VmoId){
								options += '<option selected="selected" value="' + j[i].VmoId + '">' + j[i].VmoNombre + '</option>';					
							}else{
								options += '<option value="' + j[i].VmoId + '">' + j[i].VmoNombre + '</option>';				
							}
						}

					}else{
						alert("No se encontraron marcas");
					}

					$("select#CmpVehiculoModelo").html(options);

				});		


				$("select#CmpVehiculoVersion").html('<option value="">Escoja una opcion</option>');
					
				$.getJSON("comunes/Vehiculo/JnVehiculoVersion.php",{Modelo: InsVehiculoListaPrecioDetalle.Parametro5}, function(j){

					var options = '';

					options += '<option value="">Escoja una opcion</option>';

						if(j.length != 0){							
							for (var i = 0; i < j.length; i++) {
								if(InsVehiculoListaPrecioDetalle.Parametro6 == j[i].VveId){
									options += '<option selected="selected" value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';		
								}else{
									options += '<option value="' + j[i].VveId + '">' + j[i].VveNombre + '</option>';				
								}
							}							
						}else{
							alert("No se encontraron versiones");
						}

						$("select#CmpVehiculoVersion").html(options);
						
						$('#CmpVehiculoListaPrecioDetalleFuente').select();
						
						
					});	
					
					}
				});


	

	$('#CmpVehiculoMarca').attr('readonly', true);
	$('#CmpVehiculoModelo').attr('readonly', true);
	$('#CmpVehiculoVersion').attr('readonly', true);

/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncVehiculoListaPrecioDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoListaPrecioAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoListaPrecio/acc/AccVehiculoListaPrecioDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVehiculoListaPrecioAccion').html("Eliminado");	
				FncVehiculoListaPrecioDetalleListar();
			}
		});

		FncVehiculoListaPrecioDetalleNuevo();
	}
	
}

function FncVehiculoListaPrecioDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoListaPrecioAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoListaPrecio/acc/AccVehiculoListaPrecioDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoListaPrecioAccion').html('Eliminado');	
				FncVehiculoListaPrecioDetalleListar();
			}
		});	
			
		FncVehiculoListaPrecioDetalleNuevo();
	}
	
}



$().ready(function() {

	
});
