
// JavaScript Document

$().ready(function() {

	$("#CmpRetiro").click(function(){
		FncEstablecerConductorRetiro();
	});

	$("#CmpVehiculoId").change(function(){
		//FncVehiculoCargarDatos();		
		FncVehiculoBuscar("Id");
	});

});

function FncEstablecerConductorRetiro(){

	var FechaInicioAux = $("#CmpFechaInicioAux").val();

	if($("#CmpRetiro").is(':checked')){
		$("#CmpFechaInicio").val("");
	}else{
		$("#CmpFechaInicio").val(FechaInicioAux);
	}
	
}





function FncConductorVerificarExisteNumeroDocumento(){

	var ConductorNumeroDocumento = $("#CmpNumeroDocumento").val();

	$("#CapConductorEstado").html("Cargando...");
			
	if(ConductorNumeroDocumento!=""){
		
		$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Conductor/acc/AccConductorVerificarExisteNumeroDocumento.php',
		data: 'ConductorNumeroDocumento='+ConductorNumeroDocumento,
		success: function(InsConductor){
			
				$("#CapConductorEstado").html("");
				
				if( InsConductor == null){
					alert("El NUM. DOCUMENTO no existe");
				}else{
					alert("El NUM. DOCUMENTO ya existe");
				}
			
			}
		});
		
	}else{
		alert("No ha ingresado un NUM. DOCUMENTO");
	}
	
}






function FncPropietarioNuevo(){

	$("#CmpPropietarioId").val("");
	
	$("#CmpPropietarioNombre").val("");				
	$("#CmpPropietarioApellido").val("");
	
	$("#CmpPropietarioDireccion").val("");
	$("#CmpPropietarioTelefono").val("");
	$("#CmpPropietarioCelular").val("");
	
	$("#CmpPropietarioNumeroDocumento").val("");
	
	
	
	
	$('#CmpPropietarioNombre').removeAttr('readonly');
	$('#CmpPropietarioApellido').removeAttr('readonly');
	
	$('#CmpPropietarioDireccion').removeAttr('readonly');
	$('#CmpPropietarioTelefono').removeAttr('readonly');
	$('#CmpPropietarioCelular').removeAttr('readonly');
	
	$('#CmpPropietarioNumeroDocumento').removeAttr('readonly');
	
}

function FncPropietarioBuscar(oCampo){

	var Dato = $("#CmpPropietario"+oCampo).val();
		
	$("#CapPropietarioEstado").html("Cargando...");
		
	if(Dato!=""){		
		
		$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Conductor/acc/AccPropietarioBuscar.php',
		data: 'Dato='+Dato+'&Campo='+oCampo,
		success: function(InsPropietario){
			
			$("#CapPropietarioEstado").html("");
			
			if(InsPropietario.ProId != null){

				$("#CmpPropietarioId").val(InsPropietario.ProId);
				
				$("#CmpPropietarioNombre").val(InsPropietario.ProNombre);				
				$("#CmpPropietarioApellido").val(InsPropietario.ProApellido);
				
				$("#CmpPropietarioDireccion").val(InsPropietario.ProDireccion);
				$("#CmpPropietarioTelefono").val(InsPropietario.ProTelefono);
				$("#CmpPropietarioCelular").val(InsPropietario.ProCelular);
				$("#CmpPropietarioNumeroDocumento").val(InsPropietario.ProNumeroDocumento);
				
				$('#CmpPropietarioNombre').attr('readonly', true);
				$('#CmpPropietarioApellido').attr('readonly', true);
				
				$('#CmpPropietarioDireccion').attr('readonly', true);
				$('#CmpPropietarioTelefono').attr('readonly', true);
				$('#CmpPropietarioCelular').attr('readonly', true);
				$('#CmpPropietarioNumeroDocumento').attr('readonly', true);
				
				
			}else{
				alert("No se encontraron datos del propietario");
			}
				
			}
		});
		
	}else{
		alert("No se encontraron datos");
	}
	
}



/*
* FUNCIONES VEHICULO
*/

function FncVehiculoNuevo(){

	$("#CmpVehiculoId").val("");	
	$("#CmpVehiculoPlaca").val("");
	$("#CmpVehiculoUnidad").val("");
				
	$("#CmpVehiculoMarca").val("");
	$("#CmpVehiculoModelo").val("");
	$("#CmpVehiculoAno").val("");
	$("#CmpVehiculoColor").val("");
				
	$("#CmpVehiculoCodigoMunicipal").val("");
	
	
	$('#CmpVehiculoId').removeAttr('readonly');
	$('#CmpVehiculoPlaca').removeAttr('readonly');
	
	$('#CmpVehiculoMarca').removeAttr('readonly');
	$('#CmpVehiculoModelo').removeAttr('readonly');
	$('#CmpVehiculoAno').removeAttr('readonly');
	$('#CmpVehiculoColor').removeAttr('readonly');
	
	$('#CmpVehiculoCodigoMunicipal').removeAttr('readonly');
	
}


/*
function FncVehiculoCargarDatos(){

	var VehiculoId = $("#CmpVehiculoId").val();

	if(VehiculoId!=""){		
		
		$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Conductor/acc/AccVehiculoCargarDatos.php',
		data: 'VehiculoId='+VehiculoId,
		success: function(InsVehiculo){
			
			if(InsVehiculo.VehId != null){

				$("#CmpVehiculoPlaca").val(InsVehiculo.VehPlaca);
				
				$("#CmpVehiculoMarca").val(InsVehiculo.VehMarca);
				$("#CmpVehiculoModelo").val(InsVehiculo.VehModelo);
				$("#CmpVehiculoAno").val(InsVehiculo.VehAno);
				$("#CmpVehiculoColor").val(InsVehiculo.VehColor);
				
				$("#CmpVehiculoCodigoMunicipal").val(InsVehiculo.VehCodigoMunicipal);
				
				
				
			}else{
				alert("No se encontraron datos de unidad");
			}
				
			}
		});
		
	}else{
//		alert("No ha ingresado un NUM. DOCUMENTO");
	}
	
}*/




function FncVehiculoBuscar(oCampo){

	console.log("#CmpVehiculo"+oCampo);
	
	var Dato = $("#CmpVehiculo"+oCampo).val();
	
	$("#CapVehiculoEstado").html("Cargando...");
	
	if(Dato!=""){		
		
		$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Conductor/acc/AccVehiculoBuscar.php',
		data: 'Dato='+Dato+'&Campo='+oCampo,
		success: function(InsVehiculo){
			
			$("#CapVehiculoEstado").html("");
				
			if(InsVehiculo.VehId != null){

				$("#CmpVehiculoUnidad").val(InsVehiculo.VehUnidad);
				$("#CmpVehiculoPlaca").val(InsVehiculo.VehPlaca);
				
				$("#CmpVehiculoMarca").val(InsVehiculo.VehMarca);
				$("#CmpVehiculoModelo").val(InsVehiculo.VehModelo);
				$("#CmpVehiculoAno").val(InsVehiculo.VehAno);
				$("#CmpVehiculoColor").val(InsVehiculo.VehColor);
				
				$("#CmpVehiculoCodigoMunicipal").val(InsVehiculo.VehCodigoMunicipal);
				$("#CmpVehiculoSOATFecha").val(InsVehiculo.VehSOATFecha);
				$("#CmpVehiculoRevisionTecnicaFecha").val(InsVehiculo.VehRevisionTecnicaFecha);

				$("#CmpPropietarioId").val(InsVehiculo.ProId);


				
				$('#CmpVehiculoMarca').attr('readonly', true);
				$('#CmpVehiculoModelo').attr('readonly', true);
				$('#CmpVehiculoAno').attr('readonly', true);
				$('#CmpVehiculoColor').attr('readonly', true);
				
				$('#CmpVehiculoCodigoMunicipal').attr('readonly', true);
				$('#CmpVehiculoSOATFecha').attr('readonly', true);
				$('#CmpVehiculoRevisionTecnicaFecha').attr('readonly', true);
				
				if(InsVehiculo.ProId!="" || InsVehiculo.ProId != null){
					FncPropietarioBuscar("Id");
				}
				
			
			}else{
				alert("No se encontraron datos del vehiculo");
			}
				
			}
		});
		
	}else{
		alert("No se encontraron datos");
	}
	
}

function FncConsultarPlaca(){
	tb_show("CONSULTA DE PLACA",'https://m.sunarp.gob.pe/mobile/m_ConsultaVehicular.aspx',this.rel);		
}

function FncConductorCargarSolo(oConductorId){
	tb_show("SINCRONIZANDO DATOS DE CONDUCTOR",'tareas/TarConductorSincronizarSolo.php?ConId='+oConductorId,this.rel);	
}


function FncConductorResetearSolo(oConductorId){
	tb_show("RESETEANDO DATOS DE EQUIPO DE CONDUCTOR",'tareas/TarConductorResetearSolo.php?ConId='+oConductorId,this.rel);	
}
