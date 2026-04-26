<?php

namespace App\Interfaces;

interface MovieRepositoryInterface
{
    public function getAllMovies($search = null);
    public function getPaginatedData();
    public function getMovieById($id);
    public function getAllCategories();
    public function createMovie(array $data);
    public function updateMovie($id, array $data);
    public function deleteMovie($id);
}