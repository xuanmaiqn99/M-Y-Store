@if($errors->count()>0)
    @foreach ($errors->all() as $error)
        <div class="nNote nWarning hideit">{{ $error }}</div>
    @endforeach
@endif
@if (Session::has('message'))
    <div class="nNote nFailure hideit">
        {{ Session::get('message') }}
    </div>
@endif
@if (Session::has('success'))
    <div class="nNote nInformation hideit">
        {{ Session::get('success') }}
    </div>
@endif
