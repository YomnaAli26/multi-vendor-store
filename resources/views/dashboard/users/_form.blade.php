<div  class="form-group">
    <x-form.label id="name">Name</x-form.label>
   <x-form.input type="text" name="name" :value="$user->name"/>

</div>
<div class="form-group">
    <x-form.label id="parent_id">Email</x-form.label>
    <x-form.input type="email" name="email" :value="$user->email"/>

</div>
<div class="form-group">
    <x-form.label id="parent_id">Password</x-form.label>
    <x-form.input type="password" name="password" :value="$user->password"/>

</div>

<div class="form-group">
    <fieldset>
        <legend> {{__('Roles')}} </legend>
        @foreach($roles as $role)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="roles[]" value="{{$role->id}}">
                <label class="form-check-label">{{$role->name}}</label>
            </div>
        @endforeach
    </fieldset>

</div>


<div class="form-group">
    <input type="submit" value="{{$button_label ?? 'Save'}}" class="btn btn-primary">
</div>
