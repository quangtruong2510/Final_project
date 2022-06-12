<?php

namespace App\Http\Controllers;
use App\Http\Repositories\DestinationRepository\DestinationRepositoryInterface;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DestinationController extends Controller
{
    //
    protected $destinationRepo;
    public function __construct(DestinationRepositoryInterface $destinationRepo)
    {       
        $this->destinationRepo = $destinationRepo;
        $this->middleware('auth:api');
    }

    public function createDestination(){
        $input = request()->all();
        list($errors,$output) = $this->destinationRepo->validate($input);
        if(count($errors) > 0){
            return response()->json([
                'status' => 'Create fail',
                'message' => $errors
            ], 422);
        }
        $result = $this->destinationRepo->createDestination($output);
        return response()->json([
            'message' => 'Successfully Created ',
            'data' => $result
        ],201);
    }
    public function deleteDestination($id){
        if( ! $this->destinationRepo->findDestinationById($id)) {
            return response()->json([
                'message' => 'fail',
                'message' => 'invalid ID',
            ],400);
        }
        $this->destinationRepo->deleteDestinationById($id);
        return  response()->json([
            'message' => 'Successfully deleted',
            200
        ]);;
    }

    public function updateDestination($id){
        if( ! $this->destinationRepo->findDestinationById($id)) {
            return response()->json([
                'message' => 'fail',
                'message' => 'invalid ID',
            ],400);
        }
        $input = request()->all();
        list($errors,$output) = $this->destinationRepo->validate($input);
        // dd($errors,$output);
        if(count($errors) > 0){
            return response()->json([
                'status' => 'Create Update',
                'message' => $errors
            ], 422);
        }
        $result = $this->destinationRepo->updateDestination($id,$input);
        return response()->json([
            'message'   => 'Successfully Updated',
            'data'      => $output
        ],201);
    }
    
    public function getAllDestination(){
        $result = $this->destinationRepo->getListDestinations();
        return response()->json([
            'message'   => 'Successfully',
            'data'      => $result
        ],200);
    }

    public function getDestinationById($id){
        $destination =  $this->destinationRepo->findDestinationById($id);
        if( ! $destination) {
            return response()->json([
                'message' => 'fail',
                'message' => 'invalid ID',
            ],400);
        }
        return response()->json([
            'message'   => 'Successfully',
            'data'      => $destination
        ],200);
    }

    public function getListFavouriteDestination(){
        $result = $this->destinationRepo->getListFavouriteDestinations();
        return response()->json([
            'message'   => 'Successfully',
            'data'      => $result
        ],200);
    }

    public function addToFavouriteListDestination($id){
        if( ! $this->destinationRepo->findDestinationById($id)) {
            return response()->json([
                'message' => 'fail',
                'message' => 'invalid ID',
            ],400);
        }
        $input = request()->all();
        $result = $this->destinationRepo->updateStatusFavouriteDestinations($id,$input);
        return response()->json([
            'message'   => 'Successfully Updated',
            'data'      => $result
        ],201);
    }

    public function getListCategories(){
        
    }


}
