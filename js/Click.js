/**
 * Created by Wolverine on 20.10.2019.
 */

// обрабатывает клик по кнопке отправки формы и возвращает в iframe содержимое html-файла, URL которого записано в value INPUT'a
$(function () {
    $('form').on('click', function (event) {

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
                let result = JSON.parse(response);
                let my_frame_container = document.getElementById('my_frame').contentDocument;
                my_frame_container.open();
                my_frame_container.writeln(result);
                my_frame_container.close();
            }
        });

    });
});

let frame = document.getElementById("my_frame");
frame.addEventListener("load", iframeClick, false);
function iframeClick() {
    document.getElementById("my_frame").contentWindow.document.body.onclick = function()
    {
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