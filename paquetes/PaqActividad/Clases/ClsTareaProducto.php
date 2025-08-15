<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTareaProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTareaProducto {

    public $TprId;
	public $PmaId;
	public $PmtId;
	public $TprAccion;
	public $TprKilometraje;
    public $TprEliminado;
	public $AlmId;
	
	public $PmtNombre;
	
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

	
		public function MtdGenerarTareaProductoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TprId,5),unsigned)) AS "MAXIMO"
			FROM tbltprtareaproducto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TprId ="TPR-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TprId = "TPR-".$fila['MAXIMO'];					
			}		
					
		}
		
 public function MtdObtenerTareaProducto(){

        $sql = 'SELECT 
       tpr.TprId,
			tpr.PmaId,	
			tpr.PmtId,
			tpr.ProId,
			tpr.UmeId,
			tpr.TprCantidad,
			tpr.TprKilometraje,
			tpr.AlmId,
			
			pmt.PmtNombre,
			pma.PmaNombre,
			
			pro.RtiId,

			pro.ProCodigoOriginal,
			pro.ProNombre,
			  pro.ProStockReal,
			
			ume.UmeNombre,
			
			vmo.VmaId

       FROM tbltprtareaproducto tpr
	   
		LEFT JOIN tblpmtplanmantenimientotarea pmt
		ON tpr.PmtId = pmt.PmtId
		   	LEFT JOIN tblpmaplanmantenimiento pma
			ON tpr.PmaId = pma.PmaId
				LEFT JOIN tblvmovehiculomodelo vmo
				ON pma.VmoId = vmo.VmoId
				
				LEFT JOIN tblproproducto pro
				ON tpr.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON tpr.UmeId = ume.UmeId
				
        WHERE tpr.TprId = "'.$this->TprId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TprId = $fila['TprId'];
			$this->PmaId = $fila['PmaId'];
			$this->PmtId = $fila['PmtId'];
			$this->ProId = $fila['ProId'];
			$this->UmeId = $fila['UmeId']; 
			$this->TprCantidad = $fila['TprCantidad']; 
			$this->TprKilometraje = $fila['TprKilometraje']; 
			$this->AlmId = $fila['AlmId']; 
			
			$this->PmtNombre = $fila['PmtNombre']; 
			$this->PmaNombre = $fila['PmaNombre']; 
			
			$this->RtiId = $fila['RtiId']; 
			
			$this->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
			$this->ProNombre = $fila['ProNombre'];
			$this->ProStockReal = $fila['ProStockReal']; 
			
			$this->UmeNombre = $fila['UmeNombre']; 
			$this->VmaId = $fila['VmaId']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
		
    public function MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$pmantenimiento = '';
		$kilometraje = '';
		$tarea = '';

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
		
		if(!empty($oPlanMantenimiento)){
			$pmantenimiento = ' AND tpr.PmaId = "'.$oPlanMantenimiento.'"';
		}
		
		if(!empty($oKilometraje)){
			$kilometraje = ' AND tpr.TprKilometraje = "'.$oKilometraje.'"';
		}		
		
		if(!empty($oTarea)){
			$tarea = ' AND tpr.PmtID = "'.$oTarea.'"';
		}	
		
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			tpr.TprId,
			tpr.PmaId,	
			tpr.PmtId,
			tpr.ProId,
			tpr.UmeId,
			tpr.TprCantidad,
			tpr.TprKilometraje,
			tpr.AlmId,
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProStockReal,
			pro.ProTienePromocion,
			
			ume.UmeNombre
			
			FROM tbltprtareaproducto tpr
				LEFT JOIN tblproproducto pro
				ON tpr.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON tpr.UmeId = ume.UmeId
						
			WHERE  1 = 1 '.$pmantenimiento.$kilometraje.$tarea.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTareaProducto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TareaProducto = new $InsTareaProducto();
                    $TareaProducto->TprId = $fila['TprId'];
                    $TareaProducto->PmaId = $fila['PmaId'];					
					$TareaProducto->PmtId = $fila['PmtId'];	
					$TareaProducto->ProId = $fila['ProId'];
					$TareaProducto->UmeId = $fila['UmeId'];
					$TareaProducto->TprCantidad = $fila['TprCantidad'];
					$TareaProducto->TprKilometraje = $fila['TprKilometraje'];
					$TareaProducto->AlmId = $fila['AlmId'];
					
					$TareaProducto->ProNombre = $fila['ProNombre'];
					$TareaProducto->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$TareaProducto->ProStockReal = $fila['ProStockReal'];
					$TareaProducto->ProTienePromocion = $fila['ProTienePromocion'];
					
					$TareaProducto->UmeNombre = $fila['UmeNombre'];
					
                    $TareaProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TareaProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarTareaProducto($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (TprId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (TprId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tbltprtareaproducto 
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
	
	
	public function MtdRegistrarTareaProducto() {
	
			$this->MtdGenerarTareaProductoId();



			$sql = 'INSERT INTO tbltprtareaproducto (
			TprId,
			PmaId,	
			PmtId,
			ProId,
			UmeId,
			
			AlmId,
			TprCantidad,
			TprKilometraje
			) 
			VALUES (
			"'.($this->TprId).'", 
			"'.($this->PmaId).'", 
			"'.($this->PmtId).'", 
			"'.($this->ProId).'", 
			"'.($this->UmeId).'", 
			
			'.(empty($this->AlmId)?"NULL,":'"'.$this->AlmId.'",').'
			'.($this->TprCantidad).', 
			"'.($this->TprKilometraje).'");';
		
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
	
	public function MtdEditarTareaProducto() {
	
		$sql = 'UPDATE tbltprtareaproducto SET 
		
		ProId = "'.($this->ProId).'",
		UmeId = "'.($this->UmeId).'",
		'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
		
		TprCantidad = '.($this->TprCantidad).'
		WHERE TprId = "'.($this->TprId).'";';
		
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