@if (session()->has('error'))

<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{session('error')}}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

@endif
