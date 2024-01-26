
<div class="row">
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            {{$data}}
        </div>
    </div>
</div>

<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>