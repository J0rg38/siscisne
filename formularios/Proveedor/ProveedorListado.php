<?php


$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = ($_POST['Sen'] ?? '');
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = ($_POST['Num'] ?? '');

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

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'PrvTiempoModificacion';
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

require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');

$InsProveedor = new ClsProveedor();
////MtdObtenerProveedores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PrvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)
$ResProveedor = $InsProveedor->MtdObtenerProveedores($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est);
$ArrProveedores = $ResProveedor['Datos'];
$ProveedoresTotal = $ResProveedor['Total'];
$ProveedoresTotalSeleccionado = $ResProveedor['TotalSeleccionado'];
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th >#</th>
                <th >ID</th>
                <th >TIPO DOC.</th>
                <th >NUM. DOCUMENTO</th>
                <th >NOMBRE</th>
                <th >DIRECCION</th>
                <th >TELEFONO</th>
                <th >CELULAR</th>
                <th >CTO. NOMBRE 1</th>
                <th >CTO. CELULAR 1</th>
                <th >CTO. EMAIL 1</th>
                <th >CTO. NOMBRE 2</th>
                <th >CTO. CELULAR 2</th>
                <th >CTO. EMAIL 2</th>
                <th >CTO. NOMBRE 3 </th>
                <th >CTO. CELULAR 2</th>
                <th >CTO. EMAIL 3</th>
                <th >ESTADO</th>
                </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
            <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrProveedores as $dat){

								?>



              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->PrvId;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->TdoNombre; ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->PrvNumeroDocumento; ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->PrvNombre; ?></td>
                <td align="right" ><?php echo $dat->PrvDireccion; ?></td>
                <td align="right" ><?php echo $dat->PrvTelefono; ?></td>
                <td align="right" ><?php echo $dat->PrvCelular; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoNombre1; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoCelular1; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoEmail1; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoNombre2; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoCelular2; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoEmail2; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoNombre3; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoCelular3; ?></td>
                <td align="right" ><?php echo $dat->PrvContactoEmail3; ?></td>
                <td align="right" >
                  
                  
                  <?php
			switch($dat->PrvEstado){
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
			?>                </td>
                </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>