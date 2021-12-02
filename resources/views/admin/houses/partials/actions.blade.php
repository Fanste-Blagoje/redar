<div class="btn-group">
    <a href="{{route('admin.houses.edit', ['house' => $house->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <button
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"
        data-action='delete'
        data-id='{{$house->id}}'
        data-name="{{$house->name}}"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>