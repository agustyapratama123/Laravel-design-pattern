<?php 

namespace App\Repositories;

use App\Http\Resources\PostCollection;
use App\Models\Post;

class PostRepository  
{
    public function getAll(){
        return PostCollection::collection(Post::all());
    }

    public function save($data)
    {
        $post = Post::create([
            'title'  => $data['title'],
            'body'   => $data['body'],
        ]);

        return $post;
    }
}
