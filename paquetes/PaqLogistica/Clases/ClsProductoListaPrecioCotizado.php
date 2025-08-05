<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoListaPrecioCotizado
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoListaPrecioCotizado {

	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


    public function MtdObtenerProductoListaPrecioCotizado($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoId=NULL) {

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
		
	
		if(!empty($oProducto)){
			$producto = ' AND (ood.ProId = "'.$oProducto.'") ';
		}

		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ood.OodId,			
			ood.OotId,
			ood.ProId,
			ood.UmeId,
		
			ood.OodAno,
			ood.OodModelo,
			ood.OodPrecio,
			
			ood.OodEstado,
			DATE_FORMAT(ood.OodTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOodTiempoCreacion",
	        DATE_FORMAT(ood.OodTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOodTiempoModificacion",
			
			DATE_FORMAT(oot.OotFecha, "%d/%m/%Y") AS "NOotFecha",
			prv.PrvNombreCompleto,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno,

			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			ume.UmeNombre,

			pro.UmeId AS "UmeIdOrigen",

			oot.OotTipoCambio,
			oot.MonId,
			
			mon.MonNombre,
			mon.MonSimbolo
			
			FROM tbloodordencotizaciondetalle ood
			
				LEFT JOIN tblootordencotizacion oot
				ON ood.OotId = oot.OotId
				
					LEFT JOIN tblprvproveedor prv
					ON oot.PrvId = prv.PrvId
					
					LEFT JOIN tblproproducto pro
					ON ood.ProId = pro.ProId
					
						LEFT JOIN tblumeunidadmedida ume
						ON ood.UmeId = ume.UmeId
						
							LEFT JOIN tblmonmoneda mon
							ON oot.MonId = mon.MonId

			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$recibida.$producto.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoListaPrecioCotizado = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ProductoListaPrecioCotizado = new $InsProductoListaPrecioCotizado();
                    $ProductoListaPrecioCotizado->OodId = $fila['OodId'];
                    $ProductoListaPrecioCotizado->OotId = $fila['OotId'];
					$ProductoListaPrecioCotizado->ProId = $fila['ProId'];
					
					$ProductoListaPrecioCotizado->UmeId = $fila['UmeId'];
			
					$ProductoListaPrecioCotizado->OodAno = $fila['OodAno'];  
					$ProductoListaPrecioCotizado->OodModelo = $fila['OodModelo'];
					$ProductoListaPrecioCotizado->OodPrecio = $fila['OodPrecio'];
		
					$ProductoListaPrecioCotizado->OodEstado = $fila['OodEstado'];
														
					$ProductoListaPrecioCotizado->OodTiempoCreacion = $fila['NOodTiempoCreacion'];  
					$ProductoListaPrecioCotizado->OodTiempoModificacion = $fila['NOodTiempoModificacion']; 	
					
					$ProductoListaPrecioCotizado->OotFecha = $fila['NOotFecha']; 
						
					$ProductoListaPrecioCotizado->PrvNombreCompleto = $fila['PrvNombreCompleto']; 	
					
					$ProductoListaPrecioCotizado->PrvNombre = $fila['PrvNombre']; 	
					$ProductoListaPrecioCotizado->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 	
					$ProductoListaPrecioCotizado->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 	
					
							
					$ProductoListaPrecioCotizado->ProId = $fila['ProId'];	
                    $ProductoListaPrecioCotizado->ProNombre = (($fila['ProNombre']));
					$ProductoListaPrecioCotizado->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$ProductoListaPrecioCotizado->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$ProductoListaPrecioCotizado->RtiId = (($fila['RtiId']));
					
					$ProductoListaPrecioCotizado->UmeNombre = (($fila['UmeNombre']));
					
					$ProductoListaPrecioCotizado->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$ProductoListaPrecioCotizado->OotTipoCambio = $fila['OotTipoCambio'];
					$ProductoListaPrecioCotizado->MonId = $fila['MonId'];
					
					$ProductoListaPrecioCotizado->MonNombre = $fila['MonNombre'];
					$ProductoListaPrecioCotizado->MonSimbolo = $fila['MonSimbolo'];
			
				     $ProductoListaPrecioCotizado->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ProductoListaPrecioCotizado;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
}
?>