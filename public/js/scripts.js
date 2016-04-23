// Empty JS for your own code to be here
// $(document).ready(function () {
//   $("#addAj").click(function(event){
//   var data = $("#addname").val();
//   console.log(data);

//   $.ajax({
//     url:"/add",
//     type: 'POST',
//     data:data,
//     dataType:'json',
//     success:function(res){
//        console.log("success");
//        //console.log(res.data);
//        //$("#count").text(res.price)
//       }
//     });
//  event.preventDefault();
// });
// });

//=======================
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","getuser.php?q="+str,true);
  xmlhttp.send();
}