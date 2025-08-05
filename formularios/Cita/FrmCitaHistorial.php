<?php
session_start();
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
?>

<?php
if(!empty($POST_VehiculoIngresoVIN)){
?>


	<?php
	$InsFichaIngreso = new ClsFichaIngreso();
	$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos("EinVIN","esigual",$POST_VehiculoIngresoVIN,"FinFecha","DESC",NULL,NULL,NULL,NULL,NULL,NULL);
	$ArrFichaIngresos = $ResFichaIngreso['Datos'];
	?>

    <?php
    if(empty($ArrFichaIngresos)){
    ?>
            No se encontraron registros
    <?php
    }else{
    ?>
            
            <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="2%" align="center">#</th>
              <th width="9%" align="center">O.T.</th>
              <th width="9%" align="center"> Fecha</th>
              <th width="32%" align="center">Observaciones</th>
              <th width="17%">Modalidades</th>
              <th width="12%">Kilometraje</th>
              <th width="9%">Plan Mant.</th>
              <th width="10%" align="center"> Acc.</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
                <?php
                $c = 1;
                foreach($ArrFichaIngresos as $DatFichaIngreso){
                ?>
                <tr>
                <td align="right" valign="top"><?php echo $c;?></td>
                <td align="right" valign="top"><?php echo $DatFichaIngreso->FinId;?></td>
                <td align="right" valign="top">
                  <?php echo $DatFichaIngreso->FinFecha;?></td>
                <td align="right" valign="top"><?php echo $DatFichaIngreso->FinSalidaObservacion;?></td>
                <td align="right" valign="top">
                
<?php
$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatFichaIngreso->FinId,NULL);
$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
?>

<?php
foreach($ArrFichaIngresoModalidades  as $DatFichaIngresoModalidad){
?>
<?php echo $DatFichaIngresoModalidad->MinNombre;?> [<?php echo $DatFichaIngresoModalidad->MinSigla;?>]<br />
<?php	
}
?>

                </td>
                <td align="right" valign="top"><?php echo $DatFichaIngreso->FinVehiculoKilometraje;?>km</td>
                <td align="right" valign="top">
                <?php echo $DatFichaIngreso->FinMantenimientoKilometraje;?>km
                
    
    
                </td>
                <td align="center">
                
                
                
                <a href="javascript:FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id=<?php echo $DatFichaIngreso->FinId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img border="0"  align="absmiddle" src="imagenes/acciones/ficha_tecnica.png" alt="[Ver]" title="Ver Ficha Tecnica" width="25" height="25"  /></a>
                
                <a href="javascript:FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFI.php?Id=<?php echo $DatFichaIngreso->FinId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img border="0"  align="absmiddle" src="imagenes/acciones/ficha_interna.png" alt="[Ver]" title="Ver Ficha Interna" width="25" height="25"  /></a>
                
                
                  
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





