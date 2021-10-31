@extends('layouts.user')
@section('content')
@php( $occupation = explode(',',$partnerPreference['occupation']))
@php( $familyType = explode(',',$partnerPreference['familyType']))
<div class="container py-3">
  @include('menu')
  <div class="p-3 pb-md-4 mx-auto text-center">
    <h2 class="display-6 fw-normal">Partner Preference</h2>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-8">
      <form id="form-partner-preference" autocomplete="off">
        @csrf
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">Expected Income<span class="text-danger">*</span> <span class="text-muted">(in lac)</span></label>
            <input type="hidden" class="form-control" id="minExpectedIncome" value="{{ $partnerPreference['minExpectedIncome'] }}" name="minExpectedIncome">
            <input type="hidden" class="form-control" id="maxExpectedIncome" value="{{ $partnerPreference['maxExpectedIncome'] }}" name="maxExpectedIncome">
            <div id="slider-range"></div>
            <label>Min Income : <span id="minIncome">{{ $partnerPreference['minExpectedIncome'] }}</span> lac</label><br>
            <label>Max Income : <span id="maxIncome">{{ $partnerPreference['maxExpectedIncome'] }}</span> lac</label>
          </div>

          <div class="col-12">
            <label for="occupation" class="form-label">Occupation <span class="text-danger">*</span></label>
            <select class="form-select" id="occupation" name="occupation[]" multiple>
              @foreach (config('constant.OCCUPATION_TYPE') as $key => $ot)
              <option value="{{ $key }}" {{ in_array($key, $occupation) ? "selected" : ""}}>{{ $ot }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-12">
            <label for="familyType" class="form-label">Family Type <span class="text-danger">*</span></label>
            <select class="form-select" id="familyType" name="familyType[]" multiple>
              @foreach (config('constant.FAMILY_TYPE') as $key => $ft)
              <option value="{{ $key }}" {{ in_array($key, $familyType) ? "selected" : ""}}>{{ $ft }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-12">
            <label for="maglik" class="form-label">Manglik <span class="text-danger">*</span></label>
            <select class="form-select" id="manglik" name="manglik">
              @foreach (config('constant.MANGLIK_TYPE') as $key => $manglikType)
              <option value="{{ $key }}" {{ $key == $partnerPreference['manglik'] ? 'selected' : ''}}>{{ $manglikType }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <button class="mt-4 btn btn-primary" type="button" id="btnSubmit">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection
@section('footer')
<script>
  $(function() {
    const min = parseInt(`{{ config('constant.EXPECTED_INCOME_RANGE.min') }}`);
    const max = parseInt(`{{ config('constant.EXPECTED_INCOME_RANGE.max') }}`);
    const dmin = parseInt(`{{ $partnerPreference['minExpectedIncome'] }}`);
    const dmax = parseInt(`{{ $partnerPreference['maxExpectedIncome'] }}`);
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

    $('#occupation').multiselect({
      placeholder: 'Select Occupation',
      selectAll: true
    });

    $('#familyType').multiselect({
      placeholder: 'Select Family Type',
      selectAll: true
    });

    $(".ms-options-wrap button").addClass("form-select");
    $('.ms-options-wrap button:after').css('display', 'none');

    $("#btnSubmit").on("click", () => {
      $("#btnSubmit").prop("disabled", true);
      postForm(`{{ url('partner-preference') }}`, "form-partner-preference", (response) => {
        console.log(response);
        $("#btnSubmit").prop("disabled", false);
        toast(response.flag, response.msg)
      })
    })
  });
</script>
@endsection