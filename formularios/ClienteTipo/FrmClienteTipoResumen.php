<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") and empty($GET_dia)){
?>


<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */

//MESAJES

//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

//INSTANCIAS
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsClienteTipo = new ClsClienteTipo();
//ACCIONES

//DATOS
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
$VehiculoMarcasTotal = $RepVehiculoMarca['Total'];
$VehiculoMarcasTotalSeleccionado = $RepVehiculoMarca['TotalSeleccionado'];
//ALERTAS


/*
 * interface FrmVehiculoMarcaListado {
    //put your code here  
}
*/

?>



<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">RESUMEN TIPOS DE CLIENTE Y MARGEN DE UTILIDAD</span></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td valign="top"><table border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
    <tbody class="EstTablaListadoBody">
      <?php
                    foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
                    ?>
      <tr>
        <td colspan="3" align="left" valign="top" class="SubTitulo"><?php echo $DatVehiculoMarca->VmaNombre;?></td>
      </tr>
      <?php
$ResClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'LtiNombre','ASC',NULL,$DatVehiculoMarca->VmaId);
$ArrClienteTipos = $ResClienteTipo['Datos'];

?>
      <?php
foreach($ArrClienteTipos as $DatClienteTipo){
?>
      <tr>
        <td align="left" valign="top"><a href="principal.php?Mod=ClienteTipo&amp;Form=Ver&amp;Id=<?php echo $DatClienteTipo->LtiId?>"> <?php echo $DatClienteTipo->LtiNombre;?> </a></td>
        <td align="left" valign="top"><?php echo $DatClienteTipo->LtiUtilidad;?> %</td>
        <td align="left" valign="top"><?php echo $DatClienteTipo->LtiObservacion;?></td>
      </tr>
      <?php	
}
?>
      <?php
                    }
                    ?>
    </tbody>
  </table></td>
</tr>
<tr>
  <td width="82%" valign="top">&nbsp;</td>
</tr>
</table>


</div>


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

