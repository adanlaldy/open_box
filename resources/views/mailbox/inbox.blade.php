<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boîte de réception - Open Box</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="http://127.0.0.1:8000/css/mail.css" rel="stylesheet" />
</head>
<body>
<main>
    <!-- Top Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-between align-items-center container-fluid-custom">
            <!-- menu hamburger -->
            <nav class="navbar navbar-light bg-light d-lg-none">
                <div class="container-fluid">
                    <button class="navbar-toggler custom-toggler" type="button" onclick="toggleSidebar()">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <form class="form-inline my-2 my-lg-0 mx-auto">
                <div class="input-group center">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success " type="submit">Search</button>
                </div>
            </form>

            <div class="navbar-nav d-lg-flex flex-row align-items-center">
                <ul class="navbar-nav d-flex flex-row">
                    <li class="nav-item d-lg-block d-none"><a class="nav-link" href="/offers">{{ $language->page_inbox['subscription'] }}</a></li>
                    <li class="nav-item d-lg-block d-none"><a class="nav-link" href="/parameters">{{ $language->page_inbox['parameters'] }}</a></li>
                </ul>
                <form action="{{route('auth.logout')}}" method="post"> <!-- Suppression de la classe "ms-3" pour centrer correctement le bouton sur mobile -->
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-link nav-item d-lg-block d-none">{{ $language->page_inbox['logout'] }}</button>
                </form>
            </div>
        </div>

    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-between align-items-center container-fluid-custom">
            <h1 class="form-inline my-2 my-lg-0 margin-50">Boîte de réception</h1>
        </div>
    </nav>
    <!-- Sidebar -->
    <div class="sidebar">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <nav>
            <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none margin-20" href="/inbox">Open Box <?php echo Auth::user()->email; ?></a>
            <hr class="bar-menu">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item d-lg-none"><a class="nav-link" href="/offers">{{ $language->page_inbox['subscription'] }}</a></li> <!-- Ajout de la classe "d-lg-none" pour cacher en mode PC -->
                <hr class="bar-menu nav-item d-lg-none">
                <li class="nav-item"><a class="nav-link active margin-20" href="/inbox">{{ $language->page_inbox['inbox'] }}</a></li>
                <li><a class="nav-link link-body-emphasis" href="/draft">{{ $language->page_inbox['draft'] }}</a></li>
                <li><a class="nav-link link-body-emphasis" href="/sent">{{ $language->page_inbox['sent'] }}</a></li>
                <li><a class="nav-link link-body-emphasis" href="/starred">{{ $language->page_inbox['star'] }}</a></li>
                <li><a class="nav-link link-body-emphasis" href="/archive">{{ $language->page_inbox['archive'] }}</a></li>
                <li><a class="nav-link link-body-emphasis" href="/spam">{{ $language->page_inbox['spam'] }}</a></li>
                <li><a class="nav-link link-body-emphasis" href="/trash">{{ $language->page_inbox['trash'] }}</a></li>
                <li><a class="nav-link link-body-emphasis" href="/all_mail">{{ $language->page_inbox['all_mail'] }}</a></li>
                <hr class="bar-menu nav-item d-lg-none">
                <li class="nav-item d-lg-none"><a class="nav-link " href="/parameters">{{ $language->page_inbox['parameters'] }}</a></li>
                <hr class="bar-menu nav-item d-lg-none">
                <form action="{{route('auth.logout')}}" method="post" class="nav-item d-lg-none">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-link">{{ $language->page_inbox['logout'] }}</button>
                </form>
            </ul>
        </nav>
    </div>
    <div class="overlay"></div>
    <!-- Contenu mail -->
    <article>
        <ul>
            @forelse($inboxEmails as $email)
            <div class="row">
                <div class="col">
                    <div class="form-check" id="{{ $email->id }}">
                        <input class="form-check-input" type="checkbox" value="" id="$email">
                        <label class="form-check-label" for="$email">
                            {{ $email->id }}
                        </label>
                    </div>
                </div>
                <div class="col">{{ $email->from_user_id }}</div>
                <div class="col">{{ $email->subject }}</div>
                <div class="col">{{ $email->sent_at }}</div>
                <div class="col">
                    <form action="/add-to-starreds" method="post">
                        @csrf
                        <input type="hidden" name="email_id" value="{{ $email->id }}">
                        <button type="submit" class="btn btn-outline-primary">{{ $language->page_inbox['starred'] }}</button>
                    </form>
                    <form action="/add-to-archives" method="post">
                        @csrf
                        <input type="hidden" name="email_id" value="{{ $email->id }}">
                        <button type="submit" class="btn btn-outline-info">{{ $language->page_inbox['archived'] }}</button>
                    </form>
                    <form action="/add-to-trashes" method="post">
                        @csrf
                        <input type="hidden" name="email_id" value="{{ $email->id }}">
                        <button type="submit" class="btn btn-outline-danger">{{ $language->page_inbox['delete'] }}</button>
                    </form>
                </div>
            </div>
            <hr>
        @empty
            <h2 class='text-center'>{{ $language->page_inbox['empty'] }}</h2>
            <div class="testeu">
                <img style='; width: 500px;' src='http://127.0.0.1:8000/images/mail.png' class='img-fluid' alt='Aucun message'>
            </div>
        @endforelse
    </ul>
    </article>
    <button class="btn btn-primary mt-3 static" id="new_email">Nouveau message</button>
    <dialog id="dialog">
        <div class="container mt-3">
            <h3>Créer un nouveau message</h3>
            <button class="btn btn-primary mt-3 static" id="close_email">Close</button> <
            <form action="/post-email" method="post">
                @csrf
                <div class="form-group">
                    <label for="from">Expéditeur :</label>
                    <input name="fromEmail" type="email" class="form-control" id="from" placeholder="Votre adresse email" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="to">Destinataire :</label>
                    <input name="toEmail" type="email" class="form-control" id="to" placeholder="Adresse email">
                </div>
                <div class="form-group">
                    <label for="cc">CC :</label>
                    <input name="ccEmail" type="email" class="form-control" id="cc" placeholder="Adresse email">
                </div>
                <div class="form-group">
                    <label for="bcc">CCI :</label>
                    <input name="bccEmail" type="email" class="form-control" id="bcc" placeholder="Adresse email">
                </div>
                <div class="form-group">
                    <label for="subject">Objet :</label>
                    <input name="subject" type="text" class="form-control" id="subject" placeholder="Objet de l'email">
                </div>
                <div class="form-group">
                    <label for="content">Contenu :</label>
                    <textarea name="content" class="form-control" id="content" rows="5" placeholder="Contenu de l'email"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </dialog>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');
            sidebar.classList.toggle('active');
            overlay.style.display = (sidebar.classList.contains('active')) ? 'block' : 'none';
        }

        document.querySelector('.overlay').addEventListener('click', function() {
            toggleSidebar(); // Désactiver le menu
        });

        // open or close the dialog
        const dialog = document.getElementById('dialog');
        const new_email = document.getElementById('new_email');
        const close_email = document.getElementById('close_email');

        new_email.addEventListener('click', function() {
            dialog.showModal();
        });

        close_email.addEventListener('click', function() {
            dialog.close();
        });
    </script>
</main>
</body>
</html>
