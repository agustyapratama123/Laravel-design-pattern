<?php 

namespace App\Repositories;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Exceptions\PostNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        
        if(!$post){
            throw new PostNotFoundException('post not found by id '.$postId);
        }
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

    public function deleteById($id)
    {
        $post = $this->post->find($id);
        $post->delete();

        return $post;

    }
}
