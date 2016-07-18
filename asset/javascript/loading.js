var showloading_dot="";
var showloading_dot2="";
var showloading_id = 0;
function showloading(){
	var loading=document.getElementById("loading");
	if(!loading)
		return false;
	loading.style.display="block";
	showloading_dot+="&laquo;";
	showloading_dot2+="..";
	if(showloading_dot.length>40){
		showloading_dot="";
		showloading_dot2="";
	}
	// loading.innerHTML=showloading_dot2+"Loading Content"+showloading_dot;  
	loading.innerHTML="Loading"+showloading_dot2;  
	showloading_id=setTimeout("showloading()",400);
}
function stoploading(){
	var loading=document.getElementById("loading");if(!loading)return false;
	loading.style.display="none";
	if(showloading_id){
		clearTimeout(showloading_id);
		showloading_id=0;
	}
}