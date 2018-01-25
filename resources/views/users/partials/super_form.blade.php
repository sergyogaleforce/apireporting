<form id="app-super-edit-form" data-ajax-form="/users/update/{{ $user->id }}">
    <div class="alert form-alert" style="display:none;">

    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input name="name" type="text" class="form-control" id="name" value="{{ $user->name }}">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" id="email" value="{{ $user->email }}" disabled>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" type="password" class="form-control" id="password">
        <div class="help-text"><strong>Be careful!</strong> Changing the password will change the user's token.</div>
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password Confirmation</label>
        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>