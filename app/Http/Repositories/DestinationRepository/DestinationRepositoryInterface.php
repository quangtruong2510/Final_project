<?php

namespace App\Http\Repositories\DestinationRepository;

interface DestinationRepositoryInterface {
  public function createDestination($destination);

  public function findDestinationById($id);

  public function updateDestination($id,$destination);

  public function deleteDestinationById($id);

  public function validate($input);

  public function getListDestinations();

  public function getListFavouriteDestinations();

  public function updateStatusFavouriteDestinations($id,$value);



}