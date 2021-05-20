<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'nickname',
        'nif',
        'email',
        'zip_code',
        'address',
        'city_id',
        'phone',
        'logo',
        'state_registration',
        'district',
        'number',
        'complement'
    ];

    public static function types($option = null)
    {
        $options = [
            1 => 'ADMINISTRADOR',
            2 => 'GERENTE',
            3 => 'CLIENTE' /** opção cliente se refere a opção normal do usuário **/
        ];

        if (!$option)
            return $options;

        return $options[$option];
    }

    /**
     * The city of the people.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * The user of the people.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * The client of the people.
     */
}
