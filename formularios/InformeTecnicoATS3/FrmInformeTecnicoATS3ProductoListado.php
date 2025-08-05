<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$Identificador = $_POST['Identificador'];
$POST_MonedaId = $_POST['MonedaId'];

session_start();

if (!isset($_SESSION['InsInformeTecnicoATS3Producto'.$Identificador])){
	$_SESSION['InsInformeTecnicoATS3Producto'.$Identificador] = new ClsSesionObjeto();	
}

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();


//SesionObjeto-InsInformeTecnicoATS3Producto
//Parametro1 = ItpId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = FapId
//Parametro5 = ProNombre
//Parametro6 = ItpCantidad
//Parametro7 = ItpValorUnitario
//Parametro8 = ItpValorTotal	
//Parametro9 = ItpEstado	
//Parametro10 = ItpTiempoCreacion		
//Parametro11 = ItpTiempoModificacion	
//Parametro12 = UmeNombre	
//Parametro13 = ProCodigoOriginal
//Parametro14 = ProCodigoAlternativo
	
	
$RepInformeTecnicoATS3Producto = $_SESSION['InsInformeTecnicoATS3Producto'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrInformeTecnicoATS3Productos = $RepInformeTecnicoATS3Producto['Datos'];

//deb($ArrInformeTecnicoATS3Productos);


?>

  
    <?php
    if(empty($ArrInformeTecnicoATS3Productos)){
    ?>
    No se encontraron elementos
    <?php
    }else{
    ?>
  
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" align="center">#</th>
      <th width="10%" align="center">P/N</th>
      <th width="44%" align="center">Descripcion</th>
      <th width="9%" align="center">U.M.</th>
      <th width="9%" align="center">Cant.</th>
      <th width="7%" align="center">Valor Unit.</th>
      <th width="8%" align="center">Valor Total</th>
      <th width="11%" align="center"> Acc.</th>
      </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    <?php
    $c = 1;
    $Total = 0;
    foreach($ArrInformeTecnicoATS3Productos as $DatInformeTecnicoATS3Producto){
	
    ?>
    
    
    <tr>
    <td align="left" valign="top"><?php echo $c;?></td>
    <td align="left" valign="top"><?php echo $DatInformeTecnicoATS3Producto->Parametro13;?></td>
    <td align="left" valign="top">
      <?php echo $DatInformeTecnicoATS3Producto->Parametro5;?></td>
    <td align="left" valign="top"><?php echo $DatInformeTecnicoATS3Producto->Parametro12;?></td>
    <td align="center" valign="top"><?php echo number_format($DatInformeTecnicoATS3Producto->Parametro6,2,'.','');?></td>
    <td align="left" valign="top"><?php echo number_format($DatInformeTecnicoATS3Producto->Parametro7,2,'.','');?></td>
    <td align="left" valign="top"><?php echo number_format($DatInformeTecnicoATS3Producto->Parametro8,2,'.','');?></td>
    <td align="center" valign="top">
      
      <?php
    if($_POST['Editar']==1){
    ?>
      
      <a class="EstSesionObjetosItem" href="javascript:FncInformeTecnicoATS3ProductoEscoger('<?php echo $DatInformeTecnicoATS3Producto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
      
      <?php
    }
    ?>
      
      <?php
    if($_POST['Eliminar']==1){
    ?>
      <a href="javascript:FncInformeTecnicoATS3ProductoEliminar('<?php echo $DatInformeTecnicoATS3Producto->Item;?>');" ><img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
      <?php
    }
    ?>
      
    </td>
    </tr>
    <?php
            
            $c++;
       		$Total += $DatSesionObjeto->Parametro8;
    }	
    

    ?>
    </tbody>
    </table>

<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="61%" align="right" class="Total">Total:</td>
  <td width="15%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
</tr>

</tbody>
</table>
    <?php
    }
    ?>







