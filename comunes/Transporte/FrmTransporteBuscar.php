<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

/*
*Clases de Conexion
*/
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');

/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
?>


<!--
Libreria para Arbol
-->
<?php require_once('librerias/jbarbol/jbarbol.php');?>
<link rel="stylesheet" type="text/css" media="all" href="librerias/jbarbol/jbacss.css" />




<?php
require_once('paquetes/PaqLogistica/Clases/ClsTransporteCategoria.php');

$InsTransporteCategoria = new ClsTransporteCategoria();

$RepTransporteSubCategoria = $InsTransporteCategoria->MtdObtenerTransporteCategorias(NULL,NULL,"TcaNombre","ASC",1,NULL,NULL,true);
$ArrTransporteSubCategorias = $RepTransporteSubCategoria['Datos'];


?>

<?php
$InsPoo->Ruta = '';
$InsProyecto->Ruta = '';
?>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdComunesCss("Transporte");?>/CssTransporte.css');
</style>




<div class="EstFormularioArea">

<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstFormulario">

<tr>
  <td>&nbsp;</td>
  <td width="704">B&uacute;squeda de Transportes</td>
  <td align="right">&nbsp;</td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left"><select onchange="FncTransporteFiltrar2();" class="EstFormularioCombo" name="CmpTransporteCategoria" id="CmpTransporteCategoria">
    <option value="0" >Todos </option>
    <?php echo FncArbol($ArrTransporteSubCategorias,0,false,NULL,"TcaNombre","TcaId","TransporteSubCategoria"); ?>
  </select></td>
  <td align="left">&nbsp;</td>
</tr>
<tr>
  <td width="1" align="left">&nbsp;</td>
  <td align="left"><select name="CmpTransporteCampo" id="CmpTransporteCampo" class="EstFormularioCombo">
    <option value="TraNombre">Nombre</option>
    <option value="TraNumeroDocumento">R.U.C.</option>
    <option value="TraDireccion">Direccion</option>
    </select>
    <select class="EstFormularioCombo" name="CmpTransporteCondicion" id="CmpTransporteCondicion">
      <option value="esigual">Es igual a</option>
      <option value="noesigual">No es igual a</option>
      <option value="comienza">Comienza por</option>
      <option value="termina">Termina con</option>
      <option value="contiene">Contiene</option>
      <option value="nocontiene">No Contiene</option>
    </select>
<input name="CmpTransporteFiltro" type="text" class="EstFormularioCaja" id="CmpTransporteFiltro" size="45" maxlength="255" onkeyup="FncTransporteFiltrar(event);" />
	<a href="javascript:FncTransporteFiltrar2();"><img border="0"  align="absmiddle" src="imagenes/buscar.gif" alt="[Buscar]" title="Buscar" width="20" height="20" /></a></td>
  <td width="6" align="left">&nbsp;</td>
</tr>


<tr>
  <td>&nbsp;</td>
  <td><div class="EstCapTransportes" id="CapTransportes"></div></td>
  <td>&nbsp;</td>
</tr>
</table>


</div>
