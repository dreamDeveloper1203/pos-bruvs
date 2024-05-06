<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS</title>
    <link rel="preload" href="{{ mix('css/app.css') }}" as="style" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        html,
        body {
            height: 100vh;
        }

    </style>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-md-12">
                <div id="pos" data-tax="{{ $taxRate }}" data-delivery="{{ $deliveryCharge }}"
                    data-discount="{{ $discount }}"></div>
            </div>
        </div>
    </div>

    {{-- <div class=" w-100 h-100 position-relative">
        <div class="bg-body flex-column flex-fill h-100 d-flex">

            <div class="d-flex overflow-hidden flex-shrink-0 pt-2 px-2">
                <div class="mx-2 d-flex overflow-x-auto pb-1">
                    <div class="d-flex px-2 flex-shrink-0">
                        <button class="btn btn-success btn-lg">Dashboard</button>
                    </div>
                    <div class="d-flex px-2 flex-shrink-0">
                        <button class="btn btn-success btn-lg">Customer</button>
                    </div>
                </div>
            </div>

            <div class=" flex-fill overflow-hidden d-flex p-2">
                <div class="d-flex flex-fill overflow-hidden m-2">

                    <div class="d-flex overflow-hidden p-2 w-50">
                        <div class=" flex-fill d-flex flex-column">
                            <div class=" rounded shadow overflow-hidden flex-fill d-flex bg-white">
                                <div class="d-flex flex-fill flex-column overflow-hidden">

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div> --}}



</body>

</html>
<script defer src="{{ mix('js/app.js') }}"></script>
