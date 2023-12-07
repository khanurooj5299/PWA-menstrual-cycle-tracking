var months = ["Jan","Feb","March","April","May","June","July","Aug","Sep","Oct","Nov","Dec"];
var days = ["Sun","Mon","Tue","Wed","Thur","Fri","Sat"];

//todays date data
var t = new Date();
t.setHours(0,0,0,0);
var m = months[t.getMonth()];
var y =t.getFullYear();
var date = t.getDate();
var day = days[t.getDay()];

//functions for reading things from memory
function get_lpd()
{
	var lpd_string = window.localStorage.getItem('lpd');  //returned format:yyyy-mm-dd
	return new Date(parseInt(lpd_string.substring(0,4)),parseInt(lpd_string.substring(5,7))-1,parseInt(lpd_string.substring(8,10)),0,0,0,0);
}

function get_cl()
{
	var cl = parseInt(window.localStorage.getItem('cl'));
	return cl;
}

function get_pl()
{
	var pl = parseInt(window.localStorage.getItem('pl'));
	return pl;
}

//getting three things from memory:
//1. Last Period Date
var lpd = get_lpd();

//2.Cycle Length
var cl = get_cl();

//3.Period Length
var pl =  get_pl();

//calculating today's cycle day
var c_d = (Math.round((t.getTime() - lpd.getTime())/(1000*3600*24))) + 1 ;

//calculating the ovulation day
var ovulation_day = Math.round(cl/2);

//fixing the length of fertile window
var f_w_l = 3;

//calculating current phase
var phase = "";
if (c_d <= pl)
	phase = "Menses";
else if (c_d > pl && c_d < ovulation_day)
	phase = "Follicular";
else if (c_d == ovulation_day)
	phase = "Ovulation Day!";
else if(c_d > ovulation_day && c_d <=cl)
	phase = "Luteal";
else 
	phase = "Late";

