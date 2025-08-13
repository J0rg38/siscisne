<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsUsuario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsUsuario
{

	public $UsuId;
	public $RolId;
	public $UsuUsuario;
	public $UsuContrasena;
	public $UsuFoto;
	public $UsuEstado;
	public $UsuUltimaSesion;
	public $UsuTiempoCreacion;
	public $UsuTiempoModificacion;
	public $UsuEliminado;

	public $SucId;

	public $RolNombre;

	public $PerId;
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;

	public $RolZonaPrivilegio;

	public $InsMysql;

	public function __construct()
	{
		$this->InsMysql = new ClsMysql();
	}

	public function __destruct() {}

	public function MtdGenerarUsuarioId()
	{


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(UsuId,5),unsigned)) AS "MAXIMO"
		FROM tblusuusuario';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->UsuId = "USU-10000";
		} else {
			$fila['MAXIMO']++;
			$this->UsuId = "USU-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerUsuario()
	{


		$sql = 'SELECT 
        UsuId,
		RolId,	
		UsuUsuario,
        UsuContrasena,
		UsuFoto,
		UsuEstado,		
		DATE_FORMAT(UsuUltimaSesion, "%d/%m/%Y %H:%i:%s") AS "NUsuUltimaSesion",
		DATE_FORMAT(UsuTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NUsuTiempoCreacion",
        DATE_FORMAT(UsuTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NUsuTiempoModificacion"
        FROM tblusuusuario
        WHERE UsuId = "' . $this->UsuId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {


				$this->UsuId = $fila['UsuId'];
				$this->RolId = $fila['RolId'];
				$this->UsuUsuario = (($fila['UsuUsuario']));
				$this->UsuContrasena = $fila['UsuContrasena'];
				$this->UsuFoto = $fila['UsuFoto'];
				$this->UsuEstado = $fila['UsuEstado'];
				$this->UsuUltimaSesion = $fila['NUsuUltimaSesion'];
				$this->UsuTiempoCreacion = $fila['NUsuTiempoCreacion'];
				$this->UsuTiempoModificacion = $fila['NUsuTiempoModificacion'];
			}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

		
		
  public function MtdObtenerUsuarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'UsuId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oRol=NULL,$oNoPersonal=false) {

//		if(!empty($oCampo) && !empty($oFiltro)){
//			$oFiltro = str_replace(" ","%",$oFiltro);
//			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
//		}



	if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
							
				$filtrar .= '  ) ';
	
		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}

		if(!empty($oRol)){
			$rol = ' AND usu.RolId = "'.$oRol.'"';
		}

		if(($oNoPersonal)){
			$npersonal = ' AND NOT EXISTS (
				SELECT 
				per.PerId 
				FROM tblperpersonal 
					WHERE per.UsuId = usu.UsuId  
				) ';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				usu.UsuId,
				usu.RolId,
				usu.UsuUsuario,
				usu.UsuContrasena,
				usu.UsuFoto,
				usu.UsuEstado,

				IF(DATE(usu.UsuUltimaSesion) = DATE(NOW()),	
					IF (usu.UsuUltimaActividad BETWEEN ADDDATE(NOW()  ,INTERVAL -5 MINUTE) AND NOW(),2,
						IF (usu.UsuUltimaActividad < ADDDATE(NOW()  ,INTERVAL -15 MINUTE) AND NOW(),1,3)
					)
				,1) AS UsuConectado,

				DATE_FORMAT(usu.UsuUltimaSesion, "%d/%m/%Y %H:%i:%s") AS "NUsuUltimaSesion",
				DATE_FORMAT(usu.UsuUltimaActividad, "%d/%m/%Y %H:%i:%s") AS "NUsuUltimaActividad",				
				DATE_FORMAT(usu.UsuTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NUsuTiempoCreacion",
                DATE_FORMAT(usu.UsuTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NUsuTiempoModificacion",
				rol.RolNombre,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno
				
				FROM tblusuusuario usu
				
				LEFT JOIN tblrolrol rol
				ON	usu.RolId = rol.RolId
				
				LEFT JOIN tblperpersonal per
				ON usu.UsuId = per.UsuId
				
				WHERE 1 = 1 '.$filtrar.$rol.$npersonal.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsUsuario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Usuario = new $InsUsuario();
                    $Usuario->UsuId = $fila['UsuId'];
                    $Usuario->RolId= $fila['RolId'];		
					$Usuario->UsuUsuario= $fila['UsuUsuario'];			
                    $Usuario->UsuContrasena= $fila['UsuContrasena'];
                    $Usuario->UsuFoto= $fila['UsuFoto'];					
					
                    $Usuario->UsuEstado= $fila['UsuEstado'];	
					$Usuario->UsuConectado= $fila['UsuConectado'];
						
					$Usuario->UsuUltimaSesion= $fila['NUsuUltimaSesion'];	
					$Usuario->UsuUltimaActividad= $fila['NUsuUltimaActividad'];	
                    $Usuario->UsuTiempoCreacion = $fila['NUsuTiempoCreacion'];
                    $Usuario->UsuTiempoModificacion = $fila['NUsuTiempoModificacion'];   

					$Usuario->RolNombre =  $fila['RolNombre'];   
					
					$Usuario->PerNombre =  $fila['PerNombre'];   
					$Usuario->PerApellidoPaterno =  $fila['PerApellidoPaterno'];   
					$Usuario->PerApellidoMaterno =  $fila['PerApellidoMaterno'];   
					
                    $Usuario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Usuario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		

	//Accion eliminar	 
	
	public function MtdEliminarUsuario($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (UsuId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (UsuId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tblusuusuario WHERE '.$eliminar;
			
					
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarUsuario() {
	
			$this->MtdGenerarUsuarioId();
		
			$sql = 'INSERT INTO tblusuusuario (
			UsuId,
			RolId,
			UsuUsuario,
			UsuContrasena, 
			UsuFoto,
			UsuEstado,
			UsuTiempoCreacion,
			UsuTiempoModificacion,
			UsuEliminado) 
			VALUES (
			"'.($this->UsuId).'", 
			"'.($this->RolId).'", 			
			"'.($this->UsuUsuario).'",
			"'.($this->UsuContrasena).'", 
			"'.($this->UsuFoto).'", 
			'.($this->UsuEstado).', 			
			"'.($this->UsuTiempoCreacion).'", 
			"'.($this->UsuTiempoModificacion).'", 				
			'.($this->UsuEliminado).');';					
		
		
		
		$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
			
			
			
		
			
	}
	
	public function MtdEditarUsuario() {
		
			$sql = 'UPDATE tblusuusuario SET 
			RolId = "'.($this->RolId).'",
			 UsuUsuario = "'.($this->UsuUsuario).'",
			 UsuContrasena = "'.($this->UsuContrasena).'",
			 UsuFoto = "'.($this->UsuFoto).'",
			 UsuEstado = '.($this->UsuEstado).',			 
			 UsuTiempoModificacion = "'.($this->UsuTiempoModificacion).'"
			 WHERE UsuId = "'.($this->UsuId).'"';
			
			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
		
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
			
			
				
				
		}	
		
	
	
	public function MtdEntrarUsuario(){

       $sql = 'SELECT 
        usu.UsuId,
		usu.RolId,	
		usu.UsuUsuario,
        usu.UsuContrasena,
		usu.UsuFoto,
		usu.UsuEstado,
		DATE_FORMAT(usu.UsuUltimaSesion, "%d/%m/%Y %H:%i:%s") AS "NUsuUltimaSesion",
		per.PerId,
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno
		
        FROM tblusuusuario usu

		LEFT JOIN tblperpersonal per
		ON per.UsuId = usu.UsuId
		
        WHERE 
		usu.UsuUsuario = "'.$this->InsMysql->MtdLimpiarDato($this->UsuUsuario).'"  
		AND MD5(usu.UsuContrasena) = "'.$this->InsMysql->MtdLimpiarDato($this->UsuContrasena).'";';

        $resultado = $this->InsMysql->MtdConsultar($sql);

		
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$InsRolZonaPrivilegio = new ClsRolZonaPrivilegio();
			$ResRolZonaPrivilegio = $InsRolZonaPrivilegio->MtdObtenerRolZonaPrivilegios(NULL,NULL,'RzpId','Desc',NULL,$fila['RolId']);	
			
			$this->UsuId = $fila['UsuId'];
            $this->RolId = $fila['RolId'];		
			$this->UsuUsuario = $fila['UsuUsuario'];	
            $this->UsuContrasena = $fila['UsuContrasena'];
            $this->UsuFoto = $fila['UsuFoto'];	
		    $this->UsuEstado = $fila['UsuEstado'];			
			$this->UsuUltimaSesion = $fila['NUsuUltimaSesion'];		
			$this->PerId = $fila['PerId'];
			$this->PerNombre = $fila['PerNombre'];		
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];		
			
			$this->RolZonaPrivilegio = $ResRolZonaPrivilegio['Datos'];
			
		}
        
		return $this;

    }
	
	public function MtdActualizarUltimaSesionUsuario(){
	
		$sql = 'UPDATE tblusuusuario SET 			 
			 UsuUltimaSesion = "'.($this->UsuUltimaSesion).'"
			 WHERE UsuId = "'.($this->UsuId).'";';		
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}		
	}
	
	
	public function MtdActualizarUltimaActividadUsuario(){
	
		$sql = 'UPDATE tblusuusuario SET 			 
			 UsuUltimaActividad = "'.($this->UsuUltimaActividad).'"
			 WHERE UsuId = "'.($this->UsuId).'";';		
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}		
	}
	
}
?>