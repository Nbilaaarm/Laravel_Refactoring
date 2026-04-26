<?php

namespace App\Repositories;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use App\Models\Category;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAllMovies($search = null)
    {
        $query = Movie::latest();
        if ($search) {
            $query->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('sinopsis', 'like', '%' . $search . '%');
        }
        return $query->paginate(6)->withQueryString();
    }

    public function getPaginatedData()
    {
        return Movie::latest()->paginate(10);
    }

    public function getMovieById($id)
    {
        return Movie::findOrFail($id);
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function createMovie(array $data)
    {
        return Movie::create($data);
    }

    public function updateMovie($id, array $data)
    {
        $movie = $this->getMovieById($id);
        $movie->update($data);
        return $movie;
    }

    public function deleteMovie($id)
    {
        $movie = $this->getMovieById($id);
        return $movie->delete();
    }
}