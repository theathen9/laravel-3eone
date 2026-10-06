<!-- resources\views\layouts\app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', '3EONE')
    </title>

    @stack('styles')
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            {{-- Main Content --}}
            <main class="col-12 col-md-9 col-lg-10">
                @yield('content')
            </main>

        </div>
    </div>
</body>

</html>