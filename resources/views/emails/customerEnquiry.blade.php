<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>
<body>
    <div>
        <h2>Card Information</h2>
        <div>
            <h3>{{ $cardName }}</h3>
            <p>Price: ${{ $cardPrice }}</p>
            <img src="{{ $cardImage }}" alt="Card Image">
        </div>
    </div>
</body>
</html>