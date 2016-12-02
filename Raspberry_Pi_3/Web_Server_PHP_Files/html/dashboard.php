<?php
// Enter your db username and password
$db_user = "root";
$db_pass = "root";
// Enter how ofter you want the status to auto-update (in seconds)
$refresh_timer = 5;

$conn = new mysqli('localhost', $db_user, $db_pass, 'ICBP');

if (isset($_POST['id']))
{
	// Checking connection
	if ($conn->connect_error) {
		echo 0;
		exit();
	}
	$id = mysqli_real_escape_string($conn, $_POST['id']);

	$result = $conn->query("SELECT `status` FROM `radio$id` ORDER BY time DESC LIMIT 1;");
	if (!$result)
	{
		echo 0;
		exit();
	}
	$row = $result->fetch_row();
	if (!$row)
	{
		echo 0;
		exit();
	}
	
	echo $row[0];
	$conn->close();
	exit();
}
else
{
	// Checking connection
	if (!$conn->connect_error)
	{
		for ($i = 0; $i < 8; $i++)
		{
			$id = $i + 1;
			$result = $conn->query("SELECT `status` FROM `radio$id` ORDER BY time DESC LIMIT 1;");
			if (!$result || !$row = $result->fetch_row())
			{
				$breaker[$i] = " off";
			}
			else
			{
				$status = $row[0] ? "" : "off";
				$breaker[$i] = " " + $status;
			}
		}
		$conn->close();
	}
	else
	{
		for ($i = 0; $i < 8; $i++)
			$breaker[$i] = " off";
	}
	
	if (isset($_POST['all']))
	{
		for ($i = 0; $i < 8; $i++)
			$breaker[$i] = strchr($breaker[$i], "off") ? 0 : 1;

		echo json_encode($breaker);
		exit();
	}
}
$refresh_timer *= 1000;
?>

<?php
	if (isset($_POST['On'])){
		exec('sudo python /usr/lib/cgi-bin/Radio1ON.py');
		
	}
	if (isset($_POST['Off'])){
		exec('sudo python /usr/lib/cgi-bin/Radio1OFF.py');
		
	}
?>

<!DOCTYPE html>
<html>
<head>

<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<style>
  div{
    float: left;
    color:#fff;
    font-size:40px;
  }

  h2{
    text-align: center;
  }

  .wrapper{
    position: absolute;
    top: 40%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
  }

  .one{
    width: 150px;
    height:125px;
  }

  .two{
    width: 145px;
    height:100px;
    background:darkblue;
    border: 1px solid black;
  }

  .three{
    width:145px;
    height:100px;
    background:darkblue;
    border-bottom: 1px solid black;
    border-left: 1px solid black;
    border-right: 1px solid black;
  }

  .button{
    background-color: #4CAF50; /* Green */
    border: 1px solid green;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    float: left;
    padding: 5px;
    position: relative;
    left: 17%;
  }

  .status{
    background-color: #4CAF50; /* Green */
    border: 1px solid green;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    float: left;
    padding: 5px;
    position: relative;
    margin-left: 25%;
  }

  .off {
    background: red;
    display: inline-block;
  }

  .button:hover {
    background-color: #3e8e41;
  }

  .poweron {
    background: grey;
    float: left;
    margin-left: 25%;
    padding: 5px;
    display: inline-block;
  }

  .poweroff {
    background: grey;
    float: left;
    padding: 5px;
  }

  .spacer{
    background: darkblue;
    float:left;
    margin-left: 5%;
    padding: 6px;
    border: 1px solid darkblue;
    color: darkblue;
    display: inline-block;
}
</style>
</head>

<body>
  <h2>ICBP Dashboard</h2>
  <div class="wrapper">
  <div class="one">
    <div class="two">
		<a href="breaker1/index.php"><button class="button">Breaker 1</button></a>
	<form method="post">
		<button class="poweron" name="On">On</button>
		<button class="poweroff" name="Off">Off</button>
	</form>
		<button class="spacer" data-id="1">_</button>
		<button class="status <?php echo $breaker[0]; ?>">Status</button>
    </div>
    <div class="three">
		<a href="breaker2/index.php"><button class="button">Breaker 2</button></a>
        <form method="post">
                <button class="poweron" name="On">On</button>
                <button class="poweroff" name="Off">Off</button>
        </form>
                <button class="spacer" data-id="2">_</button>
		<button class="status <?php echo $breaker[2]; ?>">Status</button>
    </div>
  </div>

  <div class="one">
    <div class="two">
		<a href="breaker3/index.php"><button class="button">Breaker 3</button></a>
		<button class="poweron">On</button>
		<button class="poweroff" data-id="3">Off</button>
		<button class="status <?php echo $breaker[2]; ?>">Status</button>
    </div>
	<div class="three">
		<a href="breaker4/index.php"><button class="button">Breaker 4</button></a>
		<button class="poweron">On</button>
		<button class="poweroff" data-id="4">Off</button>
		<button class="status <?php echo $breaker[3]; ?>">Status</button>
    </div>
  </div>
  <div class="one">
    <div class="two">
                <a href="breaker5/index.php"><button class="button">Breaker 5</button></a>
		<button class="poweron">On</button>
		<button class="poweroff" data-id="5">Off</button>
                <button class="status <?php echo $breaker[4]; ?>">Status</button>
    </div>
    <div class="three">
               <a href="breaker6/index.php"><button class="button">Breaker 6</button></a>
		<button class="poweron">On</button>
		<button class="poweroff" data-id="6">Off</button>
                <button class="status <?php echo $breaker[5]; ?>">Status</button>
    </div>
  </div>
  <div class="one">
    <div class="two">
                <a href="breaker7/index.php"><button class="button">Breaker 7</button></a>
		<button class="poweron">On</button>
		<button class="poweroff" data-id="7">Off</button>
                <button class="status <?php echo $breaker[6]; ?>">Status</button>
    </div>
    <div class="three">
                <a href="breaker8/index.php"><button class="button">Breaker 8</button></a>
		<button class="poweron">On</button>
		<button class="poweroff" data-id="8">Off</button>
                <button class="status <?php echo $breaker[7]; ?>">Status</button>
    </div>
  </div>
  </div>

  <script>
	$(document).ready(function() {
		setTimeout(executeQuery, <?php echo $refresh_timer; ?>);
	});
	function executeQuery() {
	  $.post("dashboard.php",
		{
			all: 1
		},
		function(data, status){
			var breaker = JSON.parse(data);
			for (var i = 0; i < breaker.length; i++)
			{
				var status_btn = $('.status')[i];
				if (breaker[i] == 0 && !$(status_btn).hasClass('off'))
				{
					$(status_btn).addClass('off');
				}
				else if (breaker[i] == 1 && $(status_btn).hasClass('on'))
				{
					$(status_btn).addClass('off');	
				}
			}
		});
	  setTimeout(executeQuery, <?php echo $refresh_timer; ?>);
	}

	$(".spacer").click(function(){
		var status_btn = $(this).next('.status');
		$.post("dashboard.php",
		{
			id: $(this).data('id')
		},
		function(data, status){
			if (data == '0' && !$(status_btn).hasClass('off'))
			{
				$(status_btn).addClass('off');
			}
			else if (data == '1' && $(status_btn).hasClass('off'))
			{
				$(status_btn).removeClass('off');	
			}
		})
		.fail(function(data, status) {
			if (!$(status_btn).hasClass('off'))
				$(status_btn).addClass('off');
		});
	});
  </script>
</body>
</html>
