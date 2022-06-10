<?php

namespace App\Http\Controllers;
use App\Http\Repositories\DestinationRepository\DestinationRepositoryInterface;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DestinationController extends Controller
{
    //
    protected $detinationRepo;
    public function __construct(DestinationRepositoryInterface $detinationRepo)
    {       
        $this->detinationRepo = $detinationRepo;
        $this->middleware('auth:api');
    }

    public function createDestination(){
        $input = request()->all();
        list($errors,$output) = $this->detinationRepo->validate($input);
        if(count($errors) > 0){
            return response()->json([
                'status' => 'Create fail',
                'message' => $errors
            ], 422);
        }
        $result = $this->detinationRepo->createDestination($output);
        return $result;
    }
    

}
