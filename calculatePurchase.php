<?php require 'config/config.php'; ?>
<?php require 'config/db.php'; ?>
<?php require 'header.php'; ?>
<body>
<?php require 'navbar.php' ?>
<?php 
    date_default_timezone_set('America/Panama');
    $date = date('Y-m-d');

    $query = "SELECT supplier AS supplier, purchaseTotal AS purchaseTotal, purchaseMethod AS purchaseMethod FROM purchases WHERE purchaseDate = '$date'";
    $results = mysqli_query($conn, $query);
    $records = mysqli_fetch_all($results, MYSQLI_ASSOC);

    $query = "SELECT SUM(purchaseTotal) AS total FROM purchases WHERE purchaseDate = '$date'";
    $sum = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($sum);
    $sum = $row['total'];
    $sum = number_format((float)$sum, 2, '.', '');

    $query = "SELECT SUM(purchaseTotal) AS visa FROM purchases WHERE purchaseMethod = 'Visa' AND purchaseDate = '$date'";
    $visa = mysqli_query($conn, $query);
    $visaRow = mysqli_fetch_assoc($visa);
    $visa = $visaRow['visa'];
    $visa = number_format((float)$visa, 2, '.', '');

    $query = "SELECT SUM(purchaseTotal) AS cash FROM purchases WHERE purchaseMethod = 'Efectivo' AND purchaseDate = '$date'";
    $cash = mysqli_query($conn, $query);
    $cashRow = mysqli_fetch_assoc($cash);
    $cash = $cashRow['cash'];
    $cash = number_format((float)$cash, 2, '.', '');

?>
    <div class="container">
        <h1>Calcular Compras</h1>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Vendedor</th>
                    <th scope="col">Monto Pagado</th>
                    <th scope="col">Metodo De Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $record ): ?>
                <tr>
                    <th scope="row"><?php echo $record['supplier']; ?></th>
                    <td><?php echo $record['purchaseTotal']; ?></td>
                    <td><?php echo $record['purchaseMethod']; ?></td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="container">
        <h3>Compras Total: <?php $todaySum = ($sum == 0) ? '0.00' : $sum ; echo "$".$todaySum; ?></h3>
    </div>
    <div class="container">
        <h3>Compras con Visa: <?php $visaSum = ($visa == 0) ? '0.00' : $visa ; echo "$".$visaSum; ?></h3>
    </div>
    <div class="container">
        <h3>Compras con Efectivo: <span class="text-success"><?php $cashSum = ($cash == 0) ? '0.00' : $cash ; echo "$".$cashSum; ?></span></h3>
    </div>
        
    
</body>
<?php require 'footer.php'; ?>