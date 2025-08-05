
$().ready(function() {


	if(MostrarPanelCallCenter == "Si"){
		FncCargarPanelCallCenter();
	}
	
	if(MostrarPanelAlmacen == "Si"){
		FncCargarPanelAlmacen();
	}
	
		if(MostrarPanelTaller == "Si"){
		FncCargarPanelTaller();
	}
	
		if(MostrarPanelPlaneamiento == "Si"){
		FncCargarPanelPlaneamiento();
	}
	
		if(MostrarPanelPostVenta == "Si"){
		FncCargarPanelPostVenta();
	}
	
		if(MostrarPanelCaja == "Si"){
		FncCargarPanelCaja();
	}
	
	
	FncNotificacionVerificar();
/*
* EVENTOS - NAVEGACION
*/		

	
});




function FncCargarPanelCallCenter(){
	
//	console.log("FncCargarPanelCallCenter");
	
	$.ajax({
	type: 'POST',
	url: 'formularios/Default/CapPanelCallCenter.php',
	data: 'Sucursal=',
	success: function(html2){
		
			$("#CapPanelCallCenter").html(html2);
			
		}
	});
		
}



function FncCargarPanelAlmacen(){
	
	$.ajax({
	type: 'POST',
	dataType: 'json',
	url: 'formularios/Default/CapPanelAlmacen.php',
	data: 'Sucursal=',
	success: function(html){
		
			$("#CapPanelAlmacen").html(html);
			
		}
	});
		
}


function FncCargarPanelTaller(){
	
	$.ajax({
	type: 'POST',
	dataType: 'json',
	url: 'formularios/Default/CapPanelTaller.php',
	data: 'Sucursal=',
	success: function(html){
		
			$("#CapPanelTaller").html(html);
			
		}
	});
		
}


function FncCargarPanelPlaneamiento(){
	
	$.ajax({
	type: 'POST',
	dataType: 'json',
	url: 'formularios/Default/CapPanelPlaneamiento.php',
	data: 'Sucursal=',
	success: function(html){
		
			$("#CapPanelPlaneamiento").html(html);
			
		}
	});
		
}

function FncCargarPanelPostVenta(){
	
	$.ajax({
	type: 'POST',
	dataType: 'json',
	url: 'formularios/Default/CapPanelPostVenta.php',
	data: 'Sucursal=',
	success: function(html){
		
			$("#CapPanelPostVenta").html(html);
			
		}
	});
		
}


function FncCargarPanelCaja(){
	
	$.ajax({
	type: 'POST',
	dataType: 'json',
	url: 'formularios/Default/CapPanelCaja.php',
	data: 'Sucursal=',
	success: function(html){
		
			$("#CapPanelCaja").html(html);
			
		}
	});
		
}

