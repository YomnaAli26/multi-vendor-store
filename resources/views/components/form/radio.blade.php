@props([
    'name','options','value','text','checked'=>false
    ])
@foreach($options as $value => $text)
<div class="form-check">
    <input id="{{$value}}"  type="radio" name="{{$name}}" value="{{$value}}"
        @checked(old($name,$checked) == $value)
    {{$attributes->class([
    'form-check-input'])}}
    >
    <label class="form-check-label" for="{{$value}}">
        {{$text}}
    </label>
</div>
@endforeach
