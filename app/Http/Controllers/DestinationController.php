<?php

namespace App\Http\Controllers;
use App\Http\Repositories\DestinationRepository\DestinationRepositoryInterface;
use App\Http\Repositories\CategoryRepository\CategoryRepositoryInterface;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaravelCloudinary;

class DestinationController extends Controller
{
    //
    protected $destinationRepo;
    protected $categoryRepo;
    public function __construct(DestinationRepositoryInterface $destinationRepo, CategoryRepositoryInterface $categoryRepo) 
    {   
        $this->categoryRepo = $categoryRepo;
        $this->destinationRepo = $destinationRepo;
        $this->middleware('auth:api');
    }

    public function createDestination(Request $request){
        $input = request()->all();
        list($errors,$output) = $this->destinationRepo->validate($input);
        if(count($errors) > 0){
            return response()->json([
                'status' => 'Create fail',
                'message' => $errors
            ], 422);
        }
        $destination = $this->destinationRepo->createDestination($output);
        if($destination){
            $this->categoryRepo->updateQuantity( $destination->category_id);
        }
        return response()->json([
            'message' => 'Created Successfully!',
            'data' => $destination
        ],201);
    }
    public function deleteDestination($id){
        if( ! $destination = $this->destinationRepo->findDestinationById($id)) {
            return response()->json([
                'message' => 'fail',
                'message' => 'invalid ID',
            ],400);
        }
        $idCategory = $destination->category_id;
        if ( $this->destinationRepo->deleteDestinationById($id) )
        {   
            $this->categoryRepo->updateQuantity($idCategory);
        }
        return  response()->json([
            'message' => 'Deleted Successfully!',
            200
        ]);;
    }

    public function getDestinationByCategoryId($id){
        $destinations = $this->destinationRepo->getDestinationByCategoryId($id);
        return response()->json([
            'message'   => 'Get Successfully',
            'data'      => $destinations
        ],200);
    }

    public function updateDestination($id){
        if( ! $this->destinationRepo->findDestinationById($id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'invalid ID',
            ],400);
        }
        $input = request()->all();
        list($errors,$output) = $this->destinationRepo->validate($input);
        if(count($errors) > 0){
            return response()->json([
                'status' => 'Fail ',
                'message' => $errors
            ], 422);
        }
        $result = $this->destinationRepo->updateDestination($id,$input);
        return response()->json([
            'message'   => 'Updated Successfully',
            'data'      => $output
        ],201);
    }
    
    public function getAllDestination(){
        $result = $this->destinationRepo->getListDestinations();
        return response()->json([
            'message'   => 'Get Successfully',
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
            'message'   => 'Get Successfully',
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
        $result = $this->destinationRepo->updateStatusFavouriteDestinations($id);
        return response()->json([
            'message'   => 'Successfully Updated',
            'data'      => $result
        ],200);
    }

    public function addToScheduleListDestination($id){
        if( ! $this->destinationRepo->findDestinationById($id)) {
            return response()->json([
                'message' => 'fail',
                'message' => 'invalid ID',
            ],400);
        }
        $result = $this->destinationRepo->addDestinationToSchedule($id);
        return response()->json([
            'message'   => 'Successfully',
            'data'      => $result
        ],200);
    }

    public function getListScheduleDestination(){
        $result = $this->destinationRepo->getListScheduleDestination();
        return response()->json([
            'message'   => 'Successfully',
            'data'      => $result
        ],200);
    }

    public function deleteDestinationFromListSchedule($id){
        if( ! $destination = $this->destinationRepo->findDestinationById($id)) {
            return response()->json([
                'message' => 'fail',
                'message' => 'invalid ID',
            ],400);
        }
        
        if( $this->destinationRepo->deleteScheduleDestinationById($id)){
            return  response()->json([
                'message' => 'Deleted Successfully!',
            ],200);;
        }
    }

    public function deleteScheduleList(){
        if( $this->destinationRepo->deleteScheduleList()){
            return  response()->json([
                'message' => 'Deleted Successfully!',
                
            ],200);;
        }
    }

}
