 <!--search form start-->
    
<div class="widget">

        <form action="/" method="GET">
            <div class="search-box text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <i class="btn filtering fa fa-ellipsis-v "></i>

                    <input type="search" class="form-control " name="search" placeholder="search..."  value="{{ old('search', request('search') ?? "" )}}">
                    
                    <button class="btn btn-sm btn-outline-danger" type="submit">search</button>
                </div>
                
                

            </div>
        </form>
</div>

<!--search form end-->
