<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCitaVerCalendarioFunciones.js"></script>

<?php
$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);


//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');
//CONFIGURACIONES
require_once($InsPoo->MtdPaqActividadConf().'CnfCita.php');


?>

<script type="text/javascript">
/*
//Desactivando tecla ENTER
*/

/*
//Configuracion carga de datos y animacion
*/
$(document).ready(function (){


});

/*
Configuracion Formulario
*/

</script>

<div class="EstCapMenu">
<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

</div>


<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo"> RESTRICCION DE HORARIO EN  CITAS </span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfProductoConsulta.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">

      
      </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
    
    <?php
    if(!empty($CitaRestriccionHorario)){
    ?>
    
        <?php
        foreach($CitaRestriccionHorario as $DatCitaRestriccionHorario){
        ?>
            De "<?php echo $DatCitaRestriccionHorario['Inicio'];?>" a "<?php echo $DatCitaRestriccionHorario['Fin'];?>": Limite: "<?php echo $DatCitaRestriccionHorario['Limite'];?>"
            <br />
        <?php	
        }
        ?>
        
    <?php 
    }else{
    ?>
		No se encontraron restricciones
    <?php	  
    }
    ?>
      
 
  </td>
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

