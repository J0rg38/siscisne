// JavaScript Document

function FncPreEntregaClienteNuevo(){
	
	$('#CmpClienteId').val("");
	$('#CmpClienteDescripcion').val("");
	$('#CmpClienteAccion').val("");
	$('#CmpClienteItem').val("");	
			
	$('#CapClienteAccion').html('Listo para registrar elementos');	
			
	$('#CmpClienteDescripcion').select();
			
	$('#CmpPreEntregaClienteAccion').val("AccPreEntregaClienteRegistrar.php");

}

function FncPreEntregaClienteGuardar(){

var Identificador = $('#Identificador').val();

	var Acc = $('#CmpPreEntregaClienteAccion').val();		
			
			var ClienteId = $('#CmpClienteId').val();
		
			var Item = $('#CmpClienteItem').val();
	
			if(ClienteId==""){
				$('#CmpClienteId').select();	
						
			}else{
				$('#CapClienteAccion').html('Guardando...');
				
				
						$.ajax({
							type: 'POST',
							url: 'formularios/PreEntrega/acc/'+Acc,
							data: 'Identificador='+Identificador+
'&ClienteId='+ClienteId+
'&Item='+Item
,
							success: function(){
								
							$('#CapClienteAccion').html('Listo');							
								FncPreEntregaClienteListar();
							}
						});
						
						
						
								
							FncPreEntregaClienteNuevo();	
					
					
				}
			

	
}


function FncPreEntregaClienteListar(){

	var Identificador = $('#Identificador').val();

	$('#CapClienteAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PreEntrega/FrmPreEntregaClienteListado.php',
		data: 'Identificador='+Identificador,
		success: function(html){
			$('#CapClienteAccion').html('Listo');	
			$("#CapPreEntregaClientes").html("");
			$("#CapPreEntregaClientes").append(html);
		}
	});
	

}



function FncPreEntregaClienteEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapClienteAccion').html('Editando...');
	$('#CmpPreEntregaClienteAccion').val("AccPreEntregaClienteEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PreEntrega/acc/AccPreEntregaClienteEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem+
'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaIngresoCliente){
			
/*
SesionObjeto-FichaIngresoCliente
Parametro1 = 
Parametro2 = CliId
Parametro3 = CliNombre
Parametro4 = CliNumeroDocumento
Parametro5 = CliApellidoPaterno
Parametro6 = CliApellidoMaterno
Parametro7 = 
Parametro8 = 
*/

				$('#CmpClienteId').val(InsFichaIngresoCliente.Parametro2);		
			
				$('#CmpClienteItem').val(InsFichaIngresoCliente.Item);
		}
	});
	
	
	$('#CmpClienteDescripcion').select();
	
}

function FncPreEntregaClienteEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapClienteAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PreEntrega/acc/AccPreEntregaClienteEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem+
'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#CapClienteAccion').html("Eliminado");	
				FncPreEntregaClienteListar();
			}
		});

		
		FncPreEntregaClienteNuevo();
		

	}


	
}



function FncPreEntregaClienteEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapClienteAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PreEntrega/acc/AccPreEntregaClienteEliminarTodo.php',
			data: 'Identificador='+Identificador+
'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#CapClienteAccion').html('Eliminado');	
				FncPreEntregaClienteListar();
			}
		});	
			
		FncPreEntregaClienteNuevo();
	}
	
}



function FncPreEntregaClienteEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapClienteAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PreEntrega/acc/AccPreEntregaClienteEliminarTodo.php',
			data: 'Identificador='+Identificador+
'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#CapClienteAccion').html('Eliminado');	
				FncPreEntregaClienteListar();
			}
		});	
			
		FncPreEntregaClienteNuevo();
	}
	
}

function FncPreEntregaClienteCargar(){

	var Identificador = $('#Identificador').val();
	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();
	
	if(VehiculoIngresoId!=""){
		
		$('#CapClienteAccion').html('Cargando...');	

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: 'formularios/PreEntrega/acc/AccPreEntregaClienteCargar.php',
			data: 'Identificador='+Identificador+
			'&VehiculoIngresoId='+VehiculoIngresoId,
			success: function(Resultado){
				
				
				$('#CapClienteAccion').html('Listo');	
				
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert",
					text:Resultado['Mensaje'],
					callback: function(result){
							
							FncPreEntregaClienteListar();
							
					}
				});	
				
				
				
				
				
			}
		});	

	}
	
	
	

}



