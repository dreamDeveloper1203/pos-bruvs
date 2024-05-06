@extends('layouts.app')
@section('title', 'Sales Report')

@section('content')
    <div class="card w-100">
        <div class="card-body">

            <div class="mb-2">
                <a href="{{ route('sales.index') }}" class="link-primary text-decoration-none">
                    <i class="bi bi-arrow-left me-2"></i>Back
                </a>
            </div>
            <div class=" card-title h3">{{ $date }}</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-muted small fw-normal">Item</th>
                                    <th class="text-muted small fw-normal  text-center">Total Sold</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($sales as $sale)
                                    <tr class=" clicable-cell">
                                        <td class="align-middle">
                                            <img src="{{ $sale->image_url }}" class="rounded me-1" height="50"
                                                alt="{{ $sale->product_name }}">
                                            {{ $sale->product_name }}
                                        </td>
                                        <td class="align-middle text-center">{{ $sale->qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-muted small fw-normal">Inventory Item</th>
                                    <th class="text-muted small fw-normal  text-center">Total Sold</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($soldIngredients as $soldIngredient)
                                    <tr class=" clicable-cell">
                                        <td class="align-middle">
                                            {{ $soldIngredient->master_item_name }}
                                        </td>
                                        <td class="align-middle text-center">{{ $soldIngredient->qty }} {{ $soldIngredient->unit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
