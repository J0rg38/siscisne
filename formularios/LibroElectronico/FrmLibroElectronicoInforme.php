<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
         

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsLibroElectronicoInformeFunciones.js" ></script>

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

//include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjLibroElectronico.php');
//
//require_once($InsPoo->MtdPaqLogistica().'ClsLibroElectronico.php');
//
//$InsLibroElectronico = new ClsLibroElectronico();



?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){
	

});

/*
Configuracion Formulario
*/



</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">


<div class="EstCapMenu">

           <?php
if($Edito){
?>

            

<?php
}
?>    

<div class="EstSubMenuBoton">

</div>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	



    
      
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">LIBROS ELECTRONICOS: SUNAT</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Libros</a></li>
   
</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
       
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           
           
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="5"><span class="EstFormularioSubTitulo">Registro de Ventas e Ingresos</span></td>
               <td>&nbsp;</td>
             </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Año:</td>
               <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                 <?php
				for($i=2016;$i<=date("Y");$i++){
				?>
                 <option <?php echo ($i==date("Y")?'selected="selected"':'')?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                 <?php	
				}
				?>
                 </select></td>
               <td align="left" valign="top">Mes:</td>
               <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMes" id="CmpMes">
                 <option <?php echo ((date("m")=="01")?'selected="selected"':'');?>  value="01">Enero</option>
                 <option <?php echo ((date("m")=="02")?'selected="selected"':'');?>  value="02">Febrero</option>
                 <option <?php echo ((date("m")=="03")?'selected="selected"':'');?>  value="03">Marzo</option>
                 <option <?php echo ((date("m")=="04")?'selected="selected"':'');?>  value="04">Abril</option>
                 <option <?php echo ((date("m")=="05")?'selected="selected"':'');?>  value="05">Mayo</option>
                 <option <?php echo ((date("m")=="06")?'selected="selected"':'');?>  value="06">Junio</option>
                 <option <?php echo ((date("m")=="07")?'selected="selected"':'');?>  value="07">Julio</option>
                 <option <?php echo ((date("m")=="08")?'selected="selected"':'');?>  value="08">Agosto</option>
                 <option <?php echo ((date("m")=="09")?'selected="selected"':'');?>  value="09">Setiembre</option>
                 <option <?php echo ((date("m")=="10")?'selected="selected"':'');?>  value="10">Octubre</option>
                 <option <?php echo ((date("m")=="11")?'selected="selected"':'');?>  value="11">Noviembre</option>
                 <option <?php echo ((date("m")=="12")?'selected="selected"':'');?>  value="12">Diciembre</option>
                 </select></td>
               <td align="left" valign="top">
                 
                 - <img src="imagenes/acciones/txt.png" width="25" height="25" title="Generar TXT" alt="TXT" align="absmiddle" /> <a id="BtnDescargarLibroElectronicoRegistroVenta" href="javascript:void(0);">[Descargar L.E.: TXT]</a>
                 <br /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">Registro de Inventario Permanente Valorizado</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha Inicio:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFechaInicioInventario" type="text"  id="CmpFechaInicioInventario" value="<?php  echo "01/".date("m/Y");?>" size="10" maxlength="10"/>
                 <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaInicioInventario" name="BtnFechaInicioInventario" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">Fecha Fin:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFechaFinInventario" type="text"  id="CmpFechaFinInventario" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                 <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaFinInventario" name="BtnFechaFinInventario" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">- <img src="imagenes/acciones/txt.png" width="25" height="25" title="Generar TXT" alt="TXT" align="absmiddle" /> <a id="BtnDescargarLibroElectronicoInventarioPermanenteValorizado" href="javascript:void(0);">[Descargar L.E.: TXT]</a></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="5" align="left" valign="top"><span class="EstFormularioSubEtiqueta">Este modulo genera los libros electronicos en formato txt para ser procesados y enviados a SUNAT</span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             </table>
           
           </div></td>
       </tr>
       </table>
         
		

    </div>    
    

       
    
</div>    		 
		
        
        
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>

	
	
	
    
       


     
</form>


<script type="text/javascript"> 
	/*Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 
	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del bot&oacute;n que  
	}); */
	
	
		Calendar.setup({ 
	inputField : "CmpFechaInicioInventario",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicioInventario"// el id del bot&oacute;n que  
	}); 
	
	
	Calendar.setup({ 
	inputField : "CmpFechaFinInventario",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFinInventario"// el id del bot&oacute;n que  
	}); 
	
	
</script>


<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
