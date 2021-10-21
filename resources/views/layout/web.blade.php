<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <title>Médiathèque - @yield('title')</title>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url("/") }}">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            @if(Auth::guard('admin')->check())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/admin/dashboard') }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/admin/confirm') }}">Confirmer les emprunts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/admin/books/add') }}">Ajouter un livre</a>
                                </li>
                            @elseif(Auth::check())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/books') }}">
                                        Livres
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/owned') }}">
                                        Mes emprunts
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @if(Auth::guard('admin')->check() || Auth::check())
                        <form method="POST" action="/logout">
                            @csrf
                            @method("delete")
                            <button class="btn btn-danger" type="submit" id="logout-btn">Se déconnecter</button>
                        </form>
                    @else
                        <div class="row">
                            <div class="dropdown col">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="registerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    S'inscrire
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="registerDropdown">
                                    <li><a class="dropdown-item" href="{{ url('/register?type=employee') }}">Employé</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/register?type=user') }}">Habitant</a></li>
                                </ul>
                            </div>
                            <a role="button" href="{{ url('/login') }}" class="btn btn-primary col">Se connecter</a>
                        </div>
                    @endif
                </div>
            </div>
        </nav>
        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                crossorigin="anonymous">
        </script>
    </body>
<style>
    .title {
        text-align: center;
    }

    .cover {
        max-height: 300px;
    }
</style>
</html>


