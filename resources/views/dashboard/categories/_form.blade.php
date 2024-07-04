<div  class="form-group">
    <x-form.label id="name">Category Name</x-form.label>
   <x-form.input type="text" name="name" :value="$category->name"/>
</div>
<div class="form-group">
    <x-form.label id="parent_id">Category Parent</x-form.label>

    <x-form.select name="parent_id" default_option_name="Primary Category" :options="$parents" :selected="$category->parent_id"/>

</div>
<div class="form-group">
    <x-form.label id="description">Description</x-form.label>
    <x-form.textarea :value="$category->description" name="description" id="description"/>

</div>
<div class="form-group">
    <label for="image">Image</label>
    <x-form.input type="file" name="image"/>
    @if($category->image)
        <img src="{{ asset('storage/'.$category->image) }}"  height="60" alt="">
    @endif

</div>
<div class="form-group">
    <label for="status">Status</label>
    <div>
        <x-form.radio :options="['active'=>'Active','archived'=>'Archived']"
        name="status" :checked="$category->status"/>
        @error('status')<p class="text text-danger">{{$message}}</p>@enderror

    </div>
</div>
<div class="form-group">
    <input type="submit" value="{{$button_label ?? 'Save'}}" class="btn btn-primary">
</div>
