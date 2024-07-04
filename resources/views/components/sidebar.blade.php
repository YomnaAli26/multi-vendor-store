<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        @foreach($items as $item)
        <li class="nav-item menu-open">
            <a href="{{route($item['route'])}}" class="nav-link {{Route::is($item['active'])?'active':''}}">
                <i class="{{$item['icon']}}" ></i>
                <p>
                    {{$item['title']}}
                    @if(isset($item['badge']))
                    <span class="right badge badge-danger">{{$item['badge']}}</span>
                    @endif
                </p>
            </a>

        </li>
        @endforeach
    </ul>
</nav>
<!-- /.sidebar-menu -->
