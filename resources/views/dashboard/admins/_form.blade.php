<div  class="form-group">
    <x-form.label id="name">Name</x-form.label>
   <x-form.input type="text" name="name" :value="$admin->name"/>

</div>
<div class="form-group">
    <x-form.label id="parent_id">Email</x-form.label>
    <x-form.input type="email" name="email" :value="$admin->email"/>

</div>
<div class="form-group">
    <x-form.label id="parent_id">User Name</x-form.label>
    <x-form.input type="text" name="username" :value="$admin->username"/>

</div>
<div class="form-group">
    <x-form.label id="parent_id">Password</x-form.label>
    <x-form.input type="password" name="password" :value="$admin->password"/>

</div>
<div class="form-group">
    <x-form.label id="parent_id">Phone Number</x-form.label>
    <x-form.input type="text" name="phone_number" :value="$admin->phone_number"/>

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
