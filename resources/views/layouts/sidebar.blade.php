<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">
            <img src="https://the-bruvs.net/images/webp/logo.webp" alt="">
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <div class="list-group list-group-flush my-2">
            @foreach ($items as $item)
                <a class="list-group-item list-group-item-action sidebar-item align-items-center  fw-bold d-flex py-3
                @if ($item['active']) text-danger @endif"
                    href="{{ $item['route'] }}" @if ($item['is_blank']) target="_blank" @endif>
                    {{-- <i class="bi bi-{{ $item['icon'] }} me-3 fs-4"></i> --}}
                    <img src="{{ asset('images/webp/' . $item['img']) }}" height="24" width="24" class="me-3"
                        alt="img">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>