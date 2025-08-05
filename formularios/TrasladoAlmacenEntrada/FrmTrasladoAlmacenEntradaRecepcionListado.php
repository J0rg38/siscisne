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
if (!isset($_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador])){
	$_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');

$InsVentaConcretada = new ClsVentaConcretada();

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

//SesionObjeto-TrasladoAlmacenEntradaDetalle
//Parametro1 = AmdId
//Parametro2 = ProId
//Parametro3 = Nombre
//Parametro4 = Costo
//Parametro5 = Cantidad
//Parametro6 = Importe
//Parametro7 = TiempoCreacion
//Parametro8 = TiempoModificacion
//Parametro9 = UnidadMedidaNombreConvertir
//Parametro10 = UnidadMedidaConvertir
//Parametro11 = Tipo
//Parametro12 = CantidadReal
//Parametro13 = Utilidad
//Parametro14 = UtilidadPorcentaje
//Parametro15 = CostoAnterior
//Parametro16 = CostoTotal
//Parametro17 = ProCodigoOriginal
//Parametro18 = ProCodigoAlternativo
//Parametro19 = UmeIdOrigen
//Parametro20 = AmdIdOrigen
//Parametro21 = PcdId
//Parametro22 = PcoId
//Parametro23 = PcoFecha
//Parametro24 = CliNombreCompleto

$RepTrasladoAlmacenEntradaDetalle = $_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrTrasladoAlmacenEntradaDetalles = $RepTrasladoAlmacenEntradaDetalle['Datos'];

?>



		<?php
		if(empty($ArrTrasladoAlmacenEntradaDetalles)){
		?>
        	No se encontraron elementos
        <?php
        }else{
        ?>
            
            <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="2%">#</th>
              <th width="8%">Id</th>
              <th width="12%">Cod. Orig.</th>
              <th width="8%">Cod. Alt.</th>
            <th width="34%"> Nombre
            </th>
            <th width="10%">U.M.</th>
            <th width="8%">
              Cantidad</th>
            <th width="7%">Estado</th>
            <th width="11%"> Acc.</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
            <?php
            $c = 1;
            $SubTotal = 0;
            //$CantidadTotal = 0;
            //$TotalItems = 0;
            foreach($ArrTrasladoAlmacenEntradaDetalles as $DatSesionObjeto){
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
            <td align="right" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
			<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
			<?php echo $c;?>
            </span>
            </td>
            <td align="right" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro2;?></td>
            <td align="right" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro17;?>

<a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro17;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>"   title=""> <img src="imagenes/almacen_stock.jpg" alt="[Stock]" width="20" height="20" border="0" align="absmiddle" title="Stock" /> </a>

            </td>
            <td align="right" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro18;?></td>
            <td align="right" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
            <?php echo $DatSesionObjeto->Parametro3;?></td>
            <td align="right" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro9;?>
            
            
            
            
            </td>
            <td align="right" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
              
              <input type="text" id="CmpTrasladoAlmacenEntradaDetalleCantidad_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" name="CmpTrasladoAlmacenEntradaDetalleCantidad_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" class="EstFormularioCaja" value="<?php echo number_format($DatSesionObjeto->Parametro5,2);?>" />
			  
               <!--<br />
				<span class="EstFormularioSubEtiqueta">
              (<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)
              </span>-->
            </td>
            <td align="center" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
			
			<select <?php echo (($_POST['Editar']==2)?'disabled="disabled"':'')?>    class="EstFormularioCombo" name="CmpTrasladoAlmacenEntradaDetalleEstado_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>" id="CmpTrasladoAlmacenEntradaDetalleEstado_<?php echo $ModalidadIngreso.$DatSesionObjeto->Item;?>">
  <option value="">-</option>
  <option <?php echo (($DatSesionObjeto->Parametro25=="1")?'selected="selected"':'');?> value="1">No Llego</option>
  <option <?php echo (($DatSesionObjeto->Parametro25=="3")?'selected="selected"':'');?> value="3" >Conforme</option>    
  </select>
			<?php
			/*switch($DatSesionObjeto->Parametro25){
				case 1:
			?>
              No Llego
              <?php	
				break;
				
				case 2:
			?>
              Da&ntilde;ado
  <?php	
				break;
				
				case 3:
			?>
              Conforme
  <?php	
				break;
			}*/
			?>
            
            
            </td>
            <td align="center" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
            
            <?php
            if($_POST['Editar']==1){
            ?>
            
            
            <a class="EstSesionObjetosItem" href="javascript:FncTrasladoAlmacenEntradaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
            
            <?php
            }
            ?>
            
            <?php
            if($_POST['Eliminar']==1){
            ?>
            <a href="javascript:FncTrasladoAlmacenEntradaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
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
           // $Recargo = $POST_TotalRecargo;
           // $Impuesto = round(($SubTotal + $Recargo) * ($EmpresaImpuestoVenta/100),2);
		    $Impuesto = round(($SubTotal ) * ($EmpresaImpuestoVenta/100),2);
            $Total = $SubTotal + $Impuesto;
            
            
            ?>
            </tbody>
            </table>
<br />
<?php
        }
        ?>
        

