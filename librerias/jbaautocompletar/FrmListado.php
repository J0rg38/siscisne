<?php

$XmlDatos = simplexml_load_file("xmldatos.xml");	
	
	if($XmlDatos){
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
		foreach ($XmlDatos->Item as $DatItem) { 
?>
	<tr>
		<td>
			<?php echo $DatItem = $DatItem->Parametro1;?>
		</td>
        <td>
	        <?php echo $DatItem = $DatItem->Parametro2;?>
		</td>
        <td>
	        <?php echo $DatItem = $DatItem->Parametro3;?>
        </td>
		<td>
	        <?php echo $DatItem = $DatItem->Parametro4;?>
        </td>
		<td>
	        <?php echo $DatItem = $DatItem->Parametro5;?>
        </td>
		<td>
	        <?php echo $DatItem = $DatItem->Parametro6;?>
        </td>
                
	</tr>
<?php
		}
?>
</table>
<?php
	}

?>