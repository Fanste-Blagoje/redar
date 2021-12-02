@extends('admin._layout.layout')

@section('seo_title', __('Schedule'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Schedule')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Schedule')</li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Schedule')</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.schedule.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Add new Schedule')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

<!--                        @if(!empty($systemMessage))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{$systemMessage}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif-->

                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 10px">@lang('Date')</th>
                                    <th style="width: 40%;">@lang('House')</th>
                                    <th style="width: 40%;">@lang('User')</th>
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Last Change')</th>
                                    <th class="text-center">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<form action="{{route('admin.schedule.delete')}}" method="post" class="modal fade" id="delete-modal">
    @csrf
    <input type="hidden" name="id" value="" />

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Schedule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete schedule?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>

@endsection

@push('footer_javascript')
<script type="text/javascript">
    
   let entitiesDataTable = $('#entities-list-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "{{route('admin.schedule.datatable')}}",
            "type": "post",
            "data": {
                "_token": "{{csrf_token()}}"
            }
        },
        "pageLength":10,
        "lengthMenu":[5, 10, 15, 25, 50, 100],
        "order":[[1, 'desc']],
        "columns": [
            {'name': 'id', "data": "id"},
            {'name': "date", "data": "date"},
            {'name': 'house_id', "data": "house_id"},
            {'name': 'user_id', "data": "user_id"},
            {'name': 'created_at', "data": "created_at", "className": "text-center"},
            {'name': 'updated_at', "data":"updated_at", "className": "text-center"},
            {'name': 'actions', "data":"actions", "orderable":false, "searchable":false, "className": "text-center"}
        ]
    });
    
    $('#entities-list-table').on('click', '[data-action="delete"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        let id = $(this).attr('data-id');

        let name = $(this).attr('data-name');

        $('#delete-modal [name="id"]').val(id);
        $('#delete-modal [data-container="name"]').html(name);
    });
    
    $('#delete-modal').on('submit', function (e) {
       e.preventDefault();
       
       $(this).modal('hide');
       
       $.ajax({
          "url": $(this).attr('action'),
          "type": "post",
          "data": $(this).serialize()
       }).done(function (response){
           
           toastr.success(response.system_message);
           
           entitiesDataTable.ajax.reload(null, false);
       }).fail(function (xhr) {
           toastr.error("@lang('Error occured while deleting schedule')");
       });
    });
</script>

@endpush