    <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="assets/js/popper.min.js" type="text/javascript"></script>
    <script src="assets/js/plugins.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/js/notyf.min.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js" type="text/javascript"></script>
    <script src="assets/js/widgets.js" type="text/javascript"></script>
    <script src="plugins/ckeditor4/ckeditor.js" type="text/javascript"></script> 
    <script src="assets/js/selectize.min.js" type="text/javascript"></script>  

<script>
    function ajax_handler(func, json){
        var xhttp = new XMLHttpRequest();
        try{
            xhttp.open("POST", "ajax_handler.php", true);
            xhttp.setRequestHeader("Content-type", "application/json");
            xhttp.send(json);
        }catch(err){
            alert("couldnt complete request. Is JS enabled for that domain?\\n\\n" + err.message);
            return false;
        }
        
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                func(this.responseText);
            }
        };
    }

    function logout(){
        var data = {
            func: "logout"
        };

        var json = JSON.stringify(data);

        ajax_handler(function(response){
            console.log("a");
            document.location.href = 'login.php';
        }, json );
    }

</script>