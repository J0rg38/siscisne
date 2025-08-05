<?php
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"VENTA_CONCRETADA_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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


$POST_cam = ($_POST['Cam']);
$POST_fil = ($_POST['Fil']);

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord']);
$POST_sen = ($_POST['Sen']);
$POST_pag = ($_POST['Pag']);
$POST_p = ($_POST['P']);
$POST_num = ($_POST['Num']);

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'];
$POST_acc = $_POST['Acc'];

/*
* Otras variables
*/
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'AmoTiempoModificacion';
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

if(empty($POST_finicio)){
$POST_finicio =  "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_estado)){
	$POST_estado = 0;
}
if(empty($POST_con)){
	$POST_con = "contiene";
}



require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');

$InsVentaConcretada = new ClsVentaConcretada();
     
$ResVentaConcretada = $InsVentaConcretada->MtdObtenerVentaConcretadas("AmoId,CliNombre,CliNumeroDocumento,amo.CprId,amo.VdiId",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,0,0);
$ArrVentaConcretadas = $ResVentaConcretada['Datos'];
$VentaConcretadasTotal = $ResVentaConcretada['Total'];
$VentaConcretadasTotalSeleccionado = $ResVentaConcretada['TotalSeleccionado'];

?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="2%" >ID</th>
                <th width="5%" >FECHA SALIDA</th>
                <th width="5%" >TIPO CLIENTE</th>
                <th width="3%" >TIPO DOC.</th>
                <th width="4%" >NUM. DOC.</th>
                <th width="10%" >CLIENTE</th>
                <th width="6%" >ORD. VEN.</th>
                <th width="3%" >COT.</th>
                <th width="4%" >G. REM.</th>
                <th width="3%" >FAC.</th>
                <th width="3%" >BOL.</th>
                <th width="8%" >DESC.</th>
                <th width="6%" >SUB TOTAL</th>
                <th width="7%" >IMPUESTO</th>
                <th width="4%" >TOTAL</th>
                <th width="3%" >ESTADO</th>
                <th width="2%" >IT.</th>
                <th width="6%" >ULTIMA MODIFICACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrVentaConcretadas as $dat){

								?>

           

              <tr id="Fila_<?php echo $f;?>">
                <td width="2%" align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle" width="2%"   >
				
				 <a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Ver&Id=<?php echo $dat->VcoId;?>">
				 <?php echo $dat->VcoId;  ?></a></td>
                <td  width="5%" align="right" ><?php echo ($dat->VcoFecha);?></td>
                <td  width="5%" align="right" ><?php echo ($dat->LtiNombre);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->TdoNombre);?></td>
                <td  width="4%" align="right" ><?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="10%" align="right" ><?php echo ($dat->CliNombre);?></td>
                <td  width="6%" align="right" >
				


				
<?php
if($PrivilegioVentaDirectaVer){
?>
<a href="javascript:FncVentaDirectaCargarFormulario('Ver','<?php echo $dat->VdiId?>');"  ><?php echo ($dat->VdiId);?></a>
<?php	
}else{
?>
<?php echo ($dat->VdiId);?>
<?php	
}
?>
	
    
	
	
	
                <td  width="3%" align="right" >
				
			
    				
<?php
if($PrivilegioCotizacionProductoVer){
?>
<a href="javascript:FncCotizacionProductoCargarFormulario('Ver','<?php echo $dat->CprId?>');"  ><?php echo ($dat->CprId);?></a>
<?php	
}else{
?>
<?php echo ($dat->CprId);?>
<?php	
}
?>
	
    
                
                
                </td>
                <td  width="4%" align="right" >
                
                <?php
				if($dat->VcoGuiaRemision == "Si"){
				?>

					<a href="formularios/VentaConcretada/DiaGuiaRemisionListado.php?height=440&amp;width=850&amp;AmoId=<?php echo $dat->VcoId;?>" class="thickbox" title=""><?php echo ($dat->VcoGuiaRemision); ?></a>

				<?php	
				}else{
				?>
                  <?php //echo ($dat->AmoGuiaRemision); ?>
                <?php	
				}
				?>
                
                
                </td>
                <td  width="3%" align="right" >
				
				<?php
				if($dat->VcoFactura == "Si"){
				?>
                  <a href="formularios/VentaConcretada/DiaFacturaListado.php?height=440&amp;width=850&amp;AmoId=<?php echo $dat->VcoId?>" class="thickbox" title=""><?php echo ($dat->VcoFactura); ?></a>
                  <?php	
				}else{
				?>
                  <?php //echo ($dat->AmoFactura); ?>
                <?php	
				}
				?></td>
                <td  width="3%" align="right" >
                
                
                <?php
				if($dat->VcoBoleta == "Si"){
				?>
                  <a href="formularios/VentaConcretada/DiaBoletaListado.php?height=440&amp;width=850&amp;AmoId=<?php echo $dat->VcoId?>" class="thickbox" title=""><?php echo ($dat->VcoBoleta); ?></a>
                  <?php	
				}else{
				?>
                  <?php //echo ($dat->AmoFactura); ?>
                <?php	
				}
				?>
                
                
                </td>
                <td  width="8%" align="right" ><?php echo number_format($dat->VcoDescuento,2);?>
                <?php
				
			
				?></td>
                <td  width="6%" align="right" ><?php echo number_format($dat->VcoSubTotal,2);?>
                <?php
					$SubTotal += $dat->VcoSubTotal ;
			
				?></td>
                <td  width="7%" align="right" ><?php echo number_format($dat->VcoImpuesto,2);?>
                <?php
					$Impuesto += $dat->VcoImpuesto ;
			
				?></td>
                <td  width="4%" align="right" >
                  
                  
                  <?php echo number_format($dat->VcoTotal,2);?>
                  <?php
					$Total += $dat->VcoTotal ;
			
				?>
                </td>
                <td  width="3%" align="right" >
				
                <?php echo $dat->VcoEstadoIcono; ?>
				<?php echo $dat->VcoEstadoDescripcion; ?>
                
                
				<?php
				/*switch($dat->VcoEstado){
					
						case 1:
				?>
                <!--  <img width="15" height="15" alt="[Transito]" title="En transito" src="imagenes/pendiente.gif" />-->
                
                 <img width="15" height="15" alt="[Pendiente/Anulado]" title="Pendiente/Anulado" src="imagenes/pendiente.gif" />
                
                  <?php
					
						break;
					
						case 3:
				?>
                  <img width="15" height="15" alt="[Realizado]" title="Realizado" src="imagenes/realizado.gif" />
                  <?php							
						break;	

					}*/
				?></td>
                <td  width="2%" align="right" ><?php echo ($dat->VcoTotalItems);?></td>
                <td  width="6%" align="right" ><?php echo ($dat->VcoTiempoModificacion);?></td>
        </tr>

              <?php		$f++;

									
								

                
                
									

									}
									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									$SubTotal = number_format($SubTotal,2);

									?>
            </tbody>
      </table>
