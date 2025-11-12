@if (session()->has('message'))
    
<div class="z-3 bg {{session()->has('color')? 'bg-'.session('color'): 'bg-success'}} text-white toast tops position-absolute top-0 start-50 translate-middle" role="alert" aria-live="assertive" aria-atomic="true" data-bs-auto-hide="false" >
        <div class="d-flex justify-content-center">
            <div class="toast-body">
            {{session('message')}}
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
</div>
@endif

<script>
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl, '[data-bs-auto-hide="false"]').show();
            })
        

</script>