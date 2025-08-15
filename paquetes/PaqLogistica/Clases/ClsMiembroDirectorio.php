<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsMiembroDirectorio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsMiembroDirectorio {

    public $MdiId;
	public $TdoId;
	public $MdiNumeroDocumeto;
    public $MdiNombre;
	public $MdiApellidoPaterno;
	public $MdiApellidoMaterno;
	public $MdiEmail;
	public $MdiTelefono;
	public $MdiCelular;
	public $MdiDireccion;
	public $MdiFoto;
	public $MdiCargo;

	public $MdiEstado;	
    public $MdiTiempoCreacion;
    public $MdiTiempoModificacion;
    public $MdiEliminado;

	public $MdiCargoDescripcion;
	
	public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}
		
	public function MtdGenerarMiembroDirectorioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(MdiId,5),unsigned)) AS "MAXIMO"
			FROM tblmdimiembrodirectorio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->MdiId = "MDI-10000";

			}else{
				$fila['MAXIMO']++;
				$this->MdiId = "MDI-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerMiembroDirectorio(){

        $sql = 'SELECT 
        mdi.MdiId,
		mdi.TdoId,
		mdi.MdiNumeroDocumento,
		mdi.MdiNombre,
		mdi.MdiApellidoPaterno,
		mdi.MdiApellidoMaterno,
		mdi.MdiEmail,
		mdi.MdiTelefono,
		mdi.MdiCelular,
		mdi.MdiDireccion,
		mdi.MdiFoto,
		mdi.MdiCargo,
		mdi.MdiEstado,	
		DATE_FORMAT(mdi.MdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NMdiTiempoCreacion",
        DATE_FORMAT(mdi.MdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NMdiTiempoModificacion",
		tdo.TdoNombre
        FROM tblmdimiembrodirectorio mdi
			LEFT JOIN tbltdotipodocumento tdo
			ON mdi.TdoId = tdo.TdoId
        WHERE MdiId = "'.$this->MdiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->MdiId = $fila['MdiId'];
			$this->TdoId = $fila['TdoId'];
			$this->MdiNumeroDocumento = $fila['MdiNumeroDocumento'];			
            $this->MdiNombre = $fila['MdiNombre'];
			$this->MdiApellidoPaterno = $fila['MdiApellidoPaterno'];
			$this->MdiApellidoMaterno = $fila['MdiApellidoMaterno'];
			$this->MdiEmail = $fila['MdiEmail'];
			$this->MdiTelefono = $fila['MdiTelefono'];
			$this->MdiCelular = $fila['MdiCelular'];
			$this->MdiDireccion = $fila['MdiDireccion'];
			$this->MdiFoto = $fila['MdiFoto'];
			$this->MdiCargo = $fila['MdiCargo'];
			$this->MdiEstado = $fila['MdiEstado'];
			
			$this->MdiTiempoCreacion = $fila['NMdiTiempoCreacion'];
			$this->MdiTiempoModificacion = $fila['NMdiTiempoModificacion'];

			switch($this->MdiCargo){
				case 1:
					$this->MdiCargoDescripcion = "Presidente";
				break;
				
				case 2:
					$this->MdiCargoDescripcion = "Director";
				break;
			}
			$this->TdoNombre = $fila['TdoNombre'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerMiembroDirectorios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'MdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCargo=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
				
		if(!empty($oEstado)){
			$estado = ' AND mdi.MdiEstado = '.$oEstado;
		}	
		if(!empty($oCargo)){
			$cargo = ' AND mdi.MdiCargo = '.$oCargo;
		}	
				
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				mdi.MdiId,
				mdi.TdoId,
				mdi.MdiNumeroDocumento,		
				mdi.MdiNombre,
				mdi.MdiApellidoPaterno,
				mdi.MdiApellidoMaterno,
				mdi.MdiEmail,
				mdi.MdiTelefono,
				mdi.MdiCelular,
				mdi.MdiDireccion,
				mdi.MdiFoto,
				mdi.MdiCargo,
				mdi.MdiEstado,
				DATE_FORMAT(mdi.MdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NMdiTiempoCreacion",
                DATE_FORMAT(mdi.MdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NMdiTiempoModificacion",
				tdo.TdoNombre
				FROM tblmdimiembrodirectorio mdi	
					LEFT JOIN tbltdotipodocumento tdo
					ON mdi.TdoId = tdo.TdoId
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$cargo.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsMiembroDirectorio = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$MiembroDirectorio = new $InsMiembroDirectorio();				
					
                    $MiembroDirectorio->MdiId = $fila['MdiId'];
					$MiembroDirectorio->TdoId = $fila['TdoId'];
					$MiembroDirectorio->MdiNumeroDocumento= $fila['MdiNumeroDocumento'];
                    $MiembroDirectorio->MdiNombre= $fila['MdiNombre'];
					$MiembroDirectorio->MdiApellidoPaterno = $fila['MdiApellidoPaterno'];
					$MiembroDirectorio->MdiApellidoMaterno= $fila['MdiApellidoMaterno'];
					$MiembroDirectorio->MdiEmail = $fila['MdiEmail'];
					$MiembroDirectorio->MdiTelefono = $fila['MdiTelefono'];
					$MiembroDirectorio->MdiCelular = $fila['MdiCelular'];
					$MiembroDirectorio->MdiDireccion = $fila['MdiDireccion'];
					$MiembroDirectorio->MdiFoto = $fila['MdiFoto'];
					$MiembroDirectorio->MdiCargo = $fila['MdiCargo'];
					$MiembroDirectorio->MdiEstado = $fila['MdiEstado'];					
                    $MiembroDirectorio->MdiTiempoCreacion = $fila['NMdiTiempoCreacion'];
                    $MiembroDirectorio->MdiTiempoModificacion = $fila['NMdiTiempoModificacion'];    

					switch($MiembroDirectorio->MdiCargo){
						case 1:	
							$MiembroDirectorio->MdiCargoDescripcion = "Presidente";
						break;
						
						case 2:
							$MiembroDirectorio->MdiCargoDescripcion = "Director";
						break;
						 
					}
					$MiembroDirectorio->TdoNombre = $fila['TdoNombre'];    
					
                    $MiembroDirectorio->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $MiembroDirectorio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarMiembroDirectorio($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (MdiId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (MdiId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblmdimiembrodirectorio WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarMiembroDirectorio() {

			$this->MtdGenerarMiembroDirectorioId();
		
			$sql = 'INSERT INTO tblmdimiembrodirectorio (
			MdiId,
			TdoId,
			MdiNombre,
			MdiApellidoPaterno,
			MdiApellidoMaterno,
			MdiNumeroDocumento,
			MdiEmail,
			MdiTelefono,
			MdiCelular,
			MdiDireccion,
			MdiFoto,
			MdiCargo,
			MdiEstado,
			MdiTiempoCreacion,
			MdiTiempoModificacion
			) 
			VALUES (
			"'.($this->MdiId).'", 
			"'.($this->TdoId).'",
			"'.($this->MdiNombre).'",
			"'.($this->MdiApellidoPaterno).'",
			"'.($this->MdiApellidoMaterno).'",			
			"'.($this->MdiNumeroDocumento).'",
			
			"'.($this->MdiEmail).'",
			"'.($this->MdiTelefono).'",
			"'.($this->MdiCelular).'",
			"'.($this->MdiDireccion).'",
			"'.($this->MdiFoto).'",
			'.($this->MdiCargo).', 
			'.($this->MdiEstado).', 
			"'.($this->MdiTiempoCreacion).'", 
			"'.($this->MdiTiempoModificacion).'");';

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
	

	public function MtdEditarMiembroDirectorio() {
		

			$sql = 'UPDATE tblmdimiembrodirectorio SET 
			TdoId = "'.($this->TdoId).'",
			MdiNombre = "'.($this->MdiNombre).'",
			MdiApellidoPaterno = "'.($this->MdiApellidoPaterno).'",
			MdiApellidoMaterno = "'.($this->MdiApellidoMaterno).'",
			MdiNumeroDocumento = "'.($this->MdiNumeroDocumento).'",
			
			MdiEmail = "'.($this->MdiEmail).'",
			MdiTelefono = "'.($this->MdiTelefono).'",
			MdiCelular = "'.($this->MdiCelular).'",
			MdiDireccion = "'.($this->MdiDireccion).'",
			MdiFoto = "'.($this->MdiFoto).'",
			MdiCargo = '.($this->MdiCargo).',
			MdiEstado = '.($this->MdiEstado).',
			MdiTiempoModificacion = "'.($this->MdiTiempoModificacion).'"
			WHERE MdiId = "'.($this->MdiId).'";';
			
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