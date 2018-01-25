@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success refresh-success" style="display:none;">
                <div class="panel-heading">
                    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="panel-title">
                        Token Reset!
                    </h4>
                </div>
                <div class="panel-body">
                    <p class="lead">The following User has been reset:</p>

                    <p><strong>Name:</strong> <span class="name"></span></p>

                    <p><strong>Email:</strong> <span class="email"></span></p>

                    <p><strong>Token:</strong><br />
                    <pre class="token"></pre>
                    </p>

                    <div class="alert alert-warning">
                        Copy/Paste this token now. It will not be displayed again and is not recoverable. Lost tokens will result in the need to recreate a token.
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Users
                    </h4>
                </div>
                <div class="panel-body">
                    <table id="app-users-table" class="table table-condensed table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>&nbsp;</th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-success user-success" style="display:none;">
                <div class="panel-heading">
                    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="panel-title">
                        User Created!
                    </h4>
                </div>
                <div class="panel-body">
                    <p class="lead">The following User has been created:</p>

                    <p><strong>Name:</strong> <span class="name"></span></p>

                    <p><strong>Email:</strong> <span class="email"></span></p>

                    <p><strong>Token:</strong><br />
                        <pre class="token"></pre>
                    </p>

                    <div class="alert alert-warning">
                        Copy/Paste this token now. It will not be displayed again and is not recoverable. Lost tokens will result in the need to recreate a token.
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Create User
                    </h4>
                </div>
                <div class="panel-body">
                    <form id="app-users-form" data-ajax-form="/users/create" data-ajax-form-table="#app-users-table">
                        <div class="alert form-alert" style="display:none;">

                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" name="type" class="form-control">
                                <option value="super">Super</option>
                                <option value="user" selected>User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" id="password" readonly>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Password Confirmation</label>
                            <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" readonly>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="confirm_reset_token">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="row">
                    <div class="col-lg-12 text-center" style="padding: 20px;">
                        <p>Are you sure? This will revoke the current token.</p>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-success confirm-reset-token">Yes</button>
                            <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="current_time" style="display:none;">{{ Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#type').on('change', function(){
                if($(this).val() === 'super'){
                    $('#password').prop('readonly', null);
                    $('#password_confirmation').prop('readonly', null);
                }else{
                    $('#password').prop('readonly', 'readonly');
                    $('#password_confirmation').prop('readonly', 'readonly');
                }
            });

            $('.user-success .close').on('click', function(){
                $('.user-success').slideUp();
            });

            $('.refresh-success .close').on('click', function(){
                $('.refresh-success').slideUp();
            });

            $('#app-users-form').on('submit', function (e) {
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
                        success_panel.find('.name').html(data['name']);
                        success_panel.find('.email').html(data['email']);
                        success_panel.find('.token').html(data['token']);
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

            function resetForm(form) {
                form.find('input:text, input:password, input:file, select, textarea').val('');
                form.find('input:radio, input:checkbox')
                        .removeAttr('checked').removeAttr('selected');
            }

            var now = moment($('#current_time').html());

            var app_files_table = $('#app-users-table').DataTable({
                "processing": true,
                "serverSide": true,
                ajax: {
                    url: '/users/list',
                    dataSrc: 'data'
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'id'},
                    {data: 'id'},
                ],
                "columnDefs": [{
                    "targets": 3,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        var html = '<a href="#" class="refresh-token" data-id="' + cellData + '"><span class="glyphicon glyphicon-refresh"></span></a>';
                        $(td).html(html);
                    }
                },
                    {
                        "targets": 4,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            var html = '<a href="/users/edit/' + cellData + '"><span class="glyphicon glyphicon-pencil"></span></a>';
                            $(td).html(html);
                        }
                    }],
                "drawCallback": function (settings) {
                    $('.refresh-token').on('click', function(){
                        var modal = $('#confirm_reset_token');
                        modal.modal('show');

                        modal.find('.confirm-reset-token').attr('data-id', $(this).attr('data-id'))
                                .on('click', function(){
                                    $.ajax({
                                        type: 'GET',
                                        url: '/users/token/' + $('.confirm-reset-token').attr('data-id'),
                                        dataType: 'json',
                                        encode: true,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function (data) {
                                            var token_success_panel = $('.refresh-success');
                                            token_success_panel.find('.name').html(data['name']);
                                            token_success_panel.find('.email').html(data['email']);
                                            token_success_panel.find('.token').html(data['token']);
                                            token_success_panel.slideDown();
                                        },
                                        error: function(xhr){
                                            console.log(xhr);
                                        }
                                    });



                                    $('#confirm_reset_token').modal('hide');
                                });
                    });
                }
            });
        });

        function refresh_token(id){
            var response = '';



            return response;
        }
    </script>
@stop