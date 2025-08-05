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

<?php $PrivilegioVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VentaConcretada","Imprimir"))?true:false;?>



<?php

$GET_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];


require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsProducto = new ClsProducto();
$InsMoneda = new ClsMoneda();
$InsClienteListaPrecio = new ClsClienteListaPrecio();
$InsAlmacen = new ClsAlmacen();


$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$GET_ProductoCodigoOriginal,"PreId","ASC",NULL,1);
$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];

$ArrReemplazos = array();

if(!empty($ArrProductoReemplazos)){
	foreach($ArrProductoReemplazos as $DatProductoReemplazo){
			
			if(!empty($DatProductoReemplazo->PreCodigo1)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo1;	
			}
			
			if(!empty($DatProductoReemplazo->PreCodigo2)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo2;	
			}
			
				if(!empty($DatProductoReemplazo->PreCodigo3)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo3;	
			}
			
					if(!empty($DatProductoReemplazo->PreCodigo4)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo4;	
			}
			
						if(!empty($DatProductoReemplazo->PreCodigo5)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo5;	
			}
			
						if(!empty($DatProductoReemplazo->PreCodigo6)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo6;	
			}
			
						if(!empty($DatProductoReemplazo->PreCodigo7)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo7;	
			}
			
						if(!empty($DatProductoReemplazo->PreCodigo8)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo8;	
			}
			
						if(!empty($DatProductoReemplazo->PreCodigo9)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo9;	
			}
			
			
						if(!empty($DatProductoReemplazo->PreCodigo10)){
				$ArrReemplazos[]=$DatProductoReemplazo->PreCodigo10;	
			}
			
			
			
	}
}

?>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="98%"><span class="EstFormularioSubTitulo"> Listado de codigos de reemplazo</span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
      
      Codigos de reemplazo para <?php echo $GET_ProductoCodigoOriginal;?>
      
<?php
if(!empty($ArrReemplazos)){
?>

      <table width="100%" class="EstTablaListado">
      <thead class="EstTablaListadoHead">
      <tr>
        <th width="3%" align="center">#</th>
        <th width="12%" align="center">Codigo</th>
        <th width="39%" align="center">Stock Local</th>
        <th width="46%" align="center">
        
        Disponible (Lista GM)

    
    <?php
        $FechaDisponibilidad = "";
        
        $ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades(NULL,NULL,NULL ,"PdiTiempoCreacion","DESC","1",1);
        $ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
        
        if(!empty($ArrProductoDisponibilidades)){
            foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
                
                $FechaDisponibilidad = $DatProductoDisponibilidad->PdiTiempoCreacion;
            
            }
        }
    ?>
    
    <?php
    echo $FechaDisponibilidad;
    ?>
    
    </th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
<?php
$i=1;
$ArrReemplazos = array_unique($ArrReemplazos);

foreach($ArrReemplazos as $DatReemplazo){
?>

    <tr>
        <td><?php echo $i;?></td>
        <td align="center">
         
            <?php echo $DatReemplazo;?>
           
        </td>
        <td align="center">
		

<?php
$InsAlmacenStock = new ClsAlmacenStock();
$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks("ProCodigoOriginal","esigual",$DatReemplazo,"ProId","ASC",1,"1",NULL,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];
?>

<?php
$Stock = 0;
if(!empty($ArrAlmacenStocks)){
	foreach($ArrAlmacenStocks as $DatAlmacenStock){
		$Stock = $DatAlmacenStock->AstStockReal;
	}
}
?>

<?php echo number_format($Stock,2); ?>

        </td>
        <td align="center">
        

<?php
$Disponibilidad = "";

if(!empty($DatReemplazo)){

	$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
	$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",trim($DatReemplazo) ,"PdiTiempoCreacion","DESC","1",1);
	$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
	
	//$Disponibilidad = "";
	$Disponibilidad = "NO";
	$Cantidad = 0;
	
	if(!empty($ArrProductoDisponibilidades)){
		foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
			
			$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
			$Cantidad =  ($DatProductoDisponibilidad->PdiCantidad);
		
		}
	}
}
?>

<?php echo $Disponibilidad;?> (<?php echo number_format($Cantidad,2);?>)

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
No se encontraron codigos de reemplazo<?php	
}
?>      
      </td>
      <td>&nbsp;</td>
    </tr>

  </table>
</div>
   </div>
   