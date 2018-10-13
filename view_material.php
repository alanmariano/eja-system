<!doctype html>

<html>
<head>
</head>
<body>

<?php require_once("js.php"); ?>
<script>

window.onload = function(e){
    var owner = sessionStorage.getItem("o");
    var id = sessionStorage.getItem("i");

    var data = {
        func: "get_material",
        oid: id
    }; 

    console.log("carreguei", data);

    var json = JSON.stringify(data);
                
    ajax_handler(function(response){                    
        r = JSON.parse(response);
        document.getElementsByTagName("BODY")[0].innerHTML = r[0].conteudo;                    
    }, json );

}

</script>

</body>
</html>
