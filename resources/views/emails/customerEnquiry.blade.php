<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Enquiry About A Product</title>

    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Bad+Script&family=Dancing+Script&family=Lora&family=Quattrocento+Sans&display=swap" rel="stylesheet">

</head>
<body>
    <!--banner-->
    <div style="box-shadow: 0 0 10px rgba(0,0,0,0.2); margin: 20px auto; padding: 20px; max-width: 600px; background-color: #f5f5f5;">
        <div style="text-align: center; width: 100%; margin-top:10px;">
            <h1 style="font-family: 'Quattrocento Sans', sans-serif; line-height: 28px; font-size: 24px; margin: 0;">Doherty Wedding Invitations</h1>
            <p style="font-family: 'Allura', cursive;">
                Affordable Handmade Invitations
            </p>
        </div>
        <div style="width: 100%; position: relative; margin-top: 10px;">
            <img src="https://ses-images-for-emails.s3.eu-west-1.amazonaws.com/blog-header.jpg" alt="Your Image" style="max-height: 150px; height: auto; max-width: 100%; width: 100%; bottom: 0; display: block; object-fit: cover;">
        </div>
    </div>

    <!--message -->
    <div style="box-shadow: 0 0 10px rgba(0,0,0,0.2); margin: 20px auto; padding: 20px; max-width: 600px;">
        <h3>Message:</h3>
        <div>{{ $customerMessage }}</div>
    </div>

    <!--product details section -->
    <div style="box-shadow: 0 0 10px rgba(0,0,0,0.2); align-items:center; margin: 20px auto; padding: 20px; max-width: 600px;">
        @if (!empty($productId))
            <div style="text-align: center;">
                <img src="{{ $image }}" alt="image of product" style=" border: 10px solid #6b7d73; max-height:300px;">
            </div>
        @endif
        <div style="text-align:center;">
            <!--Contact Details-->
            <h3>Contact Details</h3>
            <p>Name: {{ $name }}</p>
            <p>Email: {{ $email }}</p>
            <p>Phone: {{ $phoneNumber }}</p>

            <!--Product Details-->
            @if (!empty($name) && !empty($price))
                <h3>Product Name: {{ $productName }}</h3>
                <p>Price: {{ $price }}</p>
            @endif
        </div>

        @if (!empty($productId))
            <a href="{{ 'http://localhost:9000/#/productdetails?id=' . $productId }}" style="text-decoration: none;">
                <div style="transition: background-color 0.3s ease; font-size: 16px; cursor: pointer; border-radius: 4px; border: none; text-decoration: none; color: white; margin: 0 auto; width: 50%; background-color: #6b7d73; text-align: center; padding: 10px 20px; display: block;" class="button">See More Product Details</div>
            </a>
        @endif
    </div>
    
</body>
</html>