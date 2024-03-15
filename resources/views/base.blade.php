<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/app.css">
    <script src="js/app.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="/images/mydil.webp" alt="Logo du MyDIL" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Projets</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        {{ \Illuminate\Support\Facades\Auth::user()->pseudonyme }}
                        <form action="{{ route('auth.logout') }}" method="post" class="nav-item">
                            @method('delete')
                            @csrf
                            <input type="submit" value="Se déconnecter" class="nav-link">
                        </form>
                    @endauth
                    @guest
                        <div class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login') }}">Se connecter</a>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>
    </header>
</body>
</html>
