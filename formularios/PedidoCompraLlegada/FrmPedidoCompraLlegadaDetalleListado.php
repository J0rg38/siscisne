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
if (!isset($_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador])){
	$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador] = new ClsSesionObjeto();	
}

if (!isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

//SesionObjeto-PedidoCompraLlegadaDetalle
//Parametro1 = 
//Parametro2 = PcdId
//Parametro3 = PldCantidad
//Parametro4 = PldEstado
//Parametro5 = PldTiempoCreacion
//Parametro6 = PldTiempoModificacion
//Parametro7 = ProId
//Parametro8 = UmeId
//Parametro9 = PcdCantidad
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = UmeIdOrigen
//Parametro14 = UmeNombre
//Parametro15 = VdiId

//Parametro16 = VdiOrdenCompraNumero
//Parametro17 = CliNumeroDocumento
//Parametro18 = CliNombre
//Parametro19 = CliApellidoPaterno
//Parametro20 = CliApellidoMaterno
$RepPedidoCompraLlegadaDetalle = $_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrPedidoCompraLlegadaDetalles = $RepPedidoCompraLlegadaDetalle['Datos'];

$RepOrdenCompraPedido = $_SESSION['InsOrdenCompraPedido'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrOrdenCompraPedidos = $RepOrdenCompraPedido['Datos'];
//deb($ArrOrdenCompraPedidos);
?>

<?php
if(empty($ArrOrdenCompraPedidos)){
?>

		<?php
		if(empty($ArrPedidoCompraLlegadaDetalles)){
		?>
        	No se encontraron elementos
        <?php
        }else{
        ?>
            
            <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="2%">#</th>
              <th width="4%">Id</th>
              <th width="6%">Cod. Orig.</th>
              <th width="5%">Cod. Alt.</th>
            <th width="29%"> Nombre
            </th>
            <th width="5%">U.M.</th>
            <th width="5%">
              Cantidad</th>
            <th width="16%">Cliente</th>
            <th width="7%">Ord. Compra</th>
            <th width="8%">Ord. Venta</th>
            <th width="7%">O.C. Ref.</th>
            <th width="6%"> Acc.</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
            <?php
            $c = 1;
            foreach($ArrPedidoCompraLlegadaDetalles as $DatSesionObjeto){
            ?>
          
            <tr>
            <td align="right"><?php echo $c;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro7;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro11;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro12;?></td>
            <td align="right">
            <?php echo $DatSesionObjeto->Parametro10;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro14;?>
            
            
            
            
            </td>
            <td align="right">
              
              <?php echo number_format($DatSesionObjeto->Parametro3,3);?>
              
            </td>
            <td align="right">
            
            
            
            <?php echo $DatSesionObjeto->Parametro18;?>
            <?php echo $DatSesionObjeto->Parametro19;?>
            <?php echo $DatSesionObjeto->Parametro20;?>
            

            </td>
            <td align="right">
            <?php echo $DatSesionObjeto->Parametro22;?>
        
            &nbsp;</td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro15;?></td>
            <td align="right"><?php echo $DatSesionObjeto->Parametro16;?></td>
            <td align="center">
            
            <?php
            if($_POST['Editar']==1){
            ?>
            <a class="EstSesionObjetosItem" href="javascript:FncPedidoCompraLlegadaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
            <?php
            }
            ?>
            
            <?php
            if($_POST['Eliminar']==1){
            ?>
            <a href="javascript:FncPedidoCompraLlegadaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
            <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
            <?php
            }
            ?>
            
            
            </td>
            </tr>
            <?php
            
               
            $c++;
            }
            
           
            
            ?>
            </tbody>
            </table>
    <br />
    <?php
        }
        ?>
        


<?php	
}else{
?>


	<?php
	$SubTotal = 0;
	foreach($ArrOrdenCompraPedidos as $DatOrdenCompraPedido){
	?>
    
    
         <br />
            
            <table width="100%" cellpadding="2" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <td width="5%" align="left" class="EstFormularioEtiquetaFondo" >Pedido:</td>
                  <td width="13%" align="left" ><?php echo $DatOrdenCompraPedido->Parametro1;?></td>
                  <td width="4%" align="left" class="EstFormularioEtiquetaFondo" >Fecha:</td>
                  <td width="25%" align="left" ><?php echo $DatOrdenCompraPedido->Parametro2;?></td>
                  <td width="5%" align="left" class="EstFormularioEtiquetaFondo" >Cliente:</td>
                  <td width="36%" align="left"><?php echo $DatOrdenCompraPedido->Parametro3;?>
                  
                  </td>
                  <td width="5%" align="left">&nbsp;</td>
                    <td width="7%" align="left">&nbsp;</td>
                </tr>
            </tbody>
            </table>
            
			<br />
    	                
		<?php
        if(!empty($ArrPedidoCompraLlegadaDetalles)){
        ?>
        
        
         <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <thead class="EstTablaListadoHead">
                            <tr>
                              <th width="2%">#</th>
                              <th width="7%">Id</th>
                              <th width="8%">Cod. Orig.</th>
                              <th width="8%">Cod. Alt.</th>
                            <th width="44%"> Nombre
                            </th>
                            <th width="4%">U.M.</th>
                            <th width="7%">
                              Cantidad</th>
                            <th width="4%"> Acc.</th>
                            </tr>
                            </thead>
                            <tbody class="EstTablaListadoBody">
            <?php
			$c = 1;
            foreach($ArrPedidoCompraLlegadaDetalles as $DatPedidoCompraLlegadaDetalle){
            ?>
                
      
                <?php
                if($DatOrdenCompraPedido->Parametro1 == $DatPedidoCompraLlegadaDetalle->Parametro22){
                ?>
                
                            <?php
                            if($InsMoneda->MonId<>$EmpresaMonedaId){
                            ?>
                            
                            <?php	
                            }else{
                            ?>
                                <?php  $DatPedidoCompraLlegadaDetalle->Parametro6 = ($DatPedidoCompraLlegadaDetalle->Parametro6 * $_POST['TipoCambio']);?>
                                <?php  $DatPedidoCompraLlegadaDetalle->Parametro4 = ($DatPedidoCompraLlegadaDetalle->Parametro4 * $_POST['TipoCambio']);?>
                                <?php  $DatPedidoCompraLlegadaDetalle->Parametro13 = ($DatPedidoCompraLlegadaDetalle->Parametro13 * $_POST['TipoCambio']);?>
                            <?php	
                            }
                            ?>
                            <tr>
                            <td align="right"><?php echo $c;?></td>
                            <td align="right"><?php echo $DatPedidoCompraLlegadaDetalle->Parametro2;?></td>
                            <td align="right"><?php echo $DatPedidoCompraLlegadaDetalle->Parametro17;?></td>
                            <td align="right"><?php echo $DatPedidoCompraLlegadaDetalle->Parametro18;?></td>
                            <td align="right">
                            <?php echo $DatPedidoCompraLlegadaDetalle->Parametro3;?></td>
                            <td align="right"><?php echo $DatPedidoCompraLlegadaDetalle->Parametro9;?>
                            
                            
                            
                            
                            </td>
                            <td align="right">
                              
                              <?php echo number_format($DatPedidoCompraLlegadaDetalle->Parametro5,3);?>
                              
                            </td>
                            <td align="center">
                            
                            <?php
                            if($_POST['Editar']==1){
                            ?>
                            
                            
                            <a class="EstSesionObjetosItem" href="javascript:FncPedidoCompraLlegadaDetalleEscoger('<?php echo $DatPedidoCompraLlegadaDetalle->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
                            
                            <?php
                            }
                            ?>
                            
                            <?php
                            if($_POST['Eliminar']==1){
                            ?>
                            <a href="javascript:FncPedidoCompraLlegadaDetalleEliminar('<?php echo $DatPedidoCompraLlegadaDetalle->Item;?>');" >
                            <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
                            <?php
                            }
                            ?>
                            
                            
                            </td>
                            </tr>
                            <?php
                            
                               
                            $c++;
                           
                            
                            
                            
                            ?>
                           
          
                    
                <?php	
                }
                ?>
                
                
                
        <?php	
        }
        ?>
        
        
           </tbody>
                            </table>
                <?php
                }
                ?>   
                
    
    <?php	
    }
    ?>
    
    



        <br />
        <?php	
}
?>
