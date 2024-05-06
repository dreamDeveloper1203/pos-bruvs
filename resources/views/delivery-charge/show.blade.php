@extends('layouts.app')
@section('title', 'Delivery Charge')

@section('content')

    <div class="mb-2 d-flex">
        <h4 class="mb-3">Delivery Charge Report</h4>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-primary ms-auto px-2 py-1 text-center" data-bs-toggle="modal"
                    data-bs-target="#deliverChargeFilterModal">
                    <i class="bi bi-funnel align-middle"></i> Filter
                </button>
            </div>
            @if ($collection->isEmpty())
                <div class="text-center">
                    <div class="mb-2">There is nothing to display! Try changing the filter.</div>
                </div>
            @else
                <div class=" table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-muted small fw-normal">Total</th>
                                <th class="text-muted small fw-normal">Date</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach ($collection as $item)
                                <tr>
                                    <td class="align-middle">{{ currency_format($item->total) }} </td>
                                    <td class="align-middle">{{ $item->date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="">
                    {{ $collection->links() }}
                </div>
            @endif
        </div>
    </div>
    <div class="modal" id="deliverChargeFilterModal" tabindex="-1" aria-labelledby="deliverChargeFilterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="deliverChargeFilterModalLabel">
                        <i class="bi bi-funnel-fill align-middle fs-5"></i> Search Filters
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('delivery-charge.show') }}" role="form" method="GET">
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
                        <button type="submit" class="btn btn-primary w-100">Use Filter</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
