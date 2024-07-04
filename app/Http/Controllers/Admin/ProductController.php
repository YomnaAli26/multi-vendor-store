<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['store','category'])->paginate();
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Product::class);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Product::class);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view',$product);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update',$product);

        $categories = Category::all();
        $tags = implode(',',$product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit',
            compact('product','categories','tags'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update',$product);
        $product->update($request->except('tags'));
        $tags =json_decode($request->post('tags'));
        $tag_ids = [];
        //memory
        $saved_tags = Tag::all();
        foreach ($tags as $item)
        {

            $slug = Str::slug($item->value);
            $tag = $saved_tags->where('slug',$slug)->first();
            if (!$tag)
            {
                $tag = Tag::create([
                    'name'=>$item->value,
                    'slug'=>Str::slug($item->value)
                ]);
            }

            $tag_ids[] = $tag->id;

        }
//more sql statements in foreach bad performence
//        foreach ($tags as $t_name)
//        {
//            $slug = Str::slug($t_name);
//            $tag = Tag::where('slug',$slug)->first();
//            if (!$tag)
//            {
//                $tag = Tag::create([
//                    'name'=>$t_name,
//                    'slug'=>Str::slug($t_name)
//                ]);
//            }
//
//            $tag_ids[] = $tag->id;
//
//        }

        $product->tags()->sync($tag_ids);

        return redirect()->route('dashboard.products.index')
            ->with('success','Product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete',$product);
    }
}
