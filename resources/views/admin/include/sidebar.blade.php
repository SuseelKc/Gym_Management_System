<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: rgb(28, 28, 28);">
    <!-- Sidebar -->
    <div class="sidebar p-1" >
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-4 pb-4 mb-4 px-1 d-flex">
            <img src="{{ asset('images/roundlogo.png') }}" class="elevation-2" alt="Gym Manager X">
            <div class="info mb-2">
                <a href="
                {{ route('dashboard') }}
                "class="d-block" style="margin-left: -10px;"> Gym Manager X
                    <br>
                <small class="ml-1">Management System</small>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- ... (your existing menu items) ... -->
                
                <li class="nav-item m-1">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home m-1 p-1"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                {{--members  --}}
                <li class="nav-item m-1">
                    <a href="{{ route('member.index') }} "
                        class="nav-link {{ request()->is('members*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users  m-1 p-1"></i>
                        <p>
                            Members
                        </p>
                    </a>
                </li>  
                
                {{-- equipments/assets --}}
                <li class="nav-item m-1">
                    <a href="
                    {{ route('equipments.index') }}
                    "
                        class="nav-link {{ request()->is('equipments*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dumbbell  m-1 p-1"></i>
                        <p>
                            Equipments
                        </p>
                    </a>
         
                </li> 


                {{--  --}}
{{-- shifts--}}
<li class="nav-item m-1">
    <a href="
    {{-- {{ route('dashboard') }} --}}
    "
        class="nav-link {{ request()->is('shift*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-walking  m-1 p-1"></i>
        <p>
            Walking
        </p>
    </a>
</li> 

                

                {{--  --}}

                {{-- shifts--}}
                <li class="nav-item m-1">
                    <a href="
                    {{-- {{ route('dashboard') }} --}}
                    "
                        class="nav-link {{ request()->is('shift*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock  m-1 p-1"></i>
                        <p>
                            Shifts
                        </p>
                    </a>
                </li> 
            
            </ul>
        </nav>
    </div>


</aside>

