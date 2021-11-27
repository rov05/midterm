<?php
$name = "";
$phone = "";
$action = "";
$editId = "";

if (!empty($_POST["username"])) $name = $_POST["username"];
if (!empty($_POST["userphone"])) $phone = $_POST["userphone"];
if (!empty($_POST["action"])) $action = $_POST["action"];
?>

<html>
    <body>
        <?php


        if ($action == "add")
        {
            $fileName = "filename.txt";
            $data = fopen($fileName, "a");
            fwrite($data, $name."|---|".$phone."\r\n");
            fclose($data);
        }
        else if($action == "delete")
        {
            $deleteId = $_POST['deleteId'];         
            $readData = file("filename.txt", FILE_IGNORE_NEW_LINES);            
            $arrOut = array();

            foreach ($readData as $key => $val)
            {
                 if ($key != $deleteId) $arrOut[] = $val;
            }           

            $strArr = implode("\n",$arrOut);
            $fp = fopen('filename.txt', 'w');
            if (count($readData) < 0)
            {
             fwrite($fp, $strArr."\r\n");
            }
            else
            fwrite($fp, $strArr);   
            fclose($fp);
        }
        else if($action == "edit")
        {   
            $editId= $_POST["editId"];
            $readData = file("filename.txt", FILE_IGNORE_NEW_LINES);
            $readData[$editId] = ($name."|---|".$phone."|---|".$email."|---|".$address);
            $writeData = implode("\r\n", $readData);
            $fileWrite = fopen('filename.txt', 'w');
            fwrite($fileWrite, $writeData."\r\n"); 
            fclose($fileWrite);
        }


        $fileName = "filename.txt";
        $readData = file("filename.txt", FILE_IGNORE_NEW_LINES);
        ?>
        <table border="1" width="50%">
            <tr>
                <td>Sr. No</td>
                <td>Name</td>
                <td>Phone No</td>
                <td colspan = "2">Action</td>
            </tr>

        <?php
        $cnt = 1;
        if (count($readData) > 0)
        {
            foreach ($readData as $key => $val)
            {
                list($name, $phone) = array_pad(explode("|---|", $val, 3), 3, null);    
            ?>
                <tr>
                    <td><?=$cnt?></td>
                    <td><?=$name?></td>
                    <td><?=$phone?></td>
                    <td>
                        <form action="add.php" method="post" name="editForm" id="editForm">
                            <input type="submit" id="btnEdit" name="btnEdit" value="Edit"/>
                            <input type="hidden" id="editId" name="editId" value="<?php echo $key; ?>"/> 
                            <input type="hidden" name="action" id="action" value="edit"/>
                        </form>
                        <form action="" method="post" name="deleteForm" id="deleteForm">
                            <input type="submit" id="delete" name="delete" value="Delete" onclick="return confirm('Do you want to delete this record?');"/>
                            <input type="hidden" id="deleteId" name="deleteId" value="<?php echo $key; ?>"/>
                            <input type="hidden" name="action" id="action" value="delete"/>
                        </form>
                    </td>
                </tr>
            <?php
                $cnt++;
            }
        }
        else
        {
            echo "No Record Found";
        }
        ?>
            <tr>
                <td colspan = "7"><p>[ <a href="add.php">Add New Record</a> ]</p></td>
            </tr>
        </table>
    </body>
</html>