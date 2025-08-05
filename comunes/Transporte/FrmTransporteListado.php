<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
require_once('paquetes/PaqLogistica/Clases/ClsTransporte.php');
//require_once('paquetes/PaqLogistica/Clases/ClsTransporteCategoria.php');


$InsTransporte = new ClsTransporte();
//$InsTransporteCategoria = new ClsTransporteCategoria();

$ResTransporte = $InsTransporte->MtdObtenerTransportes($_POST['Campo'],$_POST['Condicion'],$_POST['Filtro'],$_POST['Campo'],"ASC",1,NULL,NULL,$_POST['Categoria'],true);

$ArrTransportes = $ResTransporte['Datos'];
$TransportesTotal = $ResTransporte['Total'];

//$ResTransporteCategoria = $InsTransporteCategoria->MtdObtenerTransporteCategorias(NULL,NULL,"TcaNombre","ASC",1,NULL);
//$ArrTransporteCategorias = $ResTransporteCategoria['Datos'];

?>





<?php
if(empty($ArrTransportes)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $TransportesTotal;?> elemento(s)
<table class="EstTablaListado" width="800" cellpadding="2" cellspacing="1" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="3%">#</th>
  <th width="17%">R.U.C.</th>
  <th width="56%">
Nombre</th>
  <th width="19%">Dirección</th>
  <th width="5%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrTransportes as $DatTransporte){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="left"><?php echo $DatTransporte->TraNumeroDocumento;?></td>
<td align="left">
<?php echo $DatTransporte->TraNombre;?></td>
<td align="left"><?php echo $DatTransporte->TraDireccion;?></td>
<td align="center">

<a  href="javascript:FncTransporteEscoger('<?php echo $DatTransporte->TraId;?>','<?php echo $DatTransporte->TraNumeroDocumento;?>','<?php echo $DatTransporte->TraNombre;?>','<?php echo $DatTransporte->TraDireccion;?>');">
<img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  /></a></td>
</tr>
<?php
$c++;
}
?>
</tbody>
</table>

<?php
}
?>

