<!DOCTYPE html>
    <meta charset="utf-8" /> 

    <script src="../examples/resources/scripts/ajax/aj.js"></script>
    <script src="../examples/resources/scripts/ajax/Params.js"></script>
    <script src="../examples/resources/scripts/ajax/ParamsBuilder.js"></script>
   
    <?php 
        //include '../example/resources/scripts/ajax/aj/aj.js'; 
        //include '../example/resources/scripts/ajax/parameter/easyParameterAdapter.js'; 
    ?>

    <!--
    // I moved it from /web/ to /example/ but the .htaccess when running from console has to be changed so I will do that later
    // var url = "http://localhost:8080/web/todo";
    // var url = "http://localhost:8080/todo";
    -->

    <script>
      var 
        url = "http://localhost:8080/todo",
        pb = new ParamsBuilder();

      function $(s) { return document.getElementById(s) }

      function exampleAjaxListeners() {
            return {
                500: function(result){console.log(result); console.log("500");},
                404: function(result){console.log(result); console.log("404");},
                201: function(result){console.log(result); console.log("201");},
                200: function(result){console.log(result); console.log("200");},
                303: function(result){console.log(result); console.log("303");},
                other: function(result){console.log(result); console.log("other");},
                done: function(result){console.log(result); console.log("done");}
            };
      }

      function deleteTodo() {
        // get
        var p = "delete" + pb.input($("ajax_input")).route(); 
        aj({
              url: url,
              data: p,
              listeners:exampleAjaxListeners(),
              requestType: "POST",
              route: true
        }); 
      }      

      function addTodo() {
        // post
        var p = "add" + pb.input($("ajax_input")).route(); 

        console.log(p);
        aj({
              url: url,
              data: p,
              done: function(result){console.log(result); console.log("done");},
              requestType: "GET",              
              listeners: exampleAjaxListeners(),
              route: true
        });        
        return false;
      }      

      function editTodo() {
        // post
        var p = "edit" + pb.inputs([$("ajax_input"), $("ajax_input_second")]).route(); 

        aj({
              url: url,
              data: p,
              listeners: exampleAjaxListeners(),
              requestType: "POST",
              route: true
        });        
        return false;
      }

      function getTodo() {
        // get
        var p = "get" + pb.input($("ajax_input")).route(); 
        aj({
              url: url,
              data: p,
              listeners:exampleAjaxListeners(),
              requestType: "GET"
        });        
        return false;
      }

      // getTodos
      function getTodoList() {
        // get
        var p = "getlist" + pb.input($("ajax_input")).route(); 
        aj({
              url: url,
              data: p,
              listeners:exampleAjaxListeners(),
              requestType: "GET",
              route: true
        });        
        return false;
      }

      function postTodo() {
        // POST
        aj({
            url: url,
            data: p,
            listeners:exampleAjaxListeners(),
            requestType: "POST",
            contentType: "application/json"
        }); 
      }
      function putTodo() {
        // POST
        aj({
            url: url,
            data: p,
            listeners:exampleAjaxListeners(),
            requestType: "POST"
        }); 
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