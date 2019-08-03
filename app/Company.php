<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    public function removeLogo()
    {
        if (Storage::exists($this->logo)) {
            Storage::delete($this->logo);
        }

        $this->update(['logo' => null]);
    }
}
