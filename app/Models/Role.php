<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function abilities()
    {
        return $this->hasMany(RoleAbility::class,'role_id');
    }

    public static function createRoleAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name'=>$request->post('name')
            ]);
            foreach ($request->post('abilities') as $ability=>$value)
            {
                RoleAbility::create([
                    'role_id'=>$role->id,
                    'ability'=>$ability,
                    'type'=>$value
                ]);
            }
            DB::commit();
            return $role;

        }catch (\Throwable $throwable)
        {
            DB::rollBack();
            throw $throwable;
        }

        }

    public function updateRoleAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
                 $this->update([
                'name'=>$request->post('name')
            ]);
            foreach ($request->post('abilities') as $ability=>$value)
            {

                RoleAbility::updateOrCreate([
                    'role_id'=>$this->id,
                    'ability'=>$ability,
                ],[
                    'type'=>$value
                ]);
            }
            DB::commit();
            return $this;


        }catch (\Throwable $throwable)
        {
            DB::rollBack();
            throw $throwable;
        }

    }


}
