<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;
use App\Exceptions\IdDeleteNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $postService;

    public function __construct(PostService $postService){
        $this->postService = $postService;
    }


    public function index()
    {

        try {
            $result = $this->postService->getAll();
        } catch (Exception $exception) {
            $result = [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }

        return response()->json($result,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'body'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->postService->savePostData($data);
        } catch (Exception $exception) {
            $result=[
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }

        return response()->json($result, $result['status']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        $result = ['status' => '200'];

        try{
            $result['data'] = $this->postService->getById($post);
        }catch(Exception $exception){
            $result = [
                'status' => 500,
                'error'  => $exception->getMessage()
            ];

        }catch(PostNotFoundException $exception){
            
            $result = [
                'status' => 500,
                'error'  => 'errrrrrr'
            ];
        
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'title',
            'body'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->postService->updatePost($data,$id);

        } catch (Exception $exception) {
            $result = [
                'status' => 500,
                'error'  => $exception->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ['status' => 200];

        try{
            $result['data'] = $this->postService->deleteById($id);
        }catch(Exception $exception){
            $result = [
                "status" => 500,
                "error" => $exception->getMessage()
            ];
        }catch(IdDeleteNotFoundException $exception){
            $result = [
                "status" => 500,
                "error" => $exception->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
