<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGarantiaRepuestoIsuzuManoObra
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGarantiaRepuestoIsuzuManoObra {

    public $GdmId;
	public $GriId;
	
	public $GdmOperacion;	
	public $GdmCodigo;
	public $GdmTiempo;
	
	public $GdmEstado;	
	public $GdmCodigoCreacion;
	public $GdmCodigoModificacion;
    public $GdmEliminado;
	
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

	private function MtdGenerarGarantiaRepuestoIsuzuManoObraId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(GdmId,5),unsigned)) AS "MAXIMO"
		FROM tblgdmgarantiarepuestoisuzumanoobra';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->GdmId = "GDM-10000";
		}else{
			$fila['MAXIMO']++;
			$this->GdmId = "GDM-".$fila['MAXIMO'];					
		}
			
	}

    public function MtdObtenerGarantiaRepuestoIsuzuManoObras($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GdmId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGarantia=NULL,$oEstado=NULL) {

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
		
		if(!empty($oGarantia)){
			$garantia = ' AND gdm.GriId = "'.$oGarantia.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND gdm.GdmEstado = '.$oEstado.' ';
		}
			
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			gdm.GdmId,			
			gdm.GriId,

			gdm.GdmOperacion,
			gdm.GdmCodigo,
			gdm.GdmTiempo,
			gdm.GdmCosto,
		
			gdm.GdmEstado,
			DATE_FORMAT(gdm.GdmCodigoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGdmCodigoCreacion",
	        DATE_FORMAT(gdm.GdmCodigoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGdmCodigoModificacion"
			
			FROM tblgdmgarantiarepuestoisuzumanoobra gdm
			WHERE  1 = 1 '.$garantia.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGarantiaRepuestoIsuzuManoObra = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GarantiaRepuestoIsuzuManoObra = new $InsGarantiaRepuestoIsuzuManoObra();
                    $GarantiaRepuestoIsuzuManoObra->GdmId = $fila['GdmId'];
                    $GarantiaRepuestoIsuzuManoObra->GriId = $fila['GriId'];

					$GarantiaRepuestoIsuzuManoObra->GdmOperacion = $fila['GdmOperacion'];  
					$GarantiaRepuestoIsuzuManoObra->GdmCodigo = $fila['GdmCodigo'];  
					$GarantiaRepuestoIsuzuManoObra->GdmTiempo = $fila['GdmTiempo'];
			        $GarantiaRepuestoIsuzuManoObra->GdmCosto = $fila['GdmCosto'];
					
					$GarantiaRepuestoIsuzuManoObra->GdmEstado = $fila['GdmEstado'];
					$GarantiaRepuestoIsuzuManoObra->GdmCodigoCreacion = $fila['NGdmCodigoCreacion'];  
					$GarantiaRepuestoIsuzuManoObra->GdmCodigoModificacion = $fila['NGdmCodigoModificacion']; 					

                    $GarantiaRepuestoIsuzuManoObra->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GarantiaRepuestoIsuzuManoObra;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarGarantiaRepuestoIsuzuManoObra($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (GdmId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GdmId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblgdmgarantiarepuestoisuzumanoobra 
				WHERE '.$eliminar;
							
				$error = false;
	
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				} 	
				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarGarantiaRepuestoIsuzuManoObra() {
	
			$this->MtdGenerarGarantiaRepuestoIsuzuManoObraId();
			
			
			$sql = 'INSERT INTO tblgdmgarantiarepuestoisuzumanoobra (
			GdmId,
			GriId,
			
			GdmOperacion,
			GdmCodigo,			
			GdmTiempo,
			GdmCosto,
			
			GdmEstado,
			GdmCodigoCreacion,
			GdmCodigoModificacion) 
			VALUES (
			"'.($this->GdmId).'", 
			"'.($this->GriId).'", 			
		
			"'.($this->GdmOperacion).'", 
			"'.($this->GdmCodigo).'", 
			'.($this->GdmTiempo).', 	
			'.($this->GdmCosto).',
			
			'.($this->GdmEstado).',
			"'.($this->GdmCodigoCreacion).'",
			"'.($this->GdmCodigoModificacion).'");';
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
		
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarGarantiaRepuestoIsuzuManoObra() {

			$sql = 'UPDATE tblgdmgarantiarepuestoisuzumanoobra SET 	
			
			GdmOperacion = "'.($this->GdmOperacion).'",
			GdmCodigo = "'.($this->GdmCodigo).'",			 
			GdmTiempo = '.($this->GdmTiempo).',
			GdmCosto = '.($this->GdmCosto).',
			
			GdmCodigoModificacion = "'.($this->GdmCodigoModificacion).'"
			 
			WHERE GdmId = "'.($this->GdmId).'";';
					
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}	
		
		
		
		public function MtdEditarGarantiaRepuestoIsuzuManoObraDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblgdmgarantiarepuestoisuzumanoobra SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			GdmCodigoModificacion = NOW()
			WHERE GdmId = "'.($oId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
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