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
$ModalidadIngresoId = $_POST['ModalidadIngresoId'];

$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

session_start();
if (!isset($_SESSION['InsFichaAccionTarea'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionTarea'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


//		SesionObjeto-FichaAccionTarea
//		Parametro1 = FatId
//		Parametro2 =
//		Parametro3 = FatDescripcion
//		Parametro4 = FatVerificar1
//		Parametro5 = FatVerificar2
//		Parametro6 = FatAccion
//		Parametro7 = FatTiempoCreacion
//		Parametro8 = FatTiempoModificacion
//		Parametro9 = FatEstado
//		Parametro10 = FitId

//		Parametro11 = FatEspecificacion
//		Parametro12 = FatCosto



$RepSesionObjetos = $_SESSION['InsFichaAccionTarea'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

//deb($ArrSesionObjetos);


$FichaAccionTarea = false;
$FichaAccionPlanchado = false;
$FichaAccionPintado = false;
$FichaAccionCentrado = false;
$FichaAccionTarea = false;

foreach($ArrSesionObjetos as $DatSesionObjeto){
	
	if($DatSesionObjeto->Parametro6 == "L"){
		$FichaAccionPlanchado = true;
	}

	if($DatSesionObjeto->Parametro6 == "N"){
		$FichaAccionPintado = true;
	}

	if($DatSesionObjeto->Parametro6 == "E"){
		$FichaAccionCentrado = true;
	}
	
	if($DatSesionObjeto->Parametro6 == "Z"){
		$FichaAccionReparacion = true;
	}
	
	if($DatSesionObjeto->Parametro6 == "I" or $DatSesionObjeto->Parametro6 == "R"){
		$FichaAccionTarea = true;
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
    if($ModalidadIngreso == "PP"){
    ?>
   
	<?php
    $Total = 0;
    ?>
    
    <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
        <thead class="EstTablaListadoHead">
        <tr>
          <th width="2%" align="center">#</th>
          <th width="59%" align="center"> Descripcion
          </th>
          <th width="11%" align="center">Especificacion</th>
          <th width="9%" align="center">Costo</th>
          <th width="12%" align="center">Actividad</th>
        <th width="2%" align="center">&nbsp;</th>
        <th colspan="2" align="center"> Acc.</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
        <?php
        $c = 1;
        foreach($ArrSesionObjetos as $DatSesionObjeto){
        ?>
        
        <tr>
        <td align="left" valign="top"><?php echo $c;?></td>
        <td align="left" valign="top">
          <?php echo $DatSesionObjeto->Parametro3;?>
          
          
			<?php
            if(empty($DatSesionObjeto->Parametro1)){
            ?>
            *
            <?php  
            }
            ?>
         
          </td>
        <td align="left" valign="top"><?php echo $DatSesionObjeto->Parametro11;?></td>
        <td align="left" valign="top"><?php echo number_format($DatSesionObjeto->Parametro12,2);?></td>
        <td align="left" valign="top">
        
        <?php
        switch($DatSesionObjeto->Parametro6){
            case "L":
        ?>
        Planchado
        <?php	
            break;
            
            case "N":
        ?>
        Pintado
        <?php	
            break;
            
            case "E":
        ?>
        Centrado
        <?php	
            break;	
            
            case "Z":
        ?>
        Tarea/Reparacion
        <?php	
            break;
            
            
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
        }
        ?>
        
        
        
        </td>
        <td align="left" valign="top">
          
          <input type="checkbox" checked="checked"  name="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" id="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" value="1" disabled="disabled" />
        </td>
        <td width="2%" align="left" valign="top">
          
          <?php
        if($_POST['Editar']==1){
        ?>
          
          
          <a class="EstSesionObjetosItem" href="javascript:FncFichaAccionTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          
          <?php
        }
        ?>
          
        
          
          
        </td>
        <td width="3%" align="left" valign="top">  <?php
        if($_POST['Eliminar']==1){
        ?>
          <a href="javascript:FncFichaAccionTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
          <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?></td>
        </tr>
        <?php
            $Total += $DatSesionObjeto->Parametro12;
            $c++;
        }
        ?>
        </tbody>
        </table>
            
        <br />
        
        <table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
        <tbody class="EstTablaTotalBody">
        <tr>
          <td width="17%" align="right" class="Total">&nbsp;</td>
          <td width="7%" align="left" >&nbsp;</td>
          <td width="61%" align="right" class="Total">Total:</td>
          <td width="15%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
        </tr>
        </tbody>
        </table>
        
    
    <?php	
    }else{
    ?>
   
    
        <?php
        if($FichaAccionPlanchado){
        ?>
           
           
           PLANCHADO
    
     <!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
        <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
        <thead class="EstTablaListadoHead">
        <tr>
          <th width="2%" align="center">#</th>
          <th width="91%" align="center"> Descripcion
          </th>
        <th width="2%" align="center">&nbsp;</th>
        <th colspan="2" align="center"> Acc.</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
        <?php
        $c = 1;
        foreach($ArrSesionObjetos as $DatSesionObjeto){
            
            //if($DatSesionObjeto->Parametro9==1 and $DatSesionObjeto->Parametro6=="L" ){
            if($DatSesionObjeto->Parametro6=="L" ){  
       
        ?>
        <tr>
        <td align="left" valign="top"><?php echo $c;?></td>
        <td align="left" valign="top">
          <?php echo $DatSesionObjeto->Parametro3;?>
          <?php
            if(empty($DatSesionObjeto->Parametro1)){
            ?>
*
<?php  
            }
            ?></td>
        <td align="left" valign="top">
          
          <input type="checkbox" checked="checked"  name="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" id="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" value="1" disabled="disabled" />
        </td>
        <td width="2%" align="left" valign="top">
          
          <?php
        if($_POST['Editar']==1){
        ?>
          
          
          <a class="EstSesionObjetosItem" href="javascript:FncFichaAccionTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          
          <?php
        }
        ?>
          
        
          
          
        </td>
        <td width="3%" align="left" valign="top">  <?php
        if($_POST['Eliminar']==1){
        ?>
          <a href="javascript:FncFichaAccionTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
          <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?></td>
        </tr>
        <?php
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
        if($FichaAccionPintado){
        ?>
    
    
    PINTADO
    
     <!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
        <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
        <thead class="EstTablaListadoHead">
        <tr>
          <th width="2%" align="center">#</th>
          <th width="91%" align="center"> Descripcion
          </th>
        <th width="2%" align="center">&nbsp;</th>
        <th colspan="2" align="center"> Acc.</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
        <?php
        $c = 1;
        foreach($ArrSesionObjetos as $DatSesionObjeto){
            
            if($DatSesionObjeto->Parametro6=="N" ){
                
       
        ?>
        <tr>
        <td align="left" valign="top"><?php echo $c;?></td>
        <td align="left" valign="top">
          <?php echo $DatSesionObjeto->Parametro3;?>
          <?php
            if(empty($DatSesionObjeto->Parametro1)){
            ?>
*
<?php  
            }
            ?></td>
        <td align="left" valign="top">
          
          <input type="checkbox" checked="checked"  name="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" id="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" value="1" disabled="disabled" />
        </td>
        <td width="2%" align="left" valign="top">
          
          <?php
        if($_POST['Editar']==1){
        ?>
          
          
          <a class="EstSesionObjetosItem" href="javascript:FncFichaAccionTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          
          <?php
        }
        ?>
          
        
          
          
        </td>
        <td width="3%" align="left" valign="top">  <?php
        if($_POST['Eliminar']==1){
        ?>
          <a href="javascript:FncFichaAccionTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
          <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?></td>
        </tr>
        <?php
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
        if($FichaAccionCentrado){
        ?>
    
    CENTRADO
    
     <!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
        <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
        <thead class="EstTablaListadoHead">
        <tr>
          <th width="2%" align="center">#</th>
          <th width="91%" align="center"> Descripcion
          </th>
        <th width="2%" align="center">&nbsp;</th>
        <th colspan="2" align="center"> Acc.</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
        <?php
        $c = 1;
        foreach($ArrSesionObjetos as $DatSesionObjeto){
            
            if($DatSesionObjeto->Parametro6=="E" ){
                
       
        ?>
        <tr>
        <td align="left" valign="top"><?php echo $c;?></td>
        <td align="left" valign="top">
          <?php echo $DatSesionObjeto->Parametro3;?>
          <?php
            if(empty($DatSesionObjeto->Parametro1)){
            ?>
*
<?php  
            }
            ?></td>
        <td align="left" valign="top">
          
          <input type="checkbox" checked="checked"  name="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" id="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" value="1" disabled="disabled" />
        </td>
        <td width="2%" align="left" valign="top">
          
          <?php
        if($_POST['Editar']==1){
        ?>
          
          
          <a class="EstSesionObjetosItem" href="javascript:FncFichaAccionTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          
          <?php
        }
        ?>
          
        
          
          
        </td>
        <td width="3%" align="left" valign="top">  <?php
        if($_POST['Eliminar']==1){
        ?>
          <a href="javascript:FncFichaAccionTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
          <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?></td>
        </tr>
        <?php
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
        if($FichaAccionReparacion){
        ?>
    
    TAREAS/REPARACION
    
     <!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
        <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
        <thead class="EstTablaListadoHead">
        <tr>
          <th width="2%" align="center">#</th>
          <th width="91%" align="center"> Descripcion
          </th>
        <th width="2%" align="center">&nbsp;</th>
        <th colspan="2" align="center"> Acc.</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
        <?php
        $c = 1;
        foreach($ArrSesionObjetos as $DatSesionObjeto){
            
            if($DatSesionObjeto->Parametro6=="Z" ){
                
       
        ?>
        <tr>
        <td align="left" valign="top"><?php echo $c;?></td>
        <td align="left" valign="top">
          <?php echo $DatSesionObjeto->Parametro3;?>
          <?php
            if(empty($DatSesionObjeto->Parametro1)){
            ?>
*
<?php  
            }
            ?></td>
        <td align="left" valign="top">
          
          <input type="checkbox" checked="checked"  name="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" id="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" value="1" disabled="disabled" />
        </td>
        <td width="2%" align="left" valign="top">
          
          <?php
        if($_POST['Editar']==1){
        ?>
          
          
          <a class="EstSesionObjetosItem" href="javascript:FncFichaAccionTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          
          <?php
        }
        ?>
          
        
          
          
        </td>
        <td width="3%" align="left" valign="top">  <?php
        if($_POST['Eliminar']==1){
        ?>
          <a href="javascript:FncFichaAccionTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
          <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?></td>
        </tr>
        <?php
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
        if($FichaAccionTarea){
        ?>
        
        <!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
        <table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
        <thead class="EstTablaListadoHead">
        <tr>
          <th width="2%" align="center">#</th>
          <th width="79%" align="center"> Descripcion
        </th>
        <th width="12%" align="center">
          Actividad
          
          
        </th>
        <th width="2%" align="center">&nbsp;</th>
        <th colspan="2" align="center"> Acc.</th>
        </tr>
        </thead>
        <tbody class="EstTablaListadoBody">
        <?php
        $c = 1;
        foreach($ArrSesionObjetos as $DatSesionObjeto){
            
            //if($DatSesionObjeto->Parametro9==1 and ($DatSesionObjeto->Parametro6<>"L" and $DatSesionObjeto->Parametro6<>"N" and $DatSesionObjeto->Parametro6<>"E" )){
			if( ($DatSesionObjeto->Parametro6<>"L" and $DatSesionObjeto->Parametro6<>"N" and $DatSesionObjeto->Parametro6<>"E" )){
                
       
        ?>
        <tr>
        <td align="left" valign="top"><?php echo $c;?></td>
        <td align="left" valign="top">
          <?php echo $DatSesionObjeto->Parametro3;?>
          <?php
            if(empty($DatSesionObjeto->Parametro1)){
            ?>
*
<?php  
            }
            ?></td>
        <td align="left" valign="top">
          
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
        <td align="left" valign="top">
          
          <input type="checkbox" checked="checked"  name="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" id="CmpFichaAccionTarea_<?php echo $DatSesionObjeto->Item;?>" value="1" disabled="disabled" />
        </td>
        <td width="2%" align="left" valign="top">
          
          <?php
        if($_POST['Editar']==1){
        ?>
          
          
          <a class="EstSesionObjetosItem" href="javascript:FncFichaAccionTareaEscoger('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
          
          <?php
        }
        ?>
          
        
          
          
        </td>
        <td width="3%" align="left" valign="top">  <?php
        if($_POST['Eliminar']==1){
        ?>
          <a href="javascript:FncFichaAccionTareaEliminar('<?php echo $DatSesionObjeto->Item;?>','<?php echo $ModalidadIngreso;?>');" >
          <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
          <?php
        }
        ?></td>
        </tr>
        <?php
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

    
    
<?php
}
?>
