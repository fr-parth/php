<!DOCTYPE html>
<html>
<body>

<p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">LoginGetLocation</button>

<p id="demo"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
	
    if (navigator.geolocation) {
		
       navigator.geolocation.getCurrentPosition(showPosition);
		
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
	
	//return false;
}

function showPosition(position) {
	alert("hi");
    
}
</script>

</body>
</html>