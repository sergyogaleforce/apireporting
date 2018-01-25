<form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
    {{ csrf_field() }}

    <button type="submit" class="btn btn-danger">Delete {{ $user->name }}</button>
</form>