<?php

 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"CLIENTE_".date('d-m-Y').".xls\";");
 
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


require_once($InsProyecto->MtdRutClases().'ClsCliente.php');

$InsCliente = new ClsCliente();

$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,"CliNombre","ASC",NULL,NULL,NULL);
$ArrClientes = $ResCliente['Datos'];
$ClientesTotal = $ResCliente['Total'];
$ClientesTotalSeleccionado = $ResCliente['TotalSeleccionado'];


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado" >

      <thead class="EstTablaListadoHead">

              <tr>
                <th width="17" >#</th>
                <th width="68" >ID</th>
                <th width="286" >NOMBRE</th>
                <th width="452" >DIRECCION</th>
                <th width="158" >TELEFONO</th>
                <th width="177" >CELULAR</th>
                <th width="155" >ZONA</th>
                <th width="157" >CATEGORIA</th>
                <th width="157" >ESTADO</th>
                <th width="14" >&nbsp;</th>
                </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
            <tbody class="EstTablaListadoBody">
            <?php





								foreach($ArrClientes as $dat){

								?>

              <tr id="Fila_<?php echo $f;?>">
                <td align="center"  ><?php echo $f;?></td>
                <td align="right" valign="middle"   ><?php echo $dat->CliId;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->CliNombre; ?></td>
                <td align="right" ><?php echo $dat->CliDireccion; ?></td>
                <td align="right" ><?php echo $dat->CliTelefono; ?></td>
                <td align="right" ><?php echo $dat->CliCelular; ?></td>
                <td align="right" ><?php echo $dat->CliZona; ?></td>
                <td align="right" ><?php echo $dat->CcaNombre; ?></td>
                <td align="right" >
                  
                  
                  <?php
			switch($dat->CliEstado){
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
                <td align="right" >&nbsp;</td>
              </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>
