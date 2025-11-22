@extends('layout')
@section('content')
<x-sidebar></x-sidebar>

@include('partials._hero')
    <x-column class="module container-fluid">
        <x-row>

                <x-column class="col-md-12">
                    @include('partials._search')
                            {{-- package container --}}
                            <x-card> 
                                
                                @if ($trips->count()<1)
                                    <h3>No Trips available</h3>
                                    
                                @else
                                    @foreach ($trips as $trip)

                                        <x-trip-card :trip="$trip" />

                                    @endforeach
                                @endif                        

                            
                            </x-card>
                    
                </x-column>
            
        </x-row>
        @include('partials._filter_page')

    </x-column>

<script>

    
        let filter_btn = document.querySelector(".filtering");
        let filter_page = document.querySelector(".filter_page");
        let module = document.querySelector(".module");

        filter_btn.addEventListener("click", () => {
            filter_page.classList.toggle("filter_page-show");

            module.classList.toggle("module-expand");
        });
        
        $("#filterForm").submit((e)=>{

            e.preventDefault();

            $.ajax({
                url: "/trip/filter",
                type: "post",
                data: $("#filterForm").serialize(),
                dataType: "json",
                success: function (response) {
                    console.log(response.html);
                    $("#tripList").html(response.html);
                    
                },
                error: function(xhr){
                    console.log(xhr);
                    
                }
            });
        });

        $('input[type="checkbox"]').change(()=>{
            
             $("#filterForm").submit();
        })

</script>


@endsection