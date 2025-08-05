<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<?php

$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjClienteTipo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

$InsClienteTipo = new ClsClienteTipo();
$InsVehiculoMarca = new ClsVehiculoMarca();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClienteTipoEditar.php');

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


?>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsClienteTipo->LtiId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td height="25" colspan="2"><span class="EstFormularioTitulo">VER
        TIPO DE CLIENTE</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsClienteTipo->LtiTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsClienteTipo->LtiTiempoModificacion;?></span></td>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsClienteTipo->LtiId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input value="<?php echo $InsClienteTipo->LtiNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="250" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Abreviatura:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpAbreviatura" type="text" id="CmpAbreviatura" value="<?php echo $InsClienteTipo->LtiAbreviatura;?>" size="20" maxlength="45" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Margen de Utilidad: <br />
              <span class="EstFormularioSubEtiqueta">(%)</span></td>
            <td align="left" valign="top"><span id="sprytextfield6">
              <label for="CmpPorcentajeMargenUtilidad"></label>
              <input class="EstFormularioCaja" name="CmpPorcentajeMargenUtilidad" type="text" id="CmpPorcentajeMargenUtilidad" value="<?php echo number_format($InsClienteTipo->LtiPorcentajeMargenUtilidad,2);?>" size="10" maxlength="10" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Otros Costos: <br />
              <span class="EstFormularioSubEtiqueta">(%)</span></td>
            <td align="left" valign="top"><input name="CmpPorcentajeOtroCosto" type="text" class="EstFormularioCaja" id="CmpPorcentajeOtroCosto" value="<?php echo number_format($InsClienteTipo->LtiPorcentajeOtroCosto,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descuento: <br />
              <span class="EstFormularioSubEtiqueta">(%)</span></td>
            <td align="left" valign="top"><input name="CmpPorcentajeDescuento" type="text" class="EstFormularioCaja" id="CmpPorcentajeDescuento" value="<?php echo number_format($InsClienteTipo->LtiPorcentajeDescuento,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Mano de Obra: <br />
              <span class="EstFormularioSubEtiqueta">(%)</span></td>
            <td align="left" valign="top"><input name="CmpPorcentajeManoObra" type="text" class="EstFormularioCaja" id="CmpPorcentajeManoObra" value="<?php echo number_format($InsClienteTipo->LtiPorcentajeManoObra,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descripcion:</td>
            <td align="left" valign="top"><textarea name="CmpObservacion" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsClienteTipo->LtiObservacion);?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
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
        <td width="150">&nbsp;</td>
        <td width="811">&nbsp;</td>
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

