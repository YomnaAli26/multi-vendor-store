<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'category_id',
        'store_id',
        'slug',
        'description',
        'image',
        'status',
        'price',
        'compare_price',
        'tags',
    ];
    protected $hidden = ['created_at','updated_at','deleted_at','image'];
    protected $appends = ['image_url'];
    protected static function booted()
    {
        static::addGlobalScope('store',new StoreScope());
        static::creating(function (Product $product){
            $product->slug = Str::slug($product->name);
        });

    }

    public function scopeFilter(Builder $builder,$filters)
    {
        $options = array_merge([
            'store_id'=>null,
            'category_id'=>null,
            'tag_id'=>null,
            'status'=>'active'
            ],$filters);

        $builder->when($options['status'],function ($builder,$value){
            $builder->where('status',$value);
        });
        $builder->when($options['store_id'],function ($builder,$value){
            $builder->where('store_id',$value);
        });
        $builder->when($options['category_id'],function ($builder,$value){
            $builder->where('category_id',$value);
        });
        $builder->when($options['tag_id'],function ($builder,$value){
            $builder->whereExists(function ($query) use ($value){
                $query->select(1)
                    ->from('product_tag')
                    ->where('tag_id',$value)
                    ->whereRaw('product_id = products.id');
            });

//            $builder->whereRaw('id IN (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id',[$value]);
//            $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id',[$value]);

            //            $builder->whereHas('tags',function ($builder) use ($value){
//                $builder->where('id',$value);
//            });
        });

    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status','active');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image)
        {
            return 'https://boschbrandstore.com/wp-content/uploads/2019/01/no-image.png';
        }
        if (Str::startsWith($this->image,['http://','https://']))
        {
            return $this->image;
        }
        asset('storage/'.$this->image);
    }

    public function getSalePrecentAttribute()
    {
        if (!$this->compare_price)
        {
            return 0;
        }
        return round(100-($this->price/$this->compare_price*100));
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

}
