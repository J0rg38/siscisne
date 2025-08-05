<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
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

$Identificador = $_POST['Identificador'];
$POST_AnoModelo = $_POST['AnoModelo'];

session_start();
if (!isset($_SESSION['InsVehiculoVersionCaracteristica'.$Identificador])){
	$_SESSION['InsVehiculoVersionCaracteristica'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsAlmacenProducto = new ClsAlmacenProducto();
$InsAlmacen = new ClsAlmacen();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();

//	SesionObjeto-VehiculoVersionCaracteristica
//	Parametro1 = VvcId
//	Parametro2 = VveId
//	Parametro3 = VcsId

//	Parametro4 = VvcDescripcion
//	Parametro5 = VvcValor
//	Parametro6 = VvcAnoModelo
//	Parametro7 = VvcTiempoCreacion
//	Parametro8 = VvcTiempoModificacion
//	Parametro9 = VcsNombre


$RepSesionObjetos = $_SESSION['InsVehiculoVersionCaracteristica'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];

?>

<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->

<?php
if(!empty($ArrVehiculoCaracteristicaSecciones)){
	foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
		
		
		$TieneDatos = false;
		
        foreach($ArrSesionObjetos as $DatSesionObjeto){
           if($DatSesionObjeto->Parametro3==$DatVehiculoCaracteristicaSeccion->VcsId){
                if($DatSesionObjeto->Parametro6==$POST_AnoModelo or empty($POST_AnoModelo)){
					$TieneDatos = true;
					break;			
				}
			}
		}
					
?>

<?php
if($TieneDatos){
?>


	<span class="EstCapVehiculoVersionCaracteristicaTitulo"><?php echo $DatVehiculoCaracteristicaSeccion->VcsNombre;?></span></td>
  
    
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="5%">Id</th>
  <th width="16%">Seccion</th>
  <th width="7%">Año</th>
  <th width="28%">Descripcion</th>
  <th width="29%"> Contenido</th>
  <th width="13%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">


		<?php
        $c = 1;
        foreach($ArrSesionObjetos as $DatSesionObjeto){
        ?>
            
            <?php
            if($DatSesionObjeto->Parametro3==$DatVehiculoCaracteristicaSeccion->VcsId){
            ?>
                
                <?php
                if($DatSesionObjeto->Parametro6==$POST_AnoModelo or empty($POST_AnoModelo)){
                ?>
                
                
                <tr>
                <td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $c;?></td>
                <td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
                  
                  
                  <?php echo $DatSesionObjeto->Parametro3;?>
                  
                </td>
                <td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro9;?></td>
                <td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo ($DatSesionObjeto->Parametro6);?></td>
                <td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro4;?></td>
                <td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
                  <?php echo $DatSesionObjeto->Parametro5;?>
                  
                </td>
                <td align="center" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
                  
                  <?php
                if($_POST['Editar']==1){
                ?>
                  
                  
                  <a class="EstSesionObjetosItem" href="javascript:FncVehiculoVersionCaracteristicaEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
                  
                  <?php
                }
                ?>
                  
                  <?php
                if($_POST['Eliminar']==1){
                ?>
                  <a href="javascript:FncVehiculoVersionCaracteristicaEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
                    <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
                  <?php
                }
                ?>
                  
                  
                </td>
                </tr>
                
                <?php	
                }
                ?>
                
            <?php	
            }
            ?>
        <?php
        $c++;
        }
        ?>


</tbody>
</table>

<?php
}
?>

<?php	
	}
}
?>
<br />

<!--<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">

<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="68%" align="right" class="Total">Total:</td>
  <td width="8%" align="right"><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda; ?></span> <?php echo number_format($Total,2);?></td>
  
</tr>
</tbody>
</table>-->
<?php
}
?>
