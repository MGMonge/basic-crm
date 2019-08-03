<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_id',
    ];

    public function getFullnameAttribute()
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
