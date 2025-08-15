<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsClienteNota
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsClienteNota {

    public $CnoId;
	public $CliId;
	public $PerId;
	
	public $CnoDescripcion;
   
	public $CnoEstado;	
    public $CnoTiempoCreacion;
    public $CnoTiempoModificacion;
    public $CnoEliminado;

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
		
	public function MtdGenerarClienteNotaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CnoId,5),unsigned)) AS "MAXIMO"
			FROM tblcnoclientenota';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CnoId = "CNO-10000";

			}else{
				$fila['MAXIMO']++;
				$this->CnoId = "CNO-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerClienteNota(){

        $sql = 'SELECT 
        cno.CnoId,
		cno.CliId,
		cno.PerId,
		
		DATE_FORMAT(cno.CnoFecha, "%d/%m/%Y") AS "NCnoFecha",
		cno.CnoDescripcion,
		
		cno.CnoEstado,	
		DATE_FORMAT(cno.CnoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCnoTiempoCreacion",
        DATE_FORMAT(cno.CnoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCnoTiempoModificacion",
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliNumeroDocumento,
		cli.TdoId
		
		
        FROM tblcnoclientenota cno
			LEFT JOIN tblclicliente cli
			ON cno.CliId = cli.CliId
        WHERE CnoId = "'.$this->CnoId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CnoId = $fila['CnoId'];
			$this->CliId = $fila['CliId'];
			$this->PerId = $fila['PerId'];
			
			$this->CnoFecha = $fila['NCnoFecha'];			
            $this->CnoDescripcion = $fila['CnoDescripcion'];
			$this->CnoApellidoPaterno = $fila['CnoApellidoPaterno'];
			$this->CnoApellidoMaterno = $fila['CnoApellidoMaterno'];
			$this->CnoEmail = $fila['CnoEmail'];
			$this->CnoTelefono = $fila['CnoTelefono'];
			$this->CnoCelular = $fila['CnoCelular'];
			$this->CnoDireccion = $fila['CnoDireccion'];
			$this->CnoFoto = $fila['CnoFoto'];
			$this->CnoEstado = $fila['CnoEstado'];
			$this->CnoTiempoCreacion = $fila['NCnoTiempoCreacion'];
			$this->CnoTiempoModificacion = $fila['NCnoTiempoModificacion'];

			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
			$this->CliNombre = $fila['CliNombre'];
			
				switch($this->CnoEstado){
					case 1:
						$this->CnoEstadoDescripcion = "Expirado";
					break;
										
					case 3:
						$this->CnoEstadoDescripcion = "Vigente";
					break;
				
				}
				
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerClienteNotas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CnoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oClienteId=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$tipo = '';
		$estado = '';
		$fecha = '';
		$categoria = '';
		$orden = '';
		$paginacion = '';
		$cliente = '';

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
			
				
		if(!empty($oEstado)){
			$estado = ' AND cno.CnoEstado = '.$oEstado;
		}	
		
		if(!empty($oClienteId)){
			$cliente = ' AND cno.CliId = "'.$oClienteId.'"';
		}	
		
			if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cno.CnoFecha)>="'.$oFechaInicio.'" AND DATE(cno.CnoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cno.CnoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cno.CnoFecha)<="'.$oFechaFin.'"';		
			}			
		}
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cno.CnoId,
				cno.PerId,
				DATE_FORMAT(cno.CnoFecha, "%d/%m/%Y") AS "NCnoFecha",
				cno.CliId,
				cno.CnoDescripcion,	
				cno.CnoEstado,
				DATE_FORMAT(cno.CnoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCnoTiempoCreacion",
                DATE_FORMAT(cno.CnoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCnoTiempoModificacion",
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,
				cli.TdoId,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno
				
				FROM tblcnoclientenota cno	
					LEFT JOIN tblclicliente cli
					  ON cno.CliId = cli.CliId
					  	LEFT JOIN tblperpersonal per
						ON cno.PerId = per.PerId
						
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$fecha.$cliente.$categoria.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsClienteNota = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ClienteNota = new $InsClienteNota();				
					
                    $ClienteNota->CnoId = $fila['CnoId'];
					$ClienteNota->CliId = $fila['CliId'];
					
					$ClienteNota->CnoFecha= $fila['NCnoFecha'];
					$ClienteNota->CnoDescripcion= $fila['CnoDescripcion'];
					$ClienteNota->CnoEstado = $fila['CnoEstado'];					
                    $ClienteNota->CnoTiempoCreacion = $fila['NCnoTiempoCreacion'];
                    $ClienteNota->CnoTiempoModificacion = $fila['NCnoTiempoModificacion'];
					
					$ClienteNota->CliNombre = $fila['CliNombre'];
					$ClienteNota->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$ClienteNota->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$ClienteNota->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$ClienteNota->TdoId = $fila['TdoId'];  
					
					$ClienteNota->PerNombre = $fila['PerNombre'];  
					$ClienteNota->PerApellidoPaterno = $fila['PerApellidoPaterno'];  
					$ClienteNota->PerApellidoMaterno = $fila['PerApellidoMaterno'];    

					switch($ClienteNota->CnoEstado){
						case 1:
							$ClienteNota->CnoEstadoDescripcion = "Expirado";
						break;
											
						case 3:
							$ClienteNota->CnoEstadoDescripcion = "Vigente";
						break;
					
					}
				
                    $ClienteNota->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ClienteNota;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarClienteNota($oElementos) {
		
		// Inicializar variable para evitar warnings
		$eliminar = '';
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CnoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CnoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblcnoclientenota WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarClienteNota() {

			$this->MtdGenerarClienteNotaId();
		
			$sql = 'INSERT INTO tblcnoclientenota (
			CnoId,
			CliId,
			PerId,
			
			CnoFecha,
			CnoDescripcion,
			
			CnoEstado,
			CnoTiempoCreacion,
			CnoTiempoModificacion
			) 
			VALUES (
			"'.($this->CnoId).'", 
			"'.($this->CliId).'",
			"'.($this->PerId).'",
			
			"'.($this->CnoFecha).'",
			"'.($this->CnoDescripcion).'",
			
			'.($this->CnoEstado).', 
			"'.($this->CnoTiempoCreacion).'", 
			"'.($this->CnoTiempoModificacion).'");';

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
	

	public function MtdEditarClienteNota() {
		

			$sql = 'UPDATE tblcnoclientenota SET 
			CliId = "'.($this->CliId).'",
			PerId = "'.($this->PerId).'",
			
			CnoFecha = "'.($this->CnoFecha).'",
			CnoDescripcion = "'.($this->CnoDescripcion).'",
			
			CnoEstado = '.($this->CnoEstado).',
			CnoTiempoModificacion = "'.($this->CnoTiempoModificacion).'"
			WHERE CnoId = "'.($this->CnoId).'";';
			
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