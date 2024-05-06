<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Order {{ $order->number }}</title>
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
                <div id="pos-edit" data-order="{{ $order }}"></div>
            </div>
        </div>
    </div>


</body>

</html>
<script defer src="{{ mix('js/app.js') }}"></script>
