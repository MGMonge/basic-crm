<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Responsable;

class CannotDeleteCompany extends Exception implements Responsable
{
    /**
     * {@inheritDoc}
     */
    public function toResponse($request)
    {
        return redirect()->back()->withErrors(['general' => $this->getMessage()]);
    }
}