const months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ];
  const days = [
    'Sun',
    'Mon',
    'Tue',
    'Wed',
    'Thu',
    'Fri',
    'Sat'
  ];

  var standard_date =(date) => {
      var date = new Date(date);

      date = months[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear()+' '+((date.getHours() % 12) || 12)+':'+date.getMinutes() +' '+ ( date.getHours() > 12 ? 'PM':'AM');
      return date;
  }