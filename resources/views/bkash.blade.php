<img src="{{ asset('image/bkash.png') }}" style="max-width: 150px;">
<form action="{{route('storebkash.class')}}" method= "post">
@csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="address">Address:</label>
    <textarea id="address" name="address" rows="4" cols="50" required></textarea><br><br>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="e.g. 1234567890" required><br><br>

    <button type="submit" class="btn btn-primary pulse-button">Submit</button>
</form>