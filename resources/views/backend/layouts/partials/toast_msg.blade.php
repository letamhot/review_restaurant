@if($errors->any())
  @foreach($errors->all() as $error)
  <script>
    iziToast.error({
      title: 'Error',
      message: '{{ $error }}',
      position: 'topRight'
    });
  </script>
  @endforeach
@endif

@if (Session::has('error'))
<script>
    iziToast.error({
      title: 'Error',
      message: '{{ Session::get('error') }}',
      position: 'topRight'
    });
</script>
@endif