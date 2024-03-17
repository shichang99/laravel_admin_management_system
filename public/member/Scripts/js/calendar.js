
// 引入应用 ：当您想使用此日历应用，只要 oncall open_calender(ID, DATEFORMAT, THIS.ELEMENT)

var DATEFORMAT = 'dd MMM yyyy';
var PUB_DEFAULT_DATE = '1';
var PUB_DEFAULT_MONTH = '0';
var PUB_DEFAULT_YEAR = new Date().getFullYear();
var DISPLAY_DATE_LIST = [];
var DISPLAY_MONTH_LIST = [1,2,3,4,5,6,7,8,9,10,11,12];
var DISPLAY_MONTH_SHORTNAME_LIST = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
var DISPLAY_MONTH_NAME_LIST = ['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];
var DISPLAY_YEAR_LIST = [
                          '2023','2022','2021','2020','2019','2018','2017','2016',
                          '2015','2014','2013','2012','2011','2010','2009','2008',
                          '2007','2006','2005','2004','2003','2002','2001','2000',
                          '1999','1998','1997','1996','1995','1994','1993','1992',
                          '1991','1990','1989','1988','1987','1986','1985','1984',
                          '1983','1982','1981','1980','1979','1978','1977','1976',
                          '1975','1974','1973','1972','1971','1970','1969','1968',
                          '1967','1966','1965','1964','1963','1962','1961','1960',
                          '1959','1958','1957','1956','1955','1954','1953','1952',
                          '1951','1950','1949','1948','1947','1946','1945','1944',
                          '1943','1942','1941','1940','1939','1938','1937','1936',
                          '1935','1934','1933','1932','1931','1930','1929','1928',
                          '1927','1926','1925','1924','1923','1922','1921','1920',
                          '1919','1918','1917','1916','1915','1914','1913','1912',
                          '1911','1910','1909','1908','1907','1906','1905','1904',
                          '1903','1902','1901','1900'
                        ];

function open_calender(id, target_id,  hardDate = '', hardMonth = '', hardYear = '') //target_id is input that wants to insert
{
  //check if value 
  if(hardDate !== '')
  {
    PUB_DEFAULT_DATE = hardDate;
  }
  if(hardMonth !== '')
  {
    PUB_DEFAULT_MONTH = hardMonth+1;
  }
  if(hardYear !== '')
  {
    PUB_DEFAULT_YEAR = hardYear;
  }

  var current_input_value = $(target_id).val();
  if(current_input_value !== '')
  {
    //check if got value, pub_default need set current input value , if not harddate not empty take harddate, else remain
    var converted_current_input = new Date(current_input_value);
    var converted_current_input_DATE = converted_current_input.getDate();
    var converted_current_input_MONTH = converted_current_input.getMonth();
    var converted_current_input_YEAR = converted_current_input.getFullYear();

    PUB_DEFAULT_DATE = converted_current_input_DATE;
    PUB_DEFAULT_MONTH = converted_current_input_MONTH+1;
    PUB_DEFAULT_YEAR = converted_current_input_YEAR;

    
    

    
  }else {

    if(hardDate !== '')
    {
      PUB_DEFAULT_DATE = hardDate;
    }
    if(hardMonth !== '')
    {
      PUB_DEFAULT_MONTH = hardMonth+1;
    }
    if(hardYear !== '')
    {
      PUB_DEFAULT_YEAR = hardYear;
    }

  }

  $(id).show();
  
  create_datepicker(id,target_id);
  update_datepicker_info(PUB_DEFAULT_DATE, PUB_DEFAULT_MONTH, PUB_DEFAULT_YEAR, id, target_id);

}


function select_date(hardDate, hardMonth, hardYear, id, cal_id)
{
  //$(id).val(dateformat( (hardDate + ' ' + DISPLAY_MONTH_SHORTNAME_LIST[hardMonth-1] + ', ' + hardYear) , DATEFORMAT));
  //$(cal_id).hide();
  
  //for this project, checking above 18
  var age = getAge((hardDate + ' ' + DISPLAY_MONTH_SHORTNAME_LIST[hardMonth-1] + ', ' + hardYear));
  if( age > 18 ) {
    $(id).val(dateformat( (hardDate + ' ' + DISPLAY_MONTH_SHORTNAME_LIST[hardMonth-1] + ', ' + hardYear) , DATEFORMAT));
    $(cal_id).hide();
  }else{
    $(id).val(dateformat( (hardDate + ' ' + DISPLAY_MONTH_SHORTNAME_LIST[hardMonth-1] + ', ' + (new Date().getFullYear() - 18)) , DATEFORMAT));
    $(cal_id).hide();
  }
  //for this project, checking above 18
}

function getAge(DOB) {
  var today = new Date();
  var birthDate = new Date(DOB);
  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
  }    
  return age;
}

function close_datepicker(cal_id)
{
  $(cal_id).css('display','none');
  $(cal_id).hide();
}

function clear_target_id(target_id)
{
  $(target_id).val('');
}

function dateformat(datestring, dateformats)
{

  let display = new Date(datestring);
  let note_d = '';

  //check dateformat
  note_d = dateformats.replace('dd',display.getDate());
  note_d = note_d.replace('MMM',DISPLAY_MONTH_SHORTNAME_LIST[display.getMonth()]);
  note_d = note_d.replace('yyyy',display.getFullYear());

  return note_d;
  
}


function create_datepicker(id, target_id)
{
  $(id).html(
  '<div class="calender-boxx">'+
      '<div class="calender-headerr">'+
        '<div class="calender-left">'+
          '<div class="left-date nextbtn">Next</div>'+
          '<div class="right-date previousbtn">Previous</div>'+
        '</div>'+
        '<div class="calender-right"><b class="curmonth" id="curMonth"></b> <b class="curyear" id="curYear"></b></div>'+
      '</div>'+
      '<div>'+
        '<div class="calender-weeks">'+
          '<div>S</div><div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div>'+
        '</div>'+
        '<div class="calender-dates" id="curdays"></div>'+
      '</div>'+
  
      '<div id="c_months" class="calender-date-selection">'+
        '<div class="calender-months" id="curmonths"></div>'+
        '<span>Select Year :</span>'+
        '<div class="calender-yearr" id="curyearr">'+
        '</div>'+
        '<i class="icon-icon3"></i>'+
      '</div>'+
      '<div class="calender-button">'+
        `<div class="btn--calender-close" onclick="close_datepicker('`+id+`')" id="closebtn">Close</div>`+
        `<div class="btn--calender-clear" onclick="clear_target_id('`+target_id+`')" id="clearbtn">Clear</div>`+
      '</div>'+
    '</div>'
  );
}

function update_datepicker_info(curDate, curMonth, curYear, id, target_id)
{

  getMonthDateOnly(curMonth, curYear);

  var days = '';
  var years = '';
  var wd = new Date('1 ' + DISPLAY_MONTH_SHORTNAME_LIST[curMonth-1] + ', ' + curYear);
  var space = getSpaceForFirstDays(wd.getDay());

  
  // LOOP DATE ELEMENT / MONTHLY ELEMENT
  days += space;
  for(i = 0; i < dateArray.length; i++)
  {
    days += `<div class="` + (dateArray[i]+1) + `_` + curMonth + `_` + curYear + ` days_each `+ (((dateArray[i]+1) == curDate)? 'bolded' : '') +`" onclick="select_date(` + (dateArray[i]+1) + `, `+curMonth+`, `+curYear+`, '`+target_id+`', '`+id+`' )">` + 
      (dateArray[i]+1) + 
    `</div>`;
  }
  
  for(m = 0; m < DISPLAY_YEAR_LIST.length; m++)
  {
    years += '<option value="'+ DISPLAY_YEAR_LIST[m] +'" ' + ((DISPLAY_YEAR_LIST[m] == curYear)? 'selected' : '') + ' >' + DISPLAY_YEAR_LIST[m] + '</option>';
  }


  //Init
  $(id+' #curdays').html(days);
  $(id+' #curMonth').html(DISPLAY_MONTH_SHORTNAME_LIST[curMonth-1]);
  $(id+' #curYear').html(curYear);
  $(id+' .nextbtn').attr('onclick', 'update_datepicker_info('+curDate+', '+( (curMonth <= 11) ? (curMonth+1) : 1)+', '+( (curMonth >= 12) ? curYear+1 : curYear)+', "'+id+'", "'+target_id+'")');
  $(id+' .previousbtn').attr('onclick', 'update_datepicker_info('+curDate+', '+( (curMonth > 1) ? (curMonth-1) : 12)+', '+( (curMonth > 1) ? curYear : curYear-1 )+', "'+id+'", "'+target_id+'")');
  $(id+' #curyearr').html(
    `<select onchange="update_datepicker_info(1,`+ curMonth +`,this.value, '`+id+`', '`+target_id+`')">`+
      years +
    `</select>`
  );
}


function getMonthDateOnly(month, year)
{
  dateArray = [];
  var lastDate = new Date(year, month, 0);
  
  let lastIndexofMonth = lastDate.getDate();
  for(i = 0; i < lastIndexofMonth; i++)
  {
        
    dateArray.push(i);
  }
      
    
   
}

function getSpaceForFirstDays(num)
{
  pdays = '';
  switch(num)
  {
    case 0:
      pdays += '';
    break;
    case 1:
      pdays += '<div></div>';
    break;
    case 2:
      pdays += '<div></div><div></div>';
    break;
    case 3:
      pdays += '<div></div><div></div><div></div>';
    break;
    case 4:
      pdays += '<div></div><div></div><div></div><div></div>';
    break;
    case 5:
      pdays += '<div></div><div></div><div></div><div></div><div></div>';
    break;
    case 6:
      pdays += '<div></div><div></div><div></div><div></div><div></div><div></div>';
    break;
    default:

    break;
  }
  return pdays;
}


