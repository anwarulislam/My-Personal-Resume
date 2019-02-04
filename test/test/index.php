<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Editor</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style type="text/css" media="screen">
        #editor {
            margin: 0;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
</head>

<body>


    <div class="container" style="text-align: center;">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel_form panel panel-default">
                <div style="margin: 20px;" class="panel-content">


                    <form id="formSubmit" method="post">

                        <div class="form-group">
                            <label for="email">Code:</label>

                            <pre id="editor" class="mainCode" style="height: 224px;">#include&lt;iostream&gt;
using namespace std;

int main()
{
	int age;
	
	cout &lt;&lt; "Enter your age:";
	cin &gt;&gt; age;
	cout &lt;&lt; "\nYour age is: "&lt;&lt;age;
	
	return 0;
}</pre>

                        </div>

                        <div class="form-group">
                            <label for="inputValue">Input:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="inputValue" id="inputValue">
                                <div class="input-group-append">
                                    <select name="language" id="language">
										<option value="cpp" selected>C++</option>
										<option value="py2">Python 2</option>
										<option value="py3">Python 3</option>
									</select>
                                </div>
                            </div>
                        </div>



                        <button type="button" class="btn btn-primary btn-lg getResult" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing">Get Result</button>
                </div>

                </form>


            </div>






            <div class="panel_form panel panel-default">
                <pre id="result" style="margin: 20px;display:none" class="panel-content">
				
				</pre>
            </div>
        </div>
    </div>





    <script>
        $("#formSubmit").submit(function(e){
            e.preventDefault();
        	$( ".getResult" ).trigger( "click" );
          });
        
        $('.getResult').on('click', function() {
        	
        	$('.getResult').button('loading');
        	
        	//passing these data to process.php
        	
        	var mainCode = editor.getValue();
        	var inputValue = $("#inputValue").val();
        	var language = $("#language").val();
        	var hashCode = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        	
        	$.post("process.php", {
        		mainCode: mainCode,
        		inputValue: inputValue,
        		language: language,
        		hashCode: hashCode
        		
        	}).done(function(data){
        		
        		//var dataArray = JSON.parse(data);
        		console.log(data);
        		
        		//var status = dataArray['status'];
        		
        		if(status == 200){
        			
        			//function checking(hash) {
        			//	$.post("getR.php", {
        			//		hashCode: hash
        			//	}).done(function(results){
        			//		var result = JSON.parse(results);
        			//		
					//		console.log(result);
					//		//return result;
        			//})
        			//return 0;
        			//}console.log(checking());

                    function postagain(hash) {
                        var result = [];
                        $.post("getR.php", {
								hashCode: hash
							}).done(function(results){
								result = JSON.parse(results);
                                // result.push(results);
                                console.log(result);
                                if ( result['state'] == 'success' ) {
                                    $("#result").show();
                                    $("#result").html(result['output']);
                                    $('.getResult').button('reset');
                                } else if (result['state'] == 'pending' ) {
                                    postagain(hashCode);
                                }
						})
                        // return result;
                    }

                    var result = postagain(hashCode);
                    
        					
        			
        		}else{
        			alert('error');
        		}
        		
        	})
        	
            
        });
    </script>












    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/chaos");
        editor.session.setMode("ace/mode/c_cpp");
    	editor.getSession().setUseSoftTabs(true);
    	editor.setOptions({
    	  fontSize: "14px"
    	});
    </script>

</body>

</html>