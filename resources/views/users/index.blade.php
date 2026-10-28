<x-app-layout>
    <h1>Users</h1>
    <ul>
        @foreach($users as $user)
            <li>#{{ $user['id'] }} {{ $user['name'] }} - {{ $user['email'] }}</li>
        @endforeach
    </ul>
</x-app-layout>
