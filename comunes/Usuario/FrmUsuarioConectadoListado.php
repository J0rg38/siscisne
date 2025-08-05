<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');


require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');

$InsUsuario = new ClsUsuario();

$ResUsuario = $InsUsuario->MtdObtenerUsuarios(NULL,NULL,NULL,"UsuUltimaActividad","DESC",1,NULL,NULL,NULL);
$ArrUsuarios = $ResUsuario['Datos'];

$InsProyecto->Ruta = '';
$InsPoo->Ruta = '';
?>
<table class="EstTablaChat" width="100%" border="0" cellpadding="0" cellspacing="0">
<?php
foreach($ArrUsuarios as $DatUsuario){
?>
<tr>
  <td width="3%" align="center">
  <?php            
if(!empty($DatUsuario->UsuFoto)){
	
	$extension = strtolower(pathinfo($DatUsuario->UsuFoto, PATHINFO_EXTENSION));
	$nombre_base = basename($DatUsuario->UsuFoto, '.'.$extension);  
?>
    <a  href="subidos/usuario_fotos/<?php echo $DatUsuario->UsuFoto;?>" class="thickbox" title=""><img class="tooltip" border="0"  src="subidos/usuario_fotos/<?php echo $nombre_base."_thumb2.".$extension;?>"  /></a>
    <?php	
}
?></td>
  <td width="1%" valign="top">  
	<td width="94%" valign="top">
	  
  <?php
if($DatUsuario->UsuId==$_SESSION['SesionId']){
?>
	  (<?php echo $DatUsuario->UsuUsuario;?>) <?php echo $DatUsuario->PerNombre;?> <?php echo $DatUsuario->PerApellidoPaterno;?>  <?php echo $DatUsuario->PerApellidoMaterno;?> 
	  
  <?php
}else{

$username = $DatUsuario->UsuUsuario." ".$DatUsuario->PerNombre." ".$DatUsuario->PerApellidoPaterno." ".$DatUsuario->PerApellidoMaterno;
$username = eregi_replace(' ','_',$username);
?>
	  
  <a href="javascript:chatWith('<?php echo $username;?>');">
  <span title="Enviar mensajes a <?php echo $DatUsuario->PerNombre;?> <?php echo $DatUsuario->PerApellidoPaterno;?> <?php echo $DatUsuario->PerApellidoMaterno;?>" class="EstChatEnlace" >
    (<?php echo $DatUsuario->UsuUsuario;?>) <?php echo $DatUsuario->PerNombre;?> <?php echo $DatUsuario->PerApellidoPaterno;?> <?php echo $DatUsuario->PerApellidoMaterno;?> 
  </span>
  </a>
  <?php	
}
?>
	  
	  
<td width="2%" align="right" valign="top"><?php
	switch($DatUsuario->UsuConectado){
		case 1:
	?>
	<img src="imagenes/offline.png" alt="[Desconectado]" title="Desconectado <?php echo $DatUsuario->UsuUltimaActividad; ?>" border="0" align="absmiddle" width="8" height="8" />
    
  <!--<img src="imagenes/desconectado.png" alt="[Desc.]" title="Desconectado <?php echo $DatUsuario->UsuUltimaActividad; ?>" border="0" align="absmiddle" width="15" height="15" />-->
  <?php
    	break;
		
		case 2:
	?>
  <!--<img src="imagenes/conectado.png" alt="[Conec.]" title="Conectado <?php echo $DatUsuario->UsuUltimaActividad; ?>" border="0" align="absmiddle" width="15" height="15" />-->
	<img src="imagenes/online.png" alt="[Conectado]" title="Conectado <?php echo $DatUsuario->UsuUltimaActividad; ?>" border="0" align="absmiddle" width="8" height="8" />
  <?php
		break;
		
		case 3:
	?>
<img src="imagenes/inactivo2.png" alt="[Inactivo]" title="Inactivo <?php echo $DatUsuario->UsuUltimaActividad; ?>" border="0" align="absmiddle" width="8" height="8" />
  <!--    <img src="imagenes/inactivo.png" alt="[Inac.]" title="Inactivo <?php echo $DatUsuario->UsuUltimaActividad; ?>" border="0" align="absmiddle" width="15" height="15" />-->
  <?php
		break;
	}
	?></td>
  </tr>
<?php	
}
?>
</table>