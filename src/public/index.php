<?php
declare(strict_types=1);

$servername = "mysql";
$username = "playground-user";
$password = "playground-pass1234";
$database = "classicmodels";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Définir le mode d'erreur PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour sélectionner tous les éléments de la table "product"
    $sql = "SELECT * FROM products";

    // Exécution de la requête
    $result = $conn->query($sql);

    $tableContent = "";

    if ($result->rowCount() > 0) {

        $tableContent .= "<table class='product_table'>";
        $tableContent .= "<tr>
                            <th><p>Actions</p></th> 
                            <th><p>productCode</p></th>
                            <th><p>productName</p></th>
                            <th><p>productLine</p></th>
                            <th><p>productVendor</p></th>
                            <th><p>productDescription</p></th>
                            <th><p>quantityInStock</p></th>
                            <th><p>buyPrice</p></th>
                            <th><p>MSRP</p></th>
                            
                        </tr>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $productId = $row['productCode'];
            $tableContent .= "<tr>";
            $tableContent .= '<td>
                                <button onclick="editRow()" ><a href="product.php?id=' . $productId . '">Edit</a></button>
                                <button onclick="deleteRow(' . $productId . ')">Delete</button>
                                <button onclick="copyRow(' . $productId . ')">Copy</button>
                             </td>';
            $tableContent .= "<td>" . $row['productCode'] . "</td>";
            $tableContent .= "<td>" . $row['productName'] . "</td>";
            $tableContent .= "<td>" . $row['productLine'] . "</td>";
            $tableContent .= "<td>". $row['productVendor'] . "</td>";
            $tableContent .= "<td>". $row['productDescription'] . "</td>";
            $tableContent .= "<td>". $row['quantityInStock'] . "</td>";
            $tableContent .= "<td>". $row['buyPrice'] . "</td>";
            $tableContent .= "<td>". $row['MSRP'] . "</td>";
            // Boutons Edit, Delete et Copy pour chaque ligne

            $tableContent .= "</tr>";
        }
        $tableContent .= "</table>";
    } else {
        $tableContent = "Aucun élément trouvé dans la table product.";
    }

} catch (PDOException $e) {
    die("La connexion a échoué : " . $e->getMessage());
}

// Fermer la connexion
$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de produits</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/function.js" defer></script>
</head>
<body>
<?php echo $tableContent; ?>
</body>
</html>