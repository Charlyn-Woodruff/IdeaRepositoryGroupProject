<DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h1>Update</h1>
        <?php

        //the database:
        $db = mysqli_connect('maria', 'ncmccann', 'GodIsGood123#', 'idea_repository');

        //check if connection successfully established or not. 
        if(mysqli_connect_errno()){
            echo("Connection failure");
            exit();
        }else{
            echo("Connection Success");
        }

        $sql = "UPDATE users SET lastName='Potter' WHERE firstName='Ginny'";

        if(mysqli_query($db, $sql)){
            echo ("Record updated");
        }else{
            echo("there was an error while updating your record.");
        }

        mysqli_close($db); // close the database at the end of the update operations
    ?>
    </body>
</html>