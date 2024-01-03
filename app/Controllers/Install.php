<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Install extends Controller {

   public function __construct()
 	{
 			helper(
 				['langs']
 		);
    $this->comman_model = new \App\Models\Comman_model();
 			LoadLang();

 	}
  public function app_info(){?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Installation Page</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f1f1f1;
                margin: 0;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }

            .installation-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                width: 400px;
                text-align: center;
            }

            h2 {
                color: #333;
            }

            p {
                color: #777;
                margin-top: 10px;
            }

            form {
                margin-top: 20px;
            }

            label {
                display: block;
                margin-bottom: 8px;
                text-align: left;
            }

            input {
                width: 100%;
                padding: 8px;
                margin-bottom: 16px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            button {
                background-color: #0073aa;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                margin-top: 20px;
            }

            button:hover {
                background-color: #005580;
            }
        </style>
    </head>
    <body>

    <div class="installation-container">
        <h2>Welcome to Your Installation</h2>
        <p>Please add the database info.</p>

        <form action="info" method="post">
            <label for="app_url">Website URL:</label>
            <input type="text" id="app_url" name="app_url" required>
            <label for="app_name">App name:</label>
            <input type="text" id="app_name" name="app_name" required>
            <label for="description">App description:</label>
            <input type="text" id="description" name="description" required>
            <label for="author">App author:</label>
            <input type="text" id="author" name="author" required>

            <button type="submit">Install the App</button>
        </form>
    </div>

    </body>
    </html>

<?php
}
  public function index()
  {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .installation-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        p {
            color: #777;
            margin-top: 10px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #0073aa;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        button:hover {
            background-color: #005580;
        }
    </style>
</head>
<body>

<div class="installation-container">
    <h2>Welcome to Your Installation</h2>
    <p>Please add the database info.</p>

    <form action="install/database" method="post">
        <label for="host">Host name:</label>
        <input type="text" id="host" name="host" required>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <label for="database">Database name:</label>
        <input type="text" id="database" name="database" required>

        <button type="submit">Next</button>
    </form>
</div>

</body>
</html>


<?php
/*
- database
- app_info
- add admin user to DB
- delete install
*/
  }
	public function database()
	{
    $hostname = $this->request->getPost('host');
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');
    $database = $this->request->getPost('database');
    $conn = mysqli_connect($hostname,$username,$password,$database)or die(mysqli_error());
    $conn->set_charset("utf8");
    if($hostname == NULL || $username == NULL || $database == NULL){
      echo "Complete all fields!";
    }
// Read the SQL file content
$sqlFile = '../_database/project.sql';
$sql = file_get_contents($sqlFile);

// Run the queries
if (mysqli_multi_query($conn, $sql)) {
} else {
    die("Error executing queries: " . mysqli_error($conn));
}

$filePath = '../.env';

// Read the content of the file
$fileContent = file_get_contents($filePath);

// Perform the replacement
$fileContent = preg_replace(
    '/(database\.default\.hostname\s*=\s*)(.*)/',
    'database.default.hostname = ' . $hostname,
    $fileContent
);

$fileContent = preg_replace(
    '/(database\.default\.database\s*=\s*)(.*)/',
    'database.default.database = ' . $database,
    $fileContent
);

$fileContent = preg_replace(
    '/(database\.default\.username\s*=\s*)(.*)/',
    'database.default.username = ' . $username,
    $fileContent
);

$fileContent = preg_replace(
    '/(database\.default\.password\s*=\s*)(.*)/',
    'database.default.password = ' . $password,
    $fileContent
);

// Write the modified content back to the file
file_put_contents($filePath, $fileContent);

return redirect()->to("install/app_info");
	}
  public function info()
  {
    $base_url = $this->request->getPost('app_url');
    $app_name = $this->request->getPost('app_name');
    $author_name = $this->request->getPost('author_name');
    $description = $this->request->getPost('app_description');

    $filePath = '../.env';

    // Read the content of the file
    $fileContent = file_get_contents($filePath);

    // Perform the replacement
    $fileContent = preg_replace(
        '/(app\.baseURL\s*=\s*)(.*)/',
        'app.baseURL = ' . $base_url,
        $fileContent
    );

    $fileContent = preg_replace(
        '/(PROJECT_NAME\s*=\s*)(.*)/',
        'PROJECT_NAME = "' . $app_name .'"',
        $fileContent
    );

    $fileContent = preg_replace(
      '/(PROJECT_AUTHOR\s*=\s*)(.*)/',
      'PROJECT_AUTHOR = "' . $author_name .'"',
        $fileContent
    );

    $fileContent = preg_replace(
      '/(PROJECT_DESCRIPTION\s*=\s*)(.*)/',
      'PROJECT_DESCRIPTION = "' . $description .'"',
        $fileContent
    );

    // Write the modified content back to the file
    file_put_contents($filePath, $fileContent);

    return redirect()->to("install/delete_install");
  }
  public function delete_install()
  {
    $filePath = APPPATH . 'Controllers/Install.php';

unlink($filePath);
return redirect()->to("../");
  }
}
