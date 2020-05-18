<?php

namespace App\Repositories\Implement;

use App\Models\Tag;
use App\Repositories\TagRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class TagRepositoryImpl extends EloquentRepository implements TagRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return Tag::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxIndex($request)
    {

        if ($request->ajax()) {
            $data = $this->getTag()::select('*');
            return Datatables::of($data)
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('tags.index', compact('tag'));
    }

    public function ajaxStore($request)
    {
        $this->getTag()::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name, 'slug' => Str::slug($request->name)]
        );

        return response()->json(['success' => 'Product saved successfully.']);
    }

    // public function ajaxUpdate($id)
    // {
    //     $tag = $this->getTag()->find($id);
    //     return response()->json($tag);
    // }

    public function ajaxDestroy($id)
    {
        $this->getTag()->find($id)->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }


    // public function create($request)
    // {
    //     try {
    //         $tags = $this->getTag();
    //         $tags->name = $request->name;
    //         $tags->slug = Str::slug($request->name);
    //         $tags->save();
    //     } catch (\Exception $e) {
    //         return null;
    //     }

    //     return true;
    // }

    // public function update($request, $tag)
    // {
    //     try {
    //         // $tag->update($request->all());
    //         $tag->name = $request->name;
    //         $tag->slug = Str::slug($request->name);
    //         // create unique slug using the mutator setSlugAttribute() no need Str::slug
    //         // $category->slug = $request->name;
    //         $tag->update();
    //     } catch (\Exception $e) {
    //         return null;
    //     }

    //     return true;
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $this->getTag()::findOrFail($id)->delete();
    //     } catch (\Exception $e) {
    //         return null;
    //     }
    // }

    protected function getTag()
    {
        return app()->make($this->getModel());
    }

    public function showdeleted()
    {
        try {
            return $this->getTag()::onlyTrashed()->get();
        } catch (\Exception $e) {
            return null;
        }
    }
    public function restoreDelete($id)
    {
        try {
            return $this->getTag()::onlyTrashed()->findOrFail($id)->restore();
        } catch (\Exception $e) {
            return null;
        }
    }
}
