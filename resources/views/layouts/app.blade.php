<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Modulo Administrativo') }}</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!--Estilo tabla-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

    <!-- Styles -->
    <style>
        /* Aquí puedes agregar estilos personalizados si es necesario */
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @guest
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Modulo Administrativo') }}
                    </a>
                @else
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'Modulo Administrativo') }}
                    </a>
                @endguest
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <!-- Puedes añadir elementos de menú aquí -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0">
    <!-- Authentication Links -->
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
        </li>
        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
            </li>
        @endif
    @else
        <li class="nav-item dropdown">
                 <!-- Mostrar botón adicional si el usuario es admin -->
        @if(Auth::check() && Auth::user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Administrar Usuarios</a>
            </li>
        @endif
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Cerrar sesión') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>

   
    @endguest
</ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Bundle from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Jquary 3.*-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- tablas -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        // Función para eliminar el usuario
        function deleteUser(userId) {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/users/' + userId,
                type: 'DELETE',
                success: function(result) {
                    // Recargar la página actual
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error al eliminar el usuario:', errorThrown);
                }
            });
        }

        // Escuchar el clic en el botón Delete
        $('#myTable').on('click', '.delete-btn', function() {
            var userId = $(this).data('id');
            // Mostrar SweetAlert para confirmar la eliminación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Llamar a la función para eliminar el usuario
                    deleteUser(userId);
                }
            });
        });
         // Configuración en español para DataTable
         $.extend(true, $.fn.dataTable.defaults, {
            language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        // Inicialización de DataTable
        $.ajax({
            url: "http://127.0.0.1:8000/api/users",
            type: "GET",
            success: function(data) {
                $('#myTable').DataTable({
                    data: data,
                    columns: [
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'role' },
                        {
                            data: null,
                            className: "center",
                            render: function(data, type, row) {
                                return '<a href="/users/edit/' + row.id + '" class="btn btn-warning">Edit</a> ' +
                                    '<button class="btn btn-danger delete-btn" data-id="' + row.id + '">Delete</button>';
                            }
                        }
                    ]
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error al obtener los usuarios:', errorThrown);
            }
        });
    });
</script>


</body>
</html>
