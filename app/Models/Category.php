<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable =[
      'name',
      'parent_id',
      'slug',
      'description',
      'image',
      'status'
    ];
    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id')
            ->withDefault([
                'name'=>'-'
            ]);
    }
    public function childern()
    {
        return $this->hasMany(Category::class,'parent_id');
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status','active');
    }
    public function scopeStatus(Builder $builder,$status)
    {
        $builder->where('status',$status);

    }
    public function scopeFilter(Builder $builder,$filters)
    {
        $builder->when($filters['name']??false,function ($builder,$value){
            $builder->where('name','LIKE',"%{$value}%");

        });
        $builder->when($filters['status']??false,function ($builder,$value){
            $builder->where('status',"{$value}");

        });
    }

    public static function rules($id =0)
    {
        return
            [
                'name'=>[
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    "unique:categories,name,$id",
//                     new Filter(['laravel','php'])
                'filter:php,laravel'
                ],
                'parent_id'=>['nullable','int','exists:categories,id'],
                'description'=>['nullable','min:5','max:255'],
                'image'=>['image','max:1048576','dimensions:min_width=100,min_height=100'],
                'status'=>['in:active,archived'],



            ];
    }
}
