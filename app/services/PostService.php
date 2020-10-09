<?php

namespace App\Services;

use InvalidArgumentException;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Validator;


class PostService 
{

    protected $postRepository;

    public function __construct(PostRepository $postRepository){
        $this->postRepository = $postRepository;
    }

    public function getAll(){
        return $this->postRepository->getAll();
    }

    public function savePostData($data)
    {
        $validator = Validator::make( $data, [
        'title' => 'required',
        'body'   => 'required'    
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->postRepository->save($data);

        return $result;
    }

    public function getById($post)
    {
        return $this->postRepository->getById($post);
    }
}
