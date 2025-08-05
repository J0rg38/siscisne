<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsRolFunciones.js" ></script>

<?php

$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjRol.php');

require_once($InsPoo->MtdPaqAcceso().'ClsRol.php');

require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZona.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZonaPrivilegio.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZonaCategoria.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZonaCategoria.php');

$InsRol = new ClsRol();
$InsZona = new ClsZona();
$InsZonaPrivilegio = new ClsZonaPrivilegio();
$InsZonaCategoria = new ClsZonaCategoria();

$ResZonaCategoria = $InsZonaCategoria->MtdObtenerZonaCategorias(NULL,NULL,'ZcaId','ASC',NULL);
$ArrZonaCategorias = $ResZonaCategoria['Datos'];

$ResZona = $InsZona->MtdObtenerZonas(NULL,NULL,"ZonNombre","ASC",NULL);
$ArrZonas = $ResZona['Datos'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccRolEditar.php');


//deb($InsRol);
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsRol->RolId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        ROL</span></td>
      </tr>
      <tr>
        <td colspan="2">
      
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsRol->RolTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsRol->RolTiempoModificacion;?></span></td>
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
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsRol->RolId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre</td>
            <td><input value="<?php echo $InsRol->RolNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="250" readonly="readonly" /></td>
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
              <td colspan="2" align="right" valign="top">
                <fieldset class="EstFormularioContenedor">
                  <legend>
                    
                    </legend>
                  
                  <input disabled="disabled" onclick="javascript:FncPrivilegioSeleccionarTodo();" type="checkbox" name="CmpPrivilegioSeleccionarTodo" id="CmpPrivilegioSeleccionarTodo" />
                  Todos
                  
                  </fieldset>
              </td>
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
              <td  align="left" valign="top">
                
                
                
                <?php
				$ResZonaPrivilegio = $InsZonaPrivilegio->MtdObtenerZonaPrivilegios(NULL,NULL,"PriNombre","ASC",NULL,$DatZona->ZonId);
				$ArrZonaPrivilegios = $ResZonaPrivilegio['Datos'];
				
				$c=1;			
				?>
                
                <fieldset class="EstFormularioContenedor">
                  <legend>
                    
                    <input disabled="disabled" onclick="javascript:FncPrivilegioSeleccionarZona('<?php echo $DatZona->ZonId;?>');" type="checkbox" name="CmpPrivilegioSeleccionarZona_<?php echo $DatZona->ZonId;?>" id="CmpPrivilegioSeleccionarZona_<?php echo $DatZona->ZonId;?>" /> <!--Privilegios de  <?php echo $DatZona->ZonAlias;?>--></legend>
                  
                  
                  
                  <table border="0" cellpadding="0" cellspacing="4" class="EstFormulario">
                    <tr>
                      <?php 
				foreach($ArrZonaPrivilegios as $DatZonaPrivilegio){				
				?>
                      <td align="left" valign="top" width="150" >
                        <?php				
                    foreach($InsRol->RolZonaPrivilegio as $DatRolZonaPrivilegio ){
                        $aux = '';
                        if($DatRolZonaPrivilegio->ZprId==$DatZonaPrivilegio->ZprId){
                            $aux = 'checked="checked"';						
                            break;
                        }					
                    }				
                    ?>
                        
                        <input disabled="disabled" <?php echo $aux;?>  value="<?php echo $DatZona->ZonId;?>__<?php echo $DatZonaPrivilegio->PriId;?>" type="checkbox" name="Chk_<?php echo $DatZona->ZonId;?>__<?php echo $DatZonaPrivilegio->PriId;?>" id="Chk_<?php echo $DatZona->ZonId;?>__<?php echo $DatZonaPrivilegio->PriId;?>"  />
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
              <td colspan="2" align="left" valign="top">&nbsp;</td>
              </tr>
            <?php
			}
			?>
            

<?php
}
?>
            </table>
            </td>
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

