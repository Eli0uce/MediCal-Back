<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MediCal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script src='fullcalendar/core/index.global.js'></script>
    <script src='fullcalendar/core/locales/fr.global.js'></script>
    <link href="/css/style.css" rel="stylesheet" />
    <script>
        var rendezvous = @json($rendezvous);
    </script>
    <script src="/js/fullCalendar.js"></script>
</head>

<body>
    <!-- Barre de navigation -->
    <header class="bg-blue-custom py-4 px-20 flex items-center justify-between">
        <!-- Logo à gauche -->
        <div>
            <a href="/" class="flex items-center">
                <img src="/images/logo.png" alt="Logo" class="w-8 h-8 mr-2" />
                <span class="text-white text-xl font-semibold">MediCal</span>
            </a>
        </div>

        <!-- Bouton de connexion à droite -->
        @guest
            <a href="#" class="text-white text-xl font-medium" id="open-login-modal"><i class="fa-solid fa-user"></i>
                <span class="hidden sm:inline">Connexion</span></a>
        @else
            <a href="{{ route('logout') }}" class="text-white text-xl font-medium" id="open-rdv-modal"><i
                    class="fa-solid fa-calendar"></i>
                <span class="hidden sm:inline">Se déconnecter</span></a>
        @endguest
    </header>

    <!-- Carte modale de connexion -->
    <div class="modal hidden mx-auto fixed inset-0 flex items-center justify-center mt-52 z-50" id="login-modal">
        <div class="modal-content bg-gray-custom w-96 mx-auto rounded-lg shadow-lg p-6">
            <span class="close-modal absolute top-2 right-2 cursor-pointer hover:gray-custom">
                &times;
            </span>
            <h2 class="text-2xl font-semibold mb-4 text-white">Connexion</h2>
            <!-- Ajoutez ici votre formulaire de connexion ou d'autres éléments -->
            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-white">Identifiant</label>
                    <input type="email" id="email" name="email"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-white">Mot de passe</label>
                    <input type="password" id="password" name="password"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" />
                </div>
                <button type="submit"
                    class="bg-blue-custom text-white rounded-full py-2 px-4 hover:bg-blue-custom focus:outline-none focus:ring focus:ring-blue-300">
                    Se connecter
                </button>
                <!-- add Retour button -->
                <button class="return bg-gray-custom text-white rounded-full py-2 px-4 hover:bg-gray-custom">
                    Retour
                </button>
            </form>
        </div>
    </div>

    <!-- Carte modale de rendez-vous -->
    <div class="modal hidden mx-auto fixed inset-0 flex w-max items-center justify-center mt-52 z-50" id="rdv-modal">
        <div class="modal-content bg-gray-custom mx-auto rounded-lg shadow-lg p-6">
            <form>
                <div class="flex w-full">
                    <div class="mb-4">
                        <label for="name" class="block text-white">Nom</label>
                        <input type="name" id="name" name="name"
                            class="w-72 border rounded-lg p-2 focus:ring focus:ring-blue-300" placeholder="Nom" />
                    </div>
                    <div class="ml-10 mb-4">
                        <label for="firstname" class="block text-white">Prénom</label>
                        <input type="firstname" id="firstname" name="firstname"
                            class="w-72 border rounded-lg p-2 focus:ring focus:ring-blue-300" placeholder="Prénom" />
                    </div>
                </div>
                <div class="flex w-full">
                    <div class="ml-10 mb-4">
                        <label for="phone" class="block text-white">Téléphone</label>
                        <input type="phone" id="phone" name="phone"
                            class="w-72 border rounded-lg p-2 focus:ring focus:ring-blue-300" placeholder="Téléphone" />
                    </div>
                </div>
                <div class="flex w-full">
                    <div class="mb-4">
                        <label for="date" class="block text-white">Date</label>
                        <input type="date" id="date" name="date"
                            class="w-72 border rounded-lg p-2 focus:ring focus:ring-blue-300" />
                    </div>
                    <div class="ml-10 mb-4">
                        <label for="hour" class="block text-white">Heure</label>
                        <input type="hour" id="hour" name="hour"
                            class="w-72 border rounded-lg p-2 focus:ring focus:ring-blue-300" placeholder="Heure" />
                    </div>
                </div>
                <div class="flex">
                    <button type="submit"
                        class="mt-5 bg-blue-custom text-white rounded-xl py-2 px-4 hover:bg-blue-custom focus:outline-none focus:ring focus:ring-blue-300">
                        <i class="fa-solid fa-bookmark"></i> Prendre rendez-vous
                    </button>
                    <button class="mt-5 return bg-gray-custom text-white rounded-xl py-2 px-4 hover:bg-gray-custom">
                        Retour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section principale -->
    <main class="bg-gray-100 py-8 px-20 w-full">
        @guest
            <h1 class="text-4xl font-semibold mb-8">Bienvenue sur MediCal</h1>
        @else
            <h1 class="text-4xl font-semibold mb-8">Bienvenue sur MediCal, {{ Auth::user()->prenom }}</h1>
        @endguest
        <p class="text-xl mb-8">
            MediCal est une plateforme de prise de rendez-vous en ligne pour les
            professionnels de santé.
        </p>
        <p class="text-xl mb-8">
            Vous pouvez consulter les disponibilités de nos praticiens et prendre
            rendez-vous en quelques clics.
        </p>
        <div class="w-full mx-auto py-10">
            <h2 class="text-2xl font-semibold mb-4 mt-8 text-center"><i class="fa-solid fa-bookmark"></i> Prendre
                rendez-vous
            </h2>
            <hr class="border-gray-300 mb-8 mx-96" />
            <div class="flex">
                <div class="w-full mx-auto mr-10">
                    <div id='calendar'></div>
                    <div>
                        <button
                            class="mt-5 bg-blue-custom text-white rounded-xl py-2 px-4 hover:bg-blue-custom focus:outline-none focus:ring focus:ring-blue-300"
                            id="open-rdv-modal">
                            <i class="fa-solid fa-bookmark"></i> Prendre rendez-vous
                        </button>
                    </div>
                </div>
            </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-custom text-white py-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2023 MediCal. Tous droits réservés.</p>
            <p><i class="fa-solid fa-envelope"></i> contact@example.com</p>
        </div>
    </footer>

    <script>
        // JavaScript pour gérer l'affichage de la modal de connexion
        const loginModal = document.getElementById("login-modal");
        const rdvModal = document.getElementById("rdv-modal");

        // JavaScript pour gérer l'affichage de la modal de connexion
        const openLoginModalButton = document.getElementById("open-login-modal");
        openLoginModalButton.addEventListener("click", () => {
            loginModal.style.display = "block";
        });

        // JavaScript pour gérer l'affichage de la modal de rendez-vous
        const openRdvModalButton = document.getElementById("open-rdv-modal");
        openRdvModalButton.addEventListener("click", () => {
            rdvModal.style.display = "block";
        });
    </script>
</body>

</html>
