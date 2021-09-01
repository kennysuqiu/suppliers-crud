<?php require 'config/config.php'; ?>
<?php require 'header.php'; ?>
<?php require 'config/db.php'; ?>

<?php
    $msg = '';
    $msgClass = '';


    if(isset($_POST['submit'])) {
        $supplier = mysqli_real_escape_string($conn, $_POST['supplier']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        
        if (strlen($supplier) === 0 || strlen($contact) === 0) {
            $msg = '¡No puedes dejar el nombre y/o el telefono en blanco!';
            $msgClass = 'alert-danger';
        } else {
            $query = "INSERT INTO suppliers(supplier_name, supplier_contact) VALUES ('$supplier', '$contact')";

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
    
    $query = "SELECT supplier_name, supplier_contact FROM suppliers";
    $result = mysqli_query($conn, $query);
    $supplier_names = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    mysqli_close($conn);
?>

<body>
<?php require 'navbar.php' ?>
    <div class="container">
        <h1>Agregar Vendedor</h1>
        <br>
    </div>
    <div class="container">
        <?php if($msg != ''): ?>
            <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
            <div class="form-group">
                <label for="supplier">Vendedor:</label>
                <input type="text" class="form-control" placeholder="Introduzca Nombre de la Compañia" id="supplier" name="supplier" value="<?php echo isset($_POST['supplier']) ? $supplier : ''; ?>">

            </div>
            <div class="form-group">
                <label for="amount">Telefono:</label>
                <input type="text" class="form-control" placeholder="Introduzca el numero del vendedor" id="contact" name="contact" value="<?php echo isset($_POST['contact']) ? $contact : ''; ?>">
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Vendedor</th>
                    <th scope="col">Telefono</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supplier_names as $supp): ?>
                    <tr>
                        <th scope="row"><?php echo $supp['supplier_name']; ?></th>
                        <td><?php echo $supp['supplier_contact']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
<?php require 'footer.php'; ?>