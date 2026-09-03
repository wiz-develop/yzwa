$(document).ready(function(){
    $("#uzipform").submit(function() {
		window.scrollTo(0, 0);
		$('#screen').css({	"display": "block", opacity: 0.7, "width":$(document).width(),"height":$(document).height()});
		$('body').css({"overflow":"hidden"});
		$('#box').css({"display": "block"});
	
        //Do the AJAX post
        $.post($("#uzipform").attr("action"), $("#uzipform").serialize(), function(data){
            finaldata = data;
			finaldata = '<div style="margin-top:-20px;margin-bottom:30px;">'+finaldata+'</div>'+ '<input onclick="closeb();" id="closebox" style="font-size:14px;font-family:lucida sans unicode,lucida grande,sans-serif;color:#FFF;border:none;background:#FFA100;width:auto;padding-left:8px;padding-right:8px;margin-top:10px;height:35px;width:140px;" value="OK. Thanks" type="button" /> ';
			document.getElementById('innerMSG').innerHTML = finaldata;
			document.getElementById('longurl').value = "";
		});
        //Important. Stop the normal POST
        return false;
    });
});

function closeb()
{
	$('#box').css("display", "none");
	$('#screen').css("display", "none");
	$('body').css("overflow", "auto");
	document.getElementById('innerMSG').innerHTML ='Sending request to the Server. Please wait..<br /><br />	<img src="greyscreen/loader.gif" />';
}