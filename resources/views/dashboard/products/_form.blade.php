@push('styles')
    <link href="{{ asset('css/tagify.css') }}" rel="stylesheet" type="text/css" />
@endpush

<form action="{{ route('dashboard.products.update',$product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div  class="form-group">
        <x-form.label id="name">Product Name</x-form.label>
        <x-form.input type="text" name="name" :value="$product->name"/>
    </div>
    <div class="form-group">
        <x-form.label id="product_id">Category</x-form.label>

        <x-form.select name="product_id" default_option_name="Primary Category" :options="$categories" :selected="$product->category_id"/>
        @error('product_id')<p class="text text-danger">{{$message}}</p>@enderror

    </div>
    <div class="form-group">
        <x-form.label id="description">Description</x-form.label>
        <x-form.textarea :value="$product->description" name="description" id="description"/>
        @error('description')<p class="text text-danger">{{$message}}</p>@enderror

    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <x-form.input type="file" name="image"/>
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}"  height="60" alt="">
        @endif

    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <x-form.input type="number" :value="$product->price" name="price"/>
    </div>

    <div class="form-group">
        <label for="compare_price">Compare Price</label>
        <x-form.input type="number" :value="$product->compare_price" name="compare_price"/>
    </div>

    <div class="form-group">
        <label for="compare_price">Tags</label>
        <x-form.input :value="$tags"  name="tags"/>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <div>
            <x-form.radio :options="['active'=>'Active','archived'=>'Archived']"
                          name="status" :checked="$product->status"/>
            @error('status')<p class="text text-danger">{{$message}}</p>@enderror

        </div>
    </div>
    <div class="form-group">
        <input type="submit" value="{{$button_label ?? 'Save'}}" class="btn btn-primary">

    </div>

</form>


@push('scripts')
    <script src="{{ asset('js/tagify.js') }}"></script>
    <script src="{{ asset('js/tagify.ployfilles.min.js') }}"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify (inputElm);
    </script>
@endpush
