@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Teexto sobre los id de los clientes/cambiarlo despues bla bla</div>

                </div>


                <div class="panel panel-default">
                    <div style="display: none; position: absolute; left: 300px; top: 120px; z-index: 1; " id="img_loading" >
                        <img src="{{ asset('img/loading.gif') }}" width="150" height="100" border="5">
                    </div>

                <div class="panel-body">
                    <form id="excel_id" method="post" data-ajax-form=""  >
                        <div class="alert form-alert" style="display:none;">
                            {{ csrf_field() }}
                        </div>
                        <div class="form-group">
                            <label for="campaign_summary_activity">Campaign Summary Activity Report ID</label>
                            <input name="campaign_summary_activity" type="text" class="form-control" id="campaign_summary_activity"
                                    value=" @if( isset($query) )  {{$query->campaign_summary_activity}}  @endif ">
                        </div>
                        <div class="form-group">
                            <label for="campaign_daily_activity">Campaign Daily Activity Report ID</label>
                            <input name="campaign_daily_activity" type="text" class="form-control" id="campaign_daily_activity"
                                   value=" @if( isset($query) )  {{$query->campaign_daily_activity}}  @endif ">
                        </div>
                        <div class="form-group">
                            <label for="advertiser_summary_activity">Advertiser Summary Activity Report ID</label>
                            <input name="advertiser_summary_activity" type="text" class="form-control" id="advertiser_summary_activity"
                                   value=" @if( isset($query) )  {{$query->advertiser_summary_activity}}  @endif ">
                        </div>

                        <div class="form-group">
                            <label for="campaign_status_metrics">Campaign Status Metrics Report ID</label>
                            <input name="campaign_status_metrics" type="text" class="form-control" id="campaign_status_metrics"
                                   value="@if( isset($query) )  {{$query->campaign_status_metrics}}  @endif ">
                        </div>

                        <div class="form-group">
                            <label for="campaign_status_metric">Campaign Event Detail Report ID</label>
                            <input name="campaign_event_detail" type="text" class="form-control" id="campaign_event_detail"
                                   value=" @if( isset($query) )  {{$query->campaign_event_detail}}  @endif  ">
                        </div>



                        <button type="button" class="btn btn-default" id="create">
                            Submit</button>
                    </form>
                </div>

                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>

            <div class="container">
                @yield('content')
            </div>
    </div>
    </div>
    @endsection

@section('js')
        <script >

            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
                });
                $('#create').click(function(){
                    $("#img_loading").css("display", "inline");
                    var url = "{{route('save_id_excel_c') }}";

                    $.ajax({

                        type: "POST",
                        url: url,
                     //  dataType: 'json',
                        data: $("#excel_id").serialize(),

                        success: function(data)
                        {

                            $('#panel-body').html(data);
                            $("#img_loading").css("display", "none");

                        }
                    });
                });

            });
        </script>




@endsection
