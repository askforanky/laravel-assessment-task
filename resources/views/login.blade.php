@extends('layouts.user')
@section('content')
<div class="login">
  <main class="form-signin">
    <form id="form-login" autocomplete="off">
      @csrf
      <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>
      <div class="form-floating">
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email-id">
        <label for="email">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
        <label for="password">Password</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary mb-3" type="button" id="btnSignin">Sign in</button>
      <p class="mb-3 text-muted text-center">--- or ---</p>
      <a class="w-100 btn btn-lg btn-light" href="{{ url('/auth/google/redirect') }}"><img src="{{ asset('images/google.png') }}" alt=""> <span style="margin-left: 15px;">Sign in with Google</span></a>
      <p class="my-5 text-muted text-center">
        Don't have an account?
        <a href="{{ url('signup') }}">Signup Now</a>
      </p>
    </form>
  </main>
</div>
@endsection
@section('footer')
<script>
  $(function() {
    $("#form-login input").on("keyup", function(event) {
      if (event.keyCode === 13) {
        event.preventDefault();
        $("#btnSignin").trigger("click");
      }
    })
    $("#btnSignin").on("click", () => {
      $("#btnSignin").prop("disabled", true);
      postForm(`{{ url('login') }}`, "form-login", (response) => {
        $("#btnSignin").prop("disabled", false);
        if (response.flag == 1) {
          $("#form-login")[0].reset();
          setTimeout(() => {
            location.href = `{{ url('') }}`
          }, 2000);
        }
        toast(response.flag, response.msg)
      })
    })
  })
</script>
@endsection