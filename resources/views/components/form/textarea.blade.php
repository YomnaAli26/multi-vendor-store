@props([
    'value'=>'',
    'name',
    'id'=>''
    ])


<textarea id="{{$id}}" name="{{$name}}"
{{$attributes->class(['form-control','is-invalid'=>$errors->has($name)])}}>{{old($name,$value)}}
</textarea>
@error($name)<p class="text text-danger">{{$message}}</p>@enderror
