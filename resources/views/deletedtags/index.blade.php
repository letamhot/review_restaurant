<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tag</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Danh Sách Tag Đã Bị Xóa</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $delete as $del)
                <tr>
                    <td>{{$del->name}}</td>
                    <td>{{$del->slug}}</td>
                    <td>
                        <form action="{{ route('restoreTag', $del->id) }}" method="GET">
                            @csrf
                            <input type="hidden" name="id" value="{{ $del->id }}">
                            <button type="submit"
                                onclick="return confirm('Bạn có muốn lấy lại tag {{$del->name}} đã xóa?')"
                                class="btn btn-danger btn-sm">Hoàn Tác</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>

<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: "{{ route('tag.store') }}",
            type: "GET",
            // dataType: "json",
            success: function (data) {
                $("#tagForm").trigger("reset");
                $("#ajaxModel").modal("hide");
                table.draw();
            },
            error: function (data) {
                $.each(data.responseJSON.errors, function(key, value){
                    $(`.alert-${key}`).html(value);
                });
                $("#saveBtn").html("Lưu Thay Đổi");
            },
        });
    });
