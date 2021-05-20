<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Notifications\ResetPassword;


class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
        'person_id', 'is_enabled',
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function people()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePerson($query)
    {
        return $query->select(
            'users.*',
            'people.name',
            'people.nickname',
            'people.phone',
            'people.nif',
            'people.zip_code',
            'people.address',
            'people.city_id',
            'cities.state_id',
            DB::raw("concat(cities.title, ' - ', states.letter) as city")
        )
            ->join('people', 'people.id', '=', 'users.person_id')
            ->leftJoin('cities', 'cities.id', '=', 'people.city_id')
            ->leftJoin('states', 'states.id', '=', 'cities.state_id');
    }


}
