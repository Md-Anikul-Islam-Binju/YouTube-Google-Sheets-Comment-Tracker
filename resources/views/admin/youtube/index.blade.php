@extends('admin.app')
@section('admin_content')
    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">YouTube → Google Sheets Comment Tracker</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                            <li class="breadcrumb-item active">YouTube → Google Sheets Tracker!</li>
                        </ol>
                    </div>
                    <h4 class="page-title">YouTube → Google Sheets Tracker!</h4>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <form method="POST" action="{{ route('youtube-settings.store') }}">
                    @csrf

                    <input class="form-control mb-2" name="video_id" placeholder="Video ID" required>
                    <input class="form-control mb-2" name="keywords" placeholder="sold,buy">
                    <input class="form-control mb-2" name="sheet_id" placeholder="Google Sheet ID" required>

                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

        <table class="table table-bordered">
            <tr>
                <th>#</th><th>Video</th><th>Keywords</th><th>Sheet</th>
            </tr>
            @foreach($items as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->video_id }}</td>
                    <td>{{ implode(',', $row->keywords) }}</td>
                    <td>{{ $row->sheet_id }}</td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
