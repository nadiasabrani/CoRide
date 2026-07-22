<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
        Utilisateurs
    </h2>
</x-slot>

<div class="py-12">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<div class="bg-white p-6 shadow">

<table class="w-full">
<tr>
    <th>Nom</th>
    <th>Email</th>
    <th>Entreprise</th>
    <th>Role</th>
    <th>Ville</th>
</tr>

@foreach($users as $user)

<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->entreprise->nom ?? '---' }}</td>
    <td>{{ $user->role }}</td>
    <td>{{ $user->ville }}</td>
</tr>

@endforeach

</table>

</div>

</div>
</div>

</x-app-layout>
