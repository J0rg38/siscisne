<?php
$GET_id = $_GET['Id'];
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php

include('formularios/Usuario/msj/MsjUsuario.php');


require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once('paquetes/PaqAcceso/Clases/ClsUsuarioSucursal.php');
require_once('paquetes/PaqAcceso/Clases/ClsRol.php');
require_once($InsPoo->MtdPaqEmpresa().'/ClsSucursal.php');

$InsUsuario = new ClsUsuario();
$InsRol = new ClsRol();
$InsSucursal = new ClsSucursal();


include('formularios/Usuario/acc/AccUsuarioEditar.php');

$ResRol = $InsRol->MtdObtenerRoles(NULL,NULL,"RolNombre","Asc",NULL);
$ArrRoles = $ResRol['Datos'];



$ResSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",1,NULL);
$ArrSucursales = $ResSucursal['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsUsuario->UsuId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
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
        
        </div>    <br />
        
        
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
            <td><input value="<?php echo $InsUsuario->UsuUsuario;?>"  class="EstFormularioCaja"  name="CmpUsuario" type="text" id="CmpUsuario" size="40" maxlength="255"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Contrase&ntilde;a:</td>
            <td><input value="<?php echo $InsUsuario->UsuContrasena;?>"  class="EstFormularioCaja"  name="CmpContrasena" type="password" id="CmpContrasena" size="40" maxlength="255" readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tipo:</td>
            <td>
            
            <select class="EstFormularioCombo" name="CmpRol" id="CmpRol" disabled="disabled">            
           <?php
		   foreach($ArrRoles as $DatRol){
		   ?>
		   <option value="<?php echo $DatRol->RolId;?>" <?php if($InsUsuario->RolId==$DatRol->RolId){ echo 'selected="selected"';}?>><?php echo $DatRol->RolNombre;?></option>
		   <?php
		   }
		   ?>  
			</select>            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td>


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
            
            <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
              <option <?php echo $OpcEstado1;?> value="1">Habilitado</option>
              <option <?php echo $OpcEstado2;?> value="2">Deshabilitado</option>
                        </select>			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Sucursal:</td>
            <td><select disabled="disabled" name="CmpSucursal" id="CmpSucursal" class="EstFormularioCombo">
                     <option value="0">Escoja una opcion</option>
                     <?php
					foreach($ArrSucursales as $DatSucursal){						
					?>
                    
                     <option <?php if($InsUsuario->UsuarioSucursal[0]->SucId==$DatSucursal->SucId){ echo 'selected="selected"';}?> value="<?php echo $DatSucursal->SucId;?>"><?php echo $DatSucursal->SucNombre;?></option>
                    
                     <?php
					}
					?>
                   </select></td>
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
            <td colspan="2">
            
            <?php            
if(!empty($_SESSION['SesUsuFoto'])){
	
	$extension = strtolower(pathinfo($_SESSION['SesUsuFoto'], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesUsuFoto'], '.'.$extension);  
?>

Vista Previa:<br />
  <img  src="subidos/usuario_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  
  
<?php	
}else{
?>
No hay FOTO
<?php	
}
?>
            </td>
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



	
	
	
    


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

