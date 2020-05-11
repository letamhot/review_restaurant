<?php

namespace App\Repositories\Implement;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
                $post->title = $title;
                // using the mutator setSlugAttribute()
                $post->slug = $title;
                $post->cover_image = $imageName;
                $post->content = $request->content;
                // nếu user là Admin thì post được is_approved
                // ngược lại là false chờ approved
                if (1 === $userID) {
                    $post->is_approved = true;
                } else {
                    $post->is_approved = false;
                    // thông báo post chờ duyệt cho admin , mod
                }
                $post->is_approved = $request->is_approved;

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
        // dump($post);
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
                    // xoá ảnh cũ nếu có
                    // để cập nhật ảnh mới
                    
                    $oldPath = public_path()."/posts/".$post->cover_image;
                    // dump(File::exists($oldPath));
                    // dd($oldPath);
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
            $post->title = $title;
            // using the mutator setSlugAttribute()
            $post->slug = $title;
            $post->cover_image = $imageName;
            $post->content = $request->content;
            // nếu user là Admin thì post được is_approved
            // ngược lại là false chờ approved
            // if (1 === $userID) {
            //     $post->is_approved = true;
            // } else {
            //     $post->is_approved = false;
            //     // thông báo post chờ duyệt cho admin , mod
            // }
            // $post->is_approved = $request->is_approved;
            
    if($post->is_approved == 1){
        $post->is_approved = 0;
    } else {
        $post->is_approved = 1;
    }

            $post->update();
            $post->categories()->sync($request->categories, false); // syncWithoutDetaching
            $post->tags()->sync($request->tags, false);
            // $post->update($request);

            
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

    protected function getPost()
    {
        return app()->make($this->getModel());
    }
}