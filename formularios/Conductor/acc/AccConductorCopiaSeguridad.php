<?php

 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"CONDUCTOR_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta = '../../../';

/*
*Configuraciones
*/
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

/*
*Clases de Conexion
*/
require_once($InsProyecto->MtdRutClases().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsProyecto->MtdRutClases().'ClsConductor.php');

$InsConductor = new ClsConductor();

$ResConductor = $InsConductor->MtdObtenerConductores(NULL,NULL,NULL,"ConNombre","ASC",NULL,NULL,NULL);
$ArrConductores = $ResConductor['Datos'];
$ConductoresTotal = $ResConductor['Total'];
$ConductoresTotalSeleccionado = $ResConductor['TotalSeleccionado'];


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th width="68" >COD. SISTEMA</th>
                <th width="286" >COD. ALTERNATIVO</th>
                <th width="452" >NUM. DOCUMENTO</th>
                <th width="158" >NOMBRE</th>
                <th width="158" >APELLIDOS</th>
                <th width="158" >TELEFONO</th>
                <th width="177" >CELULAR</th>
                <th width="155" >DIRECCION</th>
                <th width="157" >NUM. BREVETE</th>
                <th width="157" >FECHA EXPIRACION BREVETE (dd/mm/aaaa )</th>
                <th width="14" >TURNO</th>
                </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
            <tbody class="EstTablaListadoBody">
            <?php





								foreach($ArrConductores as $dat){

								?>

              <tr id="Fila_<?php echo $f;?>">
                <td align="right" valign="middle"   ><?php echo $dat->ConId;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->ConOtroCodigo; ?></td>
                <td align="right" ><?php echo $dat->ConNumeroDocumento; ?></td>
                <td align="right" ><?php echo $dat->ConNombre; ?></td>
                <td align="right" ><?php echo $dat->ConApellido; ?></td>
                <td align="right" ><?php echo $dat->ConTelefono; ?></td>
                <td align="right" ><?php echo $dat->ConCelular; ?></td>
                <td align="right" ><?php echo $dat->ConDireccion; ?></td>
                <td align="right" ><?php echo $dat->ConNumeroBrevete; ?></td>
                <td align="right" ><?php echo $dat->ConBreveteFechaExpiracion; ?></td>
                <td align="right" ><?php echo $dat->ConTurno; ?></td>
              </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>
