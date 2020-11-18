<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->

<html>
    <head>
        <title>League of Legends Match History</title>
    </head>
    <style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center; 
        vertical-align: middle;
    }
    img {
        width: 300px;
        height: auto;
        display: block;
        margin-right: auto;
        margin-left: auto;
        padding-bottom: 0px;
        margin-bottom: 0px;
    }
    #title {
        text-align: center;
        color: #dec26d;
        margin-top: 0px;
    }
    #topContainer {
        background-color: #8080b8;
    }
    </style>
    <body>
    <div id="topContainer">
        <img src="leagueLogo.png" alt="League of Legends Logo">
        <h1 id="title">Match History</h1>
    </div>
        <h2>Reset Database</h2>

        <form method="POST" action="MatchHistory.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />

        <h2>Add a new match</h2>
        <form method="POST" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertMatchRequest" name="insertMatchRequest">
            Match ID: <input type="text" name="insertMatchID"> <br /><br />
            Date: <input type="text" name="insertMatchDate"> <br /><br />
            User ID: <input type="text" name="insertUserID"> <br /><br />
            Team:   <select name="insertTeam">
                        <option value="Red">Red</option>
                        <option value="Blue">Blue</option>
                    </select> <br /><br />
            Victory or Defeat:  <select name="insertVictory">
                                    <option value="True">Victory</option>
                                    <option value="False">Defeat</option>
                                </select> <br /><br />
            Kills: <input type="text" name="insertKills"> Deaths: <input type="text" name="insertDeaths"> Assists: <input type="text" name="insertAssists"> <br /><br />
            Champion Name:  <select name="insertChampion">
                                <option value="Fizz">Fizz</option>
                                <option value="Jax">Jax</option>
                                <option value="Zed">Zed</option>
                                <option value="Vi">Vi</option>
                                <option value="Tristana">Tristana</option>
                            </select> <br /><br />
            Role: <select name="insertRole">
                    <option value="Assassin">Assassin</option>
                    <option value="Bruiser">Bruiser</option>
                    <option value="Tank">Tank</option>
                    <option value="Marksman">Marksman</option>
                    <option value="Enchanter">Enchanter</option>
                  </select> <br /><br />
            Item: <input type="checkbox" name="insertItems[]" value="Bilgewater Cutlass">Bilgewater Cutlass <input type="checkbox" name="insertItems[]" value="Refillable Potion">Refillable Potion<br />
                  <input type="checkbox" name="insertItems[]" value="Galeforce">Galeforce <input type="checkbox" name="insertItems[]" value="Force of Nature">Force of Nature<br />
                  <input type="checkbox" name="insertItems[]" value="Kraken Slayer">Kraken Slayer<br />


            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />    

        <h2>Delete a match</h2>
        <form method="POST" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteMatchRequest" name="deleteMatchRequest">
            Match ID: <input type="text" name="deleteMatchID"> <br /><br />

            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />

        <h2>Update Item Price</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateItemRequest" name="updateItemRequest">
            Item Name: <input type="text" name="itemName"> <br /><br />
            New Price: <input type="text" name="newPrice"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <div style="clear: both">
            <h2>Display the tuples in Matches</h2>
            <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
                <input type="hidden" id="showTablesRequest" name="showTablesRequest">
                <input type="submit" name="showTables"></p>
            </form>

            <h2>Display the tuples in Users</h2>
            <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
                <input type="hidden" id="showUsersRequest" name="showUsersRequest">
                <input type="submit" name="showUsers"></p>
            </form>
        </div>

        <hr /> 
        <!-- NEW STUFF: CHANGE FIELDS AS NEEDED -->


        <!-- SELECTION -->
        <h2>Show the users from a match</h2>
        <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectionRequest" name="selectionRequest">
            Match ID: <input type="text" name="selectionMatchIDInput"> <br /><br />
            <input type="submit" value="Select" name="selectionSubmit"></p>
        </form>

        <hr /> 

        <!-- PROJECTION -->
        <h2>Get the K/D/A of a player in a match</h2>
        <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="projectRequest" name="projectRequest">
            User ID: <input type="text" name="projectUserIDInput"> <br /><br />
            Match ID: <input type="text" name="projectMatchIDInput"> <br /><br />
            <input type="submit" value="Project" name="projectSubmit"></p>
        </form>

        <hr /> 

        <!-- JOIN -->
        <h2>Display the champion and items bought from the user with more than some number of kills</h2>3
        <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
            User ID: <input type="text" name="joinID"> <br /><br />
            Kill Count: <input type="text" name="joinNum"> <br /><br />

            <input type="submit" value="Join" name="joinSubmit"></p>
        </form>

        <hr /> 

        <!-- AGGREGATION WITH GROUP BY -->
        <h2>Find the average gold spent in a match for each role given that the User has bought an item</h2>
        <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="aggrGroupByRequest" name="aggrGroupByRequest">
            <input type="submit" name="aggrGroupBy"></p>
        </form>

        <hr /> 

        <!-- AGGREGATION WITH HAVING -->
        <h2>Find all Users who have played more than 3 matches and give their average kills and deaths</h2>
        <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="aggrHavingRequest" name="aggrHavingRequest">
            <input type="submit" name="aggrHaving"></p>
        </form>

        <hr /> 

        <!-- NESTED AGGREGATION GROUP BY -->
        <h2>Display the number of items purchased by the user who has the greatest number of items purchased</h2>
        <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="nestedAggRequest" name="nestedAggRequest">
            <input type="submit" name="nestedAgg"></p>
        </form>

        <hr /> 

        <!-- DIVISION -->
        <h2>Find the users that have lost all their matches</h2>
        <form method="GET" action="MatchHistory.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            <input type="submit" name="divisionSubmit"></p>
        </form>

        <hr /> 

        <h2> Query Result </h2>

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            // echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr); 
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection. 
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table demoTable:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
			// ora_platypus is the username and a12345678 is the password.

            $db_conn = OCILogon("ora_odys722", "a52955390", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;

            $item_name = $_POST['itemName'];
            $new_price = $_POST['newPrice'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Items SET cost='" . $new_price . "' WHERE ItemName='" . $item_name . "'");
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;

            // Execute database setup statements
            $statements = explode(';', file_get_contents('databaseSetup.sql'));
            foreach($statements as $statement) {
                if ( strlen($statement) > 0 && strlen(trim($statement)) != 0) {
                    executePlainSQL($statement);
                }
            }

            echo "<br> creating new table <br>";
            OCICommit($db_conn);

        }
        

        function handleInsertRequest() {
            global $db_conn;

            $matchID = $_POST['insertMatchID'];
            $matchDate = $_POST['insertMatchDate'];

            $userID = $_POST['insertUserID'];
            $team = $_POST['insertTeam'];
            $victory = $_POST['insertVictory'];
            $kills = $_POST['insertKills'];
            $deaths = $_POST['insertDeaths'];
            $assists = $_POST['insertAssists'];
            $champion = $_POST['insertChampion'];
            $role = $_POST['insertRole'];
            $items = $_POST['insertItems'];

            executePlainSQL("INSERT INTO Match VALUES($matchID, '$matchDate')");
            executePlainSQL("INSERT INTO \"User\" VALUES($userID, '$team', '$matchID', '$victory', $kills, $deaths, $assists, '$champion', '$role')");
            foreach ($items as $item){ 
                executePlainSQL("INSERT INTO BuysItem VALUES('$item', $userID, '$team', '$matchID')");
            }
            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM demoTable");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
            }
        }

        function handleShowTablesRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM match");
            echo "<table>";
            echo "<tr> <th>ID</th> <th>Date</th> </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";

        }


        //NEW HANDLERS


        function handleDeleteRequest() {
            global $db_conn;

            $delete_ID = $_POST['deleteMatchID'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("DELETE FROM match WHERE matchid = '" . $delete_ID . "'");
            OCICommit($db_conn);
        }

        function handleSelectionRequest(){
            global $db_conn;

            //Getting the values from user and insert data into the table
            $matchID = $_GET['selectionMatchIDInput'];

            $result = executePlainSQL("SELECT u.UserID, u.Team, u.Victory, u.Kills, u.Deaths, u.Assists, u.ChampionName, u.Role FROM \"User\" u, Match m WHERE u.MatchID = $matchID AND m.MatchID = $matchID");
            echo "<table>";
            echo "<tr> <th>UserID</th> <th>Team</th> <th>Victory</th> <th>Kills</th> <th>Deaths</th> <th>Assists</th> <th>Champion</th> <th>Role</th>  </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function handleProjectionRequest(){
            global $db_conn;

            //Getting the values from user and insert data into the table
            $userID = $_GET['projectUserIDInput'];
            $matchID = $_GET['projectMatchIDInput'];

            $result = executePlainSQL("SELECT u.Kills, u.Deaths, u.Assists FROM \"User\" u, Match m WHERE u.UserID = $userID AND m.MatchID = $matchID AND m.MatchID = u.MatchID");
            echo "<table>";
            echo "<tr> <th>Kills</th> <th>Deaths</th> <th>Assists</th> </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function handleJoinRequest(){
            global $db_conn;

            //Getting the values from user and insert data into the table
            $userID = $_GET['joinID'];
            $num = $_GET['joinNum'];


            $result = executePlainSQL("SELECT u.ChampionName, i.ItemName FROM \"User\" u, BuysItem i WHERE u.UserID = $userID AND u.Kills > $num AND u.UserID = i.UserID AND u.Team = i.Team AND u.MatchID = i.MatchID ");
            echo "<table>";
            echo "<tr> <th>Champion Name</th> <th>Items</th> </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function handleAggrGroupByRequest(){
            global $db_conn;

            $result = executePlainSQL("SELECT U.Role, TRUNC(AVG(Cost)) FROM \"User\" U, BuysItem B, Items I WHERE U.UserID = B.UserID AND U.MatchID = B.MatchID AND U.Team = B.Team AND B.ItemName = I.ItemName GROUP BY U.Role");
            echo "<table>";
            echo "<tr> <th>Role</th> <th>Gold Spent</th> </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function handleAggrHavingRequest(){
            global $db_conn;

            $result = executePlainSQL("SELECT U.UserID, TRUNC(AVG(Kills)), TRUNC(AVG(Deaths)) FROM \"User\" U GROUP BY U.UserID HAVING count(*) > 3");
            echo "<table>";
            echo "<tr> <th>User ID</th> <th>Average Kills</th> <th>Average Deaths</th> </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function handleNestedAggrGroupByRequest(){
            global $db_conn;

            $result = executePlainSQL("SELECT u1.UserID, COUNT(*) FROM \"User\" u1, BuysItem i WHERE u1.UserID = i.UserID AND u1.Team = i.Team AND u1.MatchID = i.MatchID GROUP BY u1.UserID HAVING COUNT(*) >= ALL (SELECT COUNT(*) FROM \"User\" u2, BuysItem i2 WHERE u2.UserID = i2.UserID AND u2.Team = i2.Team AND u2.MatchID = i2.MatchID GROUP BY u2.UserID )");
            echo "<table>";
            echo "<tr> <th>User ID Name</th> <th>Number of Items</th> </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function handleDivisionRequest(){
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM \"User\" U WHERE NOT EXISTS ( ( SELECT * FROM \"User\" U2 WHERE U2.UserID = U.UserID ) MINUS ( SELECT * FROM \"User\" U3 WHERE U3.UserID = U.UserID AND U3.Victory = 'False' ) ) ");
            echo "<table>";
            echo "<tr> <th>User ID</th> <th>Team</th> <th>Match ID</th> <th>Victory</th> <th>Kills</th> <th>Deaths</th> <th>Assists</th> <th>Champion Name</th> <th>Role</th> </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function handleShowUsersRequest(){
             global $db_conn;

            $result = executePlainSQL("SELECT * FROM \"User\"");
            echo "<table>";
            echo "<tr> <th>User ID</th> <th>Team</th> <th>Match ID</th> <th>Victory</th> <th>Kills</th> <th>Deaths</th> <th>Assists</th> <th>Champion Name</th> <th>Role</th> </tr>";
            while (($row = oci_fetch_row($result)) != false) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td> " . $item . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }



        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateItemRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertMatchRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('deleteMatchRequest', $_POST)) {
                    handleDeleteRequest();
                }
                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } else if (array_key_exists('showTables', $_GET)) {
                    handleShowTablesRequest();
                } else if (array_key_exists('aggrGroupBy', $_GET)) {
                    handleAggrGroupByRequest();
                } else if (array_key_exists('joinQueryRequest', $_GET)) {
                    handleJoinRequest();
                } else if (array_key_exists("nestedAgg", $_GET)) {
                    handleNestedAggrGroupByRequest();
                } else if (array_key_exists("aggrHaving", $_GET)) {
                    handleAggrHavingRequest();
                } else if (array_key_exists("divisionRequest", $_GET)) {
                    handleDivisionRequest();
                }
                else if (array_key_exists('projectRequest', $_GET)) {
                    handleProjectionRequest();
                }
                else if (array_key_exists('selectionRequest', $_GET)) {
                    handleSelectionRequest();
                } else if (array_key_exists('showUsers', $_GET)) {
                    handleShowUsersRequest();
                }
                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['showTablesRequest']) 
        || isset($_GET['aggrGroupByRequest']) || isset($_GET['joinSubmit']) || isset($_GET['nestedAggRequest'])|| isset($_GET['projectSubmit']) || isset($_GET['selectionSubmit']) || isset($_GET['aggrHaving']) || isset($_GET['divisionSubmit']) || isset($_GET['showUsers'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>


