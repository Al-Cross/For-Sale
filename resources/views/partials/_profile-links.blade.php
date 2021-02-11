<div class="button-container mb-5 border-bottom d-md-flex justify-content-between">
    <div>
        <a href="{{ route('profile') }}" class="draw-outline draw-outline--tandem">Ads</a>
        <a href="{{ route('messages') }}" class="draw-outline draw-outline--tandem"> Messages</a>
        <a href="/myaccount/settings" class="draw-outline draw-outline--tandem">Settings</a>
    </div>

    @if(Auth::user()->ad_limit !== 0)
        <span class="text-center">Ad Slots Remaining: {{ Auth::user()->ad_limit }}</span>
    @endif
    <div class="d-md-flex">
        <p class="mr-1">Your Balance: {{ config('for-sale.currency') }}{{ $balance }}</p>
        <a href="/myaccount/wallet/load-account" class="btn bg-white btn-sm rounded-lg" style="height: 38px;">Increase Balance</a>
    </div>
</div>
