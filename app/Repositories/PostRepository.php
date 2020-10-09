<?php 

namespace App\Repositories;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostRepository  
{

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
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

    public function getById($postId)
    {
        $post = $this->post->where('id',$postId)->first();
        return new PostResource($post);
    }

    public function updatePost($data,$id)
    {
        $post = $this->post->find($id);

        return $post->update([
            'title' => $data['title'],
            'body' => $data['body'],
        ]);
    }
}
