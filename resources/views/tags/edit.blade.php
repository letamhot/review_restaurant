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
    <p>Chỉnh Sửa Tag</p>
    <div class="chart-area" style="height: auto">
        <form method="post" action="{{ action('TagController@update',['tag'=>$tag]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="email">Tên</label>
                <input type="text" class="form-control" placeholder="Enter tag name" name="name" value="{{$tag->name }}"
                    required>
            </div>
            {{-- <div class="form-group">
            <label for="pwd">Slug</label>
            <input type="text" class="form-control" placeholder="Enter password" id="pwd" name="slug" required>
        </div> --}}
            <button type="submit" class="btn btn-primary">Chỉnh sửa tag</button>
        </form>
</body>

</html>
