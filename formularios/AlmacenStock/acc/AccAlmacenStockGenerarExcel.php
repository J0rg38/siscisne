<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"ALMACEN_STOCK_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>

<?php

//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

$InsACL = new ClsACL();
//$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"General","AccesoTotal"))?true:false;



$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = ($_POST['Num']);


if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}



$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';


/*
* Otras variables
*/
$POST_Estado = $_POST['Estado'] ?? '';
$POST_con = $_POST['Con'];
$POST_Referencia = $_POST['Referencia'];
$POST_IncluirReemplazo = $_POST['CmpIncluirReemplazo'];
$POST_Sucursal = $_POST['CmpSucursal'];
$POST_Almacen = ($_POST['CmpAlmacen']);
$POST_Ano = $_POST['CmpAno'];

if($_POST){
	$_SESSION['SesionAlmacen'] = $POST_Almacen;
}else{
	$POST_Almacen =  $_SESSION['SesionAlmacen'];	
}

//if($_POST){
//	$_SESSION['SesionSucursal'] = $POST_Sucursal;
//}else{
//	$POST_Sucursal = $_SESSION['SesionSucursal'];	
//}
if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}



if($_POST){
	
}else{
	$POST_est=1;
}


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'ProStockReal';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

/*
* Otras variables
*/


if(empty($POST_est)){
	$POST_est = 0;
}


if(empty($POST_con)){
	$POST_con = "contiene";
}
if(empty($POST_Ano)){
	$POST_Ano = date("Y");
}

$TieneMovimiento = true;	

$POST_pag = "";

//include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProductoListaPrecioCotizado.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsAlmacenStock = new ClsAlmacenStock();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

//include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenStock.php');

//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false)

/*if(!empty($POST_Almacen)){
	$TieneMovimiento = true;	
}else{
	$TieneMovimiento = false;
}*/
$TieneMovimiento = true;	
//deb($POST_IncluirReemplazo);

if($POST_IncluirReemplazo == "1"){
			
	$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10,PreCodigo11,PreCodigo12","esigual",$POST_fil,"PreId","ASC",NULL,1);
	$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
	
	$reemplazos = "";
	
	if(!empty($ArrProductoReemplazos)){
		foreach($ArrProductoReemplazos as $DatProductoReemplazo){
					
					if(!empty($DatProductoReemplazo->PreCodigo1)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo1;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo2)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo2;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo3)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo3;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo4)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo4;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo5)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo5;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo6)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo6;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo7)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo7;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo8)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo8;	
					}
					
					if(!empty($DatProductoReemplazo->PreCodigo9)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo9;	
					}
					
					
					if(!empty($DatProductoReemplazo->PreCodigo10)){
						$reemplazos.=",".$DatProductoReemplazo->PreCodigo10;	
					}
					
					
					
			}
		}
}



$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks("ProCodigoOriginal,ProCodigoAlternativo,ProNombre,ProId,ProCodigoBarra",$POST_con,$POST_fil.$reemplazos,$POST_ord,$POST_sen,1,$POST_pag,NULL,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,$POST_Referencia,NULL,NULL,$POST_Almacen,$TieneMovimiento,$POST_Sucursal,$POST_Ano);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];
$AlmacenStocksTotal = $ResAlmacenStock['Total'];
$AlmacenStocksTotalSeleccionado = $ResAlmacenStock['TotalSeleccionado'];



?>



<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="1%" >ID</th>
                <th width="4%" >COD. ORIG.</th>
                <th width="5%" >COD. ALT.</th>
                <th width="17%" >NOMBRE</th>
                <th width="5%" >MARCA</th>
                <th width="4%" >REF.</th>
                <th width="8%" >UBICACION</th>
                <th width="3%" >U.M.</th>
                <th width="4%" >STOCK</th>
                <th width="5%">POR LLEGAR</th>
                <th width="4%"> ULT. PED.</th>
                <th width="5%">LLEG. ESTIM.</th>
                <th width="4%">TIPO PED.</th>
                <th width="4%" > <?php

$FechaCosto = "";
$ListaMoneda = "";

?>
                  <?php

	$InsProductoListaPrecio = new ClsProductoListaPrecio();
	$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios(NULL,NULL,NULL,'PlpTiempoCreacion','DESC',"1",1);
	$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
					
    
    if(!empty($ArrProductoListaPrecios)){
		foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
			
			$FechaCosto = $DatProductoListaPrecio->PlpTiempoCreacion;
			$ListaMoneda = $DatProductoListaPrecio->MonSimbolo;
		
		}
    }
    ?>
                  Costo GM (<?php echo $ListaMoneda;?>)
  <?php

echo $FechaCosto;

?>
  <!--  Costo GM-->
                </th>
                <th width="5%" >Costo Cotizado</th>
                <th width="6%" >
                  Costo (<?php echo $EmpresaMoneda;?>) 
                </th>
                <th width="6%" >
                Precio (<?php echo $EmpresaMoneda;?>)
               </th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
            <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrAlmacenStocks as $dat){

								?>



              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="center" valign="middle"   >
                  
               
                    <?php echo $dat->ProId;  ?>
                    
                 
              <!--    <?php
				$clase = "";
				if($dat->AstStockPorcentaje >= 0 and $dat->AstStockPorcentaje <= 25){
					$clase = "EstAlmacenStockNivel1";
				}else if($dat->AstStockPorcentaje >= 26 and $dat->AstStockPorcentaje <= 50){
					$clase = "EstAlmacenStockNivel2";
				}else if($dat->AstStockPorcentaje >= 51 and $dat->AstStockPorcentaje <= 75){
					$clase = "EstAlmacenStockNivel3";
				}else if($dat->AstStockPorcentaje >= 76 and $dat->AstStockPorcentaje <= 100){
					$clase = "EstAlmacenStockNivel4";
				}
				?>
                  <div class="<?php echo $clase ?>" >
                    <?php echo $dat->AstStockPorcentaje; ?> %                
                    </div>
                  -->
                  
                </td>
                <td align="right" valign="middle"   ><?php echo $dat->ProCodigoOriginal;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->ProCodigoAlternativo;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->ProNombre; ?></td>
                <td  width="5%" align="right" ><?php echo $dat->ProMarca; ?></td>
                <td  width="4%" align="right" ><?php echo $dat->ProReferencia; ?></td>
                <td align="right" ><?php echo $dat->AstUbicacion; ?></td>
                <td align="right" ><?php echo $dat->UmeNombre; ?></td>
                <td align="right" bgcolor="#CC33CC" >
                  
                  
                  <?php echo number_format($dat->AstStockReal,2); ?>
                  
                  
                </td>
                <td align="center" ><?php echo number_format($dat->AstPedidoPorLLegar,2); ?></td>
                <td align="center" ><?php echo ($dat->AstPedidoUltimaFecha); ?></td>
                <td align="center">
                
                <?php echo ($dat->AstPedidoLlegadaEstimada); ?>
                
                </td>
                <td align="center"><?php echo ($dat->AstPedidoTipo); ?></td>
                <td  width="4%" align="center" bgcolor="#6FDB92" ><?php

$ProductoListaPrecioCosto = 0;
$ProductoListaPrecioMoneda = "";
?>
                  <?php

	$InsProductoListaPrecio = new ClsProductoListaPrecio();
	$ResProductoListaPrecio = $InsProductoListaPrecio->MtdObtenerProductoListaPrecios("PlpCodigo","esigual",$dat->ProCodigoOriginal,'PlpTiempoCreacion','DESC',"1",1);
	$ArrProductoListaPrecios = $ResProductoListaPrecio['Datos'];
					
    
    if(!empty($ArrProductoListaPrecios)){
		foreach($ArrProductoListaPrecios as $DatProductoListaPrecio){
			$ProductoListaPrecioMoneda = $DatProductoListaPrecio->MonSimbolo;
			$ProductoListaPrecioCosto = $DatProductoListaPrecio->PlpPrecioReal;
		
		}
    }
    ?>
                  <?php //echo $ProductoListaPrecioMoneda;?>
                  <?php

echo number_format($ProductoListaPrecioCosto,2);

?></td>
                <td  width="5%" align="right" ><?php

$ProductoListaPrecioCotizadoCosto = 0;
$ProductoListaPrecioCotizadoMoneda = "";
?>
                  <?php

		$InsProductoListaPrecioCotizado = new ClsProductoListaPrecioCotizado();
		//MtdObtenerProductoListaPrecioCotizado($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoId=NULL) {
		$ResProductoListaPrecioCotizado = $InsProductoListaPrecioCotizado->MtdObtenerProductoListaPrecioCotizado("pro.ProCodigoOriginal",$dat->ProCodigoOriginal,"OodTiempoCreacion","DESC",NULL,NULL);
		$ArrProductoListaPrecioCotizados = $ResProductoListaPrecioCotizado['Datos'];
		
			$ProductoListaPrecioMonedaId = "";
			$ProductoListaPrecioReal = 0;
			$ProductoListaPrecio = 0;
			
		if(!empty($ArrProductoListaPrecioCotizados)){
			foreach($ArrProductoListaPrecioCotizados as $DatProductoListaPrecioCotizado){
				
				if($DatProductoListaPrecioCotizado->MonId<>$EmpresaMonedaId){
					$PrecioConvertido = $DatProductoListaPrecioCotizado->OodPrecio / $DatProductoListaPrecioCotizado->OotTipoCambio;
				}else{
					$PrecioConvertido = $DatProductoListaPrecioCotizado->OodPrecio;
				}
				
				$ProductoListaPrecioCotizadoCosto =  $PrecioConvertido;
				$ProductoListaPrecioCotizadoMoneda =  $DatProductoListaPrecioCotizado->MonSimbolo;
			}
		}
		
?>
                  <?php echo $ProductoListaPrecioCotizadoMoneda;?>
                  <?php
echo number_format($ProductoListaPrecioCotizadoCosto,2);
?></td>
                <td  width="6%" align="right" ><?php echo number_format($dat->ProCosto,2); ?></td>
                <td  width="6%" align="right" ><!--    <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>-->
                  <?php echo number_format($dat->ProListaPrecioPrecio,2); ?></td>
                </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>
      
      
</body>
</html>