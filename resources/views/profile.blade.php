<h1>
    Hi - <i>{{ Auth::user()->name }}</i>
</h1>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>    
</form>