<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gym Manager X</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

   
        <style>
            * {
                margin: 0;
                padding: 0;
                font-family: 'Poppins', sans-serif;
                box-sizing: border-box; 
            }
            .container {
                width: 100%;
                min-height: 100vh;
                background-image: linear-gradient(rgba(5, 5, 5, 0.65), rgba(2, 2, 2, 0.65)),
                    url('{{ asset('images/background.jpg') }}');
                background-size: cover;
                background-position: center;
                padding: 2px 1%;
                /* padding: 10px 8%; */
            }
            nav {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 0; /* Increase the top and bottom padding */
                height: 100px;   /* Increase the height of the nav container */
            }
            .logo{
                width: 600px;
                cursor: pointer;
            }
            nav ul{
                list-style: none;
                width: 100%;
                height: 50px;
                text-align: right;
                text-decoration-style: double;
                padding-right: 60px;
            }
            nav ul li{
                display: inline-block;
                margin: 10px 20px
            }
            nav ul li a{ 
                color: #ffff;
                text-decoration: none;
                height: 20px;
                size: 50px;
            }
            .heading{
                color: #ffff;
                font-size: 30px;
                padding-left: 200px;
            }
            .description{
                color: #ffff;
                font-size: 28px;
                font-style: ;
                padding-top: 30px;
                padding-left: 200px;
                padding-right: 160px;
            }
            button {
        background-color: transparent;
        border: 2px solid #fff; /* White border */
        border-radius: 5px; /* Rounded corners */
        padding: 10px 20px; /* Adjust padding as needed */
        transition: background-color 0.3s, color 0.3s; /* Smooth transition */
        margin-left: 900px;
    }

    button a {
        text-decoration: none;
        color: #fff; /* White text */
        display: block;
    }

    /* Hover styles */
    button:hover {
        background-color: rgba(255, 255, 255, 0.888); /* White background with 20% opacity */
    }

    button:hover a {
        color: #000; /* Black text */
    }
        </style>
    </head>
    <body>
        <div class="container">

            <nav>
                <img src="{{asset('images/logowhite.png')}}" class="logo">
                <ul>
                    @if (Route::has('login'))
                        <div>
                            @auth
                                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Log in</a></li>
                
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @endif
                            @endauth
                        </div>                    
                    @endif
                   
                </ul>   

               
            </nav> 
            <div style="height: 250px"></div>
            
            <div class="heading"><h3>Welcome to Gym Manager X,</h3></div>
            <div class="description">Your professional gym management solution. 
                Where precision meets performance in gym management. Our software effortlessly handles member management, fitness equipment tracking, and payment monitoring, ensuring a seamless and professional experience. 
                Simplify your gym operations with Gym Manager X, where efficiency and excellence unite.</div>

                <div style="height: 50px"></div>

                <button><a href="{{ route('login') }}">Login</a></button>   
            
        </div>      
    </body>
</html>
