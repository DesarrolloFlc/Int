@extends('layouts.plantilla')

@section('title', 'mintic')

@section('content')
<link href="{{ asset('css/mintic.css') }}" rel="stylesheet" />
<main id="main" class="main">
    <div class="pagetitle text-center">
        <div >
            <h1>Talento tech</h1>
            <nav class="text-center">
                <ol class="breadcrumb d-inline-block">
                    <li class="breadcrumb-item d-inline-block" id="1"><a href="?id=1">Inicio</a></li>
                    <li class="breadcrumb-item d-inline-block" id="2"><a href="?id=2">Guía y Estructura</a></li>
                    <li class="breadcrumb-item d-inline-block" id="3"><a href="?id=3">Prerrequisitos</a></li>
                    <li class="breadcrumb-item d-inline-block" id="4"><a href="?id=4">Léeme</a></li>
                </ol>
            </nav>
        </div>

        <?php
            $id = $_REQUEST["id"] ?? "1";
            if ($id == "1") {
                ?>
                <h1 style="text-align: left">Talento Tech Finleco</h1>
                <div class="w-100 mt-3" id="container">
                    <div class="tab-pane fade shadow rounded bg-white show active p-5 overflow-auto">
                        <div class="contenedor-imagenes d-flex justify-content-center align-items-center">
                            <div class="imagen-con-descripcion text-center d-flex flex-column align-items-center">
                                <img src="{{asset('storage/Mintic/ANALISISDEDATOS.png')}}" alt="Descripción de la imagen 1">
                                <div class="descripcion-imagen mt-2">Análisis de Datos</div>
                            </div>
                            <div class="imagen-con-descripcion text-center d-flex flex-column align-items-center">
                                <img src="{{asset('storage/Mintic/ARQUITECTURAENLANUBE.png')}}" alt="Descripción de la imagen 2">
                                <div class="descripcion-imagen mt-2">Arquitectura en la nube</div>
                            </div>
                            <div class="imagen-con-descripcion text-center d-flex flex-column align-items-center">
                                <img src="{{asset('storage/Mintic/BLOCKCHAIN.png')}}" alt="Descripción de la imagen 3">
                                <div class="descripcion-imagen mt-2">Blockchain</div>
                            </div>
                            <div class="imagen-con-descripcion text-center d-flex flex-column align-items-center">
                                <img src="{{asset('storage/Mintic/DESARROLLOWEB.png')}}" alt="Descripción de la imagen 3">
                                <div class="descripcion-imagen mt-2">Desarrollo Web Full Stack</div>
                            </div>
                            <div class="imagen-con-descripcion text-center d-flex flex-column align-items-center">
                                <img src="{{asset('storage/Mintic/INTELIGENCIAARTIFICIAL.png')}}" alt="Descripción de la imagen 4">
                                <div class="descripcion-imagen mt-2">Inteligencia artificial</div>
                            </div>
                        </div><br><br>

                        <div class="text-center mt-3 d-flex justify-content-center">
                            <a href="https://talentotechbogota.co/" class="custom-button" target="_blank">Página Talento Tech</a>
                            <a href="https://talentotechbogota.co/tratamiento_datos/POLI%cc%81TICA%20DE%20TRATAMIENTO%20DE%20DATOS%20PERSONALES%20TALENTOTECH.pdf" class="custom-button" target="_blank">Política de Tratamiento de Datos</a>
                            <a href="https://talentotechbogota.co/preguntas-frecuentes" class="custom-button" target="_blank">Preguntas Frecuentes</a>
                            <a href="https://talentotechmatricula.com/wp-login.php?loggedout=true&wp_lang=es_ES" class="custom-button" target="_blank">Plataforma de matrículas</a>
                        </div>
                    </div>
                </div>




                <?php
            } elseif ($id == "2") {
                ?>
                <h1 style="text-align: left">Guía y Estructura de la llamada</h1>
                <div class="w-100 mt-3" id="container">
                    <div class="tab-pane fade shadow rounded bg-white show active p-5 overflow-auto">
                        <p><strong style="text-align: center">Estructura de la llamada</strong></p>
                        <div style="text-align: left">

                            <ul class="bullet-point">
                                <li>Matrículas</li>
                            </ul>
                            <p><strong>Saludo y presentación.</strong></p>
                            <ul class="bullet-point">
                                <li>Buenos días, ¿me comunico con el/la Sr./a Usuario? - Un gusto saludarte,
                                    te habla <strong>Asesor</strong>, de Talento Tech del MINTIC Bogotá. ¿Cómo estás? -
                                    (<strong>Empatizar con el saludo</strong>).
                                </li>
                            </ul>
                            <ul class="bullet-point">
                                <li>Te llamo para continuar con tu proceso de matrícula. Te inscribiste el
                                     año pasado para uno de los cinco programas que habilitó el ministerio
                                     y presentaste una prueba de habilidades en el programa (<strong>Nombre del
                                     programa</strong>) ¿Es correcto? - ¡Perfecto!
                                </li>
                            </ul>
                            <p><strong>Motivo de la llamada.</strong></p>
                            <ul class="bullet-point">
                                <li>Antes de continuar debo informarte que tus datos son tratados bajo el cumplimiento
                                     de la Ley 1581 de 2012, y que la llamada está siendo grabada y monitoreada con el
                                     fin de prestar un mejor servicio.</li>
                            </ul>
                            <ul class="bullet-point">
                                <li>Posterior a la verificación de las pruebas has sido seleccionado para continuar
                                    con la legalización de la matrícula. ¿Te encuentras interesado en continuar con el
                                    proceso?</li>
                            </ul>
                            <ul class="bullet-point">
                                <li>Ahora bien, de acuerdo con la inscripción realizada tenemos un número de cédula
                                    finalizado en (<strong>ultimos cuatro dígitos</strong>) ¿Me confirmas el número completo por favor?</li>
                            </ul>
                            <ul class="bullet-point">
                                <li>Según los resultados de tu examen de habilidades estas en un nivel (<strong>Básico,
                                    Intermedio, Avanzado</strong>), por lo cual validaremos unos prerrequisitos para medir tus
                                    conocimientos en este nivel ¿De acuerdo?</li>
                            </ul>
                        </div>

                        <div class="text-center mt-3 d-flex justify-content-center">
                            <button type="button" class="custom-button" data-toggle="modal" data-target="#analisisModal">Análisis de Datos</button>
                            <button type="button" class="custom-button" data-toggle="modal" data-target="#arquitecturaModal">Arquitectura en la Nube</button>
                            <button type="button" class="custom-button" data-toggle="modal" data-target="#blockModal">Blockchain</button>
                            <button type="button" class="custom-button" data-toggle="modal" data-target="#desarrolloModal">Desarrollo Web Full Stack</button>
                            <button type="button" class="custom-button" data-toggle="modal" data-target="#inteligenciaModal">Inteligencia artificial</button>

                        </div>
                        <!-- Modales -->
                        <div class="modal fade" id="analisisModal" tabindex="-1" role="dialog" aria-labelledby="paginaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="analisisModalLabel">Análisis de Datos</h5>
                                </div>
                                <div class="modal-body" style="text-align: left">
                                    <strong>Básico</strong>
                                    <ul class="bullet-point">
                                        <li>Manejo básico de un sistema operativo (Windows, macOS o Linux) e Internet (correo, búsquedas)</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimiento básico de algún lenguaje de programación (Python) y alguna base de datos SQL o NO SQL.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimiento intermedio de Excel.</li>
                                    </ul>

                                    <strong>Intermedio</strong>
                                    <ul class="bullet-point">
                                        <li>Conocimientos básicos de análisis de datos, incluyendo manejo de datos y estadística descriptiva.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia con al menos uno de los siguientes lenguajes: Python, R o SQL.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Capacidad intermedia para extraer y visualizar datos de diferentes fuentes en herramientas como Power BI o Looker Studio.</li>
                                    </ul>

                                    <strong>Avanzado</strong>
                                    <ul class="bullet-point">
                                        <li>Dominio de técnicas de análisis de datos a nivel intermedio, incluyendo estadística, recolección y limpieza de datos.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia con algoritmos de machine learning orientado a datos.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Dominio a nivel intermedio de algun lenguaje de programación para datos como Python, SQL ó R.</li>
                                </ul>
                            </div>
                                <div class="modal-footer">
                                <button type="button" class="custom-button" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="modal fade" id="arquitecturaModal" tabindex="-1" role="dialog" aria-labelledby="paginaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="arquitecturaModalLabel">Arquitectura en la nube</h5>
                                </div>
                                <div class="modal-body" style="text-align: left">
                                    <strong>Básico</strong>
                                    <ul class="bullet-point">
                                        <li>Dominio de un sistema operativo (Windows, macOS o Linux) e Internet (correo, búsquedas)</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Comprensión de cómo funcionan las arquitecturas de servidores o redes.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimientos básicos de al menos un lenguaje de programación (Java ó Python).</li>
                                    </ul>

                                    <strong>Intermedio</strong>
                                    <ul class="bullet-point">
                                        <li>Conocimientos en diseño de arquitecturas distribuidas y escalables.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Comprensión avanzada de las técnicas de seguridad y cumplimiento normativo en entornos de nube.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia con arquitecturas de Big Data y conocimiento basico de servicios de análisis de datos en AWS y/o Azure.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Capacidad para analizar y resolver problemas complejos en arquitecturas de nube.</li>
                                    </ul>

                                    <strong>Avanzado</strong>
                                    <ul class="bullet-point">
                                        <li>Conocimientos en el diseño de arquitecturas distribuidas y escalables.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Comprensión de técnicas de seguridad y cumplimiento normativo en entornos de nube.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimiento básico de servicios de análisis de datos en AWS y/o Azure.</li>
                                </ul>
                            </div>
                                <div class="modal-footer">
                                <button type="button" class="custom-button" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal fade" id="blockModal" tabindex="-1" role="dialog" aria-labelledby="paginaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="blockModalLabel">Blockchain</h5>
                                </div>
                                <div class="modal-body" style="text-align: left">
                                    <strong>Básico</strong>
                                    <ul class="bullet-point">
                                        <li>Conocimientos sólidos de Web 2.0 </li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Dominio intermedio o avanzando de un lenguaje de programación, preferiblemente Javascript.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Interés por los temas de criptografia, bitcoin y desarrollo de aplicaciones Blockchain.</li>
                                    </ul>

                                    <strong>Intermedio</strong>
                                    <ul class="bullet-point">
                                        <li>Conocimientos sólidos sobre los fundamentos del blockchain, incluyendo tipos de blockchain y criptomonedas básicas.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia con programación, preferiblemente en lenguajes relacionados con blockchain como Solidity, y herramientas de desarrollo como Remix y Truffle.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia en el uso de criptomonedas, wallets, y realización de transacciones básicas en blockchain.</li>
                                    </ul>

                                    <strong>Avanzado</strong>
                                    <ul class="bullet-point">
                                        <li>Conocimientos en programación de smart contracts en Solidity, y experiencia en el despliegue y gestión de estos contratos.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimientos en NFTs</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia con infraestructura de Blockchain, incluyendo el uso de testnets y almacenamiento descentralizado como IPFS.</li>
                                </ul>
                            </div>
                                <div class="modal-footer">
                                <button type="button" class="custom-button" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal fade" id="desarrolloModal" tabindex="-1" role="dialog" aria-labelledby="paginaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="desarrolloModalLabel">Desarrollo Web Full Stack</h5>
                                </div>
                                <div class="modal-body" style="text-align: left">
                                    <strong>Básico</strong>
                                    <ul class="bullet-point">
                                        <li>Manejo básico de un sistema operativo (Windows, macOS o Linux) e Internet (correo, búsquedas)p</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Habilidades básicas de pensamiento algorítmico y resolución de problemas.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Manejo del computador, Excel, e ideal algún conocimiento básico de programación.</li>
                                    </ul>

                                    <strong>Intermedio</strong>
                                    <ul class="bullet-point">
                                        <li>Conocimientos intermedios en HTML5, CSS3 y JavaScript.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia previa en desarrollo frontend y algo de backend básico.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Comprensión de conceptos de programación: variables, bucles, estructuras de control, SQL ó NO SQL.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimientos de herramientas como Git, Visual Studio, etc. </li>
                                    </ul>

                                    <strong>Avanzado</strong>
                                    <ul class="bullet-point">
                                        <li>Dominio avanzado de HTML5, CSS3 y JavaScript.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia práctica con frameworks Frontend y Backend (React ó Angular, Node.JS ó Python)</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimientos intermedios de Programación Orientada a Objetos y patrones de diseño.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimientos intermedios de arquitectura y proyectos de software.</li>
                                    </ul>
                            </div>
                                <div class="modal-footer">
                                <button type="button" class="custom-button" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal fade" id="inteligenciaModal" tabindex="-1" role="dialog" aria-labelledby="paginaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="inteligenciaModalLabel">Inteligencia Artificial</h5>
                                </div>
                                <div class="modal-body" style="text-align: left">
                                    <strong>Básico</strong>
                                    <ul class="bullet-point">
                                        <li>Habilidades en matemáticas incluyendo álgebra y probabilidad.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Habilidades básicas en análisis de datos.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Dominio intermedio o avanzando de un lenguaje de programación, preferiblemente Python.</li>
                                    </ul>

                                    <strong>Intermedio</strong>
                                    <ul class="bullet-point">
                                        <li>Dominio de un lenguaje de programación, preferible Python.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia previa con bibliotecas de programación para análisis de datos, como Pandas y Numpy.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Conocimientos sólidos en matemáticas especialmente en álgebra lineal, cálculo y probabilidad.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia previa en el desarrollo de modelos básicos de machine learning y análisis de datos.</li>
                                    </ul>

                                    <strong>Avanzado</strong>
                                    <ul class="bullet-point">
                                        <li> Dominio de algoritmos avanzados de machine learning y experiencia con herramientas como Scikit-learn, XGBoost, LightGBM.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia en la construcción de modelos de machine learning.</li>
                                    </ul>
                                    <ul class="bullet-point">
                                        <li>Experiencia en el desarrollo de aplicaciones de visión por computadora y análisis de imágenes."</li>
                                </ul>
                            </div>
                                <div class="modal-footer">
                                <button type="button" class="custom-button" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                            </div>
                        </div><br>

                        <div style="text-align: left">
                        <ul class="bullet-point">
                            <li>Posterior a la validación de prerrequisitos.</li>
                            <ul class="bullet-point">
                                <li>Posterior a la validación de prerrequisitos.</li>
                            </ul>
                        </ul>
                        <p><strong>Validación de datos</strong></p>
                        Una vez finalizada la validación de prerrequisitos proceder a realizar la validación de la siguiente información.
                        <ul class="bullet-point">
                            <li>Sr. Usuario, para continuar con el registro de tu matrícula me confirmas por favor.
                            </li>
                        </ul>
                        <ul class="bullet-point">
                            <li>Correo electrónico actualizado
                            </li>
                        </ul>
                        <ul class="bullet-point">
                            <li>¿Cuentas con una disponibilidad de 10 a 15 horas semanales?
                            </li>
                        </ul>
                        <ul class="bullet-point">
                            <li>Para este curso recuerda que necesitarás un buen acceso a Internet
                                y contar con cámara y micrófono para participar activamente en las sesiones.
                            </li>
                        </ul>
                        <p><strong>Términos </strong></p>
                        <ul class="bullet-point">
                            <li>Sr. Usuario, aceptas nuestra política de tratamiento de datos,
                                requisitos de la convocatoria, términos y condiciones, la cual se
                                encuentra publicada en nuestra página <a href="https://talentotechbogota.co/" target="_blank">
                                https://talentotechbogota.co/</a></li>
                        </ul>
                        <p><strong>Confirmación del Bootcamp. </strong></p>
                        <ul class="bullet-point">
                            <li>¿Me confirmas por favor tu jornada de interés? ¿AM o PM?
                                 (Validar cupos disponibles en aplicativo)</li>
                        </ul>
                        <ul class="bullet-point">
                            <li>Validar modalidad de interés, híbrido o virtual. </li>
                        </ul>
                        <ul class="bullet-point">
                            <li>Parafrasear la información del programa a matricular.</li>
                        </ul>
                        <ul class="bullet-point">
                            <li>Sr. Usuario, hemos finalizado el proceso de matrícula, recuerda
                                que quedas matriculado en el programa (nombre del programa), en
                                el nivel (nivel), modalidad (virtual o híbrida), y en los
                                horarios (horarios), tu fecha de inicio del programa será para
                                el día (día). ¿Correcto? </li>
                        </ul>
                        <ul class="bullet-point">
                            <li>Recibirás un correo de confirmación donde te aparecerá un paso
                                a paso para que adjuntes la carta de compromiso y la cedula de
                                ciudadanía. Recuerda revisar spam y bandeja de entrada. A
                                recibirlo cliquea en la opción <strong>"subir documentos"</strong>.</li>
                        </ul>
                        <ul class="bullet-point">
                            <li>Ten presente que posterior a esta matrícula, no se podrá
                                realizar cambios dentro de este mismo cohorte, por ello te pregunto
                                ¿La información está correcta? - ¡Bien!</li>
                        </ul>

                        <p><strong>Despedida</strong></p>
                        <ul class="bullet-point">
                            <li>Ha sido un gusto atenderte, recuerda mi nombre (nombre asesor) de Talento Tech
                                Bogotá, una vez recibido los documentos, te llegara un correo con toda la
                                 información para el inicio del programa, si tienes alguna inquietud no dudes
                                 en contactarte al WhatsApp 3239378596.<br>
                                Te deseo muchos éxitos en tu programa, ¡Feliz día!.</li>
                        </ul>
                        </div>

                        <div class="text-center mt-3 d-flex ">
                            <button type="button" class="custom-button" data-toggle="modal" data-target="#quedecirModal">¿Qué decir en los siguientes escenarios?</button>
                        </div>

                        <div class="modal fade" id="quedecirModal" tabindex="-1" role="dialog" aria-labelledby="paginaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="quedecirModalLabel">¿Qué decir en los siguientes escenarios?</h5>
                                </div>
                                <div class="modal-body" style="text-align: left">
                                    <strong>No me siento seguro de brindar mi información personal por llamada. 🤔</strong>
                                    <ul class="bullet-point">
                                        <li>Entiendo la novedad, ten presente que tus datos reposan en nuestras bases
                                            de información, la cual autorizaste en el proceso de selección; por tal motivo
                                             solo pedimos confirmar. Adicionalmente, solo serán usados para fines
                                             educativos entre tu persona, el ministerio y nuestras áreas de formación. </li>
                                    </ul>


                                    <strong>¿Los extranjeros se pueden matricular? 🛑</strong>
                                    <ul class="bullet-point">
                                        <li>Lo sentimos, en el momento el proceso de matrículas es solo para ciudadanos
                                             colombianos residentes en la ciudad de Bogotá.</li>
                                    </ul>


                                    <strong>¿Qué pasa si estoy fuera de Bogotá? ✈️</strong>
                                    <ul class="bullet-point">
                                        <li> Es importante que el estudiante resida en cualquier localidad de Bogotá.
                                            No será posible realizar una matricula a alguien aledaño, o que resida
                                            fuera del país, dado que la convocatoria es solo para residentes de la
                                            ciudad. Sin embargo, no te preocupes, te invitamos a estar muy pendiente
                                            del Ministerio, ya que próximamente abrirán nuevos programas a otras
                                            ciudades del territorio nacional.</li>
                                    </ul>
                                    <strong>¿Puede un tercero matricular a un usuario? 🤓</strong>
                                    <ul class="bullet-point">
                                        <li>No, la matrícula se debe realizar solo con el usuario inscrito. </li>
                                    </ul>
                                    <strong><p>Dentro de la página <a href="https://talentotechbogota.co/preguntas-frecuentes" target="_blank">
                                        https://talentotechbogota.co/preguntas-frecuentes</a> se encuentra un glosario
                                        informativo que ayudará a brindar una información organizada a las preguntas
                                        diversas del usuario. </p></strong>

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="custom-button" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                            </div>
                        </div><br>

                    </div>
                </div>
            </div>
                <?php
            } elseif ($id == "3") {
                ?>
                <h1 style="text-align: left">Validación de prerrequisitos</h1>

                <div class="tab-pane fade shadow  bg-white show active p-5 overflow-auto">
                    <p>Recuerda evaluar al estudiante de manera profundizada y analítica, de aquí depende el éxito del proceso del matriculado.</p>
                    <div class="container mt-3">
                        <div class="row">
                            <div class="col-lg-6 mb-4 col-12 ">
                                <div class="imagen-con-descripcion col-12">
                                    <img src="{{asset('storage/Mintic/ANALISISDEDATOS2.png')}}">

                                    <details class="desplegable" style="text-align: left">
                                        <summary>Análisis de Datos</summary>
                                        <p><strong>Básico</strong></p>
                                        <ul class="bullet-point">
                                            <li>Manejo básico de un sistema operativo (Windows, macOS o Linux) e Internet (correo, búsquedas)</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Conocimiento básico de algún lenguaje de programación (Python) y alguna base de datos SQL o NO SQL.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Conocimiento intermedio de Excel.</li>
                                        </ul>

                                        <p><strong>Intermedio</strong></p>
                                        <ul class="bullet-point">
                                            <li>Conocimientos básicos de análisis de datos, incluyendo manejo de datos y estadística descriptiva.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Experiencia con al menos uno de los siguientes lenguajes: Python, R o SQL.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Capacidad intermedia para extraer y visualizar datos de diferentes fuentes en herramientas como Power BI o Looker Studio.</li>
                                        </ul>

                                        <p><strong>Avanzado</strong></p>
                                        <ul class="bullet-point">
                                            <li>Dominio de técnicas de análisis de datos a nivel intermedio, incluyendo estadística, recolección y limpieza de datos.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Experiencia con algoritmos de machine learning orientado a datos.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Dominio a nivel intermedio de algún lenguaje de programación para datos como Python, SQL ó R.</li>
                                        </ul>
                                    </details>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-5 col-sm-7 mb-4 col-12">
                                <div class="imagen-con-descripcion col-12">
                                    <img src="{{asset('storage/Mintic/ARQUITECTURA2.png')}}" >

                                    <details class="desplegable" style="text-align: left">
                                        <summary>Arquitectura en la nube</summary>
                                        <p><strong>Básico</strong></p>
                                            <ul class="bullet-point">
                                                <li>Dominio de un sistema operativo (Windows, macOS o Linux) e Internet (correo, búsquedas)</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Comprensión de cómo funcionan las arquitecturas de servidores o redes.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Conocimientos básicos de al menos un lenguaje de programación (Java ó Python).</li>
                                            </ul>

                                            <strong>Intermedio</strong>
                                            <ul class="bullet-point">
                                                <li>Conocimientos en diseño de arquitecturas distribuidas y escalables.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Comprensión avanzada de las técnicas de seguridad y cumplimiento normativo en entornos de nube.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Experiencia con arquitecturas de Big Data y conocimiento basico de servicios de análisis de datos en AWS y/o Azure.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Capacidad para analizar y resolver problemas complejos en arquitecturas de nube.</li>
                                            </ul>

                                            <strong>Avanzado</strong>
                                            <ul class="bullet-point">
                                                <li>Conocimientos en el diseño de arquitecturas distribuidas y escalables.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Comprensión de técnicas de seguridad y cumplimiento normativo en entornos de nube.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Conocimiento básico de servicios de análisis de datos en AWS y/o Azure.</li>
                                            </ul>
                                    </details>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-5 col-sm-7 mb-4 col-12">
                                <div class="imagen-con-descripcion col-12">
                                    <img src="{{asset('storage/Mintic/BLOCKCHAIN2.png')}}" >

                                    <details class="desplegable" style="text-align: left">
                                        <summary>Blockchain</summary>
                                        <p><strong>Básico</strong></p>
                                            <ul class="bullet-point">
                                                <li>Conocimientos sólidos de Web 2.0 </li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Dominio intermedio o avanzando de un lenguaje de programación, preferiblemente Javascript.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Interés por los temas de criptografia, bitcoin y desarrollo de aplicaciones Blockchain.</li>
                                            </ul>

                                            <strong>Intermedio</strong>
                                            <ul class="bullet-point">
                                                <li>Conocimientos sólidos sobre los fundamentos del blockchain, incluyendo tipos de blockchain y criptomonedas básicas.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Experiencia con programación, preferiblemente en lenguajes relacionados con blockchain como Solidity, y herramientas de desarrollo como Remix y Truffle.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Experiencia en el uso de criptomonedas, wallets, y realización de transacciones básicas en blockchain.</li>
                                            </ul>

                                            <strong>Avanzado</strong>
                                            <ul class="bullet-point">
                                                <li>Conocimientos en programación de smart contracts en Solidity, y experiencia en el despliegue y gestión de estos contratos.</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Conocimientos en NFTs</li>
                                            </ul>
                                            <ul class="bullet-point">
                                                <li>Experiencia con infraestructura de Blockchain, incluyendo el uso de testnets y almacenamiento descentralizado como IPFS.</li>
                                        </ul>
                                    </details>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-5 col-sm-7 mb-4 col-12">
                                <div class="imagen-con-descripcion col-12">
                                    <img src="{{asset('storage/Mintic/DESARROLLOWEB2.png')}}" alt="Descripción de la imagen 1">

                                    <details class="desplegable" style="text-align: left">
                                        <summary>Desarrollo Web Full Stack</summary>
                                        <p><strong>Básico</strong></p>
                                        <ul class="bullet-point">
                                            <li>Manejo básico de un sistema operativo (Windows, macOS o Linux) e Internet (correo, búsquedas)p</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Habilidades básicas de pensamiento algorítmico y resolución de problemas.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Manejo del computador, Excel, e ideal algún conocimiento básico de programación.</li>
                                        </ul>

                                        <strong>Intermedio</strong>
                                        <ul class="bullet-point">
                                            <li>Conocimientos intermedios en HTML5, CSS3 y JavaScript.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Experiencia previa en desarrollo frontend y algo de backend básico.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Comprensión de conceptos de programación: variables, bucles, estructuras de control, SQL ó NO SQL.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Conocimientos de herramientas como Git, Visual Studio, etc. </li>
                                        </ul>

                                        <strong>Avanzado</strong>
                                        <ul class="bullet-point">
                                            <li>Dominio avanzado de HTML5, CSS3 y JavaScript.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Experiencia práctica con frameworks Frontend y Backend (React ó Angular, Node.JS ó Python)</li>
                                        </ul>
                                            <ul class="bullet-point">
                                            <li>Conocimientos intermedios de Programación Orientada a Objetos y patrones de diseño.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Conocimientos intermedios de arquitectura y proyectos de software.</li>
                                        </ul>
                                    </details>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-5 col-sm-7 col-12 mb-4">
                                <div class="imagen-con-descripcion  col-12">
                                    <img src="{{asset('storage/Mintic/INTELIGENCIA2.png')}}" >

                                    <details class="desplegable" style="text-align: left">
                                        <summary>Inteligencia Artificial</summary>
                                        <p><strong>Básico</strong></p>
                                        <ul class="bullet-point">
                                            <li>Habilidades en matemáticas incluyendo álgebra y probabilidad.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Habilidades básicas en análisis de datos.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Dominio intermedio o avanzando de un lenguaje de programación, preferiblemente Python.</li>
                                        </ul>

                                        <strong>Intermedio</strong>
                                        <ul class="bullet-point">
                                            <li>Dominio de un lenguaje de programación, preferible Python.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Experiencia previa con bibliotecas de programación para análisis de datos, como Pandas y Numpy.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Conocimientos sólidos en matemáticas especialmente en álgebra lineal, cálculo y probabilidad.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Experiencia previa en el desarrollo de modelos básicos de machine learning y análisis de datos.</li>
                                        </ul>

                                        <strong>Avanzado</strong>
                                        <ul class="bullet-point">
                                            <li> Dominio de algoritmos avanzados de machine learning y experiencia con herramientas como Scikit-learn, XGBoost, LightGBM.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Experiencia en la construcción de modelos de machine learning.</li>
                                        </ul>
                                        <ul class="bullet-point">
                                            <li>Experiencia en el desarrollo de aplicaciones de visión por computadora y análisis de imágenes."</li>
                                        </ul>
                                    </details>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
            } elseif ($id == "4") {
                ?>
                <h1 style="text-align: left">Información para ti</h1>
                    <div class="tab-pane fade shadow rounded bg-white show active p-5 overflow-auto w-100 mt-3" >
                        <center><div>
                            <div style="flex: 1; display: flex; flex-direction: column; ">
                            <strong><p>Ten un tono de voz agradable</p></strong>
                            <p>Recuerda que en llamada el trato con el usuario es importante, siéntete autónomo de llevar la
                                 llamada a tu comodidad, sé empático, dinámico y escucha las necesidades del cliente.</p>
                            </div>
                            <img class="pepito" src="{{asset('storage/Mintic/Leer.png')}}">

                        </div></center><br>
                        <div class="container">
                            <div class="row">
                                <div class="additional-content col-6">
                                    <strong><p>No asumas cosas</p></strong>
                                    <p>No todos los usuarios son iguales, trátalos siempre como te gustaría que te trataran en una llamada.</p>
                                  </div>
                                  <div class="additional-content col-6">
                                    <strong><p>Brinda información correcta y precisa</p></strong>
                                    <p>Maneja con seguridad toda la información que sabes del proceso, y al finalizar rectifica todo antes de guardar; un pequeño descuido puede traer un gran problema.</p>
                                  </div>
                            </div>
                            <hr>
                            <strong><p>Sedes presenciales para modalidad híbrida</p></strong>
                                <div class="contenedor-imagenes d-flex justify-content-center align-items-center">
                                    <div class="imagen-con-descripcion text-center d-flex flex-column align-items-center">
                                        <img src="{{asset('storage/Mintic/ZONANORTE.png')}}">
                                        <div class="descripcion-imagen mt-2"><strong>Norte</strong>
                                            <p>Carrera 21 #87-96, Polo Club</p>
                                        </div>
                                    </div>
                                    <div class="imagen-con-descripcion text-center d-flex flex-column align-items-center">
                                        <img src="{{asset('storage/Mintic/ZONACENTRO.png')}}">
                                        <div class="descripcion-imagen mt-2"><strong>Centro</strong>
                                            <p>Carrera 16 #31A-36, Teusaquillo.</p>
                                        </div>
                                    </div>
                                    <div class="imagen-con-descripcion text-center d-flex flex-column align-items-center">
                                        <img src="{{asset('storage/Mintic/ZONASUR.png')}}">
                                        <div class="descripcion-imagen mt-2"><strong>Sur</strong>
                                            <p>Avenida Carrera 68 #15-30 SUR, Kennedy</p>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                <?php
            }
        ?>

</main>



<!-- JavaScript de Bootstrap (jQuery requerido) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection


