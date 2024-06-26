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
    public function cargar($id,$NroD,$Nom,$Ape,$ptelefono,$pasaporte=null,$idviaje=null){
        parent::cargar($id,$NroD,$Nom,$Ape,$ptelefono);
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
    public function Buscar($id){ // Buscar por id 
		$base=new BaseDatos();
		$consulta="Select * from pasajero where id=".$id;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($id);
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
					$obj->Buscar($row2['id']);
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
			$consultaInsertar = "INSERT INTO pasajero (id, pasaporte, idviaje)
                             VALUES (".$this->getId().", '".$this->getPasaporte()."', ".$this->getIdviaje().")";
								 
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
		$consulta = "SELECT * FROM pasajero WHERE id=".$this->getId();
		$found = false;
		if ($base->iniciar()) {
			if ($base->Ejecutar($consulta)) {
				$row2 = $base->Registro();
				if ($row2['id'] == $this->getId()) {
					$found = true;
				}
			}
		}
		if ($found) {
			if(parent::modificar()){
				// buscar pasajero
				$consultaModifica="UPDATE pasajero SET idviaje='".$this->getIdviaje()."', pasaporte='".$this->getPasaporte()."' WHERE id=". $this->getId();
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
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		$consulta = "SELECT * FROM pasajero WHERE id=".$this->getId();
		$found = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consulta)) {
				$row2 = $base->Registro();
				if ($row2['id'] == $this->getId()) {
					$found = true;
				}
			}
		}
		if ($found) {
			if($base->Iniciar()){
				// buscar y despues eliminar
					$consultaBorra="DELETE FROM pasajero WHERE id=".$this->getId();
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
		}

		return $resp; 
	}
    public function __toString(){
        return parent::__toString() . 
        "Pasaporte: " . $this->getPasaporte(). "\n".
		"IdViaje: ".    $this->getIdviaje() .  "\n";
	}

}