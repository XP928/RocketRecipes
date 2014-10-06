 <?php
 class Recipe extends mysqli 
        {

            // single instance of self shared among all instances
            private static $instance = null;
            // db connection config vars
            private $user = "f12g31";
            private $pass = "group31";
            private $dbName = "student_f12g31";
            private $dbHost = "localhost";

            // private constructor
            private function __construct() 
            {
                parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
                if (mysqli_connect_error()) 
                {
                    exit('Connect Error (' . mysqli_connect_errno() . ') '
                            . mysqli_connect_error());
                }
                parent::set_charset('utf-8');
            }

            function insert_wish($wisherID, $description, $duedate) 
            {
                $description = $this->real_escape_string($description);
                if ($this->format_date_for_sql($duedate) == null) 
                {
                    $this->query("INSERT INTO wishes (wisher_id, description)" .
                            " VALUES (" . $wisherID . ", '" . $description . "')");
                }
                else
                    $this->query("INSERT INTO wishes (wisher_id, description, due_date)" .
                            " VALUES (" . $wisherID . ", '" . $description . "', "
                            . $this->format_date_for_sql($duedate) . ")");
            }

            public function verify_credentials($name, $password) 
            {
                $name = $this->real_escape_string($name);
                $password = $this->real_escape_string($password);
                $result = $this->query("SELECT 1 FROM Users
                WHERE Username = '" . $name . "' AND Password = '" . $password . "'");

                return $result->data_seek(0);
            }


            public function get_recipes() {
                return $this->query("SELECT RecipeID, Title, TimeToMake FROM Recipe");
            }

            public function get_ingredientsList($id) {
                return $this->query("SELECT IngredientAmount, IngredientMeasure,RecipeID FROM IngredientsList WHERE IngredientsID = " . $id);
            }

            public function get_ingredients() {
                return $this->query("SELECT IngredientID, Name FROM Ingredients");
            }

            //get a user by name
            public function get_user_id_by_name($name) {
                $name = $this->real_escape_string($name);

                $user = $this->query("SELECT id FROM Users WHERE name = '"
                        . $name . "'");

                if ($user->num_rows > 0) {
                    $row = $user->fetch_row();
                    return $row[0];
                }
                else
                    return null;
            }

            //creates a new user in the database
            public function create_user($name, $password, $email) {
                $name = $this->real_escape_string($name);
                $password = $this->real_escape_string($password);
                $email = $this->real_escape_string($email);
                $this->query("INSERT INTO Users (Username, Password, Email) VALUES ('" . $name . "', '" . $password . "','" . $email . "')");
            }

            //This method must be static, and must return an instance of the object if the object
            //does not already exist.
            public static function getInstance() {
                if (!self::$instance instanceof self) {
                    self::$instance = new self;
                }
                return self::$instance;
            }

            // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
            // thus eliminating the possibility of duplicate objects.
            public function __clone() {
                trigger_error('Clone is not allowed.', E_USER_ERROR);
            }

            public function __wakeup() {
                trigger_error('Deserializing is not allowed.', E_USER_ERROR);
            }

            function checkuserpass($username,$password) {
                $username=$this->real_escape_string($username);
                $password=$this->real_escape_string($password);
                $sql = "SELECT * from Users where Username='". $username ."' AND Password='". $password ."' LIMIT 0,1";
                $result = $this->query($sql);
				$rows = $result->num_rows;
				if ( $rows > '0' ) {
				  return TRUE;	
				} else {
			      return FALSE;
				}
            }

            function print_secure_content($username) {
                print("<b><h1>hi mr.$_SESSION[$username]</h1>");
                print "<br><h2>only a logged in user can see this</h2><br><a>href='logout.php'>Logout</a><br>";
            }

        }
?>
