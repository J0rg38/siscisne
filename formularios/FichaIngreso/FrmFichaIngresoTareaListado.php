<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaIngresoTarea'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoTarea'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

/*
SesionObjeto-FichaIngresoTarea
Parametro1 = FitId
Parametro2 =
Parametro3 = FitDescripcion
Parametro4 =
Parametro5 =
Parametro6 = FitAccion
Parametro7 = FitTiempoCreacion
Parametro8 = FitTiempoModificacion
*/

$RepSesionObjetos = $_SESSION['InsFichaIngresoTarea'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


?>


<?php
$FichaIngresoTarea = false;
$FichaIngresoPlanchado = false;
$FichaIngresoPintado = false;
$FichaIngresoCentrado = false;
$FichaIngresoTarea = false;

foreach($ArrSesionObjetos as $DatSesionObjeto){
	
	if($DatSesionObjeto->Parametro6 == "L"){
		$FichaIngresoPlanchado = true;
	}

	if($DatSesionObjeto->Parametro6 == "N"){
		$FichaIngresoPintado = true;
	}

	if($DatSesionObjeto->Parametro6 == "E"){
		$FichaIngresoCentrado = true;
	}
	
	if($DatSesionObjeto->Parametro6 == "Z"){
		$FichaIngresoReparacion = true;
	}
	
	if($DatSesionObjeto->Parametro6 == "I" or $DatSesionObjeto->Parametro6 == "R"){
		$FichaIngresoTarea = true;
	}

}
?>


<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>


<?php
if($FichaIngresoPlanchado){
?>
    <span class="EstFormularioSubTitulo2">
    
    PLANCHADO
    
    </span>
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" align="center">#</th>
      <th width="85%" align="center"> Descripcion
      </th>
    <th width="14%" align="center"> Acc.  </th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    <?php
    $c = 1;
    $TotalItems = 0;
    foreach($ArrSesionObjetos as $DatSesionObjeto){
		
        if($DatSesionObjeto->Parametro6 == "L"){
    ?>
    <tr>
    <td align="right"><?php echo $c;?></td>
    <td align="right">
      <?php echo $DatSesionObjeto->Parametro3;?></td>
    <td width="14%" align="center">
      
      <?php
    if($_POST['Editar']==1){
    ?>
      <a class="EstSesionObjetosItem" href="javascript:FncFichaIngresoTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
      <?php
    }
    ?>
      
      
      
      
      <?php
    if($_POST['Eliminar']==1){
    ?>
      <a href="javascript:FncFichaIngresoTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
        <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
      <?php
    }
    ?>
    </td>
    </tr>
    <?php
        $TotalItems++;
    $c++;
        }
    }
    ?>
    </tbody>
    </table>
    
<br />
<?php	
}
?>









<?php
if($FichaIngresoPintado){
?>
    
    
<span class="EstFormularioSubtitulo2">PINTADO</span>
    
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" align="center">#</th>
      <th width="85%" align="center"> Descripcion
      </th>
    <th width="14%" align="center"> Acc.  </th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    <?php
    $c = 1;
    $TotalItems = 0;
    foreach($ArrSesionObjetos as $DatSesionObjeto){
		
        if($DatSesionObjeto->Parametro6 == "N"){
    ?>
    <tr>
    <td width="2%" align="right" valign="top"><?php echo $c;?></td>
    <td align="right" valign="top">
      <?php echo $DatSesionObjeto->Parametro3;?></td>
    <td width="14%" align="center" valign="top">
      
      <?php
    if($_POST['Editar']==1){
    ?>
      <a class="EstSesionObjetosItem" href="javascript:FncFichaIngresoTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
      <?php
    }
    ?>
      
      
      
      
      <?php
    if($_POST['Eliminar']==1){
    ?>
      <a href="javascript:FncFichaIngresoTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
        <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
      <?php
    }
    ?>
    </td>
    </tr>
    <?php
        $TotalItems++;
    $c++;
        }
    }
    ?>
    </tbody>
    </table>
    
<br />
<?php	
}
?>








<?php
if($FichaIngresoCentrado){
?>
    
    
<span class="EstFormularioSubTitulo2">CENTRADO</span>
    
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" align="center">#</th>
      <th width="85%" align="center"> Descripcion
      </th>
    <th width="14%" align="center"> Acc.  </th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    <?php
    $c = 1;
    $TotalItems = 0;
    foreach($ArrSesionObjetos as $DatSesionObjeto){
		
        if($DatSesionObjeto->Parametro6 == "E"){
    ?>
    <tr>
    <td width="2%" align="right"><?php echo $c;?></td>
    <td align="right">
      <?php echo $DatSesionObjeto->Parametro3;?></td>
    <td width="14%" align="center">
      
      <?php
    if($_POST['Editar']==1){
    ?>
      <a class="EstSesionObjetosItem" href="javascript:FncFichaIngresoTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
      <?php
    }
    ?>
      
      
      
      
      <?php
    if($_POST['Eliminar']==1){
    ?>
      <a href="javascript:FncFichaIngresoTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
        <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
      <?php
    }
    ?>
    </td>
    </tr>
    <?php
        $TotalItems++;
    $c++;
        }
    }
    ?>
    </tbody>
    </table>
  <br />  

<?php	
}
?>




<?php
if($FichaIngresoReparacion){
?>
    
    
<span class="EstFormularioSubTitulo2">TAREAS/REPARACION</span>
    
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
    <thead class="EstTablaListadoHead">
    <tr>
      <th width="2%" align="center">#</th>
      <th width="84%" align="center"> Descripcion
      </th>
    <th width="14%" align="center"> Acc.  </th>
    </tr>
    </thead>
    <tbody class="EstTablaListadoBody">
    <?php
    $c = 1;
    $TotalItems = 0;
    foreach($ArrSesionObjetos as $DatSesionObjeto){
		
        if($DatSesionObjeto->Parametro6 == "Z"){
    ?>
    <tr>
    <td width="2%" align="right"><?php echo $c;?></td>
    <td align="right">
      <?php echo $DatSesionObjeto->Parametro3;?></td>
    <td width="14%" align="center">
      
      <?php
    if($_POST['Editar']==1){
    ?>
      <a class="EstSesionObjetosItem" href="javascript:FncFichaIngresoTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
      <?php
    }
    ?>
      
      
      <?php
    if($_POST['Eliminar']==1){
    ?>
      <a href="javascript:FncFichaIngresoTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
        <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
      <?php
    }
    ?>
    </td>
    </tr>
    <?php
        $TotalItems++;
    $c++;
        }
    }
    ?>
    </tbody>
</table>
  
<br />  

<?php	
}
?>








<?php
if($FichaIngresoTarea){
?>



<span class="EstFormularioSubTitulo2">ADICIONALES</span>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%" align="center">#</th>
  <th width="11%" align="center" valign="top"> Actividad </th>
  <th width="73%" align="center" valign="top"> Descripcion
</th>
<th width="14%" align="center" valign="top"> Acc.  </th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
	if($DatSesionObjeto->Parametro6 <> "L" and $DatSesionObjeto->Parametro6<>"N" and $DatSesionObjeto->Parametro6<>"E"  and $DatSesionObjeto->Parametro6<>"Z"){
?>
<tr>
<td width="2%" align="right"><?php echo $c;?></td>
<td align="right" valign="top">

<?php
  switch($DatSesionObjeto->Parametro6){
	case "I":
?>
  Inspeccionar
  <?php	
	break;
	
	case "R":
?>
  Realizar
  <?php
	break;

	
	
	
	
	default:
?>
  -
  <?php
	break;
  }
  ?>
  
  </td>
<td align="right" valign="top">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="center" valign="top">
  
  <?php
if($_POST['Editar']==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncFichaIngresoTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>




  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncFichaIngresoTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
  <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?>
</td>
</tr>
<?php
	$TotalItems++;
$c++;
	}
}
?>
</tbody>
</table>


<?php	
}
?>


<?php
}
?>
