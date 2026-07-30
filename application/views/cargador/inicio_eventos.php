<!DOCTYPE html>

<html lang="es">
<head>
    <title>Eventos</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/modal-form.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/intervenciones2.css"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

    <style type="text/css">
        /* Contenedor de las tarjetas */
        .card-evento {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 250px;
            cursor: pointer;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-evento:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        /* Ícono - SIEMPRE VISIBLE */
        .card-evento .imagen {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 45%;
            transition: all 0.5s ease;
            z-index: 1;
        }

        /* Al hacer hover, el ícono se achica un poco */
        .card-evento:hover .imagen {
            background-size: 35%;
            opacity: 0.2;
        }

        /* TELÓN - INICIALMENTE ABIERTO (no visible) */
        .card-evento .telon {
            position: absolute;
            left: 0;
            width: 100%;
            height: 0%;  
            background: rgba(0, 0, 0, 0.85);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }

        .card-evento .telon-superior {
            top: 0;
            border-radius: 12px 12px 0 0;
        }

        .card-evento .telon-inferior {
            bottom: 0;
            border-radius: 0 0 12px 12px;
        }

        /* AL HACER HOVER - El telón se CIERRA (cubre el ícono) */
        .card-evento:hover .telon-superior {
            height: 50%;  /* ← Baja desde arriba */
        }

        .card-evento:hover .telon-inferior {
            height: 50%;  /* ← Sube desde abajo */
        }

        /* Texto del título - INICIALMENTE OCULTO */
        .card-evento .titulo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            color: white;
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
            opacity: 0;  /* ← INICIALMENTE OCULTO */
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 3;
            text-align: center;
            width: 90%;
            pointer-events: none;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 2px;
        }

        .card-evento .titulo small {
            display: block;
            font-size: 0.9rem;
            font-weight: 300;
            opacity: 0.8;
            margin-top: 5px;
        }

        /* AL HACER HOVER - El título aparece */
        .card-evento:hover .titulo {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        /* Colores de fondo para cada evento */
        .card-evento.copro {
            background-color: #cc7731;
        }
        .card-evento.copro .imagen {
            background-image: url('/iiet/assets/images/ic_microscopio.svg');
        }

        .card-evento.sangre {
            background-color: #dc3545;
        }
        .card-evento.sangre .imagen {
            background-image: url('/iiet/assets/images/ic_sangre.svg');
        }

        .card-evento.biologmolec {
            background-color: #28a745;
        }
        .card-evento.biologmolec .imagen {
            background-image: url('/iiet/assets/images/ic_adn.svg');
        }

        .card-evento.tratamiento {
            background-color: #007bff;
        }
        .card-evento.tratamiento .imagen {
            background-image: url('/iiet/assets/images/ic_pastillas.svg');
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-evento {
                min-height: 200px;
                margin-bottom: 20px;
            }

            .card-evento .titulo {
                font-size: 1.5rem;
            }

            .card-evento .imagen {
                background-size: 35%;
            }
        }

        @media (max-width: 576px) {
            .card-evento {
                min-height: 150px;
            }

            .card-evento .titulo {
                font-size: 1.2rem;
            }

            .card-evento .titulo small {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>

<header class="mb-4">
    <div class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <h2 class="col-6 mb-0">Eventos</h2>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="links" class="col-6 navbar-collapse collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/iiet/inicio/operario"><span class="fa fa-arrow-circle-left mr-1"></span> Volver a Inicio</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<section id="contenedor" class="container-fluid pr-5 pl-5">
    <div class="row justify-content-center h-100 align-items-center">
        
        <!-- COPRO -->
        <div class="col-md-3 col-sm-6 mb-3" style="height: 75vh;">
            <a href="/iiet/eventos/copro" class="card-evento copro d-block">
                <div class="imagen"></div>
                <div class="telon telon-superior"></div>
                <div class="telon telon-inferior"></div>
                <div class="titulo">
                    Coproparasitológico
                    <small>Análisis de muestras</small>
                </div>
            </a>
        </div>

        <!-- SANGRE -->
        <div class="col-md-3 col-sm-6 mb-3" style="height: 75vh;">
            <a href="/iiet/eventos/sangre" class="card-evento sangre d-block">
                <div class="imagen"></div>
                <div class="telon telon-superior"></div>
                <div class="telon telon-inferior"></div>
                <div class="titulo">
                    Sangre
                    <small>Análisis hematológicos</small>
                </div>
            </a>
        </div>

        <!-- BIOLOGÍA MOLECULAR -->
        <div class="col-md-3 col-sm-6 mb-3" style="height: 75vh;">
            <a href="/iiet/eventos/biologia_molecular" class="card-evento biologmolec d-block">
                <div class="imagen"></div>
                <div class="telon telon-superior"></div>
                <div class="telon telon-inferior"></div>
                <div class="titulo">
                    Biología Molecular
                    <small>Estudios genéticos</small>
                </div>
            </a>
        </div>

        <!-- TRATAMIENTO -->
        <div class="col-md-3 col-sm-6 mb-3" style="height: 75vh;">
            <a href="/iiet/eventos/tratamiento" class="card-evento tratamiento d-block">
                <div class="imagen"></div>
                <div class="telon telon-superior"></div>
                <div class="telon telon-inferior"></div>
                <div class="titulo">
                    Tratamiento
                    <small> medicación</small>
                </div>
            </a>
        </div>

    </div>
</section>

<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script>
    // Ajustar altura del contenedor
    $('#contenedor').height(window.innerHeight - $('#contenedor').offset().top);
</script>

</body>
</html>