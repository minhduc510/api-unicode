<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài liệu API</title>
    <!-- Thêm Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
        }

        .fixed-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .content {
            margin-left: 270px;
        }
    </style>
</head>

<body>

    @include('layouts.menu')

    <div class="container content mt-5">
        @include('layouts.header')

        <div class="tab-content" id="v-pills-tabContent">
            @include('pages.index')

            @include('pages.auth')

            @include('pages.user')

            @include('pages.post')

            @include('pages.comment')

        </div>
    </div>

    <!-- Thêm Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
