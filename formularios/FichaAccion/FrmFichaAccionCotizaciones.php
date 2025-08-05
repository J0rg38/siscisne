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

$POST_VehiculoIngresoId = $_POST['VehiculoIngresoId'];
$POST_VehiculoIngresoVIN = $_POST['VehiculoIngresoVIN'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');


if(!empty($POST_VehiculoIngresoVIN)){
	
	$InsCotizacionProducto = new ClsCotizacionProducto();
	//MtdObtenerCotizacionProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL,$oVehiculoIngreso=NULL)
	$ResCotizacionProducto = $InsCotizacionProducto->MtdObtenerCotizacionProductos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"CprFecha","DESC",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
	$ArrCotizacionProductos = $ResCotizacionProducto['Datos'];
?>

    <?php
    if(empty($ArrCotizacionProductos)){
    ?>
            No se encontraron registros
    <?php
    }else{
    ?>
            <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="2%" align="center">#</th>
              <th width="8%" align="center">Cot.</th>
              <th width="11%" align="center"> Fecha</th>
              <th width="32%" align="center">Cliente</th>
              <th width="39%">Observacion</th>
              <th width="8%" align="center"> Acc.</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
                <?php
                $c = 1;
                foreach($ArrCotizacionProductos as $DatCotizacionProducto){
                ?>
                <tr>
                <td align="right" valign="top"><?php echo $c;?></td>
                <td align="right" valign="top"><?php echo $DatCotizacionProducto->CprId;?></td>
                <td align="right" valign="top">
                  <?php echo $DatCotizacionProducto->CprFecha;?></td>
                <td align="right" valign="top">
				
				<?php echo $DatCotizacionProducto->CliNombre;?>
                <?php echo $DatCotizacionProducto->CliApellidoPaterno;?>
                <?php echo $DatCotizacionProducto->CliApellidoMaterno;?>
                
                
                </td>
                <td align="right" valign="top"><?php echo $DatCotizacionProducto->CprObservacion;?></td>
                <td align="center">
                
<a href="javascript:FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id=<?php echo $DatCotizacionProducto->CprId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                  
                </td>
                </tr>
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
	
}else{
?>
	No se encontro VIN del vehiculo
<?php	
}
?>





