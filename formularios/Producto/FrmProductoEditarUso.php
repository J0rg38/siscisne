<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProductoCodigoReemplazoFunciones.js" ></script>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProducto.css');
</style>

<?php

$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();
$InsUnidadMedida = new ClsUnidadMedida();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();


$ResVehiculoVersiones = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,NULL,NULL);
$ArrVehiculoVersiones = $ResVehiculoVersiones['Datos'];

if (isset($_SESSION['InsProductoCodigoReemplazo'.$Identificador])){	
	$_SESSION['InsProductoCodigoReemplazo'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsProductoCodigoReemplazo'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProductoEditarUso.php');

$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


?>





<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
$(document).ready(function (){
	
/*
CARGAS INICIALES
*/	

FncEstablecerProductoUso();

	
});

</script>



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
	




<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">EDITAR USO DEL PRODUCTO</span></td>
      </tr>
      <tr>
        <td>
        
        
                              
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProducto->ProTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div>
        
          <br />
        
		
<ul class="tabs">

    <li><a href="#tab1">Uso</a></li>

</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

	   
     
       
       <table border="0" cellpadding="2" cellspacing="2">
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">
			<span class="EstFormularioSubTitulo">
			Datos del Producto			</span>			<input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsProducto->ProId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Original:</td>
            <td align="left" valign="top"><input readonly="readonly" value="<?php echo $InsProducto->ProCodigoOriginal;?>"  class="EstFormularioCaja"  name="CmpCodigoOriginal" type="text" id="CmpCodigoOriginal" size="30" maxlength="45" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Codigo Alternativo:</td>
            <td align="left" valign="top"><input readonly="readonly"  value="<?php echo $InsProducto->ProCodigoAlternativo;?>"  class="EstFormularioCaja"  name="CmpCodigoAlternativo" type="text" id="CmpCodigoAlternativo" size="30" maxlength="45" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input readonly="readonly" name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsProducto->ProNombre;?>" size="40" maxlength="200"></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          </table>
		</div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >

			<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
			<tr>
                <td>&nbsp;</td>
                <td>
                  
                  <span class="EstFormularioSubTitulo">
                    Uso</span>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
			</tr>
			
			<tr>
			  <td>&nbsp;</td>
			  <td colspan="3" align="left" valign="top">
			  
<input type="checkbox" name="CmpValidarUso" id="CmpValidarUso" value="2" <?php echo (($InsProducto->ProValidarUso==2)?'checked="checked"':'');?>  /> Este producto puede ser utilizado por cualquier modelo y a&ntilde;o.			  </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="center" valign="top" bgcolor="#CCCCCC">
			  
			  <div class="CapVehiculoUso">  
			  Marcas y Modelos
			  </div>
			  </td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top" bgcolor="#CCCCCC">
			  
			  <div class="CapVehiculoUso">  
			  Años
			  </div>
			  
			  </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">
			  
			  <div class="CapVehiculoUso">  
			  <input type="checkbox" name="CmpVehiculoVersionMarcarTodo" id="CmpVehiculoVersionMarcarTodo" value="1" onclick="FncVehiculoVersionMarcarTodo();" />
Marcar Todos los Modelos

</div>
</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
			  
			  <div class="CapVehiculoUso">  <input type="checkbox" name="CmpVehiculoAnoMarcarTodo" id="CmpVehiculoAnoMarcarTodo" value="1" onclick="FncVehiculoAnoMarcarTodo();" /> 
			    Marcar Todos los Años</div></td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">
              
            <div class="CapVehiculoUso">  
                
              
				<table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      
                    <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>
                  
                        <td align="left" valign="top">
                            <?php echo $DatVehiculoMarca->VmaNombre;?>                        </td>
                        <td align="left" valign="top">&nbsp;</td>
                    <?php
                    }
                    ?>
                    </tr>
                  
                    <tr>
                     
                    <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>       
                    <td align="left" valign="top">
    
                        
                            <?php
                            $RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoOrden","ASC",NULL,$DatVehiculoMarca->VmaId);
                            $ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
                            ?>
                            
                            
        
           
                           <?php
                            $i = 1;
                            foreach($ArrVehiculoModelos as $DatVehiculoModelo){
                            ?>
                            
                                
                                <input type="checkbox" name="CmpVehiculoModelo_<?php echo $DatVehiculoModelo->VmoId?>" id="CmpVehiculoModelo_<?php echo $DatVehiculoModelo->VmoId?>" value="<?php echo $DatVehiculoModelo->VmoId?>" onclick="FncSeleccionarVehiculoVersiones('<?php echo $DatVehiculoModelo->VmoId;?>');" /> <?php echo $DatVehiculoModelo->VmoNombre?>     <?php
								if(!empty($DatVehiculoModelo->VmoNombreComercial)){
								?>
                                (<small><?php echo $DatVehiculoModelo->VmoNombreComercial;?></small>)
                                <?php	
								}
								?>
                               
                                <br />
                         
                         
									<?php
                                    $ResVehiculoVersiones = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,'VveNombre','ASC',NULL,NULL,$DatVehiculoModelo->VmoId);
                                    $ArrVehiculoVersiones = $ResVehiculoVersiones['Datos'];
                                    ?>
                                                             
                         
									<?php
                                    foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
                                    ?>
                                    
                                    
                                                    <?php
                                                    if(is_array($InsProducto->ProductoVehiculoVersion)){	
                                                        foreach($InsProducto->ProductoVehiculoVersion as $DatProductoVehiculoVersion ){
                                                            $aux = '';
                                                            $PvvId = "";
                                                            if($DatProductoVehiculoVersion->VveId==$DatVehiculoVersion->VveId){
                                                                $aux = 'checked="checked"';
                                                                $PvvId = $DatProductoVehiculoVersion->PvvId;						
                                                                break;
                                                            }					
                                                        }
                                                    }				
                                                    ?>
                                    
                                                    
                                    &nbsp;&nbsp;&nbsp;::: <input  <?php echo $aux;?> type="checkbox" name="CmpVehiculoVersion_<?php echo $DatVehiculoVersion->VveId?>" id="CmpVehiculoVersion_<?php echo $DatVehiculoVersion->VveId?>" value="<?php echo $DatVehiculoVersion->VveId?>"  tipo = "vve" modelo = "<?php echo $DatVehiculoVersion->VmoId?>" />
                                    
                                    
                                    
                                  <input type="hidden" name="CmpProductoVehiculoVersion_<?php echo $DatVehiculoVersion->VveId;?>" id="CmpProductoVehiculoVersion_<?php echo $DatVehiculoVersion->VveId;?>" value="<?php echo $PvvId;?>" /><?php echo $DatVehiculoVersion->VveNombre?>
                                    <br />
                                    <?php	
                                    }
                                    ?>
                         <br />
                            <?php
                            $i++;
                            }
                            ?>                    </td>
                     <td align="left" valign="top">&nbsp;</td>
                    <?php
                    }
                    ?>
                    </tr>
				</table>              
				
				</div>
				
				</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
              
			
             <div class="CapVehiculoUso">  
             
              
			<?php
			for($i=date("Y")-25;$i<=(date("Y"));$i++){
			?>
			
                
                
                <?php
			  	if(is_array($InsProducto->ProductoAno)){	
					foreach($InsProducto->ProductoAno as $DatProductoAno ){
						$aux = '';
						$PanId = "";
						if($DatProductoAno->PanAno==$i){
							$aux = 'checked="checked"';		
							$PanId = $DatProductoAno->PanId;					
							break;
						}					
					}
				}				
				?>
                
                
				<input tipo="ano" <?php echo $aux;?> type="checkbox" name="CmpAno_<?php echo $i;?>" id="CmpAno_<?php echo $i;?>" value="<?php echo $i;?>" />
                
				<input type="hidden" name="CmpProductoAno_<?php echo $i;?>" id="CmpProductoAno_<?php echo $i;?>" value="<?php echo $PanId;?>" />				<?php echo $i;?><br />
			

			<?php
			}			  
			?>              
			</div>
			
			</td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">              </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			</table>

                    </div>
         
                   </td>
       </tr>
	   </table>
	   
	   
	   
	   
	
       
         
		

           </div>
	
	   

        
     

		   
	
           
           
           
  
        
</div>      
               
        
        
        
        
        
        
        
        
        
        
        
        
        </td>
      </tr>
      <tr>
        <td align="center"></td>
      </tr>
    </table>
    
    
</div>


	
	
	
    

</form>

<script type="text/javascript">
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryradio2 = new Spry.Widget.ValidationRadio("spryradio2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");


</script>
<?php
}else{
	echo ERR_GEN_101;
}

if(empty($GET_dia)){
	
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

