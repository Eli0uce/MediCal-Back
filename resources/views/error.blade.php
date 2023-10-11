<div class="container mx-auto mt-16">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-semibold text-red-500">Erreur</h1>
        <p class="text-xl mt-4">Oups, une erreur s'est produite.</p>
        <p class="mt-2">Nous sommes désolés, mais quelque chose s'est mal passé.</p>
        <p class="mt-2">Veuillez revenir en arrière ou essayer à nouveau plus tard.</p>

        <div class="mt-8">
            <a href="{{ url()->previous() }}"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg px-4 py-2">Retour</a>
        </div>
    </div>
</div>
