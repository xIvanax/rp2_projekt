$(document).ready(function() {
  $('#dateInput1').click(function() {
    $('#datePicker1').show();
    renderCalendar1();
  });

  $('#dateInput2').click(function() {
    $('#datePicker2').show();
    renderCalendar2();
  });

  $('#datePicker1 .close').click(function() {
    $('#datePicker1').hide();
  });

  $('#datePicker2 .close').click(function() {
    $('#datePicker2').hide();
  });

  $('#datePicker1').on('click', '.date', function() {
    var date = $(this).text();
    var month = $('#calendarContainer1').data('month');
    var year = $('#calendarContainer1').data('year');
    var formattedDate = formatDate(year, month, date);
    $('#dateInput1').val(formattedDate);
    $('#datePicker1').hide();
  });

  $('#datePicker2').on('click', '.date', function() {
    var date = $(this).text();
    var month = $('#calendarContainer2').data('month');
    var year = $('#calendarContainer2').data('year');
    var formattedDate = formatDate(year, month, date);
    $('#dateInput2').val(formattedDate);
    $('#datePicker2').hide();
  });

  $('#datePicker1').on('click', '.prev-month1', function() {
    var currentMonth = $('#calendarContainer1').data('month');
    var currentYear = $('#calendarContainer1').data('year');
    var prevMonth;
    if(Number(currentMonth) > 0)
      prevMonth = new Date(currentYear, currentMonth - 1, 1);
    else
      prevMonth = new Date(currentYear - 1, 11, 1);

    $('#calendarContainer1').data('month', prevMonth.getMonth());
    $('#calendarContainer1').data('year', prevMonth.getFullYear());

    var monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var selectedYear = prevMonth.getFullYear();
    var selectedMonth = prevMonth.getMonth();

    var calendarHTML = '';
    calendarHTML += '<div class="calendar-header1">';
    calendarHTML += '<span class="prev-month1">&lt;</span>';

    calendarHTML += '<span class="month-year">' + monthNames[selectedMonth] + ' ' + selectedYear + '</span>';

    calendarHTML += '<span class="next-month">&gt;</span>';
    calendarHTML += '</div>';
    calendarHTML += '<table id="calTable1">';
    calendarHTML += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';

    var firstDay = new Date(selectedYear, selectedMonth, 1).getDay();
    var daysInMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();


    var date = 1;
    for (var i = 0; i < 6; i++) {
      calendarHTML += '<tr>';
      for (var j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
          calendarHTML += '<td></td>';
        } else if (date > daysInMonth) {
          calendarHTML += '<td></td>';
        } else {
          var cellClass = (selectedYear === currentYear && selectedMonth === currentMonth && date === currentDate.getDate()) ? 'date today' : 'date';
          calendarHTML += '<td class="' + cellClass + '">' + date + '</td>';
          date++;
        }
      }
      calendarHTML += '</tr>';
    }

    calendarHTML += '</table>';
    $('#calendarContainer1').html(calendarHTML);
    $('#calendarContainer1').data('month', selectedMonth);
    $('#calendarContainer1').data('year', selectedYear);
  });

  $('#datePicker2').on('click', '.prev-month2', function() {
    var currentMonth = $('#calendarContainer2').data('month');
    var currentYear = $('#calendarContainer2').data('year');
    var prevMonth;
    if(Number(currentMonth) > 0)
      prevMonth = new Date(currentYear, currentMonth - 1, 1);
    else
      prevMonth = new Date(currentYear - 1, 11, 1);

    $('#calendarContainer2').data('month', prevMonth.getMonth());
    $('#calendarContainer2').data('year', prevMonth.getFullYear());

    var monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var selectedYear = prevMonth.getFullYear();
    var selectedMonth = prevMonth.getMonth();

    var calendarHTML = '';
    calendarHTML += '<div class="calendar-header2">';
    calendarHTML += '<span class="prev-month2">&lt;</span>';

    calendarHTML += '<span class="month-year">' + monthNames[selectedMonth] + ' ' + selectedYear + '</span>';

    calendarHTML += '<span class="next-month">&gt;</span>';
    calendarHTML += '</div>';
    calendarHTML += '<table id="calTable2">';
    calendarHTML += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';

    var firstDay = new Date(selectedYear, selectedMonth, 1).getDay();
    var daysInMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();


    var date = 1;
    for (var i = 0; i < 6; i++) {
      calendarHTML += '<tr>';
      for (var j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
          calendarHTML += '<td></td>';
        } else if (date > daysInMonth) {
          calendarHTML += '<td></td>';
        } else {
          var cellClass = (selectedYear === currentYear && selectedMonth === currentMonth && date === currentDate.getDate()) ? 'date today' : 'date';
          calendarHTML += '<td class="' + cellClass + '">' + date + '</td>';
          date++;
        }
      }
      calendarHTML += '</tr>';
    }

    calendarHTML += '</table>';
    $('#calendarContainer2').html(calendarHTML);
    $('#calendarContainer2').data('month', selectedMonth);
    $('#calendarContainer2').data('year', selectedYear);
  });

  $('#datePicker1').on('click', '.next-month', function() {
    var currentMonth = $('#calendarContainer1').data('month');
    var currentYear = $('#calendarContainer1').data('year');
    var nextMonth;
    if(Number(currentMonth < 11))
      nextMonth = new Date(currentYear, currentMonth + 1, 1);
    else
      nextMonth = new Date(currentYear + 1, 0, 1);

    $('#calendarContainer1').data('month', nextMonth.getMonth());
    $('#calendarContainer1').data('year', nextMonth.getFullYear());

    var monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var selectedYear = nextMonth.getFullYear();
    var selectedMonth = nextMonth.getMonth();

    var calendarHTML = '';
    calendarHTML += '<div class="calendar-header1">';
    calendarHTML += '<span class="prev-month1">&lt;</span>';

    calendarHTML += '<span class="month-year">' + monthNames[selectedMonth] + ' ' + selectedYear + '</span>';

    calendarHTML += '<span class="next-month">&gt;</span>';
    calendarHTML += '</div>';
    calendarHTML += '<table id="calTable1">';
    calendarHTML += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';

    var firstDay = new Date(selectedYear, selectedMonth, 1).getDay();
    var daysInMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();


    var date = 1;
    for (var i = 0; i < 6; i++) {
      calendarHTML += '<tr>';
      for (var j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
          calendarHTML += '<td></td>';
        } else if (date > daysInMonth) {
          calendarHTML += '<td></td>';
        } else {
          var cellClass = (selectedYear === currentYear && selectedMonth === currentMonth && date === currentDate.getDate()) ? 'date today' : 'date';
          calendarHTML += '<td class="' + cellClass + '">' + date + '</td>';
          date++;
        }
      }
      calendarHTML += '</tr>';
    }

    calendarHTML += '</table>';
    $('#calendarContainer1').html(calendarHTML);
    $('#calendarContainer1').data('month', selectedMonth);
    $('#calendarContainer1').data('year', selectedYear);
  });

  $('#datePicker2').on('click', '.next-month', function() {
    var currentMonth = $('#calendarContainer2').data('month');
    var currentYear = $('#calendarContainer2').data('year');
    var nextMonth;
    if(Number(currentMonth < 11))
      nextMonth = new Date(currentYear, currentMonth + 1, 1);
    else
      nextMonth = new Date(currentYear + 1, 0, 1);

    $('#calendarContainer2').data('month', nextMonth.getMonth());
    $('#calendarContainer2').data('year', nextMonth.getFullYear());

    var monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var selectedYear = nextMonth.getFullYear();
    var selectedMonth = nextMonth.getMonth();

    var calendarHTML = '';
    calendarHTML += '<div class="calendar-header2">';
    calendarHTML += '<span class="prev-month2">&lt;</span>';

    calendarHTML += '<span class="month-year">' + monthNames[selectedMonth] + ' ' + selectedYear + '</span>';

    calendarHTML += '<span class="next-month">&gt;</span>';
    calendarHTML += '</div>';
    calendarHTML += '<table id="calTable2">';
    calendarHTML += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';

    var firstDay = new Date(selectedYear, selectedMonth, 1).getDay();
    var daysInMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();


    var date = 1;
    for (var i = 0; i < 6; i++) {
      calendarHTML += '<tr>';
      for (var j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
          calendarHTML += '<td></td>';
        } else if (date > daysInMonth) {
          calendarHTML += '<td></td>';
        } else {
          var cellClass = (selectedYear === currentYear && selectedMonth === currentMonth && date === currentDate.getDate()) ? 'date today' : 'date';
          calendarHTML += '<td class="' + cellClass + '">' + date + '</td>';
          date++;
        }
      }
      calendarHTML += '</tr>';
    }

    calendarHTML += '</table>';
    $('#calendarContainer2').html(calendarHTML);
    $('#calendarContainer2').data('month', selectedMonth);
    $('#calendarContainer2').data('year', selectedYear);
  });

  function renderCalendar1() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth();
    var monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var selectedDate = new Date($('#dateInput1').val());
    var selectedYear = selectedDate.getFullYear();
    var selectedMonth = selectedDate.getMonth();

    var calendarHTML = '';
    calendarHTML += '<div class="calendar-header1">';
    calendarHTML += '<span class="prev-month1">&lt;</span>';
    if(isNaN(selectedYear) || isNaN(selectedMonth)){
      calendarHTML += '<span class="month-year">' + monthNames[currentMonth] + ' ' + currentYear + '</span>';
    }
    else{
      calendarHTML += '<span class="month-year">' + monthNames[selectedMonth] + ' ' + selectedYear + '</span>';
    }
    calendarHTML += '<span class="next-month">&gt;</span>';
    calendarHTML += '</div>';
    calendarHTML += '<table id="calTable1">';
    calendarHTML += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';

    var firstDay, daysInMonth;
    if(isNaN(selectedYear) || isNaN(selectedMonth)){
      firstDay = new Date(currentYear, currentMonth, 1).getDay();
      daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    }else{
      firstDay = new Date(selectedYear, selectedMonth, 1).getDay();
      daysInMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();
    }

    var date = 1;
    for (var i = 0; i < 6; i++) {
      calendarHTML += '<tr>';
      for (var j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
          calendarHTML += '<td></td>';
        } else if (date > daysInMonth) {
          calendarHTML += '<td></td>';
        } else {
          var cellClass = (selectedYear === currentYear && selectedMonth === currentMonth && date === currentDate.getDate()) ? 'date today' : 'date';
          calendarHTML += '<td class="' + cellClass + '">' + date + '</td>';
          date++;
        }
      }
      calendarHTML += '</tr>';
    }

    calendarHTML += '</table>';
    $('#calendarContainer1').html(calendarHTML);
    if(isNaN(selectedYear) || isNaN(selectedMonth)){
      $('#calendarContainer1').data('month', currentMonth);
      $('#calendarContainer1').data('year', currentYear);
    }else{
      $('#calendarContainer1').data('month', selectedMonth);
      $('#calendarContainer1').data('year', selectedYear);
    }
  }

  function renderCalendar2() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth();
    var monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var selectedDate = new Date($('#dateInput2').val());
    var selectedYear = selectedDate.getFullYear();
    var selectedMonth = selectedDate.getMonth();

    var calendarHTML = '';
    calendarHTML += '<div class="calendar-header2">';
    calendarHTML += '<span class="prev-month2">&lt;</span>';
    if(isNaN(selectedYear) || isNaN(selectedMonth)){
      calendarHTML += '<span class="month-year">' + monthNames[currentMonth] + ' ' + currentYear + '</span>';
    }
    else{
      calendarHTML += '<span class="month-year">' + monthNames[selectedMonth] + ' ' + selectedYear + '</span>';
    }
    calendarHTML += '<span class="next-month">&gt;</span>';
    calendarHTML += '</div>';
    calendarHTML += '<table id="calTable2">';
    calendarHTML += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';

    var firstDay, daysInMonth;
    if(isNaN(selectedYear) || isNaN(selectedMonth)){
      firstDay = new Date(currentYear, currentMonth, 1).getDay();
      daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    }else{
      firstDay = new Date(selectedYear, selectedMonth, 1).getDay();
      daysInMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();
    }

    var date = 1;
    for (var i = 0; i < 6; i++) {
      calendarHTML += '<tr>';
      for (var j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay) {
          calendarHTML += '<td></td>';
        } else if (date > daysInMonth) {
          calendarHTML += '<td></td>';
        } else {
          var cellClass = (selectedYear === currentYear && selectedMonth === currentMonth && date === currentDate.getDate()) ? 'date today' : 'date';
          calendarHTML += '<td class="' + cellClass + '">' + date + '</td>';
          date++;
        }
      }
      calendarHTML += '</tr>';
    }

    calendarHTML += '</table>';
    $('#calendarContainer2').html(calendarHTML);
    if(isNaN(selectedYear) || isNaN(selectedMonth)){
      $('#calendarContainer2').data('month', currentMonth);
      $('#calendarContainer2').data('year', currentYear);
    }else{
      $('#calendarContainer2').data('month', selectedMonth);
      $('#calendarContainer2').data('year', selectedYear);
    }
  }

  function formatDate(year, month, day) {
    var formattedMonth = (month < 9) ? '0' + (month + 1) : (month + 1);
    var formattedDay = (day < 10) ? '0' + day : day;
    return year + '-' + formattedMonth + '-' + formattedDay;
  }
});
