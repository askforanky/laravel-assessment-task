@extends('layouts.user')
@section('content')
<div class="container py-3">
  @include('menu')

  <div class="row row-cols-1 mb-3 text-center" id="result">

  </div>
  <div class="d-flex justify-content-center">
    <button id="btnShowMore" class="btn btn-primary">
      Show more
    </button>
  </div>
</div>
@endsection
@section('footer')
<script>
  let currentPage = 1;
  let itemPerPage = parseInt(`{{ config('constant.ITEM_PER_PAGE') }}`);
  const _token = "{{csrf_token()}}";
  let a = true;
  loadData();

  $("#btnShowMore").on("click", () => {
    loadData();
  })

  function loadData() {
    $("#btnShowMore").prop("disabled", true);
    $("#btnShowMore").prop("Loading");
    if (a) {
      postRequest("{{ url('filter-partner-suggetion') }}", {
        currentPage,
        _token
      }, (response) => {
        console.log(response);

        $("#result").append(response.data.blade);
        if (response.data.count < itemPerPage) {
          a = false;
          $("#btnShowMore").hide();
          if (!response.data.isPref) {
            $("#result").append("<div class='col-12'><h3 class='text-center'>Please add partner preference</h3></div>");
          } else if (currentPage == 1 && response.data.count == 0) {
            $("#result").append("<div class='col-12'><h3 class='text-center'>No Match Found</h3></div>");
          }
        } else {
          currentPage++;
          $("#btnShowMore").prop("ShowMore");
          $("#btnShowMore").prop("disabled", false);
        }
      });
    }
  }
</script>
@endsection