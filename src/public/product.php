<?php
// Vérifier si l'identifiant du produit est présent dans l'URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Ici, vous pouvez récupérer les informations du produit depuis la base de données en utilisant l'identifiant du produit
    // et stocker le code HTML du tableau dans une variable.

    // Connexion à la base de données (vous pouvez réutiliser les informations de connexion)
    $servername = "mysql";
    $username = "playground-user";
    $password = "playground-pass1234";
    $database = "classicmodels";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // Définir le mode d'erreur PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour sélectionner les informations du produit en fonction de l'identifiant
        $sql = "SELECT * FROM products WHERE productCode = :productId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_STR);
        $stmt->execute();

        // Vérifier si le produit a été trouvé
        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // Stocker le code HTML du tableau dans une variable
            $tableContent = "<table>";
            $tableContent .= "<tr>
                                    <th>productCode</th>
                                    <th>productName</th>
                                    <th>productLine</th>
                                    <th>productVendor</th>
                                    <th>productDescription</th>
                                    <th>quantityInStock</th>
                                    <th>buyPrice</th>
                                    <th>MSRP</th>
                                  </tr>";

            $tableContent .= "<tr>";
            $tableContent .= "<td>" . $product['productCode'] . "</td>";
            $tableContent .= "<td>" . $product['productName'] . "</td>";
            $tableContent .= "<td>" . $product['productLine'] . "</td>";
            $tableContent .= "<td>" . $product['productVendor'] . "</td>";
            $tableContent .= "<td>" . $product['productDescription'] . "</td>";
            $tableContent .= "<td>" . $product['quantityInStock'] . "</td>";
            $tableContent .= "<td>" . $product['buyPrice'] . "</td>";
            $tableContent .= "<td>" . $product['MSRP'] . "</td>";
            $tableContent .= "</tr>";

            $tableContent .= "</table>";
        } else {
            $tableContent = "Produit non trouvé.";
        }

    } catch (PDOException $e) {
        die("La connexion a échoué : " . $e->getMessage());
    }

    // Fermer la connexion
    $conn = null;

} else {
    $tableContent = "Identifiant du produit manquant.";
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<?php echo $tableContent; ?>
</body>
</html>
