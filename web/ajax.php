<!DOCTYPE html>
    <meta charset="utf-8" /> 

    <script>
        <?php 
            include '../example/resources/scripts/ajax/aj/aj.js'; 
            include '../example/resources/scripts/ajax/parameter/easyParameterAdapter.js'; 
        ?>
    </script>

    <!--
    The above script is used when running from the command line starting in web/, if on a dev server, use the following two script links 
    
    <script src="../example/resources/scripts/ajax/aj/aj.js"></script> 
    <script src="../example/resources/scripts/ajax/parameter/easyParameterAdapter.js"></script> 
    -->
    <!--
    use these to make it faster when the time is right
    <script src="resources/scripts/ajax/aj/ajG.js"></script> 
    <script src="resources/scripts/ajax/aj/ajP.js"></script>
    <script src="resources/scripts/ajax/parameter/ajGP.js"></script> 
    <script src="resources/scripts/ajax/parameter/ajPP.js"></script> 

    could put userId & login form in here
    could select the Todos from the db and have a <select> 
    <script src="resources/scripts/ajax/aj/parameter/single/optionElementParameterAdapter.js"></script>
  
    // I moved it from /web/ to /example/ but the .htaccess when running from console has to be changed so I will do that later
    // var url = "http://localhost:8080/web/todo";
    // var url = "http://localhost:8080/todo";
  -->

    <script>
      var url = "http://localhost:8080/todo";
      function $(s) { return document.getElementById(s) }

      function deleteTodo() {
        // get
        var p = "delete" + "/"  + $("ajax_input").value; 
        aj(
            {
              url: url,
              data: p,
              listeners: {
                500: function(result){console.log(result); console.log("500");},
                404: function(result){console.log(result); console.log("404");},
                201: function(result){console.log(result); console.log("201");},
                200: function(result){console.log(result); console.log("200");},
                303: function(result){console.log(result); console.log("303");},
                other: function(result){console.log(result); console.log("other");}
              },
              done: function(result){console.log(result); console.log("done");},
              requestType: "POST",
              route: true
            } 
        ); 
      }      

      function addTodo() {
        // post
        var p = "add" + "/"  + $("ajax_input").value; 
        console.log(p);
        aj(
            {
              url: url,
              data: p,
              done: function(result){console.log(result); console.log("done");},
              requestType: "GET",              
              listeners: {
                500: function(result){console.log(result); console.log("500");},
                404: function(result){console.log(result); console.log("404");},
                404: function(result){console.log(result); console.log("404");},
                200: function(result){console.log(result); console.log("201");},
                303: function(result){console.log(result); console.log("303");},
                other: function(result){console.log(result); console.log("303");},
              },
              route: true
            } 
        );        
        return false;
      }      

      function editTodo() {
        // post
        var p = "edit" + "/"  + $("ajax_input").value + "/" + $("ajax_input_second").value; 
        aj(
            {
              url: url,
              data: p,
              listeners: {
                500: function(result){console.log(result); console.log("500");},
                404: function(result){console.log(result); console.log("404");},
                201: function(result){console.log(result); console.log("201");},
                200: function(result){console.log(result); console.log("200");},
                303: function(result){console.log(result); console.log("303");},
                other: function(result){console.log(result); console.log("other");}
              },
              requestType: "POST",
              route: true
            } 
        );        
        return false;
      }

      function getTodo() {
        // get
        var p = "get" + "/"  + $("ajax_input").value; 
        aj(
            {
              url: url,
              data: p,
              listeners: {
                500: function(result){console.log(result); console.log("500");},
                404: function(result){console.log(result); console.log("404");},
                201: function(result){console.log(result); console.log("201");},
                200: function(result){console.log(result); console.log("200");},
                303: function(result){console.log(result); console.log("303");},
                other: function(result){console.log(result); console.log("other");}
              },
              requestType: "GET"
            } 
        );        
        return false;
      }

      // getTodos
      function getTodoList() {
        // get
        var p = "getlist" + "/"  + $("ajax_input").value; 
        aj(
            {
              url: url,
              data: p,
              listeners: {
                500: function(result){console.log(result); console.log("500");},
                404: function(result){console.log(result); console.log("404");},
                201: function(result){console.log(result); console.log("201");},
                200: function(result){console.log(result); console.log("200");},
                303: function(result){console.log(result); console.log("303");},
                other: function(result){console.log(result); console.log("other");}
              },
              requestType: "GET",
              route: true
            } 
        );        
        return false;
      }

      function putTodo() {
        // POST
        aj(
            {
              url: url,
              data: p,
              listeners: {
                500: function(result){console.log(result); console.log("500");},
                404: function(result){console.log(result); console.log("404");},
                201: function(result){console.log(result); console.log("201");},
                200: function(result){console.log(result); console.log("200");},
                303: function(result){console.log(result); console.log("303");},
                other: function(result){console.log(result); console.log("other");}
              },
              requestType: "POST"
            } 
        ); 
      }

  </script>
  <form method="GET">
    <input name="ajax_input" placeholder="id" id="ajax_input"/>
    <input name="ajax_input_second" placeholder="description [optional]" id="ajax_input_second"/>
    <input type="button" onclick="deleteTodo();" id="delete_button" value="delete"/>
    <input type="button" onclick="addTodo();" id="add_button" value="add"/>
    <input type="button" onclick="editTodo();" id="get_button" value="edit"/>
    <input type="button" onclick="getTodoList();" id="getlist_button" value="get list"/>
    <input type="button" onclick="getTodo();" id="gettodo_button" value="get todo" disabled/>
  </form>
  <div id="ResponseDiv"></div>
  <div id="loading"></div>