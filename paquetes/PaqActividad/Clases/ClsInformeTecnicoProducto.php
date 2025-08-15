<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsInformeTecnicoProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsInformeTecnicoProducto {

    public $ItpId;
	public $IteId;
	
	public $ProId;
	public $UmeId;
	
	public $ItpValorUnitario;
    public $ItpCantidad;
	public $ItpValorTotal;

	public $ItpEstado;	
	public $ItpTiempoCreacion;
	public $ItpTiempoModificacion;
    public $ItpEliminado;
	
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

	private function MtdGenerarInformeTecnicoProductoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ItpId,5),unsigned)) AS "MAXIMO"
		FROM tblitpinformetecnicoproducto';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->ItpId = "ITP-10000";
		}else{
			$fila['MAXIMO']++;
			$this->ItpId = "ITP-".$fila['MAXIMO'];					
		}
				
	}

    public function MtdObtenerInformeTecnicoProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ItpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oInformeTecnico=NULL,$oEstado=NULL,$oProducto=NULL) {

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
		
		if(!empty($oInformeTecnico)){
			$garantia = ' AND itp.IteId = "'.$oInformeTecnico.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND itp.ItpEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (itp.ProId = "'.$oProducto.'") ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			itp.ItpId,			
			itp.IteId,
			
			itp.ProId,
			itp.UmeId,
		
			itp.ItpValorUnitario,
			itp.ItpCantidad,
			itp.ItpValorTotal,
			
			itp.ItpEstado,
			DATE_FORMAT(itp.ItpTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NItpTiempoCreacion",
	        DATE_FORMAT(itp.ItpTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NItpTiempoModificacion",
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.UmeId,
			
			ume.UmeNombre
			
			
			FROM tblitpinformetecnicoproducto itp
				LEFT JOIN tblproproducto pro
				ON itp.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON pro.UmeId = ume.UmeId
					
			WHERE  1 = 1 '.$garantia.$estado.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsInformeTecnicoProducto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$InformeTecnicoProducto = new $InsInformeTecnicoProducto();
                    $InformeTecnicoProducto->ItpId = $fila['ItpId'];
                    $InformeTecnicoProducto->IteId = $fila['IteId'];
					
					$InformeTecnicoProducto->ProId = $fila['ProId'];
					$InformeTecnicoProducto->UmeId = $fila['UmeId'];

					$InformeTecnicoProducto->ItpCodigo = $fila['ItpCodigo'];  
					$InformeTecnicoProducto->ItpDescripcion = $fila['ItpDescripcion'];  
			
					$InformeTecnicoProducto->ItpValorUnitario = $fila['ItpValorUnitario'];
			        $InformeTecnicoProducto->ItpCantidad = $fila['ItpCantidad'];  
					$InformeTecnicoProducto->ItpValorTotal = $fila['ItpValorTotal'];
					
					$InformeTecnicoProducto->ItpEstado = $fila['ItpEstado'];
					$InformeTecnicoProducto->ItpTiempoCreacion = $fila['NItpTiempoCreacion'];  
					$InformeTecnicoProducto->ItpTiempoModificacion = $fila['NItpTiempoModificacion'];
					
					$InformeTecnicoProducto->ProNombre = $fila['ProNombre'];
					$InformeTecnicoProducto->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$InformeTecnicoProducto->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					$InformeTecnicoProducto->UmeId = $fila['UmeId'];
					
					$InformeTecnicoProducto->UmeNombre = $fila['UmeNombre']; 					

                    $InformeTecnicoProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $InformeTecnicoProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarInformeTecnicoProducto($oElementos) {
		
//		$InsInformeTecnicoProductoOrigen = new ClsInformeTecnicoProductoOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (ItpId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (ItpId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblitpinformetecnicoproducto 
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
	
	
	public function MtdRegistrarInformeTecnicoProducto() {
	
			$this->MtdGenerarInformeTecnicoProductoId();
			
			$sql = 'INSERT INTO tblitpinformetecnicoproducto (
			ItpId,
			IteId,
			
			FapId,
			
			ProId,
			UmeId,
			
			ItpValorUnitario,
			ItpCantidad,
			ItpValorTotal,
			
			ItpEstado,
			ItpTiempoCreacion,
			ItpTiempoModificacion) 
			VALUES (
			"'.($this->ItpId).'", 
			"'.($this->IteId).'", 
			
			'.(empty($this->FapId)?'NULL,':'"'.$this->FapId.'",').'	
			
			"'.($this->ProId).'", 
			"'.($this->UmeId).'", 

			'.($this->ItpValorUnitario).', 	
			'.($this->ItpCantidad).',
			'.($this->ItpValorTotal).', 	
			
			'.($this->ItpEstado).',
			"'.($this->ItpTiempoCreacion).'",
			"'.($this->ItpTiempoModificacion).'");';
		
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
	
	public function MtdEditarInformeTecnicoProducto() {

			$sql = 'UPDATE tblitpinformetecnicoproducto SET 	
			
			ItpValorUnitario = '.($this->ItpValorUnitario).',
			ItpCantidad = '.($this->ItpCantidad).',
			ItpValorTotal = '.($this->ItpValorTotal).',
			
			ItpTiempoModificacion = "'.($this->ItpTiempoModificacion).'"
			
			WHERE ItpId = "'.($this->ItpId).'";';
					
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