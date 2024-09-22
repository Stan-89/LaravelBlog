@section('styles')
<link rel="stylesheet" href="{{ URL::to('/css/common.css')}}" type="text/css"/>
<!-- Since 2nd-level (contact has its own section) APPEND lets us add to an existing section [instead of endsection]-->
@append

@if(Session::has('fail'))
  <section class="info-box fail">
    {{Session::get('fail')}}
  </section>
@endif
@if(Session::has('success'))
  <section class="info-box success">
    {{Session::get('success')}}
  </section>
@endif
@if(count($errors)> 0)
  <section class="info-box fail">
    <ul>
      @foreach($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
    </ul>
  </section>
@endif
