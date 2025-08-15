<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenCompraPedido
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenCompraPedido {

    public $OcpId;
	public $OcoId;
	public $PcoId;
	public $OcpEstado;	
	public $OcpTiempoCreacion;
	public $OcpTiempoModificacion;
    public $OcpEliminado;
	
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


    public function MtdObtenerOrdenCompraPedidos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OcpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenCompra=NULL,$oEstado=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){

			$oFiltro = str_replace(" ","%",$oFiltro);			
			$elementos = explocp(",",$oCampo);

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
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND pco.OcoId = "'.$oOrdenCompra.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND pco.PcoEstado = '.$oEstado.' ';
		}
		
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pco.OcoId,			
			pco.PcoId,
			DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
			pco.PcoTotal,
			
			pco.CliId,
			
			pco.VdiId,
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno

			FROM tblpcopedidocompra pco

				LEFT JOIN tblclicliente cli
				ON pco.CliId = cli.CliId

			WHERE  pco.OcoId IS NOT NULL '.$ocompra.$estado.$pcompra.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenCompraPedido = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenCompraPedido = new $InsOrdenCompraPedido();
                    $OrdenCompraPedido->OcoId = $fila['OcoId'];
                    $OrdenCompraPedido->PcoId = $fila['PcoId'];
					$OrdenCompraPedido->PcoFecha = $fila['NPcoFecha'];
					$OrdenCompraPedido->PcoTotal = $fila['PcoTotal'];

					$OrdenCompraPedido->CliId = $fila['CliId'];
					
					$OrdenCompraPedido->VdiId = $fila['VdiId'];

					$OrdenCompraPedido->CliNombre = $fila['CliNombre'];
					$OrdenCompraPedido->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$OrdenCompraPedido->CliApellidoMaterno = $fila['CliApellidoMaterno'];

                    $OrdenCompraPedido->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenCompraPedido;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
}
?>