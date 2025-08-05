<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)   ){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsConductorFunciones.js" ></script>


<?php

$GET_id = $_GET['Id'];
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjConductor.php');

require_once($InsProyecto->MtdRutClases().'ClsAuditoria.php');

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
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/iconos/guardar.png" width="50" height="50" alt="[Guardar]" title="Guardar" />
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2" align="center"><span class="EstFormularioTitulo">MODIFICAR
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
        
        </div>  
        
        <br />
		<div class="EstFormularioArea">
        
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
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
            <td rowspan="31" align="left" valign="top"><iframe src="formularios/Conductor/acc/AccConductorSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrConductorSubirArchivo" name="IfrConductorSubirArchivo" scrolling="Auto"  frameborder="0" width="350" height="300"></iframe></td>
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
              <select class="EstFormularioCombo" name="CmpModalidad" id="CmpModalidad">
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
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" value="<?php echo $InsConductor->ConNumeroDocumento;?>" size="20" maxlength="9" />
              <a href="javascript:FncConductorVerificarExisteNumeroDocumento();">Verificar</a> <a target="_blank" href="http://www.reniec.gob.pe/portal/masServiciosLinea.htm#">Consultar DNI</a></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cod. Conductor:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpOtroCodigo" type="text" id="CmpOtroCodigo" value="<?php echo $InsConductor->ConOtroCodigo;?>" size="20" maxlength="8" /></td>
            <td align="left" valign="top"><div id="CapConductorEstado"></div></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><span id="sprytextfield1">
              <label>
                <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsConductor->ConNombre;?>" size="40" maxlength="250" />
                </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td align="left" valign="top">Apellidos:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpApellido" type="text" id="CmpApellido" value="<?php echo $InsConductor->ConApellido;?>" size="40" maxlength="250" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Direccion:</td>
            <td colspan="3" align="left" valign="top"><input class="EstFormularioCaja" name="CmpDireccion" type="text" id="CmpDireccion" value="<?php echo $InsConductor->ConDireccion;?>" size="70" maxlength="250" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Telefono:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpTelefono" type="text" id="CmpTelefono" value="<?php echo $InsConductor->ConTelefono;?>" size="20" maxlength="45" /></td>
            <td align="left" valign="top">Celular:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCelular" type="text" id="CmpCelular" value="<?php echo $InsConductor->ConCelular;?>" size="20" maxlength="9" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Licencia:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpNumeroBrevete" type="text" id="CmpNumeroBrevete" value="<?php echo $InsConductor->ConNumeroBrevete;?>" size="20" maxlength="45" />
              <a target="_blank" href="http://slcp.mtc.gob.pe/">Consultar Licencia</a></td>
            <td align="left" valign="top">Fecha de Expiracion:</td>
            <td align="left" valign="top"><span id="sprytextfield5">
              <label>
                <input name="CmpBreveteFechaExpiracion" type="text" class="EstFormularioCajaFecha" id="CmpBreveteFechaExpiracion" value="<?php echo $InsConductor->ConBreveteFechaExpiracion; ?>" size="15" maxlength="10" />
              </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnBreveteFechaExpiracion" name="BtnBreveteFechaExpiracion" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha de Ingreso:</td>
            <td align="left" valign="top"><span id="sprytextfield4">
              <label>
                <input name="CmpFechaInicio" type="text" class="EstFormularioCajaFecha" id="CmpFechaInicio" value="<?php echo $InsConductor->ConFechaInicio; ?>" <?php //echo (!empty($InsConductor->ConFechaInicio)?'readonly="readonly"':'');?>   size="15" maxlength="10" />
                </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Formato no valido"  /></span></span> <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaInicio" name="BtnFechaInicio" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">Fecha de Retiro: </td>
            <td align="left" valign="top"><span id="sprytextfield7">
              <label>
                <input name="CmpFechaFin" type="text" class="EstFormularioCajaFecha" id="CmpFechaFin" value="<?php echo $InsConductor->ConFechaFin; ?>" size="15" maxlength="10" />
              </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" alt="a" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="a" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFin" name="BtnFechaFin" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
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
              <select class="EstFormularioCombo" name="CmpTurno" id="CmpTurno">
                <option <?php echo $OpcTurno1;?> value="1">DIA</option>
                <option <?php echo $OpcTurno2;?> value="2">NOCHE</option>
                <option <?php echo $OpcTurno3;?> value="3">PUERTA LIBRE</option>
              </select></td>
            <td align="left" valign="top">Cuota:</td>
            <td align="left" valign="top"><span id="sprytextfield3">
              <input class="EstFormularioCaja" name="CmpCuota" type="text" id="CmpCuota" value="<?php echo number_format($InsConductor->ConCuota,2); ?>" size="10" maxlength="10" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Situacion:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpSituacion" type="text" id="CmpSituacion" value="<?php echo $InsConductor->ConSituacion;?>" size="20" maxlength="45" /></td>
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
            <td align="left" valign="top"><a  href="javascript:FncPropietarioNuevo();"><img align="absmiddle" src="imagenes/acciones/limpiar.png" alt="Limpiar" title="Limpiar datos de propietario" border="0" width="25" height=
            "25"  /></a>
              <input class="EstFormularioCaja" name="CmpPropietarioNumeroDocumento" type="text" id="CmpPropietarioNumeroDocumento" value="<?php echo $InsConductor->ProNumeroDocumento;?>" size="20" maxlength="8" />              <a href="javascript:FncConductorVerificarExisteNumeroDocumento();"></a> 
              
              <a  href="javascript:FncPropietarioBuscar('NumeroDocumento');"><img align="absmiddle" src="imagenes/acciones/buscar.gif" alt="Buscar" title="Buscar" border="0" width="25" height="25"  /></a>
              
              <a target="_blank" href="http://www.reniec.gob.pe/portal/masServiciosLinea.htm#">Consultar DNI</a>
              
              </td>
            <td align="left" valign="top"><div id="CapPropietarioEstado"></div></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombres:
              <input class="EstFormularioCaja" name="CmpPropietarioId" type="hidden" id="CmpPropietarioId" value="<?php echo $InsConductor->ProId;?>" size="40" maxlength="250" /></td>
            <td align="left" valign="top"><span id="sprytextfield1">
              <label>
                <input class="EstFormularioCaja" name="CmpPropietarioNombre" type="text" id="CmpPropietarioNombre" value="<?php echo $InsConductor->ProNombre;?>" size="40" maxlength="250" />
              </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td align="left" valign="top">Apellidos:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpPropietarioApellido" type="text" id="CmpPropietarioApellido" value="<?php echo $InsConductor->ProApellido;?>" size="40" maxlength="250" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Direccion:</td>
            <td colspan="3" align="left" valign="top"><input class="EstFormularioCaja" name="CmpPropietarioDireccion" type="text" id="CmpPropietarioDireccion" value="<?php echo $InsConductor->ProDireccion;?>" size="70" maxlength="250" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Telefono:</td>
            <td align="left" valign="top"><input name="CmpPropietarioTelefono" type="text" class="EstFormularioCaja" id="CmpPropietarioTelefono" value="<?php echo $InsConductor->ProTelefono;?>" size="20" /></td>
            <td align="left" valign="top">Celular:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpPropietarioCelular" type="text" id="CmpPropietarioCelular" value="<?php echo $InsConductor->ProCelular;?>" size="20" maxlength="9" /></td>
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
            <td align="left" valign="top">
            
            
          <!--  <input readonly="readonly"  class="EstFormularioCajaDeshabilitada" name="CmpVehiculoUnidadId" type="text" id="CmpVehiculoUnidadId" value="<?php echo $InsConductor->ConVehiculoUnidad;?><?php echo $InsConductor->ConVehiculoUnidad2;?><?php echo $InsConductor->ConVehiculoUnidad3;?>" size="15" maxlength="20" />-->
            
            

                          <a  href="javascript:FncVehiculoNuevo();"><img align="absmiddle" src="imagenes/acciones/limpiar.png" alt="Limpiar" title="Limpiar datos de unidad" border="0" width="25" height="25"  /></a>
                                      
            <select class="EstFormularioCombo" name="CmpVehiculoId" id="CmpVehiculoId">

            <option value="">Escoja una opcion</option>
              <?php
		   foreach($ArrVehiculos as $DatVehiculo){
		   ?>
              <option value="<?php echo $DatVehiculo->VehId;?>" <?php if($InsConductor->VehId==$DatVehiculo->VehId){ echo 'selected="selected"';}?>><?php echo $DatVehiculo->VehUnidad;?></option>
              <?php
		   }
		   ?>
            </select>
               <a  href="javascript:FncVehiculoBuscar('Id');"><img align="absmiddle" src="imagenes/acciones/buscar.gif" alt="Buscar" title="Buscar" border="0" width="25" height="25"  /></a>
            
            

                          
                          
                                      </td>
            <td align="left" valign="top"><div id="CapVehiculoEstado"></div></td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoUnidad" type="hidden" id="CmpVehiculoUnidad" value="<?php echo $InsConductor->VehUnidad;?>" size="40" maxlength="250" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Placa:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoPlaca" type="text" id="CmpVehiculoPlaca" value="<?php echo $InsConductor->VehPlaca;?>" size="20" maxlength="8" />
             
             
              <a target="_blank" href=" https://m.sunarp.gob.pe/mobile/m_ConsultaVehicular.aspx">Consultar Placa</a>
            <!--  
              <a href="javascript:FncConsultarPlaca();" >Consultar Placa</a>


              -->
              
              
              </td>
            <td align="left" valign="top">Codigo Municipal:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoCodigoMunicipal" type="text" id="CmpVehiculoCodigoMunicipal" value="<?php echo $InsConductor->VehCodigoMunicipal;?>" size="20" maxlength="8" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Marca:</td>
            <td><input class="EstFormularioCaja" name="CmpVehiculoMarca" type="text" id="CmpVehiculoMarca" value="<?php echo $InsConductor->VehMarca;?>" size="30" maxlength="45" /></td>
            <td>Modelo:</td>
            <td><input class="EstFormularioCaja" name="CmpVehiculoModelo" type="text" id="CmpVehiculoModelo" value="<?php echo $InsConductor->VehModelo;?>" size="30" maxlength="45" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Año:</td>
            <td><input class="EstFormularioCaja" name="CmpVehiculoAno" type="text" id="CmpVehiculoAno" value="<?php echo $InsConductor->VehAno;?>" size="10" maxlength="4" /></td>
            <td align="left" valign="top">Color:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoColor" type="text" id="CmpVehiculoColor" value="<?php echo $InsConductor->VehColor;?>" size="20" maxlength="45" /></td>
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
            <td align="left" valign="top"><span id="sprytextfield2">
              <label>
                <input name="CmpVehiculoSOATFecha" type="text" class="EstFormularioCajaFecha" id="CmpVehiculoSOATFecha" value="<?php echo $InsConductor->VehSOATFecha; ?>" size="15" maxlength="10" />
                </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnSOATFecha" name="BtnSOATFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">Fecha Venc. Rev. Tecnica:</td>
            <td align="left" valign="top"><span id="sprytextfield6">
              <label>
                <input name="CmpVehiculoRevisionTecnicaFecha" type="text" class="EstFormularioCajaFecha" id="CmpVehiculoRevisionTecnicaFecha" value="<?php echo $InsConductor->VehRevisionTecnicaFecha; ?>" size="15" maxlength="10" />
              </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnRevisionTecnicaFecha" name="BtnRevisionTecnicaFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Num. Credencial Taxi:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCredencialTaxi" type="text" id="CmpCredencialTaxi" value="<?php echo $InsConductor->ConCredencialTaxi;?>" size="20" maxlength="45" /></td>
            <td align="left" valign="top">Fecha Venc. Credencial</td>
            <td align="left" valign="top"><span id="sprytextfield8">
              <label>
                <input name="CmpCredencialTaxiFecha" type="text" class="EstFormularioCajaFecha" id="CmpCredencialTaxiFecha" value="<?php echo $InsConductor->ConCredencialTaxiFecha; ?>" size="15" maxlength="10" />
                </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" width="20" height="20" border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnCredencialTaxiFecha" name="BtnCredencialTaxiFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DE ACCESO A APLICACION/SISTEMA</span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Supervisor:</td>
            <td align="left" valign="top">
			
            
<?php
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
              <input <?php echo $OpcSupervisor1;?> type="radio" name="CmpSupervisor" id="CmpSupervisor1" value="1" checked="checked" />
              Si
              <input <?php echo $OpcSupervisor2;?> type="radio" name="CmpSupervisor" id="CmpSupervisor2" value="2" />
              No 
<?php	
}else{
?>	
No tienes permisos suficientes
	<input type="hidden" name="CmpSupervisor" id="CmpSupervisor" value="<?php echo $InsConductor->ConSupervisor;?>" />
<?php	
}
?>
			
              
              
              </td>
            <td align="left" valign="top">Nivel:</td>
            <td align="left" valign="top">
			
			
			<?php
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
              <input <?php echo $OpcSupervisorNivel1;?> type="radio" name="CmpSupervisorNivel" id="CmpSupervisorNivel1" value="1" checked="checked" />
              Normal
  <input <?php echo $OpcSupervisorNivel2;?> type="radio" name="CmpSupervisorNivel" id="CmpSupervisorNivel2" value="2" />
              De Turno 
<?php
}else{
?>
No tienes permisos suficientes
	<input type="hidden" name="CmpSupervisorNivel" id="CmpSupervisorNivel" value="<?php echo $InsConductor->ConSupervisorNivel;?>" />
<?php	
}
?>

</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Correo Electronico: </td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpEmail" type="text" id="CmpEmail" value="<?php echo $InsConductor->ConEmail;?>" size="45" maxlength="500" /></td>
            <td align="left" valign="top">Contraseña de aplicacion:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpClave" type="text" id="CmpClave" value="<?php echo $InsConductor->ConClave;?>" size="20" maxlength="10" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Modelo Equipo:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpEquipoModelo" type="text" id="CmpEquipoModelo" value="<?php echo $InsConductor->ConEquipoModelo;?>" size="30" maxlength="45" /></td>
            <td align="left" valign="top">Observacion:</td>
            <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="3" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsConductor->ConObservacion;?></textarea></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Identificador de equipo:</td>
            <td align="left" valign="top"><input name="CmpConductorIdentificador" type="text" class="EstFormularioCajaDeshabilitada" id="CmpConductorIdentificador" value="<?php echo $InsConductor->ConIdentificador;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td colspan="2">&nbsp;</td>
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
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Habilitado</option>
                <option <?php echo $OpcEstado2;?> value="2">Deshabilitado</option>
                <option <?php echo $OpcEstado3;?> value="3">Retirado</option>
                </select>
              
              </td>
            <td colspan="2">
              
              
  <a href="javascript:FncConductorResetearSolo('<?php echo $InsConductor->ConId?>');" ><img src="imagenes/resetear.png" width="19" height="19" border="0" title="Resetear" alt="[Resetear]"   /> Resetear Celular</a>
              
              
  <a href="javascript:FncConductorCargarSolo('<?php echo $InsConductor->ConId?>');" ><img src="imagenes/sincronizar.png" width="19" height="19" border="0" title="Sincronizar" alt="[Sincronizar]"   />Sincronizar Datos</a>
              
              
  <!--
              <a href="tareas/TarCargarConductorSolo.php?ConId=<?php echo $dat->ConId?>" target="_blank"><img src="imagenes/sincronizar.png" width="19" height="19" border="0" title="Sincronizar" alt="[Sincronizar]"   />Sincronizar Datos</a>
              
              <a href="tareas/TarCargarConductorResetear.php?ConId=<?php echo $dat->ConId?>" target="_blank"><img src="imagenes/resetear.png" width="19" height="19" border="0" title="Resetear" alt="[Resetear]"   />Resetear Celular</a>     -->       </td>
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



	
	
	
    

</form>

<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpCredencialTaxiFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnCredencialTaxiFecha"// el id del botón que  
	});
</script>


<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpVehiculoSOATFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnSOATFecha"// el id del botón que  
	});
</script>


<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpVehiculoRevisionTecnicaFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnRevisionTecnicaFecha"// el id del botón que  
	});
</script>

<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpBreveteFechaExpiracion",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnBreveteFechaExpiracion"// el id del botón que  
	});
</script>	
<script type="text/javascript">
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del botón que  
	});
</script>	
<?php
//if(empty($InsConductor->ConFechaInicio)){
?> 
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del botón que  
	});
</script>
<?php
//}
?>


<script type="text/javascript">
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
<?php
$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();
?>
<?php

}else{
echo ERR_GEN_101;
}

if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
		
}
?>