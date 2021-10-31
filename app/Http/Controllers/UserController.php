<?php

namespace App\Http\Controllers;

use App\Lib\General;
use App\Models\PartnerPreference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{

  public function getLogin()
  {
    if (Auth::guard('user')->check()) {
      return redirect("/");
    }
    return view("login", ["title" => "Login"]);
  }

  public function postLogin(Request $request)
  {
    $params = $request->all();
    $validationRules = [
      'email' => 'required|email',
      'password' => 'required|min:6'
    ];
    $validate = General::validation($params, $validationRules);
    if ($validate['flag'] != 1) {
      return $validate;
    }
    $user = \App\Models\User::where("email", $params['email'])->first();
    if (!$user) {
      return General::error_res("Invalid Email-id or Password");
    }
    if (!Hash::check($params['password'], $user->password)) {
      return General::error_res("Invalid Email-id or Password");
    }
    Auth::guard("user")->loginUsingId($user->id);
    return General::success_res('Login successful! Redirecting...');
  }

  public function getSignup()
  {
    if (Auth::guard('user')->check()) {
      return redirect("/");
    }
    return view("signup", ["title" => "Signup"]);
  }

  public function postSignup(Request $request)
  {
    $params = $request->all();
    $validationRules = [
      'firstName' => 'required|alpha',
      'lastName' => 'required|',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6|max:32',
      'confirmPassword' => 'required|same:password',
      'dateOfBirth' => 'required',
      'gender' => 'required|size:1|in:m,f',
      'annualIncome' => 'required|numeric|gt:0',
      'occupation' => 'nullable|integer|in:1,2,3',
      'familyType' => 'nullable|integer|in:1,2',
      'manglik' => 'nullable|integer|in:1,2'
    ];
    $validate = General::validation($params, $validationRules);
    if ($validate['flag'] != 1) {
      return $validate;
    }
    $validationRules = [
      'minExpectedIncome' => 'required|numeric',
      'maxExpectedIncome' => 'required|numeric',
      'occupation' => 'required',
      'familyType' => 'required',
      'manglik' => 'required|integer|in:1,2'
    ];
    $validate = General::validation($params, $validationRules);
    if ($validate['flag'] != 1) {
      return $validate;
    }
    $response = \App\Models\User::createUser($params);
    if ($response['flag'] == 1) {
      PartnerPreference::updateOrCreate(
        ['user_id' => $response['data']['user']['id']],
        [
          'minExpectedIncome' => $params['minExpectedIncome'],
          'maxExpectedIncome' => $params['maxExpectedIncome'],
          'occupation' => implode(',', $params['expectedOccupation']),
          'familyType' => implode(',', $params['expectedFamilyType']),
          'manglik' => $params['expectedManglik']
        ]
      );
    }
    return $response;
  }

  public function getHome()
  {
    if (!Auth::guard('user')->check()) {
      return redirect("login");
    }
    return view("home", ['title' => "Home", "id" => "home"]);
  }

  public function postFilterPartnerSuggestion(Request $request)
  {
    $params = $request->all();
    $res = User::filterUsers($params);
    $response = General::success_res();
    $response['data']['blade'] = view("filter-partner-suggection", ["users" => $res['users']])->render();
    $response['data']['count'] = $res['count'];
    $response['data']['isPref'] = $res['isPref'];
    return $response;
  }

  public function getPartnerPreference()
  {
    if (!Auth::guard('user')->check()) {
      return redirect("login");
    }
    $partnerPreference = PartnerPreference::where("user_id", Auth::guard('user')->user()->id)->first();
    if (!$partnerPreference) {
      $partnerPreference['minExpectedIncome'] = config('constant.DEFUALT_EXPECTED_INCOME_RANGE.min');
      $partnerPreference['maxExpectedIncome'] = config('constant.DEFUALT_EXPECTED_INCOME_RANGE.max');
      $partnerPreference['occupation'] = "";
      $partnerPreference['familyType'] = "";
      $partnerPreference['manglik'] = "";
    }
    return view('partner-preference', ["partnerPreference" => $partnerPreference, "title" => "Partner Preference", "id" => "partnerPreference"]);
  }

  public function postPartnerPreference(Request $request)
  {
    $params = $request->all();
    Log::info($params);
    $validationRules = [
      'minExpectedIncome' => 'required|numeric',
      'maxExpectedIncome' => 'required|numeric',
      'occupation' => 'required',
      'familyType' => 'required',
      'manglik' => 'required|integer|in:1,2'
    ];
    $validate = General::validation($params, $validationRules);
    if ($validate['flag'] != 1) {
      return $validate;
    }
    PartnerPreference::updateOrCreate(
      ['user_id' => Auth::guard('user')->user()->id],
      [
        'minExpectedIncome' => $params['minExpectedIncome'],
        'maxExpectedIncome' => $params['maxExpectedIncome'],
        'occupation' => implode(',', $params['occupation']),
        'familyType' => implode(',', $params['familyType']),
        'manglik' => $params['manglik']
      ]
    );
    return General::success_res();
  }

  public function getProfile()
  {
    if (!Auth::guard('user')->check()) {
      return redirect("login");
    }
    $user = User::where("id", Auth::guard('user')->user()->id)->first();
    if (!$user) {
      return redirect('login');
    }
    return view('profile', ["user" => $user, "title" => "Profile", "id" => "profile"]);
  }

  public function postProfile(Request $request)
  {
    $params = $request->all();
    Log::info($params);
    $validationRules = [
      'firstName' => 'required|alpha',
      'lastName' => 'required|',
      'dateOfBirth' => 'required',
      'gender' => 'required|size:1|in:m,f',
      'annualIncome' => 'required|numeric|gt:0',
      'occupation' => 'nullable|integer|in:1,2,3',
      'familyType' => 'nullable|integer|in:1,2',
      'manglik' => 'nullable|integer|in:1,2'
    ];
    $validate = General::validation($params, $validationRules);
    if ($validate['flag'] != 1) {
      return $validate;
    }
    $response = \App\Models\User::updateUser(Auth::guard('user')->user()->id, $params);
    return $response;
  }

  public function getLogout()
  {
    if (!Auth::guard('user')->check()) {
      return redirect("login");
    }
    Auth::guard('user')->logout();
    return redirect("login");
  }

  public function getGoogleRedirect()
  {
    if (Auth::guard('user')->check()) {
      return redirect("login");
    }
    return Socialite::driver('google')->redirect();
  }

  public function getGoogleCallback()
  {
    if (Auth::guard('user')->check()) {
      return redirect("login");
    }
    $googleUser = Socialite::driver('google')->user();
    $user = User::where('email', $googleUser->email)->first();
    if (!$user) {
      $params = [
        "firstName" => $googleUser->user['given_name'],
        "lastName" => $googleUser->user['family_name'],
        "email" => $googleUser->user['email'],
      ];
      $res = User::createGoogleUser($params);
      if ($res['flag'] != 1) {
        return redirect("login");
      } else {
        $user = $res['data']['user'];
      }
    }
    Auth::guard("user")->loginUsingId($user->id);
    return redirect("/");
  }
}
