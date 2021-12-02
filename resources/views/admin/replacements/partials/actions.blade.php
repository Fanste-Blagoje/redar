
<div class="btn-group">
    <a href="{{route('admin.schedule.edit', ['schedule' => $schedule->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"
        data-action="delete"
        data-id="{{$schedule->id}}"
        data-name="{{$schedule->date . ' - ' . optional($schedule->house)->name}}"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>