<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSocio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsSocio {

    public $SocId;
	public $TdoId;
	public $SocNumeroDocumeto;
    public $SocNombre;
	public $SocApellidoPaterno;
	public $SocApellidoMaterno;
	public $SocEmail;
	public $SocTelefono;
	public $SocCelular;
	public $SocDireccion;
	public $SocFoto;
	public $SocEstado;	
    public $SocTiempoCreacion;
    public $SocTiempoModificacion;
    public $SocEliminado;

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
		
	public function MtdGenerarSocioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(SocId,5),unsigned)) AS "MAXIMO"
			FROM tblsocsocio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->SocId = "SOC-10000";

			}else{
				$fila['MAXIMO']++;
				$this->SocId = "SOC-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerSocio(){

        $sql = 'SELECT 
        soc.SocId,
		soc.TdoId,
		soc.SocNumeroDocumento,
		soc.SocNombre,
		soc.SocApellidoPaterno,
		soc.SocApellidoMaterno,
		soc.SocEmail,
		soc.SocTelefono,
		soc.SocCelular,
		soc.SocDireccion,
		soc.SocFoto,
		soc.SocEstado,	
		DATE_FORMAT(soc.SocTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSocTiempoCreacion",
        DATE_FORMAT(soc.SocTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSocTiempoModificacion",
		tdo.TdoNombre
        FROM tblsocsocio soc
			LEFT JOIN tbltdotipodocumento tdo
			ON soc.TdoId = tdo.TdoId
        WHERE SocId = "'.$this->SocId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->SocId = $fila['SocId'];
			$this->TdoId = $fila['TdoId'];
			$this->SocNumeroDocumento = $fila['SocNumeroDocumento'];			
            $this->SocNombre = $fila['SocNombre'];
			$this->SocApellidoPaterno = $fila['SocApellidoPaterno'];
			$this->SocApellidoMaterno = $fila['SocApellidoMaterno'];
			$this->SocEmail = $fila['SocEmail'];
			$this->SocTelefono = $fila['SocTelefono'];
			$this->SocCelular = $fila['SocCelular'];
			$this->SocDireccion = $fila['SocDireccion'];
			$this->SocFoto = $fila['SocFoto'];
			$this->SocEstado = $fila['SocEstado'];
			$this->SocTiempoCreacion = $fila['NSocTiempoCreacion'];
			$this->SocTiempoModificacion = $fila['NSocTiempoModificacion'];

			$this->TdoNombre = $fila['TdoNombre'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerSocios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SocId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

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
			$estado = ' AND soc.SocEstado = '.$oEstado;
		}	
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				soc.SocId,
				soc.TdoId,
				soc.SocNumeroDocumento,		
				soc.SocNombre,
				soc.SocApellidoPaterno,
				soc.SocApellidoMaterno,
				soc.SocEmail,
				soc.SocTelefono,
				soc.SocCelular,
				soc.SocDireccion,
				soc.SocFoto,
				soc.SocEstado,
				DATE_FORMAT(soc.SocTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSocTiempoCreacion",
                DATE_FORMAT(soc.SocTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSocTiempoModificacion",
				tdo.TdoNombre
				FROM tblsocsocio soc	
					LEFT JOIN tbltdotipodocumento tdo
					ON soc.TdoId = tdo.TdoId
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$categoria.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsSocio = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Socio = new $InsSocio();				
					
                    $Socio->SocId = $fila['SocId'];
					$Socio->TdoId = $fila['TdoId'];
					$Socio->SocNumeroDocumento= $fila['SocNumeroDocumento'];
                    $Socio->SocNombre= $fila['SocNombre'];
					$Socio->SocApellidoPaterno = $fila['SocApellidoPaterno'];
					$Socio->SocApellidoMaterno= $fila['SocApellidoMaterno'];
					$Socio->SocEmail = $fila['SocEmail'];
					$Socio->SocTelefono = $fila['SocTelefono'];
					$Socio->SocCelular = $fila['SocCelular'];
					$Socio->SocDireccion = $fila['SocDireccion'];
					$Socio->SocFoto = $fila['SocFoto'];
					$Socio->SocEstado = $fila['SocEstado'];					
                    $Socio->SocTiempoCreacion = $fila['NSocTiempoCreacion'];
                    $Socio->SocTiempoModificacion = $fila['NSocTiempoModificacion'];    

					$Socio->TdoNombre = $fila['TdoNombre'];    
					
                    $Socio->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Socio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarSocio($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (SocId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (SocId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblsocsocio WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarSocio() {

			$this->MtdGenerarSocioId();
		
			$sql = 'INSERT INTO tblsocsocio (
			SocId,
			TdoId,
			SocNombre,
			SocApellidoPaterno,
			SocApellidoMaterno,
			SocNumeroDocumento,
			SocEmail,
			SocTelefono,
			SocCelular,
			SocDireccion,
			SocFoto,
			SocEstado,
			SocTiempoCreacion,
			SocTiempoModificacion
			) 
			VALUES (
			"'.($this->SocId).'", 
			"'.($this->TdoId).'",
			"'.($this->SocNombre).'",
			"'.($this->SocApellidoPaterno).'",
			"'.($this->SocApellidoMaterno).'",			
			"'.($this->SocNumeroDocumento).'",
			
			"'.($this->SocEmail).'",
			"'.($this->SocTelefono).'",
			"'.($this->SocCelular).'",
			"'.($this->SocDireccion).'",
			"'.($this->SocFoto).'",
			
			'.($this->SocEstado).', 
			"'.($this->SocTiempoCreacion).'", 
			"'.($this->SocTiempoModificacion).'");';

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
	

	public function MtdEditarSocio() {
		

			$sql = 'UPDATE tblsocsocio SET 
			TdoId = "'.($this->TdoId).'",
			SocNombre = "'.($this->SocNombre).'",
			SocApellidoPaterno = "'.($this->SocApellidoPaterno).'",
			SocApellidoMaterno = "'.($this->SocApellidoMaterno).'",
			SocNumeroDocumento = "'.($this->SocNumeroDocumento).'",
			
			SocEmail = "'.($this->SocEmail).'",
			SocTelefono = "'.($this->SocTelefono).'",
			SocCelular = "'.($this->SocCelular).'",
			SocDireccion = "'.($this->SocDireccion).'",
			SocFoto = "'.($this->SocFoto).'",
			
			SocEstado = '.($this->SocEstado).',
			SocTiempoModificacion = "'.($this->SocTiempoModificacion).'"
			WHERE SocId = "'.($this->SocId).'";';
			
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