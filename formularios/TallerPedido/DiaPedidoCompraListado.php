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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TallerPedido","Imprimir"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>


<?php
$GET_FinId = $_GET['FinId'];
$GET_FccId = $_GET['FccId'];

//require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
//$InsTallerPedido = new ClsTallerPedido();

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');

$InsPedidoCompra = new ClsPedidoCompra();
$InsVentaDirecta = new ClsVentaDirecta();

//MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL) {
$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoTiempoCreacion","DESC",NULL,(NULL),(NULL),NULL,NULL,0,NULL,NULL,NULL,$GET_FinId);
$ArrPedidoCompras = $ResPedidoCompra['Datos'];


// MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL,$oFichaIngreso=NULL) {
$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas(NULL,NULL,NULL,'VdiTiempoCreacion','DESC',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL,NULL,NULL,NULL,$GET_FinId);
$ArrVentaDirectas = $ResVentaDirecta['Datos'];
		
?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Ordenes de compra </span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>


<?php
if(!empty($ArrPedidoCompras)){
?>
        
        <table width="100%" class="EstTablaListado">
          <thead class="EstTablaListadoHead">
            <tr>
              <th width="2%" align="center">#</th>
              <th width="8%" align="center">Ped. Compra</th>
              <th width="10%" align="center">Fecha</th>
              <th width="55%" align="center">Observacion</th>
              <th width="14%" align="center">Orden Compra</th>
              <th width="11%" align="center">Acciones</th>
              </tr>
            </thead>
          <tbody class="EstTablaListadoBody">
            <?php
$i=1;
foreach($ArrPedidoCompras as $DatPedidoCompra){
?>
            
            
            <tr>
              <td><?php echo $i;?></td>
              <td align="left">
                <a target="_self"  href="principal.php?Mod=TallerPedido&Form=Ver&Id=<?php echo $DatPedidoCompra->PcoId;?>">
                  <?php echo $DatPedidoCompra->PcoId;?>
                  </a>
                </td>
              <td align="left"><?php echo $DatPedidoCompra->PcoFecha;?></td>
              <td align="left"><?php echo $DatPedidoCompra->PcoObservacion;?></td>
              <td align="center"><?php
				  
				  if(!empty($DatPedidoCompra->OcoId)){
				?>
                <?php echo $DatPedidoCompra->OcoId;?>
                <?php
				  }else{
				?>
                No tiene orden a proveedor
                <?php	  
				  }
				  
				  ?></td>
              <td align="center">
                
                <?php
			if($PrivilegioVer){
			?>
                <a target="_self"  href="principal.php?Mod=PedidoCompra&Form=Ver&Id=<?php echo $DatPedidoCompra->PcoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                <?php
			}
			?>
                
                <?php
			if($PrivilegioVistaPreliminar){
			?>
                <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $DatPedidoCompra->PcoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                <?php
			}
			?>
                
                <?php
			if($PrivilegioImprimir){
			?>        
                
                <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $DatPedidoCompra->PcoId;?>&P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                <?php
			}
			?> 
                
                   <?php
			if($PrivilegioVer){
			?>
 <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimirEstado.php?Id=<?php echo $DatPedidoCompra->PcoId;?>',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/ver_estado.png" alt="[Ver Estado]" title="Ver Estado" width="19" height="19" border="0" /></a>           
                <?php
			}
			?>
                
                
                </td>
              </tr>
            
            <?php
$i++;
}
?>
            
            <?php
   
    foreach($ArrVentaDirectas as $DatVentaDirecta){
        //MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL) {
        $ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoTiempoCreacion","DESC",NULL,(NULL),(NULL),NULL,NULL,0,$DatVentaDirecta->VdiId,NULL,NULL,NULL);
        $ArrPedidoCompras = $ResPedidoCompra['Datos'];
	?>
            
            <?php
            foreach($ArrPedidoCompras as $DatPedidoCompra){
            ?>
            
            
            <tr>
              <td><?php echo $i;?></td>
              <td align="left"><a target="_self"  href="principal.php?Mod=TallerPedido&amp;Form=Ver&amp;Id=<?php echo $DatPedidoCompra->PcoId;?>"> <?php echo $DatPedidoCompra->PcoId;?> </a></td>
              <td align="left"><?php echo $DatPedidoCompra->PcoFecha;?></td>
              <td align="left"><?php echo $DatPedidoCompra->PcoObservacion;?></td>
              <td align="center"><?php
				  
				  if(!empty($DatPedidoCompra->OcoId)){
				?>
                <?php echo $DatPedidoCompra->OcoId;?>
                <?php
				  }else{
				?>
                No tiene orden a proveedor
                <?php	  
				  }
				  
				  ?></td>
              <td align="center"><?php
                if($PrivilegioVer){
                ?>
                <a target="_self"  href="principal.php?Mod=PedidoCompra&amp;Form=Ver&amp;Id=<?php echo $DatPedidoCompra->PcoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                <?php
                }
                ?>
                <?php
                if($PrivilegioVistaPreliminar){
                ?>
                <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $DatPedidoCompra->PcoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                <?php
                }
                ?>
                <?php
                if($PrivilegioImprimir){
                ?>
                <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $DatPedidoCompra->PcoId;?>',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                <?php
                }
                ?></td>
              </tr>
            
            <?php	
                $i++;
            }
            ?>
            
            
            <?php	
    
    }
    ?>
            
            </tbody>
          </table>
        
        <?php
}else{
?>
        
        
        <?php
    if(!empty($ArrVentaDirectas)){
    ?>
        <table width="100%" class="EstTablaListado">
          <thead class="EstTablaListadoHead">
            <tr>
              <th width="2%" align="center">#</th>
              <th width="8%" align="center">Ped. Compra</th>
              <th width="10%" align="center">Fecha</th>
              <th width="55%" align="center">Observacion</th>
              <th width="14%" align="center">Orden Compra</th>
              <th width="11%" align="center">Acciones</th>
              </tr>
            </thead>
          <tbody class="EstTablaListadoBody">
            <?php
    $i=1;
    foreach($ArrVentaDirectas as $DatVentaDirecta){
        
        //MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL) {
        $ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,"PcoTiempoCreacion","DESC",NULL,(NULL),(NULL),NULL,NULL,0,$DatVentaDirecta->VdiId,NULL,NULL,NULL);
        $ArrPedidoCompras = $ResPedidoCompra['Datos'];
        
    
    ?>
            <?php
            foreach($ArrPedidoCompras as $DatPedidoCompra){
            ?>
            
            
            <tr>
              <td><?php echo $i;?></td>
              <td align="left"><a target="_self"  href="principal.php?Mod=TallerPedido&amp;Form=Ver&amp;Id=<?php echo $DatPedidoCompra->PcoId;?>"> <?php echo $DatPedidoCompra->PcoId;?> </a></td>
              <td align="left"><?php echo $DatPedidoCompra->PcoFecha;?></td>
              <td align="left"><?php echo $DatPedidoCompra->PcoObservacion;?></td>
              <td align="center">
                
                <?php
				  
				  if(!empty($DatPedidoCompra->OcoId)){
				?>
                <?php echo $DatPedidoCompra->OcoId;?>
                <?php
				  }else{
				?>
                No tiene orden a proveedor
                <?php	  
				  }
				  
				  ?>
                
                
                
                </td>
              <td align="center"><?php
                if($PrivilegioVer){
                ?>
                <a target="_self"  href="principal.php?Mod=PedidoCompra&amp;Form=Ver&amp;Id=<?php echo $DatPedidoCompra->PcoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
                <?php
                }
                ?>
                <?php
                if($PrivilegioVistaPreliminar){
                ?>
                <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $DatPedidoCompra->PcoId;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                <?php
                }
                ?>
                <?php
                if($PrivilegioImprimir){
                ?>
                <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id=<?php echo $DatPedidoCompra->PcoId;?>&amp;P=1',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                <?php
                }
                ?>
                
                
                                   <?php
			if($PrivilegioVer){
			?>
 <a href="javascript:FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimirEstado.php?Id=<?php echo $DatPedidoCompra->PcoId;?>',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/ver_estado.png" alt="[Ver Estado]" title="Ver Estado" width="19" height="19" border="0" /></a>           
                <?php
			}
			?>
               
                
                </td>
              </tr>
            
            <?php	
                $i++;
            }
            ?>
            
            
            <?php	
    
    }
    ?>
            </tbody>
          </table>
        
        <?php
    }else{
    ?>
        No se encontraron ORDENES DE COMPRA para este PEDIDO DE TALLER
        <?php	
    }
    ?>
        
        
        <?php	
}
?>      
        </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
   </div>
   