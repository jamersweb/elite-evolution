<style>
    .account-sidebar{
        background:#161616;
        padding-block:70px !important;
        height: 100%;
    }
    .account-sidebar ul{
        padding-inline: 10px !important;
    }
    .li-links {
        text-align: left !important;
        padding: 15px !important;
    }
    .li-links a {
        color: white !important;
        padding: 15px !important;
    }
</style>
<div class="row p-0 account-sidebar" >
    <div class="col-12 px-0">
        <div class="links text-start">
            <ul class="m-0 pb-5">

                <li class="list-unstyled li-links py-2 ">
                    <a  class="fs-5 d-block text-decoration-none "  >
                        {{auth()->user()->name}}
                    </a>
                </li>

                <li class="list-unstyled li-links py-2 active">
                    <a href="{{url('my-account')}}" class="fs-5 list-links text-decoration-none">
                        <i class="fa fa-user" aria-hidden="true"></i> My Account</a>
                </li>
                <li class="list-unstyled li-links py-2 ">
                    <a href="{{url('wishlist')}}" class="fs-5 list-links text-decoration-none ">
                        <i class="fa fa-heart" aria-hidden="true"></i> Wishlist</a>
                </li>

                <li class="list-unstyled li-links py-2 ">
                    <a href="{{url('saved-search')}}" class="fs-5 list-links text-decoration-none ">
                        <i class="fa fa-tasks" aria-hidden="true"></i>
                        Saved Search</a>
                </li>

 <li class="list-unstyled li-links py-2 ">
     <form class="m-0" method="POST" action="{{ route('logout') }}">
         @csrf
         <a href="#" class="fs-5 list-links text-decoration-none "  :href="route('logout')"
            onclick="event.preventDefault();
                                                this.closest('form').submit();">
             <i class="fas fa-power-off" aria-hidden="true"></i>
             {{ __('Log Out') }}
         </a>
     </form>
                </li>



                {{--                                <li class="list-unstyled li-links py-2 ">--}}
                {{--                                    <a href="https://eliteblue.net/Clients/viys/coupon/public/change-password" class="fs-5 list-links text-decoration-none">--}}
                {{--                                        <i class="fa fa-lock" aria-hidden="true"></i>--}}
                {{--                                        Change Password--}}
                {{--                                    </a>--}}
                {{--                                </li>--}}
            </ul>
        </div>
    </div>
</div>
