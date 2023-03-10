<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    /**
    * create new instance
    *
    * @param Post $model
    */
    public function __construct(Post $model)
    {
        $this->model = $model;         
    }
    
    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }
    
    public function list($limit = false)
    {
        $builder = Post::orderBy('created_at', 'desc');
        if(!$limit) {
            return $builder->get();
        }
        return $builder->paginate($limit);
    }
    
    // create new record
    public function create(array $data)
    {
        $data = $this->setPayload($data);
		return $this->model->create($data);
    }
    
    
    public function uploadPostImage(array $data)
	{
        $data = $this->setPayload($data);
		$extension = strtolower($data['image']->getClientOriginalExtension());
		$filename = 'post_'.str_random().'.'.$extension;
		$path =  public_path('images/posts/images/');
		$imageLocation = $data['image']->move($path, $filename);
		// $image_path = $path.$filename;
		return $filename;
	}

    // remove record from the database
    public function delete(Post $post)
    {
        $delete = Post::destroy($post->id);
        return $delete;
    }
    
    private function setPayload(array $payload)
	{
		return [
			'title'              => $payload['title'],
			'body'				 => $payload['body'],
			'username'	 	     => $payload['username'],
			'user_id'	 	     => $payload['user_id'],
			'tag'	 	         => $payload['tag'],
			'category'	 	     => $payload['category'],
			'post_link'	 	     => $payload['post_link'],
			'image'	         	 => $payload['image'],
		];
	}
}