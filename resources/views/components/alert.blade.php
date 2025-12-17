
<div {{$attributes->merge(['class'=>' alert alert-dismissible fade show'])}}>
           {{$slot}}
    <button class="btn-close" data-bs-dismiss='alert'></button>
</div>

