<?php
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if the reset parameter is provided
    if(isset($_GET['reset']) && $_GET['reset'] === 'true') {
        // Open the CSV file in write mode to truncate it
        $file = fopen('donnees.csv', 'w');
        // Close the file
        fclose($file);
        // Redirect to the current page to clear GET parameters
        header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
        exit;
    }

    if(isset($_GET['nom']) && isset($_GET['inscription']) && isset($_GET['filier']) && isset($_GET['mois']) && isset($_GET['financier']) && isset($_GET['do'])) {
        $nom = $_GET['nom'];
        $inscription = $_GET['inscription'];
        $filier = $_GET['filier'];
        $mois = $_GET['mois'];
        $financier = $_GET['financier'];
        $do = $_GET['do'];
        
        // Calculate the sum of financial and do
        $total = $financier + $do;


        // Ouvrir le fichier CSV en mode ajout
        $file = fopen('donnees.csv', 'a');

        // Écrire les données dans le fichier CSV
        fputcsv($file, array($nom, $inscription, $filier, $mois, $financier, $do, $total, $some));

        // Fermer le fichier
        fclose($file);

        // Redirection vers la page d'accueil après l'ajout
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Veuillez remplir tous les champs.";
    }

    // Fonction pour télécharger le fichier Excel
    function outputExcelFile() {
        // Entête pour forcer le téléchargement
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="donnees.xls"');

        // Données Excel
        echo "<table>";
        echo "<tr><th>#</th><th>Nom</th><th>Inscription</th><th>Filier</th><th>Mois</th><th>Financier</th><th>Do</th><th>Total</th><th>Some</th></tr>";
        $file = fopen('donnees.csv', 'r');
        if ($file !== false) {
            $counter = 1; // Counter variable
            while (($row = fgetcsv($file)) !== false) {
                echo "<tr>";
                echo "<td>" . $counter++ . "</td>"; // Output row number
                foreach ($row as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
            fclose($file);
        }
        echo "</table>";
    }

    // Vérifier si le paramètre 'format' est défini et égal à 'excel'
    if(isset($_GET['format']) && $_GET['format'] === 'excel') {
        // Appeler la fonction pour télécharger le fichier Excel
        outputExcelFile();
        exit;
    }

    // Search for data by name
    if(isset($_GET['search_name'])) {
        $search_name = $_GET['search_name'];
        // Open the CSV file to search for the name
        $file = fopen('donnees.csv', 'r');
        if ($file !== false) {
            $found = false; // Flag to track if name is found
            while (($row = fgetcsv($file)) !== false) {
                // Check if the name matches
                if ($row[0] === $search_name) {
                    $found = true;
                    echo "<div class='search-container'>";
                    echo "<h3>Information for $search_name:</h3>";
                    echo "<p><strong>Nom:</strong> " . htmlspecialchars($row[0]) . "</p>";
                    echo "<p><strong>Inscription:</strong> " . htmlspecialchars($row[1]) . "</p>";
                    echo "<p><strong>Filier:</strong> " . htmlspecialchars($row[2]) . "</p>";
                    echo "<p><strong>Mois:</strong> " . htmlspecialchars($row[3]) . "</p>";
                    echo "<p><strong>Financier:</strong> " . htmlspecialchars($row[4]) . "</p>";
                    echo "<p><strong>Do:</strong> " . htmlspecialchars($row[5]) . "</p>";
                    echo "<p><strong>Total:</strong> " . htmlspecialchars($row[6]) . "</p>";
                    echo "<p><strong>Some:</strong> " . htmlspecialchars($row[7]) . "</p>";
                    echo "</div>";
                }
            }
            fclose($file);
            if (!$found) {
                echo "<div class='search-container'>";
                echo "<p>No data found for the name: $search_name</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='search-container'>";
            echo "<p>Error: Unable to open the data file.</p>";
            echo "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #333;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .search-container {
            margin-top: 20px;
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
        }

        .search-container p {
            margin-bottom: 10px;
        }

        .search-result {
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter des données</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <label for="nom">اسم الكامل:</label>
            <input type="text" id="nom" name="nom"><br>
            <label for="inscription">رقم التسجيل :</label>
            <input type="text" id="inscription" name="inscription"><br>
            <label for="filier">الشعبة :</label>
            <input type="text" id="filier" name="filier"><br>
            <label for="mois">الشهر :</label>
            <input type="text" id="mois" name="mois"><br>
            <label for="financier">التأمين :</label>
            <input type="number" id="financier" name="financier"><br>
            <label for="do">الواجب الشهري :</label>
            <input type="number" id="do" name="do"><br>
            <input type="submit" value="Ajouter">
        </form>

        <h2>Données existantes</h2>
        <table>
            <tr>
                <th>#</th>
                <th>الاسم للكام</th>
                <th>رقم التسجيل</th>
                <th>الشعبة</th>
                <th>الشهر</th>
                <th>التأمين</th>
                <th>الواجب الشهري</th>
                <th>المجموع</th>
            </tr>
            <?php
            // Affichage des données du fichier CSV
            $file = fopen('donnees.csv', 'r');
            if ($file !== false) {
                $counter = 1; // Counter variable
                while (($row = fgetcsv($file)) !== false) {
                    echo "<tr>";
                    echo "<td>" . $counter++ . "</td>"; // Output row number
                    foreach ($row as $cell) {
                        echo "<td>" . htmlspecialchars($cell) . "</td>";
                    }
                    echo "</tr>";
                }
                fclose($file);
            }
            ?>
        </table>

        <!-- Add a link/button to reset data -->
        <p><a href="?reset=true">Réinitialiser les données</a></p>

        <!-- Add a form to search data by name -->
        <div class="search-container">
            <h3>Search by Name:</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                <input type="text" id="search_name" name="search_name">
                <input type="submit" value="Search">
            </form>
            <!-- Comment block for search results -->
            <!-- Results will appear here -->
        </div>

        <p><a href="?format=excel">Télécharger en format Excel</a></p>
    </div>
</body>
</html>
