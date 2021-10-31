@extends('layouts.user')
@section('content')
<div class="container py-3">
  @include('menu')
  <div class="p-3 pb-md-4 mx-auto text-center">
    <h2 class="display-6 fw-normal">Profile</h2>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-8">

      <form id="form-profile" autocomplete="off">
        @csrf
        <div class="row g-3">
          <div class="col-sm-6">
            <label for="firstName" class="form-label">First name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ $user->firstName }}" id="firstName" name="firstName" placeholder="Enter first name">
          </div>

          <div class="col-sm-6">
            <label for="lastName" class="form-label">Last name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ $user->lastName }}" id="lastName" name="lastName" placeholder="Enter last name">
          </div>

          <div class="col-12 col-md-6">
            <label for="dateOfBirth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ $user->dateOfBirth }}" id="dateOfBirth" name="dateOfBirth" placeholder="Enter date of birth">
          </div>

          <div class="col-12 col-md-6">
            <label for="address" class="form-label">Gander <span class="text-danger">*</span></label>
            <div class="pt-1">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="ganderMale" {{ $user->gender == 'm' ? 'checked' : ''}} value="m">
                <label class="form-check-label" for="ganderMale">Male</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderFemale" {{ $user->gender == 'f' ? 'checked' : ''}} value="f">
                <label class="form-check-label" for="genderFemale">Female</label>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="annualIncome" class="form-label">Annual Income <span class="text-danger">*</span> <span class="text-muted">(in lac)</span></label>
            <input type="number" class="form-control" value="{{ $user->annualIncome }}" id="annualIncome" name="annualIncome" placeholder="Enter annual income">
          </div>

          <div class="col-md-6">
            <label for="occupation" class="form-label">Occupation</label>
            <select class="form-select" id="occupation" name="occupation" value="{{ $user->occupation }}">
              <option value="">Choose...</option>
              @foreach (config('constant.OCCUPATION_TYPE') as $key => $occupationType)
              <option value="{{ $key }}" {{ $key == $user->occupation ? 'selected' : '' }}>{{ $occupationType }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label for="familyType" class="form-label">Family Type</label>
            <select class="form-select" id="familyType" name="familyType" value="{{ $user->familyType }}">
              <option value="">Choose...</option>
              @foreach (config('constant.FAMILY_TYPE') as $key => $familyType)
              <option value="{{ $key }}" {{ $key == $user->familyType ? 'selected' : '' }}>{{ $familyType }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label for="manglik" class="form-label">Manglik</label>
            <select class="form-select" id="manglik" name="manglik" value="{{ $user->manglik }}">
              <option value="">Choose...</option>
              @foreach (config('constant.MANGLIK_TYPE') as $key => $manglikType)
              <option value="{{ $key }}" {{ $key == $user->manglik ? 'selected' : '' }}>{{ $manglikType }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <button class="mt-4 btn btn-primary" type="button" id="btnUpdate">Update</button>
      </form>

    </div>
  </div>
</div>
@endsection
@section('footer')
<script>
  $(function() {
    $("#dateOfBirth").datepicker({
      dateFormat: "yy-mm-dd"
    });
    $("#btnUpdate").on("click", () => {
      $("#btnUpdate").prop("disabled", true);
      postForm(`{{ url('profile') }}`, "form-profile", (response) => {
        console.log(response);
        $("#btnUpdate").prop("disabled", false);
        toast(response.flag, response.msg)
      })
    });
  });
</script>
@endsection