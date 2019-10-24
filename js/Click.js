/**
 * Created by Wolverine on 20.10.2019.
 */

// обрабатывает клик по кнопке отправки формы и возвращает в iframe содержимое html-файла, URL которого записано в value INPUT'a
$(function () {
    $('#submit').on('click', function (event) {

        event.preventDefault();// using this page stop being refreshing
        let value = $('input').val();
        $.ajax({
            type: 'GET',
            url: 'getContent.php',
            data: {
                my_url: value
            },
            success: function (response)
            {
                console.log("content="+response);
                //let result = JSON.parse(response);
                let result = response;
                let my_frame_container = document.getElementById('my_frame').contentDocument;
                my_frame_container.open();
                my_frame_container.writeln(result);
                my_frame_container.close();
            },
            error: function(response) { // Данные не отправлены
                //alert("Ошибка. Данные не отправленны.");
            }
        });

    });
});

let frame = document.getElementById("my_frame");
frame.addEventListener("load", iframeClick, false);
function iframeClick() {
    //отключаем возможность клика по всем кнопкам установкой атрибута неактивности поля input
    $('#my_frame').contents().find('input').each(function () {
        $('#my_frame').contents().find('input').attr('disabled', 'disabled');
    });
    //отключаем переходы по гиперссылкам
    $('#my_frame').contents().find('a').click(function () {
        event.preventDefault();
        $(this).css("box-shadow", "3px 3px 33px 6px rgba(250,0,0,1)");
        sendSelector(event.target.id, event.target.className, event.target.tagName);
    });
    document.getElementById("my_frame").contentWindow.document.body.onclick = function()
    {
        let msg;
        if(event.target.id!="")
            msg = $('#my_frame').contents().find('#'+event.target.id);
        if(event.target.className)
            msg = $('#my_frame').contents().find('.'+event.target.className);
        msg.css("box-shadow", "3px 3px 33px 6px rgba(250,0,0,1)");
       /* msg.css('border-width', '0');
        msg.css("border", "3px solid red");*/
       // msg.html(data); //table_result
           sendSelector(event.target.id, event.target.className, event.target.tagName);
    }
}

function sendSelector(params_id, params_class, tags)
{
    let value = $('input').val();
    $.ajax({
        method: "GET",
        url: "save_to_file.php",
        data: {
            my_url: value,
            tag: tags,                      //значение тега
            selectors_id: params_id,        //значение селектора id
            selectors_class: params_class   //значение селектора class
        },
        //response:'text',//тип возвращаемого ответа text либо xml
        success: function (data) {  //возвращаемый результат от сервера
            //$('#table_result').html(data);
        },
        error: function (data) {
            $('#result').html(data);
        }
    });
}
