<p class="display-5">
    Bienvenue dans le backOffice <strong>d'une école 100% en ligne formant des développeurs Web</strong>...
</p>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="./index.html">School</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.html">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('teacher-list')  ?>">Profs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('student-list')  ?>">Etudiants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('user-list')  ?>">Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>