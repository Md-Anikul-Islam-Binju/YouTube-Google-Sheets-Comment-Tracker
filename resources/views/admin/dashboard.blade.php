@extends('admin.app')

@section('admin_content')

    {{-- Page Title --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">YouTube → Google Sheets Comment Tracker</li>
                        <li class="breadcrumb-item">Dashboards</li>
                        <li class="breadcrumb-item active">Welcome</li>
                    </ol>
                </div>
                <h4 class="page-title">Welcome!</h4>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row">

        {{-- Total Videos --}}
        <div class="col-xxl-6 col-sm-6">
            <div class="card widget-flat text-bg-pink">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-youtube-line widget-icon" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="text-uppercase mt-0">Total Videos</h6>
                    <h2 class="my-2">{{ $totalVideosLink }}</h2>
                </div>
            </div>
        </div>

        {{-- Total Sheets --}}
        <div class="col-xxl-6 col-sm-6">
            <div class="card widget-flat text-bg-purple">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-file-list-3-line widget-icon" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="text-uppercase mt-0">Total Sheets</h6>
                    <h2 class="my-2">{{ $totalSheetLink }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- Service Account --}}
    <div class="row">
        <div class="col-xxl-12">
            <div class="card widget-flat text-bg-success">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-mail-line widget-icon" style="font-size: 2.5rem;"></i>
                    </div>

                    <h6 class="text-uppercase mt-0">Google Service Account</h6>

                    @if($clientEmail)
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <code id="clientEmailText" style="color:white;">{{ $clientEmail }}</code>

                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                onclick="copyClientEmail(this)">
                                <i class="ri-file-copy-line"></i>
                            </button>
                        </div>
                    @else
                        <span class="text-warning">Service account not found</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyClientEmail(btn) {
            var text = document.getElementById('clientEmailText').innerText;

            var input = document.createElement('input');
            input.value = text;
            document.body.appendChild(input);

            input.select();
            document.execCommand('copy');

            document.body.removeChild(input);

            btn.innerHTML = '<i class="ri-check-line"></i>';
            setTimeout(function () {
                btn.innerHTML = '<i class="ri-file-copy-line"></i>';
            }, 1500);
        }
    </script>

@endsection


