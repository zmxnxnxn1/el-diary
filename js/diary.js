// 어플리케이션 시작
function startApplycation() {
	
}

// 캘린더 갱신
function fullCalendarRefresh() {

	if (!checkLogin()) return;

	$('#calendar').fullCalendar('removeEvents');
	$('#calendar').fullCalendar('refetchEvents');
}

// 로그인 체크
function checkLogin() {
	return $("input[name=checkLogin]").val() ? true : false;
}

// 클릭 이벤트
function clickEvent(event, calEvent) {
	//console.log(event); console.log(calEvent);

	$('#titleValue').val(event.title);
	$("input[name=eventId]").val(event.id);
	$('#fullCalModal').modal();

	// 타이틀 색상 SELECT
	var eventTitleColor = event.color == "#3a87ad" ? "default" : event.color;
	$(".colorSelect option").each( function(index, Element) {
		if (this.value == eventTitleColor) {
			$(this).prop("selected", "selected");
		} else {
			$(this).removeAttr("selected");
		}
	});
	
}

// 이동 이벤트
function moveEvent(event) {
	//console.log(event);

	var seq = event["id"];
	var startDate = event["start"]["_d"].toJSON();
	var EndDate = checkNullEndDate(event);

	putDiaryMoveUpdate(seq, startDate, EndDate);
}

// 리사이즈 이벤트
function resizeEvent(event) {
	//console.log(event);

	var seq = event["id"];
	var startDate = event["start"]["_d"].toJSON();
	var EndDate = checkNullEndDate(event);

	putDiaryResizeUpdate(seq, startDate, EndDate);
}

// endDate 널 체크
function checkNullEndDate(event) {
	return endDate = (event["end"]) ? event["end"]["_d"].toJSON() : null;
}


// 일정 추가 이벤트
function putDiaryInsert(dateValue, bg_color, text_color) {
	$.ajax({
		url:'model/putDiaryInsert.php',
		dataType:'json',
		async: false,
		data:{"dateValue":dateValue, "bg_color":bg_color, "text_color":text_color},
		success:function(data) {} 
	});

	fullCalendarRefresh();
	
} // End of function

// 일정 이동 이벤트
function putDiaryMoveUpdate(seq, startDate, EndDate) {
	$.ajax({
		url:'model/putDiaryMoveUpdate.php',
		dataType:'json',
		data:{"seq":seq, "startDate":startDate, "EndDate":EndDate},
		success:function(data) {} 
	});
} // End of function

// 일정 리사이즈 이벤트
function putDiaryResizeUpdate(seq, startDate, EndDate) {
	$.ajax({
		url:'model/putDiaryResizeUpdate.php',
		dataType:'json',
		data:{"seq":seq, "startDate":startDate, "EndDate":EndDate},
		success:function(data) {} 
	});
} // End of function


// 일정 타이틀 수정
function putTitleUpdate() {
	var title = $("input[name=titleValue]").val();
	var eventId = $("input[name=eventId]").val();
	var colorSelect= $("select[name=colorSelect]").val();

	$.ajax({
		url:'model/putTitleUpdate.php',
		async: false,
		data:{"title":title, "seq":eventId, "colorSelect":colorSelect},
		success:function(data) {
			fullCalendarRefresh();
			$('#fullCalModal').modal('hide');

			if (!checkLogin()) {
				alert("미로그인 상태에서는 반영되지 않습니다.");
			}

		} 
	});
	
}

// 로그인
function submitLogin() {
	if (!checkLoginInput()) return;
	
	$("input[name=loginMode]").val("login");

	var formObj = document.loginForm;
	formObj.action = "login.php";
	formObj.submit();
}

// 로그아웃
function userLogout() {
	if (!confirm('로그아웃 하시겠습니까?')) return;

	$("input[name=loginMode]").val("logout");

	var formObj = document.loginForm;
	formObj.action = "login.php";
	formObj.submit();
}

// 등록
function submitRegister() {
	if (!checkLoginInput()) return;
	if (!confirm('등록 하시겠습니까?')) return;

	$("input[name=loginMode]").val("register");

	var formObj = document.loginForm;
	formObj.action = "login.php";
	formObj.submit();
}

// 로그인 및 등록 input 체크
function checkLoginInput() {
	if (!$("input[name=username]").val()) {
		alert("아이디를 입력해주세요.");
		$("input[name=username]").focus();
		return;
	}

	if (!$("input[name=password]").val()) {
		alert("비밀번호를 입력해주세요.");
		$("input[name=password]").focus();
		return;
	}

	return true;
}

// 이벤트 박스 새로고침
function refreshEventBox() {
	location.reload();
}