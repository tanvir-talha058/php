<?php
// --- Step 1: Database Connection ---
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "Donations";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// --- Step 2: Fetch the Top Donor from Yesterday ---
$top_donor_name = "No donations yesterday";
$top_donor_amount = 0;

// Get yesterday's date in 'YYYY-MM-DD' format
$yesterday_date = date('Y-m-d', strtotime('-1 day'));

// SQL query to find the highest, non-anonymous donation from yesterday
$sql = "SELECT fullname, amount 
        FROM donors 
        WHERE anonymous = 'no' AND DATE(donation_datetime) = ?
        ORDER BY amount DESC 
        LIMIT 1";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $yesterday_date);
$stmt->execute();
$result = $stmt->get_result();

// Check if a top donor was found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $top_donor_name = htmlspecialchars($row['fullname']);
    $top_donor_amount = htmlspecialchars($row['amount']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Donor of the Day</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        
        .container {
            background-color: #fff;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 2px solid #4682b4; /* Steel blue border */
        }
        h1 {
            color: #4682b4; /* Steel blue */
            margin-bottom: 10px;
        }
        p {
            font-size: 1.2em;
            color: #333;
        }
        .donor-name {
            font-weight: bold;
            font-size: 1.5em;
            color: #2e8b57; /* Sea green */
        }
        .donor-amount {
            font-weight: bold;
            font-size: 1.5em;
            color: #ff8c00; /* Dark orange */
        }
        .date-info {
            margin-top: 20px;
            font-style: italic;
            color: #777;
        }
        .nav-link {
            margin-top: 30px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4682b4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .nav-link:hover {
            background-color: #5a9bd4;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Yesterday's Top Donor</h1>
        <p>We are grateful for all our supporters. A special thank you to our top donor from yesterday!</p>
        
        <p>
            <span class="donor-name"><?php echo $top_donor_name; ?></span>
        </p>
        
        <?php if ($top_donor_amount > 0): ?>
            <p>
                with a generous donation of 
                <span class="donor-amount">$<?php echo number_format($top_donor_amount, 2); ?></span>
            </p>
        <?php endif; ?>

        <p class="date-info">
            This reflects donations made on <?php echo date("F j, Y", strtotime($yesterday_date)); ?>.
        </p>

        <a href="index.html" class="nav-link">Make a Donation</a>
    </div>
</body>
</html>
