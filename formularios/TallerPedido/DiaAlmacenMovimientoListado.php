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
$GET_Precio = $_GET['Precio'];

//require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
//$InsTallerPedido = new ClsTallerPedido();

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');

$InsTallerPedido = new ClsTallerPedido();
$InsFacturaAlmacenMovimiento = new ClsFacturaAlmacenMovimiento();
$InsBoletaAlmacenMovimiento = new ClsBoletaAlmacenMovimiento();
////MtdObtenerTallerPedidos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL) {
//$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,"AmoFecha","DESC",NULL,NULL,NULL,NULL,NULL,$GET_FinId,0,0,NULL,NULL,false,NULL);
//$ArrTallerPedidos = $ResTallerPedido['Datos'];

$InsBoleta = new ClsBoleta();
$InsFactura = new ClsFactura();


$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoFecha','DESC',NULL,NULL,NULL,NULL,NULL,$GET_FinId);
$ArrTallerPedidos = $ResTallerPedido['Datos'];				



?>

<script type="text/javascript">
/*
* VISTA PRELIMINAR OTROS
*/


function FncFacturaVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				FncPopUp('formularios/Factura/FrmFacturaImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "3":
	
				FncPopUp('formularios/Factura/FrmFacturaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
		
		}
		
	}

}



function FncBoletaVistaPreliminar(oId,oTalonario,oOpcion){
	
	if(oOpcion==null){
		oOpcion = "1";
	}
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)",
oOpcion);
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario+'',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

						FncPopUp('formularios/Boleta/FrmBoletaImprimir2.php?Id='+oId+'&Ta='+oTalonario+'',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

						FncPopUp('formularios/Boleta/FrmBoletaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
				}
				
			}
			
}

//function FncFacturaVistaPreliminar(oId,oTalonario){
//
//	FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
//
//}


//function FncBoletaVistaPreliminar(oId,oTalonario){
//
//	FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
//
//}
//

</script>

<div class="EstFormularioArea"> 
    <div id="ForBuscadorProductos"  >
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="98%"><span class="EstFormularioSubTitulo"> Listado de fichas de salida </span></td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
    <?php
    if(!empty($ArrTallerPedidos)){
    ?>
    
          <table width="100%" class="EstTablaListado">
          <thead class="EstTablaListadoHead">
          <tr>
            <th width="2%" align="center">#</th>
            <th width="6%" align="center">Cod. Mov. Alm.</th>
            <th width="7%" align="center">Fecha</th>
            <th width="9%" align="center">Modalidad</th>
            <th width="42%" align="center">Observacion</th>
            <th width="10%" align="center">Factura</th>
            <th width="8%" align="center">Boleta</th>
            <th width="6%" align="center">Revisar</th>
            <th width="10%" align="center">Acciones</th>
            </tr>
            </thead>
            <tbody class="EstTablaListadoBody">
    <?php
    $i=1;
    foreach($ArrTallerPedidos as $DatTallerPedido){
    ?>
    
        <tr>
            <td><?php echo $i;?></td>
            <td align="left">
            <a target="_self"  href="principal.php?Mod=AlmacenMovimientoSalida&Form=Ver&Id=<?php echo $DatTallerPedido->AmoId;?>">
            <?php echo $DatTallerPedido->AmoId;?>
            </a>
            </td>
            <td align="left"><?php echo $DatTallerPedido->AmoFecha;?></td>
            <td align="left"><?php echo $DatTallerPedido->MinNombre;?></td>
            <td align="left"><?php echo $DatTallerPedido->AmoObservacion;?></td>
            <td align="center">
            <?php
    $ResFacturaAlmacenMovimiento = $InsFacturaAlmacenMovimiento->MtdObtenerFacturaAlmacenMovimientos(NULL,NULL,'FamId','Desc',NULL,NULL,NULL,$DatTallerPedido->AmoId,true,"3");
    $ArrFacturaAlmacenMovimientos = $ResFacturaAlmacenMovimiento['Datos'];
    ?>
    
    <?php
    foreach($ArrFacturaAlmacenMovimientos as $DatFacturaAlmacenMovimiento){
    ?>
    
    				
 <a href="javascript:FncFacturaVistaPreliminar('<?php echo $DatFacturaAlmacenMovimiento->FacId;?>','<?php echo $DatFacturaAlmacenMovimiento->FtaId;?>');">
 
 
 
    <?php echo $DatFacturaAlmacenMovimiento->FtaNumero ?> - <?php echo $DatFacturaAlmacenMovimiento->FacId ?></a><br />
    <?php
    }
    ?>
            
    <?php
    //MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL)
    /*$ResFactura = $InsFactura->MtdObtenerFacturas(NULL,NULL,NULL,"FacFechaEmision","ASC",NULL,NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$DatTallerPedido->AmoId);
    $ArrFacturas = $ResFactura['Datos'];
    ?>
              <?php
    foreach($ArrFacturas as $DatFactura){
    ?>
              <?php echo $DatFactura->FtaNumero ?> - <?php echo $DatFactura->FacId ?><br />
              <?php
    }*/
    ?></td>
            <td align="center">
            
    <?php
    //MtdObtenerBoletaAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oBoleta=NULL,$oBoletaTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL)
    $ResBoletaAlmacenMovimiento = $InsBoletaAlmacenMovimiento->MtdObtenerBoletaAlmacenMovimientos(NULL,NULL,'BamId','Desc',NULL,NULL,NULL,$DatTallerPedido->AmoId,true,"3");
    $ArrBoletaAlmacenMovimientos = $ResBoletaAlmacenMovimiento['Datos'];
    ?>
    
    
    <?php
    foreach($ArrBoletaAlmacenMovimientos as $DatBoletaAlmacenMovimiento){
    ?>
     <a href="javascript:FncBoletaVistaPreliminar('<?php echo $DatBoletaAlmacenMovimiento->BolId;?>','<?php echo $DatBoletaAlmacenMovimiento->BtaId;?>');"> 
                
                
        <?php echo $DatBoletaAlmacenMovimiento->BtaNumero ?> - <?php echo $DatBoletaAlmacenMovimiento->BolId ?></a><br />
    <?php	
    }
    ?>
            
            <?php
    // MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL)
    /*$ResBoleta = $InsBoleta->MtdObtenerBoletas(NULL,NULL,NULL,"BolFechaEmision","ASC",NULL,"5",NULL,NULL,NULL,NULL,NULL,NULL,$DatTallerPedido->AmoId);
    $ArrBoletas = $ResBoleta['Datos'];
    ?>
              <?php
    foreach($ArrBoletas as $DatBoleta){
    ?>
              <?php echo $DatBoleta->BtaNumero ?> - <?php echo $DatBoleta->BolId ?><br />
              <?php	
    }*/
    ?></td>
            <td align="left">
              
              <?php
            if(!empty($DatTallerPedido->AmoSinPrecio)){
            ?>	
              <img src="imagenes/advertencia.png" alt="Advertencia" width="20" height="20" border="0" title="Advertencia" />
              Existen (<?php echo $DatTallerPedido->AmoSinPrecio;?>) items sin precio.        
              <?php	
            }
            ?>
              
            </td>
            <td align="center">
        
            <?php
                if($PrivilegioVer){
                ?>
             <a target="_self"  href="principal.php?Mod=TallerPedido&Form=Ver&Id=<?php echo $DatTallerPedido->AmoId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>                
                <?php
                }
                ?>
                        
             <?php
                if($PrivilegioVistaPreliminar){
                ?>
             <a href="javascript:FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id=<?php echo $DatTallerPedido->AmoId;?>&Precio=<?php echo $GET_Precio;?>',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/acciones/preliminar.gif" alt="[Vista Preliminar]" title="Vista preliminar" width="19" height="19" border="0" /></a>
                <?php
                }
                ?>
            
                <?php
                if($PrivilegioImprimir){
                ?>        
         
                    <a href="javascript:FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id=<?php echo $DatTallerPedido->AmoId;?>&P=1&Precio=<?php echo $GET_Precio;?>',0,0,1,0,1,1,0,screen.height,screen.width);"><img src="imagenes/acciones/imprimir.png" alt="[Imprimir]" title="Imprimir" width="19" height="19" border="0" /></a>
                <?php
                }
                ?> 
             
             
    <?php
    if($PrivilegioGenerarGuiaRemision){
    ?>
        <a href="principal.php?Mod=GuiaRemision&Form=Registrar&Ori=FichaAccion&FccId=<?php echo $DatTallerPedido->FccId;?>&AmoId=<?php echo $DatTallerPedido->AmoId;?>"><img src="imagenes/generar_guia_remision.png" width="19" height="19" border="0" title="Generar Guia de Remision" alt="[Generar Guia de Remision]"   /></a>
    <?php
    }
    ?>
    
    
            </td>
            </tr>
            
    <?php
    $i++;
    }
    ?>
          
          </tbody>
          </table>
    
    <?php
    }else{
    ?>
        No se encontraron FICHAS DE SALIDA para este PEDIDO DE TALLER
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
   