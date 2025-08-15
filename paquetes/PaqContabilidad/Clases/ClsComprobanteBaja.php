<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsComprobanteBaja
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsComprobanteBaja {

    public $CbjId;
	
	public $FacId;
	public $FtaId;
	
    public $BolId;
	public $BtaId;
	
	public $NcrId;
	public $NctId;
	
	public $NdbId;
	public $NdtId;
	
	public $CbjFecha;
	public $CbjNumeracion;
	
    public $CbjTiempoCreacion;
    public $CbjTiempoModificacion;
    public $CbjEliminado;
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
	
	
	
	
	public function MtdGenerarComprobanteBajaId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CbjId,5),unsigned)) AS "MAXIMO"
			FROM tblcbjcomprobantebaja';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CbjId = "CBJ-10000";

			}else{
				$fila['MAXIMO']++;
				$this->CbjId = "CBJ-".$fila['MAXIMO'];					
			}	
			
				
		}
		
		
	public function MtdGenerarComprobanteBajaNumeracion() {

	/*	$sql = 'SELECT	
		MAX(CONVERT(cbj.CbjNumeracion,unsigned)) AS "MAXIMO"
		FROM tblcbjcomprobantebaja cbj 
		WHERE cbj.CbjFecha = DATE(NOW());';			*/
		
			$sql = 'SELECT	
		MAX((cbj.CbjNumeracion)) AS "MAXIMO"
		FROM tblcbjcomprobantebaja cbj 
		WHERE cbj.CbjFecha = DATE(NOW());';			
		

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){	
			$this->CbjNumeracion = "1";			
		}else{
			$fila['MAXIMO']++;
			$this->CbjNumeracion = ($fila['MAXIMO']);	
		}
		
		return $this->CbjNumeracion;
			
	}
	
	
	
		
    public function MtdObtenerComprobanteBaja(){

        $sql = 'SELECT 
        cbj.CbjId,
		
        cbj.FacId,
		cbj.FtaId,
		
		cbj.BolId,
		cbj.BtaId,
		
		cbj.NcrId,
		cbj.NctId,
		
		cbj.NdbId,
		cbj.NdtId
		
		DATE_FORMAT(cbj.CbjFecha, "%d/%m/%Y") AS "NCbjFecha",
		cbj.CbjNumeracion,
		cbj.CbjArchivo,
		cbj.CbjEstado,
		
		DATE_FORMAT(cbj.CbjTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCbjTiempoCreacion",
        DATE_FORMAT(cbj.CbjTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCbjTiempoModificacion"
		
        FROM tblcbjcomprobantebaja
        WHERE CbjId = "'.$this->CbjId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CbjId = $fila['CbjId'];
			
			$this->FacId = $fila['FacId'];
			$this->FtaId = $fila['FtaId'];
			
			$this->BolId = $fila['BolId'];
			$this->BtaId = $fila['BtaId'];
			
			$this->NcrId = $fila['NcrId'];
			$this->NctId = $fila['NctId'];
			
			$this->NdbId = $fila['NdbId'];
			$this->NdtId = $fila['NdtId'];
			
			$this->CbjFecha = $fila['NCbjFecha'];
			$this->CbjNumeracion = $fila['CbjNumeracion'];
			
			$this->CbjArchivo = $fila['CbjArchivo'];
			$this->CbjEstado = $fila['CbjEstado'];
			
			$this->CbjTiempoCreacion = $fila['NCbjTiempoCreacion'];
			$this->CbjTiempoModificacion = $fila['NCbjTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerComprobanteBajas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CbjId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
								
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cbj.CbjFecha)>="'.$oFechaInicio.'" AND DATE(cbj.CbjFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cbj.CbjFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cbj.CbjFecha)<="'.$oFechaFin.'"';		
			}			
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				cbj.FacId,
				cbj.FtaId,
				
				cbj.BolId,
				cbj.BtaId,
				
				cbj.NcrId,
				cbj.NctId,
				
				cbj.NdbId,
				cbj.NdtId
				
				DATE_FORMAT(cbj.CbjFecha, "%d/%m/%Y") AS "NCbjFecha",
				cbj.CbjNumeracion,
				cbj.CbjArchivo,
				cbj.CbjEstado,
				
				DATE_FORMAT(cbj.CbjTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCbjTiempoCreacion",
				DATE_FORMAT(cbj.CbjTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCbjTiempoModificacion"
				
				FROM tblcbjcomprobantebaja cbj
					
				WHERE 1 = 1 '.$filtrar.$fecha.$moneda.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsComprobanteBaja = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ComprobanteBaja = new $InsComprobanteBaja();
                    $ComprobanteBaja->CbjId = $fila['CbjId'];
					
					$ComprobanteBaja->FacId = $fila['FacId'];
					$ComprobanteBaja->FtaId = $fila['FtaId'];
					
					$ComprobanteBaja->BolId = $fila['BolId'];
					$ComprobanteBaja->BtaId = $fila['BtaId'];
					
					$ComprobanteBaja->NcrId = $fila['NcrId'];
					$ComprobanteBaja->NctId = $fila['NctId'];
					
					$ComprobanteBaja->NdbId = $fila['NdbId'];
					$ComprobanteBaja->NdtId = $fila['NdtId'];
					
					$ComprobanteBaja->CbjFecha = $fila['NCbjFecha'];
					$ComprobanteBaja->CbjNumeracion = $fila['CbjNumeracion'];
					
					$ComprobanteBaja->CbjArchivo = $fila['CbjArchivo'];
					$ComprobanteBaja->CbjEstado = $fila['CbjEstado'];
					
					$ComprobanteBaja->CbjTiempoCreacion = $fila['NCbjTiempoCreacion'];
					$ComprobanteBaja->CbjTiempoModificacion = $fila['NCbjTiempoModificacion'];
			
			
                    $ComprobanteBaja->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ComprobanteBaja;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarComprobanteBaja($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CbjId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CbjId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblcbjcomprobantebaja WHERE '.$eliminar;

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
	
	
				
	public function MtdRegistrarComprobanteBaja() {
	
			$this->MtdGenerarComprobanteBajaId();
		
			 $sql = 'INSERT INTO tblcbjcomprobantebaja (
			CbjId,
			
			FacId,			
			FtaId, 
			
			BolId,
			BtaId,
			
			NcrId,
			NctId,
			
			NdbId,
			NdtId,
			
			CbjFecha,
			CbjNumeracion,
			
			CbjArchivo,
			CbjEstado,
			
			CbjTiempoCreacion,
			CbjTiempoModificacion
			) 
			VALUES (
			"'.($this->CbjId).'", 
			'.(empty($this->FacId)?'NULL, ':'"'.$this->FacId.'",').'
			'.(empty($this->FtaId)?'NULL, ':'"'.$this->FtaId.'",').'
			
			'.(empty($this->BolId)?'NULL, ':'"'.$this->BolId.'",').'
			'.(empty($this->BtaId)?'NULL, ':'"'.$this->BtaId.'",').'
			
			'.(empty($this->NcrId)?'NULL, ':'"'.$this->NcrId.'",').'
			'.(empty($this->NctId)?'NULL, ':'"'.$this->NctId.'",').'
			
			'.(empty($this->NdbId)?'NULL, ':'"'.$this->NdbId.'",').'
			'.(empty($this->NdtId)?'NULL, ':'"'.$this->NdtId.'",').'
			
			"'.($this->CbjFecha).'", 
			"'.($this->CbjNumeracion).'", 
			
			"'.($this->CbjArchivo).'", 
			'.($this->CbjEstado).', 
			
			"'.($this->CbjTiempoCreacion).'", 
			"'.($this->CbjTiempoModificacion).'");';					

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
	
	public function MtdEdicbjComprobanteBaja() {
		
			$sql = 'UPDATE tblcbjcomprobantebaja SET 
			
			'.(empty($this->FacId)?'FacId = NULL, ':'FacId = "'.$this->FacId.'",').'
			'.(empty($this->FtaId)?'FtaId = NULL, ':'FtaId = "'.$this->FtaId.'",').'
			
			'.(empty($this->BolId)?'BolId = NULL, ':'BolId = "'.$this->BolId.'",').'
			'.(empty($this->BtaId)?'BtaId = NULL, ':'BtaId = "'.$this->BtaId.'",').'
			
			'.(empty($this->NcrId)?'NcrId = NULL, ':'NcrId = "'.$this->NcrId.'",').'
			'.(empty($this->NctId)?'NctId = NULL, ':'NctId = "'.$this->NctId.'",').'
			
			'.(empty($this->NdbId)?'NdbId = NULL, ':'NdbId = "'.$this->NdbId.'",').'
			'.(empty($this->NdtId)?'NdtId = NULL, ':'NdtId = "'.$this->NdtId.'",').'
			
			CbjFecha = "'.($this->CbjFecha).'",
			CbjNumeracion = "'.($this->CbjNumeracion).'",
			
			CbjArchivo = "'.($this->CbjArchivo).'",
			CbjEstado = '.($this->CbjEstado).',
			
			CbjTiempoModificacion = "'.($this->CbjTiempoModificacion).'"
			
			WHERE CbjId = "'.($this->CbjId).'";';
			
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