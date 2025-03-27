

<template>
    <header>
        <div class="top-bar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-7">
                        <ul class="top-info">
                            <li><a href="#"><i class="las la-map-marker"></i>Melbourne VIC 3000</a>
                            </li>
                            <li><a href="mailto:info@melbourneairporttaxiservice.com.au"><i class="las la-envelope"></i>
                                    info@discountify.com</a></li>
                        </ul>
                    </div>

                    <div class="col-sm-5">
                        <ul class="top-act">

                            <li><a href="#"><i class="lab la-facebook-f" aria-hidden="true"></i></a></li>

                            <li><a href="#"><i class="lab la-instagram" aria-hidden="true"></i></a></li>

                            <li><a href="#"><i class="lab la-youtube" aria-hidden="true"></i></a></li>

                            <li><a href="#"><i class="lab la-linkedin"></i></a></li>


                            <li><a href="#"><i class="lab la-twitter"></i></a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-menu">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
                <div class="container">
                    <a href="#" class="brand-link">Discountify</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <!-- <a class="nav-link active" aria-current="page" href="#">Home</a> -->
                                <Link class="nav-link" :href="route('site.index')">Home</Link>

                            </li>


                            <li class="nav-item">
                                <Link class="nav-link" :href="route('state')">State</Link>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Products</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Shops</a>
                            </li>



                        </ul>


                        <ul class="header-right">

                            <li><a href="#" class="login-btn">Log in</a></li>

                            <li><a href="#" class="register-btn">Register<i class="las la-arrow-right"></i></a></li>
                        </ul>

                    </div>
                </div>
            </nav>
        </div>
    </header>
</template>
