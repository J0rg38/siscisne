<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoMarcaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCampanaFunciones.js" ></script>

<?php
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCampana.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsCampana.php');
require_once($InsPoo->MtdPaqActividad().'ClsCampanaVehiculo.php');
//INSTANCIAS
$InsCampana = new ClsCampana();

if (isset($_SESSION['InsCampanaVehiculo'.$Identificador])){	
	$_SESSION['InsCampanaVehiculo'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCampanaVehiculo'.$Identificador]);
}

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCampanaEditar.php');

?><script type="text/javascript" >

var VehiculoMarcaHabilitado = 2;
var VehiculoModeloHabilitado = 2;
var VehiculoVersionHabilitado = 2;


$().ready(function() {
	
	FncVehiculoMarcasCargar();
	
});

</script>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsCampana->CamId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            
                       <?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?> 
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        CAMPAÑA</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCampana->CamTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCampana->CamTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo:</td>
            <td align="left" valign="top">
              
              <input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCampana->CamId;?>" size="15" maxlength="20"  readonly="readonly"/>            </td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Campaña:</td>
            <td align="left" valign="top"><input name="CmpCodigo" type="text" class="EstFormularioCaja" id="CmpCodigo" value="<?php echo $InsCampana->CamCodigo;?>" size="20" maxlength="20"/></td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input name="CmpNombre" type="text"  class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsCampana->CamNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha  Inicio:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFechaInicio" type="text" class="EstFormularioCajaFecha" id="CmpFechaInicio" value="<?php  echo $InsCampana->CamFechaInicio; ?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td align="left" valign="top">Fecha  Fin:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFechaFin" type="text" class="EstFormularioCajaFecha" id="CmpFechaFin" value="<?php  echo $InsCampana->CamFechaFin; ?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cod. Operacion:</td>
            <td align="left" valign="top"><input name="CmpOperacionCodigo" type="text" class="EstFormularioCaja" id="CmpOperacionCodigo" value="<?php echo $InsCampana->CamOperacionCodigo;?>" size="20" maxlength="20"/></td>
            <td align="left" valign="top">Tiempo Operacion:<br />
              <span class="EstFormularioSubEtiqueta">(hrs)</span></td>
            <td align="left" valign="top"><input name="CmpOperacionTiempo" type="text" class="EstFormularioCaja" id="CmpOperacionTiempo" value="<?php echo number_format($InsCampana->CamOperacionTiempo,2);?>" size="20" maxlength="20"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Boletin:</td>
            <td align="left" valign="top"><input name="CmpBoletinCodigo" type="text" class="EstFormularioCaja" id="CmpBoletinCodigo" value="<?php echo $InsCampana->CamBoletinCodigo;?>" size="20" maxlength="20" readonly="readonly"/></td>
            <td align="left" valign="top">Observacion:</td>
            <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsCampana->CamObservacion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Marca:
              <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsCampana->VmaId;?>" size="3" /></td>
            <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" disabled="disabled" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsCampana->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td>Modelo:
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsCampana->VmoId;?>" size="3" /></td>
            <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">Archivo de Listado de Vehiculos:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">
          <div class="EstCapCampanaArchivo1">
          
          
          
  
<hr />
Archivo actual: <b><?php echo $InsCampana->CamArchivo1;?></b>
<hr />


<?php
 
?>


<?php
if(!empty($InsCampana->CampanaVehiculo)){
	foreach($InsCampana->CampanaVehiculo as $DatCampanaVehiculo){
?>

	<?php echo $DatCampanaVehiculo->AveVIN;?><br />

<?php
	}	
}else{
?>
No se encontraron registros.
<?php	
}
?>



          </div>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">Archivo de Boletin:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">
            <div class="EstCapCampanaBoletin">
            Boletin Actual: <b><a target="_blank" href="subidos/campana/<?php echo $InsCampana->CamBoletin ?>"><?php echo $InsCampana->CamBoletin ?></a></b>
            </div>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
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
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>


