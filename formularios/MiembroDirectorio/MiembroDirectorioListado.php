<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */

$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = ($_POST['Fil'] ?? '');

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = $_POST['Sen'] ?? '';
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = $_POST['Num'] ?? '';

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

$POST_Cargo = $_POST['Cargo'];
$POST_Estado = $_POST['Estado'] ?? '';
$POST_con = $_POST['Con'];

if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'MdiTiempoModificacion';
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

if(empty($POST_con)){
	$POST_con = "contiene";
}
//MENSAJES

//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsMiembroDirectorio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
//INSTANCIAS
$InsMiembroDirectorio = new ClsMiembroDirectorio();
$InsTipoDocumento = new ClsTipoDocumento();
//ACCIONES

//DATOS
$ResMiembroDirectorio = $InsMiembroDirectorio->MtdObtenerMiembroDirectorios($POST_cam,$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_est,$POST_Cargo);
$ArrMiembroDirectorios = $ResMiembroDirectorio['Datos'];
$MiembroDirectoriosTotal = $ResMiembroDirectorio['Total'];
$MiembroDirectoriosTotalSeleccionado = $ResMiembroDirectorio['TotalSeleccionado'];


//ALERTAS


/*
 * interface FrmMiembroDirectorioListado {
    //put your code here  
}
*/

?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="2%" >#</th>
                <th width="4%" >ID</th>
                <th width="5%" >CARGO</th>
                <th width="14%" >NOMBRE</th>
                <th width="9%" >APE. PATERNO</th>
                <th width="9%" >APE. MATERNO</th>
                <th width="7%" >EMAIL</th>
                <th width="7%" >TELEFONO</th>
                <th width="6%" >CELULAR</th>
                <th width="12%" >DIRECCION </th>
                <th width="3%" >ESTADO</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
  <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;

								foreach($ArrMiembroDirectorios as $dat){

								?>

          
          
          
          
          
          

              <tr  >
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->MdiId;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->MdiCargoDescripcion;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->MdiNombre; ?></td>
                <td align="right" ><?php echo $dat->MdiApellidoPaterno; ?></td>
                <td align="right" ><?php echo $dat->MdiApellidoMaterno; ?></td>
                <td align="right" ><?php echo ($dat->MdiEmail);?></td>
                <td align="right" ><?php echo ($dat->MdiTelefono);?></td>
                <td align="right" ><?php echo ($dat->MdiCelular);?></td>
                <td align="right" ><?php echo ($dat->MdiDireccion);?></td>
                <td align="right" ><?php
			switch($dat->MdiEstado){
				case 1:
			?>
En Actividad
                  <?php
				break;
				
				case 2:
			?>
Sin Actividad
                  <?php
				break;

			}
			?></td>
          </tr>

              <?php		$f++;

									}

									?>
                                    
                                    
                                    
                                    
                                    
                                    
            </tbody>
      </table>

