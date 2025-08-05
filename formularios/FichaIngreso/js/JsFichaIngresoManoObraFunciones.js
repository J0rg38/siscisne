// JavaScript Document

function FncFichaIngresoManoObraNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'ManoObraId').val("");
	$('#Cmp'+oModalidadIngreso+'ManoObraDescripcion').val("");
	$('#Cmp'+oModalidadIngreso+'ManoObraImporte').val("");
	$('#Cmp'+oModalidadIngreso+'ManoObraItem').val("");	
			

	$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Listo para registrar elementos');				
	$('#Cmp'+oModalidadIngreso+'ManoObraDescripcion').focus();			
	$('#CmpFichaIngreso'+oModalidadIngreso+'ManoObraAccion').val("AccFichaIngresoManoObraRegistrar.php");

	$('#Cmp'+oModalidadIngreso+'ManoObraImporte').removeAttr('readonly');
	$('#Cmp'+oModalidadIngreso+'ManoObraDescripcion').removeAttr('readonly');
	
}

function FncFichaIngresoManoObraGuardar(oModalidadIngreso){

//alert(":3");
		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpFichaIngreso'+oModalidadIngreso+'ManoObraAccion').val();		
	
			var ManoObraId = $('#Cmp'+oModalidadIngreso+'ManoObraId').val();
			var ManoObraDescripcion = $('#Cmp'+oModalidadIngreso+'ManoObraDescripcion').val();
			var ManoObraImporte = $('#Cmp'+oModalidadIngreso+'ManoObraImporte').val();
		
			var Item = $('#Cmp'+oModalidadIngreso+'ManoObraItem').val();
	
			if(ManoObraDescripcion==""){
				$('#Cmp'+oModalidadIngreso+'ManoObraDescripcion').select();	
			}else if(ManoObraImporte=="" || ManoObraImporte <=0){
				$('#Cmp'+oModalidadIngreso+'ManoObraImporte').select();	
			}else{
				$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/FichaIngreso/acc/'+Acc,
							data: 'Identificador='+Identificador
							+'&ManoObraImporte='+ManoObraImporte
							+'&ManoObraDescripcion='+ManoObraDescripcion
							+'&ManoObraId='+ManoObraId
							+'&Item='+Item
							+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(rpta){
								
								if(rpta != "" ){
									alert(rpta);
								}
								
							$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Listo');							
								FncFichaIngresoManoObraListar(oModalidadIngreso);
							}
						});
						
						FncFichaIngresoManoObraNuevo(oModalidadIngreso);	
					
				}
			

	
}


function FncFichaIngresoManoObraListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Cargando...');
	
	var ModalidadIngresoId = $('#CmpModalidadIngresoId_'+oModalidadIngreso).val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/FrmFichaIngresoManoObraListado.php',
		data: 'ModalidadIngresoId='+ModalidadIngresoId
		+'&Identificador='+Identificador
		+'&ModalidadIngreso='+oModalidadIngreso
		+'&Editar='+FichaIngresoManoObraEditar
		+'&Eliminar='+FichaIngresoManoObraEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Listo');	
			$("#CapFichaIngreso"+oModalidadIngreso+"ManoObras").html("");
			$("#CapFichaIngreso"+oModalidadIngreso+"ManoObras").append(html);
		}
	});
	
}


function FncFichaIngresoManoObraEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Editando...');
	$('#CmpFichaIngreso'+oModalidadIngreso+'ManoObraAccion').val("AccFichaIngresoManoObraEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaIngreso/acc/AccFichaIngresoManoObraEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaIngresoManoObra){
			
				/*
SesionObjeto-FichaIngresoManoObra
Parametro1 = FmoId
Parametro2 =
Parametro3 = FmoDescripcion
Parametro4 = FmoImporte
Parametro5 =
Parametro6 = 
Parametro7 = FmoTiempoCreacion
Parametro8 = FmoTiempoModificacion
*/
	
	
				$('#Cmp'+oModalidadIngreso+'ManoObraId').val(InsFichaIngresoManoObra.Parametro1);
				$('#Cmp'+oModalidadIngreso+'ManoObraDescripcion').val(InsFichaIngresoManoObra.Parametro3);
				$('#Cmp'+oModalidadIngreso+'ManoObraImporte').val(InsFichaIngresoManoObra.Parametro4);
				$('#Cmp'+oModalidadIngreso+'ManoObraItem').val(InsFichaIngresoManoObra.Item);
			
				
			}
	});
	
	
	$('#Cmp'+oModalidadIngreso+'ManoObraImporte').select();

	
}

function FncFichaIngresoManoObraEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/AccFichaIngresoManoObraEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ManoObraAccion').html("Eliminado");	
				FncFichaIngresoManoObraListar(oModalidadIngreso);
			}
		});

		FncFichaIngresoManoObraNuevo(oModalidadIngreso);

	}
	
}



function FncFichaIngresoManoObraEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/AccFichaIngresoManoObraEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ManoObraAccion').html('Eliminado');	
				FncFichaIngresoManoObraListar(oModalidadIngreso);
			}
		});	
			
		FncFichaIngresoManoObraNuevo(oModalidadIngreso);
	}
	
}
