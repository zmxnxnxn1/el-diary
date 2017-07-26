$(document).ready(function() {

	$('#external-events .fc-event').each(function() {

		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			stick: true, // maintain when user navigates (see docs on the renderEvent method),
		});

		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 999,
			revert: true,      // will cause the event to go back to its
			revertDuration: 0  //  original position after the drag
		});

	});

	$('#calendar').fullCalendar({

		events: 'model/getDiaryList.php',
		firstDay: 0, // 0=일요일, 1=월요일
		weekNumbers: false, // true일때 월(Month) 선택시 주차 표시, false 일경우 주차 표시 안함.
		weekNumbersWithinDays: true,
		weekNumberCalculation: 'ISO',
		locale: 'ko',
		
		eventClick: function(event, calEvent, jsEvent, view) {
			clickEvent(event, calEvent);
		},
		eventDrop: function( event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view ) {
			moveEvent(event);
		},
		eventResize:function( event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view ) { 
			resizeEvent(event);
		},

		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay,listWeek'
		},
		navLinks: true, // can click day/week names to navigate views

		editable: true, // true 일때 드래그 또는 사이즈 조정을 하도록함, false 일경우 드래그 또는 사이즈 조정을 하지 않음
		droppable: true, // 달력에 드래그해서 떨어트려줄수 있게 한다.
		drop: function(date , jsEvent , ui , resourceId) {
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				//$(this).remove(); // if so, remove the element from the "Draggable Events" list

				var bg_color = $(this).attr("bg_color");
				var text_color = $(this).attr("text_color");
				putDiaryInsert(date["_d"].toJSON(), bg_color, text_color); // 일정 추가하기
			}
		},

		/** 드래그로 삭제하는 기능 A */
		eventDragStop: function( event, jsEvent, ui, view ) {
			if (isEventOverDiv(jsEvent.clientX, jsEvent.clientY)) {
					$('#calendar').fullCalendar('removeEvents', event._id);
					var el = $( "<div class='fc-event'>" ).appendTo( '#external-events-listing' ).text( event.title );
					el.draggable({
						zIndex: 999,
						revert: true, 
						revertDuration: 0 
					});
						
					$.ajax({
						url:"model/putDiaryTrashDelete.php",
						type:"post",
						data:{"seq":event.id}
					});

					el.data('event', { title: event.title, id :event.id, stick: true });
					
			}
		},
		
		/**  마지막 날짜 리로드 */
		defaultDate: localStorage.getItem('defaultFullCalendarDate'),
		viewRender: function(view) {
			var currentDate = $('#calendar').fullCalendar('getDate').toDate();
			localStorage.setItem('defaultFullCalendarDate', currentDate);
		},


	});

	/** 드래그 삭제기능 B */
	var isEventOverDiv = function(x, y) {
		var external_events = $( '#external-events' );
		var offset = external_events.offset();
		offset.right = external_events.width() + offset.left;
		offset.bottom = external_events.height() + offset.top;

		// Compare
		if (x >= offset.left && y >= offset.top && x <= offset.right && y <= offset .bottom) { 
			if (!confirm("정말로 삭제하시겠습니까?")) return;
			return true; 
		}
		return false;
	}
	
	startApplycation(); // 어플리케이션 시작
});

$(document).ready(function() {

	/** 수정 모드에서 포커스 기능 */
	$('#fullCalModal').on('shown.bs.modal', function () {
	    $('#titleValue').focus();
	});

	/** 새로고침 */
	$('.fc-center').click(function () {
		location.reload();
	});

	/** 날짜클릭 기능 삭제 */
	$(".fc-day-number").removeAttr("data-goto");


});