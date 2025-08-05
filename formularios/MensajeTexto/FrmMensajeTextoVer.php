<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"MensajeTexto","Ver")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsMensajeTextoFunciones.js" ></script>
<!-- ARCHIVO DE FUNCIONES JS -->

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"MensajeTexto","Editar"))?true:false;?>

<?php
//VARIABLES
$GET_id = $_GET['Id'];


//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjMensajeTexto.php');
//CLASES
require_once($InsPoo->MtdPaqAcceso().'ClsMensajeTexto.php');

//INSTANCIAS
$InsMensajeTexto = new ClsMensajeTexto();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccMensajeTextoEditar.php');

?>


<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=AbonoEditar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsMensajeTexto->MteId;?>&CmtId=<?php echo $GET_CmtId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        MENSAJE DE TEXTO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsMensajeTexto->MteTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsMensajeTexto->MteTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        <br />
        


    
<ul class="tabs">
    <li><a href="#tab1">Mensaje</a></li>


</ul>
<div class="tab_container">
    <div id="tab1" class="tab_content">
    <!--Content-->     
    
    
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><span class="EstFormularioSubTitulo">Datos del Mensaje de Texto
              <input type="hidden" name="Guardar" id="Guardar"   />
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
            </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo Interno:              </td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsMensajeTexto->MteId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield1">
              <label>
                <input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" tabindex="6" value="<?php echo $InsMensajeTexto->MteFecha; ?>" size="10" maxlength="10" readonly="readonly" />
                </label>
              </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Destinatario:</td>
            <td align="left" valign="top"><input name="CmpDestino" type="text" class="EstFormularioCaja" id="CmpDestino"   tabindex="2" value="<?php echo $InsMensajeTexto->MteDestino;?>" size="45" maxlength="255" readonly="readonly" <?php if(!empty($InsMensajeTexto->CmtId)){ echo 'readonly="readonly"';} ?>  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Contenido:</td>
            <td align="left" valign="top"><textarea name="CmpContenido" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpContenido"><?php echo $InsMensajeTexto->MteContenido;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsMensajeTexto->MteEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
	
				case 3:
					$OpcEstado3 = 'selected="selected"';
				break;
				
			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Expirado</option>
                <option <?php echo $OpcEstado3;?> value="3">Vigente</option>
              </select></td>
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

	</div>
    
    
    
    
    
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


