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
                @if(auth()->user()->UserRole==1)
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home m-1 p-1"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                
                {{--members  --}}
                <li class="nav-item">
                    <a href="{{ route('member.index') }} "
                        class="nav-link {{ request()->is('members*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users  m-1 p-1"></i>
                        <p>
                            Members
                        </p>
                    </a>
                </li>  

                {{--renew members  --}}
                <li class="nav-item">
                    <a href="{{ route('member.renewal') }} "
                        class="nav-link {{ request()->is('renew*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-clock  m-1 p-1"></i>
                        <p>
                            Renew Membership
                        </p>
                    </a>
                </li>  
                
                {{-- equipments/assets --}}
                <li class="nav-item">
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

                {{-- Staff --}}
                <li class="nav-item">
                    <a href="
                    {{ route('staffs.staffindex') }}
                    "
                        class="nav-link {{ request()->is('staffs*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-friends  m-1 p-1"></i>
                        <p>
                            Staffs
                        </p>
                    </a>
                </li> 
                {{--  --}}


                {{-- Reports --}}
                <li class="nav-item">
                    <a href="
                    {{ route('pricing.index') }}             
                    "
                        class="nav-link {{ request()->is('pricing*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-donate  m-1 p-1"></i>
                        <p>                            
                            Packages & Pricing
                        </p>
                    </a>
                </li>
                 {{--  --}}

                {{-- Ledger--}}
                <li class="nav-item">
                    <a href=" 
                    {{ route('ledger.index') }}                       
                    "
                        class="nav-link {{ request()->is('ledger*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book  m-1 p-1"></i>
                        <p>
                            Payment Ledger
                        </p>
                    </a>
                </li> 
                {{--  --}}

                {{-- Paymets --}}
                <li class="nav-item">
                    <a href="
                    {{ route('expenses.index') }}        
                    "
                        class="nav-link {{ request()->is('expenses*') ? 'active' : '' }}">
                        <i class="nav-icon 	fas fa-money-check-alt  m-1 p-1"></i>
                        <p>
                            Expenses
                        </p>
                    </a>
                </li>
                 {{--  --}} 

               

                {{-- Reports --}}
                <li class="nav-item">
                    <a href=" 
                    {{ route('report.index') }}                
                    "
                        class="nav-link {{ request()->is('report*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar  m-1 p-1"></i>
                        <p>
                            Reports
                        </p>
                    </a>
                </li>
               
            @endif

            @if(auth()->user()->UserRole==0)
                 {{--  --}}
                 <li class="nav-item">
                    <a href=" 
                    {{ route('systemadmindashboard') }}                
                    "
                        class="nav-link {{ request()->is('systemadmindashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home m-1 p-1"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
               
                 {{--  --}}
            @endif
            @if(auth()->user()->UserRole==0)
            {{--  --}}
            <li class="nav-item">
               <a href=" 
               {{ route('gym.index') }}                
               "
                   class="nav-link {{ request()->is('gym*') ? 'active' : '' }}">
                   <i class="nav-icon fas fa-hospital-alt m-1 p-1"></i>
                   <p>
                       Gym
                   </p>
               </a>
           </li>
          
            {{--  --}}
            <li class="nav-item">
                <a href=" 
                {{ route('membersgym.index') }}                
                "
                    class="nav-link {{ request()->is('membersgym*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users m-1 p-1"></i>
                    <p>
                        Gym Members
                    </p>
                </a>
            </li>

            {{--  --}}
            @endif  
            
            @if(auth()->user()->UserRole==2)
            <li class="nav-item">
                <a href=" 
                {{ route('memberprofile') }}                
                "
                    class="nav-link {{ request()->is('memberprofile*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-circle m-1 p-1"></i>
                    <p>
                       Profile
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href=" 
                {{ route('account') }}                
                "
                    class="nav-link {{ request()->is('account*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-money-check-alt m-1 p-1"></i>
                    <p>
                       Account
                    </p>
                </a>
            </li>

            @endif

            </ul>
        </nav>
    </div>


</aside>

