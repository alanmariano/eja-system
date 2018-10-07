
    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
    <script src="plugins/ckeditor4/ckeditor.js"></script> 
    <script src="assets/js/selectize.min.js"></script>  

<script>
    function ajax_handler(func, json){
        var xhttp = new XMLHttpRequest();
        console.log("aaa");
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
</script>