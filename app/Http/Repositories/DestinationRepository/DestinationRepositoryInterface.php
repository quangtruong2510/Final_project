<?php

namespace App\Http\Repositories\DestinationRepository;

interface DestinationRepositoryInterface {
  public function createDestination($destination);

  public function findDestinationById($user_id);

  public function updateDestination($destination,$id);

  public function deleteDestinationById($id);

  public function validate($input);



}