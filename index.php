<html>
<head>
    <title>Friend list</title>
</head>
<body>
    <?php
    include("header.html"); 
    ?>
    <br>
    <form action="index.php" method="post">
    Name: <input type="text" name="name">
        <input type="submit">
    </form>

    <h1> Friends</h1>

    <ul>
    <?php
        $fileIn = fopen("friends.txt", "rt");
        $friendsArray = [];
        while(!feof($fileIn)){
            $name = trim(fgets($fileIn));
            if($name !== "")
            {
                array_push($friendsArray, $name);
            }
        }
        fclose($fileIn);

        if(isset($_POST["name"])){
            $name = $_POST["name"];
            array_push($friendsArray, $name);
        }


        if (isset($_POST['delete'])) {
            $indexToBeRemoved = $_POST['delete'];
            array_splice($friendsArray, $indexToBeRemoved, 1);
        }


        $fileOut = fopen("friends.txt", "wt");
        foreach($friendsArray as $name) {
            fwrite($fileOut, "$name\n");
        }
        fclose($fileOut);


        $nameFilter = "";
        $startingWith = false;
        if(isset($_POST["nameFilter"])){
            $nameFilter = $_POST["nameFilter"];
            echo "filter";
        }
        if(isset($_POST["startingWith"])){
            $startingWith = $_POST["startingWith"];
        }
        

 
        $i = 0;
        foreach($friendsArray as $name){
            if(($nameFilter === "") || 
                 ($startingWith && stripos($name, $nameFilter) === 0) || 
                 (!$startingWith && stripos($name, $nameFilter) !== false)) { 
                echo "<li>
                        <form action=index.php method='post'>
                            $name 
                            <button type='submit' name='delete' value='$i'>Delete</button>
                        </form>
                      </li>";
            }
            $i++;
        }
    ?>
    </ul>

    <form action="index.php" method="post">
        <input type="text" name="nameFilter" value="<?=$nameFilter?>">
        <input type="checkbox" name="startingWith" <?php if ($startingWith=='TRUE') echo "checked"?> value="TRUE">Only the start of the name</input>
        <input type="submit" value="Filter list">
    </form>

</body>
</html>
