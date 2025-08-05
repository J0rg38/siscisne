<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPersonal
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPersonal {

    public $PerId;
	public $UsuId;
	public $TdoId;
	public $PtiId;
    public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	public $PerFechaNacimiento;
	public $PerEdad;
	public $PerFechaCumpleano;
	public $PerSexo;
	public $PerEstadoCivil;
	public $PerCantidadHijo;
	
	public $PerNumeroDocumento;
	public $PerEmail;
	public $PerTelefono;
	public $PerCelular;
	public $PerPais;
	public $PerCiudad;
	public $PerDireccion;
	public $PerDepartamento;
	public $PerProvincia;
	public $PerDistrito;
	
	public $PerTaller;
	public $PerRecepcion;
	public $PerVenta;
	
	public $PerFoto;
	public $PerFirma;
	public $PerEstado;	
    public $PerTiempoCreacion;
    public $PerTiempoModificacion;
    public $PerEliminado;
    
	public $PtiNombre;
	
	public $TdoNombre;
	
	public $UsuUsuario;
	
	public $InsMysql;

	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarPersonalId() {
	
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PerId,5),unsigned)) AS "MAXIMO"
		FROM tblperpersonal';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->PerId = "PER-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->PerId = "PER-".$fila['MAXIMO'];					
		}
			
	}
		
    public function MtdObtenerPersonal(){

        $sql = 'SELECT 
        per.PerId,
		per.SucId,
		
		per.AreId,
		
		per.UsuId,
		per.TdoId,
		per.PtiId,
		
		per.PerAbreviatura,
		CONCAT(IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoPaterno,"")," ",IFNULL(per.PerApellidoMaterno,"")) AS PerNombreCompleto,
        per.PerNombre,		
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		
		DATE_FORMAT(per.PerFechaNacimiento, "%d/%m/%Y") AS "NPerFechaNacimiento",
		CASE
	    WHEN(MONTH(per.PerFechaNacimiento) < MONTH(NOW())) THEN YEAR(NOW()) - YEAR(per.PerFechaNacimiento)
    	WHEN (MONTH(per.PerFechaNacimiento) = MONTH(NOW())) AND (DAY(per.PerFechaNacimiento) <= DAY(NOW())) THEN YEAR(NOW()) - 		
		YEAR(per.PerFechaNacimiento)
	    ELSE (YEAR(NOW()) - YEAR(per.PerFechaNacimiento)) - 1
		END AS PerEdad,
		DATE_FORMAT(CONCAT(YEAR(NOW()),"-",MONTH(per.PerFechaNacimiento),"-",DAY(per.PerFechaNacimiento)), "%d/%m/%Y") AS "PerFechaCumpleano",	
		per.PerSexo,
		per.PerEstadoCivil,
		per.PerCantidadHijo,
		
		per.PerNumeroDocumento,
		per.PerEmail,
		per.PerTelefono,
		per.PerCelular,
		per.PerPais,
		per.PerCiudad,
		per.PerDireccion,
		per.PerDepartamento,
		per.PerProvincia,
		per.PerDistrito,
		
		
		per.PerTaller,
		per.PerRecepcion,
		per.PerVenta,
		per.PerAlmacen,
		per.PerFirmante,
		
		per.PerFoto,	
		per.PerFirma,	
		per.PerEstado,		
		DATE_FORMAT(per.PerTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPerTiempoCreacion",
        DATE_FORMAT(per.PerTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPerTiempoModificacion",
		tdo.TdoNombre,
		
		pti.PtiNombre
		
        FROM tblperpersonal per
			LEFT JOIN tbltdotipodocumento tdo
			ON per.TdoId = tdo.TdoId
				LEFT JOIN tblptipersonaltipo pti
				ON per.PtiId = pti.PtiId
				
        WHERE PerId = "'.$this->PerId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			
			$this->PerId = $fila['PerId'];
			$this->SucId = $fila['SucId'];
			
			$this->AreId = $fila['AreId'];
			
			$this->UsuId = $fila['UsuId'];
			$this->TdoId = $fila['TdoId'];		
			$this->PtiId = $fila['PtiId'];		
			
			$this->PerNombreCompleto = $fila['PerNombreCompleto'];
			$this->PerAbreviatura = $fila['PerAbreviatura'];
            $this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerFechaNacimiento = $fila['NPerFechaNacimiento'];
			$this->PerEdad = $fila['PerEdad'];
			$this->PerFechaCumpleano = $fila['PerFechaCumpleano'];
			$this->PerSexo = $fila['PerSexo'];
			$this->PerEstadoCivil = $fila['PerEstadoCivil'];
			$this->PerCantidadHijo = $fila['PerCantidadHijo'];
			$this->PerNumeroDocumento = $fila['PerNumeroDocumento'];				
			$this->PerEmail = $fila['PerEmail'];
			$this->PerTelefono = $fila['PerTelefono'];
			$this->PerCelular = $fila['PerCelular'];
			$this->PerPais = $fila['PerPais'];
			$this->PerCiudad = $fila['PerCiudad'];
			$this->PerDireccion = $fila['PerDireccion'];
			$this->PerDepartamento = $fila['PerDepartamento'];
			$this->PerProvincia = $fila['PerProvincia'];
			$this->PerDistrito = $fila['PerDistrito'];
			
			$this->PerTaller = $fila['PerTaller'];
			$this->PerRecepcion = $fila['PerRecepcion'];
			$this->PerVenta = $fila['PerVenta'];
			$this->PerAlmacen = $fila['PerAlmacen'];
			$this->PerFirmante = $fila['PerFirmante'];
			
			$this->PerFoto = $fila['PerFoto'];
			$this->PerFirma = $fila['PerFirma'];
			$this->PerEstado = $fila['PerEstado'];
			$this->PerTiempoCreacion = $fila['NPerTiempoCreacion'];
			$this->PerTiempoModificacion = $fila['NPerTiempoModificacion']; 
			
			$this->TdoNombre = $fila['TdoNombre']; 
			
			$this->PtiNombre = $fila['PtiNombre']; 
			
			
		
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

	
    public function MtdVerificarPersonalExiste($oCampo,$oDato) {
		
		$PersonalId = "";
		$ResPersonales = $this->MtdObtenerPersonales($oCampo,"esigual",$oDato,'PerId','ASC','1',NULL,NULL,NULL,NULL,NULL,NULL);
		$ArrPersonales = $ResPersonales['Datos'];
		
		if(!empty($ArrPersonales)){
			foreach($ArrPersonales as $DatPersonal){
				$PersonalId = $DatPersonal->PerId;
			}
		}
		
		return $PersonalId;
//    public function MtdObtenerPersonales($oCampo=NULL,$oCondicion,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL) {
		
			
	}
	
	
    public function MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false) {

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

		if(!empty($oPersonalTipo)){
			$ptipo = ' AND per.PtiId = "'.$oPersonalTipo.'"';
		}		
		
		if(!empty($oEstado)){
			$estado = ' AND per.PerEstado = '.$oEstado;
		}		
				
		if(!empty($oFechaNacimientoRango)){
		
			$NFecha = explode("#",$oFechaNacimientoRango);
						
			if (count($NFecha)>1){
				$nacimiento = ' AND PerFechaNacimiento BETWEEN "'.$NFecha[0].'" AND "'.$NFecha[1].'"' ;				
			}else{

		
				$nacimiento = ' AND WEEK(CONCAT(YEAR(NOW()),"-",MONTH(per.PerFechaNacimiento),"-",DAY(per.PerFechaNacimiento)),3) = WEEK("'.$oFechaNacimientoRango.'",3)';
			}
						
		}
	
		if(!empty($oTaller)){
			$taller = ' AND per.PerTaller = '.$oTaller;
		}	
		
		if(!empty($oRecepcion)){
			$recepcion = ' AND per.PerRecepcion = '.$oRecepcion;
		}	
		
		if(!empty($oVenta)){
			$venta = ' AND per.PerVenta = '.$oVenta;
		}	
		
		if(!empty($oArea)){
			$area = ' AND per.AreId = "'.$oArea.'"';
		}	
		
		if($oMultisucursal){
			
			if(!empty($oSucursal)){
				
				$sucursal = ' AND (per.SucId = "'.$oSucursal.'" OR per.SucId IS NULL)';
				
			}	
			
		}else{
				
			if(!empty($oSucursal)){
				
				$sucursal = ' AND per.SucId = "'.$oSucursal.'"';
				
			}	
			
		}
		
		
		if(!empty($oAlmacen)){
			$almacen = ' AND per.PerAlmacen = '.$oAlmacen;
		}	
		
		
		if(!empty($oFirmante)){
			$firmante = ' AND per.PerFirmante = '.$oFirmante;
		}
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				per.PerId,
				per.SucId,
					
				per.AreId,	
					
				per.UsuId,
				per.TdoId,
				per.PtiId,
				
				CONCAT(IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoPaterno,"")," ",IFNULL(per.PerApellidoMaterno,"")) AS PerNombreCompleto,
				
				per.PerAbreviatura,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				DATE_FORMAT(per.PerFechaNacimiento, "%d/%m/%Y") AS "NPerFechaNacimiento",
				CASE
			    WHEN(MONTH(per.PerFechaNacimiento) < MONTH(NOW())) THEN YEAR(NOW()) - YEAR(per.PerFechaNacimiento)
		    	WHEN (MONTH(per.PerFechaNacimiento) = MONTH(NOW())) AND (DAY(per.PerFechaNacimiento) <= DAY(NOW())) THEN YEAR(NOW()) - 		
				YEAR(per.PerFechaNacimiento)
			    ELSE (YEAR(NOW()) - YEAR(per.PerFechaNacimiento)) - 1
				END AS PerEdad,
		DATE_FORMAT(CONCAT(YEAR(NOW()),"-",MONTH(per.PerFechaNacimiento),"-",DAY(per.PerFechaNacimiento)), "%d/%m/%Y") AS "PerFechaCumpleano",
				per.PerSexo,
				per.PerEstadoCivil,
				per.PerCantidadHijo,
				per.PerNumeroDocumento,
				per.PerEmail,
				per.PerTelefono,
				per.PerCelular,
				per.PerPais,
				per.PerCiudad,
				per.PerDireccion,
				per.PerDepartamento,
				per.PerProvincia,
				per.PerDistrito,
				
				per.PerTaller,	
				per.PerRecepcion,
				per.PerVenta,
per.PerFirmante,
				per.PerAlmacen,
				
				per.PerFoto,	
				per.PerFirma,
				per.PerEstado,
				DATE_FORMAT(per.PerTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPerTiempoCreacion",
                DATE_FORMAT(per.PerTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPerTiempoModificacion",
				
				tdo.TdoNombre,
				
				pti.PtiNombre,
				
				usu.UsuUsuario,
				
				are.AreNombre,
				
				suc.SucNombre
				
				FROM tblperpersonal per
					LEFT JOIN tbltdotipodocumento tdo
					ON per.TdoId = tdo.TdoId
						LEFT JOIN tblptipersonaltipo pti
						ON per.PtiId = pti.PtiId
							LEFT JOIN tblusuusuario usu
							ON per.UsuId = usu.UsuId
								LEFT JOIN tblarearea are
								ON per.AreId = are.AreId
									LEFT JOIN tblsucsucursal suc
									ON per.SucId = suc.SucId
									
				WHERE 1 = 1 '.$filtrar.$sucursal.$ptipo.$firmante.$estado.$almacen.$area.$nacimiento.$taller.$recepcion.$venta.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPersonal = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Personal = new $InsPersonal();				
					
                    $Personal->PerId = $fila['PerId'];
					$Personal->SucId = $fila['SucId'];
					
					$Personal->UsuId = $fila['UsuId'];
					$Personal->TdoId = $fila['TdoId'];
					$Personal->PtiId = $fila['PtiId'];
					
					$Personal->PerNombreCompleto= $fila['PerNombreCompleto'];
					$Personal->PerAbreviatura= $fila['PerAbreviatura'];
                    $Personal->PerNombre= $fila['PerNombre'];
					$Personal->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$Personal->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$Personal->PerFechaNacimiento = $fila['NPerFechaNacimiento'];
					$Personal->PerEdad = $fila['PerEdad'];		
					$Personal->PerFechaCumpleano = $fila['PerFechaCumpleano'];				
					$Personal->PerSexo = $fila['PerSexo'];				
					$Personal->PerEstadoCivil = $fila['PerEstadoCivil'];				
					$Personal->PerCantidadHijo = $fila['PerCantidadHijo'];									
					$Personal->PerNumeroDocumento = $fila['PerNumeroDocumento'];					
					$Personal->PerEmail = $fila['PerEmail'];
					$Personal->PerTelefono = $fila['PerTelefono'];
					$Personal->PerCelular = $fila['PerCelular'];
					$Personal->PerPais = $fila['PerPais'];
					$Personal->PerCiudad = $fila['PerCiudad'];
					$Personal->PerDireccion = $fila['PerDireccion'];
					$Personal->PerDepartamento = $fila['PerDepartamento'];
					$Personal->PerProvincia = $fila['PerProvincia'];
					$Personal->PerDistrito = $fila['PerDistrito'];
					
					$Personal->PerTaller = $fila['PerTaller'];
					$Personal->PerRecepcion = $fila['PerRecepcion'];
					$Personal->PerVenta = $fila['PerVenta'];
					$Personal->PerAlmacen = $fila['PerAlmacen'];
					$Personal->PerFirmante = $fila['PerFirmante'];
					
					
					$Personal->PerFoto = $fila['PerFoto'];
					$Personal->PerFirma = $fila['PerFirma'];
					$Personal->PerEstado = $fila['PerEstado'];					
                    $Personal->PerTiempoCreacion = $fila['NPerTiempoCreacion'];
                    $Personal->PerTiempoModificacion = $fila['NPerTiempoModificacion'];    					
				
					$Personal->TdoNombre =  $fila['TdoNombre']; 
					
					$Personal->PtiNombre =  $fila['PtiNombre']; 
				
					$Personal->UsuUsuario =  $fila['UsuUsuario']; 
					
					$Personal->AreNombre =  $fila['AreNombre']; 
					$Personal->SucNombre =  $fila['SucNombre']; 
					                
                    $Personal->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Personal;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
	
	//Accion eliminar	 
	
	public function MtdEliminarPersonal($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' PerId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PerId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PerId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
		
			$sql = 'DELETE FROM  tblperpersonal WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarPersonal() {
	
			$this->MtdGenerarPersonalId();

			
			$sql = 'INSERT INTO tblperpersonal (
			PerId,
			SucId,
			
			AreId,
			
			UsuId,
			TdoId,
			PtiId,
			
			PerAbreviatura,
			PerNombre, 
			PerApellidoPaterno,
			PerApellidoMaterno,
			PerFechaNacimiento,
			PerSexo,
			PerEstadoCivil,
			PerCantidadHijo,
			PerNumeroDocumento,
			PerEmail,
			PerTelefono,
			PerCelular,
			PerPais,
			PerCiudad,
			PerDireccion,
			PerDepartamento,
			PerProvincia,
			PerDistrito,
			PerTaller,
			PerRecepcion,
			PerVenta,
			PerAlmacen,
			PerFirmante,
			
			PerFoto,
			PerFirma,
			PerEstado,
			PerTiempoCreacion,
			PerTiempoModificacion
			) 
			VALUES (
			"'.($this->PerId).'",	
			'.(empty($this->SucId)?'NULL, ':'"'.$this->SucId.'",').'
			
			'.(empty($this->AreId)?'NULL, ':'"'.$this->AreId.'",').'
			
			'.(empty($this->UsuId)?'NULL, ':'"'.$this->UsuId.'",').'
			"'.($this->TdoId).'", 
			"'.($this->PtiId).'", 
			
			"'.($this->PerAbreviatura).'", 
			"'.($this->PerNombre).'", 
			"'.($this->PerApellidoPaterno).'", 
			"'.($this->PerApellidoMaterno).'", 
			'.(empty($this->PerFechaNacimiento)?'NULL, ':'"'.$this->PerFechaNacimiento.'",').'
			"'.($this->PerSexo).'", 	
			"'.($this->PerEstadoCivil).'", 	
			'.($this->PerCantidadHijo).', 	
			"'.($this->PerNumeroDocumento).'", 									
			"'.($this->PerEmail).'", 
			"'.($this->PerTelefono).'", 
			"'.($this->PerCelular).'", 
			"'.($this->PerPais).'", 
			"'.($this->PerCiudad).'", 
			"'.($this->PerDireccion).'", 
			"'.($this->PerDepartamento).'", 
			"'.($this->PerProvincia).'", 
			"'.($this->PerDistrito).'", 
			'.($this->PerTaller).', 
			'.($this->PerRecepcion).', 
			'.($this->PerVenta).', 
			'.($this->PerAlmacen).', 
			'.($this->PerFirmante).', 
			
			"'.($this->PerFoto).'",
			"'.($this->PerFirma).'",
			'.($this->PerEstado).', 
			"'.($this->PerTiempoCreacion).'", 
			"'.($this->PerTiempoModificacion).'");';					

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
	
	public function MtdEditarPersonal() {
		
				
			$sql = 'UPDATE tblperpersonal SET 
			'.(empty($this->SucId)?'SucId = NULL, ':'SucId = "'.$this->SucId.'",').'	
			'.(empty($this->UsuId)?'UsuId = NULL, ':'UsuId = "'.$this->UsuId.'",').'	
			'.(empty($this->AreId)?'AreId = NULL, ':'AreId = "'.$this->AreId.'",').'	
			
			 TdoId = "'.($this->TdoId).'",
			 PtiId = "'.($this->PtiId).'",
			 
			  PerAbreviatura = "'.($this->PerAbreviatura).'",
			 PerNombre = "'.($this->PerNombre).'",
			 PerApellidoPaterno = "'.($this->PerApellidoPaterno).'",
			 PerApellidoMaterno = "'.($this->PerApellidoMaterno).'",
			'.(empty($this->PerFechaNacimiento)?'PerFechaNacimiento = NULL, ':'PerFechaNacimiento = "'.$this->PerFechaNacimiento.'",').'		
			 PerSexo = "'.($this->PerSexo).'",
			 PerEstadoCivil = "'.($this->PerEstadoCivil).'",
			 PerCantidadHijo = '.($this->PerCantidadHijo).',
			 PerNumeroDocumento = "'.($this->PerNumeroDocumento).'",
			 PerEmail = "'.($this->PerEmail).'",
			 PerTelefono = "'.($this->PerTelefono).'",
			 PerCelular = "'.($this->PerCelular).'",
			 PerPais = "'.($this->PerPais).'",
			 PerCiudad = "'.($this->PerCiudad).'",
			 PerDireccion = "'.($this->PerDireccion).'",
			 PerDepartamento = "'.($this->PerDepartamento).'",
			 PerProvincia = "'.($this->PerProvincia).'",
			 PerDistrito = "'.($this->PerDistrito).'",			 			 
			 PerTaller = '.($this->PerTaller).',
			 PerRecepcion = '.($this->PerRecepcion).',
			 PerVenta = '.($this->PerVenta).',
			  PerAlmacen = '.($this->PerAlmacen).',
			   PerFirmante = '.($this->PerFirmante).',

			 PerFoto = "'.($this->PerFoto).'",
			 PerFirma = "'.($this->PerFirma).'",
			 PerEstado = "'.($this->PerEstado).'",
			 PerTiempoModificacion = "'.($this->PerTiempoModificacion).'"
			 WHERE PerId = "'.($this->PerId).'";';
			
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