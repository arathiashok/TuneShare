<?php
include_once 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

try {
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data for dropdowns
    // $artistId = $_POST['artist'];
    // $albumId = $_POST['album'];
    $songId = $_POST['id'];

    // Construct data for the QR code (customize this based on your needs)

    $stmt = $conn->prepare("SELECT * FROM songs where songID=:songId");
	$stmt->execute(array(':songId' => $songId));
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        $id = $row['SongID'];
        $title = $row['Title'];
        $genre = $row['Genre'];
        $lang = $row['Language'];
        $length = $row['Length'];
        $year = $row['Year'];
    }
    $data = "SongID: $id, Title: $title, Genre: $genre, Language: $lang, Length: $length, Year: $year";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

    // $data = "Artist: $artistId, Album: $albumId, Song: $songId";

    // Encode the data for URL
    $encodedData = urlencode($data);

    // API URL for QR code generation
    $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$encodedData";

    // Get the QR code image from the API
    // $qrCodeImage = file_get_contents($apiUrl);

    // // Set the appropriate header to indicate that the content is an image
    // header('Content-Type: image/png');

    // // Echo the image data directly to the response
    // echo $qrCodeImage;

    $qrCodeImage = file_get_contents($apiUrl);

// Instead of echoing the image data, echo the URL to the image
    echo $apiUrl;
    exit;
}
?>