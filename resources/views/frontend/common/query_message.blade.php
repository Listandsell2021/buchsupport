@if ($message = Session::get('query_success'))
    <div class="alert alert-success alert-block mb-4">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{!! $message !!}</strong>
    </div>
@endif
