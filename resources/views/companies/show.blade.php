
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="reportModalForm"  action="{{ route('reports.store', 0) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <div class="form-group col-12 my-3">
                        <label for="content">Report:</label>
                    <textarea class="form-control" id="content" name="content" placeholder="Content"  rows="4" value="{{ old('content')}}"></textarea>
                    @if ($errors->first('content'))
                        <div class="alert alert-danger">
                            {{ $errors->first('content') }}
                        </div>
                    @endif
                </div>

                <div class="form-group row">
                    <div class="col-12  d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary my-3" >
                            Submit
                        </button>
                    </div>
                </div>

            </form>
        </div>
      </div>
    </div>
  </div>
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$company->name}}
        </h2>
    </x-slot>
<div class="row">
    <div class="col-12 col-md-3 p-5 text-wrap text-break">
        <p class="text-wrap text-break">
            <b>Company name: </b> {{$company->name}}
        </p>
        <p class="text-wrap text-break">
            <b>Address: </b> {{$company->address}}
        </p>
        <p class="text-wrap text-break">
            <b>Website: </b> <a href="https://{{$company->website}}">{{$company->website}}</a>
        </p>
        <p class="text-wrap text-break">
            <b>Company description:</b>
            <br>
            {{$company->description}}
        </p>
        <p class="text-wrap text-break">
            <b>Comment:</b>
            <br>
            {{$company->comment}}
        </p>
        <p class="text-wrap text-break">
            <b>Contact person: </b> {{$company->contact_person}}
        </p>
        <p class="text-wrap text-break">
            <b>Contact email: </b> {{$company->contact_email}}
        </p>
        <p class="text-wrap text-break">
            <b>Contact phone number: </b> {{$company->contact_phone}}
        </p>
    </div>


    <div class="col-12 col-md-9 p-5">
        <div class="col-12 col-md-4">
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="event-select" onchange='changeAction(this.value)'>
                <option id="selection" value="0" selected>Select an event</option>
                @foreach ($statuses as $status)
                    <option value="{{$status->id}}">{{$status->event->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="" id="show-reports">

        </div>
    </div>




</div>

<script type='text/javascript'>
    $(document).ready(function(){
    $('#event-select').change(function(){
        var status_id = $(this).val();
        $.ajax({
            url: 'getReports/'+status_id,
            method: "GET",
            success: function(data){
                $('#show-reports').html(data.html);
            }
        });
    });
});

</script>

<script type='text/javascript'>
    function changeAction(val){
    document.getElementById('selection').setAttribute('disabled','disabled');

    var newaction = '/reports/'+val;
    document.getElementById('reportModalForm').setAttribute('action', newaction);
}
</script>

</x-app-layout>
