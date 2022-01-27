
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add report
</button>



@foreach ($reports as $report)
    <div class="card my-2">
        <div class="card-header">
            {{ \Carbon\Carbon::parse($report->created_at)->format('d.m.Y.')}}
        </div>
        <div class="card-body">
            <blockquote class="blockquote mb-0">
                <p>{{$report->content}}</p>
                <footer class="blockquote-footer">{{$report->user->name}}</footer>
            </blockquote>
        </div>
    </div>
@endforeach

{{-- @include('report-modal') --}}
