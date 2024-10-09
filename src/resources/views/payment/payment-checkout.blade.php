@extends('layouts.app')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment/payment-checkout.css') }}">
@endsection
    <script src="https://js.stripe.com/v3/"></script>
@section('content')
<div class="container">
    <form class="checkout__form" id="payment-form">
        <h1 class="checkout__title">Check out</h1>
        <p class="checkout__amount">お支払い金額を入力してください</p>
        <input class="checkout-input" type="number" id="amount" placeholder="Amount in JPY" min="1" required>
        <button class="submit__button" type="submit" id="checkout-button">決済</button>
    </form>
</div>

    <script>
        const stripe = Stripe('pk_test_51PhnPlRuekiYr2wt9X0QAJ9BkRhK512lVTJXfI7xAacZX8wBe6GEE13CfLeccZl2pBI75pVldmUr6CyWPoOMjvNE00bBFKj28e');
        document.getElementById('payment-form').addEventListener('submit', function (event) {
            event.preventDefault();
            const amount = document.getElementById('amount').value; // Convert yen to cents
            fetch('/create-checkout-session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ amount: amount })
            })
            .then(response => response.json())
            .then(data => {
                return stripe.redirectToCheckout({ sessionId: data.id });
            })
            .then(result => {
                if (result.error) {
                    alert(result.error.message);
                }
            });
        });
    </script>
@endsection