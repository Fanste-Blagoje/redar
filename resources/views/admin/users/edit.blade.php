@extends('admin._layout.layout')

@section('seo_title', __('Edit User'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit User')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.users.index')}}">@lang('Users')</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @lang('Edit User')
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
                        <h3 class="card-title">
                            @lang('Editing user')
                            #{{$user->id}}
                            -
                            {{$user->name}}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form 
                        id="entity-form"
                        action="{{route('admin.users.update', ['user' => $user->id])}}"
                        method="post"
                        enctype="multipart/form-data"
                        role="form"
                        >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>

                                        <div class="input-group">
                                            <input 
                                                name="email"
                                                value="{{old('email', $user->email)}}"
                                                type="email" 
                                                class="form-control @if($errors->has('email')) is-invalid @endif" 
                                                placeholder="Enter email"
                                                >
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    @
                                                </span>
                                            </div>
                                            @include('admin._layout.partials.form_errors', ['fieldName' => 'email'])
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input 
                                            name="name"
                                            value="{{old('name', $user->name)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('name')) is-invalid @endif" 
                                            placeholder="Enter name"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                                    </div>
                                    <div class="form-group">
                                        <label>House</label>
                                        <select name="house_id" id="" class="form-control @if($errors->has('house_id')) is-invalid @endif">
                                            <option value="">--- Select House ---</option>
                                            @foreach(\App\Models\Models\House::orderBy('name')->get() as $house)
                                            <option
                                                value="{{$house->id}}"
                                                @if($house->id == old('house_id', $user->house_id))
                                                selected
                                                @endif
                                                >{{$house->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'house_id'])
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Save</button>
                            <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
        "theme": "bootstrap4"
    });

    $('#entity-form').validate({
        rules: {
            "email": {
                "required": true,
                "maxlength": 255,
                "email": true
            },
            "name": {
                "required": true,
                "maxlength": 255
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