<div class="vs-menu-wrapper">
    <div class="vs-menu-area text-center">
        <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo">
            {{-- <a href="index.html"><img src="frontend/img/logo.svg" alt="Kiddino"></a> --}}
            <a href="index.html"><img src="{{asset('logo/logo-simik.jpg')}}" style="width: 100px" alt="Kiddino"></a>
        </div>
        <div class="vs-mobile-menu">
            <ul>
                {{-- <li class="menu-item-has-children">
                    <a href="index.html">Demo</a>
                    <ul class="sub-menu">
                        <li><a href="index.html">Demo Style 1</a></li>
                        <li><a href="index-2.html">Demo Style 2</a></li>
                        <li><a href="index-3.html">Demo Style 3</a></li>
                    </ul>
                </li> --}}
                <li>
                    <a href="{{route('home.index')}}">Halaman Utama</a>
                </li>
                {{-- <li class="menu-item-has-children">
                    <a href="match.html">Classes</a>
                    <ul class="sub-menu">
                        <li><a href="class.html">Class Style 1</a></li>
                        <li><a href="class-2.html">Class Style 2</a></li>
                        <li><a href="class-details.html">Class Details</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="menu-item-has-children">
                    <a href="blog.html">Blog</a>
                    <ul class="sub-menu">
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="blog-details.html">Blog Details</a></li>
                    </ul>
                </li> --}}
                {{-- <li class="menu-item-has-children">
                    <a href="#">Pages</a>
                    <ul class="sub-menu">
                        <li><a href="service.html">Service</a></li>
                        <li><a href="service-details.html">Service Details</a></li>
                        <li><a href="team.html">Team</a></li>
                        <li><a href="team-details.html">Team Details</a></li>
                        <li><a href="event-details.html">Event Details</a></li>
                        <li><a href="gallery.html">Gallery</a></li>
                        <li><a href="price-plan.html">Price Plan</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="shop.html">Shop</a></li>
                        <li><a href="shop-details.html">Shop Details</a></li>
                        <li><a href="cart.html">Shopping Cart</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="registration.html">Registration</a></li>
                        <li><a href="error.html">Error Page</a></li>
                    </ul>
                </li> --}}
                <li>
                    <a href="{{route('home.daftar')}}">Pendaftaran</a>
                </li>
            </ul>
        </div>
    </div>
</div>
