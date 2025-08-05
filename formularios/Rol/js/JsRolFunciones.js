// JavaScript Document


function FncPrivilegioSeleccionarTodo(){

	if(document.getElementById('CmpPrivilegioSeleccionarTodo').checked){

		for (i=0;i<document.FrmRol.elements.length;i++){
			if(document.FrmRol.elements[i].type == "checkbox"){

        		document.FrmRol.elements[i].checked = 1;

			}
		}

	}else{

		for (i=0;i<document.FrmRol.elements.length;i++){
			if(document.FrmRol.elements[i].type == "checkbox"){
        		document.FrmRol.elements[i].checked=0;
			}
		}

	}
	
}

function FncPrivilegioSeleccionarZona(oZonaId){
	
	var aux;
	
	if(document.getElementById('CmpPrivilegioSeleccionarZona_'+oZonaId).checked){

		for (i=0;i<document.FrmRol.elements.length;i++){
			if(document.FrmRol.elements[i].type == "checkbox"){
				
				aux = document.FrmRol.elements[i].name.indexOf("__");
											
				if(document.FrmRol.elements[i].name.substring(0,aux) == 'Chk_'+oZonaId){					
	        		document.FrmRol.elements[i].checked = 1;	
				}
			}
		}

	}else{

		for (i=0;i<document.FrmRol.elements.length;i++){
			if(document.FrmRol.elements[i].type == "checkbox"){
				
				aux = document.FrmRol.elements[i].name.indexOf("__");
				
				if(document.FrmRol.elements[i].name.substring(0,aux) == 'Chk_'+oZonaId){			
	        		document.FrmRol.elements[i].checked=0;
				}
        		
			}
		}

	}
	
}