<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <title>Data Table</title>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css'>
	<link rel='stylesheet' href='https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css'>
	<link rel="stylesheet" href="./style.css">
</head>
<body>
  <div class="table-reponsive box">
  <table id="example" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Position</th>
        <th>Office</th>
        <th>Age</th>
        <th>Start date</th>
        <th>Salary</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Tiger Nixon</td>
        <td>System Architect</td>
        <td>Edinburgh</td>
        <td>61</td>
        <td>2011/04/25</td>
        <td>$320,800</td>
      </tr>      
    </tbody>
  </table>
</div>
  <script src='https://code.jquery.com/jquery-3.3.1.js'></script>
	<script src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
	<script src='https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js'></script>
	<script  src="./script.js"></script>
</body>
</html>
