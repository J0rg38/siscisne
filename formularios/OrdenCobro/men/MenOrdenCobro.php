<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado") ){
?>  

<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Listado"><img src="imagenes/iconos/listado.png" alt="[Listado]"  title="Ir a formulario de listado" /> Listado</a></div>

<div class="EstSubMenuBoton"><a href="principal.php?Mod=<?php echo $GET_mod;?>&Form=Monitoreo"><img src="imagenes/iconos/monitoreo.png" alt="[Mon. Ord. Cobro]"  title="Ir a formulario de monitoreo de ordenes de cobro" />Monitoreo</a></div>


<?php
}
?>
