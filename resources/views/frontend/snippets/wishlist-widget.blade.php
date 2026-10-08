<div style="gap: 8px;" class="d-flex align-items-center justify-content-end card-icon-pack">
    <p class="mb-0 fs-12 d-md-block d-none">
        Wishlist
    </p>
{{--@dd(Auth::check())--}}
    <div class="wishlist like-container d-fle align-items-center btn bg-white">
        <div class="heart like-reaction text-center" data-toggle="tooltip" data-placement="right" title="{{Auth::check() ? '' : 'Login First'}}" data-reaction="wishlist" data-type="{{ $ReferenceType }}"
             data-id="{{ $ReferenceId }}">


            <img src="{{ count($already) == 0 ? asset('frontend/img/heart-line.png') : asset('frontend/img/heart.png') }}"
                 class="heart_img {{ count($already) == 0 ? '' : 'active' }}" alt="Wishlist">

            {{--        <img src="https://eliteblue.net/Clients/viys/coupon/public/frontend/img/Icon feather-heart.png" class="w-75 heart_img" alt=""> --}}
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#example').tooltip({ boundary: 'window' })

        $("body").tooltip({ selector: '[data-toggle=tooltip]',boundary: 'window' });
    });
</script>
