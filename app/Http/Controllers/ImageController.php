<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Glide\Server;

class ImageController extends Controller
{
    public function show(Server $glide)
    {
        try {
            return $glide->fromRequest()->response();
        } catch (Exception $ex) {
            abort(Response::HTTP_NOT_FOUND);
        }
    }
}