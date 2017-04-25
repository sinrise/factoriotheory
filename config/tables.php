<?php require_once('database.php'); ?>
<?php

// Main Application Tables
class Product extends DatabaseObject {
	protected static $table_name="product";
	protected static $db_fields = array('id', 'name', 'category_id', 'craft_speed', 'craft_time', 'energy_cons', 'energy_prod', 'qty_produced', 'is_disp');
	public $id;
	public $name;
	public $category_id;
	public $craft_speed;
	public $craft_time;
	public $energy_cons;
	public $energy_prod;
	public $qty_produced;
	public $is_disp;
}

class Category extends DatabaseObject {
	protected static $table_name="category";
	protected static $db_fields = array('id', 'name', 'is_disp');
	public $id;
	public $name;
	public $is_disp;
}

class Recipe extends DatabaseObject {
	protected static $table_name="recipe";
	protected static $db_fields = array('id', 'product_id', 'ingredient_id', 'producer_id', 'qty_need', 'is_disp');
	public $id;
	public $product_id;
	public $ingredient_id;
	public $producer_id;
	public $qty_need;
	public $is_disp;
}

class Bonus extends DatabaseObject {
	protected static $table_name="bonus";
	protected static $db_fields = array('id', 'name', 'product_id', 'bonus_amt');
	public $id;
	public $name;
	public $product_id;
	public $bonus_amt;
}

// Framework Tables
class Nav_menu extends DatabaseObject {
	protected static $table_name="nav_menu";
	protected static $db_fields = array('id', 'name', 'parent_id', 'link_or', 'type_id', 'position', 'is_disp');
	public $id;
	public $name;
	public $parent_id;
	public $link_or;
	public $type_id;
	public $position;
	public $is_disp;
}

class Nav_type extends DatabaseObject {
	protected static $table_name="nav_type";
	protected static $db_fields = array('id', 'name');
	public $id;
	public $name;
}

class Us_state extends DatabaseObject {
	protected static $table_name="us_state";
	protected static $db_fields = array('id', 'name_short', 'name_long');
	public $id;
	public $name_short;
	public $name_long;
}

//ADMIN

//This class is used to create a new user only. This class is needed because of the need to separate password updating from the rest of the user account info. This is at  least slightly more secure, as it does reduce the number of times a user's hashed password is sent via POST. This is because of the way the DatabaseObject class works. It will update every field defined in the class so if no data is passed via POST, it sets the field to nothing, which is bad, for instance, if you want to have a separate area to change a user's password and don't want to always have to send the password each time the user account info is updated. A better solution might be to rewrite the class so it only updates fields that have data in them, rather build the array that is sent to the MySQL server to include only the fields necessary. This would include setting conditional statements within the DatabaseObject class. Still, the current method might be a faster way to do it, since objects are only as large as they need to be for that particular update. It might make the total project size larger but overall performance of the app is a higher priority.
class New_user extends DatabaseObject {
	protected static $table_name="user";
	protected static $db_fields = array('username', 'email', 'hashed_password', 'created_date', 'is_active');
	public $username;
	public $email;
	public $hashed_password;
	public $created_date;
	public $is_active;
}

class Update_login extends DatabaseObject {
	protected static $table_name="user";
	protected static $db_fields = array('id', 'last_login');
	public $id;
	public $last_login;
}

//this class is used to udate user info without touching the password. This way, the users's password is never passed in POST data when updating other user info. More secure.
class Update_user extends DatabaseObject {
	protected static $table_name="user";
	protected static $db_fields = array('id', 'username', 'email', 'is_active');
	public $id;
	public $username;
	public $email;
	public $is_active;
}

//limited set of user info update tools for the user to modify in their account view
class Update_user_public extends DatabaseObject {
	protected static $table_name="user";
	protected static $db_fields = array('id', 'username', 'email');
	public $id;
	public $username;
	public $email;
}

//this class is the only way a user password can be changed. This is the only time (other than password creation) a user's password is sent via POST (always hashed).
class User_pwreset extends DatabaseObject {
	protected static $table_name="user";
	protected static $db_fields = array('id', 'hashed_password');
	public $id;
	public $hashed_password;
}

//this is the class used for user authenitcation and for database view.
class User extends DatabaseObject {
	protected static $table_name="user";
	protected static $db_fields = array('id', 'username', 'hashed_password', 'email', 'created_date', 'is_active');
	public $id;
	public $username;
	public $hashed_password;
	public $email;
	public $created_date;
	public $is_active;

	public static function authenticate($email="", $hashed_password="") {
		global $database;
		$email = $database->escape_value($email);
		$hashed_password = $database->escape_value($hashed_password);
		
		$sql  = "SELECT * FROM user ";
		$sql .= "WHERE email = '{$email}' ";
		$sql .= "AND hashed_password = '{$hashed_password}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
}

class Feedback extends DatabaseObject {
	protected static $table_name="feedback";
	protected static $db_fields = array('id', 'date', 'is_read', 'message', 'user_id');
}

class Help_head extends DatabaseObject {
	protected static $table_name="help_head";
	protected static $db_fields = array('id', 'name', 'position', 'is_disp');
	public $id;
	public $name;
	public $position;
	public $is_disp;
}

class Help_body extends DatabaseObject {
	protected static $table_name="help_body";
	protected static $db_fields = array('id', 'head_id', 'body', 'position', 'is_disp');
	public $id;
	public $head_id;
	public $body;
	public $position;
	public $is_disp;
}

class Meta_data extends DatabaseObject {
	protected static $table_name="meta_data";
	protected static $db_fields = array('id', 'name', 'type_id');
	public $id;
	public $name;
	public $type_id;
}

class Meta_data_type extends DatabaseObject {
	protected static $table_name="meta_data_type";
	protected static $db_fields = array('id', 'name');
	public $id;
	public $name;
}
?>