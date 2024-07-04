@props([
    'type'=>'text',
    'value'=>'',
    'name',

    ])

<input id="{{$name}}" type="{{$type}}" name="{{$name}}" value="{{old($name,$value)}}"
{{$attributes->class(['form-control','is-invalid'=>$errors->has($name)])}}>
@error($name)<p class="text text-danger">{{$message}}</p>@enderror
