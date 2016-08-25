<p>В области ввода текста письма можно использовать &laquo;переменные&raquo; - метки, они могут быть заменены на соответствующие подписчику значения:<br />
Эти переменные должны соответствовать формату <strong>[НАЗВАНИЕ]</strong>, где <i>НАЗВАНИЕ</i> будет заменено на имя одного из заданных администратором атрибутов.<br />
Для примера, если у Вас есть атрибут &laquo;ИмяФамилия&raquo;, включите в текст письма метку [ИмяФамилия] в квадратных скобках для обозначения места, где необходимо вставить соответствующий атрибут.</p>
<p>Вы также можете добавить какой-то текст на тот случай, если у подписчика данный атрибут не будет заполнен. Для этого используйте следующий синтаксис:<br/>
<strong>[НАЗВАНИЕ МЕТКИ%%Альтернативный текст]</strong><br/>
Для примера можно начать текст письма со следующих слов:<br/>
<i>Уважаемый [ИмяФамилия%%клиент]!</i><br/>
что приведёт к тому, что в тексте будет указано значение атрибута &laquo;ИмяФамилия&raquo;, если они заданы, и &laquo;клиент&raquo; для всех остальных.</p>

<p>На текущий момент у Вас определены следующие атрибуты:
<?php

print listPlaceHolders();

if (phplistPlugin::isEnabled('rssmanager')) {
    ?>

<p>Вы можете настроить шаблоны для писем, которые рассылаются с содержимым RSS-ленты. Для того, чтобы это сделать, нажмите на вкладку &laquo;Расписание&raquo; и укажите частоту отправки письма. Письмо будет использоваться для отправки содержимого ленты подписчикам выбранного списка рассылки с учётом установленной периодичности. Необходимо использовать метку [RSS] в своем письме для указания начала списка содержимого RSS-ленты.</p>

<?php 
}
?>

<p>Для того, чтобы отправить содержимое веб-страницы, добавьте следующую строку в тело Вашего письма:<br/>
<b>[URL:</b>http://www.example.org/путь/к/файлу.html<b>]</b></p>
<p>Также, в адрес веб-страницы можно включать основную информацию (но не атрибуты) подписчиков:</br>
<b>[URL:</b>http://www.example.org/userprofile.php?email=<b>[</b>email<b>]]</b></p>