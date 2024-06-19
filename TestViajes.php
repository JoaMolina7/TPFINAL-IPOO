<?php 

// Test Principal Programa Viajes 
include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Empresa.php';
include_once 'Viaje.php';


// Implementamos menu principal y sus variaciones.
function mostrarMenuPrincipal() {
    echo "1) Gestionar Viajes \n";
    echo "2) Gestionar Empresas \n";
    echo "3) Gestionar Pasajeros \n";
    echo "4) Gestionar Responsables \n";
    echo "5) Gestionar Personas \n";
    echo "6) Salir \n";
}
function mostrarMenuViajes() {
    echo "1) Ver Lista de Viajes \n";
    echo "2) Agregar Viaje \n";
    echo "3) Modificar Viaje \n";
    echo "4) Eliminar Viaje \n";
    echo "5) Volver al Menu Principal \n";
}
function mostrarMenuEmpresas() {
    echo "1) Ver Lista de Empresas \n";
    echo "2) Agregar Empresa \n";
    echo "3) Modificar Empresa \n";
    echo "4) Eliminar Empresa \n";
    echo "5) Volver al Menu Principal \n";
}
function mostrarMenuPasajeros() {
    echo "1) Ver Lista de Pasajeros \n";
    echo "2) Agregar Pasajero \n";
    echo "3) Modificar Pasajero \n";
    echo "4) Eliminar Pasajero \n";
    echo "5) Volver al Menu Principal \n";
}
function mostrarMenuResponsables() {
    echo "1) Ver Lista de Responsables \n";
    echo "2) Agregar Responsable \n";
    echo "3) Modificar Responsable \n";
    echo "4) Eliminar Responsable \n";
    echo "5) Volver al Menu Principal \n";
}
function mostrarMenuPersonas() {
    echo "1) Ver Lista de Personas \n";
    echo "2) Agregar Persona \n";
    echo "3) Modificar Persona \n";
    echo "4) Eliminar Persona \n";
    echo "5) Volver al Menu Principal \n";
}

// funciones agregadas
function imprimirEnVerde($texto) {
    echo "\033[0;32m" . $texto . "\033[0m";
}
function imprimirEnRojo($texto) {
    echo "\033[0;31m" . $texto . "\033[0m";
}
function mostrarMenuModificacionPersona() {
    echo "1) Modificar Nombre \n";
    echo "2) Modificar Apellido \n";
    echo "3) Modificar Telefono \n";
}
function mostrarMenuModificacionEmpresa() {
    echo "1) Modificar Nombre \n";
    echo "2) Modificar Dirección \n";
}
function mostrarMenuModificacionViaje() {
    echo "1) Modificar Destino \n";
    echo "2) Modificar Importe \n";
    echo "3) Modificar Cantidad Máxima de Pasajeros \n";
}

// Implementacion de funciones para gestionar las opciones del menu

function gestionarViajes() {
    mostrarMenuViajes();
    echo "Opción: ";
    $opcionUserViaje = trim(fgets(STDIN));
    $viaje = new Viaje(); 
    $pasajero = new Pasajero();
    if ($opcionUserViaje == 5) {
        App();
    } else {
        // manejamos las opciones del menu de viajes
        switch($opcionUserViaje) {
            case 1:
                // Ver Lista de Viajes
                $listaViajes = $viaje->listar(); // obtenemos la lista de viajes
                if ($listaViajes) {
                    echo "Viajes encontrados: \n";
                    foreach ($listaViajes as $viaje) {
                        $idViaje = $viaje->getIdViaje();
                        $colObjPasajerosBd = $pasajero->listar("idviaje = $idViaje");
                        foreach ($colObjPasajerosBd as $pasajeroBd) {
                            $viaje->agregarPasajero($pasajeroBd);
                        }
                        echo "--------------------------------";
                        imprimirEnVerde($viaje);
                    }
                } else {
                    imprimirEnRojo("No se encontraron viajes.\n");
                }
                break;
            case 2:
                // Agregar Viaje
                echo "Ingrese un destino: ";
                $destino = trim(fgets(STDIN));
                echo "Ingrese la cantidad máxima de pasajeros: ";
                $cantMaxPasajeros = trim(fgets(STDIN));
                $empresa = new Empresa();
                $listaEmpresas = $empresa->listar();
                if ($listaEmpresas) {
                    echo "Empresas encontradas: \n";
                    foreach ($listaEmpresas as $empresa) {
                        echo "/" . $empresa->getIdEmpresa() . "/";
                    }
                    echo "\n";
                } 
                echo "Ingrese el ID de la empresa: "; // presentamos una lista de empresas para mejor entendimiento
                $idEmpresa = trim(fgets(STDIN));
                if ($empresa->buscar($idEmpresa)) {
                    echo "Ingrese el documento del responsable: "; // lo hacemos por documento dado que buscar() es por DNI
                    $dniEmpleado = trim(fgets(STDIN));
                    $responsable = new ResponsableV();
                    if ($responsable->buscar($dniEmpleado)) {
                        $numeroEmpleado = $responsable->getRnumeroempleado();
                        echo "Ingrese el importe: ";
                        $importe = trim(fgets(STDIN));
                        $viaje->cargar(0, $destino, $cantMaxPasajeros, $idEmpresa, $numeroEmpleado, $importe); 
                        $insert = $viaje->insertar();
                        if ($insert) {
                            imprimirEnVerde("Viaje agregado exitosamente \n");
                        } else {
                            imprimirEnRojo("Error al agregar el viaje \n");
                        }
                    } else {
                        imprimirEnRojo("Responsable no encontrado \n");
                    }
                } else {
                    imprimirEnRojo("Empresa no encontrada \n");
                }
                break;
            case 3:
                // Modificar Viaje (destino e importe)
                echo "Ingrese el ID del viaje a modificar: ";
                $idViaje = trim(fgets(STDIN));
                $found = $viaje->Buscar($idViaje);
                if ($found) {
                    echo "Que desea modificar? \n";
                    mostrarMenuModificacionViaje();
                    echo "Opción: ";
                    $opcionModificacionViaje = trim(fgets(STDIN));
                    switch($opcionModificacionViaje) {
                        case 1:
                            echo "Ingrese el nuevo destino: ";
                            $nuevoDestino = trim(fgets(STDIN));
                            $viaje->setVdestino($nuevoDestino);
                            $viaje->modificar();
                            imprimirEnVerde("Destino modificado exitosamente \n");
                            break;
                        case 2:
                            echo "Ingrese el nuevo importe: ";
                            $nuevoImporte = trim(fgets(STDIN));
                            $viaje->setVimporte($nuevoImporte);
                            $viaje->modificar();
                            imprimirEnVerde("Importe modificado exitosamente \n");
                            break;
                        case 3:
                            echo "Ingrese la nueva cantidad máxima de pasajeros: ";
                            $nuevaCantMaxPasajeros = trim(fgets(STDIN));
                            $viaje->setVcantmaxpasajeros($nuevaCantMaxPasajeros);
                            $viaje->modificar();
                            imprimirEnVerde("Cantidad máxima de pasajeros modificada exitosamente \n");
                            break;
                        default:
                            imprimirEnRojo("Opción no válida, por favor seleccione una opción válida \n");
                            break;
                    }
                } else {
                    imprimirEnRojo("El viaje no se encuentra registrado \n");
                }
                break;
            case 4:
                // Eliminar Viaje
                echo "Ingrese el ID del viaje a eliminar: ";
                $idViaje = trim(fgets(STDIN));
                $found = $viaje->Buscar($idViaje);
                if ($found) {
                    $viaje->eliminar();
                    imprimirEnVerde("Viaje eliminado exitosamente \n");
                } else {
                    imprimirEnRojo("El viaje no se encuentra registrado \n");
                }
                break;
            default:
                echo "Opción no válida, por favor seleccione una opción válida \n";
                break;
        }

        gestionarViajes(); // Volver al menú de viajes después de manejar una opción
    }
}
function gestionarEmpresas() {
    mostrarMenuEmpresas();
    echo "Opción: ";
    $opcionUserEmpresa = trim(fgets(STDIN));
    $empresa = new Empresa();
    if ($opcionUserEmpresa == 5) {
        App();
    } else {
        switch($opcionUserEmpresa) {
            case 1: 
                // Ver Lista de Empresas
                $empresa = new Empresa();
                $listaEmpresas = $empresa->listar();
                if ($listaEmpresas) {
                    echo "Empresas encontradas: \n";
                    foreach ($listaEmpresas as $empresa) {
                        echo "--------------------------------\n";
                        imprimirEnVerde($empresa);
                    }
                } else {
                    imprimirEnRojo("No se encontraron empresas.\n");
                }
                break;
            case 2: 
                // Agregar Empresa 
                echo "Ingrese el nombre de la empresa: ";
                $nombreEmpresa = trim(fgets(STDIN));
                echo "Ingrese la dirección de la empresa: ";
                $direccionEmpresa = trim(fgets(STDIN));
                $empresa->setENombre($nombreEmpresa);
                $empresa->setEdireccion($direccionEmpresa);
                $empresa->setIdEmpresa(0);
                $insert = $empresa->insertar();
                if ($insert) {
                    imprimirEnVerde("Empresa agregada exitosamente \n");
                } else {
                    imprimirEnRojo("Error al agregar la empresa \n");
                }
                break;
            case 3: 
                // Modificar Empresa 
                echo "Ingrese el ID de la empresa a modificar: ";
                $idEmpresa = trim(fgets(STDIN));
                $found = $empresa->Buscar($idEmpresa);
                if ($found) {
                    echo "Que desea modificar? \n";
                    mostrarMenuModificacionEmpresa();
                    echo "Opción: ";
                    $opcionModificacionEmpresa = trim(fgets(STDIN));
                    switch($opcionModificacionEmpresa) {
                        case 1:
                            echo "Ingrese el nuevo nombre de la empresa: ";
                            $nuevoNombreEmpresa = trim(fgets(STDIN));
                            $empresa->setENombre($nuevoNombreEmpresa);
                            $empresa->modificar();
                            imprimirEnVerde("Nombre modificado exitosamente \n");
                            break;
                        case 2:
                            echo "Ingrese la nueva dirección de la empresa: ";
                            $nuevaDireccionEmpresa = trim(fgets(STDIN));
                            $empresa->setEdireccion($nuevaDireccionEmpresa);
                            $empresa->modificar();
                            imprimirEnVerde("Dirección modificada exitosamente \n");
                            break;
                        default:
                            imprimirEnRojo("Opción no válida, por favor seleccione una opción válida \n");
                            break;
                    }
                } else {
                    imprimirEnRojo("La empresa no se encuentra registrada \n");
                }
                break;
            case 4: 
                // Eliminar Empresa
                echo "Ingrese el ID de la empresa a eliminar: ";
                $idEmpresa = trim(fgets(STDIN));
                $found = $empresa->Buscar($idEmpresa);
                if ($found) {
                    $empresa->eliminar();
                    imprimirEnVerde("Empresa eliminada exitosamente \n");
                } else {
                    imprimirEnRojo("La empresa no se encuentra registrada \n");
                }
                break;
        }
        gestionarEmpresas(); // Volver al menú de empresas después de manejar una opción
    }
}

function gestionarPasajeros() {
    mostrarMenuPasajeros();
    echo "Opción: ";
    $opcionUserPasajero = trim(fgets(STDIN));
    $pasajero = new Pasajero();
    $viaje = new Viaje();
    if ($opcionUserPasajero == 5) {
        App();
    } else {
        switch($opcionUserPasajero) {
            case 1: 
                // Ver Lista de Pasajeros segun el id del viaje
                echo "Ingrese el ID del viaje: ";
                $idViaje = trim(fgets(STDIN));
                $found = $viaje->Buscar($idViaje);
                if ($found){
                    $listaPasajeros = $pasajero->listar("idviaje = $idViaje");
                    if ($listaPasajeros) {
                        foreach ($listaPasajeros as $pasajero) {
                            echo "--------------------------------";
                            imprimirEnVerde($pasajero);
                        }
                    } else {
                        imprimirEnRojo("No se encontraron pasajeros para el viaje \n");
                    }
                } else {
                    imprimirEnRojo("El viaje no se encuentra registrado \n");
                }
                break;
            case 2: 
                // Agregar Pasajero
                echo "Ingrese el id del viaje: ";
                $idViaje = trim(fgets(STDIN));
                $found = $viaje->Buscar($idViaje);
                if ($found) {
                    $colObjPasajerosBd = $pasajero->listar("idviaje = $idViaje");
                    foreach ($colObjPasajerosBd as $pasajeroBd) {
                        $viaje->agregarPasajero($pasajeroBd);
                    }
                    $colObjPasajeros = $viaje->getColObjPasajeros();
                    $cantPasajeros = count($colObjPasajeros);
                    $cantMax = $viaje->getVcantmaxpasajeros();
                    if ($cantPasajeros >= $cantMax) {
                        imprimirEnRojo("El viaje se encuentra completo: " . $cantPasajeros . "/" . $cantMax . "\n");
                    } else {
                        echo "Ingrese el documento del pasajero: ";
                        $documentoPasajero = trim(fgets(STDIN));
                        $found = $pasajero->Buscar($documentoPasajero);
                        if ($found){
                            imprimirEnRojo("El pasajero ya se encuentra registrado \n");
                        } else {
                            echo "Ingrese el pasaporte del pasajero: ";
                            $pasaporte = trim(fgets(STDIN));
                            echo "Ingrese el nombre del pasajero: ";
                            $nombrePasajero = trim(fgets(STDIN));
                            echo "Ingrese el apellido del pasajero: ";
                            $apellidoPasajero = trim(fgets(STDIN));
                            echo "Ingrese el telefono del pasajero: ";
                            $telefonoPasajero = trim(fgets(STDIN));
                            // antes de insertar los datos, verificamos que se pueda agregar al pasajero
                            $pasajero->cargar($documentoPasajero, $nombrePasajero, $apellidoPasajero, $telefonoPasajero, $pasaporte, $idViaje);
                            $agregarPasajero = $viaje->agregarPasajero($pasajero);
                            // ademas, agregamos los pasajeros de la base de datos
                            if ($agregarPasajero) {
                                $cantPasajerosNueva = count($viaje->getColObjPasajeros());
                                $insert = $pasajero->insertar();
                                if ($insert) {
                                    imprimirEnVerde("Pasajero agregado exitosamente: " . $cantPasajerosNueva . "/" . $cantMax . "\n") .  "\n" . 
                                    imprimirEnVerde("Valor: $" . $viaje->getVimporte() . "\n");     
                                } 
                            }
                        }
                    }
                } else {
                    imprimirEnRojo("El viaje no se encuentra registrado \n");
                }    
                break;
            case 3:
                // Modificar Pasajero
                echo "Ingrese el documento del pasajero a modificar: ";
                $documentoPasajero = trim(fgets(STDIN));
                $found = $pasajero->Buscar($documentoPasajero);
                if ($found) {
                    echo "Ingrese el nuevo pasaporte del pasajero: ";
                    $nuevoPasaporte = trim(fgets(STDIN));
                    $pasajero->setPasaporte($nuevoPasaporte);
                    $pasajero->modificar();
                    imprimirEnVerde("Pasaporte modificado exitosamente \n");
                } else {
                    imprimirEnRojo("El pasajero no se encuentra registrado \n");
                }
            case 4: 
                // Eliminar Pasajero
                echo "Ingrese el documento del pasajero a eliminar: ";
                $documentoPasajero = trim(fgets(STDIN));
                $found = $pasajero->Buscar($documentoPasajero);
                if ($found) {
                    $pasajero->eliminar();
                    imprimirEnVerde("Pasajero eliminado exitosamente \n");
                } else {
                    imprimirEnRojo("El pasajero no se encuentra registrado \n");
                }
                break;
            default:
                echo "Opción no válida, por favor seleccione una opción válida \n";
                break;
        }
        gestionarPasajeros(); // Volver al menú de pasajeros después de manejar una opción
    }
}

function gestionarResponsables() {
    mostrarMenuResponsables();
    echo "Opción: ";
    $opcionUserResponsable = trim(fgets(STDIN));
    $responsable = new ResponsableV();
    $pasajero = new Pasajero();
    $persona = new Persona();
    if ($opcionUserResponsable == 5) {
        App();
    } else {
        switch($opcionUserResponsable) {
            case 1: 
                // Ver lista de responsables
                $listaResponsables = $responsable->listar();
                if ($listaResponsables) {
                    echo "Responsables encontrados: \n";
                    foreach ($listaResponsables as $responsable) {
                        echo "--------------------------------\n";
                        imprimirEnVerde($responsable);
                    }
                } else {
                    imprimirEnRojo("No se encontraron responsables.\n");
                }
                break;
            case 2:
                // Agregar Responsable (verificar que exista una persona previamente)
                echo "Ingrese el documento de la persona responsable: ";
                $documentoResponsable = trim(fgets(STDIN));
                // verificamos que ese responsable no exista previamente
                $found = $responsable->Buscar($documentoResponsable);
                if ($found) {
                    imprimirEnRojo("El responsable ya se encuentra registrado \n");
                } else {
                    // verificamos que primero sea una persona
                    $foundPersona = $persona->Buscar($documentoResponsable);
                    if ($foundPersona){
                    // verificamos que no sea pasajero
                    $foundPasajero = $pasajero->Buscar($documentoResponsable);
                    if ($foundPasajero) {
                        imprimirEnRojo("La persona es un pasajero, no puede ser responsable \n");
                    } else {
                        echo "Ingrese el numero de licencia del responsable: ";
                        $numeroLicencia = trim(fgets(STDIN));
                        $responsable->setNrodoc($documentoResponsable);
                        $responsable->setRNumeroLicencia($numeroLicencia);
                        $responsable->setRnumeroempleado(0);
                        $insert = $responsable->insertar();
                        if ($insert) {
                            imprimirEnVerde("Responsable agregado exitosamente \n");
                        } else {
                            imprimirEnRojo("Error al agregar el responsable \n");
                        }
                    }
                    } else {
                        imprimirEnRojo("La persona no se encuentra registrada con ese DNI \n");
                    }
                }
                break;
            case 3:
                // Modificar Responsable
                echo "Ingrese el documento del responsable a modificar: ";
                $documentoResponsable = trim(fgets(STDIN));
                $found = $responsable->Buscar($documentoResponsable);
                if ($found){
                    echo "Ingrese el nuevo numero de licencia del responsable: ";
                    $nuevoNumeroLicencia = trim(fgets(STDIN));
                    $responsable->setRNumeroLicencia($nuevoNumeroLicencia);
                    $responsable->modificar();
                    imprimirEnVerde("Numero de licencia modificado exitosamente \n");
                }
                break;
            case 4:
                // Eliminar Responsable
                echo "Ingrese el documento del responsable a eliminar: ";
                $documentoResponsable = trim(fgets(STDIN));
                $found = $responsable->Buscar($documentoResponsable);
                if ($found) {
                    $responsable->eliminar();
                    imprimirEnVerde("Responsable eliminado exitosamente \n");
                } else {
                    imprimirEnRojo("El responsable no se encuentra registrado \n");
                }
                break;

        }
        gestionarResponsables(); // Volver al menú de responsables después de manejar una opción
    }
}
function gestionarPersonas() {
    mostrarMenuPersonas();
    echo "Opción: ";
    $opcionUserPersona = trim(fgets(STDIN));
    $persona = new Persona();

    if ($opcionUserPersona == 5) {
        App();
    } else {
        switch($opcionUserPersona) {
            case 1:
                // Ver Lista de Personas
                $listaPersonas = $persona->listar(); // obtenemos la lista de personas
                if ($listaPersonas) {
                    echo "Personas encontradas: \n";
                    foreach ($listaPersonas as $persona) {
                        echo "--------------------------------\n";
                        imprimirEnVerde($persona);
                    }
                } else {
                    imprimirEnRojo("No se encontraron personas.\n");
                }
                break;
            case 2:
                // Agregar Persona
                echo "Ingrese el documento de la persona: ";
                $documentoPersona = trim(fgets(STDIN));
                $found = $persona->Buscar($documentoPersona);

                if ($found){
                    imprimirEnRojo("La persona ya se encuentra registrada \n");
                } else {
                   echo "Ingrese el nombre de la persona: ";
                   $nombrePersona = trim(fgets(STDIN));
                   echo "Ingrese el apellido de la persona: ";
                   $apellidoPersona = trim(fgets(STDIN));
                   echo "Ingrese el telefono de la persona: ";
                   $telefonoPersona = trim(fgets(STDIN));  
                   $persona->setNrodoc($documentoPersona);
                   $persona->setPNombre($nombrePersona);
                   $persona->setPApellido($apellidoPersona);
                   $persona->setPTelefono($telefonoPersona);
                   $insert = $persona->insertar();
                   if ($insert) {
                          imprimirEnVerde("Persona agregada exitosamente \n");
                     } else {
                          imprimirEnRojo("Error al agregar la persona \n");
                   }
                }
                break;
            case 3:
                // Modificar Persona
                echo "Ingrese el documento de la persona a modificar: ";
                $documentoPersona = trim(fgets(STDIN));
                $found = $persona->Buscar($documentoPersona);
                if ($found) {
                    echo "Que Desea modificar? \n";
                    mostrarMenuModificacionPersona();
                    echo "Opción: ";
                    $opcionModificacionPersona = trim(fgets(STDIN));
                    switch($opcionModificacionPersona) {
                        case 1:
                            echo "Ingrese el nuevo nombre de la persona: ";
                            $nuevoNombrePersona = trim(fgets(STDIN));
                            $persona->setPNombre($nuevoNombrePersona);
                            $persona->modificar();
                            imprimirEnVerde("Nombre modificado exitosamente \n");
                            break;
                        case 2:
                            echo "Ingrese el nuevo apellido de la persona: ";
                            $nuevoApellidoPersona = trim(fgets(STDIN));
                            $persona->setPApellido($nuevoApellidoPersona);
                            $persona->modificar();
                            imprimirEnVerde("Apellido modificado exitosamente \n");
                            break;
                        case 3:
                            echo "Ingrese el nuevo telefono de la persona: ";
                            $nuevoTelefonoPersona = trim(fgets(STDIN));
                            $persona->setPTelefono($nuevoTelefonoPersona);
                            $persona->modificar();
                            imprimirEnVerde("Telefono modificado exitosamente \n");
                            break;
                        default:
                            imprimirEnRojo("Opción no válida, por favor seleccione una opción válida \n");
                            break;
                    }
                } else {
                    imprimirEnRojo("La persona no se encuentra registrada \n");
                }
                break;
            case 4:
                // Eliminar Persona
                echo "Ingrese el documento de la persona a eliminar: ";
                $documentoPersona = trim(fgets(STDIN));
                $found = $persona->Buscar($documentoPersona);
                if ($found) {
                    $persona->eliminar();
                    imprimirEnVerde("Persona eliminada exitosamente \n");
                } else {
                    imprimirEnRojo("La persona no se encuentra registrada \n");
                }
                break;
            default:
                imprimirEnRojo("Opción no válida, por favor seleccione una opción válida \n");
                break;
        
        }
        gestionarPersonas(); // Volver al menú de personas después de manejar una opción
    }
}
function App() {
    echo "Bienvenido a la App de Viajes ✈️🌍️! Para continuar seleccione una opcion \n";
    mostrarMenuPrincipal();
    echo "Opción: ";
    $opcionUser = trim(fgets(STDIN));

    switch ($opcionUser) {
        case 1:
            gestionarViajes();
            break;
        case 2:
            gestionarEmpresas();
            break;
        case 3:
            gestionarPasajeros();
            break;
        case 4:
            gestionarResponsables();
            break;
        case 5:
            gestionarPersonas();
            break;
        case 6:
            echo "Gracias por usar la App de Viajes. ¡Adiós!\n";
            break;
        default:
            imprimirEnRojo("Opción no válida, por favor seleccione una opción válida \n"); 
            App();
            break;
    }
}
// Iniciar la aplicación
App();



















