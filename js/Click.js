/**
 * Created by Wolverine on 20.10.2019.
 */
let qwe="";
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
        $(this).attr('disabled', 'disabled'); //$('#my_frame').contents().find('input')
        $(this).addClass("disabled");

    });
    //отключаем переходы по гиперссылкам
    $('#my_frame').contents().find('a').click(function () {
        event.preventDefault();
        $(this).css('border-width', '0');
        $(this).css("border", "3px solid red");
        //$(this).css("box-shadow", "3px 3px 33px 6px rgba(250,0,0,1)");
        sendSelector(event.target.id, event.target.className, event.target.tagName);
    });

  /*  $('input').click(function (event) {
        if ($(this).hasClass('disabled')) {
            alert('CLICKED, BUT DISABLED!!');
        } else {
            alert('Not disabled. =)');
        }
    });*/

    document.getElementById("my_frame").contentWindow.document.body.onclick = function()
    {
        /*let qwe = $('#my_frame').contents().find('input[disabled="disabled"]');
        if (qwe.hasClass('disabled')) {
            alert('CLICKED, BUT DISABLED!!');
        }*/
        let msg;
        if(event.target.id!=="")
            msg = $('#my_frame').contents().find('#'+event.target.id);
        else
        {
            msg = $('#my_frame').contents().find(event.target);
            msg.attr("id", "my_frame_click"); //принудительная установка id на кликнутом элементе
        }
        if(event.target.className!=="")
        {
            msg = $('#my_frame').contents().find('.' + event.target.className);
            msg.attr("class", "my_frame_click"); //принудительная установка id на кликнутом элементе
        }
        //msg.css("box-shadow", "3px 3px 33px 6px rgba(250,0,0,1)");
        msg.css('border-width', '0');
        msg.css("border", "3px solid red");
       // msg.html(data); //table_result
            sendSelector(event.target.id, event.target.className, event.target.tagName);
    }
}

function sendSelector(params_id, params_class, tags)
{
    //let value = $('input').val();
    let html = document.getElementById("my_frame").contentWindow.document.body.parentNode.innerHTML;
    console.log(html);
    let value = JSON.stringify("<!DOCTYPE html><html>"+html+"</html>");
    console.log(value);
    $.ajax({
        method: "POST",
        url: "save_to_file.php",
        data: {
            my_url: value,
            tag: tags,                      //значение тега
            selectors_id: params_id,        //значение селектора id
            selectors_class: params_class   //значение селектора class
        },
        //response:'text',//тип возвращаемого ответа text либо xml
        success: function (data) {  //возвращаемый результат от сервера
            let result = $.parseJSON(data);
            console.log(result);
            for (let i = 0; i < result.length; i++)
            {
                qwe = qwe + result[i];
            }
            qwe = "Title > " + qwe;
            $('#title').val(qwe);
        },
        error: function (data) {
            $('#title').val(data);
        }
    });
}

let export_css = document.getElementById("export");
export_css.addEventListener("click", exportButtonClick, false);
function exportButtonClick()
{
    let title = $('#title').val();
    let subtitle = $('#subtitle').val();
    let intro_text = $('#intro_text').val();
    let date = $('#date').val();
    let author = $('#author').val();
    let content = $('#content').val();
    if((title.length>0)&&(subtitle.length>0)&&(intro_text.length>0)&&(date.length>0)&&(author.length>0)&&(content.length>0))
    {
        $.ajax({
            method: "POST",
            url: "export_to_file.php",
            data: {
                title: title,           //значение поля Title
                subtitle: subtitle,     //значение поля SubTitle
                intro_text: intro_text, //значение поля Intro Text
                date: date,             //значение поля Date
                author: author,         //значение поля Author
                content: content        //значение поля Content
            },
            //response:'text',//тип возвращаемого ответа text либо xml
            success: function (data) {  //возвращаемый результат от сервера
               /* let result = $.parseJSON(data);
                console.log(result);
                $('#title').val(data);*/
                alert("Данные сохранеы в файл export.json");
            },
            error: function (data) {
                //$('#title').val(data);
                alert("Произошла ошибка на сервере. Данные вероятно не сохранены!");
            }
        });
    }
    else
        alert("Заполнены не все поля! Пожалуйста, заполните их!");
}