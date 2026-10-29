

<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? 'countries';

if ($lookup === 'cities') {
    $sql = "SELECT cities.name, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE ?
            ORDER BY cities.name";

    $stmt = $conn->prepare($sql);
    $search = "%" . $country . "%";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>District</th>";
    echo "<th>Population</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['district']) . "</td>";
        echo "<td>" . htmlspecialchars((string)$row['population']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    $stmt->close();
} else {
    $sql = "SELECT * FROM countries WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search = "%" . $country . "%";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Country Name</th>";
    echo "<th>Continent</th>";
    echo "<th>Independence Year</th>";
    echo "<th>Head of State</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
        echo "<td>" . htmlspecialchars((string)($row['independence_year'] ?? '')) . "</td>";
        echo "<td>" . htmlspecialchars($row['head_of_state'] ?? '') . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    $stmt->close();
}

$conn->close();
?>

