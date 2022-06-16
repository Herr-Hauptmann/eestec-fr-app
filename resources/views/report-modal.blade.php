<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModal">Add report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST"  action="{{ route('reports.store', [$status_id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <div class="form-group col-md-6">
                            <label for="content">Report:</label>
                        <textarea class="form-control" id="content" name="content" placeholder="Content"  rows="4" value="{{ old('content')}}"></textarea>
                        @if ($errors->first('content'))
                            <div class="alert alert-danger">
                                {{ $errors->first('content') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
