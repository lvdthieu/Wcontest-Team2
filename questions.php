<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha384-/LjQZzcpTzaYn7qWqRIWYC5l8FWEZ2bIHIz0D73Uzba4pShEcdLdZyZkI4Kv676E" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/questions.css">
</head>
<body>
    <div id="startDiv">
        <div id="headerDiv">Welcome to the Exam</div> 
        <div id="bodyDiv" class=" position-relative">
            <button type="button" name="button" class="btn btn-lg btn-success customBtn" id="btnStart"> Start</button>
        </div>
    </div>
                
               
    <div id="questions" class="container" ></div>          
    <button type="button" name="button" class="btn btn-warning btn-lg position-relative bottom-0 start-50 translate-middle-x" id="btnFinish" style="margin-top: 5%">Nộp bài</button>
 <div class="row showGrade" style="margin-top: 5%">
                    <div class="col-sm-12 text-center">
                        <h4 id="mark" class ="text-info"></h4>
                    </div>
                </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('#btnFinish').hide();
        $('#questions').hide();
    });
    $('#btnStart').click(function() {
        GetQuestions();
        $('#questions').show();
        $('#btnFinish').show();
        $('#startDiv').hide();

    });
    var questions;
    let index = 1;
    function sum(a, b){
        return a + b;
    }
    $('#btnFinish').click(function(){
        $(this).hide();
        //$('#btnStart').show();
        CheckResult();
    })

    function CheckResult(){
        let mark = 0;
        $('#questions div.qtest ').each(function(k,v) {
            
        // Bước 1: lấy đáp án đúng của câu hỏi
        let id = $(v).find('h5').attr('id');
    
        let question = questions.find(x=>x.id == id);
        let answer = question['ranswer'];
        //Bước 2: lấy từ người dùng
        let da = $(v).find('fieldset input[type = "radio"]:checked').attr('class');
        //da: đáp án của người dùng
        let choice = '';
        switch (da) {
            case 'rdOptionA':
                choice = "answer1";
                break;
            case 'rdOptionB':
                choice = "answer2";
                break;
            case 'rdOptionC':
                choice = "answer3";
                break;
            case 'rdOptionD':
                choice = "answer4";
                break;
            }
            if (choice == answer) {
                mark++;
                $("input").prop("disabled", true);

            } else {
            }
             // Bước 3: đánh dấu câu hỏi nào đúng, câu nào sai
        $('#question_'+id+' >.answer>fieldset>div>label.'+answer).append('<span class="glyphicon glyphicon-ok"></span>');
        });
        console.log('Điểm của bạn là: ' + mark + '/' + sum(index,-1));
        $('#mark').text('Điểm của bạn là: ' + mark + '/' + sum(index,-1));    
    };
    $('#btnStart').click(function() {
        GetQuestions();
    });

    function GetQuestions() {
        $.ajax({
            url: 'renderQ.php',
            type: 'get',
            success: function(data) {
                questions = jQuery.parseJSON(data);
                index = 1;
                let d  = '';
                $.each(questions,function(k,v) {  
            d +=        '<div id="aQuestion" class="container">'
            
            d +=        '<div class = "qtest" id = "question_' + v['id']+'"> ';
            d +=        '<div class="question">'
            d +=        '<h5 id ='+v['id']+'> <span class = "text-danger">Câu ' + index +': </span>' + v['quest'] +'</h5>';
                    if (v['filepath'] != null) {
                    d += '<img src = assets/image/' + v['filepath'] + '>';
                    }
            d +=        '</div>';            
            

            d +=        '<div class="answer">'
                    
            d +=        '<fieldset id = "group'+index+'">';
            d +=        '<div class="radio choice">';
            d +=        '    <label  class = "answer1"><input type="radio" class="rdOptionA" name = "group'+index+'"><span class = "text-warning">A: </span> '+v['answer1']+' </label>';
            d +=        '</div>';
            d +=        '<div class="radio choice">';
            d +=        '    <label class = "answer2"><input type="radio" class="rdOptionB" name = "group'+index+'"><span class = "text-warning">B: </span> '+v['answer2']+'</label>';
            d +=        '</div>';
            d +=        '<div class="radio choice">';
            d +=        '    <label class = "answer3"><input type="radio" class="rdOptionC" name = "group'+index+'"><span class = "text-warning">C: </span> '+v['answer3']+'</label>';
            d +=        '</div>';
            d +=        '<div class="radio choice">';
            d +=        '    <label class = "answer4"><input type="radio" class="rdOptionD" name = "group'+index+'"><span class = "text-warning">D: </span> '+v['answer4']+'</label>';
            d +=        '</div>';
            d +=         '</fieldset>';
            d +=        '</div>';
            d +=        '</div>';
            d +=        '</div>';
            index++;

                });

            $('#questions').html(d);
            }
        });
    }
</script>
</html>

