<?php

namespace App\Models;

use App\Lib\General;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Support\Facades\Auth;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'dateOfBirth',
        'gender',
        'annualIncome',
        'occupation',
        'familyType',
        'manglik',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function createUser($params)
    {
        $user = new self;
        $user->firstName = $params['firstName'];
        $user->lastName = $params['lastName'];
        $user->email = $params['email'];
        $user->password = Hash::make($params['password']);
        $user->dateOfBirth = $params['dateOfBirth'];
        $user->gender = $params['gender'];
        $user->annualIncome = $params['annualIncome'];
        $user->occupation = $params['occupation'];
        $user->familyType = $params['familyType'];
        $user->manglik = $params['manglik'];
        if ($user->save()) {
            return General::success_res("Singup successful! Redirecting...", ['user' => $user]);
        } else {
            return General::error_res("Something went to wrong!");
        }
    }

    public static function createGoogleUser($params)
    {
        $user = new self;
        $user->firstName = $params['firstName'];
        $user->lastName = $params['lastName'];
        $user->email = $params['email'];
        if ($user->save()) {
            return General::success_res("Singup successful! Redirecting...", ["user" => $user]);
        } else {
            return General::error_res("Something went to wrong!");
        }
    }

    public static function updateUser($id, $params)
    {
        $user = self::where("id", $id)->first();
        $user->firstName = $params['firstName'];
        $user->lastName = $params['lastName'];
        $user->dateOfBirth = $params['dateOfBirth'];
        $user->gender = $params['gender'];
        $user->annualIncome = $params['annualIncome'];
        $user->occupation = $params['occupation'];
        $user->familyType = $params['familyType'];
        $user->manglik = $params['manglik'];
        if ($user->save()) {
            return General::success_res("Profile updated..");
        } else {
            return General::error_res("Something went to wrong!");
        }
    }

    public static function filterUsers($params)
    {
        $user_id = Auth::guard('user')->user()->id;
        $partnerPreference = PartnerPreference::where('user_id', $user_id)->first();
        $count = 0;
        $users = [];
        $isPref = true;
        if ($partnerPreference) {
            $minExpectedIncome = $partnerPreference->minExpectedIncome;
            $maxExpectedIncome = $partnerPreference->maxExpectedIncome;
            $occupation = explode(',', $partnerPreference->occupation);
            $familyType = explode(',', $partnerPreference->familyType);
            $manglik = $partnerPreference->manglik;

            $usersData = self::orderBy('id', 'desc');
            $usersData = $usersData->whereBetween("annualIncome", [$minExpectedIncome, $maxExpectedIncome]);
            $usersData = $usersData->whereIn("occupation", $occupation);
            $usersData = $usersData->whereIn("familyType", $familyType);
            $usersData = $usersData->where("manglik", $manglik);
            $usersData = $usersData->where("id", "<>", $user_id);
            $usersData = $usersData->where("gender", "<>", Auth::guard('user')->user()->gender);

            $itemPerPage = config('constant.ITEM_PER_PAGE');
            $currentPage = $params['currentPage'];
            $start = ($currentPage - 1) * $itemPerPage;
            $users = $usersData->skip($start)->take($itemPerPage)->get()->toArray();
            $count = count($users);
        } else {
            $isPref = false;
        }
        return ["users" => $users, "count" => $count, "isPref" => $isPref];
    }
}
