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

// CRUD - Create , Read , Update Delete

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


// Implementacion de funciones para gestionar las opciones del menu

function gestionarViajes() {
    mostrarMenuViajes();
    echo "Opción: ";
    $opcionUserViaje = trim(fgets(STDIN));

    if ($opcionUserViaje == 5) {
        App();
    } else {
        // manejamos las opciones del menu de viajes
        switch($opcionUserViaje) {
            case 1:
                // Ver Lista de Viajes
                $viaje = new Viaje(); // creamos la instancia de viaje que se conecta a la BD
                $listaViajes = $viaje->listar(); // obtenemos la lista de viajes

                if ($listaViajes) {
                    echo "Viajes encontrados: \n";
                    foreach ($listaViajes as $viaje) {
                        echo "--------------------------------\n";
                        imprimirEnVerde($viaje);
                    }
                } else {
                    echo "No se encontraron viajes.\n";
                }
                break;
            case 2:
                // Agregar Viaje
                echo "agregamos viaje";
                break;
            case 3:
                // Modificar Viaje
                echo "modificamos viaje";
                break;
            case 4:
                // Eliminar Viaje
                echo "eliminamos viaje";
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

    if ($opcionUserEmpresa == 5) {
        App();
    } else {
        // Aquí puedes añadir más casos para las opciones del menú de empresas
        gestionarEmpresas(); // Volver al menú de empresas después de manejar una opción
    }
}

function gestionarPasajeros() {
    mostrarMenuPasajeros();
    echo "Opción: ";
    $opcionUserPasajero = trim(fgets(STDIN));

    if ($opcionUserPasajero == 5) {
        App();
    } else {
        // Aquí puedes añadir más casos para las opciones del menú de pasajeros
        gestionarPasajeros(); // Volver al menú de pasajeros después de manejar una opción
    }
}

function gestionarResponsables() {
    mostrarMenuResponsables();
    echo "Opción: ";
    $opcionUserResponsable = trim(fgets(STDIN));
    $responsable = new ResponsableV();
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
                    echo "No se encontraron responsables.\n";
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
                    echo "No se encontraron personas.\n";
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
    echo "Bienvenido a la App de Viajes! Para continuar seleccione una opcion \n";
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
            echo "Opción no válida, por favor seleccione una opción válida \n";
            App();
            break;
    }
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

function mostrarMenuModificacionResponsable() {
    echo "1) Modificar Numero Licencia \n";
}


// Iniciar la aplicación
App();



















