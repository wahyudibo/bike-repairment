<button type="button" class="btn btn-primary btn-view" value="{{ $id }}"><i class="fa fa-eye"></i></button>
@if ($status !== 'DONE')
    <button type="button" class="btn btn-success btn-update-status" value="{{ $id }}"><i class="fa fa-check"></i></button>
    <button type="button" class="btn btn-danger btn-delete" value="{{ $id }}"><i class="fa fa-trash"></i></button>
@endif