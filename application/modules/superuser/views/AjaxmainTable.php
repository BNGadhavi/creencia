<!DOCTYPE html>
<html>
<head>
  <title>Datatable ajax server side demo</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  
</head>
<body>
  <button onclick="reloadTable()" style="font-size: 20px">Reload Data</button>
  <br>
  <br>
  <br>
  <table id="tableid">
    <thead>
      <tr>
        <th>fullname</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

var adminurl = 'http://evanland.in/panel/admin/';
var table=$('#tableid').DataTable( {
   "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 2 ] }],
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": adminurl+"/MemberDetail/ajax_call",
    "type": "POST",
  },
  "aoColumns" : [
    {"mData" : "fullname"},
    {"mData" : "action"},
   


  ]
});

function reloadTable()
{
  table.ajax.reload();
}
</script>


</html>

