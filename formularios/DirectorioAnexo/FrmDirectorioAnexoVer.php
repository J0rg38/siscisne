<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ConfiguracionEmpresa","Ver") and empty($GET_dia)){
?>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssDirectorioAnexo.css');
</style>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Ing. Jonathan Blanco Alave
 */



?>



<div class="EstCapMenu">

</div>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td height="25"><span class="EstFormularioTitulo">DIRECTORIO DE ANEXOS</span></td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
</tr>

<tr>
  <td width="82%" valign="top">
  
  
  
  
  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      
                  
                  
                        <td align="left" valign="top">
                        
						
                            
                                         
                        </td>
                        <td align="left" valign="top">&nbsp;</td>
                  
                    </tr>
                  
                    <tr>
                     
                       
                    <td align="left" valign="top">
    
<img src="imagenes/iconos/anexos.png" alt="[Anexo]" title="Anexos" border="0" width="20" height="20" align="absmiddle" />
<span class="EstDirectorioAnexoNumero">200 - Soporte Informatico</span><br />
	<span class="EstDirectorioAnexoPersonal">- Jonathan Blanco</span><br />
<br />

<img src="imagenes/iconos/anexos.png" alt="[Anexo]" title="Anexos" border="0" width="20" height="20" align="absmiddle" />
<span class="EstDirectorioAnexoNumero">201 - Administracion</span><br />
	<span class="EstDirectorioAnexoPersonal">- Maria Luisa Godinez</span><br />
<br />

<img src="imagenes/iconos/anexos.png" alt="[Anexo]" title="Anexos" border="0" width="20" height="20" align="absmiddle" />
<span class="EstDirectorioAnexoNumero">206 - Area de Operaciones 1</span><br />
	<span class="EstDirectorioAnexoPersonal">- Ana Cecilia Araujo</span><br />
<br />



<img src="imagenes/iconos/anexos.png" alt="[Anexo]" title="Anexos" border="0" width="20" height="20" align="absmiddle" />
<span class="EstDirectorioAnexoNumero">205 - Area de Operaciones 2</span><br />
	<span class="EstDirectorioAnexoPersonal">- Alonso Villanueva</span><br />
	<span class="EstDirectorioAnexoPersonal">- Jose Luis Maquera</span><br />
<br />


<img src="imagenes/iconos/anexos.png" alt="[Anexo]" title="Anexos" border="0" width="20" height="20" align="absmiddle" />
<span class="EstDirectorioAnexoNumero">203 - Venta de Vehiculos</span><br />
	<span class="EstDirectorioAnexoPersonal">- Ivan Quezada</span><br />
	<span class="EstDirectorioAnexoPersonal">- Eva Escobar</span><br />
<br />


<img src="imagenes/iconos/anexos.png" alt="[Anexo]" title="Anexos" border="0" width="20" height="20" align="absmiddle" />
<span class="EstDirectorioAnexoNumero">208 - Facturacion</span><br />
	<span class="EstDirectorioAnexoPersonal">- Paola Zapana</span><br />

<br />

<img src="imagenes/iconos/anexos.png" alt="[Anexo]" title="Anexos" border="0" width="20" height="20" align="absmiddle" />
<span class="EstDirectorioAnexoNumero">210 - Area de Repuestos</span><br />
	<span class="EstDirectorioAnexoPersonal">- Aldo Liendo</span><br />

<br />
                    </td>
                     <td align="left" valign="top">&nbsp;</td>
                   
                    </tr>
		</table>
                
                
  
  </td>
</tr><tr>
  <td align="left">
  

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

