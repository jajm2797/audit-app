@auth()
    @if($is_product)
    @include('layouts.navbars.navs.auth_products')
    @else
    @include('layouts.navbars.navs.auth')
    @endif
@endauth

@guest()
    @include('layouts.navbars.navs.guest')
@endguest
