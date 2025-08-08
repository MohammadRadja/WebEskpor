@props(['id', 'title', 'icon', 'items' => []])

<a class="nav-link collapsed d-flex align-items-center text-white" href="#" data-bs-toggle="collapse"
    data-bs-target="#{{ $id }}" aria-expanded="false" aria-controls="{{ $id }}">
    <i class="fas {{ $icon }} me-2"></i> {{ $title }}
    <i class="fas fa-angle-down ms-auto"></i>
</a>

<div class="collapse" id="{{ $id }}" data-bs-parent="#sidenavAccordion">
    <nav class="nav flex-column ps-4">
        @foreach ($items as $item)
            <a href="{{ route($item['route']) }}"
                class="nav-link text-white {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'active' : '' }}">
                <i class="fas {{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</div>
