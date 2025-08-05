<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */

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

//Nuevo
$POST_ProductoTipo = $_POST['CmpProductoTipo'];
$POST_con = $_POST['Con'];
$POST_est = $_POST['Est'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'ProTiempoModificacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

if(empty($POST_cam)){
	$POST_cam = "ProNombre";
}

// Variables Extra

if(empty($POST_con)){
	$POST_con = "contiene";
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');

$InsProducto = new ClsProducto();
$InsProductoTipo = new ClsProductoTipo();


$ResProducto = $InsProducto->MtdObtenerProductos($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,NULL,$POST_est,$POST_ProductoTipo,NULL);
$ArrProductos = $ResProducto['Datos'];
$ProductosTotal = $ResProducto['Total'];
$ProductosTotalSeleccionado = $ResProducto['TotalSeleccionado'];



/*
 * interface FrmProductoListado {
    //put your code here  
}
*/

?>


    
    
    
    <table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >
      
      <thead class="EstTablaListadoHead">
        
        <tr>
          <th width="2%" >#</th>
          <th width="2%" >ID</th>
          <th width="5%" >TIPO</th>
          <th width="8%" >COD. ALT.</th>
          <th width="7%" >COD. ORIG.</th>
          <th width="18%" >NOMBRE</th>
          <th width="10%" >REFERENCIA</th>
          <th width="9%" >UBICACION</th>
          <th width="6%" >COSTO </th>
          <th width="6%" >PRECIO</th>
          <th width="6%" >U.M.</th>
          <th width="4%" >STK. MIN.</th>
          <th width="4%" >FOTO</th>
          <th width="5%" >ESPEC.</th>
          <th width="8%" >EST.</th>
          </tr>
        </thead>
      
      <tfoot class="EstTablaListadoFoot">
        </tfoot>
      <tbody class="EstTablaListadoBody">
        <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrProductos as $dat){

								?>
        
        
        
        <tr id="Fila_<?php echo $f;?>">
          <td width="2%" align="center"  ><?php echo $f;?></td>
          <td align="right" valign="middle" width="2%"   ><?php echo $dat->ProId;  ?></td>
          <td align="right" valign="middle" width="5%"   ><?php echo $dat->RtiNombre; ?></td>
          <td align="right" valign="middle" width="8%"   ><?php echo $dat->ProCodigoAlternativo; ?></td>
          <td align="right" valign="middle" width="7%"   ><?php echo $dat->ProCodigoOriginal; ?></td>
          <td align="right" valign="middle" width="18%"   ><?php echo $dat->ProNombre; ?></td>
          <td  width="10%" align="right" ><?php echo $dat->ProReferencia; ?></td>
          <td  width="9%" align="right" ><?php echo $dat->ProUbicacion; ?></td>
          <td  width="6%" align="right" ><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span><?php echo $dat->ProCosto; ?></td>
          <td  width="6%" align="right" ><span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span><?php echo $dat->ProPrecio; ?></td>
          <td  width="6%" align="right" ><?php echo $dat->UmeNombre; ?></td>
          <td  width="4%" align="right" ><?php echo $dat->ProStockMinimo; ?></td>
          <td  width="4%" align="right" >
          
		  
		  <?php
if(!empty($dat->ProFoto)){
?>
            SI
            
            <?php
}else{
?>
NO
<?php	
}
			?> 
            
            </td>
          <td  width="5%" align="right" >
<?php
if(!empty($dat->ProEspecificacion)){
?>
            SI
            <?php
}else{
?>
NO
<?php
}
?>

</td>
          <td  width="8%" align="right" ><?php
			switch($dat->ProEstado){
				case 1:
			?>
            ACTIVO
            <?php
				break;
				
				case 2:
			?>
		INACTIVO
            <?php
				break;

			}
			?></td>
          <?php

?>	
          </tr>
        
        <?php		$f++;

									}

									?>
        </tbody>
      </table>


