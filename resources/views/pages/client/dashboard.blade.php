<x-app title="Welcome {{ auth()->user()->name }}">
    <h1>Hallo</h1>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-error">Logout</button>
    </form>
</x-app>
