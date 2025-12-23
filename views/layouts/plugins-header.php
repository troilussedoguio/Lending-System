<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title id="contactContent">
    <?php
    $currentUri = $_SERVER['REQUEST_URI'];

    $cleanUri = strtok($currentUri, '?');
    $page = basename($cleanUri);
    $cleanName = str_replace('-', ' ', $page);
    $title = ucwords($cleanName);
    echo $title;
    ?>
   </title>
   <link rel="icon" href="images/logo.png" type="image/png">

   <!-- CUSTOM CSS Sass -->
   <link rel="stylesheet" href="assets/css/main.css">

   <!-- BOOTSTRAP 5 CSS -->
   <link rel="stylesheet" type="text/css" href="plugins/bootstrap5/css/bootstrap.min.css">

   <!-- REMIXICON ICONS-->
   <link href="plugins/icons/remixicon/node_modules/remixicon/fonts/remixicon.css" rel="stylesheet">

   <!-- select2 dropdown -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

   <!-- datatable -->
  <script src="plugins/datatables/datatables.min.css"></script>

   <!-- CHART JS -->
   <script src="plugins//chart/apex-chart/dist/apexcharts.js"></script>
    
   <!-- font family -->
   <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
   
   <!-- Datatable Responsive CSS -->
    <link href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.dataTables.css
" rel="stylesheet">
   <link href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" rel="stylesheet">

   <!-- Select2 CSS -->
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   
</head>
<body>