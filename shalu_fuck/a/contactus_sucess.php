<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$servername = "localhost";
$username = "shubham"; // DB username
$password = "Shubh@2003"; // DB passwordco
$dbname = "powerfulformula_data";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Collect and sanitize form data
$name = mysqli_real_escape_string($conn, $_POST['name']);
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

// Insert data into contact_us table
$sql = "INSERT INTO user_data (name, phone) VALUES ('$name', '$mobile')";
$success = mysqli_query($conn, $sql);

// Close connection
mysqli_close($conn);


$ivrApiUrl = "https://web.betyphon.com/api/public/inboundleads"
    . "?cid=6899c8107254df2ceeb30627"
    . "&phone=" . urlencode($mobile)
    . "&firstName=" . urlencode($name)
    . "&admin=" . urlencode("biomanix6@gmail.com")
    . "&source=" . urlencode("Website");


// Call IVR API with cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ivrApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable only for testing


$response = curl_exec($ch);
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo "IVR API Error: " . $error_msg;
}
curl_close($ch);


// Continue with your success page
//echo "<h1>Thank you, $name! We have received your request.</h1>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Submission Success</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <!-- START ExoClick Goal Tag | bio -->
<script type="application/javascript" src="https://a.magsrv.com/tag_gen.js" data-goal="84bcec5183daa7044e554dcd28deb89c" ></script>
<!-- END ExoClick Goal Tag | bio -->
  <style>
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: 'Roboto', Arial, sans-serif;
      background: linear-gradient(135deg, #e0f7fa 0%, #b2dfdb 100%);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .confirmation-container {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(44, 62, 80, 0.12);
      padding: 2.5rem 2rem 2rem 2rem;
      max-width: 400px;
      width: 90%;
      text-align: center;
      animation: fadeInUp 0.8s cubic-bezier(0.23, 1, 0.32, 1);
    }
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(40px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .success-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 1.5rem auto;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
      border-radius: 50%;
      box-shadow: 0 4px 16px rgba(67, 233, 123, 0.15);
      animation: popIn 0.7s cubic-bezier(0.23, 1, 0.32, 1);
    }
    @keyframes popIn {
      0% { transform: scale(0.5); opacity: 0; }
      80% { transform: scale(1.1); opacity: 1; }
      100% { transform: scale(1); }
    }
    .success-icon svg {
      width: 44px;
      height: 44px;
      stroke: #fff;
      stroke-width: 3.5;
      stroke-linecap: round;
      stroke-linejoin: round;
      fill: none;
      display: block;
    }
    .confirmation-title {
      font-size: 1.6rem;
      font-weight: 700;
      color: #2e7d32;
      margin-bottom: 0.5rem;
      letter-spacing: 0.01em;
    }
    .confirmation-message {
      font-size: 1.1rem;
      color: #555;
      margin-bottom: 2rem;
    }
    .confirmation-actions {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      align-items: center;
    }
    .confirmation-btn {
      background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 0.75rem 2.2rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(67, 233, 123, 0.10);
      transition: background 0.2s, transform 0.2s;
    }
    .confirmation-btn:hover, .confirmation-btn:focus {
      background: linear-gradient(90deg, #38f9d7 0%, #43e97b 100%);
      transform: translateY(-2px) scale(1.03);
      outline: none;
    }
    @media (max-width: 600px) {
      .confirmation-container {
        padding: 1.5rem 0.5rem 1.5rem 0.5rem;
        max-width: 95vw;
      }
      .confirmation-title {
        font-size: 1.2rem;
      }
      .confirmation-message {
        font-size: 1rem;
      }
    }
  </style>
  <script type="application/javascript" src="/a.js" data-goal="84bcec5183daa7044e554dcd28deb89c" ></script>
</head>
<body>
  <div class="confirmation-container">
    <div class="success-icon">
      <svg viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="25" fill="none"/>
        <path d="M16 27l7 7 13-13"/>
      </svg>
    </div>
    <div class="confirmation-title">
      <?php echo $success ? "Success!" : "Oops!"; ?>
    </div>
    <div class="confirmation-message">
      <?php
        echo $success 
          ? "Thank you! Your message has been successfully sent. We’ll get back to you shortly."
          : "Sorry, there was a problem submitting your message. Please try again.";
      ?>
    </div>
    <div class="confirmation-actions">
      <button class="confirmation-btn" onclick="window.history.back()">Go Back</button>
    </div>
  </div>
</body>
</html>
