@props(['name','options'=>[],'default_option_name'=>'','selected'=>false])
<select name="{{$name}}" id="{{$name}}" {{$attributes->class(['form-control form-select'])}}>
    <option value="">{{$default_option_name}}</option>
    @if($options instanceof \Illuminate\Database\Eloquent\Collection)
    @foreach($options as $option)
        <option value="{{$option->id}}" @selected(old($name,$selected) == $option->id)>{{ $option->name }}</option>
    @endforeach
    @else
        @foreach($options as $option=>$text)
            <option value="{{$option}}" @selected(old($name,$selected) == $option)>{{ $text }}</option>
        @endforeach
    @endif
</select>
