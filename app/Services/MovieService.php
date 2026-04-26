<?php

namespace App\Services;

use App\Interfaces\MovieRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MovieService
{
    protected $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getAllMovies($search)
    {
        return $this->movieRepository->getAllMovies($search);
    }

    public function getPaginatedData()
    {
        return $this->movieRepository->getPaginatedData();
    }

    public function getMovieById($id)
    {
        return $this->movieRepository->getMovieById($id);
    }

    public function getAllCategories()
    {
        return $this->movieRepository->getAllCategories();
    }

    public function storeMovie(array $data, $file)
    {
        // Logika upload foto dipindah ke sini
        if ($file) {
            $randomName = Str::uuid()->toString();
            $fileExtension = $file->getClientOriginalExtension() ?: 'jpg';
            $fileName = $randomName . '.' . $fileExtension;
            $file->move(public_path('images'), $fileName);
            
            $data['foto_sampul'] = $fileName;
        }

        return $this->movieRepository->createMovie($data);
    }

    public function updateMovie($id, array $data, $file = null)
    {
        // Jika ada file baru yang diunggah
        if ($file) {
            $movie = $this->getMovieById($id);
            
            // Hapus foto lama
            if (File::exists(public_path('images/' . $movie->foto_sampul))) {
                File::delete(public_path('images/' . $movie->foto_sampul));
            }

            // Simpan foto baru
            $randomName = Str::uuid()->toString();
            $fileExtension = $file->getClientOriginalExtension() ?: 'jpg';
            $fileName = $randomName . '.' . $fileExtension;
            $file->move(public_path('images'), $fileName);
            
            $data['foto_sampul'] = $fileName;
        }

        return $this->movieRepository->updateMovie($id, $data);
    }

    public function deleteMovie($id)
    {
        $movie = $this->getMovieById($id);
        
        // Hapus foto sebelum menghapus data di database
        if (File::exists(public_path('images/' . $movie->foto_sampul))) {
            File::delete(public_path('images/' . $movie->foto_sampul));
        }

        return $this->movieRepository->deleteMovie($id);
    }
}