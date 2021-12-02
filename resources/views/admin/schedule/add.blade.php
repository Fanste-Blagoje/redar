@extends('admin._layout.layout')

@section('seo_title', __('Add new Schedule'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Add new schedule')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.schedule.index')}}">@lang('Schedule')</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @lang('Add new schedule')
                    </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Enter data for the schedule')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form 
                        id="entity-form"
                        action="{{route('admin.schedule.insert')}}"
                        method="post"
                        enctype="multipart/form-data"
                        role="form"
                        >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date</label>

                                        <div class="input-group">
                                            <input 
                                                name="date"
                                                value="{{old('date')}}"
                                                type="date" 
                                                class="form-control @if($errors->has('date')) is-invalid @endif" 
                                                placeholder="Choose date"
                                                >
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-day"></i>                                             </span>
                                            </div>
                                            @include('admin._layout.partials.form_errors', ['fieldName' => 'date'])
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>House</label>
                                        <select name="house_id" id="sel_house" class="form-control @if($errors->has('house_id')) is-invalid @endif">
                                            <option value="">--- Select House ---</option>
                                            @foreach(\App\Models\Models\House::orderBy('name')->get() as $house)
                                            <option
                                                value="{{$house->id}}"
                                                @if($house->id == old('house_id'))
                                                selected
                                                @endif
                                                >{{$house->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'house_id'])
                                    </div>
                                    <div class="form-group">
                                        <label>User</label>
                                        <select name="user_id" id="sel_user" class="form-control @if($errors->has('user_id')) is-invalid @endif">
                                            <option value="">--- Select User ---</option>
<!--                                            @foreach(\App\Models\User::orderBy('name')->where('status', 1)->get() as $user)
                                            <option
                                                value="{{$user->id}}"
                                                @if($user->id == old('user_id'))
                                                selected
                                                @endif
                                                >{{$user->name}}</option>
                                            @endforeach-->
                                        </select>
                                        <!--                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'user_id'])-->
                                    </div>

                                </div>
                                <div class="offset-md-1 col-md-5">

                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Save</button>
                            <a href="{{route('admin.schedule.index')}}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@push('footer_javascript')
<script type="text/javascript">

    $('#entity-form [name="house_id"]').select2({
        "theme": "bootstrap4",
        //"tags": true
    });
    $('#entity-form [name="user_id"]').select2({
        "theme": "bootstrap4",
        "tags": true
    });

    $('#entity-form [name="house_id"]').on('change', function (e) {

        e.preventDefault();
        e.stopPropagation();

        var id = $(this).find(":selected").val();

        $('#entity-form [name="user_id"]').find('option').not(':first').remove();

        $.ajax({
            "url": "get-user/"+id,
            "type": "get",
            "dataType": "json",
            success: function (response) {

                var len = 0;

                if (response != null) {
                    len = response.length;
                }

                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        var id = response[i].id;

                        var name = response[i].name;

                        var option = "<option value='" + id + "'>" + name + "</option>";

                        $('#entity-form [name="user_id"]').append(option);
                    }
                }

            }
        });
    });

    $('#entity-form').validate({
        rules: {
            "date": {
                "required": true,
                "date": true
            },
            "house_id": {
                "required": true,
            },
            "user_id": {
                "required": true,
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

</script>
@endpush