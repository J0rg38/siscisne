<?php

 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition:  filename=\"PROPIETARIO".date('d-m-Y').".xls\";");
 
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


require_once($InsProyecto->MtdRutClases().'ClsPropietario.php');

$InsPropietario = new ClsPropietario();

$ResPropietario = $InsPropietario->MtdObtenerPropietarios(NULL,NULL,NULL,"ConNombre","ASC",NULL,NULL,NULL);
$ArrPropietarios = $ResPropietario['Datos'];
$PropietariosTotal = $ResPropietario['Total'];
$PropietariosTotalSeleccionado = $ResPropietario['TotalSeleccionado'];
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
                <th width="155" >GARANTIA</th>
                <th width="157" >DEUDA</th>
                <th width="157" >FECHA RECIBO  (dd/mm/aaaa )</th>
                <th width="14" >FECHA REINGRESO  (dd/mm/aaaa )</th>
                </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
            <tbody class="EstTablaListadoBody">
            <?php





								foreach($ArrPropietarios as $dat){

								?>

              <tr id="Fila_<?php echo $f;?>">
                <td align="right" valign="middle"   ><?php echo $dat->ProId;  ?></td>
                <td align="right" valign="middle"   ><?php echo $dat->ProOtroCodigo; ?></td>
                <td align="right" ><?php echo $dat->ProNumeroDocumento; ?></td>
                <td align="right" ><?php echo $dat->ProNombre; ?></td>
                <td align="right" ><?php echo $dat->ProApellido; ?></td>
                <td align="right" ><?php echo $dat->ProTelefono; ?></td>
                <td align="right" ><?php echo $dat->ProCelular; ?></td>
                <td align="right" ><?php echo $dat->ProDireccion; ?></td>
                <td align="right" ><?php echo $dat->ProGarantia; ?></td>
                <td align="right" ><?php echo $dat->ProDeuda; ?></td>
                <td align="right" ><?php echo $dat->ProBreveteFechaExpiracion; ?></td>
                <td align="right" ><?php echo $dat->ProTurno; ?></td>
              </tr>

              <?php		$f++;

									}

									?>
            </tbody>
      </table>
