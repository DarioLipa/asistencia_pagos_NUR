<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <head lang="es">
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
        <meta content="ie=edge" http-equiv="x-ua-compatible">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>
            @yield('titulo', 'inicio')
        </title>

        {{-- token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
        <link href="{{ asset('app/publico/css/lib/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet"
            integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('app/publico/css/lib/lobipanel/lobipanel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/publico/css/separate/vendor/lobipanel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/publico/css/lib/jqueryui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/publico/css/separate/pages/widgets.min.css') }}">

        {{-- font awesome --}}
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/fontawesome.min.css') }}">

        {{-- datatables --}}
        <link rel="stylesheet" href="{{ asset('app/publico/css/lib/datatables-net/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/publico/css/separate/vendor/datatables-net.min.css') }}">

        <link href="{{ asset('app/publico/css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('app/publico/css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('app/publico/css/mis_estilos/estilos.css') }}" rel="stylesheet">

        {{-- form --}}
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app/publico/css/lib/jquery-flex-label/jquery.flex.label.css') }}"> <!-- Original -->

        {{-- mis estilos --}}
        <link href="{{ asset('principal/css/estilos.css') }}" rel="stylesheet">

        {{-- pNotify --}}
        <link href="{{ asset('pnotify/css/pnotify.css') }}" rel="stylesheet" />
        <link href="{{ asset('pnotify/css/pnotify.buttons.css') }}" rel="stylesheet" />
        <link href="{{ asset('pnotify/css/custom.min.css') }}" rel="stylesheet" />

        {{-- google fonts --}}
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

        {{-- pnotify --}}
        <script src="{{ asset('pnotify/js/jquery.min.js') }}"></script>
        <script src="{{ asset('pnotify/js/pnotify.js') }}"></script>
        <script src="{{ asset('pnotify/js/pnotify.buttons.js') }}"></script>

        {{-- alpine js --}}
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        {{-- chart js --}}
        <script src="{{ asset('chart/chart.js') }}"></script>

        <style>
            .marca {
                width: 100%;
                background: rgb(13, 39, 48);
                position: fixed;
                bottom: 0;
                z-index: 999;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 10px;
            }

            .marca__parrafo {
                margin: 0 !important;
                color: white;
            }

            .marca__texto {
                color: rgb(0, 162, 255);
                text-decoration: underline;
            }

            .marca__parrafo span {
                color: red;
            }

            /* poner un color a inputs readonl */
            input[readonly] {
                background-color: #eee !important;
                cursor: not-allowed !important;
            }
        </style>
        @laravelPWA

    </head>
</head>

<body class="with-side-menu">

    <!-- Modal -->
    <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Ingrese el DNI del padre de familia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="height: 100px;overflow: auto;">
                    <input autofocus type="number" id="dniPadre" placeholder="DNI"
                        class="form-control form-control-lg">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="" id="buscar" class="btn btn-primary">Buscar</a>
                </div>
            </div>
        </div>
    </div>


    <div id="app">

        <header class="site-header">
            <div class="container-fluid" style="padding-left: 40px;">

                <a href="#" class="site-logo">

                </a>

                <button id="show-hide-sidebar-toggle" class="show-hide-sidebar menu">
                    <span>toggle menu</span>
                </button>

                <button class="hamburger hamburger--htla">
                    <span>toggle menu</span>
                </button>
                <div class="site-header-content">
                    <div class="site-header-content-in">
                        <div class="site-header-shown">

                            <div class="dropdown dropdown-notification">
                                <h6 class="mt-2 nomTipo">
                                    {{ Auth::user()->usuario }}
                                </h6>
                            </div>

                            <div class="dropdown user-menu">
                                <button class="dropdown-toggle" id="dd-user-menu" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if (Auth::user()->foto == null)
                                        <img src="{{ asset('app/publico/img/user.svg') }}" alt="">
                                    @else
                                        <img src="data:image/jpg;base64,<?= base64_encode(Auth::user()->foto) ?>"
                                            alt="">
                                    @endif
                                </button>
                                <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="dd-user-menu">

                                    <h5 class="p-2 text-center nomInfo">{{ Auth::user()->nombres }}</h5>
                                    <a class="dropdown-item" href="{{ route('perfil.index') }}"><span
                                            class="font-icon glyphicon glyphicon-user"></span>Perfil</a>
                                    <a class="dropdown-item" href="{{ route('clave.index') }}"><span
                                            class="font-icon glyphicon glyphicon-lock"></span>Cambiar contraseña</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        <span class="font-icon glyphicon glyphicon-log-out"></span>salir
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--.site-header-shown-->

                        <div class="mobile-menu-right-overlay"></div>
                        <div class="site-header-collapsed">

                        </div>
                        <!--.site-header-collapsed-->
                    </div>
                    <!--site-header-content-in-->
                </div>
                <!--.site-header-content-->
            </div>
            <!--.container-fluid-->
        </header>

        <div class="mobile-menu-left-overlay">
        </div>
        <nav class="side-menu">

            <ul class="side-menu-list p-0">
                <li class="red">
                    <a href="{{ route('home') }}" class="{{ Request::is('home*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/house.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-house-user"></i> --}}
                        <span class="lbl">INICIO</span>
                    </a>
                </li>

                <li class="red">
                    <a href="{{ route('cargos.index') }}" class="{{ Request::is('cargos*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/cargo.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-house-user"></i> --}}
                        <span class="lbl">CARGOS</span>
                    </a>
                </li>


                <li class="grey with-sub {{ Request::is('escaner*') ? 'opened' : '' }}">
                    <span>
                        <img src="{{ asset('img-inicio/qr.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-sort-amount-up-alt"></i> --}}
                        <span class="lbl">SCANEAR</span>
                    </span>
                    <ul>
                        @foreach ($reunionActivo as $item)
                            <li>
                                <a href="{{ route('escaner.show', $item->id_reunion) }}"
                                    class="{{ Request::is('scaner*') ? 'activo' : '' }} ">
                                    <i class="fas fa-angle-double-down"></i>
                                    <span class="lbl">{{ $item->titulo }}</span>
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </li>

                <li class="grey with-sub {{ Request::is('padres-familia*') ? 'opened' : '' }}">
                    <span>
                        <img src="{{ asset('img-inicio/padres.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-sort-amount-up-alt"></i> --}}
                        <span class="lbl">PADRES DE FAMILIA</span>
                    </span>
                    <ul>
                        <li>
                            <a href="{{ route('padres-familia.create') }}"
                                class="{{ Request::is('padres-familia/create*') ? 'activo' : '' }}">
                                <i class="fas fa-plus-square icono-submenu"></i>
                                <span class="lbl">Nuevo registro</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('padres-familia.index') }}"
                                class="{{ Request::is('padres-familia') ? 'activo' : '' }}">
                                <i class="fas fa-th-list icono-submenu"></i>
                                <span class="lbl">Lista de padres</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="" class="{{ Request::is('cita-index*') ? 'activo' : '' }}">
                                <i class="fas fa-search icono-submenu"></i>
                                <span class="lbl">Buscar deudas</span>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                <li class="red">
                    <a href="{{ route('estudiantes.index') }}"
                        class="{{ Request::is('estudiante*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/estudio.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-house-user"></i> --}}
                        <span class="lbl">ESTUDIANTES</span>
                    </a>
                </li>

                {{-- <li class="red">
                    <a href="{{ route('home') }}" class="{{ Request::is('asistencia*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/ausencia.png') }}" class="img-inicio" alt="">
                        <span class="lbl">ASISTENCIAS</span>
                    </a>
                </li> --}}

                <li class="red">
                    <a href="{{ route('reuniones.index') }}"
                        class="{{ Request::is('reuniones*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/asistencia.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-house-user"></i> --}}
                        <span class="lbl">REUNIONES</span>
                    </a>
                </li>

                <li class="red">
                    <a href="{{ route('aportes.index') }}" class="{{ Request::is('aporte*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/aporte.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-house-user"></i> --}}
                        <span class="lbl">APORTES</span>
                    </a>
                </li>

                <li class="red">
                    <a href="" data-toggle="modal" data-target="#modal"
                        class="{{ Request::is('pagos*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/pago.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-house-user"></i> --}}
                        <span class="lbl">PAGOS</span>
                    </a>
                </li>


                <li class="red">
                    <a href="{{ route('historial.index') }}"
                        class="{{ Request::is('historial*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/deuda.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-house-user"></i> --}}
                        <span class="lbl">HISTORIAL</span>
                    </a>
                </li>

                <li class="red">
                    <a href="{{ route('usuarios.index') }}" class="{{ Request::is('usuarios*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/usuario.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-house-user"></i> --}}
                        <span class="lbl">USUARIOS</span>
                    </a>
                </li>


                <li class="red">
                    <a href="{{ route('empresa.index') }}" class="{{ Request::is('empresa*') ? 'activo' : '' }}">
                        <img src="{{ asset('img-inicio/info.png') }}" class="img-inicio" alt="">
                        {{-- <i class="fas fa-exclamation"></i> --}}
                        <span class="lbl">ACERCA DE LA I.E</span>
                    </a>
                </li>

            </ul>
        </nav>

        <div class="page-content mt-5">
            @yield('content')
        </div>
    </div>



    <script src="{{ asset('bootstrap5/js/popper.min.js') }}"
        integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
        integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
    </script>


    <script src="{{ asset('app/publico/js/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('app/publico/js/lib/tether/tether.min.js') }}"></script>
    <script src="{{ asset('app/publico/js/lib/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('app/publico/js/plugins.js') }}"></script>

    {{-- datatables --}}
    <script src="{{ asset('app/publico/js/lib/datatables-net/datatables.min.js') }}"></script>



    {{-- sweet alert --}}
    <script src="{{ asset('sweet/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('sweet/js/sweet.js') }}"></script>


    <script>
        $(function() {
            var table;
            // Verificar si DataTables ya está inicializado en la tabla
            if ($.fn.DataTable.isDataTable('#example')) {
                // Si ya está inicializado, usa la instancia existente
                table = $('#example').DataTable();
            } else {

            }
            table = $('#example').DataTable({
                select: {
                    //style: 'multi'
                },
                paging: true,
                columnDefs: [{
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }],
                responsive: true,
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Registros del _START_ al _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Registros del 0 al 0 de 0 registros",
                    "sInfoFiltered": "-",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });
            $('#todos').click(function() {
                // Obtener el estado actual del checkbox "Seleccionar todo"
                var selectAllChecked = $(this).prop('checked');

                // Seleccionar/deseleccionar todas las casillas de verificación en todas las páginas de la tabla
                table.$('.select-item').prop('checked', selectAllChecked);
            });

        });


        $(function() {
            $('#example2').DataTable({
                select: {
                    //style: 'multi'
                },
                columnDefs: [{
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }],
                responsive: true,
                "language": {
                    "sProcessing": "Procesando...",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Registros del _START_ al _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Registros del 0 al 0 de 0 registros",
                    "sInfoFiltered": "-",
                    "sInfoPostFix": "",
                    "sSearch": "", // Quitamos la opción de búsqueda
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                },
                "lengthChange": false, // Ocultar la opción de cambiar la cantidad de registros por página
                "searching": false // Ocultar la barra de búsqueda
            });
        });

        $(function() {
            $('#example3').DataTable({
                select: {
                    //style: 'multi'
                },
                columnDefs: [{
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }],
                responsive: true,
                "language": {
                    "sProcessing": "Procesando...",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Registros del _START_ al _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Registros del 0 al 0 de 0 registros",
                    "sInfoFiltered": "-",
                    "sInfoPostFix": "",
                    "sSearch": "", // Quitamos la opción de búsqueda
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                },
                "lengthChange": false, // Ocultar la opción de cambiar la cantidad de registros por página
                "searching": false // Ocultar la barra de búsqueda
            });
        });
    </script>


    <script type="text/javascript" src="{{ asset('app/publico/js/lib/jqueryui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/publico/js/lib/lobipanel/lobipanel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/publico/js/lib/match-height/jquery.matchHeight.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('loader/loader.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('.panel').lobiPanel({
                sortable: true
            });
            $('.panel').on('dragged.lobiPanel', function(ev, lobiPanel) {
                $('.dahsboard-column').matchHeight();
            });

            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'Day');
                dataTable.addColumn('number', 'Values');
                // A column for custom tooltip content
                dataTable.addColumn({
                    type: 'string',
                    role: 'tooltip',
                    'p': {
                        'html': true
                    }
                });
                dataTable.addRows([
                    ['MON', 130, ' '],
                    ['TUE', 130, '130'],
                    ['WED', 180, '180'],
                    ['THU', 175, '175'],
                    ['FRI', 200, '200'],
                    ['SAT', 170, '170'],
                    ['SUN', 250, '250'],
                    ['MON', 220, '220'],
                    ['TUE', 220, ' ']
                ]);

                var options = {
                    height: 314,
                    legend: 'none',
                    areaOpacity: 0.18,
                    axisTitlesPosition: 'out',
                    hAxis: {
                        title: '',
                        textStyle: {
                            color: '#fff',
                            fontName: 'Proxima Nova',
                            fontSize: 11,
                            bold: true,
                            italic: false
                        },
                        textPosition: 'out'
                    },
                    vAxis: {
                        minValue: 0,
                        textPosition: 'out',
                        textStyle: {
                            color: '#fff',
                            fontName: 'Proxima Nova',
                            fontSize: 11,
                            bold: true,
                            italic: false
                        },
                        baselineColor: '#16b4fc',
                        ticks: [0, 25, 50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325, 350],
                        gridlines: {
                            color: '#1ba0fc',
                            count: 15
                        }
                    },
                    lineWidth: 2,
                    colors: ['#fff'],
                    curveType: 'function',
                    pointSize: 5,
                    pointShapeType: 'circle',
                    pointFillColor: '#f00',
                    backgroundColor: {
                        fill: '#008ffb',
                        strokeWidth: 0,
                    },
                    chartArea: {
                        left: 0,
                        top: 0,
                        width: '100%',
                        height: '100%'
                    },
                    fontSize: 11,
                    fontName: 'Proxima Nova',
                    tooltip: {
                        trigger: 'selection',
                        isHtml: true
                    }
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                chart.draw(dataTable, options);
            }
            $(window).resize(function() {
                drawChart();
                setTimeout(function() {}, 1000);
            });
        });
    </script>
    <script src="{{ asset('app/publico/js/app.js') }}"></script>

    {{-- form --}}
    <script src="{{ asset('app/publico/js/lib/jquery-flex-label/jquery.flex.label.js') }}"></script>

    <script type="application/javascript">
        (function ($) {
        $(document).ready(function () {
            $('.fl-flex-label').flexLabel();
        });
    })(jQuery);
    </script>


    <script>
        let dniPadre = document.getElementById("dniPadre");
        dniPadre.addEventListener("input", function() {
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8)
            }
        })

        let buscar = document.getElementById("buscar");
        buscar.addEventListener("click", function(e) {
            e.preventDefault();
            let dniPadre = document.getElementById("dniPadre").value;
            if (dniPadre == "") {
                alert("Ingrese su DNI");
            } else {
                document.location.href = `{{ route('pagos.show', '') }}/${dniPadre}`
            }
        })

        //ejecutar funcion al hacer enter en el input dniPadre
        dniPadre.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                buscar.click();
            }
        });
    </script>






</body>

</html>
