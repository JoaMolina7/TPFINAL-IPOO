<?php 
include_once "BaseDatos.php";
class Pasajero extends Persona{
    private $pasaporte;
    private $idviaje;
    public function __construct() {
        parent::__construct();
        $this->pasaporte = "";
        $this->idviaje = "";
    }
    public function cargar($NroD,$Nom,$Ape,$ptelefono,$pasaporte=null,$idviaje=null){
        parent::cargar($NroD,$Nom,$Ape,$ptelefono);
        $this->setPasaporte($pasaporte);
		$this->setIdviaje($idviaje);
    }
    //getters
    public function getPasaporte() {
        return $this->pasaporte;
    }
    public function getIdviaje() {
        return $this->idviaje;
    }
    //setters   
    public function setPasaporte($pasaporte) {
        $this->pasaporte = $pasaporte;
    }
    public function setIdviaje($idviaje) {
        $this->idviaje = $idviaje;
    }
    
    /**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base=new BaseDatos();
		$consulta="Select * from pasajero where nrodoc=".$dni;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($dni);
                    $this->setIdviaje($row2['idviaje']);
                    $this->setPasaporte($row2['pasaporte']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
   
	public function listar($condicion = "") {
		$arreglo = null;
		$base = new BaseDatos();
		$consulta = "SELECT * FROM pasajero";
		
		if ($condicion != "") {
			$consulta .= " WHERE " . $condicion;
		}
		
		$consulta .= " ORDER BY pasaporte";
		
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consulta)) {
				$arreglo = array();
				while ($row2 = $base->Registro()) {
					$obj = new Pasajero();
					$obj->Buscar($row2['nrodoc']);
					array_push($arreglo, $obj);
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		
		return $arreglo;
	}
		
    
	public function insertar() {
		$base = new BaseDatos();
		$resp = false;
	
		if ($base->iniciar()) {
			$consultaInsertar = "INSERT INTO pasajero (nrodoc, pasaporte, idviaje)
                             VALUES (".$this->getNrodoc().", '".$this->getPasaporte()."', ".$this->getIdviaje().")";
								 
			if ($base->Iniciar()) {
				if ($base->Ejecutar($consultaInsertar)) {
					$resp = true;
				} else {
					$this->setmensajeoperacion($base->getError());
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		}
		return $resp;
	}
	
	
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
	    if(parent::modificar()){
	        $consultaModifica="UPDATE pasajero SET idviaje='".$this->getIdviaje()."', pasaporte='".$this->getPasaporte()."' WHERE nrodoc=". $this->getNrodoc();
	        if($base->Iniciar()){
	            if($base->Ejecutar($consultaModifica)){
	                $resp=  true;
	            }else{
	                $this->setmensajeoperacion($base->getError());
	                
	            }
	        }else{
	            $this->setmensajeoperacion($base->getError());
	            
	        }
	    }
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM pasajero WHERE nrodoc=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    if(parent::eliminar()){
				        $resp=  true;
				    }
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
    public function __toString(){
        return parent::__toString() . 
        "Pasaporte: " . $this->getPasaporte(). "\n".
		"IdViaje: ".    $this->getIdviaje() .  "\n";
	}

}