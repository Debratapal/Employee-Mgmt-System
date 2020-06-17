@extends('employees-mgmt.base')

@section('action-content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{
    $("#empid").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });

   $("#mobnumber").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg2").html("Numbers Only").show().fadeOut("slow");
               return false;
    }
   });

   $( "#empname" ).keypress(function(e) {
        var key = e.keyCode;
            if (key >= 48 && key <= 57) {
                $("#errmsg1").html("Alphabets Only").show().fadeOut("slow");
               return false;
             }
    });  

    $('#clear').click(function() {
        $('.form-horizontal input[type="text"]').val('');
    });
    
});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update employee</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('employee-management.update', ['id' => $employee->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('empid') ? ' has-error' : '' }}">
                            <label for="empid" class="col-md-4 control-label">Employee ID</label>

                            <div class="col-md-6">
                                <input id="empid" type="text" class="form-control" maxlength="5" name="empid" value="{{ $employee->empid }}" required autofocus> <span id="errmsg"></span>

                                @if ($errors->has('empid'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('empid') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('empname') ? ' has-error' : '' }}">
                            <label for="empname" class="col-md-4 control-label">Epmloyee Name</label>

                            <div class="col-md-6">
                                <input id="empname" type="text" class="form-control" name="empname" value="{{ $employee->empname }}" required> <span id="errmsg1"></span>

                                @if ($errors->has('empname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('empname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('mobnumber') ? ' has-error' : '' }}">
                            <label for="mobnumber" class="col-md-4 control-label">Mobile</label>

                            <div class="col-md-6">
                                <input id="mobnumber" type="text" class="form-control" name="mobnumber" placeholder="7854896587" maxlength="10" pattern="[0-9]{10}" value="{{ $employee->mobnumber }}" required> <span id="errmsg2"></span>

                                @if ($errors->has('mobnumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobnumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ $employee->email }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                               
                        <div class="form-group">
                            <label class="col-md-4 control-label">Date of Birth</label>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="{{ $employee->birthdate }}" name="birthdate" class="form-control pull-right" id="birthDate" required>
                                </div>
                            </div>
                        </div>
                          
                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label" >Profile Photo</label>
                            <div class="col-md-6">
                                <img src="../../{{$employee->picture }}" width="50px" height="50px"/>
                                <input type="file" id="picture" name="picture" accept="image/x-png,image/jpeg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <button type="submit" class="btn btn-primary" id="clear">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
