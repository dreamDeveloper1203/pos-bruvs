@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show py-3" role="alert">
        <i class="bi bi-check-circle me-2 fs-4 align-middle text-success fw-bold"></i>
        <span class=" align-middle">
            {{ $message }}
        </span>
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show py-3" role="alert">
        <i class="bi bi-x-circle me-2 fs-4 align-middle text-danger fw-bold"></i>
        <span class=" align-middle">
            {{ $message }}
        </span>
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show py-3" role="alert">
        <i class="bi bi-exclamation-triangle me-2 fs-4 align-middle text-black fw-bold"></i>
        <span class=" align-middle">
            {{ $message }}
        </span>
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show py-3" role="alert">
        <i class="bi bi-info-circle me-2 fs-4 align-middle text-primary fw-bold"></i>
        <span class=" align-middle">
            {{ $message }}
        </span>
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($message = Session::get('status'))
    <div class="alert alert-info alert-dismissible fade show py-3" role="alert">
        <i class="bi bi-info-circle me-2 fs-4 align-middle text-primary fw-bold"></i>
        <span class="align-middle">
            {{ $message }}
        </span>
        <x-btn-alert-dismiss />
    </div>
@endif
