@extends('admin._layout.layout')

@section('seo_title', __('House'))

@section('content')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@lang('Edit house')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.houses.index')}}">@lang('Home')</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.houses.add')}}">@lang('Houses')</a></li>
              <li class="breadcrumb-item active">@lang('Edit house')</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">  
                    @lang('Editing house'):
                  #{{$house->id}}
                  -
                  {{$house->name}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{route('admin.houses.update', ['house' => $house->id])}}" method="post" id='entity-form'>
                  @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Name</label>
                    <input 
                        name="name"
                        value="{{old('name', $house->name)}}"
                        type="text" 
                        class="form-control @if ($errors->has('name')) is-invalid @endif" 
                        placeholder="Enter name"
                    >
                    @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-info">@lang('Save')</button>
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
  
  $('#entity-form').validate({
    rules: {
      "name": {
        required: true,
        maxlength: 10
      }
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