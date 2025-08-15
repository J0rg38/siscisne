<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsClientePersonal
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsClientePersonal {

    public $CpeId;
	public $CliId;
	public $PerId;
	
	public $CpeDescripcion;
   
	public $CpeEstado;	
    public $CpeTiempoCreacion;
    public $CpeTiempoModificacion;
    public $CpeEliminado;

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
		
	public function MtdGenerarClientePersonalId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CpeId,5),unsigned)) AS "MAXIMO"
			FROM tblcpeclientepersonal';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CpeId = "CPE-10000";

			}else{
				$fila['MAXIMO']++;
				$this->CpeId = "CPE-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerClientePersonal(){

        $sql = 'SELECT 
        cpe.CpeId,
		cpe.CliId,
		cpe.PerId,
		
		DATE_FORMAT(cpe.CpeFecha, "%d/%m/%Y") AS "NCpeFecha",
		cpe.CpeDescripcion,
		
		cpe.CpeEstado,	
		DATE_FORMAT(cpe.CpeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCpeTiempoCreacion",
        DATE_FORMAT(cpe.CpeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCpeTiempoModificacion",
		
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliNumeroDocumento,
		cli.TdoId
		
        FROM tblcpeclientepersonal cpe
			LEFT JOIN tblclicliente cli
			ON cpe.CliId = cli.CliId
        WHERE CpeId = "'.$this->CpeId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CpeId = $fila['CpeId'];
			$this->CliId = $fila['CliId'];
			$this->PerId = $fila['PerId'];
			
			$this->CpeFecha = $fila['NCpeFecha'];			
            $this->CpeDescripcion = $fila['CpeDescripcion'];
			
			$this->CpeEstado = $fila['CpeEstado'];
			$this->CpeTiempoCreacion = $fila['NCpeTiempoCreacion'];
			$this->CpeTiempoModificacion = $fila['NCpeTiempoModificacion'];

			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
		
			
				switch($this->CpeEstado){
					case 1:
						$this->CpeEstadoDescripcion = "Antiguo";
					break;
										
					case 3:
						$this->CpeEstadoDescripcion = "Vigente";
					break;
				
				}
				
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerClientePersonals($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CpeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oClienteId=NULL) {

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
			$estado = ' AND cpe.CpeEstado = '.$oEstado;
		}	
		
		if(!empty($oClienteId)){
			$cliente = ' AND cpe.CliId = "'.$oClienteId.'"';
		}	
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cpe.CpeId,
				cpe.PerId,
				DATE_FORMAT(cpe.CpeFecha, "%d/%m/%Y") AS "NCpeFecha",
				cpe.CliId,
				cpe.CpeDescripcion,	
				cpe.CpeEstado,
				DATE_FORMAT(cpe.CpeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCpeTiempoCreacion",
                DATE_FORMAT(cpe.CpeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCpeTiempoModificacion",
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,
				cli.TdoId,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno
				
				FROM tblcpeclientepersonal cpe	
					LEFT JOIN tblclicliente cli
					  ON cpe.CliId = cli.CliId
					  	LEFT JOIN tblperpersonal per
						ON cpe.PerId = per.PerId
						
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$fecha.$cliente.$categoria.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsClientePersonal = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ClientePersonal = new $InsClientePersonal();				
					
                    $ClientePersonal->CpeId = $fila['CpeId'];
					$ClientePersonal->CliId = $fila['CliId'];
					
					$ClientePersonal->CpeFecha= $fila['NCpeFecha'];
					$ClientePersonal->CpeDescripcion= $fila['CpeDescripcion'];
					$ClientePersonal->CpeEstado = $fila['CpeEstado'];					
                    $ClientePersonal->CpeTiempoCreacion = $fila['NCpeTiempoCreacion'];
                    $ClientePersonal->CpeTiempoModificacion = $fila['NCpeTiempoModificacion'];
					
					$ClientePersonal->CliNombre = $fila['CliNombre'];
					$ClientePersonal->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$ClientePersonal->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$ClientePersonal->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$ClientePersonal->TdoId = $fila['TdoId'];  
					
					$ClientePersonal->PerNombre = $fila['PerNombre'];  
					$ClientePersonal->PerApellidoPaterno = $fila['PerApellidoPaterno'];  
					$ClientePersonal->PerApellidoMaterno = $fila['PerApellidoMaterno'];    

					switch($ClientePersonal->CpeEstado){
						case 1:
							$ClientePersonal->CpeEstadoDescripcion = "Antiguo";
						break;
											
						case 3:
							$ClientePersonal->CpeEstadoDescripcion = "Vigente";
						break;
					
					}
				
                    $ClientePersonal->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ClientePersonal;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarClientePersonal($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CpeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CpeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblcpeclientepersonal WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarClientePersonal() {

			$this->MtdGenerarClientePersonalId();
		
			$sql = 'INSERT INTO tblcpeclientepersonal (
			CpeId,
			CliId,
			PerId,
			
			CpeFecha,
			CpeDescripcion,
			
			CpeEstado,
			CpeTiempoCreacion,
			CpeTiempoModificacion
			) 
			VALUES (
			"'.($this->CpeId).'", 
			"'.($this->CliId).'",
			"'.($this->PerId).'",
			
			"'.($this->CpeFecha).'",
			"'.($this->CpeDescripcion).'",
			
			'.($this->CpeEstado).', 
			"'.($this->CpeTiempoCreacion).'", 
			"'.($this->CpeTiempoModificacion).'");';

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
	

	public function MtdEditarClientePersonal() {
		

			$sql = 'UPDATE tblcpeclientepersonal SET 
			CliId = "'.($this->CliId).'",
			PerId = "'.($this->PerId).'",
			
			CpeFecha = "'.($this->CpeFecha).'",
			CpeDescripcion = "'.($this->CpeDescripcion).'",
			
			CpeEstado = '.($this->CpeEstado).',
			CpeTiempoModificacion = "'.($this->CpeTiempoModificacion).'"
			WHERE CpeId = "'.($this->CpeId).'";';
			
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