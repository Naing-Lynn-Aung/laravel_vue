<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;

class PostsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Post::updateOrCreate([
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'image' => $row['image']
        ]);
    }
}
