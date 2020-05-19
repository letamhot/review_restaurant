<?php

namespace App\Repositories\Implement;

use App\Models\Category;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


// use Illuminate\Http\Request;
class PostRepositoryImpl extends EloquentRepository implements PostRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return Post::class;
    }

    public function create($request)
    {
     
        try {
                $image =  $request->file('cover_image');
                // dd($image);
                $title = $request->title;
                    if (isset($image)) {
                        // tạo tên file duy nhất ko trùng lặp
                        $currentDate = Carbon::now()->toDateString();
                        $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                        // trỏ tới thư mục public/post
                        $path = public_path().'/posts';
                        // nếu chưa có thư mục thì tạo thư mục
                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0777, true);
                        }
   
                        // lưu ảnh
                        $image->move($path, $imageName);
                    } else {
                        // đặt giá trị mặc định cho file
                        $imageName = 'default.png';
                    }
                $userID = Auth::id();
                $post =  $this->getPost();
                $post->user_id = $userID;
                $post->category_id = $request->category_id;
                $post->title = $title;
                // using the mutator setSlugAttribute()
                $post->slug = $title;
                $post->cover_image = $imageName;
                $post->content = $request->content;
                if($request->is_approved == 'on')
                {
                    $post->is_approved = 1;
                } else {    
                    $post->is_approved = 0;
                }
                $post->save();
                $post->categories()->sync($request->categories, false); // syncWithoutDetaching
                $post->tags()->sync($request->tags, false);
        } catch (\Exception $e) {
            dd($e->getMessage());
            // return null;
        }

        return true;
    }

    public function update($request, $post)
    {
        try {
            $image = $request->cover_image;
            // dd($image);
            $title = $request->title;
            if (isset($image)) {
                    // tạo tên file duy nhất ko trùng lặp
                    $currentDate = Carbon::now()->toDateString();
                    $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                    // trỏ tới thư mục public/post
                    $path = public_path().'/posts';
                    // nếu chưa có thư mục thì tạo thư mục
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0777, true);
                    }
                    
                    $oldPath = public_path()."/posts/".$post->cover_image;
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    // lưu ảnh
                    $image->move($path, $imageName);
                } else {
                    // đặt giá trị mặc định cho file
                    $imageName = $post->cover_image;
                }
         
            $userID = Auth::id();
            $post->user_id = $userID;
            $post->category_id = $request->category_id;
            $post->title = $title;
            // using the mutator setSlugAttribute()
            $post->slug = $title;
            $post->cover_image = $imageName;
            $post->content = $request->content;
            if($request->is_approved == 'on')
            {
                $post->is_approved = 1;
            } else {
                $post->is_approved = 0;
            }

            $post->update();
            $post->categories()->sync($request->categories, false); // syncWithoutDetaching
            $post->tags()->sync($request->tags, false);

            
        } catch (\Exception $e) {
            return null;
        }

        return true;
    }

    public function destroy($id)
    {
        try {
            $post = $this->getPost()::findOrFail($id);
            $post->delete();
        } catch (\Exception $e) {
            return null;
        }
    }


    public function findByIdOnlyTrashed($id)
    {
        $result = $this->getPost()->onlyTrashed()->find($id);
        return $result;
    }

    // public function getAll(){
    //     return $this->getPost()->orderBy('created_at','desc')->get();
    // }
    public function getAllCategory(){
        try {
            $data = Category::select('id','name');

            return DataTables::of($data)->toJson();
        } catch (\Exception $e) {
            return null;
        }
    }


    protected function getPost()
    {
        return app()->make($this->getModel());
    }

    

}