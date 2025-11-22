  

    <div class="wrapper" id="side" >
    
            <!-- Sidebar -->
            <aside id="sidebar">
                    <div class="sidebar-logo">
                        <a href="#">{{Auth()->user()? Auth()->user()->type : "User"}}</a>
                    </div>
                    
                    <!-- Sidebar Navigation -->
                    <ul class="list-items" >
                        <li class="sidebar-header">
                            Tools & Components
                        </li>
                    
                @if(Auth()->user())
                    @if (Auth()->user()->type=='Travel_agent')
                         <!-- Travel Agent's -->
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#agent"
                                aria-expanded="false" aria-controls="agent">
                                <i class="fa-regular fa-file-lines pe-2"></i>
                                Trip-page
                            </a>
                            <ul id="agent" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#agent">
                                {{-- <li class="sidebar-item">
                                    <a href="/trip/create" class="sidebar-link">Add Trip</a>
                                </li> --}}

                                {{-- <li class="sidebar-item">
                                    <a href="/place/create" class="sidebar-link">Add Places</a>
                                </li>
                               --}}
                                <li class="sidebar-item">
                                    <a href="/trip/manage" class="sidebar-link">Manage Trips</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="/place/manage" class="sidebar-link">Manage Places & Category</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="/hotel/trip/reserve/show" class="sidebar-link">Manage trip/hotel Reservation</a>
                                </li> 
                                
                            </ul>
                        </li>
                        
                        @elseif(Auth()->user()->type=='Manager')
                        <!-- Hotel Manager's -->
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#manager"
                                aria-expanded="false" aria-controls="manager">
                                <i class="fa-regular fa-file-lines pe-2"></i>
                                Hotel-section
                            </a>
                            <ul id="manager" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#manager">
                                
                                <li class="sidebar-item">
                                    <a href="/hotel/create" class="sidebar-link">Create Hotel</a>
                                </li>
                               

                                <li class="sidebar-item">
                                    <a href="/hotel/" class="sidebar-link">Manage Hotel</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="/hotel/manage/book" class="sidebar-link">Manage hotel/room booking</a>
                                </li> 
                                
                            </ul>
                        </li>

                        @elseif(Auth()->user()->type=='Customer')
                                  <!-- Customer's  -->
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#users"
                                    aria-expanded="false" aria-controls="users">
                                    <i class="fa-regular fa-file-lines pe-2"></i>
                                    Your Booking
                                </a>
                                <ul id="users" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#users">
                                    <li class="sidebar-item">
                                        <a href="/reserve/show" class="sidebar-link">Reservation</a>
                                    </li>
                                    
                                </ul>
                            </li>

                    @endif

                
            
                @endif


                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#auth"
                        aria-expanded="false" aria-controls="auth">
                        <i class="fa-regular fa-user pe-2"></i>
                            {{Auth()->user()? Auth()->user()->name : "Account"}}
                    </a>

                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        
                        <li class="sidebar-item">
                            <a href="/login" class="sidebar-link">Login</a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/logout" class="sidebar-link">Logout</a>
                        </li>
                    </ul>
                </li>
                                   
                        
                    </ul>

            </aside>

    </div>