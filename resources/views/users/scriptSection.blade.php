@section('scripts')
    <script type="text/javascript" src="{{URL::to('js/common.js')}}"></script>
    <script type="text/javascript">
      var token="{{Session::token()}}";
      $(document).ready(function(){
        activateMenu({{$theSection}});
        activateListenersDelete();
      });
    </script>
@endsection
