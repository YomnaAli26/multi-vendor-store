<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //SELECT child.* ,parent.name as parent_name FROM categories as child
        //leftjoin categories as parent ON  parent.id = child.parent_id
        $categories = Category::with('parent')
        /*leftjoin('categories as parent','parent.id','=','categories.parent_id')
            ->select('categories.*','parent.name as parent_name')*/
//           ->select('categories.*')
//            ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count ')
            ->withCount([
                'products'=>function($query){
                $query->where('status','active');
            }])
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate();
        return view("dashboard.categories.index",compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view("dashboard.categories.create",compact('parents','category'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());
        $data = $request->except('image');
        $request->merge(['slug'=>Str::slug($request->post('name'))]);
        $path = $this->uploadImage($request);
        $data['image'] = $path;

        Category::create($data);
        return redirect()->route('dashboard.categories.index')
            ->with('success','Category created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //SELECT * FROM categories WHERE id <> $id AND
        //(parent_id IS NULL OR parent_id <> $id)
        $parents = Category::where('id','<>',$id)
            ->where(function ($query) use ($id){
                $query->whereNull('parent_id')
                    ->orwhere('parent_id','<>',$id);
            })
            ->get();
        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(Category::rules($id));
        $category = Category::findorFail($id);
        $old_image = $category->image;
        $data = $request->except('image');
        $new_image = $this->uploadImage($request);
        if ($new_image)
        {
            $data['image'] = $new_image;
        }
        $category->update($data);
        if ($old_image && $new_image)
        {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success','Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('dashboard.categories.index')
            ->with('success','Category deleted!');


    }
    protected function uploadImage($request)
    {
        if (!$request->hasFile('image'))
        {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads','public');
        return $path;

    }
    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(4);
        return view('dashboard.categories.trash',compact('categories'));
    }
    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.index')->with('success','Category restored!');

    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category->image)
        {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')->with('success','Category deleted forever!');

    }
}
