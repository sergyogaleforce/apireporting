@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success user-success" style="display:none;">
                <div class="panel-heading">
                    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="panel-title">
                        User Updated
                    </h4>
                </div>
                <div class="panel-body hidden">
                    <p class="lead">The following User has been updated:</p>

                    <p><strong>Name:</strong> <span class="name"></span></p>

                    <p><strong>Email:</strong> <span class="email"></span></p>

                    <p><strong>Token:</strong><br />
                    <pre class="token"></pre>
                    </p>
                </div>
            </div>


            <div class="panel panel-default {{ $user->hasRole('super') ? 'panel-warning' : 'panel-info' }}">
                <div class="panel-heading">{{ $user->name }} <span class="pull-right"><strong>{{ $user->hasRole('super') ? 'Super' : 'User' }}</strong></span></div>
                <div class="panel-body">
                    @if($user->hasRole('super'))
                        @include('users.partials.super_form')
                    @else
                        @include('users.partials.user_form')
                        <form id="app-user-edit-form" data-ajax-form="/users/update/{{ $user->id }}">
                            <div class="alert form-alert" style="display:none;">

                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input name="name" type="text" class="form-control" id="name" value="{{ $user->name }}">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            @if(\Auth::user()->id === 1)
                <div class="panel panel-danger">
                    <div class="panel-heading">Delete {{ $user->name }} </div>
                    <div class="panel-body text-center">
                        @if($user->id === 1)
                            <strong>You can't delete yourself, silly.</strong>
                        @else
                            @include('users.partials.delete_form')
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

@section('js')
    <script>
        if($('#app-user-edit-form').length > 0){
            $('#tv_books').multiSelect({
                selectableOptgroup: true,
                selectableHeader: "<input type='text' class='search-input form-control' placeholder='Search...' autocomplete='off'>",
                selectionHeader: "<input type='text' class='search-input form-control' placeholder='Search...' autocomplete='off'>",
                afterInit: function(ms){
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e){
                            if (e.which === 40){
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e){
                            if (e.which == 40){
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });

            $('#app-user-edit-form').on('submit', function (e) {
                e.preventDefault();

                var data = $(this).serializeArray();
                var url = $(this).attr('data-ajax-form');
                var form = $(this);

                form.find('div.form-alert').removeClass('alert-danger').removeClass('alert-info').slideUp();

                var success_panel = $('div.user-success');

                success_panel.find('.name').html('');
                success_panel.find('.email').html('');
                success_panel.find('.token').html('');
                success_panel.slideUp();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'json',
                    encode: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        var success_panel = $('div.user-success');
                        success_panel.find('.panel-body').addClass('hidden');
                        success_panel.slideDown();
                    },
                    error: function(xhr){
                        if (xhr.status == 422) {
                            var issues = xhr.responseJSON;
                            var error_text = '<ul>';
                            for (var index in issues) {
                                error_text = error_text + '<li>' + issues[index] + '</li>';
                            }
                            error_text = error_text + '</ul>';
                            form.find('div.form-alert').addClass('alert-danger').html(error_text).slideDown();
                        }else{

                        }
                        console.log(xhr);
                    }
                });
            });

        };

        $('.user-success .close').on('click', function(){
            $('.user-success').slideUp();
        });


        $('#app-super-edit-form').on('submit', function (e) {
            e.preventDefault();

            var data = $(this).serializeArray();
            var url = $(this).attr('data-ajax-form');
            var form = $(this);

            form.find('div.form-alert').removeClass('alert-danger').removeClass('alert-info').slideUp();

            var success_panel = $('div.user-success');

            success_panel.find('.name').html('');
            success_panel.find('.email').html('');
            success_panel.find('.token').html('');
            success_panel.find('.panel-body').addClass('hidden');
            success_panel.slideUp();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                dataType: 'json',
                encode: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    success_panel.find('.name').html(data['name']);
                    success_panel.find('.email').html(data['email']);
                    success_panel.find('.token').html(data['token']);
                    success_panel.find('.panel-body').removeClass('hidden');
                    success_panel.slideDown();

                    resetForm(form);
                    $(form.attr('data-ajax-form-table')).DataTable().ajax.reload();
                },
                error: function(xhr){
                    if (xhr.status == 422) {
                        var issues = xhr.responseJSON;
                        var error_text = '<ul>';
                        for (var index in issues) {
                            error_text = error_text + '<li>' + issues[index] + '</li>';
                        }
                        error_text = error_text + '</ul>';
                        form.find('div.form-alert').addClass('alert-danger').html(error_text).slideDown();
                    }else{

                    }
                    console.log(xhr);
                }
            });
        });
    </script>
@stop