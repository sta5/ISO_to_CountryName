<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ISO to Country Name</title>

    <!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
        <div class="container">
            
            <div class="page-header">
		<h1>ISO to Country Name</h1>
            </div>
            
            <form method="post">
                <textarea class="form-control" rows="15" autofocus name="iso"><?php echo $_POST['iso']; ?></textarea>
                <br />
                <input type="submit" value="JUST DO IT" class="btn btn-primary">
            </form>
        <?php
        if (!empty($_POST['iso'])) {
            $_POST['iso'] = preg_replace("/[^a-z]/i", " ", $_POST['iso']);
            $_POST['iso'] = preg_replace("/\s+/"," ", trim($_POST['iso']));
            $iso_array = explode(" ", $_POST['iso']);
            
            $iso_csv = array_map('str_getcsv', file(__DIR__.'/csv/iso.csv'));
            $languages_csv = array_map('str_getcsv', file(__DIR__.'/csv/languages.csv'));

            $output_array = array();
            $n = 1;
            foreach ($iso_array as $iso_array_value) {   
                $iso_array_value = strtoupper($iso_array_value);
                foreach ($iso_csv as $iso_csv_value) {
                    if (in_array($iso_array_value, $iso_csv_value)) {
                        $languages = "";
                        foreach ($languages_csv as $languages_csv_value) {
                            if (strcasecmp($iso_csv_value[1], $languages_csv_value[0]) == 0){
                                $languages = $languages_csv_value[1];
                            }
                        }
                        $output_array[] = "<td>" . $n . "</td><td>" . $iso_array_value . "</td><td>" . $iso_csv_value[1] . "</td><td>" . $languages . "</td>";
                        $n++;
                        continue 2;
                    }
                } 
                $output_array[] = "<td>" . $n . "</td><td>" . $iso_array_value . "</td><td>Unknown Country</td><td></td>";
                $n++;
            }
            
            $html_output = '';
            foreach($output_array as $output) {
                $html_output .= "<tr>" . $output . "</tr>";
            }
        ?>
            <div class="page-header">
		<h1>Result:</h1>
            </div>
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ISO</th>
                    <th>Country</th>
                    <th>Languages</th>
                  </tr>
                </thead>
                <tbody>
                    <?php echo $html_output; ?>
                </tbody>
            </table>
        <?php
        }
        ?>
        </div>   
    </body>
</html>
