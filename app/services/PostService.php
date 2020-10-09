<?php

namespace App\Services;

use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function getById($postId)
    {
        return $this->postRepository->getById($postId);
    }

    public function updatePost($data,$id)
    {
        $validator = Validator::make($data,[
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $post = $this->postRepository->updatePost($data,$id);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());

            throw new InvalidArgumentException("Unable to Update Post Data");
        }

        DB::commit();

        return $post;

    }

    public function deleteById($id)
    {
        DB::beginTransaction();

        try{
            $post = $this->postRepository->deleteById($id);
        }catch(Exception $exception){
            DB::rollback();
            Log::info($exception->getMessage());

            throw new InvalidArgumentException('Unable to delete this photo');
        }

        DB::commit();

        return $post;
    }
}
