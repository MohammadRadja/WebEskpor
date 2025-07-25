<footer id="footer" class="footer dark-background">
    <div class="copyright text-center py-4">
        <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center gap-3">

            {{-- Info Website --}}
            <div class="text-center text-lg-start">
                <div class="fw-bold">
                    &copy; {{ date('Y') }} <span>{{ $footer->kutipan ?? 'Website' }}</span>
                </div>
                <div class="small text-white">
                    {!! $footer->konten ?? '' !!}<br>
                    {{ meta($footer, 'alamat') }}
                </div>
            </div>

            {{-- Sosial Media --}}
            @php $sosial = meta($footer, 'sosial', []); @endphp
            <div class="social-links d-flex gap-3">
                @foreach (['facebook', 'instagram'] as $platform)
                    @if (!empty($sosial[$platform]))
                        <a href="{{ $sosial[$platform] }}" target="_blank" class="text-white">
                            <i class="bi bi-{{ $platform }}"></i>
                        </a>
                    @endif
                @endforeach
            </div>

        </div>
    </div>
</footer>
