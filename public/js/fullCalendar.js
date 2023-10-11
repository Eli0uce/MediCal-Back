document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridFiveDay",
        locale: "fr",
        allDaySlot: false,
        timeZone: "UTC",
        firstDay: 1,
        height: 650,
        slotMinTime: "08:00",
        slotMaxTime: "19:00",
        forceEventDuration: false,
        eventClick: function (info) {
            // Fonction pour formater une date au format "Le DD/MM/YYYY à Hh:Mm"
            function formatDate(date) {
                const options = {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                    hour: "numeric",
                    minute: "numeric",
                };
                return "Le " + date.toLocaleDateString("fr-FR", options);
            }

            // Crée une popup avec les informations du rendez-vous
            var popup = document.createElement("div");
            popup.className =
                "popup mx-auto fixed inset-0 w-max h-44 top-40 left-50 z-50 items-center justify-center text-center bg-white p-4 rounded-lg shadow-lg";
            popup.innerHTML = "<h2>" + info.event.title + "</h2>";
            popup.innerHTML += "<br>";
            popup.innerHTML +=
                "<p>Début : " + formatDate(info.event.start) + "</p>";
            popup.innerHTML +=
                "<p>Fin : " + formatDate(info.event.end) + "</p>";

            // Crée un bouton pour fermer la popup
            var closeButton = document.createElement("button");
            closeButton.className =
                "close-button bg-blue-custom text-white font-bold py-2 px-4 rounded mt-4";
            closeButton.innerHTML = "Fermer";
            closeButton.addEventListener("click", function () {
                popup.remove();
            });

            // Ajoute le bouton à la popup
            popup.appendChild(closeButton);

            // Ajoute la popup à la page
            document.body.appendChild(popup);
        },
        views: {
            timeGridFiveDay: {
                type: "timeGrid",
                duration: {
                    days: 5,
                },
            },
        },
        events: (function () {
            var events = [];
            for (var i = 0; i < rendezvous.length; i++) {
                var eventData = rendezvous[i];
                if (auth) {
                    var endDate = new Date(eventData.date_et_heure);
                    endDate.setTime(endDate.getTime() + 15 * 60 * 1000);

                    // Obtenir les composants de date et d'heure de endDate
                    var year = endDate.getFullYear();
                    var month = String(endDate.getMonth() + 1).padStart(2, "0"); // Le mois est 0-indexé, donc ajoutez 1 et formatez avec deux chiffres
                    var day = String(endDate.getDate()).padStart(2, "0");
                    var hours = String(endDate.getHours()).padStart(2, "0");
                    var minutes = String(endDate.getMinutes()).padStart(2, "0");
                    var seconds = String(endDate.getSeconds()).padStart(2, "0");

                    // Formatage de endDate au format "YYYY-MM-DDTHH:mm:ss"
                    var formattedEndDate =
                        year +
                        "-" +
                        month +
                        "-" +
                        day +
                        "T" +
                        hours +
                        ":" +
                        minutes +
                        ":" +
                        seconds;

                    events.push({
                        id: eventData.rendezvous_id,
                        title: eventData.motif + " - " + eventData.patient,
                        backgroundColor: "#007BFF",
                        start: eventData.date_et_heure,
                        end: formattedEndDate,
                    });
                } else {
                    events.push({
                        id: eventData.rendezvous_id,
                        title: "Complet",
                        backgroundColor: "#007BFF",
                        start: eventData.date_et_heure,
                        end: formattedEndDate,
                        className: "rendezvous-non-connecte",
                    });
                }
            }
            return events;
        })(),
    });

    calendar.render();
});
