//JS FUNCTION TO SAVE DETAILS */

function saveDetails()
{

		//GET THE VALUES HERE//

		var city=document.getElementById("cty").value;
		var college=document.getElementById("clg").value;

    	var ajaxRequest; // The variable that makes Ajax possible!
		try{
				// Opera 8.0+, Firefox, Safari
				ajaxRequest = new XMLHttpRequest();
			}catch (e){
				// Internet Explorer Browsers
		try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			}catch (e) {
		try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
			}
			}
			}
// Create a function that will receive data
// sent from the server and will update
// div section in the same page.
			ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('result');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			}
			}
			// Now get the value from user and pass it to
			// server script.

			var request='&clg='+college+'&cty='+city;
			ajaxRequest.open("GET", "../resoures/AddImf.php?src=basic-info"+request, true);

			ajaxRequest.send(null);

}


//SAVE DETAILS ABOUT //


function saveAboutDetails()
{

		//GET THE VALUES HERE//

		var about=document.getElementById("abt").value;

    	var ajaxRequest; // The variable that makes Ajax possible!
		try{
				// Opera 8.0+, Firefox, Safari
				ajaxRequest = new XMLHttpRequest();
			}catch (e){
				// Internet Explorer Browsers
		try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			}catch (e) {
		try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
			}
			}
			}
// Create a function that will receive data
// sent from the server and will update
// div section in the same page.
			ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('result');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			}
			}
			// Now get the value from user and pass it to
			// server script.

			var request='&abt='+about;
			ajaxRequest.open("GET", "../resoures/AddImf.php?src=abt"+request, true);

			ajaxRequest.send(null);

}

//SAVE THE SEARCH TAG

function saveTags()
{
	//GET THE VALUES HERE//

		var tags=document.getElementById("search_tag").value;

		alert("Tags: "+tags);

    	var ajaxRequest; // The variable that makes Ajax possible!
		try{
				// Opera 8.0+, Firefox, Safari
				ajaxRequest = new XMLHttpRequest();
			}catch (e){
				// Internet Explorer Browsers
		try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			}catch (e) {
		try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
			}
			}
			}
// Create a function that will receive data
// sent from the server and will update
// div section in the same page.
			ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('result');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			}
			}
			// Now get the value from user and pass it to
			// server script.

			var request='&q='+tags;
			ajaxRequest.open("GET", "../resoures/AddImf.php?src=tags"+request, true);

			ajaxRequest.send(null);

}




