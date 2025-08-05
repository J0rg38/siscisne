<?php
session_start();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
/*
*Control de Lista de Acceso
*/
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();

$InsACL = new ClsACL();

/*
*Variables GET
*/
$GET_mod = $_GET['Mod'];
$GET_form = $_GET['Form'];

?>

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Ver"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","Imprimir"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PedidoCompra","VistaPreliminar"))?true:false;?>


<?php

$GET_ProId = $_GET['ProId'];


require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');

$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();
$InsUnidadMedida = new ClsUnidadMedida();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$InsProducto->ProId = $GET_ProId;
$InsProducto->MtdObtenerProducto();		

?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="3%">&nbsp;</td>
      <td><span class="EstFormularioSubTitulo"> USO del PRODUCTO
        </span></td>
      <td width="3%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  
	  <input disabled="disabled" type="checkbox" name="CmpValidarUso" id="CmpValidarUso" value="2" <?php echo (($InsProducto->ProValidarUso==2)?'checked="checked"':'');?>>
Este producto puede ser utilizado por cualquier modelo y a&ntilde;o.
	  
	  
	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="94%"><table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
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
			  <td align="center" valign="top" bgcolor="#CCCCCC">Marcas y Modelos</td>
			  <td align="center" valign="top">&nbsp;</td>
			  <td align="center" valign="top" bgcolor="#CCCCCC">Años</td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">
              
              
              
              
				<table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      
                    <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>
                  
                        <td align="left" valign="top">
                            <?php echo $DatVehiculoMarca->VmaNombre;?>                
                        </td>
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
                            $RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$DatVehiculoMarca->VmaId);
                            $ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
                            ?>
                            
                            
                
                            <?php
                            $i = 1;
                            foreach($ArrVehiculoModelos as $DatVehiculoModelo){
                            ?>
                            
                                
                                <input disabled="disabled" type="checkbox" name="CmpVehiculoModelo_<?php echo $DatVehiculoModelo->VmoId?>" id="CmpVehiculoModelo_<?php echo $DatVehiculoModelo->VmoId?>" value="<?php echo $DatVehiculoModelo->VmoId?>" /> <?php echo $DatVehiculoModelo->VmoNombre?> 
                               
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

&nbsp;&nbsp;&nbsp;::: [&nbsp;<?php echo ($aux=='checked="checked"')?'X':'&nbsp;';?>&nbsp;]
<!--<input disabled="disabled"  <?php echo $aux;?> type="checkbox" name="CmpVehiculoVersion_<?php echo $DatVehiculoVersion->VveId?>" id="CmpVehiculoVersion_<?php echo $DatVehiculoVersion->VveId?>" value="<?php echo $DatVehiculoVersion->VveId?>" />-->

<input type="hidden" name="CmpProductoVehiculoVersion_<?php echo $DatVehiculoVersion->VveId;?>" id="CmpProductoVehiculoVersion_<?php echo $DatVehiculoVersion->VveId;?>" value="<?php echo $PvvId;?>" /><?php echo $DatVehiculoVersion->VveNombre?>

<br />
<?php	
}
?>
                         <br />
                            <?php
                            $i++;
                            }
                            ?>
       
                            
                            
                    </td>
                     <td align="left" valign="top">&nbsp;</td>
                    <?php
                    }
                    ?>
                    </tr>
				</table>
                
                
                
                
                
                
              
              </td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
              
			<table border="0" cellpadding="0" cellspacing="0">
            
			<?php
			for($i=date("Y")-25;$i<=(date("Y"));$i++){
			?>
			<tr>
				<td>
                
                
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
                
                [&nbsp;<?php echo ($aux=='checked="checked"')?'X':'&nbsp;';?>&nbsp;]
				<!--<input disabled="disabled" <?php echo $aux;?> type="checkbox" name="CmpAno_<?php echo $i;?>" id="CmpAno_<?php echo $i;?>" value="<?php echo $i;?>" />-->
                
				<input type="hidden" name="CmpProductoAno_<?php echo $i;?>" id="CmpProductoAno_<?php echo $i;?>" value="<?php echo $PanId;?>" />				<?php echo $i;?>
				</td>
			</tr>

			<?php
			}			  
			?>

			</table>
              
              
              </td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  </tr>
			</table></td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   