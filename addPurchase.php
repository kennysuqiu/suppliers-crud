<?php require 'config/config.php'; ?>
<?php require 'header.php'; ?>
<?php require 'config/db.php'; ?>

<?php
    $msg = '';
    $msgClass = '';

    $query = "SELECT supplier_name FROM suppliers";
    $result = mysqli_query($conn, $query);
    $supplier_names = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    if(isset($_POST['submit'])) {
        $supplier = mysqli_real_escape_string($conn, $_POST['supplier']);
        $purchaseTotal = mysqli_real_escape_string($conn, $_POST['purchaseTotal']);
        $purchaseMethod = mysqli_real_escape_string($conn, $_POST['paymentMethod']);
        

        if (strlen($purchaseTotal) === 0) {
            $msg = '¡No puedes dejar el monto en blanco!';
            $msgClass = 'alert-danger';
        } else {
            $query = "INSERT INTO purchases(supplier, purchaseTotal, purchaseMethod) VALUES ('$supplier', '$purchaseTotal','$purchaseMethod')";

            if (mysqli_query($conn, $query)) {
                $msg = '¡Récord guardado!';
                $msgClass = 'alert-success';
            } else {
                echo 'ERROR' . mysqli_error($conn);
            }
            $msg = '¡Récord guardado!';
            $msgClass = 'alert-success';
        }

    }
    mysqli_close($conn);
?>

<body>
<?php require 'navbar.php' ?>
    <div class="container">
        <h1>Agregar Compra</h1>
        <br>
    </div>
    <div class="container">
        <?php if($msg != ''): ?>
            <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
            <div class="form-group">
                <label for="supplier">Vendedor:</label>
                <select class="form-control" name="supplier" id="supplier">
                    <?php foreach($supplier_names as $supp): ?>
                        <option value="<?php echo $supp['supplier_name']?>"><?php echo $supp['supplier_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="purchaseTotal">Cantidad:</label>
                <input type="number" step="0.01" class="form-control" placeholder="Introduzca cantidad" id="purchaseTotal" name="purchaseTotal" value="<?php echo isset($_POST['purchaseTotal']) ? $purchaseTotal : ''; ?>">
            </div>
            <br>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="paymentMethod" id="cash" value="Efectivo" checked>
                <label class="form-check-label" for="cash">Efectivo</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="paymentMethod" id="visa" value="Visa">
                <label class="form-check-label" for="visa">VISA</label>
            </div>
            <div class="form-check">
            <input type="hidden" name="date"></div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</body>
<?php require 'footer.php'; ?>