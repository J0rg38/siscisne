// JavaScript Document


function FncZonaPrivilegioNuevo(){
//	document.getElementById('CmpZonaPrivilegioId').value = "";
	document.getElementById('CmpPrivilegioFecha').value = "";
	document.getElementById('CmpPrivilegioNombre').value = "";
	document.getElementById('CmpPrivilegioNumero').value = "";
	document.getElementById('CmpPrivilegioItem').value = "";
	document.getElementById('CapZonaPrivilegioAccion').innerHTML = "Listo para registrar elementos";	
	document.getElementById('CmpPrivilegioFecha').focus();
	document.getElementById('CmpZonaPrivilegioAccion').value = "AccZonaPrivilegioRegistrar.php";
}

function FncZonaPrivilegioGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = document.getElementById('CmpZonaPrivilegioAccion').value;
		
			var Fecha = document.getElementById('CmpPrivilegioFecha').value;
			var Nombre = document.getElementById('CmpPrivilegioNombre').value;
			var Numero = document.getElementById('CmpPrivilegioNumero').value;
			
			var Item = document.getElementById('CmpPrivilegioItem').value;
	
			if(Fecha==""){
				document.getElementById('CmpPrivilegioFecha').focus();	
			}else if(FncValidarFechaNormal(Fecha)==false){
				document.getElementById('CmpPrivilegioFecha').focus();
			}else if(Nombre==""){
				document.getElementById('CmpPrivilegioNombre').focus();	
			}else if(Numero==""){
				document.getElementById('CmpPrivilegioNumero').focus();	 
			}else{
				document.getElementById('CapZonaPrivilegioAccion').innerHTML = "Guardando...";
									
								
					AjaxZonaPrivilegio('formularios/Gasto/acc/'+Acc,'CapZonaPrivilegiosResultado','Identificador='+Identificador+'&Fecha='+Fecha+'&Nombre='+Nombre+'&Numero='+Numero+'&Item='+Item);
					
			
						if(confirm("Desea seguir agregando mas items?")==false){
							if(confirm("Desea guardar el registro ahora?")){
								$('#Guardar').val("1");
								$('#'+Formulario).submit();
							}
						}
							
					
					FncZonaPrivilegioNuevo();	
				}
			

	
}

function FncZonaPrivilegioListar(){

	var Identificador = $('#Identificador').val();
	
	document.getElementById('CapZonaPrivilegioAccion').innerHTML = "Cargando...";
	


	AjaxZonaPrivilegioListar('formularios/Gasto/FrmZonaPrivilegioListado.php','CapZonaPrivilegios','Identificador='+Identificador+'&Editar='+ZonaPrivilegioEditar+'&Eliminar='+ZonaPrivilegioEliminar);
	
}



function FncZonaPrivilegioEscoger(oFecha,oNombre,oNumero,oItem){//

	document.getElementById('CmpZonaPrivilegioAccion').value = "AccZonaPrivilegioEditar.php";
	
	document.getElementById('CapZonaPrivilegioAccion').innerHTML = "Editando...";
				
	document.getElementById('CmpPrivilegioFecha').value = oFecha;
	document.getElementById('CmpPrivilegioNombre').value = oNombre;
	document.getElementById('CmpPrivilegioNumero').value = oNumero;
	document.getElementById('CmpPrivilegioItem').value = oItem;	
	
	document.getElementById('CmpPrivilegioFecha').focus();
			
}

function FncZonaPrivilegioEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		document.getElementById('CapZonaPrivilegioAccion').innerHTML = "Eliminando...";	
		
		AjaxZonaPrivilegio('formularios/Gasto/acc/AccZonaPrivilegioEliminar.php','CapZonaPrivilegiosResultado','Identificador='+Identificador+'&Item='+oItem);	
		
		FncZonaPrivilegioNuevo();
		

	}
	
}




function FncZonaPrivilegioEliminarTodo(){
	
	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapArticuloAccion').html('Eliminando...');	
		AjaxZonaPrivilegioEliminar('formularios/Gasto/acc/AccZonaPrivilegioEliminarTodo.php','CapZonaPrivilegiosResultado','Identificador='+Identificador);	
		FncZonaPrivilegioNuevo();
	}
	
}
