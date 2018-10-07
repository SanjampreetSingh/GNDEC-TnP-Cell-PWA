<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAboutRequest;
use DB;
use Exception;
use Notification;
use JWTAuth;
use App\Services\AboutService;
use App\Repositories\AboutRepository;

class AboutController extends Controller
{
    public function __construct(AboutService $service,AboutRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth = JWTAuth::parseToken()->authenticate();
        $limit  = $request->input('limit') ?? 10;
        $posts = $this->repository->list($limit);
        return $this->respondData($posts);
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
    public function store(CreateAboutRequest $request)
    {
        $auth = JWTAuth::parseToken()->authenticate();
        try {
            DB::beginTransaction();
            if (!$auth) {
                return $this->respondUnauthorized('About Failed');
            }
            $about = $request->all();
            if ($request->hasFile('image')) {
                $about['image'] = $this->service->uploadAboutImageService($about);
            } 
            
            $aboutCreate = $this->service->createAbout($about);
            DB::commit();
            return $this->respondSuccess('Inserted', $aboutCreate);
        }
        catch (Exception $e) {
            DB::rollback();
            return $this->respondException($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        $auth = JWTAuth::parseToken()->authenticate();
        return $this->respondData($about);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(About $about)
    {
        $auth = JWTAuth::parseToken()->authenticate();
        return $this->respondData($about);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateAbouttRequest $request,About $about)
    {
        $auth = JWTAuth::parseToken()->authenticate();
        try {
            DB::beginTransaction();
            if(!$auth){
                return $this->respondError('Failed', 401); 
            }
            $data = $request->all();
            $about->title = $request->title;
            $about->body = $request->body;
            $about->tag = $request->tag;
            $about->category = $request->category;
            if ($request->hasFile('image')) {
                $about['image'] = $this->service->uploadAboutImageService($data);
            } 
            $about->save(); 
            DB::commit();
            return $this->respondSuccess('Updated',$about);
        } catch (Exception $e) {
            DB::rollback();
            return $this->respondException($e);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        $auth = JWTAuth::parseToken()->authenticate();
        // $post['image'] = $this->service->deletePostImage($post);
        // $delete = Post::destroy($post->id);
        $delete = $this->repository->delete($about);
        $index= About::orderBy('created_at', 'desc')->get();
        return $this->respondSuccess('Deleted', $index);
    }
}