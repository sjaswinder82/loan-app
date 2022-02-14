<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function respondItem($resource, $transformer, $type, $message = null)
    {
        $response =  fractal($resource, $transformer)
                    ->withResourceName($type)
                    ->toArray();

        if($message) {
            $response['message'] = $message;
        }

        return response()->json($response);
    }

    public function respondCollection($resource, $transformer, $type)
    {
        $response =  fractal($resource, $transformer)
                    ->withResourceName($type)
                    ->toArray();

        return response()->json($response);
    }


    public function respondCreated($resource, $transformer, $type, $message = null)
    {
        $response =  fractal($resource, $transformer)
                    ->withResourceName($type)
                    ->toArray();

        if($message) {
            $response['message'] = $message;
        }

        return response()->json($response, 201);
    }

    public function respondError($message='Error', $code=422)
    {        
        $response['message'] = $message;

        return response()->json($response, $code);
    }
}
