<? require_once('inc/common.php') ?>

<?

?>

<!DOCTYPE html>
<html>
<head>
<title>EL Diary</title>
<meta charset='utf-8' />
<link href='css/fullcalendar.min.css' rel='stylesheet' />
<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='js/moment.min.js'></script>
<script src='js/jquery.min.js'></script>
<script src='js/jquery-ui.min.js'></script>
<script src='js/fullcalendar.min.js'></script>
<script src='js/locale-all.js'></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link href='css/base.css?<?=filemtime('js/main.js')?>' rel='stylesheet' />
<script src='js/main.js?<?=filemtime('js/main.js')?>'></script>
<script src='js/diary.js?<?=filemtime('js/diary.js')?>'></script>

<script>

</script>
<style>

</style>

</head>
<body>
	
	<input type="hidden" name="checkLogin" value="<?=$_SESSION["seq"]?>">

	<div id='wrap'>

		<div id='external-events'>
			<h4 style="font-weight:bold;">일정 추가&삭제</h4>
			<div class="fc-event-group">
				<div class='fc-event' bg_color="#3a87ad" text_color="white" style="background-color:#3a87ad; color:white;">My Event</div>
				<div class='fc-event' bg_color="black" text_color="white" style="background-color:black; color:white;">My Event</div>
				<div class='fc-event' bg_color="red" text_color="white" style="background-color:red; color:white;">My Event</div>
			</div>
			<p style="display:none">
				<input type='checkbox' id='drop-remove' checked='checked' />
				<label for='drop-remove'>remove after drop</label>
			</p>
			<div style="text-align:center; margin:30px 0 10px 0">
				<? if (!$_SESSION["seq"]) { ?>
				<button type="button" class="btn btn-success" style="width:100%;" data-toggle="modal" data-target="#loginModal">Login / Register</button>
				<? } else { ?>
				<button type="button" class="btn btn-danger" style="width:100%;" onclick="userLogout();">Logout</button>
				<? } ?>
			</div>
		</div>

		<div id='calendar'></div>

		<div style='clear:both'></div>

	</div>
	<br /><br />

</body>
</html>


<!-- 모달 리스트 -->
<div id="fullCalModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
				<h4 id="modalTitle" class="modal-title">일정 수정하기</h4>
			</div>
			<div id="modalBody" class="modal-body">
				<div>
					<input type="hidden" name="eventId" />
					<input type="text" id="titleValue" name="titleValue" style="width:90%" onkeypress="if (event.keyCode == 13) putTitleUpdate();" />
				</div><br />
				<div style="width:90%; text-align:left; padding-left:30px;">
					<span style="font-weight:bold;">Color</span>
					<select class="colorSelect" name="colorSelect">
						<option value="default">default</option>
						<option value="black">black</option>
						<option value="red">red</option>
					</select>
				</div>			
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" onclick="javascript:putTitleUpdate()">수정</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="loginModal" class="container modal fade">
	<div class="modal-dialog" style="width:300px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
				<h4 id="modalTitle" class="modal-title"><div class="panel-title">Login / Register</div></h4>
			</div>
			<form method="POST" name="loginForm">
				<input type="hidden" name="loginMode">
				<div id="modalBody" class="modal-body">
					<div>
						<input type="text" class="form-control" name="username" placeholder="Username" required autofocus />
					</div>
					<div>
						<input type="password" class="form-control" name="password" placeholder="Password" onkeypress="if (event.keyCode == 13) submitLogin();" required>
					</div>
				</div>
				<div class="modal-footer">
					<div>
						<button type="button" class="form-control btn btn-info" onclick="javascript:submitLogin();">Login</button>
					</div>
					<div style="margin-top:5px">
						<button type="button" class="form-control btn btn-success" onclick="javascript:submitRegister();">Register</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>