@if (count($errors) > 0)
  <div class="alert alert-danger text-center">
    <div>
      @foreach ($errors->all() as $error)
        <div class="">{{ $error }}</div>
      @endforeach
    </div>
  </div>
@endif