@extends('admin._layout.layout')

@section('seo_title', __('Replacements'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Replacements')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Replacements')</li>
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
                        <h3 class="card-title">@lang('All Replacements')</h3>
                        
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
<!--                                    <th class="text-center">@lang('Schedule')</th>-->
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Last Change')</th>
                                    
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


@endsection

@push('footer_javascript')
<script type="text/javascript">
    
   let entitiesDataTable = $('#entities-list-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "{{route('admin.replacements.datatable')}}",
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
            //{'name': 'schedule_id', "data": "schedule_id"},
            {'name': 'created_at', "data": "created_at", "className": "text-center"},
            {'name': 'updated_at', "data":"updated_at", "className": "text-center"},
            
        ]
    });
    
    
</script>

@endpush