var xhttp = new XMLHttpRequest();
xhttp.open("GET", "https://codebreak.weareimd.be/api/chrome/wateradd", false);
xhttp.send();
var output = xhttp.response;
document.querySelector('.container').innerHTML = output;
document.getElementById('wateraddbutton').addEventListener('click', function(event){
    setTimeout(function(){ document.querySelector('.container').innerHTML = "<h1>Done</h1><p>Your water has been logged!</p><a class='btn btn-primary' href='https://codebreak.weareimd.be/dashboard/water' target='_blank' style='background-color: #28a745;border-color: #28a745;'>Go to water habit</a>"; }, 500);
});