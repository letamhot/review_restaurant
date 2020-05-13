<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body class="container-fluid">
    <p>Tạo Tag Mới</p>
    <form action="{{ route('tag.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">Tên</label>
            <input type="text" class="form-control" placeholder="Enter tag name" name="name" required>
        </div>
        {{-- <div class="form-group">
            <label for="pwd">Slug</label>
            <input type="text" class="form-control" placeholder="Enter password" id="pwd" name="slug" required>
        </div> --}}
        <button type="submit" class="btn btn-primary">Tạo Tag Mới</button>
    </form>
</body>

</html>
