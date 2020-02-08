<?php

include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/design/IGalleryRepository.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class GalleryRepository extends DatabaseContext implements IGalleryRepository
{

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function GetLoggedUserGalleries(User $user){
        $query = "SELECT * FROM php_gallery.galleries
                  WHERE userId =?";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $user->id);
        $statement->execute();
        $results = $statement->get_result();


        $galleries = mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $galleries;
    }

    public function Create($galleryName, int $userId){
        $query = "INSERT INTO php_gallery.galleries (name, userId) VALUES (?,?);";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('si', $galleryName, $userId);
        $statement->execute();
        
    }

}
