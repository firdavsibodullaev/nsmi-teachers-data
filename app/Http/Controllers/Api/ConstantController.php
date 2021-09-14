<?php

namespace App\Http\Controllers\Api;

use App\Constants\PostConstants;
use App\Http\Controllers\Controller;

class ConstantController extends Controller
{
    /**
     * @return array
     */
    public function posts(): array
    {
        return PostConstants::translatedList();
    }
}
