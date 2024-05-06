<div class="modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="bi bi-funnel-fill align-middle fs-5"></i> Search Filters
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.filter') }}" role="form" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date-from" class="form-label">Date Starts</label>
                        <input type="date" name="from" class="form-control" id="date-from"
                            value="{{ Request::get('from') }}">
                    </div>
                    <div class="mb-3">
                        <label for="date-to" class="form-label">Date Ends</label>
                        <input type="date" name="to" class="form-control" id="date-to"
                            value="{{ Request::get('to') }}">
                    </div>
                    <div class="mb-3">
                        <label for="customer-name" class="form-label">Customer Name <small
                                class="text-muted fw-normal">optional</small></label>
                        <input type="text" name="name" class="form-control" id="customer-name"
                            value="{{ Request::get('name') }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Use Filter</button>
                </div>

            </form>
        </div>
    </div>
</div>
