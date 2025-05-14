<x-mail::message>
# Bonjour {{ $client->lastname }} {{ $client->firstname }}

Merci pour votre achat. Veuillez trouver ci-joint votre ticket de caisse.

À bientôt,<br/>
L'équipe de magasin : {{ $shop->name }}
</x-mail::message>
