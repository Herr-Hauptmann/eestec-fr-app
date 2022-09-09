@if($status->event->is_active==1 && $status->user->id == $userId)
    <form class="" action="/status/updateStatus/{{ $status->id }}" method="post" enctype="multipart/form-data"
        id="status_form">
        @csrf
        @method('PUT')
        <select class="form-select" id="status" name="status" onchange='this.form.submit();'>
            <option @if ($status->status == 1) selected @endif value="1">Not contacted</option>
            <option @if ($status->status == 2) selected @endif value="2">Contacted, no answer</option>
            <option @if ($status->status == 3) selected @endif value="3">Contacted, waiting for reply
            </option>
            <option @if ($status->status == 4) selected @endif value="4">Accepted</option>
            <option @if ($status->status == 5) selected @endif value="5">Denied</option>
        </select>
    </form>
@endif