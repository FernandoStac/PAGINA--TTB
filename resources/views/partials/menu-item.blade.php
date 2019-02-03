@if ($item['submenu'] == [])
    <li class="nav-item">
        <a class="nav-link" href="{{ url($item['slug']) }}">{{ $item['name'] }} </a>
    </li>
@else
    <li class=" nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $item['name'] }} <span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-right dropdown-danger">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <a class="dropdown-item" href="{{ url('menu',['id' => $submenu['id'], 'slug' => $submenu['name']]) }}"> df</a>
                @else
                    @include('partials.menu-item', [ 'item' => $submenu ])
                @endif
            @endforeach
        </ul>
    </li>
@endif

    