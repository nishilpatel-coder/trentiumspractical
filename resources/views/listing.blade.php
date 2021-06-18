<!DOCTYPE html>
<html>
<head>
    <title>Address Book</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">

<div class="col-md-offset-6 text-right">
    <a href="{{ URL::to('addressbook/create') }}"><button class="btn btn-primary " type="button"> Add Addressbook</button></a>
</div>

<h1>All Address Book</h1>

<!-- will be used to show any messages -->
@if (Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

{{ Form::open(array('url' => 'addressbook', 'method' => 'GET')) }}

    <div class="form-group @if ($errors->has('zipcode')) has-error @endif">
        {{ Form::label('zipcode', 'Zip-code') }}
        {{ Form::text('zipcode', $zipcode, array('class' => 'form-control')) }}
        @error('zipcode')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group @if ($errors->has('city_id')) has-error @endif">
        {{ Form::label('city_id', 'City') }}
        {{ Form::select('city_id', $city, $city_id, array('class' => 'form-control')) }}
        @error('city_id')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
{{ Form::submit('Filter', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}




<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Profile Picture</td>
            <td>Name</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Street</td>
            <td>City</td>
            <td>Zip-code</td>
        </tr>
    </thead>
    <tbody>
    @foreach($addressbook as $key => $value)
        <tr>
            <td>
                @if($value->profilePic)
                    <img src="{{ url('/')}}/images/{{ $value->profilePic }}" width="150" height="150"> 
                @else
                    <img src="{{ url('/')}}/images/No_image_available.png" width="150" height="150"> 
                @endif
            </td>
            <td>{{ $value->firstName }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->phone }}</td>
            <td>{{ $value->street }}</td>
            <td>{{ $value->city->name }}</td>
            <td>{{ $value->zipcode }}</td>
            <td>
                {{ Form::open(array('url' => 'addressbook/' . $value->slug, 'class' => 'pull-right')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
                {{ Form::close() }}
                <a class="btn btn-small btn-info" href="{{ URL::to('addressbook/' . $value->slug . '/edit') }}">Edit</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{!! $addressbook->links() !!}

</div>
</body>
</html>