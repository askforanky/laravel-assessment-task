@extends('layouts.user')
@section('content')
<div class="container">
  <main>
    <div class="pt-5 pb-3 text-center">
      <h2>Regitration form</h2>
      <p class="lead">fill out below form.</p>
    </div>

    <div class="row justify-content-center pb-5">
      <div class="col-md-7 col-lg-8">
        <form id="form-signup" autocomplete="off">
          @csrf
          <div class="form-tab" id="basic-form">
            <h4 class="mb-3">Basic Information</h4>
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">First name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name">
              </div>

              <div class="col-sm-6">
                <label for="lastName" class="form-label">Last name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name">
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email-id">
              </div>

              <div class="col-12">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
              </div>

              <div class="col-12">
                <label for="confirmPassword" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Re-type password">
              </div>

              <div class="col-12 col-md-6">
                <label for="dateOfBirth" class="form-label">Date of Birth</label>
                <input type="text" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="yyyy-mm-dd">
              </div>

              <div class="col-12 col-md-6">
                <label for="address" class="form-label">Gander</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" checked id="ganderMale" value="m">
                  <label class="form-check-label" for="ganderMale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="f">
                  <label class="form-check-label" for="genderFemale">Female</label>
                </div>
              </div>

              <div class="col-md-6">
                <label for="annualIncome" class="form-label">Annual Income <span class="text-muted">(in lac)</span></label>
                <input type="number" class="form-control" id="annualIncome" name="annualIncome" placeholder="Enter annual income">
              </div>

              <div class="col-md-6">
                <label for="occupation" class="form-label">Occupation</label>
                <select class="form-select" id="occupation" name="occupation">
                  <option value="">Choose...</option>
                  @foreach (config('constant.OCCUPATION_TYPE') as $key => $occupationType)
                  <option value="{{ $key }}">{{ $occupationType }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="familyType" class="form-label">Family Type</label>
                <select class="form-select" id="familyType" name="familyType">
                  <option value="">Choose...</option>
                  @foreach (config('constant.FAMILY_TYPE') as $key => $familyType)
                  <option value="{{ $key }}">{{ $familyType }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="manglik" class="form-label">Manglik</label>
                <select class="form-select" id="manglik" name="manglik">
                  <option value="">Choose...</option>
                  @foreach (config('constant.MANGLIK_TYPE') as $key => $manglikType)
                  <option value="{{ $key }}">{{ $manglikType }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-3">
                <button class="w-100 mt-4 btn btn-primary" type="button" id="btnNext">Next</button>
              </div>
            </div>
          </div>
          <div class="form-table" id="partner-preference-form">
            <h4 class="mb-3">Partner Preference</h4>
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Expected Income<span class="text-danger">*</span> <span class="text-muted">(in lac)</span></label>
                <input type="hidden" class="form-control" id="minExpectedIncome" name="minExpectedIncome">
                <input type="hidden" class="form-control" id="maxExpectedIncome" name="maxExpectedIncome">
                <div id="slider-range"></div>
                <label>Min Income : <span id="minIncome"></span> lac</label><br>
                <label>Max Income : <span id="maxIncome"></span> lac</label>
              </div>

              <div class="col-12">
                <label for="expectedOccupation" class="form-label">Occupation <span class="text-danger">*</span></label>
                <select class="form-select" id="expectedOccupation" name="expectedOccupation[]" multiple>
                  @foreach (config('constant.OCCUPATION_TYPE') as $key => $ot)
                  <option value="{{ $key }}">{{ $ot }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-12">
                <label for="expectedFamilyType" class="form-label">Family Type <span class="text-danger">*</span></label>
                <select class="form-select" id="expectedFamilyType" name="expectedFamilyType[]" multiple>
                  @foreach (config('constant.FAMILY_TYPE') as $key => $ft)
                  <option value="{{ $key }}">{{ $ft }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-12">
                <label for="expectedManglik" class="form-label">Manglik <span class="text-danger">*</span></label>
                <select class="form-select" id="expectedManglik" name="expectedManglik">
                  @foreach (config('constant.MANGLIK_TYPE') as $key => $manglikType)
                  <option value="{{ $key }}">{{ $manglikType }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row justify-content-between">
              <div class="col-3">
                <button class="w-100 mt-4 btn btn-primary" type="button" id="btnPrevious">Previous</button>
              </div>
              <div class="col-3">
                <button class="w-100 mt-4 btn btn-primary" type="button" id="btnSignup">Signup</button>
              </div>
            </div>
          </div>
        </form>
        <div class="d-flex justify-content-center">
          <p class="my-3 text-muted text-center">
            Already signed up?
            <a href="{{ url('login') }}">Login Here</a>
          </p>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
@section('footer')
<script>
  $(function() {
    $("#basic-form").show();
    $("#partner-preference-form").hide();
    $("#dateOfBirth").datepicker({
      dateFormat: "yy-mm-dd"
    });

    const min = parseInt(`{{ config('constant.EXPECTED_INCOME_RANGE.min') }}`);
    const max = parseInt(`{{ config('constant.EXPECTED_INCOME_RANGE.max') }}`);
    const dmin = parseInt(`{{ config('constant.DEFUALT_EXPECTED_INCOME_RANGE.min') }}`);
    const dmax = parseInt(`{{ config('constant.DEFUALT_EXPECTED_INCOME_RANGE.max') }}`);
    $("#slider-range").slider({
      range: true,
      min,
      max,
      values: [dmin, dmax],
      slide: function(event, ui) {
        $("#minIncome").text(ui.values[0]);
        $("#maxIncome").text(ui.values[1]);
        $("#minExpectedIncome").val(ui.values[0]);
        $("#maxExpectedIncome").val(ui.values[1]);
      }
    });

    $("#minIncome").text($("#slider-range").slider("values", 0));
    $("#maxIncome").text($("#slider-range").slider("values", 1));
    $("#minExpectedIncome").val($("#slider-range").slider("values", 0));
    $("#maxExpectedIncome").val($("#slider-range").slider("values", 1));

    $('#expectedOccupation').multiselect({
      placeholder: 'Select Occupation',
      selectAll: true
    });

    $('#expectedFamilyType').multiselect({
      placeholder: 'Select Family Type',
      selectAll: true
    });

    $(".ms-options-wrap button").addClass("form-select");
    $('.ms-options-wrap button:after').css('display', 'none');

    $("#btnSignup").on("click", () => {
      // $("#btnSignup").prop("disabled", true);
      postForm(`{{ url('signup') }}`, "form-signup", (response) => {
        console.log(response);
        $("#btnSignup").prop("disabled", false);
        if (response.flag == 1) {
          $("#form-signup")[0].reset();
          setTimeout(() => {
            location.href = `{{ url('login') }}`
          }, 2000);
        }
        toast(response.flag, response.msg)
      })
    });

    $("#btnNext").on("click", () => {
      $("#basic-form").hide();
      $("#partner-preference-form").fadeIn(500);
    });

    $("#btnPrevious").on("click", () => {
      $("#partner-preference-form").hide();
      $("#basic-form").fadeIn(500);
    })
  })
</script>
@endsection