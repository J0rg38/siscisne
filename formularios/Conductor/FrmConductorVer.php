<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsConductorFunciones.js" ></script>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjConductor.php');

require_once($InsProyecto->MtdRutClases().'ClsConductor.php');
require_once($InsProyecto->MtdRutClases().'ClsConductorActividad.php');
require_once($InsProyecto->MtdRutClases().'ClsVehiculo.php');
require_once($InsProyecto->MtdRutClases().'ClsPropietario.php');

$InsConductor = new ClsConductor();
$InsVehiculo = new ClsVehiculo();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccConductorEditar.php');

$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos(NULL,NULL,"VehUnidad","Asc",NULL);
$ArrVehiculos = $ResVehiculo['Datos'];


?>
<div class="EstCapMenu">
<?php
if($PrivilegioEditar){
?>           
	<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Editar&Id=<?php echo $InsConductor->ConId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" /></a></div>
<?php
}
?>  
</div>

<div class="EstCapContenido">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2" align="center"><span class="EstFormularioTitulo">VISUALIZAR
        CONDUCTOR</span></td>
    </tr>
      <tr>
        <td colspan="2">
      
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsConductor->ConTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsConductor->ConTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>    <br />
        
        
		<div class="EstFormularioArea">
        
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo Interno:</td>
            <td align="left" valign="top"><input readonly="readonly"  class="EstFormularioCajaDeshabilitada" name="CmpId" type="text" id="CmpId" value="<?php echo $InsConductor->ConId;?>" size="15" maxlength="20" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td rowspan="31" align="left" valign="top">
            
            
<?php
if(!empty($_SESSION['SesConFoto'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesConFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesConFoto'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />

  
	<img  src="subidos/conductor_fotos/<?php echo $nombre_base.".".$extension;?>" width="150" height="180" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
<?php	
}else{
?>
No hay FOTO
<?php	
}
?>            </td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DEL CONDUCTOR</span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Modalidad:</td>
            <td align="left" valign="top">
			
			<?php
			switch($InsConductor->ConModalidad){

				case "APP 114":
					$OpcModalidad1 = 'selected="selected"';
				break;

				case "RT 114":
					$OpcModalidad2 = 'selected="selected"';
				break;

			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpModalidad" id="CmpModalidad">
                <option "" value="">Escoja una opcion</option>
                <option <?php echo $OpcModalidad1;?> value="APP 114">APP 114</option>
                <option <?php echo $OpcModalidad2;?> value="RT 114">RT 114</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Num. Doc.:</td>
            <td align="left" valign="top"><input name="CmpNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpNumeroDocumento" value="<?php echo $InsConductor->ConNumeroDocumento;?>" size="20" maxlength="9" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cod. Conductor:</td>
            <td align="left" valign="top"><input name="CmpOtroCodigo" type="text" class="EstFormularioCaja" id="CmpOtroCodigo" value="<?php echo $InsConductor->ConOtroCodigo;?>" size="20" maxlength="8" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input value="<?php echo $InsConductor->ConNombre;?>"  class="EstFormularioCaja"  name="CmpConductor" type="text" id="CmpConductor" size="40" maxlength="255"  readonly="readonly"/></td>
            <td align="left" valign="top">Apellidos:</td>
            <td align="left" valign="top"><input name="CmpApellido" type="text" class="EstFormularioCaja" id="CmpApellido" value="<?php echo $InsConductor->ConApellido;?>" size="40" maxlength="250" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Direccion:</td>
            <td colspan="3" align="left" valign="top"><input name="CmpDireccion" type="text" class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsConductor->ConDireccion;?>" size="70" maxlength="250" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Telefono:</td>
            <td align="left" valign="top"><input name="CmpTelefono" type="text" class="EstFormularioCaja" id="CmpTelefono" value="<?php echo $InsConductor->ConTelefono;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">Celular:</td>
            <td align="left" valign="top"><input name="CmpCelular" type="text" class="EstFormularioCaja" id="CmpCelular" value="<?php echo $InsConductor->ConCelular;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Licencia:</td>
            <td align="left" valign="top"><input name="CmpNumeroBrevete" type="text" class="EstFormularioCaja" id="CmpNumeroBrevete" value="<?php echo $InsConductor->ConNumeroBrevete;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">Fecha de Expiracion:</td>
            <td align="left" valign="top"><input name="CmpBreveteFechaExpiracion" type="text" class="EstFormularioCajaFecha" id="CmpBreveteFechaExpiracion" value="<?php echo $InsConductor->ConBreveteFechaExpiracion; ?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha de Ingreso:</td>
            <td align="left" valign="top"><input name="CmpFechaInicio" type="text" class="EstFormularioCajaFecha" id="CmpFechaInicio" value="<?php echo $InsConductor->ConFechaInicio; ?>" size="15" maxlength="10" /></td>
            <td align="left" valign="top">Fecha de Retiro: </td>
            <td align="left" valign="top"><input name="CmpFechaFin" type="text" class="EstFormularioCajaFecha" id="CmpFechaFin" value="<?php echo $InsConductor->ConFechaFin; ?>" size="15" maxlength="10" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Turno:</td>
            <td align="left" valign="top"><?php
			switch($InsConductor->ConTurno){
				case 1:
					$OpcTurno1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcTurno2 = 'selected="selected"';
				break;
				
				case 3:
					$OpcTurno3 = 'selected="selected"';
				break;


			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpTurno" id="CmpTurno">
                <option <?php echo $OpcTurno1;?> value="1">DIA</option>
                <option <?php echo $OpcTurno2;?> value="2">NOCHE</option>
                <option <?php echo $OpcTurno3;?> value="3">PUERTA LIBRE</option>
              </select></td>
            <td align="left" valign="top">Cuota:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCuota" type="text" id="CmpCuota" value="<?php echo number_format($InsConductor->ConCuota,2); ?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Situacion:</td>
            <td align="left" valign="top"><input name="CmpSituacion" type="text" class="EstFormularioCaja" id="CmpSituacion" value="<?php echo $InsConductor->ConSituacion;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DEL PROPIETARIO</span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Num. Doc.:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpPropietarioNumeroDocumento" type="text" id="CmpPropietarioNumeroDocumento" value="<?php echo $InsConductor->ProNumeroDocumento;?>" size="20" maxlength="20" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombres:
              <input class="EstFormularioCaja" name="CmpPropietarioId" type="hidden" id="CmpPropietarioId" value="<?php echo $InsConductor->ProNombre;?>" size="40" maxlength="250" /></td>
            <td align="left" valign="top"><input name="CmpPropietarioNombre" type="text" class="EstFormularioCaja" id="CmpPropietarioNombre" value="<?php echo $InsConductor->ProNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
            <td align="left" valign="top">Apellidos:</td>
            <td align="left" valign="top"><input name="CmpPropietarioApellido" type="text" class="EstFormularioCaja" id="CmpPropietarioApellido" value="<?php echo $InsConductor->ProApellido;?>" size="40" maxlength="250" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Direccion:</td>
            <td colspan="3" align="left" valign="top"><input name="CmpPropietarioDireccion" type="text" class="EstFormularioCaja" id="CmpPropietarioDireccion" value="<?php echo $InsConductor->ProDireccion;?>" size="70" maxlength="250" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Telefono:</td>
            <td align="left" valign="top"><input name="CmpPropietarioTelefono" type="text" class="EstFormularioCaja" id="CmpPropietarioTelefono" value="<?php echo $InsConductor->ProTelefono;?>" size="20" readonly="readonly" /></td>
            <td align="left" valign="top">Celular:</td>
            <td align="left" valign="top"><input name="CmpPropietarioCelular" type="text" class="EstFormularioCaja" id="CmpPropietarioCelular" value="<?php echo $InsConductor->ProCelular;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DE LA UNIDAD</span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Unidad Asignada: </td>
            <td align="left" valign="top"><!--  <input readonly="readonly"  class="EstFormularioCajaDeshabilitada" name="CmpVehiculoId" type="text" id="CmpVehiculoId" value="<?php echo $InsConductor->ConVehiculoUnidad;?><?php echo $InsConductor->ConVehiculoUnidad2;?><?php echo $InsConductor->ConVehiculoUnidad3;?>" size="15" maxlength="20" />-->
              <select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoId" id="CmpVehiculoId">
                <option value="">Escoja una opcion</option>
                <?php
		   foreach($ArrVehiculos as $DatVehiculo){
		   ?>
                <option value="<?php echo $DatVehiculo->VehId;?>" <?php if($InsConductor->VehId==$DatVehiculo->VehId){ echo 'selected="selected"';}?>><?php echo $DatVehiculo->VehUnidad;?></option>
                <?php
		   }
		   ?>
              </select></td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoUnidad" type="hidden" id="CmpVehiculoUnidad" value="<?php echo $InsConductor->VehUnidad;?>" size="40" maxlength="250" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Placa:</td>
            <td align="left" valign="top"><input name="CmpVehiculoPlaca" type="text" class="EstFormularioCaja" id="CmpVehiculoPlaca" value="<?php echo $InsConductor->VehPlaca;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">Codigo Municipal:</td>
            <td align="left" valign="top"><input name="CmpVehiculoCodigoMunicipal" type="text" class="EstFormularioCaja" id="CmpVehiculoCodigoMunicipal" value="<?php echo $InsConductor->VehCodigoMunicipal;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Marca:</td>
            <td><input name="CmpVehiculoMarca" type="text" class="EstFormularioCaja" id="CmpVehiculoMarca" value="<?php echo $InsConductor->VehMarca;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td>Modelo:</td>
            <td><input name="CmpVehiculoModelo" type="text" class="EstFormularioCaja" id="CmpVehiculoModelo" value="<?php echo $InsConductor->VehModelo;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Año:</td>
            <td><input name="CmpVehiculoAno" type="text" class="EstFormularioCaja" id="CmpVehiculoAno" value="<?php echo $InsConductor->VehAno;?>" size="10" maxlength="4" readonly="readonly" /></td>
            <td align="left" valign="top">Color:</td>
            <td align="left" valign="top"><input name="CmpVehiculoColor" type="text" class="EstFormularioCaja" id="CmpVehiculoColor" value="<?php echo $InsConductor->VehColor;?>" size="20" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><span class="EstFormularioSubTitulo">DOCUMENTOS</span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha Venc. SOAT:</td>
            <td align="left" valign="top"><input name="CmpVehiculoSOATFecha" type="text" class="EstFormularioCajaFecha" id="CmpVehiculoSOATFecha" value="<?php echo $InsConductor->VehSOATFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">Fecha Venc. Rev. Tecnica:</td>
            <td align="left" valign="top"><input name="CmpVehiculoRevisionTecnicaFecha" type="text" class="EstFormularioCajaFecha" id="CmpVehiculoRevisionTecnicaFecha" value="<?php echo $InsConductor->VehRevisionTecnicaFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Num. Credencial Taxi:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCredencialTaxi" type="text" id="CmpCredencialTaxi" value="<?php echo $InsConductor->ConCredencialTaxi;?>" size="20" maxlength="45" /></td>
            <td align="left" valign="top">Fecha Venc. Credencial</td>
            <td align="left" valign="top"><input name="CmpCredencialTaxiFecha" type="text" class="EstFormularioCajaFecha" id="CmpCredencialTaxiFecha" value="<?php echo $InsConductor->ConCredencialTaxiFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><span class="EstFormularioSubTitulo">DATOS DE ACCESO A APLICACION/SISTEMA</span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Supervisor:</td>
            <td align="left" valign="top"><?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"CambiarSupervisor")   ){
?>
              <?php
switch($InsConductor->ConSupervisor){
	case "1":
		$OpcSupervisor1 = 'checked="checked"';
	break;
	
	case "2":
		$OpcSupervisor2 = 'checked="checked"';
	break;
}
?>
              <input disabled="disabled" <?php echo $OpcSupervisor1;?> type="radio" name="CmpSupervisor" id="CmpSupervisor1" value="1" checked="checked" />
              Si
  <input disabled="disabled" <?php echo $OpcSupervisor2;?> type="radio" name="CmpSupervisor" id="CmpSupervisor2" value="2" />
              No
  <?php	
}else{
?>
              No tienes permisos suficientes
  <input type="hidden" name="CmpSupervisor" id="CmpSupervisor" value="<?php echo $InsConductor->ConSupervisor;?>" />
  <?php	
}
?></td>
            <td align="left" valign="top">Nivel:</td>
            <td align="left" valign="top"><?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"CambiarSupervisor")   ){
?>
              <?php
switch($InsConductor->ConSupervisorNivel){
	case "1":
		$OpcSupervisorNivel1 = 'checked="checked"';
	break;
	
	case "2":
		$OpcSupervisorNivel2 = 'checked="checked"';
	break;
}
?>
              <input disabled="disabled" <?php echo $OpcSupervisorNivel1;?> type="radio" name="CmpSupervisorNivel" id="CmpSupervisorNivel1" value="1" checked="checked" />
              Normal
  <input disabled="disabled" <?php echo $OpcSupervisorNivel2;?> type="radio" name="CmpSupervisorNivel" id="CmpSupervisorNivel2" value="2" />
              De Turno
  <?php
}else{
?>
              No tienes permisos suficientes
  <input type="hidden" name="CmpSupervisorNivel" id="CmpSupervisorNivel" value="<?php echo $InsConductor->ConSupervisorNivel;?>" />
  <?php	
}
?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Correo Electronico: </td>
            <td align="left" valign="top"><input readonly="readonly" class="EstFormularioCaja" name="CmpEmail" type="text" id="CmpEmail" value="<?php echo $InsConductor->ConEmail;?>" size="45" maxlength="500" /></td>
            <td align="left" valign="top">Contraseña de aplicacion:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpClave" type="text" id="CmpClave" value="<?php echo $InsConductor->ConClave;?>" size="20" maxlength="10" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Modelo Equipo:</td>
            <td align="left" valign="top"><input name="CmpEquipoModelo" type="text" class="EstFormularioCaja" id="CmpEquipoModelo" value="<?php echo $InsConductor->ConEquipoModelo;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">Observacion:</td>
            <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="3" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsConductor->ConObservacion;?></textarea></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Identificador de equipo:</td>
            <td align="left" valign="top"><input name="CmpConductorIdentificador" type="text" class="EstFormularioCajaDeshabilitada" id="CmpConductorIdentificador" value="<?php echo $InsConductor->ConIdentificador;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsConductor->ConEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;
				
				
				case 3:
					$OpcEstado3 = 'selected="selected"';
				break;

			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Habilitado</option>
                <option <?php echo $OpcEstado2;?> value="2">Deshabilitado</option>
                <option <?php echo $OpcEstado3;?> value="3">Retirado</option>
              </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </table>
        
        </div>
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
    
    
</div>



	
	
	
    
<?php
$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();
?>

<?php
}else{
echo ERR_GEN_101;
}
?>
