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
                <th>#</th>
                <th>Video</th>
                <th>Keywords</th>
                <th>Sheet</th>
                <th>Action</th>
            </tr>
            @foreach($items as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->video_id }}</td>
                    <td>{{ implode(',', $row->keywords) }}</td>
                    <td>{{ $row->sheet_id }}</td>
                    <td style="width: 100px;">
                        <div class="d-flex justify-content-end gap-1">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$row->id}}">Edit</button>
                            <a href="{{route('youtube-settings.destroy',$row->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$row->id}}">Delete</a>
                        </div>
                    </td>


                    <!--Edit Modal -->
                    <div class="modal fade" id="editNewModalId{{$row->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$row->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="addNewModalLabel{{$row->id}}">Edit</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('youtube-settings.update',$row->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="video_id" class="form-label">Video ID</label>
                                                    <input type="text" id="video_id" name="video_id" value="{{$row->video_id}}"
                                                           class="form-control" placeholder="Enter Video ID" required>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="keywords_{{$row->id}}" class="form-label">Keywords</label>
                                                    <input type="text" id="keywords_{{$row->id}}" name="keywords" class="form-control"
                                                           placeholder="Enter Keywords (comma separated)" value="{{ implode(',', $row->keywords) }}">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="sheet_id_{{$row->id}}" class="form-label">Google Sheet ID</label>
                                                    <input type="text" id="sheet_id_{{$row->id}}" name="sheet_id" class="form-control"
                                                           placeholder="Enter Google Sheet ID" value="{{ $row->sheet_id }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Modal -->
                    <div id="danger-header-modal{{$row->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$row->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header modal-colored-header bg-danger">
                                    <h4 class="modal-title" id="danger-header-modalLabe{{$row->id}}l">Delete</h4>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <a href="{{route('youtube-settings.destroy',$row->id)}}" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
