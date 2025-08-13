<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsACL
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsACL
{

	public $InsMysql;


	public function __construct()
	{
		$this->InsMysql = new ClsMysql();
	}

	public function __destruct() {}


	public function MtdVerificarACL($oRol = NULL, $oZona = NULL, $oPrivilegio = NULL)
	{

		$Permiso = false;


		//echo $_SESSION['SesionRol'];

		//echo "<br>";

		if (!empty($_SESSION['SesionRol'])) {

			$InsRolZonaPrivilegio = new ClsRolZonaPrivilegio();
			$ResRolZonaPrivilegio = $InsRolZonaPrivilegio->MtdObtenerRolZonaPrivilegios(NULL, NULL, 'RzpId', 'Desc', NULL, $_SESSION['SesionRol']);
			$ArrRolZonaPrivilegios = $ResRolZonaPrivilegio['Datos'];

			foreach ($ArrRolZonaPrivilegios as $DatRolZonaPrivilegio) {

				if ($DatRolZonaPrivilegio->RolId == $oRol and $DatRolZonaPrivilegio->ZonNombre == $oZona and $DatRolZonaPrivilegio->PriNombre == $oPrivilegio) {

					$Permiso = true;
					break;
				}
			}
		}


		//		if (isset($_SESSION['InsRolZonaPrivilegio'])){	
		//			$_SESSION['InsRolZonaPrivilegio'] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsRolZonaPrivilegio']);
		//		}
		//
		//
		//
		//		$Permiso = false;
		//
		//		$RepSesionObjetos = $_SESSION['InsRolZonaPrivilegio']->MtdObtenerSesionObjetos();
		//
		//		foreach($RepSesionObjetos['Datos'] as $DatSesionObjeto){
		//
		//				
		//			if($DatSesionObjeto->Parametro2 == $oRol and $DatSesionObjeto->Parametro4 == $oZona and $DatSesionObjeto->Parametro5 == $oPrivilegio ){		
		//					
		//					//echo " xd";
		//					$Permiso = true;
		//					break;
		//			}
		//				
		//		}


		//echo "<hr>";

		//echo ".- <i>".$oTipo."</i> -> <b>".$oFormulario."</b> => <b>".$oAccion."</b>";


		/*$sql = 'SELECT ZprId FROM tblrzprolzonaprivilegio WHERE RolId = "'.$oRol.'";';
			
        $resultado = $this->InsMysql->MtdConsultar($sql);

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{										
				$sql2 = 'SELECT 
				COUNT(zpr.ZprId) AS "PERMISO"
				FROM tblzprzonaprivilegio zpr
				WHERE zpr.ZprId = "'.$fila['ZprId'].'"
				AND EXISTS (
						SELECT 
						zon.ZonId 
						FROM tblzonzona zon 
						WHERE zon.ZonNombre = "'.$oZona.'" 
						AND zpr.ZonId = zon.ZonId
					)
				AND EXISTS (
						SELECT 
						pri.PriId 
						FROM tblpriprivilegio pri 
						WHERE pri.PriNombre= "'.$oPrivilegio.'" 
						AND zpr.PriId = pri.PriId
				);';
				
				$resultado2 = $this->InsMysql->MtdConsultar($sql2);
				$fila2 = $this->InsMysql->MtdObtenerDatos($resultado2);
				
				if(($fila2['PERMISO'])>0){
					$Permiso = true;
					break;
				}
				
			}
        */

		//	$i++;
		return $Permiso;
	}
}
