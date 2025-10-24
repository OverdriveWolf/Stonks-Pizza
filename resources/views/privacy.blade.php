@extends('layouts.app-layout')

@section('content')
    <div class="min-h-screen bg-gray-50 flex flex-col items-center py-10 px-4">
        <div class="bg-white shadow-lg rounded-2xl max-w-3xl w-full p-8">
            <h1 class="text-3xl font-bold text-blue-800 mb-6 text-center">Privacyverklaring</h1>

            <p class="mb-6 text-gray-700">
                Wij hechten veel waarde aan de bescherming van jouw persoonsgegevens. In deze privacyverklaring leggen wij uit welke gegevens wij verzamelen,
                waarom wij dat doen en hoe wij zorgvuldig met jouw gegevens omgaan. Deze verklaring is opgesteld in overeenstemming met de
                <strong>Algemene Verordening Gegevensbescherming (AVG)</strong>.
            </p>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">1. Verantwoordelijke</h2>
            <p class="text-gray-700 mb-4">
                De verantwoordelijke voor de verwerking van persoonsgegevens is: <br>
                <strong>Johnny van Duren</strong><br>
                E-mail: Johnny@Durengmail.com<br>
                Adres: 123 Pizza Street, Pizzatown
            </p>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">2. Welke gegevens wij verwerken</h2>
            <ul class="list-disc ml-6 text-gray-700 mb-4">
                <li>Naam</li>
                <li>Adres</li>
                <li>Woonplaats</li>
                <li>E-mailadres</li>
                <li>Telefoonnummer</li>
                <li>Bestelde producten (pizza en ingrediënten)</li>
            </ul>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">3. Waarom wij deze gegevens verwerken</h2>
            <p class="text-gray-700 mb-4">
                Wij gebruiken deze gegevens uitsluitend om bestellingen te verwerken, contact op te nemen bij vragen,
                en betalingen of leveringen correct af te handelen.
            </p>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">4. Hoe wij jouw gegevens beveiligen</h2>
            <ul class="list-disc ml-6 text-gray-700 mb-4">
                <li>Gebruik van beveiligde (HTTPS) verbinding.</li>
                <li>Toegang alleen voor bevoegde personen.</li>
                <li>Gegevens worden opgeslagen in een beveiligde database.</li>
                <li>Geen delen van gegevens met derden zonder toestemming.</li>
            </ul>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">5. Bewaartermijn</h2>
            <p class="text-gray-700 mb-4">
                Wij bewaren persoonsgegevens niet langer dan noodzakelijk. Bestelgegevens worden maximaal <strong>30 dagen</strong> na afronding van de bestelling bewaard.
            </p>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">6. Rechten van de gebruiker</h2>
            <p class="text-gray-700 mb-4">
                Je hebt recht op inzage, correctie, verwijdering, beperking of bezwaar tegen de verwerking van jouw gegevens.
                Neem contact op via <strong>Johnny@Durengmail.com</strong> om van deze rechten gebruik te maken.
            </p>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">7. Minderjarigen</h2>
            <p class="text-gray-700 mb-4">
                Als je jonger bent dan 16 jaar, mag je alleen persoonsgegevens verstrekken met toestemming van je ouder of voogd.
            </p>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">8. Contact</h2>
            <p class="text-gray-700 mb-4">
                Voor vragen over deze privacyverklaring of de verwerking van jouw gegevens kun je contact opnemen via:<br>
                📧 <strong>Johnny@Durengmail.com</strong><br>
                📍 <strong>Pizza Street 123</strong>
            </p>

            <h2 class="text-2xl font-semibold text-blue-700 mt-6 mb-2">9. Wijzigingen</h2>
            <p class="text-gray-700 mb-8">
                Wij behouden ons het recht voor deze privacyverklaring te wijzigen. Controleer deze pagina regelmatig om op de hoogte te blijven van eventuele aanpassingen.
            </p>

            <div class="text-center">
                <a href="{{ url()->previous() }}" class="bg-blue-700 text-white px-5 py-2 rounded-lg hover:bg-blue-800">
                    Terug naar bestellen
                </a>
            </div>
        </div>
    </div>
@endsection
