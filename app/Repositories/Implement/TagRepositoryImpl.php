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

    public function ajaxUpdate($id)
    {
        return $this->getTag()->find($id);
    }

    public function ajaxDestroy($id)
    {
        $this->getTag()->find($id)->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }

    protected function getTag()
    {
        return app()->make($this->getModel());
    }

    public function showdeleted()
    {
        try {
            return $this->getTag()->onlyTrashed()->get();
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
