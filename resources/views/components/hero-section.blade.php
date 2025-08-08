@props([
    'title' => 'Page Title',
    'background' => 'assets/img/page-title-bg.webp',
    'breadcrumbs' => [['label' => 'Home', 'url' => '/']],
])

<div class="page-title dark-background" data-aos="fade" data-aos-duration="1200"
    style="background-image: url('{{ $background }}');">
    <div class="container position-relative">
        <h1 data-aos="fade-up" data-aos-delay="100">{{ $title }}</h1>
        @if (!empty($breadcrumbs))
            <nav class="breadcrumbs" data-aos="fade-up" data-aos-delay="300">
                <ol>
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if (!$loop->last)
                            <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                        @else
                            <li class="current">{{ $breadcrumb['label'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif
    </div>
</div>
