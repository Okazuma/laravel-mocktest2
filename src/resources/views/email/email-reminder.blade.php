<html>
<body>
<h1>Reservation Reminder</h1>
    <p>{{ $reservation->user->name }}様</p>
    <p>This is a reminder for your reservation at {{ $reservation->restaurant->name }}.</p>
    <p>Date: {{ $reservation->date }}</p>
    <p>Time: {{ $reservation->time }}</p>

    <p>We are looking forward to your visit. Thank you!</p>

</body>
</html>