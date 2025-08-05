<?php
$GET_id = $_GET['Id'];
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form) || $GET_id==$_SESSION['SesionId']  ){
?>

<?php

$Registro = false;

include($InsProyecto->MtdFormulariosMsj('Usuario').'MsjUsuario.php');

require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRol.php');

$InsUsuario = new ClsUsuario();
$InsRol = new ClsRol();

include($InsProyecto->MtdFormulariosAcc('Usuario').'AccUsuarioEditar.php');

$ResRol = $InsRol->MtdObtenerRoles(NULL,NULL,"RolNombre","Asc",NULL);
$ArrRoles = $ResRol['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>




<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">


<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        USUARIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsUsuario->UsuTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsUsuario->UsuTiempoModificacion;?></span></td>
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
            <td>C&oacute;digo:</td>
            <td><input readonly="readonly"  class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsUsuario->UsuId;?>" size="15" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Usuario:</td>
            <td><span id="sprytextfield1">
              <label>
              <input class="EstFormularioCaja" name="CmpUsuario" type="text" id="CmpUsuario" value="<?php echo $InsUsuario->UsuUsuario;?>" size="40" maxlength="250" />
              </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Contrase&ntilde;a:</td>
            <td><span id="sprytextfield2">
              <label>
              <input class="EstFormularioCaja" name="CmpContrasena" type="password" id="CmpContrasena" value="<?php echo $InsUsuario->UsuContrasena;?>" size="40" maxlength="250" />
              </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Rol:</td>
            <td>
            
             <?php
			if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Rol")){
			?>
            
            
<span id="spryselect1">
 <select class="EstFormularioCombo" name="CmpRol" id="CmpRol">            
           <?php
		   foreach($ArrRoles as $DatRol){
		   ?>
		   <option value="<?php echo $DatRol->RolId;?>" <?php if($InsUsuario->RolId==$DatRol->RolId){ echo 'selected="selected"';}?>><?php echo $DatRol->RolNombre;?></option>
		   <?php
		   }
		   ?>  
			</select>     
			<span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span>
            
            
                                        
            
            	<?php
		  }else{
		  
		  ?> 
            
                <input type="hidden" name="CmpRol" id="CmpRol" value="<?php echo $InsUsuario->RolId;?>" />
          <?php
		  }
		  ?>            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td>
              
              <?php
			if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Estado")){
			?>
              
              <?php
			switch($InsUsuario->UsuEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              
              
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Habilitado</option>
                <option <?php echo $OpcEstado2;?> value="2">Deshabilitado</option>
                </select>      
              
              <?php
		  }else{
		  
		  ?>          
              <input type="hidden" name="CmpEstado" id="CmpEstado" value="<?php echo $InsUsuario->UsuEstado;?>" />
              <?php
		  }
		  ?>			</td>
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
            <td>Foto:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><iframe src="formularios/Usuario/acc/AccUsuarioSubirArchivo.php" id="IfrUsuarioSubirArchivo" name="IfrUsuarioSubirArchivo" scrolling="Auto"  frameborder="0" width="400" height="500"></iframe></td>
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
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
    
    
</div>



	
	
	
    

</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
</script>

<?php
}else{
	echo ERR_GEN_101;
}

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
?>