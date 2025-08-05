<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsListaPrecio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsListaPrecio {

    public $LprId;
	public $ProId;
	public $LtiId;
	public $UmeId;
	
	public $LprCosto;
	public $LprPorcentajeUtilidad;
	public $LprPorcentajeOtroCosto;
	public $LprPorcentajeAdicional;
	public $LprPorcentajeDescuento;

	public $LprOtroCosto;	
	public $LprUtilidad;
	public $LprAdicional;
	public $LprValorVenta;
	public $LprImpuesto;
	public $LprDescuento;
	public $LprPrecio;

    public $LprTiempoCreacion;
    public $LprTiempoModificacion;
    public $LprEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	public function MtdGenerarListaPrecioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(LprId,5),unsigned)) AS "MAXIMO"
			FROM tbllprlistaprecio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->LprId ="LPR-10000";
			}else{
				$fila['MAXIMO']++;
				$this->LprId = "LPR-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerListaPrecio(){

        $sql = 'SELECT 
        lpr.LprId,
		lpr.SucId,
		
		lpr.ProId,
		lpr.LtiId,
		lpr.UmeId,
		
		lpr.LprCosto,
		lpr.LprPorcentajeOtroCosto,
		lpr.LprPorcentajeUtilidad,
		lpr.LprPorcentajeManoObra,
		
		lpr.LprPorcentajeAdicional,
		lpr.LprPorcentajeDescuento,
		
		lpr.LprOtroCosto,
		lpr.LprUtilidad,
		lpr.LprManoObra,
		
		lpr.LprAdicional,
		
		lpr.LprValorVenta,
		lpr.LprImpuesto,
		lpr.LprDescuento,
		lpr.LprPrecio,

		DATE_FORMAT(lpr.LprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NLprTiempoCreacion",
        DATE_FORMAT(lpr.LprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NLprTiempoModificacion",
		
		pro.MonId,
		pro.ProTipoCambio
		
        FROM tbllprlistaprecio lpr
			LEFT JOIN tblproproducto pro
			ON lpr.ProId = pro.ProId
			
        WHERE lpr.LprId = "'.$this->LprId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->LprId = $fila['LprId'];
			$this->SucId = $fila['SucId'];
			
			
			$this->ProId = $fila['ProId'];
			$this->LtiId = $fila['LtiId'];
			$this->UmeId = $fila['UmeId'];
			
			$this->LprCosto = $fila['LprCosto'];
			$this->LprPorcentajeOtroCosto = $fila['LprPorcentajeOtroCosto'];
			$this->LprPorcentajeUtilidad = $fila['LprPorcentajeUtilidad'];
			$this->LprPorcentajeManoObra= $fila['LprPorcentajeManoObra'];
			$this->LprPorcentajeAdicional = $fila['LprPorcentajeAdicional'];
			$this->LprPorcentajeDescuento = $fila['LprPorcentajeDescuento'];
			
			$this->LprOtroCosto = $fila['LprOtroCosto'];
			$this->LprUtilidad = $fila['LprUtilidad'];
			$this->LprManoObra = $fila['LprManoObra'];
			$this->LprAdicional = $fila['LprAdicional'];
			
			$this->LprValorVenta = $fila['LprValorVenta'];
			$this->LprImpuesto = $fila['LprImpuesto'];
			$this->LprDescuento = $fila['LprDescuento'];
			$this->LprPrecio = $fila['LprPrecio'];

			$this->LprTiempoCreacion = $fila['NLprTiempoCreacion'];
			$this->LprTiempoModificacion = $fila['NLprTiempoModificacion']; 
			
			$this->MonId = $fila['MonId']; 
			$this->ProTipoCambio = $fila['ProTipoCambio']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL,$oSucursal=NULL) {

//		if(!empty($oCampo) && !empty($oFiltro)){
//			$oFiltro = str_replace(" ","%",$oFiltro);
//			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
//		}
		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
		
		
		if(!empty($oProducto)){
			$producto = ' AND lpr.ProId = "'.($oProducto).'"';
		}
		
		
		if(!empty($oClienteTipo)){
			$ctipo = ' AND lpr.LtiId = "'.($oClienteTipo).'"';
		}

		if(!empty($oUnidadMedida)){
			$umedida = ' AND lpr.UmeId = "'.($oUnidadMedida).'"';
		}

		if(!empty($oSucursal)){
			$sucursal = ' AND lpr.SucId = "'.($oSucursal).'"';
		}
		
		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				lpr.LprId,
				lpr.SucId,
				
				
				lpr.ProId,
				lpr.LtiId,
				lpr.UmeId,
				
				lpr.LprEquivalente,
				lpr.LprCosto,
				
				lpr.LprPorcentajeOtroCosto,
				lpr.LprPorcentajeUtilidad,
				lpr.LprPorcentajeManoObra,
				
				lpr.LprPorcentajeAdicional,
				lpr.LprPorcentajeDescuento,
				
				lpr.LprOtroCosto,
				lpr.LprUtilidad,
				lpr.LprManoObra,
				
				lpr.LprAdicional,
				
				
				lpr.LprValorVenta,
				lpr.LprImpuesto,
				lpr.LprDescuento,
				lpr.LprPrecio,

				DATE_FORMAT(lpr.LprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NLprTiempoCreacion",
                DATE_FORMAT(lpr.LprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NLprTiempoModificacion",
				
				pro.MonId,
				pro.ProTipoCambio
				
				FROM tbllprlistaprecio lpr
					LEFT JOIN tblproproducto pro
					ON lpr.ProId = pro.ProId
					
				WHERE  1 = 1 '.$filtrar.$producto.$sucursal.$ctipo.$umedida.$orden.$paginacion;

//echo "<br>";	
//echo "<br>";	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsListaPrecio = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ListaPrecio = new $InsListaPrecio();
                    $ListaPrecio->LprId = $fila['LprId'];
					$ListaPrecio->SucId = $fila['SucId'];
					
					
					$ListaPrecio->ProId = $fila['ProId'];
					$ListaPrecio->LtiId = $fila['LtiId'];
					$ListaPrecio->UmeId = $fila['UmeId'];

					$ListaPrecio->LprEquivalente = $fila['LprEquivalente'];	
                    $ListaPrecio->LprCosto = $fila['LprCosto'];	
					
					$ListaPrecio->LprPorcentajeOtroCosto = $fila['LprPorcentajeOtroCosto'];				
                    $ListaPrecio->LprPorcentajeUtilidad = $fila['LprPorcentajeUtilidad'];
					$ListaPrecio->LprPorcentajeManoObra = $fila['LprPorcentajeManoObra'];
					 $ListaPrecio->LprPorcentajeAdicional = $fila['LprPorcentajeAdicional'];
					  $ListaPrecio->LprPorcentajeDescuento = $fila['LprPorcentajeDescuento'];
					
					$ListaPrecio->LprOtroCosto = $fila['LprOtroCosto'];
					$ListaPrecio->LprUtilidad = $fila['LprUtilidad'];
					$ListaPrecio->LprManoObra = $fila['LprManoObra'];
					$ListaPrecio->LprAdicional = $fila['LprAdicional'];
					
					$ListaPrecio->LprValorVenta = $fila['LprValorVenta'];
					$ListaPrecio->LprImpuesto = $fila['LprImpuesto'];
					$ListaPrecio->LprDescuento = $fila['LprDescuento'];
					$ListaPrecio->LprPrecio = $fila['LprPrecio'];

                    $ListaPrecio->LprTiempoCreacion = $fila['NLprTiempoCreacion'];
                    $ListaPrecio->LprTiempoModificacion = $fila['NLprTiempoModificacion'];
					
					//$ListaPrecio->MonId = $fila['MonId'];
					//$ListaPrecio->ProTipoCambio = $fila['ProTipoCambio'];

					$ListaPrecio->InsMysql = NULL;      
					$Respuesta['Datos'][]= $ListaPrecio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarListaPrecio($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' LprId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (LprId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (LprId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tbllprlistaprecio WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarListaPrecio() {
	

		$this->MtdGenerarListaPrecioId();
			
			$sql = 'INSERT INTO tbllprlistaprecio (
				LprId,
				SucId,
				
				ProId,
				LtiId,
				UmeId,
				
				LprCosto,
				
				LprPorcentajeOtroCosto,
				LprPorcentajeUtilidad,
				LprPorcentajeManoObra,
				
				LprPorcentajeAdicional,
				LprPorcentajeDescuento,
				
				LprOtroCosto,
				LprUtilidad,
				LprManoObra,
				
				LprAdicional,
				
				LprValorVenta,
				LprImpuesto,
				LprDescuento,
				LprPrecio,

				LprTiempoCreacion,
				LprTiempoModificacion) 
				VALUES (
				"'.($this->LprId).'", 
				"'.($this->SucId).'", 
				
				"'.($this->ProId).'", 
				"'.($this->LtiId).'", 
				"'.($this->UmeId).'", 
				
				'.($this->LprCosto).',
				
				'.($this->LprPorcentajeOtroCosto).',
				'.($this->LprPorcentajeUtilidad).',
				'.($this->LprPorcentajeManoObra).',
				'.($this->LprPorcentajeAdicional).',
				'.($this->LprPorcentajeDescuento).',
				
				'.($this->LprOtroCosto).',
				'.($this->LprUtilidad).',
				'.($this->LprManoObra).',
				
				'.($this->LprAdicional).',
				
				'.($this->LprValorVenta).',
				'.($this->LprImpuesto).',
				'.($this->LprDescuento).',
				'.($this->LprPrecio).',

				"'.($this->LprTiempoCreacion).'", 
				"'.($this->LprTiempoModificacion).'");';	
				
				//echo $sql;
				
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
	
	public function MtdEditarListaPrecio() {
		
			$sql = 'UPDATE tbllprlistaprecio SET 
				LprCosto = '.($this->LprCosto).',
				
				LprPorcentajeOtroCosto = '.($this->LprPorcentajeOtroCosto).',
				LprPorcentajeUtilidad = '.($this->LprPorcentajeUtilidad).',
				LprPorcentajeManoObra = '.($this->LprPorcentajeManoObra).',
				
				LprPorcentajeAdicional = '.($this->LprPorcentajeAdicional).',
				LprPorcentajeDescuento = '.($this->LprPorcentajeDescuento).',
				
				LprOtroCosto = '.($this->LprOtroCosto).',
				LprUtilidad = '.($this->LprUtilidad).',
				LprManoObra = '.($this->LprManoObra).',
				
				LprAdicional = '.($this->LprAdicional).',
				
				LprValorVenta = '.($this->LprValorVenta).',
				LprImpuesto = '.($this->LprImpuesto).',
				LprDescuento = '.($this->LprDescuento).',
				LprPrecio = '.($this->LprPrecio).',
				
				LprTiempoModificacion = "'.($this->LprTiempoModificacion).'"
				WHERE LprId = "'.($this->LprId).'";';

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