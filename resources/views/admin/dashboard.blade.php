@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">YouTube → Google Sheets Comment Tracker</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Welcome!</li>
                    </ol>
                </div>
                <h4 class="page-title">Welcome!</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Videos -->
        <div class="col-xxl-6 col-sm-6">
            <div class="card widget-flat text-bg-pink">
                <div class="card-body">
                    <div class="float-end">
                        <!-- Video / YouTube icon -->
                        <i class="ri-youtube-line widget-icon" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Total Videos">Total Videos</h6>
                    <h2 class="my-2">{{ $totalVideosLink }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Sheets -->
        <div class="col-xxl-6 col-sm-6">
            <div class="card widget-flat text-bg-purple">
                <div class="card-body">
                    <div class="float-end">
                        <!-- Sheet / File icon -->
                        <i class="ri-file-list-3-line widget-icon" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Total Sheets">Total Sheets</h6>
                    <h2 class="my-2">{{ $totalSheetLink }}</h2>
                </div>
            </div>
        </div>
    </div>

@endsection
