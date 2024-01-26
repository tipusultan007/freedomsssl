
{{--@if(session('success'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-success" role="alert">
            {{session('success')}}
        </div>
    </div>
</div>--}}
@if(session('success'))
<div class="alert alert-success" role="alert">
    <div class="alert-body">
        {{session('success')}}
    </div>
</div>
@endif

<script>
window.setTimeout(function() {
    $(".alert").fadeTo(10000, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 2000);
</script>
