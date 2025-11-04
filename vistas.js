// Ingresos/Vistas -> Rol

"Comun" = {
    "Vistas": [
        "Inicio",
        "Perfil",
        "Identidad Corporativa",
    ]
}

"Roles" = [

    "Administrativos" = [
        "Unidades" = [
            "Calidad" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de todos los procesos dentro del mapa
                    - "Horarios",                         // Generar Horarios para unidad de calidad / edición de horarios generados
                    - "Reporte de Accidentes/Incidentes", // Generar los reportes / Ver lista
                    - "Reporte de Novedad",               // Generar los reportes / Ver lista
                    - "Cargue de Archivos",               // Cargar Archivos mapa de procesos / Editar identidad corporativa / Actualizar Video / Actualizar Noticias / Agregar Links / Registrar Usuarios
                ]
            },
        
            "Gerencia" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de todos los procesos dentro del mapa
                    - "Horarios",                         // Generar Horarios para unidad de Gerencia y asistente de gerencia / edicion de horarios generados
                    - "Reporte de Novedad",               // Generar los reportes / Ver lista
                ]
            },
        
            "Asistente Administrativa" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Destion Administrativa dentro del mapa de proceso
                    - "Horarios",                         // Visualizar horarios puestos por gerencia hacia ella
                ]
            },
        
            "Gestion Humana" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion Humana dentro del mapa de procesos
                    - "Reporte de Accidentes/Incidentes", // Generar los reportes / Ver lista
                    - "Horarios",                         // Generar Horarios para unidad de Gestion Humana
                    - "Reporte de Novedad",               // Generar los reportes / Ver lista
                ]
            },
        
            "Contabilidad" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion Administrativa dentro del mapa de procesos
                    - "Horarios",                         // Generar Horarios para la unidad de contabilidad
                ]
            },
        
            "Tencologia" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion TI dentro del mapa de procesos
                    - "Horarios",                         // Generar Horarios para la unidad de tecnologia
                ]
            },
        
            "Coordinadores" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion de Operaciones dentro del mapa de procesos
                    - "Links",                            // Vista de los links de todas las campañas
                    - "Horarios",                         // Generar Horarios propios / Vista y edicion de los horarios de todas las campañas
                ]
            },
        ]
    ],
    
    "Coordinadores" = [
        "Unidades" = [
            "Gestion Documental" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion Documental y Gestion de operaciones dentro del mapa de porcesos
                    - "Links",                            // Vista de Links propios de su unidad (Gestion Documental)
                    - "Horarios",                         // Generar y editar Horarios para su unidad (Gestion Documental)
                ]
            },
    
            "Cartera Propia" = {
                "Vistas": [
                    - "Mapa de Procesos",                 // Vista de Gestion de Operaciones dentro del mapa de procesos
                    - "Links",                            // Vista de Links propios de su unidad (Cartera Propia)
                    - "Horarios",                         // Generar y editar Horarios para su unidad (Cartera propia)
                ]
            },
    
            "Colsubsidio" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion de Operaciones dentro del mapa de procesos
                    - "Links",                            // Vista de Links propios de su unidad (Colsubsidio)
                    - "Horarios",                         // Generar y editar Horarios para su unidad (Colsubsidio)
                ]
            },
    
            "Claro" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion de Operaciones dentro del mapa de procesos
                    - "Links",                            // Vista de Links propios de su unidad (Claro)
                    - "Horarios",                         // Generar y editar Horarios para su unidad (Claro)
                ]
            },
    
            "Credivalores" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion de Operaciones dentro del mapa de procesos
                    - "Links",                            // Vista de Links propios de su unidad (Credivalores)
                    - "Horarios",                         // Generar y editar Horarios para su unidad (Credivalores)
                ]
            },
    
            "Santander" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion de Operaciones dentro del mapa de procesos
                    - "Links",                            // Vista de Links propios de su unidad (Santander)
                    - "Horarios",                         // Generar y editar Horarios para su unidad (Santander)
                ]
            },
    
            "Vanti" = {
                "Vistas": [
                    - "Mapa de procesos",                 // Vista de Gestion de Operaciones dentro del mapa de procesos
                    - "Links",                            // Vista de Links propios de su unidad (Vanti)
                    - "Horarios",                         // Generar y editar Horarios para su unidad (Vanti)
                ]
            }
        ]
    ],
    
    "Asesores" = [
        "Unidades" = [
            "Calidad" = {
                "Vistas": [
                    - "Links",                            // No ver los links
                    - "Horarios",                         // Vista de los horarios generados por el coordinador de su unidad
                ]
            }, 

            "Gestion Documental" = {
                "Vistas": [
                    - "Links",                            // Vista de Links propios de su unidad (Gestion Documental)
                    - "Horarios"                          // Vista de los horarios generados por el coordinador de su unidad
                ]
            },
    
            "Formacion" = {
                "Vistas": [
                    - "Links",                            // Vista de los Links de todas las campañas
                    | "Horarios",                         // Generar y editar horarios para su unidad (Formacion)
                ]
            }, 
    
            "Cartera Propia" = {
                "Vistas": [
                    - "Links",                            // Vista de Links propios de su unidad (Cartera Propia)
                    - "Horarios",                         // Vista de los horarios generados por el coordinador de su unidad
                ]
            },
    
            "Colsubsidio" = {
                "Vistas": [
                    - "Links",                            // Vista de Links propios de su unidad (Colsubsidio)
                    - "Horarios",                         // Vista de los horarios generados por el coordinador de su unidad
                ]
            },
    
            "Claro" = {
                "Vistas": [
                    - "Links",                            // Vista de Links propios de su unidad (Claro)
                    - "Horarios",                         // Vista de los horarios generadod por el coordinador de su unidad
                ]
            },
    
            "Credivalores" = {
                "Vistas": [
                    - "Links",                            // Vista de Links propios de su unidad (Credivalores)
                    - "Horarios",                         // Vista de los horarios generados por el coordinador de su unidad
                ]
            },
    
            "Santander" = {
                "Vistas": [
                    - "Links",                            // Vista de Links propios de su unidad (Santander)
                    - "Horarios",                         // Vista de los horarios generados por el coordinador de su unidad
                ]
            },
            
            "Vanti" = {
                "Vistas": [
                    - "Links",                            // Vista de Links propios de su unidad (Vanti)
                    - "Horarios",                         // Vista de los horarios generados por el coordinador de su unidad
                ]
            },
    
            "Otro" = {
                "Vistas": [
                    - "Horarios",                         // Horarios asignados // Revision
                ]
            }
        ]
    ]
]




