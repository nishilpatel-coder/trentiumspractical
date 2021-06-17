<!DOCTYPE html>
<html>
<head>
    <title>Address Book</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<div class="col-md-offset-6 text-right">
    <a href="{{ URL::to('addressbook') }}"><button class="btn btn-primary " type="button"> View All</button></a>
</div>

<h1>Create a Address Book</h1>
@if (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
{{ Form::open(array('url' => 'addressbook', 'files' => true)) }}

    <div class="form-group @if ($errors->has('firstName')) has-error @endif">
        {{ Form::label('firstName', 'First Name') }}
        {{ Form::text('firstName', Input::old('firstName'), array('class' => 'form-control '. $errors->first('firstName', 'is-invalid'))) }}
        @error('firstName')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group @if ($errors->has('lastName')) has-error @endif">
        {{ Form::label('lastName', 'Last Name') }}
        {{ Form::text('lastName', Input::old('lastName'), array('class' => 'form-control')) }}
        @error('lastName')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group @if ($errors->has('email')) has-error @endif">
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
        @error('email')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group @if ($errors->has('phone')) has-error @endif">
        {{ Form::label('phone', 'Phone') }}
        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
        @error('phone')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group @if ($errors->has('street')) has-error @endif">
        {{ Form::label('street', 'Street') }}
        {{ Form::textarea('street', Input::old('street'), array('class' => 'form-control','rows'=>'1')) }}
        @error('street')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>    

    <div class="form-group @if ($errors->has('zipcode')) has-error @endif">
        {{ Form::label('zipcode', 'Zip-code') }}
        {{ Form::text('zipcode', Input::old('zipcode'), array('class' => 'form-control')) }}
        @error('zipcode')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group @if ($errors->has('city_id')) has-error @endif">
        {{ Form::label('city_id', 'City') }}
        {{ Form::select('city_id', $city, Input::old('city_id'), array('class' => 'form-control')) }}
        @error('city_id')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group @if ($errors->has('image')) has-error @endif">
        {{ Form::label('image', 'Profile Picture') }}
        {{ Form::file('image', array('class' => 'form-control','accept'=>"image/x-png,image/gif,image/jpeg")) }}
        @error('image')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

</div>
</body>
</html>