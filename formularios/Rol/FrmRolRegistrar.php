<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsRolFunciones.js" ></script>

<?php

$Registro = false;
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjRol.php');


require_once($InsPoo->MtdPaqAcceso().'ClsRol.php');

require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZona.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZonaPrivilegio.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZonaCategoria.php');

$InsRol = new ClsRol();
$InsZona = new ClsZona();
$InsZonaPrivilegio = new ClsZonaPrivilegio();
$InsZonaCategoria = new ClsZonaCategoria();

$ResZonaCategoria = $InsZonaCategoria->MtdObtenerZonaCategorias(NULL,NULL,'ZcaId','ASC',NULL);
$ArrZonaCategorias = $ResZonaCategoria['Datos'];

$ResZona = $InsZona->MtdObtenerZonas(NULL,NULL,"ZonNombre","ASC",NULL);
$ArrZonas = $ResZona['Datos'];

$InsRol->RolZonaPrivilegio = array();	


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccRolRegistrar.php');
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<form id="FrmRol" name="FrmRol" method="post" action="#" enctype="multipart/form-data">

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        ROL</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
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
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsRol->RolId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre</td>
            <td>
              <span id="sprytextfield1">
                <label>
                  <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsRol->RolNombre;?>" size="40" maxlength="250" />
                  </label>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
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
            <td colspan="2">
            
           
           
           
           
            <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">
               <thead>
            </thead>
            
                        <tr>
              <td align="right" valign="top" colspan="2" > 
              
              <fieldset class="EstFormularioContenedor">
                  <legend>
                    
                    </legend>
                  
                  <input onclick="javascript:FncPrivilegioSeleccionarTodo();" type="checkbox" name="CmpPrivilegioSeleccionarTodo" id="CmpPrivilegioSeleccionarTodo" />
                  Todos
                  
                  </fieldset></td>
              </tr>
       
<?php
foreach($ArrZonaCategorias as $DatZonaCategoria){
?>


           <tr>
              <td align="right" valign="top" colspan="2" > 
              
              <fieldset class="EstFormularioContenedor">
                  <legend>
                    
                    </legend>

<span class="EstFormularioTitulo">
<?php 
echo $DatZonaCategoria->ZcaNombre;
?>
</span>
                  
                  </fieldset>
                  
                  
                  </td>
              </tr>
              

<?php
//MtdObtenerZonas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ZonId',$oSentido = 'Desc',$oPaginacion = '0,10',$oZonaCategoria=NULL)
$ResZona = $InsZona->MtdObtenerZonas(NULL,NULL,"ZonNombre","ASC",NULL,$DatZonaCategoria->ZcaId);
$ArrZonas = $ResZona['Datos'];
?>
            <?php
			foreach($ArrZonas as $DatZona){
			?>
         

            <tr>
            <td>

             
             <span title="<?php echo $DatZona->ZonNombre;?>"><?php echo $DatZona->ZonAlias;?></span>

            </td>
              <td align="left" valign="top">
                
                <?php
				$ResZonaPrivilegio = $InsZonaPrivilegio->MtdObtenerZonaPrivilegios(NULL,NULL,"PriNombre","ASC",NULL,$DatZona->ZonId);
				$ArrZonaPrivilegios = $ResZonaPrivilegio['Datos'];
				
				//deb($ArrZonaPrivilegios);
				
				$c=1;			
				?>
                
                <fieldset class="EstFormularioContenedor">
                  <legend>
                    
                    <input onclick="javascript:FncPrivilegioSeleccionarZona('<?php echo $DatZona->ZonId;?>');" type="checkbox" name="CmpPrivilegioSeleccionarZona_<?php echo $DatZona->ZonId;?>" id="CmpPrivilegioSeleccionarZona_<?php echo $DatZona->ZonId;?>" /> <!--Privilegios de  <?php echo $DatZona->ZonAlias;?>--></legend>
                  
                  <table border="0" cellpadding="0" cellspacing="4"  class="EstFormulario">
                    <tr>
                      <?php 
				foreach($ArrZonaPrivilegios as $DatZonaPrivilegio){
				?>
                      <td align="left" valign="top" width="150" >
                        
                        <?php		
			  
			 // deb($InsRol->RolZonaPrivilegio);	
			  
			  	if(is_array($InsRol->RolZonaPrivilegio)){	
					foreach($InsRol->RolZonaPrivilegio as $DatRolZonaPrivilegio ){
	
						$aux = '';
						if($DatRolZonaPrivilegio->ZprId==$DatZonaPrivilegio->ZprId){
							$aux = 'checked="checked"';						
							break;
						}					
						
					}
				}				
				?>
                        
                        <input  <?php echo $aux;?>   value="<?php echo $DatZona->ZonId;?>__<?php echo $DatZonaPrivilegio->PriId;?>" type="checkbox" name="Chk_<?php echo $DatZona->ZonId;?>__<?php echo $DatZonaPrivilegio->PriId;?>" id="Chk_<?php echo $DatZona->ZonId;?>__<?php echo $DatZonaPrivilegio->PriId;?>" />
                        
                        
                        <?php echo $DatZonaPrivilegio->PriAlias;?>                </td>
                      
                      <?php				
                    if($c%5==0){
                    ?>
                      </tr><tr>
                        <?php
                    }
                    ?>                
                        
                        
                        <?php
					$c++;
				}
				?>
                        </tr>
                    </table>               
                  
                  
                  </fieldset>
                
              </td>            
            </tr>
            <tr>
            <td colspan="2">&nbsp;
            
            </td>
            </tr>
             <?php
			}
			?>
            
            
            
<?php
}
?>       

            
            
            
            
            </table>            </td>
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
//-->
</script>

<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
