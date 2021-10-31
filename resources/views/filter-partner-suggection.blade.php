@foreach ( $users as $user ) <div class="col-md-4 col-sm-4 col-12">
  <div class="card mb-4 rounded-3 shadow-sm">
    <div class="card-header py-3">
      <h4 class="my-0 fw-normal">{{ $user['firstName'] }} {{ $user['lastName'] }}</h4>
    </div>
    <div class="card-body">
      <ul class="list-unstyled mt-3 mb-4">
        <li class="text-muted">Date of Birth: <span class="text-dark fw-bolder">{{ $user['dateOfBirth'] }}</span></li>
        <li class="text-muted">Gander: <span class="text-dark fw-bolder">{{ config('constant.GENDER')[$user['gender']] }}</span></li>
        <li class="text-muted">Annual Income: <span class="text-dark fw-bolder">{{ $user['annualIncome'] }} lac</span></li>
        <li class="text-muted">Occupation: <span class="text-dark fw-bolder">{{ config('constant.OCCUPATION_TYPE')[$user['occupation']] }}</span></li>
        <li class="text-muted">Family Type: <span class="text-dark fw-bolder">{{ config('constant.FAMILY_TYPE')[$user['familyType']] }}</span></li>
        <li class="text-muted">Manglik: <span class="text-dark fw-bolder">{{ config('constant.MANGLIK_TYPE')[$user['manglik']] }}</span></li>
      </ul>
    </div>
  </div>
</div>
@endforeach