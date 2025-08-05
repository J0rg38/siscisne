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
$POST_MonedaId = $_POST['MonedaId'];
$POST_TotalRecargo = (empty($_POST['TotalRecargo']))?0:$_POST['TotalRecargo'];

session_start();
if (!isset($_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador])){
	$_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoListaPrecio.php');

$InsVehiculoListaPrecio = new ClsVehiculoListaPrecio();

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();


//SesionObjeto-PagoVehiculoIngreso
//Parametro1 = PvdId
//Parametro2 = EinId
//Parametro3 = EinVIN

//Parametro4 = PvdCosto
//Parametro5 = PvdCantidad
//Parametro6 = PvdImporte
//Parametro7 = PvdTiempoCreacion
//Parametro8 = PvdTiempoModificacion

//Parametro9 = EinNumeroMotor
//Parametro10 = EinAnoFabricacion
//Parametro11 = EinAnoModelo
//Parametro12 = VehId

//Parametro13 = PvdUtilidad
//Parametro14 = PvdUtilidadPorcentaje
//Parametro15 = PvdCostoAnterior
//Parametro16 = 
//Parametro17 = EinColor
//Parametro18 = EinColorInterior
//Parametro19 = VmaNombre
//Parametro20 = VmoNombre
//Parametro21 = VveNombre
//Parametro22 = VmaId
//Parametro23 = VmoId
//Parametro24 = VveId
//Parametro25 = PvdEstado
//Parametro26 = VehCodigoIdentificador
//Parametro27 = UmeId
//Parametro28 = UmeNombre

$RepPagoVehiculoIngreso = $_SESSION['InsPagoVehiculoIngresoDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrPagoVehiculoIngresos = $RepPagoVehiculoIngreso['Datos'];

?>



		<?php
		if(empty($ArrPagoVehiculoIngresos)){
		?>
        	No se encontraron elementos
        <?php
        }else{
        ?>
            
            <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="1%">#</th>
              <th width="4%">Id</th>
              <th width="10%">VIN</th>
              <th width="6%">Cod. Unico</th>
              <th width="6%">Marca</th>
              <th width="6%">Modelo</th>
              <th width="6%">Version</th>
              <th width="6%">Color Exterior</th>
              <th width="6%">Color Interior</th>
              <th width="6%">Año / Fab.</th>
              <th width="6%">Año / Mod.</th>
              <th width="9%">Observaciones</th>
            <th width="7%"> Acc.</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
            <?php
            $c = 1;
            $SubTotal = 0;
            //$CantidadTotal = 0;
            //$TotalItems = 0;
            foreach($ArrPagoVehiculoIngresos as $DatSesionObjeto){
            ?>
            
            <?php
            if($InsMoneda->MonId<>$EmpresaMonedaId){
            ?>
            
            <?php	
            }else{
            ?>
                <?php  $DatSesionObjeto->Parametro6 = ($DatSesionObjeto->Parametro6 * $_POST['TipoCambio']);?>
                <?php  $DatSesionObjeto->Parametro4 = ($DatSesionObjeto->Parametro4 * $_POST['TipoCambio']);?>
                <?php  $DatSesionObjeto->Parametro13 = ($DatSesionObjeto->Parametro13 * $_POST['TipoCambio']);?>
            <?php	
            }
            ?>
            <tr>
            <td align="right">
			<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
			<?php echo $c;?>
            </span>
            </td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro2;?></td>
            <td align="right">
            
           
       <!--     
 <a href="javascript:FncPagoVehiculoIngresoDetalleReemplazorCargar('<?php echo  $Identificador;?>','<?php echo trim($DatSesionObjeto->Item);?>');"><?php echo $DatSesionObjeto->Parametro17;?></a>-->
			
            
	<?php echo $DatSesionObjeto->Parametro3;?>

<!--<a target="_blank" href="principal.php?Mod=Vehiculo&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro17;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Vehiculo]" width="20" height="20" border="0" align="absmiddle" title="Vehiculo " /> </a>
-->

            </td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro26;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro19;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro20;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro21;?></td>
            
            <td align="right"><?php echo $DatSesionObjeto->Parametro17;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro18;?></td>
            
            <td align="right"><?php echo $DatSesionObjeto->Parametro10;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro11;?></td>
            <td align="right"><?php echo (($DatSesionObjeto->Parametro16));?></td>
            <td align="center">
            
            <?php
            if($_POST['Editar']==1){
            ?>
            
            
            <a class="EstSesionObjetosItem" href="javascript:FncPagoVehiculoIngresoDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
            
            <?php
            }
            ?>
            
            <?php
            if($_POST['Eliminar']==1){
            ?>
            <a href="javascript:FncPagoVehiculoIngresoDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
            <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
            <?php
            }
            ?>
            
            
            </td>
            </tr>
            <?php
            
                $SubTotal = $SubTotal + $DatSesionObjeto->Parametro6;
            
            $c++;
            }
            
            //$POST_TotalRecargo
            $SubTotal = round($SubTotal,2);
            $Recargo = $POST_TotalRecargo;
            $Impuesto = round(($SubTotal + $Recargo) * ($EmpresaImpuestoVenta/100),2);
            $Total = $SubTotal + $Recargo + $Impuesto;
            ?>
            </tbody>
            </table>
<br />
<?php
        }
        ?>
        


